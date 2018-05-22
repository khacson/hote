<?php
/**
 * @author 
 * @copyright 2018
 */
 class ExportModel extends CI_Model{
	function __construct(){
		parent::__construct('');
		$this->login = $this->site->getSession('login');
		$this->ctr = 3;
	}
	function getOderList(){
		$tb = $this->base_model->loadTable();
		$sql = "
			select co.poid,co.id
			from `".$tb['hotel_orders']."` co
			left join `".$tb['hotel_orders_detail']."` so on so.orderid = co.id
			where co.isdelete = 0
			and so.isdelete = 0
			and co.id not in (
				select  occ.soid
				from`".$tb['hotel_output_detail']."` occ
				where occ.soid = co.id
				and occ.isdelete = 0
			) 
			group by co.poid
		"; 
		
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
					from `".$tb['hotel_output_detail']."` outs 
					where outs.isdelete = 0 
					and outs.socode = od.poid 
					and outs.goodsid = od.goodsid
				) as quantityout
				 FROM `".$tb['hotel_orders']."` coo 
				 LEFT JOIN `".$tb['hotel_orders_detail']."` od on coo.uniqueid = od.uniqueid
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
	function deleteTempDataNewSO($soid,$isnew){
		$tb = $this->base_model->loadTable();
		$userid =  $this->login->id;
		$this->model->table($tb['hotel_add_temp'])
					->where('contronller',$this->ctr)
					->where('userid',$userid)
					->where('soid',$soid)
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
		$unitNode = $tbGoods.'.unitid as unitidNode';
		$sql = "
			SELECT st.*, g.isnegative, g.unitid AS unitidNode, g.goods_name
			FROM `$tbTemp` st
			LEFT JOIN `$tbGoods` g ON g.id = goodid
			WHERE st.id IN ($stringID)
		";
		$queryTemp = $this->model->query($sql)->execute();
		$listError = '';
		foreach($queryTemp as $item){
			//Kiểm tra số lượng trong kho
			$checkInventory = $this->model->table($tb['hotel_inventory'])
								   ->select('id,quantity')
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
				$arrAddInventorey['shelflife'] = '0000-00-00';
				$this->model->table($tb['hotel_inventory'])->insert($arrAddInventorey);
				$quantityStock = 0;
			}
			//Số lượng
			$quantity = $item->quantity;
			//S Tinh quy doi so luong
			if($item->unitidNode != $item->unitid){
				//Tinh quy doi
				$findUnit = $this->model->table($tb['hotel_goods_conversion'])
										->select('conversion')
										->where('goodsid',$item->goodid)
										->where('unitid',$item->unitid)
										->find();
				if(!empty($findUnit->conversion)){
					$quantity = ($findUnit->conversion) *  ($item->quantity);
				}
			}
			//Số lương Tồn kho
			if(!empty($checkInventory->quantity)){
				$quantityStock = $checkInventory->quantity;
			}
			else{
				$quantityStock = 0;
			}
			if(empty($item->isnegative)){
				if($quantityStock < $quantity){
					$listError.= $item->goods_name .' + Tồn kho không đủ - Tồn:'.$quantityStock.'</br>';
				}
			}
		}
		#region kiem tra so luong ton
		if($listError != ''){
			$arr = array();
			$arr['uniqueid'] = 0;
			$arr['poid'] = 0;
			$arr['msg'] = ' Tồn kho không đủ: <br>'.$listError;
			return $arr;
		}
		#end
		#region Tru hang hoa trong kho
		foreach($queryTemp as $item){
			$quantity = $item->quantity;
			$goodid = $item->goodid;
			if($item->unitidNode != $item->unitid){
				//Tinh quy doi
				$findUnit = $this->model->table($tb['hotel_goods_conversion'])
										->select('conversion')
										->where('goodsid',$item->goodid)
										->where('unitid',$item->unitid)
										->find();
				if(!empty($findUnit->conversion)){
					$quantity = ($findUnit->conversion) *  ($item->quantity);
				}
			}		   
			$sqlUpdate = "
				UPDATE `".$tb['hotel_inventory']."` 
				SET `quantity`= `quantity` - ".$quantity." 
				WHERE `goodsid`='".$goodid."'
				AND `branchid` = '".$branchid."'
				AND `warehouseid` = '".$array['warehouseid']."'
				;
			";
			$this->model->executeQuery($sqlUpdate);
		}
		#end
		#region Tao po
		$setuppo = $this->login->setuppo;
		$arrAuto = $this->createPoOrder($branchid,$array['datecreate']);
		if($setuppo == 0){
			$poid = $arrAuto['poid'];
		}
		else{
			$poid = $array['poid']; 
			//Kiem tra ton tai PO
			$checkPOid = $this->model->table($tb['hotel_output'])
								 ->select('poid')
								 ->where('poid',$poid )
								 ->where('branchid',$branchid )
								 ->where('isdelete',0)
								 ->find();
			if(!empty($checkPOid->poid)){
				$status['uniqueid'] = -2;
				$status['poid'] = $poid;
				$status['msg'] = 'Mã đơn hàng đã tồn tại';
				return $status; //PO đa tồn tại
			}
		}
		#end
		//Tam ung 
		$price_prepay = fmNumberSave($array['total_tamung']); 
		$tontienthanhtoan = fmNumberSave($array['total_tongcong']);
		
		$insert['price_prepay'] = fmNumberSave($array['price_prepay']);
		$insert['price_prepay_value'] =  $price_prepay;
		$insert['price_prepay_type'] =  $array['price_prepay_type'];
		//Giam gia 
		$insert['discount'] =  fmNumberSave($array['discount']);
		$insert['discount_value'] =  fmNumberSave($array['total_discount']);
		$insert['discount_type'] =  $array['discount_type'];
		$insert['quantity'] = fmNumberSave($array['tong_so_luong']);  
		//Dieu chinh gia 
		$insert['adjustment'] =  fmNumberSave($array['total_adjustment']);
		#region insert
		$timeNow = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
		$insert['branchid'] = $branchid;
		$insert['description'] = $array['description'];
		$insert['customerid'] = $array['customerid'];
		$insert['datecreate'] = $timeNow;
		$insert['usercreate'] =  $this->login->username;
		$insert['employeeid'] = $array['employeeid'];
		$insert['payments'] = $array['payments'];
		$insert['vat'] = fmNumberSave($array['vat']);
		$insert['vat_value'] = fmNumberSave($array['vat_value']);
		$insert['uniqueid'] = $uniqueid;
		$insert['poid'] = $poid;
		$insert['soid'] = $soidsave ;
		//Tong tien hang $array['warehouseid'];
		$insert['price'] = fmNumberSave($array['total_amount']); 
		//Tong thanh toan
		$total_tongcong = fmNumberSave($array['total_tongcong']);
		$insert['price_total'] = $total_tongcong;
		
		if(!empty($array['datecreate'])){
			$insert['datepo'] = fmDateSave($array['datecreate']);
		}
		if(!empty($array['deliverydate'])){
			$insert['deliverydate'] = fmDateSave($array['deliverydate']);
		}
		$insert['place_of_delivery'] = $array['place_of_delivery'];
		$insert['price_total'] = fmNumberSave($tontienthanhtoan);
		$insert['stt'] = $arrAuto['stt'];
		
		//Cong no
		$payments_status = 0;
		if($price_prepay < $total_tongcong){ //Chưa thanh toán hết
			$payments_status = -1;
		}
		$insert['payments_status'] = $payments_status;
		
		$insert['deliverydate'] = fmDateSave($array['deliverydate']); 
		$insert['signature_x'] = $this->login->signature;
		$insert['signature_name_x'] = $this->login->fullname;
		$insert['warehouseid'] = $array['warehouseid'];
		$insert['soid'] = $array['oderpoid'];
		$this->model->table($tb['hotel_output'])->insert($insert);	
		#end
		$orderid = $this->model->table($tb['hotel_output'])	
							   ->select('id')
							   ->where('uniqueid',$uniqueid)
							   ->find()->id;
		
		#region dua vao cong no //Đưa tất cả số tiền vào công nợ
		if($payments_status == -1){
			$conNoConLai = $total_tongcong - $price_prepay;
			$insCongno = array();
			$insCongno['branchid'] = $branchid;
			$insCongno['customerid'] = $array['customerid'];
			$insCongno['orderid'] = $orderid;
			$insCongno['liabilities'] = 2;// mua hang
			$insCongno['price'] = $total_tongcong;// ban hang
			$insCongno['amount_debt'] = $conNoConLai;
			$insCongno['description'] = '';
			$insCongno['pxk'] = $poid;
			$insCongno['customerid'] = $array['customerid'];
			$insCongno['usercreate'] = $this->login->username;
			$insCongno['datecreate'] = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
			$this->model->table($tb['hotel_liabilities'])->insert($insCongno);	
			}
		#end
		#region them bang detail
		$i=1;
		foreach($queryTemp as $item){
			$insertInput = array();
			$insertInput['warehouseid'] = $array['warehouseid'];
			$insertInput['branchid'] = $branchid;
			$insertInput['customerid'] = $array['customerid'];
			$insertInput['datecreate'] = $timeNow;
			$insertInput['usercreate'] = $this->login->fullname;
			$insertInput['poid'] = $poid;
			$insertInput['orderid'] = $orderid;
			$insertInput['quantity'] = $item->quantity;
			$insertInput['unitid'] = $item->unitid;
			$insertInput['goodsid'] = $item->goodid;
			$insertInput['priceone'] = $item->price;
			$insertInput['price'] = fmNumberSave($item->quantity * $item->price);
			$insertInput['guarantee'] =  $item->guarantee;
			$insertInput['sttview'] = $i;
			
			$insertInput['discount'] = $item->discount;
			$insertInput['discount_value'] = $item->discount_value;
			$insertInput['discount_type'] = $item->discount_type;
			$insertInput['serial_number'] = $item->serial_number;
			$insertInput['cksp'] = $item->xkm;
			if(!empty($item->orderidso)){
				$insertInput['soid'] = $item->orderidso;
			}
			$this->model->table($tb['hotel_output_detail'])->insert($insertInput);
			$i++;
		}
		#end
		#region Nhập vào phiếu thu
		//if(isreceipt() == 1){//Tu dong thanh toan
		$arrIS =  array();
		$arrIS['receipts_code'] = $this->createPoReceipt($branchid,$array['datecreate']);
		$arrIS['orderid'] = $orderid;
		$arrIS['branchid'] = $branchid;
		$arrIS['customerid'] = $array['customerid'];
		$arrIS['receipts_type'] = 2; //Chi thie phiếu nhập kho
		$arrIS['datepo'] = fmDateSave($array['datecreate']);
		$arrIS['payment'] = $array['payments'];
		$arrIS['amount'] =  $insert['price_prepay'];
		$arrIS['poid'] = $poid;
		$arrIS['customerid'] = $poid;
		$arrIS['usercreate'] = $this->login->username;
		$arrIS['datecreate'] = $timeNow; 
		if(!empty($arrIS['amount'])){
			$this->model->table($tb['hotel_receipts'])->insert($arrIS);
		}
		//}
		#end
		#region ghi log
		$description = 'Thêm mới: Đơn hàng '.$poid;
		$this->base_model->addAcction('Xuất bán hàng',$this->uri->segment(2),'','',$description );	
		#end
		#region Xoa du lieu bang tam
		$userid =  $this->login->id;
		$this->model->table($tb['hotel_add_temp'])
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
		$unitNode = $tbGoods.'.unitid as unitidNode';
		$sql = "
			SELECT st.*, g.isnegative, g.unitid AS unitidNode, g.goods_name,
			(
				select dt.quantity
				FROM `".$tb['hotel_output_detail']."` dt
				where dt.id = goodid 
				and dt.goodsid = g.id
			) as quantityOut
			FROM `$tbTemp` st
			LEFT JOIN `$tbGoods` g ON g.id = goodid
			WHERE st.id IN ($stringID)
		";
		$queryTemp = $this->model->query($sql)->execute(); 
		$listError = '';
		foreach($queryTemp as $item){
			//Kiểm tra số lượng trong kho
			$checkInventory = $this->model->table($tb['hotel_inventory'])
								   ->select('id,quantity')
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
				$arrAddInventorey['shelflife'] = '0000-00-00';
				$this->model->table($tb['hotel_inventory'])->insert($arrAddInventorey);
				$quantityStock = 0;
			}
			//Số lượng
			$quantity = $item->quantity;
			//S Tinh quy doi so luong
			if($item->unitidNode != $item->unitid){
				//Tinh quy doi
				$findUnit = $this->model->table($tb['hotel_goods_conversion'])
										->select('conversion')
										->where('goodsid',$item->goodid)
										->where('unitid',$item->unitid)
										->find();
				if(!empty($findUnit->conversion)){
					$quantity = ($findUnit->conversion) *  ($item->quantity);
				}
			}
			//Số lương Tồn kho
			if(!empty($checkInventory->quantity)){
				$quantityStock = $checkInventory->quantity;
			}
			else{
				$quantityStock = 0;
			}
			if(empty($item->isnegative)){
				$quantityOut = $item->quantityOut;
				$checkQuantityOut = $quantityStock + $quantityOut -  $quantity;
				if($checkQuantityOut < 0){
					$listError.= $item->goods_name .' + Tồn kho không đủ - Tồn:'.$quantityStock.'</br>';
				}
			}
		}
		#region kiem tra so luong ton
		if($listError != ''){
			$arr = array();
			$arr['uniqueid'] = 0;
			$arr['poid'] = 0;
			$arr['msg'] = ' Tồn kho không đủ: <br>'.$listError;
			return $arr;
		}
		#end
		#region Tru hang hoa trong kho
		$orderidso = 0;
		foreach($queryTemp as $item){
			$quantity = $item->quantity;
			$goodid = $item->goodid;
			$orderidso = $item->orderidso;
			if($item->unitidNode != $item->unitid){
				//Tinh quy doi
				$findUnit = $this->model->table($tb['hotel_goods_conversion'])
										->select('conversion')
										->where('goodsid',$item->goodid)
										->where('unitid',$item->unitid)
										->find();
				if(!empty($findUnit->conversion)){
					$quantity = ($findUnit->conversion) *  ($item->quantity);
				}
			}		  
			//Cộnh số lượng cũ vào kho
			$quantityOut = $item->quantityOut;
			$sqlUpdate = "
				UPDATE `".$tb['hotel_inventory']."` 
				SET `quantity`= `quantity` + ".$quantityOut." 
				WHERE `goodsid`='".$goodid."'
				AND `branchid` = '".$branchid."'
				AND `warehouseid` = '".$array['warehouseid']."'
				;
			";
			//Trừ số lượng mới
			$sqlUpdate = "
				UPDATE `".$tb['hotel_inventory']."` 
				SET `quantity`= `quantity` - ".$quantity." 
				WHERE `goodsid`='".$goodid."'
				AND `branchid` = '".$branchid."'
				AND `warehouseid` = '".$array['warehouseid']."'
				;
			";
			$this->model->executeQuery($sqlUpdate);
		}
		#end
		#region Tao po
		$setuppo = $this->login->setuppo;
		/*$arrAuto = $this->createPoOrder($branchid,$array['datecreate']);
		if($setuppo == 0){
			$poid = $arrAuto['poid'];
		}
		else{
			$poid = $array['poid']; 
			//Kiem tra ton tai PO
			$checkPOid = $this->model->table($tb['hotel_output'])
								 ->select('poid')
								 ->where('poid',$poid )
								 ->where('branchid',$branchid )
								 ->where('isdelete',0)
								 ->find();
			if(!empty($checkPOid->poid)){
				$status['uniqueid'] = -2;
				$status['poid'] = $poid;
				$status['msg'] = 'Mã đơn hàng đã tồn tại';
				return $status; //PO đa tồn tại
			}
		}*/
		#end
		//Tam ung 
		$price_prepay = fmNumberSave($array['total_tamung']); 
		$tontienthanhtoan = fmNumberSave($array['total_tongcong']);
		
		$insert['price_prepay'] = fmNumberSave($array['price_prepay']);
		$insert['price_prepay_value'] =  $price_prepay;
		$insert['price_prepay_type'] =  $array['price_prepay_type'];
		//Giam gia 
		$insert['discount'] =  fmNumberSave($array['discount']);
		$insert['discount_value'] =  fmNumberSave($array['total_discount']);
		$insert['discount_type'] =  $array['discount_type'];
		$insert['quantity'] = fmNumberSave($array['tong_so_luong']);  
		//Dieu chinh gia 
		$insert['adjustment'] =  fmNumberSave($array['total_adjustment']);
		#region insert
		$timeNow = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
		$insert['branchid'] = $branchid;
		$insert['description'] = $array['description'];
		$insert['customerid'] = $array['customerid'];
		$insert['dateupdate'] = $timeNow;
		$insert['userupdate'] =  $this->login->username;
		$insert['employeeid'] = $array['employeeid'];
		$insert['payments'] = $array['payments'];
		$insert['vat'] = fmNumberSave($array['vat']);
		$insert['vat_value'] = fmNumberSave($array['vat_value']);
		//$insert['uniqueid'] = $uniqueid;
		//$insert['poid'] = $poid;
		$insert['soid'] = $soidsave ;
		//Tong tien hang $array['warehouseid'];
		$insert['price'] = fmNumberSave($array['total_amount']); 
		//Tong thanh toan
		$total_tongcong = fmNumberSave($array['total_tongcong']);
		$insert['price_total'] = $total_tongcong;
		
		if(!empty($array['datecreate'])){
			$insert['datepo'] = fmDateSave($array['datecreate']);
		}
		if(!empty($array['deliverydate'])){
			$insert['deliverydate'] = fmDateSave($array['deliverydate']);
		}
		$insert['place_of_delivery'] = $array['place_of_delivery'];
		$insert['price_total'] = fmNumberSave($tontienthanhtoan);
		//$insert['stt'] = $arrAuto['stt'];
		
		//Cong no
		$payments_status = 0;
		if($price_prepay < $total_tongcong){ //Chưa thanh toán hết
			$payments_status = -1;
		}
		$insert['payments_status'] = $payments_status;
		$insert['deliverydate'] = fmDateSave($array['deliverydate']); 
		$insert['signature_x'] = $this->login->signature;
		$insert['signature_name_x'] = $this->login->fullname;
		$insert['warehouseid'] = $array['warehouseid'];
		$insert['soid'] = $array['oderpoid'];
		$this->model->table($tb['hotel_output'])
					->where('id',$orderidso)
					->update($insert);	
		#end
		$orderid = $orderidso;
		$findOrder = $this->model->table($tb['hotel_output'])	
							   ->select('id,poid')
							   ->where('id',$orderid)
							   ->find();
		$poid = $findOrder->poid;
		#region dua vao cong no //Đưa tất cả số tiền vào công nợ
		$this->model->table($tb['hotel_liabilities'])
					->where('orderid',$orderid)
					->where('liabilities',2)
					->update(array('isdelete'=>1));	
		if($payments_status == -1){
			$conNoConLai = $total_tongcong - $price_prepay;
			$insCongno = array();
			$insCongno['branchid'] = $branchid;
			$insCongno['customerid'] = $array['customerid'];
			$insCongno['orderid'] = $orderid;
			$insCongno['liabilities'] = 2;// mua hang
			$insCongno['price'] = $total_tongcong;// ban hang
			$insCongno['amount_debt'] = $conNoConLai;
			$insCongno['description'] = '';
			$insCongno['pxk'] = $poid;
			$insCongno['customerid'] = $array['customerid'];
			$insCongno['usercreate'] = $this->login->username;
			$insCongno['datecreate'] = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
			$this->model->table($tb['hotel_liabilities'])->insert($insCongno);	
			}
		#end
		#region them bang detail
		$this->model->table($tb['hotel_output_detail'])
					->where('orderid',$orderid)
					->update(array('isdelete'=>1));
		$i=1;
		foreach($queryTemp as $item){
			$insertInput = array();
			$insertInput['warehouseid'] = $array['warehouseid'];
			$insertInput['branchid'] = $branchid;
			$insertInput['customerid'] = $array['customerid'];
			$insertInput['datecreate'] = $timeNow;
			$insertInput['usercreate'] = $this->login->fullname;
			$insertInput['poid'] = $poid;
			$insertInput['orderid'] = $orderid;
			$insertInput['quantity'] = $item->quantity;
			$insertInput['unitid'] = $item->unitid;
			$insertInput['goodsid'] = $item->goodid;
			$insertInput['priceone'] = $item->price;
			$insertInput['price'] = fmNumberSave($item->quantity * $item->price);
			$insertInput['guarantee'] =  $item->guarantee;
			$insertInput['sttview'] = $i;
			
			$insertInput['discount'] = $item->discount;
			$insertInput['discount_value'] = $item->discount_value;
			$insertInput['discount_type'] = $item->discount_type;
			$insertInput['serial_number'] = $item->serial_number;
			$insertInput['cksp'] = $item->xkm;
			if(!empty($item->orderidso)){
				$insertInput['soid'] = $item->orderidso;
			}
			$this->model->table($tb['hotel_output_detail'])->insert($insertInput);
			$i++;
		}
		#end
		#region Nhập vào phiếu thu
		//if(isreceipt() == 1){//Tu dong thanh toan
		$this->model->table($tb['hotel_receipts'])
					->where('orderid',$orderid)
					->where('receipts_type',2)
					->delete();	
		$arrIS =  array();
		$arrIS['receipts_code'] = $this->createPoReceipt($branchid,$array['datecreate']);
		$arrIS['orderid'] = $orderid;
		$arrIS['branchid'] = $branchid;
		$arrIS['customerid'] = $array['customerid'];
		$arrIS['receipts_type'] = 2; //Chi thie phiếu nhập kho
		$arrIS['datepo'] = fmDateSave($array['datecreate']);
		$arrIS['payment'] = $array['payments'];
		$arrIS['amount'] =  $insert['price_prepay'];
		$arrIS['poid'] = $poid;
		$arrIS['customerid'] = $poid;
		$arrIS['usercreate'] = $this->login->username;
		$arrIS['datecreate'] = $timeNow; 
		if(!empty($arrIS['amount'])){
			$this->model->table($tb['hotel_receipts'])->insert($arrIS);
		}
		//}
		#end
		#region ghi log
		$description = 'Thêm mới: Đơn hàng '.$poid;
		$this->base_model->addAcction('Xuất bán hàng',$this->uri->segment(2),'','',$description );	
		#end
		#region Xoa du lieu bang tam
		$userid =  $this->login->id;
		$this->model->table($tb['hotel_add_temp'])
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
	/*(function edits($uniqueid,$itemList,$array,$isnew){
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
		$unitNode = $tbGoods.'.unitid as unitidNode';
		$sql = "
			SELECT st.*, g.isnegative, g.unitid AS unitidNode, g.goods_name
			FROM `$tbTemp` st
			LEFT JOIN `$tbGoods` g ON g.id = goodid
			WHERE st.id IN ($stringID)
		";
		$queryTemp = $this->model->query($sql)->execute();
		$detailidlist = 0;
		foreach($queryTemp as $item){
			 $detailidlist.= ','.$item->detailid;
		}
		#region Trừ số lượng khỏi kho
		$detialList = $this->model->table($tb['hotel_input'])
								   ->select('id,goodsid,warehouseid,quantity,unitid')
								   ->where(" orderid in ($detailidlist)")
								   ->find_all();
		foreach($detialList as $detail){
			$quantity = $detail->quantity;
			$goodsid = $detail->goodsid;
			$warehouseid = $detail->warehouseid;
			$unitid = $detail->unitid;
			//Tìm đơn vị quy đổi
			$conversion = $this->model->table($tb['hotel_goods_conversion'])
							  ->select('id,conversion')
							  ->where('goodsid',$goodsid)
							  ->where('unitid',$unitid)
							  ->find();
			if(!empty($conversion->id)){
				$quantitys = ($conversion->conversion) * $quantity;
			}
			else{
				$quantitys = $quantity;
			}
			
			$sql = "UPDATE `".$tb['hotel_inventory']."` SET `quantity`= `quantity` - '$quantitys' 
					WHERE `goodsid`='$goodsid' 
					AND `warehouseid` = '$warehouseid';";
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
		$arrGoods = array();
		$arrNegative = array();
		$arrGoodName = array();
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
				$arrAddInventorey['shelflife'] = '0000-00-00';
				$this->model->table($tb['hotel_inventory'])->insert($arrAddInventorey);
			}
			$quantity = $item->quantity;
			//S Tinh quy doi so luong
			if($item->unitidNode != $item->unitid){
				//Tinh quy doi
				$findUnit = $this->model->table($tb['hotel_goods_conversion'])
										->select('conversion')
										->where('goodsid',$item->goodid)
										->where('unitid',$item->unitid)
										->find();
				if(!empty($findUnit->conversion)){
					$quantity = ($findUnit->conversion) *  ($item->quantity);
				}
			}
			//E tinh quy doi so luon
			if(isset($arrGoods[$item->goodid])){
				$arrGoods[$item->goodid]+= ($quantity + $item->xkm);
			}
			else{
				$arrGoods[$item->goodid] = ($quantity + $item->xkm);
			}
			$arrNegative[$item->goodid] = $item->isnegative;
			$arrGoodName[$item->goodid] = $item->goods_name;
		}
		#region kiem tra so luong ton  
		$listError = '';
		foreach($arrGoods as $goodid=>$quantity){
			//So luong hien tai
			if(empty($arrNegative[$goodid])){
				$inventory = $this->model->table($tb['hotel_inventory'])
									   ->select('quantity')
									   ->where('branchid',$branchid)
									   ->where('goodsid',$item->goodid)
									   ->where('warehouseid',$array['warehouseid'])
									   ->where('isdelete',0)
									   ->find();
				$quantitynow = 0;
				if(!empty($inventory->quantity)){
					$quantitynow = $inventory->quantity;
				}
				if($quantitynow < $quantity){
					$listError.= $arrGoodName[$goodid].' + Tồn kho không đủ - Tồn:'.$quantitynow.'</br>';
				}
			}
		}
		if($listError != ''){
			$arr = array();
			$arr['uniqueid'] = 0;
			$arr['poid'] = 0;
			$arr['msg'] = ' Tồn kho không đủ: <br>'.$listError;
			return $arr;
		}
		#end
		#region Tru hang hoa trong kho
		foreach($arrGoods as $goodid=>$quantity){
			$sqlUpdate = "
				UPDATE `".$tb['hotel_inventory']."` 
				SET `quantity`= `quantity` - ".$quantity." 
				WHERE `goodsid`='".$goodid."'
				AND `branchid` = '".$branchid."'
				AND `warehouseid` = '".$array['warehouseid']."'
				;
			";
			$this->model->executeQuery($sqlUpdate);
		}
		#end
		#region Tao po
		$setuppo = $this->login->setuppo;
		$arrAuto = $this->createPoOrder($branchid,$array['datecreate']);
		if($setuppo == 0){
			$poid = $arrAuto['poid'];
		}
		else{
			$poid = $array['poid']; 
			//Kiem tra ton tai PO
			$checkPOid = $this->model->table($tb['hotel_output'])
								 ->select('poid')
								 ->where('poid',$poid )
								 ->where('branchid',$branchid )
								 ->where('isdelete',0)
								 ->find();
			if(!empty($checkPOid->poid)){
				$status['uniqueid'] = -2;
				$status['poid'] = $poid;
				$status['msg'] = 'Mã đơn hàng đã tồn tại';
				return $status; //PO đa tồn tại
			}
		}
		#end
		//Tam ung 
		$price_prepay = fmNumberSave($array['total_tamung']); 
		$tontienthanhtoan = fmNumberSave($array['total_tongcong']);
		
		$insert['price_prepay'] = fmNumberSave($array['price_prepay']);
		$insert['price_prepay_value'] =  $price_prepay;
		$insert['price_prepay_type'] =  $array['price_prepay_type'];
		//Giam gia 
		$insert['discount'] =  fmNumberSave($array['discount']);
		$insert['discount_value'] =  fmNumberSave($array['total_discount']);
		$insert['discount_type'] =  $array['discount_type'];
		$insert['quantity'] = fmNumberSave($array['tong_so_luong']);  
		//Dieu chinh gia 
		$insert['adjustment'] =  fmNumberSave($array['total_adjustment']);
		#region insert
		$timeNow = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
		$insert['branchid'] = $branchid;
		$insert['description'] = $array['description'];
		$insert['customerid'] = $array['customerid'];
		$insert['datecreate'] = $timeNow;
		$insert['usercreate'] =  $this->login->username;
		$insert['employeeid'] = $array['employeeid'];
		$insert['payments'] = $array['payments'];
		$insert['vat'] = fmNumberSave($array['vat']);
		$insert['vat_value'] = fmNumberSave($array['vat_value']);
		$insert['uniqueid'] = $uniqueid;
		$insert['poid'] = $poid;
		$insert['soid'] = $soidsave ;
		//Tong tien hang $array['warehouseid'];
		$insert['price'] = fmNumberSave($array['total_amount']); 
		//Tong thanh toan
		$total_tongcong = fmNumberSave($array['total_tongcong']);
		$insert['price_total'] = $total_tongcong;
		
		if(!empty($array['datecreate'])){
			$insert['datepo'] = fmDateSave($array['datecreate']);
		}
		if(!empty($array['deliverydate'])){
			$insert['deliverydate'] = fmDateSave($array['deliverydate']);
		}
		$insert['place_of_delivery'] = $array['place_of_delivery'];
		$insert['price_total'] = fmNumberSave($tontienthanhtoan);
		$insert['stt'] = $arrAuto['stt'];
		
		//Cong no
		$payments_status = 0;
		if($price_prepay < $total_tongcong){ //Chưa thanh toán hết
			$payments_status = -1;
		}
		$insert['payments_status'] = $payments_status;
		
		$insert['deliverydate'] = fmDateSave($array['deliverydate']); 
		$insert['signature_x'] = $this->login->signature;
		$insert['signature_name_x'] = $this->login->fullname;
		$insert['warehouseid'] = $array['warehouseid'];
		$insert['soid'] = $array['oderpoid'];
		$this->model->table($tb['hotel_output'])->insert($insert);	
		#end
		$orderid = $this->model->table($tb['hotel_output'])	
							   ->select('id')
							   ->where('uniqueid',$uniqueid)
							   ->find()->id;
		
		#region dua vao cong no //Đưa tất cả số tiền vào công nợ
		if($payments_status == -1){
			$conNoConLai = $total_tongcong - $price_prepay;
			$insCongno = array();
			$insCongno['branchid'] = $branchid;
			$insCongno['customerid'] = $array['customerid'];
			$insCongno['orderid'] = $orderid;
			$insCongno['liabilities'] = 2;// mua hang
			$insCongno['price'] = $total_tongcong;// ban hang
			$insCongno['amount_debt'] = $conNoConLai;
			$insCongno['description'] = '';
			$insCongno['pxk'] = $poid;
			$insCongno['customerid'] = $array['customerid'];
			$insCongno['usercreate'] = $this->login->username;
			$insCongno['datecreate'] = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
			$this->model->table($tb['hotel_liabilities'])->insert($insCongno);	
		}
		#end
		#region them bang detail
		$i=1;
		foreach($queryTemp as $item){
			$insertInput = array();
			$insertInput['warehouseid'] = $array['warehouseid'];
			$insertInput['branchid'] = $branchid;
			$insertInput['customerid'] = $array['customerid'];
			$insertInput['datecreate'] = $timeNow;
			$insertInput['usercreate'] = $this->login->fullname;
			$insertInput['poid'] = $poid;
			$insertInput['orderid'] = $orderid;
			$insertInput['quantity'] = $item->quantity;
			$insertInput['unitid'] = $item->unitid;
			$insertInput['goodsid'] = $item->goodid;
			$insertInput['priceone'] = $item->price;
			$insertInput['price'] = fmNumberSave($item->quantity * $item->price);
			$insertInput['guarantee'] =  $item->guarantee;
			$insertInput['sttview'] = $i;
			
			$insertInput['discount'] = $item->discount;
			$insertInput['discount_value'] = $item->discount_value;
			$insertInput['discount_type'] = $item->discount_type;
			$insertInput['serial_number'] = $item->serial_number;
			$insertInput['cksp'] = $item->xkm;
			if(!empty($item->orderidso)){
				$insertInput['soid'] = $item->orderidso;
			}
			$this->model->table($tb['hotel_output_detail'])->insert($insertInput);
			$i++;
		}
		#end
		#region Nhập vào phiếu thu
		//if(isreceipt() == 1){//Tu dong thanh toan
		$arrIS =  array();
		$arrIS['receipts_code'] = $this->createPoReceipt($branchid,$array['datecreate']);
		$arrIS['orderid'] = $orderid;
		$arrIS['customerid'] = $array['customerid'];
		$arrIS['branchid'] = $branchid;
		$arrIS['receipts_type'] = 2;
		$arrIS['datepo'] = fmDateSave($array['datecreate']);
		$arrIS['payment'] = $array['payments'];
		$arrIS['amount'] =  $insert['price_prepay'];
		$arrIS['poid'] = $poid;
		$arrIS['usercreate'] = $this->login->username;
		$arrIS['datecreate'] = $timeNow; 
		if(!empty($arrIS['amount'])){
			$this->model->table($tb['hotel_receipts'])->insert($arrIS);
		}
		//}
		#end
		#region ghi log
		$description = 'Thêm mới: Đơn hàng '.$poid;
		$this->base_model->addAcction('Xuất bán hàng',$this->uri->segment(2),'','',$description );	
		#end
		#region Xoa du lieu bang tam
		$userid =  $this->login->id;
		$this->model->table($tb['hotel_add_temp'])
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
	}*/
	function findGoodsID($id){
		$tb = $this->base_model->loadTable();
		$output = $tb['hotel_output_detail_detail'];
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
		$query = $this->model->table($tb['hotel_output_detail'])
					  ->select('*')
					  ->where('id',$id)
					  ->find();
		return $query;
	}
	function findListID($poid,$id=""){
		$tb = $this->base_model->loadTable();
		if(empty($id)){
			$and = " and ip.poid = '$poid'";
		}
		else{
			$and = " and ip.id = '$id'";
		}
		//price discount_value
		$sql = "
			 select dt.cksp, ip.vat, ip.vat_value, dt.quantity ,dt.priceone, dt.price, dt.discount, dt.discount_value, dt.discount_type, gt.goods_tye_name,
			 ip.poid as phieu_nhap_kho, ip.datepo, ip.stt, ip.customerid, ip.description, ip.price as t_price, ip.price_total, ip.price_prepay, ip.price_prepay_value, ip.price_prepay_type, ip.discount as t_discount, ip.discount_value as t_discount_value, ip.discount_type as t_discount_type, ip.adjustment, ip.payments, wh.warehouse_name, g.goods_name, g.goods_code ,unt.unit_name, ip.soid, g.goods_type, dt.id,
			 c.customer_code, c.customer_name, c.phone, c.fax, c.email, c.address, ip.signature_x, ip.signature_name_x
			 from `".$tb['hotel_output_detail']."` dt
			 left join `".$tb['hotel_output']."` ip on ip.id = dt.orderid
			 left join `".$tb['hotel_goods']."` g on g.id = dt.goodsid
			 left join `".$tb['hotel_unit']."` unt on unt.id = dt.unitid
			 left join `".$tb['hotel_goods_type']."` gt on gt.id = g.goods_type
			 left join `".$tb['hotel_customer']."` c on c.id = ip.customerid 
			 left join `".$tb['hotel_warehouse']."` wh on wh.id = ip.warehouseid
			 where dt.isdelete = 0
			 $and
			 order by dt.sttview asc
		 "; 
		 $query = $this->model->query($sql)->execute();
		 return $query;
		//t_discount_type ponumber poid goods_type customer_name
		/*$sql = "
			SELECT oo.id, so.vat, so.signature_x, so.signature_name_x, so.place_of_delivery, so.stt, so.poid, so.datepo, oo.sttview, oo.goodsid, oo.branchid, sum(oo.quantity) as quantity, oo.priceone, oo.price, sum(oo.discount) as discount, so.description, sum(oo.cksp) as cksp, oo.discount_value, oo.discount_type,
			c.customer_code, c.customer_name, c.phone, c.fax, c.email, c.address,
			g.goods_code, g.goods_code2, g.goods_name, g.goods_type, gt.goods_tye_name,
			un.unit_name,  so.discount_value as t_discount_value
			FROM `".$tb['hotel_output']."` so
			LEFT join `".$tb['hotel_output_detail']."` oo on oo.orderid = so.id
			left join `".$tb['hotel_customer']."` c on c.id = so.customerid 
			left join `".$tb['hotel_goods']."` g on g.id = oo.goodsid
			left join `".$tb['hotel_goods_type']."` gt on gt.id = g.goods_type
			left join `".$tb['hotel_unit']."` un on un.id = g.unitid and un.isdelete = 0
			where so.isdelete = 0
			and oo.isdelete = 0
			and g.isdelete = 0
			$and
			group by oo.goodsid
			;
		 ";
		return $this->model->query($sql)->execute();;*/
	}
	function findOrder($id){
		$tb = $this->base_model->loadTable();
		$query = $this->model->table($tb['hotel_output'])
					  ->select('*')
					  ->where('id',$id)
					  ->where('isout',0)
					  ->find();
		return $query;
	 }
	function deletes($id, $array){
		$tb = $this->base_model->loadTable();
		$this->db->trans_start();
		$result = $this->model->table($tb['hotel_output'])
					   ->select('id,uniqueid')
					   ->where("id in ($id)")
					   ->find();	
		$orderid =  $result->id;
		$query = $this->model->table($tb['hotel_output_detail'])
					   ->select('orderid,id,quantity,warehouseid,branchid,companyid')
					   ->where("orderid in (".$orderid.")")
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
		$this->model->table($tb['hotel_output'])
					   ->where("id in ($orderid)")
					   ->update($array);
					   
		$this->model->table($tb['hotel_output_detail'])
					   ->where("$orderid in ($$orderid)")
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
				$arrAdd['price'] = $findgoods->sale_price;
				$arrAdd['discount'] = $findgoods->discountsales_dly;
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
				if($findgoods->discountsales_type_dly == 1){//Tinh phần trăm
					$ptr = $findgoods->discountsales_dly * $findgoods->sale_price / 100;
					$arrAdd['discount_value'] = fmNumberSave($ptr);
				}
				else{
					$arrAdd['discount_value'] = $findgoods->discountsales_dly;
				}
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
				SELECT  sat.id as satid, if(sat.discount_type=1,'%','') as satdiscount_type, sat.discount_type as discount_types, sat.discount_value, sat.xkm,sat.serial_number, sat.discount, sat.uniqueid, sat.stype, s.goods_code, s.id, s.img,s.goods_name,un.unit_name, s.shelflife, s.discountsales_dly,s.discountsales_type_dly, sat.guarantee as guaranteedate,
				if(sat.quantity is not null,sat.quantity,1) as quantity,
				if(sat.price is not null,sat.price,s.sale_price) as sale_price,
				if(sat.discount is not null,sat.discount,s.discountsales_dly) as discount, s.isserial, sat.vat, sat.price_total, sat.discount_value,
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
				un.unit_name, un.id as unitid, sat.unitid as satunitid, sat.detailid
				FROM `".$tb['hotel_add_temp']."` sat
				left join `".$tb['hotel_goods']."` s on s.id = sat.goodid
				left join `".$tb['hotel_unit']."` un on un.id = s.unitid
				where sat.userid = '$userid'
				and sat.contronller = '".$this->ctr ."'
				and sat.isnew = '$isnew'
				and s.isdelete = 0
				and un.isdelete = 0
				$and
				order by sat.datecreate asc
			 ";
		$query = $this->model->query($sql)->execute();
		return $query;
	}
	function getTempGoodSO($so){
		$tb = $this->base_model->loadTable();
		$skey = $this->login->skey;
		$sql = "
				SELECT sat.discount, sat.uniqueid, '0' as stype, sat.quantity, s.goods_code, s.id, s.img,DES_DECRYPT(s.goods_name,'".$skey."') as goods_name,
				 un.unit_name, sat.price, sat.priceone, s.shelflife
				,gg.group_code, gg.group_name, gd.exchang, sat.guarantee as guaranteedate,
				(
					select op.quantity
					from `".$tb['hotel_output_detail']."` op
					where op.isdelete = 0
					and op.socode = sat.poid
					and op.goodsid = sat.goodsid
				) as quantityexport, '' as serial_number
				FROM `".$tb['hotel_orders_detail']."` sat
				left join `".$tb['hotel_goods']."` s on s.id = sat.goodsid
				left join `".$tb['hotel_unit']."` un on un.id = s.unitid
				left join `".$tb['hotel_goods_group_detail']."` gd on gd.goodid = s.id and gd.isdelete = 0
				left join `".$tb['hotel_goods_group']."` gg on gg.id = gd.groupid and gg.isdelete = 0
				where s.isdelete = 0
				and un.isdelete = 0
				and sat.poid = '$so'
				and sat.isdelete = 0
				group by sat.goodsid 
                having (quantity - quantityexport > 0 or quantityexport is null)
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
				$arrAdd['isnew'] = $isnew;
				$arrAdd['poid'] = $item->poid;
				$arrAdd['orderidso'] = $item->orderid;
				$arrAdd['detailid'] = $item->detailid;
				$arrAdd['uniqueid'] = $item->uniqueid;
				$arrAdd['unitid'] = $item->unitid;
				$arrAdd['goodid'] = $item->goodsid;
				$arrAdd['quantity'] = $item->quantity;
				$arrAdd['price'] = $item->buy_price;
				$arrAdd['price_total'] = $item->price;
				$arrAdd['discount'] = $item->discount;
				$arrAdd['discount_value'] = $item->discount_value;
				$arrAdd['discount_type'] = $item->discount_type;
				$arrAdd['guarantee'] = $item->guaranteeOut;
				$arrAdd['xkm'] = $item->cksp;
				$arrAdd['vat'] = $item->vat;
				$arrAdd['soid'] = $item->soid;
				if(!empty($item->serial_number)){
					$arrAdd['serial_number'] = $item->serial_number;
				}
				if(!empty($item->orderid)){
					$arrAdd['orderidso'] = $item->orderid;
				}
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
		WHERE table_name='".$tb['hotel_output']."'; 
		";
		$query = $this->model->query($sql)->execute();
		$obj = new stdClass();
		foreach($query as $item){
			$clm = $item->column_name;
			$obj->$clm = null;
		}
		return $obj;
	}
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
		 $output = $tb['hotel_output_detail'];
		 $createorders = $tb['hotel_output'];
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
	function createPoReceipt($branchid,$datecreate){
		$tb = $this->base_model->loadTable();
		$yearDay = fmMonthSave($datecreate);
		$configs = configs();
		if($configs['cfpt_type'] == 0){
			$checkPOid = $this->model->table($tb['hotel_receipts'])
				 ->select('receipts_code')
				 ->where("datepo like '$yearDay%'")
				 ->where('branchid',$branchid)
				 ->where('isdelete',0)
				 ->order_by('id','DESC')
				 ->find();
			if(!empty($checkPOid->receipts_code)){
				$receipts_code = str_replace($configs['cfpt'],'',$checkPOid->receipts_code);
				$poc = trim($configs['cfpt']).((float)$receipts_code + 1);
			}
			else{
				if(empty($configs['cfpt_default'])){
					$configs['cfpt_default'] = '00001';
				}
				$poc = trim($configs['cfpt']).date('ym',strtotime($yearDay)).trim($configs['cfpt_default']);
			}
		}
		else{
			$checkPOid = $this->model->table($tb['hotel_receipts'])
				 ->select('receipts_code')
				 ->where('branchid',$branchid)
				 ->where('isdelete',0)
				 ->order_by('id','DESC')
				 ->find();
			if(!empty($checkPOid->receipts_code)){
				$receipts_code = str_replace($configs['cfpt'],'',$checkPOid->receipts_code);
				$poc = trim($configs['cfpt']). $this->base_model->createPO($configs['cfpt_default'], $receipts_code);
			}
			else{
				if(empty($configs['cfpt_default'])){
					$configs['cfpt_default'] = '00001';
				}
				$poc = trim($configs['cfpt']).trim($configs['cfpt_default']);
			}
		}
		return $poc;
	}
	function createPoOrder($branchid,$datecreate){
		$tb = $this->base_model->loadTable();
		$yearDay = fmMonthSave($datecreate);
		$configs = configs();
		if($configs['cfpx_type'] == 0){		
			$checkPOid = $this->model->table($tb['hotel_output'])
					 ->select('poid,stt')
					 ->where("datepo like '$yearDay%'")
					 ->where('branchid',$branchid)
					 ->where('isdelete',0)
					 ->order_by('id','DESC')
					 ->find();
			if(!empty($checkPOid->poid)){
				$poid = str_replace($configs['cfpx'],'',$checkPOid->poid);
				$poc = trim($configs['cfpx']).((float)$poid + 1);
			}
			else{
				if(empty($configs['cfpx_default'])){
					$configs['cfpx_default'] = '00001';
				}
				$poc = trim($configs['cfpx']).date('ym',strtotime($yearDay)).trim($configs['cfpx_default']);
			}
		}
		else{
			$checkPOid = $this->model->table($tb['hotel_output'])
					 ->select('poid,stt')
					 ->where('branchid',$branchid)
					 ->where('isdelete',0)
					 ->order_by('id','DESC')
					 ->find();
			if(!empty($checkPOid->poid)){
				$poid = str_replace($configs['cfpx'],'',$checkPOid->poid);
				if(empty($configs['cfpx_default'])){
					$configs['cfpx_default'] = '00001';
				}
				$poc = trim($configs['cfpx']). $this->base_model->createPO($configs['cfpx_default'], $poid);
			}
			else{
				if(empty($configs['cfpx_default'])){
					$configs['cfpx_default'] = '00001';
				}
				$poc = trim($configs['cfpx']).trim($configs['cfpx_default']);
			}
		}
		$checkSTT = $this->model->table($tb['hotel_output'])
					 ->select('poid,stt')
					 ->where("datepo like '$yearDay%'")
					 ->where('branchid',$branchid)
					 ->where('isdelete',0)
					 ->order_by('id','DESC')
					 ->find();
		if(!empty($checkSTT->stt)){
			$stt = (float)$checkSTT->stt;
		}
		else{
			$stt = '0';
		}
		$array = array();
		$array['poid'] =  $poc;
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
			FROM `".$tb['hotel_orders_detail']."`  sat
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
		$detail = $this->model->table($tb['hotel_output_detail'])
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
		//Cộng trong kho so luong quy doi
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
		$sql = "UPDATE `".$tb['hotel_inventory']."` SET `quantity`= `quantity` + '$quantitys' 
					WHERE `goodsid`='$goodid' 
					AND `warehouseid` = '$warehouseid';";
		$this->model->executeQuery($sql);
		//Xóa detail 
		$array = array();
		$array['isdelete'] = 1;
		$array['userupdate'] = $this->login->username;
		$array['dateupdate'] = $timeNow;
		$this->model->table($tb['hotel_output_detail'])
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
	function updateSerial($goodid,$serial_number,$isnew){
		$userid =  $this->login->id;
		$tb = $this->base_model->loadTable();
		$this->model->table($tb['hotel_add_temp'])
						  ->where('contronller',$this->ctr)
						  ->where('userid',$userid)
						  ->where('goodid',$goodid)
						  ->where('isnew',$isnew)
						  ->update(array('serial_number'=>$serial_number));
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
		$array['unitid'] = $unitid;
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
						  ->select('sum(quantity * price) as price, sum(discount_value) as discount')
						  ->where('contronller',$this->ctr)
						  ->where('userid',$userid)
						  ->where('isnew',$isnew)
						  ->find();
		return $query;
	}
	function findListUniqueID($orderid){
		$tb = $this->base_model->loadTable();
		$branchid = $this->login->branchid;
		$sql = "
			select '' as soid,sg.id, '0' stype ,si.serial_number , si.goodsid, sg.sale_price ,si.quantity, si.priceone as buy_price, sg. sale_price as price_out, sg.goods_code, sg.goods_name , su.unit_name, sg.guarantee as isguarantee, if(si.guarantee = '0000-00-00',0,si.guarantee) as guaranteedate, sg.guarantee, si.orderid as uniqueid, si.guarantee as guaranteeOut, si.discount, si.discount_value, si.discount_type,si.cksp,
			(
				SELECT oc.vat
				FROM `".$tb['hotel_output']."` oc
				where oc.id = si.orderid
				and oc.branchid = '$branchid'
				limit 1
			) as vat, si.unitid, si.id as detailid, si.orderid, si.poid, si.price
			from `".$tb['hotel_output_detail']."` si
			left join `".$tb['hotel_goods']."` sg on si.goodsid = sg.id
			left join `".$tb['hotel_unit']."` su on su.id = sg.unitid
			where si.orderid = '$orderid'
			and si.isdelete = 0
			order by si.sttview asc
		"; 
		return $this->model->query($sql)->execute();
	}
	function findListOder($orderid){
		$tb = $this->base_model->loadTable();
		$branchid = $this->login->branchid;
		$sql = "
			select '' as soid,sg.id, '0' stype ,si.serial_number , si.goodsid, sg.sale_price ,si.quantity, si.priceone as buy_price, sg. sale_price as price_out, sg.goods_code, sg.goods_name , su.unit_name, sg.guarantee as isguarantee, if(si.guarantee = '0000-00-00',0,si.guarantee) as guaranteedate, sg.guarantee, si.orderid as uniqueid, si.guarantee as guaranteeOut, si.discount, si.discount_value, si.discount_type,si.cksp,
			(
				SELECT oc.vat
				FROM `".$tb['hotel_output']."` oc
				where oc.id = si.orderid
				and oc.branchid = '$branchid'
				limit 1
			) as vat, si.unitid, si.id as detailid, si.orderid, si.poid, si.price, 
			so.customerid, so.datepo as datecreate, so.deliverydate, so.place_of_delivery, so.description, so.employeeid
			from `".$tb['hotel_orders_detail']."` si
			left join `".$tb['hotel_orders']."` so on so.id = si.orderid
			left join `".$tb['hotel_goods']."` sg on si.goodsid = sg.id
			left join `".$tb['hotel_unit']."` su on su.id = sg.unitid
			where si.orderid = '$orderid'
			and si.isdelete = 0
			order by si.sttview asc
		"; 
		return $this->model->query($sql)->execute();
	}
	/*function findListSO($soid){
		$tb = $this->base_model->loadTable();
		$branchid = $this->login->branchid;
		$sql = "
			select si.id, si.poid as soid, oc.poid , sg.id, '0' stype ,si.serial_number , si.goodsid, sg.sale_price ,si.quantity, si.price as totalPrice, si.priceone as buy_price, sg. sale_price as price_out, sg.goods_code, sg.goods_name, su.unit_name, sg.guarantee as isguarantee, if(si.guarantee = '0000-00-00',0,si.guarantee) as guaranteedate, sg.guarantee, oc.uniqueid, si.guarantee as guaranteeOut, si.discount, si.discount_value, si.discount_type,si.cksp, si.unitid, si.orderid,
			oc.vat, oc.customer_id, oc.employeeid, oc.datepo, oc.deliverydate, oc.place_of_delivery, oc.description, oc.payments, oc.price_prepay
			from `".$tb['hotel_orders_detail']."` si
			left join `".$tb['hotel_orders']."` oc on oc.id = si.orderid
			left join `".$tb['hotel_goods']."` sg on si.goodsid = sg.id
			left join `".$tb['hotel_unit']."` su on su.id = sg.unitid
			where si.isdelete = 0
			and oc.isdelete = 0
			and oc.id = '$soid'
			and oc.id not in (
				select occ.soid
				from `".$tb['hotel_output']."` occ 
				left join `".$tb['hotel_output_detail']."` ss on occ.id = ss.orderid
				where occ.soid = oc.id
				and occ.isdelete = 0
				and ss.isdelete = 0
				and ss.goodsid = si.goodsid
			) 
			order by si.sttview asc
		"; //echo '<pre>';print_r($sql); exit;
		return $this->model->query($sql)->execute();
	}*/
	function findOrderUniqueid($orderid){
		$tb = $this->base_model->loadTable();
		$query = $this->model->table($tb['hotel_output'])
					  ->select('*')
					  ->where('id',$orderid)
					  ->find();
		return $query;
	}
	function findOrderUniqueidSO($orderid){
		$tb = $this->base_model->loadTable();
		$query = $this->model->table($tb['hotel_orders'])
					  ->select('*')
					  ->where('id',$orderid)
					  ->find();
		return $query;
	}
	function findOrderSO($so){
		$tb = $this->base_model->loadTable();
		$query = $this->model->table($tb['hotel_orders'])
					  ->select('*')
					  ->where('poid',$so)
					  ->find();
		return $query;
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
}