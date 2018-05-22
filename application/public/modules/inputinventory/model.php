<?php
/**
 * @author 
 * @copyright 2015
 */
 class InputinventoryModel extends CI_Model{
	function __construct(){
		parent::__construct('');
		$this->login = $this->site->getSession('login');
		$this->ctr = 1;
	}
	function getOderList(){
		$tb = $this->base_model->loadTable();
		$sql = "
			select co.poid,co.id
			from `".$tb['hotel_input_createorders_order']."` co
			left join `".$tb['hotel_input_order']."` so on so.uniqueid = co.uniqueid
			where co.isdelete = 0
			and so.isdelete = 0
			and co.poid not in (
				select  occ.soid
				from `".$tb['hotel_input']."` ss
				left join `".$tb['hotel_input_createorders']."` occ on occ.uniqueid = ss.uniqueid
				where ss.goodsid = so.goodsid
				and occ.soid = co.poid
				and ss.isdelete = 0
				and occ.isdelete = 0
			) 
			group by co.poid
		"; //echo '<pre>'; echo $sql; exit;
		return $this->model->query($sql)->execute();
	}
	function getSalesOder(){
		$tb = $this->base_model->loadTable();
		$sql = "
			select *
				from(
				SELECT od.goodsid, od.poid, od.quantity, 
				( 
					select outs.quantity 
					from `".$tb['hotel_input']."` outs 
					where outs.isdelete = 0 
					and outs.socode = od.poid 
					and outs.goodsid = od.goodsid
				) as quantityout
				 FROM `".$tb['hotel_input_createorders_order']."` coo 
				 LEFT JOIN `".$tb['hotel_input_order']."` od on coo.uniqueid = od.uniqueid
				 where coo.isdelete = 0
				 and od.isdelete = 0
				 group by od.goodsid, coo.poid 
				 having ( quantityout is null or quantity > quantityout)
				 ) t
				 group by t.poid
		";
		$query = $this->model->query($sql)->execute();
		return $query;
	}
	function deleteTempDataNew($isnew){
		$tb = $this->base_model->loadTable();
		$userid =  $this->login->id;
		$this->model->table($tb['hotel_add_temp'])
					->where('contronller',$this->ctr)
					->where('userid',$userid)
					->where('isnew',$isnew)
					->delete();	
	}
	function saves($uniqueid,$itemList,$array,$isnew){
		$this->db->trans_start();
		$tb = $this->base_model->loadTable();
		$timeNow  = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
		$companyid = $this->login->companyid;
		$branchid = $this->login->branchid;
		$userid = $this->login->id;
		$soidsave = '';
		if(!empty($array['soid'])){
			$soidsave = $array['soid'];
		}
		$listID = json_decode($itemList);
		$stringID = '';
		foreach($listID as $key=>$val){
			$stringID.= ','.$key;
		}
		$stringID = substr($stringID,1);
		$tbTemp = $tb['hotel_add_temp'];
		$tbGoods = $tb['hotel_goods'];
		//$unitNode = $tbGoods.'.unitid as unitidNode';
		$sql = "
			SELECT st.*, g.isnegative, g.unitid AS unitidNode
			FROM `$tbTemp` st
			LEFT JOIN `$tbGoods` g ON g.id = goodid
			WHERE st.id IN ($stringID)
		";
		$queryTemp = $this->model->query($sql)->execute();
		//Danh sach đơn vị
		$goodidlist = 0;
		foreach($queryTemp as $item){
			 $goodidlist.= ','.$item->goodid;
		}
		$arrGoods = $this->model->table($tbGoods)
						 ->select('id,unitid')
						 ->where("id in ($goodidlist)")
						 ->find_combo('id','unitid');
		$sqlTemp = "";
		foreach($queryTemp as $item){
			$checkInventory = $this->model->table($tb['hotel_inventory'])
								   ->select('id')
								   ->where('branchid',$branchid)
								   ->where('goodsid',$item->goodid)
								   ->where('warehouseid',$array['warehouseid'])
								   ->where('isdelete',0)
								   ->find();
			if(empty($checkInventory->id)){
				//Them vao kho
				$arrAddInventorey = array();
				$arrAddInventorey['branchid'] = $branchid; 
				$arrAddInventorey['warehouseid'] = $array['warehouseid'];
				$arrAddInventorey['goodsid'] = $item->goodid;
				$arrAddInventorey['quantity'] = 0;
				$arrAddInventorey['unitid'] = 0;
				if(isset($arrGoods[$item->goodid])){
					$arrAddInventorey['unitid'] = $arrGoods[$item->goodid];
				}
				$arrAddInventorey['shelflife'] = '0000-00-00';
				$this->model->table($tb['hotel_inventory'])->insert($arrAddInventorey);
			}
		}
		#region Công hang hoa trong kho
		$t_tien = 0;
		foreach($queryTemp as $item){
			$goodid = $item->goodid;
			$warehouseid = $item->warehouseid;
			$quantity = $item->quantity;
			//Nếu đơn vị nhập vào khác với đơn vị ghốc thì quy đổi ra đơn vị gốc
			if($item->unitidNode != $item->unitid){
				//Tinh quy doi
				$findUnit = $this->model->table($tb['hotel_goods_conversion'])
										->select('conversion')
										->where('goodsid',$goodid)
										->where('unitid',$item->unitid)
										->find();
				if(!empty($findUnit->conversion)){
					//$quantity = ($findUnit->conversion) *  (($item->quantity) - ($item->xkm));
					$quantity = ($findUnit->conversion) *  ($item->quantity);
				}
			}
			//End Tinh doi don vi
			$xkm = $item->xkm;
			$sqlUpdate = "
				UPDATE `".$tb['hotel_inventory']."` 
				SET `quantity`= `quantity` + ".($quantity)." 
				WHERE `goodsid`='".$goodid."'
				AND `branchid` = '".$branchid."'
				AND `warehouseid` = '".$array['warehouseid']."'
				;
			";
			$this->model->executeQuery($sqlUpdate);
			$t_tien+= $item->price_total;
		}
		#end
		#region Tao po
		$setuppo = $this->login->setuppo;
		$arrAuto = $this->createPoOrder($branchid,$array['datecreate']);
		$poid = $arrAuto['poid'];
		#end
		$insert = array();

		#region insert ban tổng
		$timeNow = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
		$insert['branchid'] = $branchid;
		$insert['description'] = $array['description'];
		$insert['supplierid'] = $array['supplierid'];
		$insert['datecreate'] = $timeNow;
		$insert['usercreate'] =  $this->login->username;
		$insert['payments'] = $array['payments'];
		$insert['vat'] = fmNumberSave($array['vat']);
		$insert['vat_value'] = fmNumberSave($array['vat_value']);
		$insert['uniqueid'] = $uniqueid;
		$insert['poid'] = $poid;
		$insert['ponumber'] = $array['ponumberid'];
		//Tong tien hang
		$insert['price'] = fmNumberSave($array['total_amount']); 
		//Tong thanh toan
		$total_tongcong = fmNumberSave($array['total_tongcong']);
		$insert['price_total'] = $total_tongcong;
		//Tam ung 
		$price_prepay = fmNumberSave($array['total_tamung']); 
		$insert['price_prepay'] = fmNumberSave($array['price_prepay']);
		$insert['price_prepay_value'] =  $price_prepay;
		$insert['price_prepay_type'] =  $array['price_prepay_type'];
		//Giam gia 
		$insert['discount'] =  fmNumberSave($array['discount']);
		$insert['discount_value'] =  fmNumberSave($array['total_discount']);
		$insert['discount_type'] =  $array['discount_type'];
		//Số lượng quantity
		$insert['quantity'] = fmNumberSave($array['tong_so_luong']);  
		//Dieu chinh gia 
		$insert['adjustment'] =  fmNumberSave($array['total_adjustment']);
		//Cong no
		$payments_status = 0;
		if($price_prepay < $total_tongcong){ //Chưa thanh toán hết
			$payments_status = -1;
		}
		$insert['payments_status'] = $payments_status;
		
		$insert['stt'] = $arrAuto['stt'];
		$insert['datepo'] = fmDateSave($array['datecreate']);
		$insert['currency'] = configs()['currency'];
		
		$insert['signature'] = $this->login->signature;
		$insert['signature_name'] = $this->login->fullname;
		$insert['warehouseid'] = $array['warehouseid'];
		$this->model->table($tb['hotel_input_createorders'])->insert($insert);	
		#end
		$orderid = $this->model->table($tb['hotel_input_createorders'])	
							   ->select('id')
							   ->where('uniqueid',$uniqueid)
							   ->find()->id;
		#region them bang detail
		$i=1;
		foreach($queryTemp as $item){
			$insertInput = array();
			$insertInput['warehouseid'] = $array['warehouseid'];
			$insertInput['branchid'] = $branchid;
			$insertInput['supplierid'] = $array['supplierid'];
			$insertInput['datecreate'] = $timeNow;
			$insertInput['usercreate'] = $this->login->fullname;
			$insertInput['poid'] = $poid;
			$insertInput['orderid'] = $orderid;
			$insertInput['quantity'] = $item->quantity;
			$insertInput['goodsid'] = $item->goodid;
			$insertInput['priceone'] = $item->price;
			$insertInput['price'] = $item->price_total;
			$insertInput['vat'] = $item->vat;
			$insertInput['guarantee'] =  $item->guarantee;
			$insertInput['sttview'] = $i;
			$insertInput['unitid'] = $item->unitid;
			$insertInput['discount'] = $item->discount;
			$insertInput['discount_value'] = $item->discount_value;
			$insertInput['discount_type'] = $item->discount_type;
			$insertInput['cksp'] = $item->xkm;
			$dateShelflife = '0000-00-00';
			$insertInput['shelflife'] = $dateShelflife;
			$this->model->table($tb['hotel_input'])->insert($insertInput);
			$i++;
		}
		#end
		#region dua vao cong no
		if($payments_status == -1){//Nếu chưa thanh toán hết thì đưa vào công nợ
			$conNoConLai = $total_tongcong - $price_prepay;
			$insCongno = array();
			$insCongno['branchid'] = $branchid;
			$insCongno['orderid'] = $orderid;
			$insCongno['liabilities'] = 2;// mua hang
			$insCongno['price'] = $total_tongcong;// ban hang
			$insCongno['amount_debt'] = $conNoConLai;// ban hang 
			$insCongno['description'] = '';
			$insCongno['pnk'] = $poid;
			$insCongno['supplierid'] = $array['supplierid'];
			$insCongno['usercreate'] = $this->login->username;
			$insCongno['datecreate'] = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
			if(!empty($conNoConLai)){
				$this->model->table($tb['hotel_liabilities_buy'])->insert($insCongno);	
			}
		}
		#end
		#region tư thanh toan du vao chi
		//if(ispay() == 1){ //Tự động thanh toan
			$pay_code = $this->createPOPay($branchid,$array['datecreate']);		
			$arrIS =  array();
			$arrIS['orderid'] = $orderid;
			$arrIS['branchid'] = $branchid;
			$arrIS['pay_type'] = 2; //chi theo phiếu nhập kho = 2
			$arrIS['payment'] =  $array['payments'];
			$arrIS['poid'] = $poid;
			$arrIS['usercreate'] = $this->login->username;
			$arrIS['datecreate'] = $timeNow;
			$arrIS['pay_code'] = $pay_code;
			$arrIS['supplierid'] = $array['supplierid'];
			$arrIS['datepo'] = fmDateSave($array['datecreate']);
			if(!empty($insert['price_prepay_value'])){
				$arrIS['amount'] = fmNumberSave($insert['price_prepay_value']);
				$this->model->table($tb['hotel_pay'])->insert($arrIS);
			}
		//}
		#end
		#region ghi log
		$description = getLanguage('them-moi').': '.$poid;
		$this->base_model->addAcction(getLanguage('nhap-kho'),$this->uri->segment(2),'','',$description );	
		#end
		#region Xoa du lieu bang tam
		$userid =  $this->login->id;
		$this->model->table($tb['hotel_add_temp'])
					->where('contronller',$this->ctr)
					->where("id in ($stringID)")
					->delete();	
		#end
		$this->db->trans_complete();
		$arr = array();
		$arr['uniqueid'] = $uniqueid;
		//$arr['uniqueidnew'] = 
		$arr['poid'] = $poid;
		$arr['msg'] = '';
		return $arr;
	}
	function edits($uniqueid,$itemList,$array,$isnew){
		$this->db->trans_start();
		$tb = $this->base_model->loadTable();
		$timeNow  = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
		$companyid = $this->login->companyid;
		$branchid = $this->login->branchid;
		$userid = $this->login->id;
		$soidsave = '';
		if(!empty($array['soid'])){
			$soidsave = $array['soid'];
		}
		$listID = json_decode($itemList);
		$stringID = '';
		foreach($listID as $key=>$val){
			$stringID.= ','.$key;
		}
		$stringID = substr($stringID,1);
		$tbTemp = $tb['hotel_add_temp'];
		$tbGoods = $tb['hotel_goods'];
		
		
		//$unitNode = $tbGoods.'.unitid as unitidNode';
		$sql = "
			SELECT st.*, g.isnegative, g.unitid AS unitidNode
			FROM `$tbTemp` st
			LEFT JOIN `$tbGoods` g ON g.id = goodid
			WHERE st.id IN ($stringID)
		";
		$queryTemp = $this->model->query($sql)->execute();
		//Danh sach đơn vị
		$goodidlist = 0;  
		$detailidlist = 0;
		foreach($queryTemp as $item){
			 $goodidlist.= ','.$item->goodid;
			 $detailidlist.= ','.$item->detailid;
		}
		#region Trừ số lượng khỏi kho
		$detialList = $this->model->table($tb['hotel_input'])
								   ->select('id,goodsid,warehouseid,quantity')
								   ->where(" orderid in ($detailidlist)")
								   ->find();
		foreach($detialList as $detail){
			$quantitys = $item->quantity;
			$goodsid = $item->goodsid;
			$warehouseid = $item->warehouseid;
			$sql = "UPDATE `".$tb['hotel_inventory']."` SET `quantity`= `quantity` - '$quantitys' 
					WHERE `goodsid`='$goodsid' 
					AND `warehouseid` = '$warehouseid';";
		$this->model->executeQuery($sql);
			$this->model->executeQuery($sql);
		}
		//Xóa dữ liệu chi tiết
		$updateDetail = array();
		$updateDetail['userupdate'] = $this->login->username;
		$updateDetail['dateupdate'] = $timeNow;
		$updateDetail['isdelete'] = 1;
		$this->model->table($tb['hotel_input'])
					->where(" orderid in ($detailidlist)")
					->update($updateDetail);
		#end
		$arrGoods = $this->model->table($tbGoods)
						 ->select('id,unitid')
						 ->where("id in ($goodidlist)")
						 ->find_combo('id','unitid');
		$sqlTemp = "";
		foreach($queryTemp as $item){
			$checkInventory = $this->model->table($tb['hotel_inventory'])
								   ->select('id')
								   ->where('branchid',$branchid)
								   ->where('goodsid',$item->goodid)
								   ->where('warehouseid',$array['warehouseid'])
								   ->where('isdelete',0)
								   ->find();
			if(empty($checkInventory->id)){
				//Them vao kho
				$arrAddInventorey = array();
				$arrAddInventorey['branchid'] = $branchid; 
				$arrAddInventorey['warehouseid'] = $array['warehouseid'];
				$arrAddInventorey['goodsid'] = $item->goodid;
				$arrAddInventorey['quantity'] = 0;
				$arrAddInventorey['unitid'] = 0;
				if(isset($arrGoods[$item->goodid])){
					$arrAddInventorey['unitid'] = $arrGoods[$item->goodid];
				}
				$arrAddInventorey['shelflife'] = '0000-00-00';
				$this->model->table($tb['hotel_inventory'])->insert($arrAddInventorey);
			}
		}
		#region Công hang hoa trong kho
		$t_tien = 0;
		foreach($queryTemp as $item){
			$goodid = $item->goodid;
			$warehouseid = $item->warehouseid;
			$quantity = $item->quantity;
			//Nếu đơn vị nhập vào khác với đơn vị ghốc thì quy đổi ra đơn vị gốc
			if($item->unitidNode != $item->unitid){
				//Tinh quy doi
				$findUnit = $this->model->table($tb['hotel_goods_conversion'])
										->select('conversion')
										->where('goodsid',$goodid)
										->where('unitid',$item->unitid)
										->find();
				if(!empty($findUnit->conversion)){
					//$quantity = ($findUnit->conversion) *  (($item->quantity) - ($item->xkm));
					$quantity = ($findUnit->conversion) *  ($item->quantity);
				}
			}
			//End Tinh doi don vi
			$xkm = $item->xkm;
			$sqlUpdate = "
				UPDATE `".$tb['hotel_inventory']."` 
				SET `quantity`= `quantity` + ".($quantity)." 
				WHERE `goodsid`='".$goodid."'
				AND `branchid` = '".$branchid."'
				AND `warehouseid` = '".$array['warehouseid']."'
				;
			";
			$this->model->executeQuery($sqlUpdate);
			$t_tien+= $item->price_total;
		}
		#end
		#region Tao po
		$setuppo = $this->login->setuppo;
		$arrAuto = $this->createPoOrder($branchid,$array['datecreate']);
		$poid = $arrAuto['poid'];
		#end
		$insert = array();

		#region insert ban tổng
		$timeNow = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
		$insert['branchid'] = $branchid;
		$insert['description'] = $array['description'];
		$insert['supplierid'] = $array['supplierid'];
		$insert['datecreate'] = $timeNow;
		$insert['usercreate'] =  $this->login->username;
		$insert['payments'] = $array['payments'];
		$insert['vat'] = fmNumberSave($array['vat']);
		$insert['vat_value'] = fmNumberSave($array['vat_value']);
		$insert['uniqueid'] = $uniqueid;
		$insert['poid'] = $poid;
		$insert['ponumber'] = $array['ponumberid'];
		//Tong tien hang
		$insert['price'] = fmNumberSave($array['total_amount']); 
		//Tong thanh toan
		$total_tongcong = fmNumberSave($array['total_tongcong']);
		$insert['price_total'] = $total_tongcong;
		//Tam ung 
		$price_prepay = fmNumberSave($array['total_tamung']); 
		$insert['price_prepay'] = fmNumberSave($array['price_prepay']);
		$insert['price_prepay_value'] =  $price_prepay;
		$insert['price_prepay_type'] =  $array['price_prepay_type'];
		//Giam gia 
		$insert['discount'] =  fmNumberSave($array['discount']);
		$insert['discount_value'] =  fmNumberSave($array['total_discount']);
		$insert['discount_type'] =  $array['discount_type'];
		//Số lượng quantity
		$insert['quantity'] = fmNumberSave($array['tong_so_luong']);  
		//Dieu chinh gia 
		$insert['adjustment'] =  fmNumberSave($array['total_adjustment']);
		//Cong no
		$payments_status = 0;
		if($price_prepay < $total_tongcong){ //Chưa thanh toán hết
			$payments_status = -1;
		}
		$insert['payments_status'] = $payments_status;
		
		$insert['stt'] = $arrAuto['stt'];
		$insert['datepo'] = fmDateSave($array['datecreate']);
		$insert['currency'] = configs()['currency'];
		
		$insert['signature'] = $this->login->signature;
		$insert['signature_name'] = $this->login->fullname;
		$insert['warehouseid'] = $array['warehouseid'];
		$this->model->table($tb['hotel_input_createorders'])->insert($insert);	
		#end
		$orderid = $this->model->table($tb['hotel_input_createorders'])	
							   ->select('id')
							   ->where('uniqueid',$uniqueid)
							   ->find()->id;
		#region them bang detail
		$i=1;
		foreach($queryTemp as $item){
			$insertInput = array();
			$insertInput['warehouseid'] = $array['warehouseid'];
			$insertInput['branchid'] = $branchid;
			$insertInput['supplierid'] = $array['supplierid'];
			$insertInput['datecreate'] = $timeNow;
			$insertInput['usercreate'] = $this->login->fullname;
			$insertInput['poid'] = $poid;
			$insertInput['orderid'] = $orderid;
			$insertInput['quantity'] = $item->quantity;
			$insertInput['goodsid'] = $item->goodid;
			$insertInput['priceone'] = $item->price;
			$insertInput['price'] = $item->price_total;
			$insertInput['vat'] = $item->vat;
			$insertInput['guarantee'] =  $item->guarantee;
			$insertInput['sttview'] = $i;
			$insertInput['unitid'] = $item->unitid;
			$insertInput['discount'] = $item->discount;
			$insertInput['discount_value'] = $item->discount_value;
			$insertInput['discount_type'] = $item->discount_type;
			$insertInput['cksp'] = $item->xkm;
			$dateShelflife = '0000-00-00';
			$insertInput['shelflife'] = $dateShelflife;
			$this->model->table($tb['hotel_input'])->insert($insertInput);
			$i++;
		}
		#end
		#region dua vao cong no
		if($payments_status == -1){//Nếu chưa thanh toán hết thì đưa vào công nợ
			$conNoConLai = $total_tongcong - $price_prepay;
			$insCongno = array();
			$insCongno['branchid'] = $branchid;
			$insCongno['orderid'] = $orderid;
			$insCongno['liabilities'] = 2;// mua hang
			$insCongno['price'] = $total_tongcong;// ban hang
			$insCongno['amount_debt'] = $conNoConLai;// ban hang 
			$insCongno['description'] = '';
			$insCongno['pnk'] = $poid;
			$insCongno['supplierid'] = $array['supplierid'];
			$insCongno['usercreate'] = $this->login->username;
			$insCongno['datecreate'] = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
			if(!empty($conNoConLai)){
				$this->model->table($tb['hotel_liabilities_buy'])->insert($insCongno);	
			}
		}
		#end
		#region tư thanh toan du vao chi
		//if(ispay() == 1){ //Tự động thanh toan
			$pay_code = $this->createPOPay($branchid,$array['datecreate']);		
			$arrIS =  array();
			$arrIS['orderid'] = $orderid;
			
			$arrIS['branchid'] = $branchid;
			$arrIS['pay_type'] = 2; //chi theo phiếu nhập kho = 2
			$arrIS['payment'] =  $array['payments'];
			$arrIS['poid'] = $poid;
			$arrIS['usercreate'] = $this->login->username;
			$arrIS['datecreate'] = $timeNow;
			$arrIS['pay_code'] = $pay_code;
			$arrIS['supplierid'] = $array['supplierid'];
			$arrIS['datepo'] = fmDateSave($array['datecreate']);
			if(!empty($insert['price_prepay_value'])){
				$arrIS['amount'] = fmNumberSave($insert['price_prepay_value']);
				$this->model->table($tb['hotel_pay'])->insert($arrIS);
			}
		//}
		#end
		#region ghi log
		$description = getLanguage('them-moi').': '.$poid;
		$this->base_model->addAcction(getLanguage('nhap-kho'),$this->uri->segment(2),'','',$description );	
		#end
		#region Xoa du lieu bang tam
		$userid =  $this->login->id;
		$this->model->table($tb['hotel_add_temp'])
					->where('contronller',$this->ctr)
					->where("id in ($stringID)")
					->delete();	
		#end
		$this->db->trans_complete();
		$arr = array();
		$arr['uniqueid'] = $uniqueid;
		//$arr['uniqueidnew'] = 
		$arr['poid'] = $poid;
		$arr['msg'] = '';
		return $arr;
	}
	function findGoodsID($id){
		$tb = $this->base_model->loadTable();
		$output = $tb['hotel_input'];
		$goods = $tb['hotel_goods'];
		$query = $this->model->table($output)
					  ->select('goods_code,goods_name')
					  ->join($goods,$goods.'.id = '.$output.'.goodsid','left')
					  ->where($output.".id in ($id)")
					  ->where($output.'.isdelete',0)
					  ->find_all();
		if(!empty($query[0]->goods_name)){
			return $query[0];
		}
		else{
			return "";
		}
	}
	function findID($id){
		$tb = $this->base_model->loadTable();
		$query = $this->model->table($tb['hotel_input'])
					  ->select('*')
					  ->where('id',$id)
					  ->find();
		return $query;
	}
	function findListID($unit){
		$tb = $this->base_model->loadTable();
		$sql = "
			SELECT oo.id, so.vat, so.signature_x, so.signature_name_x, so.place_of_delivery, so.stt, so.poid, so.datepo, oo.sttview, oo.goodsid, oo.branchid, sum(oo.quantity) as quantity, oo.priceone, oo.price, sum(oo.discount) as discount, so.description, sum(oo.cksp) as cksp,
			c.customer_code, c.customer_name, c.phone, c.fax, c.email, c.address, pr.province_name,
			g.goods_code, g.goods_code2, g.goods_name, g.goods_type, gt.goods_tye_name,
			un.unit_name
			FROM `".$tb['hotel_input_createorders']."` so
			LEFT join `".$tb['hotel_input']."` oo on oo.uniqueid = so.uniqueid
			left join `".$tb['hotel_customer']."` c on c.id = so.customer_id and c.isdelete = 0
			left join hotel_province pr on pr.id = c.provinceid and pr.isdelete = 0
			left join hotel_district d on d.id = c.districid and d.isdelete = 0
			left join `".$tb['hotel_goods']."` g on g.id = oo.goodsid
			left join `".$tb['hotel_goods_type']."` gt on gt.id = g.goods_type and gt.isdelete =0
			left join `".$tb['hotel_unit']."` un on un.id = g.unitid and un.isdelete = 0
			where so.uniqueid = '$unit'
			and so.isdelete = 0
			and oo.isdelete = 0
			and g.isdelete = 0
			group by oo.goodsid
			;
		 ";
		return $this->model->query($sql)->execute();;
	}
	function findOrder($id){
		$tb = $this->base_model->loadTable();
		$query = $this->model->table($tb['hotel_input_createorders'])
					  ->select('*')
					  ->where('id',$id)
					  ->where('isout',0)
					  ->find();
		return $query;
	 }
	function deletes($id, $array){
		$tb = $this->base_model->loadTable();
		$this->db->trans_start();
		$result = $this->model->table($tb['hotel_input_createorders'])
					   ->select('id,uniqueid')
					   ->where("id in ($id)")
					   ->find();	
		$query = $this->model->table($tb['hotel_input'])
					   ->select('uniqueid,id,quantity,warehouseid,branchid,companyid')
					   ->where("uniqueid in (".$result->uniqueid .")")
					   ->find_all();
		foreach($query as $item){
			$uniqueid = $item->uniqueid;
			//Cong tra so luong vao kho
			 $goodsid = $this->findID($item->id);//$array['goodsid'];
			 $quantity = $goodsid->quantity;
			 $warehouseid = $goodsid->warehouseid;
			 $branchid = $goodsid->branchid;
			 $companyid = $goodsid->companyid;
			 //Tru so luong trong kho
			 $sqlUpdate = "
				UPDATE `".$tb['hotel_inventory']."` SET `quantity`=`quantity`+ $quantity 
				WHERE `id` > 0
				and `goodsid`= '".$goodsid->goodsid ."'
				and `branchid`= '$branchid'
				;
			 ";
			 $this->model->executeQuery($sqlUpdate);				
		}
		$this->model->table($tb['hotel_input_createorders'])
					   ->where("uniqueid in ($uniqueid)")
					   ->update($array);
					   
		$this->model->table($tb['hotel_input'])
					   ->where("uniqueid in ($uniqueid)")
					   ->update($array);
		$this->db->trans_complete();
		return 1;
	}
	function findGoods($id,$code,$stype,$exchangs,$delete='',$isnew,$xkm,$uniqueid,$findgoods){
		$code = trim($code);
		$companyid = $this->login->companyid;
		$tb = $this->base_model->loadTable();
		
		$arrexchangs = explode(',',$exchangs);
		$userid =  $this->login->id;
		$arrAdd = array();
		$arrAdd['contronller'] = $this->ctr;
		$arrAdd['userid'] = $userid;
		$arrAdd['stype'] = $stype;
		if(!empty($delete)){//Lay lay danh sach truong hop xoa
			return $this->getTempGood($userid,$isnew);
		}
		$arrAdd['stype'] = $stype;
		$checkuniqueid = $this->model->table($tb['hotel_add_temp'])
						  ->select('uniqueid')
						  ->where('contronller',$this->ctr)
						  ->where('userid',$userid)
						  ->where('isnew',$isnew)
						  ->find();
		if(empty($checkuniqueid->uniqueid)){
			$arrAdd['uniqueid'] = $uniqueid;
		}
		else{
			$arrAdd['uniqueid'] = $checkuniqueid->uniqueid;
		}
		foreach($arrexchangs as $key=>$str){
			$arrStr = explode('____',$str);
			$goodcode  = $arrStr[0];
			$goodid  = $arrStr[1];
			$exchang  = $arrStr[2];
			$arrAdd['isnew'] = $isnew;
			$arrAdd['goods_code_group'] = $code;
			$arrAdd['goods_code'] = $goodcode;
			$arrAdd['goodid'] = $goodid;
			$check = $this->model->table($tb['hotel_add_temp'])
						  ->select('id,quantity')
						  ->where('contronller',$this->ctr)
						  ->where('userid',$userid)
						  ->where('goodid',$goodid)
						  ->where('isnew',$isnew)
						  ->find();
			if(empty($check->id)){//chua co insert
				$quantity = $exchang;
			}
			else{
				$quantity = $exchang + $check->quantity;
			}
			$arrAdd['quantity'] = $quantity;
			if(empty($check->id)){//chua co insert
				$arrAdd['price'] = '';
				$arrAdd['discount'] = '';
				if(!empty($findgoods->discountsales_dly)){
					$arrAdd['discount_type'] = $findgoods->discountsales_type_dly;
				}
				else{
					$arrAdd['discount_type'] = 2;
				}
				if($xkm == 1){
					$arrAdd['discount'] = 0;
					$arrAdd['price'] = 0;
				}
				//Tinh tien
				/*if($findgoods->discountsales_type_dly == 1){//Tinh phần trăm
					$ptr = $findgoods->discountsales_dly * $findgoods->sale_price / 100;
					$arrAdd['discount_value'] = fmNumberSave($ptr);
				}
				else{
					$arrAdd['discount_value'] = $findgoods->discountsales_dly;
				}*/
				$arrAdd['datecreate'] = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
				$arrAdd['unitid'] = $findgoods->unitid_active;
				$this->model->table($tb['hotel_add_temp'])->insert($arrAdd);
			}
			else{//co roi update so luon
				$this->model->table($tb['hotel_add_temp'])->save($check->id,$arrAdd);
			}
		}
		return $this->getTempGood($userid,$isnew);
	}
	function getTempGood($userid,$isnew = 0,$soid=''){
		$tb = $this->base_model->loadTable();
		$skey = $this->login->skey;
		$branchid = $this->login->branchid;
		$and = '';
		if(!empty($soid)){
			$and.= " and sat.soid = '$soid'";
		}
		$sql = "
				SELECT  sat.id as satid, if(sat.discount_type=1,'%','') as satdiscount_type, sat.discount_type as discount_types, sat.discount_value, sat.xkm,sat.serial_number, sat.discount, sat.uniqueid, sat.stype, s.goods_code, s.id, s.img,s.goods_name, s.shelflife, s.discountsales_dly,s.discountsales_type_dly
, sat.guarantee as guaranteedate, sat.detailid,
				if(sat.quantity is not null,sat.quantity,1) as quantity,
				if(sat.price is not null,sat.price,s.buy_price) as buy_price,
				if(sat.discount is not null,sat.discount,s.discountsales_dly) as discount, s.isserial, sat.vat, sat.price, sat.price_total,
				if(sat.discount is not null,2,s.discountsales_type_dly) as discount_type
				,(
					SELECT iv.quantity
					FROM `".$tb['hotel_inventory']."` iv
					WHERE iv.isdelete = 0
					and iv.branchid = '$branchid'
					and iv.goodsid = s.id
					limit 1
				) tonkho,
				(
					select group_concat(concat(gc.unitid,'::', unt.unit_name) SEPARATOR '___') as unitChange
						from `".$tb['hotel_goods_conversion']."` gc
						left join `".$tb['hotel_unit']."` unt on unt.id = gc.unitid
						where unt.isdelete = 0
						and gc.goodsid = s.id
				) as unit_exchange,
				un.unit_name, un.id as unitid, sat.unitid as satunitid, s.unitid_active
				FROM `".$tb['hotel_add_temp']."` sat
				left join `".$tb['hotel_goods']."` s on s.id = sat.goodid
				left join `".$tb['hotel_unit']."` un on un.id = s.unitid
				where s.isdelete = 0
				and sat.userid = '$userid'
				and sat.contronller = '".$this->ctr ."'
				and sat.isnew = '$isnew'
				and un.isdelete = 0
				$and
				order by sat.datecreate asc
			 "; 
		$query = $this->model->query($sql)->execute();
		return $query;
	}
	function checkTempData($query,$isnew){
		$tb = $this->base_model->loadTable();
		foreach($query as $item){
			$check = $this->model->table($tb['hotel_add_temp'])
							     ->select('id')
								 ->where('contronller',$this->ctr)
								 ->where('goodid',$item->goodsid)
								 ->where('userid',$this->login->id)
								 ->where('isnew',$isnew)
								 ->find();
			if(empty($check->id)){ //Chi insert lần đâu vào
				$arrAdd = array();
				$arrAdd['contronller'] = $this->ctr;
				$arrAdd['userid'] = $this->login->id;
				$arrAdd['stype'] = $item->stype;
				$arrAdd['orderidso'] = $item->orderid;
				$arrAdd['detailid'] = $item->detailid;
				$arrAdd['isnew'] = $isnew;
				$arrAdd['uniqueid'] = $item->uniqueid;
				//$arrAdd['goods_code_group'] = $item->group_code; unitid
				$arrAdd['goods_code'] = $item->goods_code;
				$arrAdd['goodid'] = $item->goodsid;
				$arrAdd['quantity'] = $item->quantity;
				$arrAdd['price'] = $item->buy_price;
				$arrAdd['price_total'] = $item->price;
				$arrAdd['discount'] = $item->discount;
				$arrAdd['discount_value'] = $item->discount_value;
				$arrAdd['discount_type'] = $item->discount_type;
				//$arrAdd['guarantee'] = $item->guaranteeOut;
				$arrAdd['xkm'] = $item->cksp;
				//$arrAdd['vat'] = $item->vat;
				//$arrAdd['soid'] = $item->soid;
				if(!empty($item->serial_number)){
					$arrAdd['serial_number'] = $item->serial_number;
				}
				$arrAdd['unitid'] = $item->unitid;
				$arrAdd['guarantee'] = $item->guaranteeOut;
				$arrAdd['datecreate'] = gmdate("Y-m-d H:i:s", time() + 7 * 3600);;
				$this->model->table($tb['hotel_add_temp'])->insert($arrAdd);
			}
		}
	}
	function getNoneCreateorders(){
		$tb = $this->base_model->loadTable();
		$sql = "
		SELECT column_name
		FROM information_schema.columns
		WHERE table_name='".$tb['hotel_input_createorders']."'; 
		";
		$query = $this->model->query($sql)->execute();
		$obj = new stdClass();
		foreach($query as $item){
			$clm = $item->column_name;
			$obj->$clm = null;
		}
		return $obj;
	}
	/*function findGoodsByPO($poid){
		$tb = $this->base_model->loadTable();
		
		$skey = $this->login->skey;
		$find = $this->model->table($tb['hotel_input_createorders'])
							 ->select("place_of_delivery,deliverydate,poid,uniqueid,customer_id,employeeid,warehouseid,payments,quantity,price,price_prepay,
							 customer_name as customer_name,
							 customer_address,
							 customer_phone,
							 customer_email,
							 DATE_FORMAT(datecreate,'%m-%d-%Y') as datecreate,description, (price - price_prepay) as cl
							 ")
							 ->where('isdelete',0)

							 ->where('poid',$poid)
							 ->where('isout',0)
							 //->where('isorder',1)
							 ->find();
		
		//print_r($find); exit;
		if(isset($find->uniqueid)){
			$uniqueid = $find->uniqueid;
		}
		else{
			$uniqueid = '';
		}
		$sql = "
			SELECT s.id, g.img ,s.uniqueid, s.goodsid, s.quantity, g.goods_code, 
			DES_DECRYPT(g.goods_name,'".$skey."') as goods_name,  un.unit_name,  g.sale_price as sale_price, (g.sale_price * s.quantity) as price , s.guarantee
			FROM `".$tb['hotel_input']."` s
			left join `".$tb['hotel_goods']."` g on g.id = s.goodsid and g.isdelete = 0
			left join `".$tb['hotel_unit']."` un on un.id = g.unitid
			where s.uniqueid = '$uniqueid'
			and s.isdelete = 0
		 ";
		 $query = $this->model->query($sql)->execute();
		 $array['datas'] = $query;
		 $array['finds'] = $find;				 
		 return $array;
	}*/
	function saveCustomer($arrays){
		$tb = $this->base_model->loadTable();
		foreach($arrays as $k=>$v){
			$kk = str_replace("_a_","",$k);
			$array[$kk] = $v;
		}
		$check = $this->model->table($tb['hotel_customer'])
					  ->select('id')
					  ->where('isdelete',0)
					  ->where('customer_name',$array['customer_name'])
					  ->where('companyid',$this->login->companyid)
					  ->find();
		if(!empty($check->id)){
			return -1;	
		}

		$result = $this->model->table($tb['hotel_customer'])->save('',$array);	
		return $result;
	}
	function getDetailEdit($uniqueid=''){
		 $tb = $this->base_model->loadTable();
		 $goods = $tb['hotel_goods'];
		 $warehouse = $tb['hotel_warehouse'];
		 $output = $tb['hotel_input'];
		 $createorders = $tb['hotel_input_createorders'];
		 $unit = $tb['hotel_unit'];
		 $sql = "
			SELECT c.place_of_delivery, c.deliverydate, o.id, c.id as createordersid, c.uniqueid, c.customer_id, c.customer_name, c.customer_address, c.customer_phone, c.customer_email, u.unit_name , c.poid, c.usercreate,
				c.employeeid, c.warehouseid, c.payments, o.quantity, o.priceone, o.price, g.id as goodsid, 
				g.goods_code, DES_DECRYPT(g.goods_name,'".$this->login->skey ."') as goods_name, 
				c.price as pricetotal, c.description, c.vat, o.guarantee
				FROM `$output` o 
				LEFT JOIN `$createorders` c on c.uniqueid = o.uniqueid
				LEFT JOIN `$goods` g on g.id = o.goodsid
				LEFT JOIN `$unit` u on u.id = g.unitid
				where o.isdelete = 0
				and c.isdelete = 0
				and c.uniqueid = '$uniqueid'
				;
		 ";
		$query = $this->model->query($sql)->execute();
		return $query;
	}
	function createPoOrder($branchid,$datecreate){
		$yearDay = fmMonthSave($datecreate); 
		$tb = $this->base_model->loadTable();
		$configs = configs();
		if($configs['cfpn_type'] == 0){		
			$checkPOid = $this->model->table($tb['hotel_input_createorders'])
				 ->select('poid,stt')
				 ->where("datepo like '%$yearDay%'")
				 ->where('branchid',$branchid)
				 ->where('isdelete',0)
				 ->order_by('id','DESC')
				 ->limit(1)
				 ->find(); 
			if(!empty($checkPOid->poid)){
				$poid = str_replace($configs['cfpn'],'',$checkPOid->poid);
				$poc = trim($configs['cfpn']).((float)$poid + 1);
			}
			else{
				if(empty($configs['cfpn_default'])){
					$configs['cfpn_default'] = '00001';
				}
				$poc = trim($configs['cfpn']).date('ym',strtotime($yearDay)).trim($configs['cfpn_default']);
			}
		}	
		else{
			$checkPOid = $this->model->table($tb['hotel_input_createorders'])
				 ->select('poid,stt')
				 ->where('branchid',$branchid)
				 ->where('isdelete',0)
				 ->order_by('id','DESC')
				 ->limit(1)
				 ->find();
			if(!empty($checkPOid->poid)){
				$poid = str_replace($configs['cfpn'],'',$checkPOid->poid);
				if(empty($configs['cfpn_default'])){
					$configs['cfpn_default'] = '00001';
				}
				//$poc = trim($configs['cfpn']).((float)$poid + 1);
				$poc = trim($configs['cfpn']). $this->base_model->createPO($configs['cfpn_default'], $poid);
			}
			else{
				if(empty($configs['cfpn_default'])){
					$configs['cfpn_default'] = '00001';
				}
				$poc = trim($configs['cfpn']).trim($configs['cfpn_default']);
			}
		}
		$checkSTT = $this->model->table($tb['hotel_input_createorders'])
				 ->select('poid,stt')
				 ->where("datepo like '%$yearDay%'")
				 ->where('branchid',$branchid)
				 ->where('isdelete',0)
				 ->order_by('id','DESC')
				 ->limit(1)
				 ->find(); 
		if(!empty($checkSTT->stt)){
			$stt = (float)$checkSTT->stt;
		}
		else{
			$stt = '0';
		}
		$array = array();
		$array['poid'] = $poc;
		$array['stt'] = $stt + 1;
		return $array;
	}
	function getDiscountorder($goodid,$price,$isnew){
		$tb = $this->base_model->loadTable();
		$userid =  $this->login->id;
		$skey = $this->login->skey;
		$sql = "
			SELECT g.id, sat.discount, g.goods_code, DES_DECRYPT(g.goods_name,'".$skey."') as goods_name
			FROM `".$tb['hotel_add_temp']."`  sat
			left join `".$tb['hotel_goods']."` g on g.id = sat.goodid
			where sat.contronller = '".$this->ctr ."'
			and sat.userid = '$userid'
			and sat.goodid = '$goodid'
			and sat.isnew = '$isnew'
			and g.isdelete = 0
			;
		";
		$query = $this->model->query($sql)->execute();
		return $query[0];
	}
	function getDiscountorderSO($goodid,$poid){
		$tb = $this->base_model->loadTable();
		$userid =  $this->login->id;
		$skey = $this->login->skey;
		$sql = "
			SELECT g.id, sat.discount, g.goods_code, DES_DECRYPT(g.goods_name,'".$skey."') as goods_name
			FROM `".$tb['hotel_input_order']."`  sat
			left join `".$tb['hotel_goods']."` g on g.id = sat.goodsid
			where sat.poid = '$poid'
			and sat.goodsid = '$goodid'
			and g.isdelete = 0
			;
		";
		$query = $this->model->query($sql)->execute();
		return $query[0];
	}
	/*function updateDiscount($price_discount_val,$goodid){
		$tb = $this->base_model->loadTable();
		$array = array();
		$userid =  $this->login->id;
		$array['discount'] = $price_discount_val;
		$this->model->table($tb['hotel_add_temp'])
					->where('contronller',$this->ctr)
					->where('userid',$userid)
					->where('goodid',$goodid)
					->update($array);
	}*/
	function updateGuarantee($goodid,$guarantee){
		$userid =  $this->login->id;
		$tb = $this->base_model->loadTable();
		$this->model->table($tb['hotel_add_temp'])
						  ->where('contronller',$this->ctr)
						  ->where('userid',$userid)
						  ->where('goodid',$goodid)
						  ->update(array('guarantee'=>fmDateSave($guarantee)));
	}
	function updateAllGuarantee($guarantee){
		$userid =  $this->login->id;
		$tb = $this->base_model->loadTable();
		$this->model->table($tb['hotel_add_temp'])
						  ->where('contronller',$this->ctr)
						  ->where('userid',$userid)
						  ->update(array('guarantee'=>fmDateSave($guarantee)));
	}
	function deleteTempData($goodid){
		$userid =  $this->login->id;
		$tb = $this->base_model->loadTable();
		$this->model->table($tb['hotel_add_temp'])
						  ->where('contronller',$this->ctr)
						  ->where('userid',$userid)
						  ->where('goodid',$goodid)
						  ->delete();
	}
	function deleteTempDataEdit($goodid, $detailid){//Xóa trừ số lượng trong kho
		$this->db->trans_start();
		$timeNow  = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
		$userid =  $this->login->id;
		$tb = $this->base_model->loadTable();
		//Get detai 
		$detail = $this->model->table($tb['hotel_input'])
						  ->select('id,quantity,warehouseid,unitid')
						  ->where('id',$detailid)
						  ->find(); 
		$quantity = 0;
		if(!empty($detail->id)){
			$quantity = $detail->quantity;
		} 
		$warehouseid = $detail->warehouseid;
		$unitid = $detail->unitid;
		//Kiểm tra số lượng trong kho
		$inventory = $this->model->table($tb['hotel_inventory'])
						  ->select('id,quantity')
						  ->where('goodsid',$goodid)
						  ->where('warehouseid',$warehouseid)
						  ->find();
		$quantityInventory = 0;
		if(!empty($inventory->quantity)){
			$quantityInventory = $inventory->quantity;
		}
		//Tru so luong trong kho so luong quy doi
		//Tìm đơn vị quy đổi
		$conversion = $this->model->table($tb['hotel_goods_conversion'])
						  ->select('id,conversion')
						  ->where('goodsid',$goodid)
						  ->where('unitid',$unitid)
						  ->find();
		if(!empty($conversion->id)){
			$quantitys = ($conversion->conversion) * $quantity;
		}
		else{
			$quantitys = $quantity;
		}
		if($quantitys > $quantityInventory){
			return 0;
		}
		$sql = "UPDATE `".$tb['hotel_inventory']."` SET `quantity`= `quantity` - '$quantitys' 
					WHERE `goodsid`='$goodid' 
					AND `warehouseid` = '$warehouseid';";
		$this->model->executeQuery($sql);
		//Xóa detail 
		$array = array();
		$array['isdelete'] = 1;
		$array['userupdate'] = $this->login->username;
		$array['dateupdate'] = $timeNow;
		$this->model->table($tb['hotel_input'])
						  ->select('id,quantity,warehouseid')
						  ->where('id',$detailid)
						  ->update($array);
		//Xoa bang tam
		$this->model->table($tb['hotel_add_temp'])
						  ->where('contronller',$this->ctr)
						  ->where('userid',$userid)
						  ->where('goodid',$goodid)
						  ->delete();
		$this->db->trans_complete();
		return 1;
	}
	function updateUnit($goodid,$unitid,$isnew){
		$userid =  $this->login->id;
		$tb = $this->base_model->loadTable();
		$this->model->table($tb['hotel_add_temp'])
						  ->where('contronller',$this->ctr)
						  ->where('userid',$userid)
						  ->where('goodid',$goodid)
						  ->where('isnew',$isnew)
						  ->update(array('unitid'=>$unitid));
	}
	function updatePriceOne($goodid,$priceone,$quantity,$discount,$xkm,$isnew,$unitid){
		$userid =  $this->login->id;
		$tb = $this->base_model->loadTable();
		$array = array();
		$pos = strpos($discount,'%');
		if ($pos !== false) {
			$discount_types = 2;
		} else {
			$discount_types = 1;
		}
		$array['discount'] = $discount;
		$discount = fmNumberSave(str_replace('%','',$discount));
		if(empty($discount)){
			$discount = 0;
		}
		$priceone = fmNumberSave($priceone);
		if(empty($priceone)){
			$priceone = 0;
		}
		$quantity = fmNumberSave($quantity);
		if(empty($quantity)){
			$quantity = 0;
		}
		$vat = 0;
		$xkm = fmNumberSave($xkm);
		if(empty($xkm)){
			$xkm = 0;
		}
		
		$array['price'] = $priceone;
		$array['quantity'] = $quantity;
		
		$array['vat'] = $vat;
		
		$totalEnd = $quantity - $xkm;
		$priceEnd = $totalEnd * $priceone;
		$giamGia = $discount;
		if($discount_types == 2){
			$giamGia = ($discount * $priceEnd) / 100;
		}
		$priceEnds = $priceEnd - $giamGia;
		$totalVat = ($vat * $priceEnds) /100;
		
				
		$array['discount_type'] = $discount_types;
		$array['discount_value'] = $discount;
		$array['xkm'] = $xkm;
		$array['unitid'] = $unitid;
		$array['price_total'] = fmNumberSave($priceEnds + $totalVat);
		
		$this->model->table($tb['hotel_add_temp'])
						  ->where('contronller',$this->ctr)
						  ->where('userid',$userid)
						  ->where('goodid',$goodid)
						  ->where('isnew',$isnew)
						  ->update($array);
						  
		return $this->getNewPrice($isnew);
	}
	function getNewPrice($isnew){
		$tb = $this->base_model->loadTable();
		$userid =  $this->login->id;
		$query =  $this->model->table($tb['hotel_add_temp'])
						  ->select('sum(price_total) as price, sum(discount_value) as discount')
						  ->where('contronller',$this->ctr)
						  ->where('userid',$userid)
						  ->where('isnew',$isnew)
						  ->find();
		return $query;
	}
	function findListUniqueID($orderid){
		$tb = $this->base_model->loadTable();
		$branchid = $this->login->branchid;  //discount vat
		$sql = "
			select '' as soid,sg.id, '0' stype , si.goodsid, sg.sale_price ,si.quantity, si.price, si.priceone as buy_price, sg.sale_price as price_out, sg.goods_code, sg.goods_name , su.unit_name,  sg.guarantee, si.orderid, si.guarantee as guaranteeOut, oc.discount, oc.discount_value, oc.discount_type,si.cksp, oc.uniqueid, oc.poid, oc.supplierid, oc.datepo, oc.description, oc.payments, oc.ponumber, oc.warehouseid, oc.datecreate,
			si.unitid, oc.adjustment, oc.vat, oc.price_prepay, oc.price_prepay_value, oc.price_prepay_type, oc.vat_value, si.id as detailid
			from `".$tb['hotel_input']."` si
			left join `".$tb['hotel_input_createorders']."` oc on oc.id = si.orderid
			left join `".$tb['hotel_goods']."` sg on si.goodsid = sg.id
			left join `".$tb['hotel_unit']."` su on su.id = sg.unitid
			where si.isdelete = 0
			and oc.id = '$orderid'
			and oc.branchid = '$branchid'
			order by si.sttview asc
		"; 
		return $this->model->query($sql)->execute();
	}
	function findIDs($uniqueid){
		 $tb = $this->base_model->loadTable();
		 $query = $this->model->table($tb['hotel_input_createorders'])
					  ->select('*')
					  ->where('uniqueid',$uniqueid)
					  ->find();
		if(!empty($query->id)){
			return $query;
		}
		else{
			return $this->getNoneData($tb['hotel_input_createorders']);
		}
	}
	function getNoneData($tb){
		$sql = "
		SELECT column_name
		FROM information_schema.columns
		WHERE table_name='".$tb."'; 
		";
		$query = $this->model->query($sql)->execute();
		$obj = new stdClass();
		foreach($query as $item){
			$clm = $item->column_name;
			$obj->$clm = null;
		}
		return $obj;
	}
	/*function findListSO($poid){
		$tb = $this->base_model->loadTable();
		$branchid = $this->login->branchid;
		$sql = "
			select si.id, si.poid as soid, oc.poid , sg.id, '0' stype ,si.serial_number , si.goodsid, sg.sale_price ,si.quantity, si.price as totalPrice, si.priceone as buy_price, sg. sale_price as price_out, sg.goods_code, sg.goods_name, su.unit_name, sg.guarantee as isguarantee, if(si.guarantee = '0000-00-00',0,si.guarantee) as guaranteedate, gg.group_code, gg.group_name, sg.guarantee, gd.exchang,si.uniqueid, si.guarantee as guaranteeOut, si.discount, si.discount_value, si.discount_type,si.cksp,
			oc.vat, oc.customer_id, oc.employeeid, oc.datepo, oc.deliverydate, oc.place_of_delivery, oc.description, oc.payments, oc.price_prepay
			from `".$tb['hotel_input_order']."` si
			left join `".$tb['hotel_input_createorders_order']."` oc on oc.uniqueid = si.uniqueid
			left join `".$tb['hotel_goods']."` sg on si.goodsid = sg.id
			left join `".$tb['hotel_goods_group_detail']."` gd on gd.goodid = sg.id and gd.isdelete = 0
			left join `".$tb['hotel_goods_group']."` gg on gg.id = gd.groupid and gg.isdelete = 0
			left join `".$tb['hotel_unit']."` su on su.id = sg.unitid
			where si.poid = '$poid'
			and si.isdelete = 0
			and oc.isdelete = 0
			and oc.poid not in (
				select occ.soid
				from `".$tb['hotel_input']."` ss
				left join `".$tb['hotel_input_createorders']."` occ on occ.uniqueid = ss.uniqueid
				where occ.soid = oc.poid
				and ss.goodsid = si.goodsid
				and ss.isdelete = 0
				and occ.isdelete = 0
			) 
			order by si.sttview asc
		"; //echo '<pre>';print_r($sql); exit;
		return $this->model->query($sql)->execute();
	}
	*/
	/*function findOrderUniqueid($uniqueid){
		$tb = $this->base_model->loadTable();
		$query = $this->model->table($tb['hotel_input_createorders'])
					  ->select('*')
					  ->where('uniqueid',$uniqueid)
					  ->find();
		return $query;
	}*/
	/*function findOrderUniqueidSO($uniqueid){
		$tb = $this->base_model->loadTable();
		$query = $this->model->table($tb['hotel_input_createorders_order'])
					  ->select('*')
					  ->where('uniqueid',$uniqueid)
					  ->find();
		return $query;
	}*/
	/*function findOrderSO($so){
		$tb = $this->base_model->loadTable();
		$query = $this->model->table($tb['hotel_input_createorders_order'])
					  ->select('*')
					  ->where('poid',$so)
					  ->find();
		return $query;
	}*/
	function createPOPay($branchid,$datecreate){
		$yearDay = fmMonthSave($datecreate);
		$tb = $this->base_model->loadTable();
		$configs = configs();
		if($configs['cfpc_type'] == 0){
			$checkPOid = $this->model->table($tb['hotel_pay'])
							 ->select('pay_code')
							 ->where("datepo like '$yearDay%'")
							 ->where('branchid',$branchid)
							 ->where('isdelete',0)
							 ->order_by('id','DESC')
							 ->limit(1)
							 ->find();
			if(!empty($checkPOid->pay_code)){
				$pay_code = str_replace($configs['cfpc'],'',$checkPOid->pay_code);
				$poc = trim($configs['cfpc']).((float)$pay_code + 1);
			}
			else{
				if(empty($configs['cfpc_default'])){
					$configs['cfpc_default'] = '00001';
				}
				$poc = trim($configs['cfpc']).date('ym',strtotime($yearDay)).trim($configs['cfpc_default']);
			}
		}
		else{
			$checkPOid = $this->model->table($tb['hotel_pay'])
							 ->select('pay_code')
							 ->where('branchid',$branchid)
							 ->where('isdelete',0)
							 ->order_by('id','DESC')
							 ->limit(1)
							 ->find();
			if(!empty($checkPOid->pay_code)){
				$pay_code = str_replace($configs['cfpc'],'',$checkPOid->pay_code);
				$poc = trim($configs['cfpc']). $this->base_model->createPO($configs['cfpc_default'], $pay_code);
			}
			else{
				if(empty($configs['cfpc_default'])){
					$configs['cfpc_default'] = '00001';
				}
				$poc = trim($configs['cfpc']).trim($configs['cfpc_default']);
			}
		}
		return $poc;
	}
	function getOrder($id,$unit=''){
		$skey = $this->login->skey;
		$tb = $this->base_model->loadTable();
		$tbcreateorders = $tb['hotel_input_createorders'];
		$tbsupplier = $tb['hotel_supplier'];
		
		$queryOrder = $this->model->table($tbcreateorders)
					  ->select("
					  signature, signature_name, 
					  $tbcreateorders.stt,$tbcreateorders.datepo,$tbcreateorders.id,$tbcreateorders.datecreate,poid,uniqueid,quantity,price,price_prepay, supplier_name, phone,address")
					  ->join($tbsupplier,$tbsupplier.'.id = '.$tbcreateorders.'.supplierid','left');
			if(empty($unit)){
				$queryOrder = $queryOrder->where($tbcreateorders.'.id',$id);
			}
			else{
				$queryOrder = $queryOrder->where($tbcreateorders.'.uniqueid',$unit);
			}
			$queryOrder = $queryOrder->where($tbcreateorders.'.isdelete',0)->find();
		return $queryOrder;
	}
	function findListIDDetail($uniqueid){
		 $tb = $this->base_model->loadTable();
		 $tbinput = $tb['hotel_input'];
		 $tbgoods = $tb['hotel_goods'];
		 $tbwarehouse = $tb['hotel_warehouse'];
		 $createorders = $tb['hotel_input_createorders'];
		 $tbunit = $tb['hotel_unit'];
		 
		 $sql = "
			 select dt.cksp, ip.vat, ip.vat_value, dt.quantity ,dt.priceone, dt.price, dt.discount, dt.discount_value, dt.discount_type,
			 ip.poid as phieu_nhap_kho, ip.datepo, ip.stt, ip.ponumber, ip.supplierid, ip.description, ip.price as t_price, ip.price_total, ip.price_prepay, ip.price_prepay_value, ip.price_prepay_type, ip.discount as t_discount, ip.discount_value as t_discount_value, ip.discount_type as t_discount_type, ip.adjustment, ip.payments, wh.warehouse_name, g.goods_name, g.goods_code ,unt.unit_name
			 from `$tbinput` dt
			 left join `$createorders` ip on ip.id = dt.orderid
			 left join `$tbgoods` g on g.id = dt.goodsid
			 left join `$tbunit` unt on unt.id = dt.unitid
			 left join `$tbwarehouse` wh on wh.id = dt.warehouseid
			 where dt.isdelete = 0
			 and ip.uniqueid in ($uniqueid)
			 order by dt.sttview asc
		 "; 
		 $query = $this->model->query($sql)->execute();
		 return $query;
	}
	function saveSupplier($arrays){
		$skey = $this->login->skey;
		$tb = $this->base_model->loadTable();
		foreach($arrays as $k=>$v){
			$kk = str_replace("_a_","",$k);
			$array[$kk] = addslashes($v); 
		}
		//$supplier_name = 
		//$array['supplier_name'] = "select (DES_DECRYPT(".$array['supplier_name'].",'$skey')) ";
		$check = $this->model->table($tb['hotel_supplier'])
					  ->select('id')
					  ->where('isdelete',0)
					  ->where('supplier_code',$array['supplier_code'])
					  ->find();
		if(!empty($check->id)){
			return -1;	
		}
		$companyid = $this->login->companyid;
		$this->model->table($tb['hotel_supplier'])->insert($array);
		$checkID = $this->model->table($tb['hotel_supplier'])
					  ->select('id')
					  ->where('isdelete',0)
					  ->where('supplier_code',$array['supplier_code'])
					  ->order_by('id','DESC')
					  ->find();
		return $checkID->id;
	}
	function getPonumber(){
		$tb = $this->base_model->loadTable();
		$query = $this->model->table($tb['hotel_ponumber'])
					  ->select('id,ponumber')
					  ->where('isdelete',0)
					  ->order_by('id','DESC')
					  ->find_all();
		return $query;
	}
	public function getSupplier($poid){
		$tb = $this->base_model->loadTable();
		$query = $this->model->table($tb['hotel_ponumber'])
					  ->select('group_concat(supplierid) supplierid')
					  ->where('isdelete',0)
					  ->where('id',$poid)
					  ->find();
		$supplierid = 0;
		if(!empty($query->supplierid)){
			$supplierid = $query->supplierid;
		}
		
		$sql = 
		"
			select sg.id, sg.email, sg.phone, concat(supplier_code,' - ',sg.supplier_name) as supplier_name
			from `".$tb['hotel_supplier']."` sg
			where sg.isdelete = 0
			and sg.id in ($supplierid)
		";
		$sql.= " order by sg.supplier_name ASC"; 
		$query = $this->model->query($sql)->execute(); 
		return $query;
	}
}