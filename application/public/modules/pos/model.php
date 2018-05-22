<?php
/**
 * @author 
 * @copyright 2016
 */
 class PosModel extends CI_Model{
	function __construct(){
		parent::__construct('');
		$this->login = $this->site->getSession('login');
		$this->ctr = 10;
	}
	function getGroupType(){
		$tb = $this->base_model->loadTable();
		$query = $this->model->table($tb['hotel_goods_type'])
							 ->where('isdelete',0)
							 ->order_by('goods_tye_name','asc')
							 ->find_all();
		return $query;
	}
	function getSearchSale($search){
		return '';
	}
	function getListSale($search,$page,$rows){
		$searchs = $this->getSearchSale($search);
		$tb = $this->base_model->loadTable();
		$skey = $this->login->skey;
		$tb_goods = $tb['hotel_goods'];
		$tb_goods_type = $tb['hotel_goods_type'];
		$tb_unit = $tb['hotel_unit'];
		$companyid = $this->login->companyid;
		$branchid = $this->login->branchid;
		$sql = "
			SELECT c.isnegative, c.shelflife,c.isserial,c.quantitymin,c.img,c.goods_code, c.goods_code2 , 
				c.goods_type, c.id, c.madein, c.discountsales, c.discounthotel_type, c.unitid, c.sale_price, c.buy_price, c.companyid, c.description, 
				DES_DECRYPT(c.goods_name,'$skey') as goods_name, vat,
				ut.unit_name,
				(
					select sum(i.quantity) as quantity
					from `".$tb['hotel_inventory']."` i
					where i.isdelete = 0
					and i.companyid = '".$companyid."'
					and i.branchid = '".$branchid ."'
					and i.goodsid = c.id
				) quantity,
				(
					select i.goodid
					from `".$tb['hotel_add_temp']."` i
					where i.contronller = '".$this->ctr ."'
					and i.branchid = '".$branchid."'
					and i.goodid = c.id
					limit 1
				) checkin
				FROM `$tb_goods` AS c
				LEFT JOIN `$tb_unit` ut on ut.id = c.unitid and ut.isdelete = 0 
				WHERE c.isdelete = 0
		";
		$sql.= ' limit '.$page.','.$rows;
		$query = $this->model->query($sql)->execute();
		return $query;
	}
	function getSalesOder(){
		$tb = $this->base_model->loadTable();
		$sql = "
			select *
				from(
				SELECT od.goodsid, od.poid, od.quantity, 
				( 
					select outs.quantity 
					from `".$tb['hotel_output']."` outs 
					where outs.isdelete = 0 
					and outs.socode = od.poid 
					and outs.goodsid = od.goodsid
				) as quantityout
				 FROM `".$tb['hotel_output_createorders_order']."` coo 
				 LEFT JOIN `".$tb['hotel_output_order']."` od on coo.uniqueid = od.uniqueid
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
	function getSearch($searchs){
		foreach($searchs as $key=>$val){
			$search[$key] = addslashes($val);
		}
		$sql = "";
		$companyid = $this->login->companyid;
		$branchid = $this->login->branchid;
		
		$sql.= " and c.companyid = '".$companyid."' ";	
		if($this->login->grouptype == 4){
			$sql.= " and c.usercreate = '".$this->login->username ."' ";	
		}
		if(!empty($branchid)){
			$sql.= " and c.branchid in (".$branchid.") ";	
		}
		if(!empty($search['customer_name'])){
			$sql.= " and DES_DECRYPT(c.customer_name,'".$this->login->skey ."') like '%".$search['customer_name']."%' ";	
		}
		if(!empty($search['customer_type'])){
			$sql.= " and c.customer_type in (".$search['customer_type'].") ";	
		}
		if(!empty($search['soid'])){
			$sql.= " and c.soid in (".$search['soid'].") ";	
		}
		if(!empty($search['phone'])){
			$sql.= " and DES_DECRYPT(c.phone,'".$this->login->skey ."')  like '%".$search['customer_name']."%' ";	
		}
		if(!empty($search['formdate'])){
			$sql.= " and c.datecreate <= '".date('Y-m-d',strtotime($search['formdate']))."' ";	
		}
		if(!empty($search['todate'])){
			$sql.= " and c.datecreate >= '".date('Y-m-d',strtotime($search['todate']))."' ";	
		}
		return $sql;
	}
	function getList($search,$page,$rows){
		$tb = $this->base_model->loadTable();
		$searchs = $this->getSearch($search);
		$sql = "SELECT c.*, w.warehouse_name, DES_DECRYPT(cm.customer_name,'".$this->login->skey ."')  as cmname,DES_DECRYPT(cm.phone,'".$this->login->skey ."') as cmphone,DES_DECRYPT(cm.address,'".$this->login->skey ."') as cmaddress,
		DES_DECRYPT(cm.email,'".$this->login->skey ."') as cmemail, cm.phone as phones, sum(so.discount) discount
				FROM `".$tb['hotel_output_createorders']."`  AS c
				LEFT JOIN `".$tb['hotel_output']."` so on so.uniqueid = c.uniqueid
				LEFT JOIN `".$tb['hotel_warehouse']."` w on w.id = c.warehouseid and w.isdelete = 0
				LEFT JOIN `".$tb['hotel_customer']."` cm on cm.id = c.customer_id and cm.isdelete = 0
				WHERE c.isdelete = 0 
				and so.isdelete = 0
				$searchs
				group by c.uniqueid
				";
		if(empty($search['order'])){
			$sql.= ' ORDER BY c.id DESC ';
		}
		else{
			$sql.= ' ORDER BY '.$search['order'].' '.$search['index'].' ';
		}
		if($page != 0 && $rows != 0){
			$sql.= ' limit '.$page.','.$rows;
		}
		$query = $this->model->query($sql)->execute();
		return $query;
	}
	function getTotal($search){
		$tb = $this->base_model->loadTable();
		$searchs = $this->getSearch($search);
		$sql = " 
		SELECT count(1) total
		FROM(
		SELECT count(1) total
		FROM `".$tb['hotel_output_createorders']."` AS c
		LEFT JOIN `".$tb['hotel_output']."` so on so.uniqueid = c.uniqueid
		LEFT JOIN `".$tb['hotel_warehouse']."` w on w.id = c.warehouseid and w.isdelete = 0
		LEFT JOIN `".$tb['hotel_customer']."` cm on cm.id = c.customer_id and cm.isdelete = 0
		WHERE c.isdelete = 0 
		and so.isdelete = 0
		$searchs	
		group by c.uniqueid
		) t
		";
		$query = $this->model->query($sql)->execute();
		return $query[0]->total;	
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
	function saves($uniqueid,$arrays,$listQuantity,$description,$customer_type,$listPriceone,$guarantee,$discount,$sttview,$serial){
		foreach($arrays as $key=>$val){
			if($key == 'input_list'){ continue; }
			$array[$key] = addslashes($val); 
		}
		$tb = $this->base_model->loadTable();
		$timeNow  = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
		$companyid = $this->login->companyid;
		$branchid = $this->login->branchid;
		$array['companyid'] = $companyid;
		$array['branchid'] = $branchid;
		$array['employeeid'] = $this->login->id;
		
		$inputList = json_decode($listQuantity,true); //Số lương
		$inputPriceone =  json_decode($listPriceone,true);
		$discountList =  json_decode($discount,true);
		$sttviewList =  json_decode($sttview,true);
		$guaranteeList = json_decode($guarantee,true);
		$serial = json_decode($serial,true);
		$this->db->trans_start();
		//Kiểm tra số lượng tồn kho
		$str_goodsid = '';
		foreach($inputList as $k=>$v){
			$str_goodsid.= ','.$k;
		}
		$str_goodsid = substr($str_goodsid,1);
		#region Kiem tra ma hang co trong kho chu
		$sql = "
			SELECT i.id, i.goodsid, if(i.shelflife = '0000-00-00','3000-12-31',i.shelflife) as  shelflife, i.quantity, concat(g.goods_code,' - ',DES_DECRYPT(g.goods_name,'".$this->login->skey ."')) as goods_name, g.isnegative
			FROM `".$tb['hotel_inventory']."` i
			left join `".$tb['hotel_goods']."` g on g.id = i.goodsid
			where i.companyid = '".$companyid."'
			and i.branchid = '".$branchid."'
			and i.goodsid in (".$str_goodsid.")
			and i.warehouseid = '".$array['warehouseid']."'
			and i.isdelete = 0
			and g.isdelete = 0
		";
		$queryCheckInventory = $this->model->query($sql)->execute();
		$arrInventoryGoods = array();//Mang ton kho
		$arrGoodCode = array();
		$arrGoodCodeNegative = array();
		foreach($queryCheckInventory as $item){
			$arrGoodCode[$item->goodsid] = $item->goods_name;
			$arrGoodCodeNegative[$item->goodsid] = $item->isnegative;
			$arrInventoryGoods[$item->goodsid] = (float)$item->quantity;
		}
		foreach($inputList as $gid=>$q){
			if(!isset($arrGoodCode[$gid])){//Chua co add vao voi so sluong = 0
				$arrAddInventorey = array();
				$arrAddInventorey['companyid'] = $companyid; 
				$arrAddInventorey['branchid'] = $branchid; 
				$arrAddInventorey['warehouseid'] = $array['warehouseid']; 
				$arrAddInventorey['goodsid'] = $gid;
				$arrAddInventorey['quantity'] = 0;
				$arrAddInventorey['shelflife'] = '0000-00-00';
				$this->model->table($tb['hotel_inventory'])->insert($arrAddInventorey);
			}
		}
		#end
		$listError = '';
		foreach($arrGoodCode as $goodid=>$goods_name){ 
			$sl_tonkh = (int)$arrInventoryGoods[$goodid];
			$sl_ban = (int)$inputList[$goodid];
			if($arrGoodCodeNegative[$goodid] == 0){ //=1 cho phep xuat am
				if($sl_ban > $sl_tonkh){
					$listError.= $goods_name .' - Tồn kho: '.$sl_tonkh.'</br>';
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
		//Trừ hàng trong kho -> Tru theo han su dung -> han su dung thap thi tru truoc
		foreach($inputList as $kk=>$suquantity){
			$sqlUpdate = "
				UPDATE `".$tb['hotel_inventory']."` 
				SET `quantity`= `quantity` - ".fmNumberSave($suquantity)." 
				WHERE `goodsid`='".$kk."'
				AND `warehouseid` = '".$array['warehouseid']."'
				AND `branchid` = '".$this->login->branchid ."'
				;
			";
			$this->model->executeQuery($sqlUpdate);
		}
		#region Tao po
		$setuppo = $this->login->setuppo;
		$arrAuto = $this->createPoOrder($branchid,$array['datecreate']);
		if($setuppo == 0){
			$poid = $arrAuto['poid'];
		}
		else{
			$poid = $array['poid']; 
			//Kiem tra ton tai PO
			$checkPOid = $this->model->table($tb['hotel_output_createorders'])
								 ->select('poid')
								 ->where('poid',$poid )
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
		//$uniqueid = $this->base_model->getUniqueid();
		//Lay so luong
		$totalQuantity = 0;
		$totalPrice = 0;
		foreach($inputList as $goodsid=>$input){
			$discount = fmNumberSave($discountList[$goodsid]);
			$input = fmNumberSave($input);
			$totalQuantity+=  $input;
			$priceone = fmNumberSave($inputPriceone[$goodsid]);
			$totalPrice+= (($input * $priceone) - $discount);
		}
		//Tinh them tien thue
		$vat = $array['vat'];
		$totalVat = rNumber($totalPrice * $vat /100);
		$price_total = $totalPrice + $totalVat;
		
		$price_prepay =  str_replace(',','',$array['price_prepay']);
		$price_prepay =  fmNumberSave($price_prepay);
		$price_total =  fmNumberSave($price_total);
		$insert = array();
		if(!empty($array['price_prepay'])){//Co tam ung
			if($array['percent'] == 1){//Tinh %
				$insert['percent_value'] = fmNumberSave($price_prepay);
				$prepays = fmNumberSave($price_prepay) * fmNumberSave($price_total) / 100; 
				$insert['price_prepay'] = $prepays;
				if($insert['percent_value'] < 100){
					$insert['payments_status'] = -1; 
				}
			}
			else{//Tiem mat
				$insert['price_prepay'] = fmNumberSave($price_prepay);
				if($insert['price_prepay'] < fmNumberSave($totalPrice)){
					$insert['payments_status'] = -1; 
				}
			}
		}
		#region insert vao table serial
		if(count($serial) > 0){
			foreach($serial as $goodsid=>$sn){ 
				$arrSN = array();
				$arrSN['goodsid'] = $goodsid;
				$arrSN['uniqueid'] = $uniqueid;
				$arrSN['sn'] = $sn;
				$arrSN['usercreate'] = $this->login->username;
				$arrSN['datecreate'] = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
				if(!empty($sn)){
					$this->model->table($tb['hotel_seial'])->insert($arrSN);
				}
			}
		}	
		#end
		// Insert vao bang hoa don nhap - hotel_input_createorders
		$array['usercreate'] = $this->login->username;
		$insert['companyid'] = $companyid;
		$insert['branchid'] = $branchid;
		$insert['description'] = $description;
		if($customer_type == 1){ //KH Đại lý
			$insert['customer_id'] = $array['customerid'];
		}
		else{ // Khách hàng lẽ
			$insert['customer_name'] = $array['customer_name'] ;
			$insert['customer_phone'] = $array['customer_phone'];
			$insert['customer_address'] = $array['customer_address'] ;
			$insert['customer_email'] = $array['customer_email'];
		}
		$insert['datecreate'] = $timeNow;
		$insert['usercreate'] = $array['usercreate'];
		$insert['employeeid'] = $array['employeeid'];
		$insert['payments'] = $array['payments'];
		$insert['vat'] = (float)$array['vat'];
		$insert['customer_type'] = $customer_type;
		$insert['uniqueid'] = $uniqueid;
		$insert['poid'] = $poid;
		$insert['quantity'] = fmNumberSave($totalQuantity);
		$insert['price'] = fmNumberSave($totalPrice);
		$insert['price_total'] = fmNumberSave($price_total);
		$insert['isout'] = 1;
		$insert['stt'] = $arrAuto['stt'];
		$insert['datepo'] = fmDateSave($array['datecreate']);
		$insert['place_of_delivery'] = $array['place_of_delivery'];
		$insert['deliverydate'] = fmDateSave($array['deliverydate']); 
		$insert['signature_x'] = $this->login->signature;
		$insert['signature_name_x'] = $this->login->fullname;
		$insert['warehouseid'] = $array['warehouseid'];
		$this->model->table($tb['hotel_output_createorders'])->insert($insert);
		// Insert vao bang chi tiet nhap - hotel_input
		$insertInput = array();
		$insertInput['warehouseid'] = $array['warehouseid'];
		$insertInput['companyid'] = $companyid;
		$insertInput['branchid'] = $branchid;
		$insertInput['datecreate'] = $array['datecreate'] ;
		$insertInput['usercreate'] = $array['usercreate'];
		$insertInput['poid'] = $poid;
		$insertInput['uniqueid'] = $uniqueid;
		//Get Price
		$goodlist = '';
		foreach($inputList as $goodsid=>$input){ 
			$goodlist.= ','.$goodsid;
		}
		$goodlist = substr($goodlist,1);
		$arrPrice = $this->model->table($tb['hotel_goods'])
					->where("id in ($goodlist)")
					->find_combo('id','buy_price');
		//$inputPriceone 
		foreach($inputList as $goodsid=>$input){
			$priceone = str_replace(',','',$inputPriceone[$goodsid]);
			$insertInput['quantity'] = fmNumberSave($input);
			$insertInput['goodsid'] = $goodsid;
			$insertInput['priceone'] = fmNumberSave($priceone);
			$insertInput['price'] = fmNumberSave($priceone * $input);
			$guaranteesave = '0000-00-00';
			if(isset($guaranteeList[$goodsid]) && !empty($guaranteeList[$goodsid])){
				$guaranteesave = fmDateSave($guaranteeList[$goodsid]);
			}
			if(isset($serial[$goodsid]) && !empty($serial[$goodsid])){
				$insertInput['serial_number'] = $serial[$goodsid];
			}
			$insertInput['sttview'] = $sttviewList[$goodsid];
			$insertInput['discount'] = $discountList[$goodsid];
			$insertInput['guarantee'] =  $guaranteesave;
			$this->model->table($tb['hotel_output'])->insert($insertInput);
		}
		#region Nhập vào phiếu thu
		$arrIS =  array();
		$arrIS['receipts_code'] = $this->createPoReceipt($branchid,$array['datecreate']);
		$arrIS['uniqueid'] = $uniqueid;
		$arrIS['companyid'] = $companyid;
		$arrIS['branchid'] = $branchid;
		$arrIS['receipts_type'] = 1;
		$arrIS['datepo'] = fmDateSave($array['datecreate']);
		$arrIS['payment'] = $array['payments'];
		if(empty($insert['price_prepay'])){ 
			$arrIS['amount'] =  fmNumberSave($price_total);
		}
		else{
			$arrIS['amount'] = $insert['price_prepay'];
		}
		$arrIS['poid'] = $poid;
		$arrIS['usercreate'] = $array['usercreate'];
		$arrIS['datecreate'] = $timeNow;
		$this->model->table($tb['hotel_receipts'])->insert($arrIS);
		#end
		#region Xoa du lieu bang tam
		$userid =  $this->login->id;
		$this->model->table($tb['hotel_add_temp'])
					->where('contronller',$this->ctr)
					->where('userid',$userid)
					->delete();	
		#end
		$this->db->trans_complete();
		$arr = array();
		$arr['uniqueid'] = $uniqueid;
		$arr['poid'] = $poid;
		$arr['msg'] = '';
		return $arr;
	}
	function edits($uniqueid,$arrays,$listQuantity,$description,$customer_type,$listPriceone,$guarantee,$discount,$sttview,$serial){
		foreach($arrays as $key=>$val){
			if($key == 'input_list'){ continue; }
			$array[$key] = addslashes($val); 
		}
		$tb = $this->base_model->loadTable();
		$timeNow  = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
		$companyid = $this->login->companyid;
		$branchid = $this->login->branchid;
		$array['companyid'] = $companyid;
		$array['branchid'] = $branchid;
		$array['employeeid'] = $this->login->id;
		
		$inputList = json_decode($listQuantity,true); //Số lương
		$inputPriceone =  json_decode($listPriceone,true);
		$discountList =  json_decode($discount,true);
		$sttviewList =  json_decode($sttview,true);
		$guaranteeList = json_decode($guarantee,true);
		$serial = json_decode($serial,true);

		$this->db->trans_start();
		#region so da xuat
		$sqlOut = "
			select oc.soid, oc.socode, ot.goodsid,ot.quantity,ot.branchid,ot.warehouseid,ot.poid,oc.stt 
			from `".$tb['hotel_output']."` ot
			left join `".$tb['hotel_output_createorders']."` oc on oc.uniqueid = ot.uniqueid
			where oc.isdelete = 0
			and oc.branchid = '".$branchid."'
			and oc.uniqueid = '".$uniqueid."'
			and ot.isdelete = 0
		";
		$queryOut = $this->model->query($sqlOut)->execute();
		$stt = 0;
		if(empty($queryOut[0]->poid)){
			$arr = array();
			$arr['uniqueid'] = 0;
			$arr['poid'] = 0;
			$arr['msg'] = ' Sửa không thành công';
			return $arr;
		}
		else{
			$poid = $queryOut[0]->poid;
			$stt = $queryOut[0]->stt;
		}
		$arrOut = array();
		foreach($queryOut as $item){
			$arrOut[$item->goodsid] = $item->quantity;
		}
		#end
		//Kiểm tra số lượng tồn kho
		$str_goodsid = '';
		foreach($inputList as $k=>$v){
			$str_goodsid.= ','.$k;
		}
		$str_goodsid = substr($str_goodsid,1);
		#region Kiem tra ma hang co trong kho chu
		$sql = "
			SELECT i.id, i.goodsid, if(i.shelflife = '0000-00-00','3000-12-31',i.shelflife) as  shelflife, i.quantity, concat(g.goods_code,' - ',DES_DECRYPT(g.goods_name,'".$this->login->skey ."')) as goods_name, g.isnegative
			FROM `".$tb['hotel_inventory']."` i
			left join `".$tb['hotel_goods']."` g on g.id = i.goodsid
			where i.companyid = '".$companyid."'
			and i.branchid = '".$branchid."'
			and i.goodsid in (".$str_goodsid.")
			and i.warehouseid = '".$array['warehouseid']."'
			and i.isdelete = 0
			and g.isdelete = 0
		";
		$queryCheckInventory = $this->model->query($sql)->execute();
		$arrInventoryGoods = array();//Mang ton kho
		$arrGoodCode = array();
		$arrGoodCodeNegative = array();
		foreach($queryCheckInventory as $item){
			$arrGoodCode[$item->goodsid] = $item->goods_name;
			$arrGoodCodeNegative[$item->goodsid] = $item->isnegative;
			$arrInventoryGoods[$item->goodsid] = (float)$item->quantity;
		}
		foreach($inputList as $gid=>$q){
			if(!isset($arrGoodCode[$gid])){//Chua co add vao voi so sluong = 0
				$arrAddInventorey = array();
				$arrAddInventorey['companyid'] = $companyid; 
				$arrAddInventorey['branchid'] = $branchid; 
				$arrAddInventorey['warehouseid'] = $array['warehouseid']; 
				$arrAddInventorey['goodsid'] = $gid;
				$arrAddInventorey['quantity'] = 0;
				$arrAddInventorey['shelflife'] = '0000-00-00';
				$this->model->table($tb['hotel_inventory'])->insert($arrAddInventorey);
			}
		}
		#end
		$listError = '';
		foreach($arrGoodCode as $goodid=>$goods_name){ 
			$sl_tonkh = (int)$arrInventoryGoods[$goodid];
			$sl_ban = (int)$inputList[$goodid];
			$sl_secongvaokho = 0;
			if(isset($arrOut[$goodid])){
				$sl_secongvaokho = $arrOut[$goodid];
			}
			if($arrGoodCodeNegative[$goodid] == 0){ //=1 cho phep xuat am
				if($sl_ban > ($sl_tonkh + $sl_secongvaokho)){
					$listError.= $goods_name .' - Tồn kho: '.$sl_tonkh.'</br>';
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
		//Lay ma phieu thu cu
		$hotel_receipts = $this->model->table($tb['hotel_receipts'])
							   ->select('receipts_code')
							   ->where('uniqueid',$uniqueid)
							   ->where('isdelete',0)
							   ->find();
		//Xoa don hang tao lai
		$arrUpDelete['isdelete'] = 1;
		$arrUpDelete['dateupdate'] = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
		$arrUpDelete['userupdate'] = $this->login->username;
		$this->model->table($tb['hotel_output_createorders'])->where('uniqueid',$uniqueid)
														->update($arrUpDelete);
		$this->model->table($tb['hotel_output'])->where('uniqueid',$uniqueid)
														->update($arrUpDelete);
		$this->model->table($tb['hotel_receipts'])->where('uniqueid',$uniqueid)
														->update($arrUpDelete);
		
		//Cộng số lượng vào kho
		foreach($queryOut as $item){
			$sqlUpdateCong = "
				UPDATE `".$tb['hotel_inventory']."` 
				SET `quantity`= `quantity` + ".$item->quantity ." 
				WHERE `goodsid`='".$item->goodsid ."'
				AND `warehouseid` = '".$item->warehouseid ."'
				AND `branchid` = '".$item->branchid ."'
				;
			";
			$this->model->executeQuery($sqlUpdateCong);
		}
		//Trừ hàng trong kho -> Tru theo han su dung -> han su dung thap thi tru truoc
		foreach($inputList as $kk=>$suquantity){
			$sqlUpdateTru = "
				UPDATE `".$tb['hotel_inventory']."` 
				SET `quantity`= `quantity` - ".fmNumberSave($suquantity)." 
				WHERE `goodsid`='".$kk."'
				AND `warehouseid` = '".$array['warehouseid']."'
				AND `branchid` = '".$this->login->branchid ."'
				;
			";
			$this->model->executeQuery($sqlUpdateTru);
		}
		#region Tao po
		//$uniqueid = $this->base_model->getUniqueid();
		//Lay so luong
		$totalQuantity = 0;
		$totalPrice = 0;
		foreach($inputList as $goodsid=>$input){
			$discount = fmNumberSave($discountList[$goodsid]);
			$input = fmNumberSave($input);
			$totalQuantity+=  $input;
			$priceone = fmNumberSave($inputPriceone[$goodsid]);
			$totalPrice+= (($input * $priceone) - $discount);
		}
		//Tinh them tien thue
		$vat = $array['vat'];
		$totalVat = rNumber($totalPrice * $vat /100);
		$price_total = $totalPrice + $totalVat;
		
		$price_prepay =  str_replace(',','',$array['price_prepay']);
		$price_prepay =  fmNumberSave($price_prepay);
		$price_total =  fmNumberSave($price_total);
		if(!empty($array['price_prepay'])){//Co tam ung
			if($array['percent'] == 1){//Tinh %
				$insert['percent_value'] = fmNumberSave($price_prepay);
				$prepays = fmNumberSave($price_prepay) * fmNumberSave($price_total) / 100; 
				$insert['price_prepay'] = $prepays;
				if($insert['percent_value'] < 100){
					$insert['payments_status'] = -1; 
				}
			}
			else{//Tiem mat
				$insert['price_prepay'] = fmNumberSave($price_prepay);
				if($insert['price_prepay'] < fmNumberSave($totalPrice)){
					$insert['payments_status'] = -1; 
				}
			}
		}
		#region insert vao table serial
		if(count($serial) > 0){
			foreach($serial as $goodsid=>$sn){ 
				$arrSN = array();
				$arrSN['goodsid'] = $goodsid;
				$arrSN['uniqueid'] = $uniqueid;
				$arrSN['sn'] = $sn;
				$arrSN['usercreate'] = $this->login->username;
				$arrSN['datecreate'] = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
				if(!empty($sn)){
					$this->model->table($tb['hotel_seial'])
								->where('goodsid',$goodsid)
								->where('uniqueid',$uniqueid)
								->update(array('isdelete'=>1));
					$this->model->table($tb['hotel_seial'])->insert($arrSN);
				}
				
			}
		}	
		#end
		// Insert vao bang hoa don nhap - hotel_input_createorders
		$array['usercreate'] = $this->login->username;
		$insert['companyid'] = $companyid;
		$insert['branchid'] = $branchid;
		$insert['description'] = $description;
		if($customer_type == 1){ //KH Đại lý
			$insert['customer_id'] = $array['customerid'];
		}
		else{ // Khách hàng lẽ
			$insert['customer_name'] = $array['customer_name'] ;
			$insert['customer_phone'] = $array['customer_phone'];
			$insert['customer_address'] = $array['customer_address'] ;
			$insert['customer_email'] = $array['customer_email'];
		}
		$insert['datecreate'] = $timeNow;
		$insert['usercreate'] = $array['usercreate'];
		$insert['employeeid'] = $array['employeeid'];
		$insert['payments'] = $array['payments'];
		$insert['vat'] = (float)$array['vat'];
		$insert['customer_type'] = $customer_type;
		$insert['uniqueid'] = $uniqueid;
		$insert['poid'] = $poid;
		$insert['quantity'] = fmNumberSave($totalQuantity);
		$insert['price'] = fmNumberSave($totalPrice);
		$insert['price_total'] = fmNumberSave($price_total);
		$insert['stt'] = $stt;
		$insert['datepo'] = fmDateSave($array['datecreate']);
		$insert['place_of_delivery'] = $array['place_of_delivery'];
		$insert['deliverydate'] = fmDateSave($array['deliverydate']); 
		$insert['signature_x'] = $this->login->signature;
		$insert['signature_name_x'] = $this->login->fullname;
		$insert['warehouseid'] = $array['warehouseid'];
		$insert['soid'] = $queryOut[0]->soid;
		$insert['socode'] = $queryOut[0]->socode;
		
		$this->model->table($tb['hotel_output_createorders'])->insert($insert);
		// Insert vao bang chi tiet nhap - hotel_input
		$insertInput = array();
		$insertInput['warehouseid'] = $array['warehouseid'];
		$insertInput['companyid'] = $companyid;
		$insertInput['branchid'] = $branchid;
		$insertInput['datecreate'] = $array['datecreate'] ;
		$insertInput['usercreate'] = $array['usercreate'];
		$insertInput['poid'] = $poid;
		$insertInput['uniqueid'] = $uniqueid;
		//Get Price
		$goodlist = '';
		foreach($inputList as $goodsid=>$input){ 
			$goodlist.= ','.$goodsid;
		}
		$goodlist = substr($goodlist,1);
		$arrPrice = $this->model->table($tb['hotel_goods'])
					->where("id in ($goodlist)")
					->find_combo('id','buy_price');
		//$inputPriceone 
		foreach($inputList as $goodsid=>$input){
			$priceone = str_replace(',','',$inputPriceone[$goodsid]);
			$insertInput['quantity'] = fmNumberSave($input);
			$insertInput['goodsid'] = $goodsid;
			$insertInput['priceone'] = fmNumberSave($priceone);
			$insertInput['price'] = fmNumberSave($priceone * $input);
			$guaranteesave = '0000-00-00';
			if(isset($guaranteeList[$goodsid]) && !empty($guaranteeList[$goodsid])){
				$guaranteesave = fmDateSave($guaranteeList[$goodsid]);
			}
			if(isset($serial[$goodsid]) && !empty($serial[$goodsid])){
				$insertInput['serial_number'] = $serial[$goodsid];
			}
			$insertInput['sttview'] = $sttviewList[$goodsid];
			$insertInput['discount'] = $discountList[$goodsid];
			$insertInput['guarantee'] =  $guaranteesave;
			$this->model->table($tb['hotel_output'])->insert($insertInput);
		}
		#region Nhập vào phiếu thu
		$arrIS =  array();
		$arrIS['receipts_code'] = $this->createPoReceipt($branchid,$array['datecreate']);
		$arrIS['uniqueid'] = $uniqueid;
		$arrIS['companyid'] = $companyid;
		$arrIS['branchid'] = $branchid;
		if(!empty($hotel_receipts->receipts_code)){
			$arrIS['datepo'] = $hotel_receipts->receipts_code;
		}
		else{
			$arrIS['datepo'] = fmDateSave($array['datecreate']);
		}
		$arrIS['receipts_type'] = 1;
		$arrIS['payment'] = $array['payments'];
		if(empty($insert['price_prepay'])){ 
			$arrIS['amount'] =  fmNumberSave($price_total);
		}
		else{
			$arrIS['amount'] = $insert['price_prepay'];
		}
		$arrIS['poid'] = $poid;
		$arrIS['usercreate'] = $array['usercreate'];
		$arrIS['datecreate'] = $timeNow;
		$this->model->table($tb['hotel_receipts'])->insert($arrIS);
		#end
		#region Xoa du lieu bang tam
		$userid =  $this->login->id;
		$this->model->table($tb['hotel_add_temp'])
					->where('contronller',$this->ctr)
					->where('userid',$userid)
					->delete();	
		#end
		$this->db->trans_complete();
		$arr = array();
		$arr['uniqueid'] = $uniqueid;
		$arr['poid'] = $poid;
		$arr['msg'] = '';
		return $arr;	
	}
	function findGoodsID($id){
		$tb = $this->base_model->loadTable();
		$output = $tb['hotel_output'];
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
		$query = $this->model->table($tb['hotel_output'])
					  ->select('*')
					  ->where('id',$id)
					  ->find();
		return $query;
	}
	function findListID($id,$unit=''){
		$tb = $this->base_model->loadTable();
		$createorders = $tb['hotel_output_createorders'];
		 $warehouse = $tb['hotel_warehouse'];
		 $customer = $tb['hotel_customer'];
		 $query = $this->model->table($createorders)
					  ->select("
					  signature_x,signature_name_x, datepo,
					  place_of_delivery,stt,datepo ,vat, checkprint, uniqueid,poid,price,price_prepay, customer_type, ".$createorders.".customer_name, customer_phone, customer_address, description,warehouse_name,
					  DES_DECRYPT(".$customer.".customer_name,'".$this->login->skey ."') as cname, 
					  DES_DECRYPT(".$customer.".phone,'".$this->login->skey ."') as cphone, 
					  DES_DECRYPT(".$customer.".fax,'".$this->login->skey ."') as cfax,
					  DES_DECRYPT(".$customer.".address,'".$this->login->skey ."')  as caddress,
					  ".$createorders.".datecreate
					  ")
					  ->join($warehouse,$warehouse.'.id = '.$createorders.'.warehouseid','left')
					  ->join($customer,$customer.'.id = '.$createorders.'.customer_id','left')
					  ;
		if(empty($unit)){
			$query = $query->where($createorders.".id",$id);
		}
		else{
			$query = $query->where($createorders.".uniqueid",$unit);
		}
		$query = $query->where($createorders.'.isdelete',0)->find();
		return $query;
	}
	function findListIDDetail($uniqueid){
		$tb = $this->base_model->loadTable();
		$goods = $tb['hotel_goods'];
		 $warehouse = $tb['hotel_warehouse'];
		 $output = $tb['hotel_output'];
		 $unit = $tb['hotel_unit'];
		 $query = $this->model->table($tb['hotel_output'])
					  ->select("warehouse_name,goods_code,goods_code2,DES_DECRYPT(goods_name,'".$this->login->skey ."') goods_name,poid,quantity,price,priceone,unit_name,discount")
					  ->join($goods,$goods.'.id = '.$output.'.goodsid','left')
					  ->join($warehouse,$warehouse.'.id = '.$output.'.warehouseid','left')
					  ->join($unit,$unit.'.id = '.$goods.'.unitid','left')
					  ->where($output.".uniqueid in ($uniqueid)")
					  ->where($output.'.isdelete',0)
					  ->order_by($output.'.sttview','asc')
					  ->find_all();
		return $query;
	}
	function findUniqueid($uniqueid){
		$tb = $this->base_model->loadTable(); 
		$sql = "
			SELECT s.id, s.uniqueid, s.goodsid, s.quantity, g.sale_price, (s.quantity * g.sale_price) as price, g.goods_code, g.goods_name,  un.unit_name, s.employeeid, s.customer_id, sc.phone, sc.address, s.guarantee
			FROM `".$tb['hotel_output']."` s
			left join `".$tb['hotel_goods']."` g on g.id = s.goodsid and g.isdelete = 0
			left join `".$tb['hotel_unit']."` un on un.id = g.unitid
			left join `".$tb['hotel_customer']."` sc on sc.id = s.customer_id
			where s.uniqueid = '$uniqueid'
			and s.isdelete = 0
		 ";
		 $query = $this->model->query($sql)->execute();
		 return $this->model->query($sql)->execute();
	 }
	function findOrder($id){
		$tb = $this->base_model->loadTable();
		$query = $this->model->table($tb['hotel_output_createorders'])
					  ->select('*')
					  ->where('id',$id)
					  ->where('isout',0)
					  ->find();
		return $query;
	 }
	function deletes($id, $array){
		$tb = $this->base_model->loadTable();
		$this->db->trans_start();
		$result = $this->model->table($tb['hotel_output_createorders'])
					   ->select('id,uniqueid')
					   ->where("id in ($id)")
					   ->find();	
		$query = $this->model->table($tb['hotel_output'])
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
				and `warehouseid`= '$warehouseid'
				and `companyid`= '$companyid'
				;
			 ";
			 $this->model->executeQuery($sqlUpdate);				
		}
		$this->model->table($tb['hotel_output_createorders'])
					   ->where("uniqueid in ($uniqueid)")
					   ->update($array);
					   
		$this->model->table($tb['hotel_output'])
					   ->where("uniqueid in ($uniqueid)")
					   ->update($array);
		$this->db->trans_complete();
		return 1;
	}
	function findGoods($id,$code,$stype,$exchangs,$delete='',$isnew){
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
		$checkuniqueid = $this->model->table($tb['hotel_add_temp'])
						  ->select('uniqueid')
						  ->where('contronller',$this->ctr)
						  ->where('userid',$userid)
						  ->where('isnew',$isnew)
						  ->find();
		
		if(empty($checkuniqueid->uniqueid)){
			$arrAdd['uniqueid'] = $this->base_model->getUniqueid();
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
			if(empty($check->id)){//chua co inser
				$arrAdd['quantity'] = $exchang;
				$arrAdd['datecreate'] = gmdate("Y-m-d H:i:s", time() + 7 * 3600);;
				$this->model->table($tb['hotel_add_temp'])->insert($arrAdd);
			}
			else{//co roi update so luon
				$arrAdd['quantity'] = $exchang + $check->quantity;
				$this->model->table($tb['hotel_add_temp'])->save($check->id,$arrAdd);
			}
			
		}
		return $this->getTempGood($userid,$isnew);
	}
	function addToList($uniqueid,$goodid,$price,$goods_code,$isnew){
		$tb = $this->base_model->loadTable();
		$userid =  $this->login->id;
		$check = $this->model->table($tb['hotel_add_temp'])
					  ->select('id,quantity')
					  ->where('goodid',$goodid)
					  ->where('contronller',$this->ctr)
					  ->where('isnew',0)
					  ->find();
		if(empty($check->id)){
			$arrAdd = array();
			$arrAdd['contronller'] = $this->ctr;
			$arrAdd['userid'] = $userid;
			$arrAdd['stype'] = 0;
			$arrAdd['isnew'] = $isnew;
			$arrAdd['goods_code_group'] = '';
			$arrAdd['goods_code'] = $goods_code;
			$arrAdd['goodid'] = $goodid;
			$arrAdd['price'] = $price;
			$arrAdd['quantity'] = 1;
			$arrAdd['uniqueid'] = $uniqueid;
			$arrAdd['datecreate'] = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
			$this->model->table($tb['hotel_add_temp'])->insert($arrAdd);
			echo 1;
		}
		else{
			$arrAdd = array();
			$arrAdd['quantity'] = $check->quantity + 1;
			$this->model->table($tb['hotel_add_temp'])->where('id',$check->id)->update($arrAdd);
			echo 1;
		}
	}
	function getTempGood($userid,$isnew = 0){
		$tb = $this->base_model->loadTable();
		$skey = $this->login->skey;
		$sql = "
				SELECT sat.discount, sat.serial_number, sat.uniqueid, sat.stype, sat.quantity, s.goods_code, s.id, s.img,DES_DECRYPT(s.goods_name,'".$skey."') as goods_name,
 un.unit_name, sat.price as satPrice ,s.sale_price, s.shelflife, s.isserial
,gg.group_code, gg.group_name, gd.exchang, sat.guarantee as guaranteedate, (sat.quantity * sat.price) as price
				FROM `".$tb['hotel_add_temp']."` sat
				left join `".$tb['hotel_goods']."` s on s.id = sat.goodid
				left join `".$tb['hotel_unit']."` un on un.id = s.unitid
				left join `".$tb['hotel_goods_group_detail']."` gd on gd.goodid = s.id and gd.isdelete = 0
				left join `".$tb['hotel_goods_group']."` gg on gg.id = gd.groupid and gg.isdelete = 0
				where s.isdelete = 0
				and un.isdelete = 0
				and sat.userid = '$userid'
				and sat.contronller = '".$this->ctr ."'
				and sat.isnew = '$isnew'
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
					from `".$tb['hotel_output']."` op
					where op.isdelete = 0
					and op.socode = sat.poid
					and op.goodsid = sat.goodsid
				) as quantityexport, '' as serial_number
				FROM `".$tb['hotel_output_order']."` sat
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
	function checkTempData($query){
		$tb = $this->base_model->loadTable();
		foreach($query as $item){
			$check = $this->model->table($tb['hotel_add_temp'])
							     ->select('id')
								 ->where('contronller',$this->ctr)
								 ->where('goodid',$item->goodsid)
								 ->where('userid',$this->login->id)
								 ->where('isnew',1)
								 ->find();
			if(empty($check->id)){ //Chi insert lần đâu vào
				$arrAdd = array();
				
				$arrAdd['contronller'] = $this->ctr;
				$arrAdd['userid'] = $this->login->id;
				$arrAdd['stype'] = $item->stype;
				$arrAdd['isnew'] = 1;
				$arrAdd['uniqueid'] = $item->uniqueid;
				$arrAdd['goods_code_group'] = $item->group_code;
				$arrAdd['goods_code'] = $item->goods_code;
				$arrAdd['goodid'] = $item->goodsid;
				$arrAdd['quantity'] = $item->quantity;
				$arrAdd['price'] = $item->buy_price;
				$arrAdd['discount'] = $item->discount;
				$arrAdd['guarantee'] = $item->guaranteeOut;
				if(!empty($item->serial_number)){
					$arrAdd['serial_number'] = $item->serial_number;
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
		WHERE table_name='".$tb['hotel_output_createorders']."'; 
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
		$array['companyid'] = $this->login->companyid;
		$result = $this->model->table($tb['hotel_customer'])->save('',$array);	
		return $result;
	}
	function createPoReceipt($branchid,$datecreate){
		$tb = $this->base_model->loadTable();
		$yearDay = fmMonthSave($datecreate);
		$checkPOid = $this->model->table($tb['hotel_receipts'])
							 ->select('receipts_code')
							 ->where("datepo like '$yearDay%'")
							 ->where('branchid',$branchid)
							 ->where('isdelete',0)
							 ->order_by('id','DESC')
							 ->find();
		if(!empty($checkPOid->receipts_code)){
			$poid = str_replace(cfpt(),'',$checkPOid->receipts_code);
			$poc = (float)$poid;
		}
		else{
			$poc = date('ym',strtotime($yearDay)).'00000';
		}
		$receipts_code = cfpt().($poc + 1);
		return $receipts_code;
	}
	function createPoOrder($branchid,$datecreate){
		$tb = $this->base_model->loadTable();
		$yearDay = fmMonthSave($datecreate);
		//$yearDay = gmdate("Y-m", time() + 7 * 3600);
		$checkPOid = $this->model->table($tb['hotel_output_createorders'])
							 ->select('poid,stt')
							 ->where("datepo like '$yearDay%'")
							 ->where('branchid',$branchid)
							 ->where('isdelete',0)
							 ->order_by('id','DESC')
							 ->find();
		if(!empty($checkPOid->poid)){
			$poid = str_replace(cfpx(),'',$checkPOid->poid);
			$poc = (float)$poid;
		}
		else{
			$poc = date('ym',strtotime($yearDay)).'00000';
		}
		if(!empty($checkPOid->stt)){
			$stt = (float)$checkPOid->stt;
		}
		else{
			$stt = '0';
		}
		$array = array();
		$array['poid'] =  cfpx().($poc + 1);
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
			FROM `".$tb['hotel_output_order']."`  sat
			left join `".$tb['hotel_goods']."` g on g.id = sat.goodsid
			where sat.poid = '$poid'
			and sat.goodsid = '$goodid'
			and g.isdelete = 0
			;
		";
		$query = $this->model->query($sql)->execute();
		return $query[0];
	}
	function updateDiscount($price_discount_val,$goodid){
		$tb = $this->base_model->loadTable();
		$array = array();
		$userid =  $this->login->id;
		$array['discount'] = $price_discount_val;
		$this->model->table($tb['hotel_add_temp'])
					->where('contronller',$this->ctr)
					->where('userid',$userid)
					->where('goodid',$goodid)
					->update($array);
	}
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
	function updateQuantity($goodid,$quantity){
		$userid =  $this->login->id;
		$tb = $this->base_model->loadTable();
		$this->model->table($tb['hotel_add_temp'])
						  ->where('contronller',$this->ctr)
						  ->where('userid',$userid)
						  ->where('goodid',$goodid)
						  ->update(array('quantity'=>fmNumberSave($quantity)));
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
	function updatePriceOne($goodid,$priceone){
		$userid =  $this->login->id;
		$tb = $this->base_model->loadTable();
		$this->model->table($tb['hotel_add_temp'])
						  ->where('contronller',$this->ctr)
						  ->where('userid',$userid)
						  ->where('goodid',$goodid)
						  ->update(array('price'=>fmNumberSave($priceone)));
		$this->model->table($tb['hotel_goods'])
						  ->where('id',$goodid)
						  ->update(array('buy_price'=>fmNumberSave($priceone)));				  
		
	}
	function findListUniqueID($uniqueid){
		$tb = $this->base_model->loadTable();
		$sql = "
			select sg.id, '0' stype ,si.serial_number , si.goodsid, sg.sale_price ,si.quantity, si.price as totalPrice, si.priceone as buy_price, sg. sale_price as price_out, sg.goods_code, DES_DECRYPT(sg.goods_name,'".$this->login->skey ."') as goods_name, su.unit_name, sg.guarantee as isguarantee, if(si.guarantee = '0000-00-00',0,si.guarantee) as guaranteedate, gg.group_code, gg.group_name, sg.guarantee, gd.exchang,si.uniqueid, si.guarantee as guaranteeOut, si.discount
			from `".$tb['hotel_output']."` si
			left join `".$tb['hotel_goods']."` sg on si.goodsid = sg.id
			left join `".$tb['hotel_goods_group_detail']."` gd on gd.goodid = sg.id and gd.isdelete = 0
			left join `".$tb['hotel_goods_group']."` gg on gg.id = gd.groupid and gg.isdelete = 0
			left join `".$tb['hotel_unit']."` su on su.id = sg.unitid
			where si.uniqueid = '$uniqueid'
			and si.isdelete = 0
			order by si.sttview asc
		"; 
		return $this->model->query($sql)->execute();
	}
	function findOrderUniqueid($uniqueid){
		$tb = $this->base_model->loadTable();
		$query = $this->model->table($tb['hotel_output_createorders'])
					  ->select('*')
					  ->where('uniqueid',$uniqueid)
					  ->find();
		return $query;
	}
	function findOrderSO($so){
		$tb = $this->base_model->loadTable();
		$query = $this->model->table($tb['hotel_output_createorders_order'])
					  ->select('*')
					  ->where('poid',$so)
					  ->find();
		return $query;
	}
}