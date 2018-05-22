<?php
/**
 * @author 
 * @copyright 2015
 */
 class SuplierreturnModel extends CI_Model{
	function __construct(){
		parent::__construct('');
		$this->login = $this->site->getSession('login');
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
		$searchs = $this->getSearch($search);
		$sql = "SELECT c.*, w.warehouse_name, DES_DECRYPT(cm.customer_name,'".$this->login->skey ."')  as cmname,DES_DECRYPT(cm.phone,'".$this->login->skey ."') as cmphone,DES_DECRYPT(cm.address,'".$this->login->skey ."') as cmaddress,
		DES_DECRYPT(cm.email,'".$this->login->skey ."') as cmemail,
				 e.employee_code ,
				 DES_DECRYPT(e.employee_name,'".$this->login->skey ."')as employee_name, cm.phone as phones
				FROM `".$this->base_model->tb_output_createorders()."`  AS c
				LEFT JOIN `".$this->base_model->tb_warehouse()."` w on w.id = c.warehouseid and w.isdelete = 0
				LEFT JOIN `".$this->base_model->tb_customer()."` cm on cm.id = c.customer_id and cm.isdelete = 0
				LEFT JOIN `".$this->base_model->tb_employeesale()."` e on e.id = c.employeeid and e.isdelete = 0
				WHERE c.isdelete = 0 
				AND c.isout = 1
				$searchs
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
		$str_unique = "";
		foreach($query as $item){
			$str_unique.= ",".$item->uniqueid;
		}
		if(!empty($str_unique)){
			$str_unique = substr($str_unique,1);
		}
		$data['detail'] = $this->getListDetail($str_unique);
		$data['result'] = $query;
		return $data;
	}
	function getListDetail($str_unique){
		if(empty($str_unique)){
			$str_unique = 0;
		}
		$sql = "
			SELECT so.id, so.uniqueid, so.priceone, DES_DECRYPT(g.goods_name,'".$this->login->skey ."') as goods_name ,g.goods_code, so.quantity, ut.unit_name
			FROM `".$this->base_model->tb_output()."` so
			left join `".$this->base_model->tb_goods()."` g on g.id = so.goodsid and g.isdelete = 0
			left join `".$this->base_model->tb_unit()."` ut on ut.id = g.unitid
			where so.isdelete = 0
			and so.uniqueid in ($str_unique)
			;
		";
		$query = $this->model->query($sql)->execute();
		$arr = array();
		foreach($query as $item){
			$obj = new stdClass();
			$obj->goods_code = $item->goods_code;
			$obj->goods_name = $item->goods_name;
			$obj->quantity = $item->quantity;
			$obj->priceone = $item->priceone;
			$obj->unit_name = $item->unit_name;
			$arr[$item->uniqueid][$item->id] = $obj;
		}
		return $arr;
	}
	function getTotal($search){
		$searchs = $this->getSearch($search);
		$sql = " 
		SELECT count(1) total
		FROM `".$this->base_model->tb_output_createorders()."` AS c
		LEFT JOIN `".$this->base_model->tb_warehouse()."` w on w.id = c.warehouseid and w.isdelete = 0
		LEFT JOIN `".$this->base_model->tb_customer()."` cm on cm.id = c.customer_id and cm.isdelete = 0
		LEFT JOIN `".$this->base_model->tb_employeesale()."` e on e.id = c.employeeid and e.isdelete = 0
		WHERE c.isdelete = 0 
		AND c.isout = 1
		$searchs	
		";
		$query = $this->model->query($sql)->execute();
		return $query[0]->total;	
	}
	function saves($arrays,$listQuantity,$description,$customer_type,$listPriceone){
		foreach($arrays as $key=>$val){
			if($key == 'input_list'){ continue; }
			$array[$key] = addslashes($val); 
		}
		$timeNow  = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
		$companyid = $this->login->companyid;
		$branchid = $this->login->branchid;
		$array['companyid'] = $companyid;
		$array['branchid'] = $branchid;
		$array['employeeid'] = $this->login->id;
		$inputList = json_decode($listQuantity,true); //Số lương
		$inputPriceone =  json_decode($listPriceone,true);
		$this->db->trans_start();
		//Kiểm tra số lượng tồn kho
		$str_goodsid = '';
		foreach($inputList as $k=>$v){
			$str_goodsid.= ','.$k;
		}
		$str_goodsid = substr($str_goodsid,1);
		#region Kiem tra ma hang co trong kho chua
		$queryCheckInventory = $this->model->table($this->base_model->tb_inventory())
									->where('companyid',$companyid)
									->where('branchid',$branchid)
									->where('warehouseid',$array['warehouseid'])
									->where("goodsid in ($str_goodsid)")
									->find_combo('goodsid','warehouseid');
		
		foreach($inputList as $gid=>$q){
			if(!isset($queryCheckInventory[$gid])){//Chua co add vao voi so sluong = 0
				$arrAddInventorey = array();
				$arrAddInventorey['companyid'] = $companyid; 
				$arrAddInventorey['branchid'] = $branchid; 
				$arrAddInventorey['warehouseid'] = $array['warehouseid']; 
				$arrAddInventorey['goodsid'] = $gid;
				$arrAddInventorey['quantity'] = 0;
				$this->model->table($this->base_model->tb_inventory())->insert($arrAddInventorey);
				
			}
		}
		#end
		//Ly so luong ton kho
		$sqlCheckInventory = "
			SELECT iv.quantity, iv.goodsid, concat(g.goods_code,' - ',DES_DECRYPT(g.goods_name,'".$this->login->skey ."')) as goods_name
			FROM `".$this->base_model->tb_inventory()."` iv
			left join `".$this->base_model->tb_goods()."` g on g.id = iv.goodsid
			where iv.isdelete = 0
			and iv.companyid = '$companyid'
			and iv.branchid = '$branchid'
			and iv.goodsid in ($str_goodsid)
			group by goodsid
			;
		";
		$queryCheckIventory = $this->model->query($sqlCheckInventory)->execute();
		$listError = '';
		foreach($queryCheckIventory as $items){
			$sl_ban = (float)$inputList[$items->goodsid];
			$sl_tonkh = (float)$items->quantity;
			
			if($sl_ban > $sl_tonkh){
				$listError.= $items->goods_name .' - Tồn kho: '.$sl_tonkh.'</br>';
			}
		}
		if($listError != ''){
			$arr = array();
			$arr['uniqueid'] = 0;
			$arr['poid'] = 0;
			$arr['msg'] = ' Tồn kho không đủ: <br>'.$listError;
			return $arr;
		}
		
		//Trừ hàng trong kho
		foreach($inputList as $kk=>$suquantity){
			$sqlUpdate = "
				UPDATE `".$this->base_model->tb_inventory()."` 
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
			$checkPOid = $this->model->table($this->base_model->tb_output_createorders())
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
		$uniqueid = $this->base_model->getUniqueid();
		//Lay so luong
		$totalQuantity = 0;
		$totalPrice = 0;
		foreach($inputList as $goodsid=>$input){
			$input = str_replace(',','',$input);
			$totalQuantity+=  $input;
			$priceone = str_replace(',','',$inputPriceone[$goodsid]);
			$totalPrice+= ($input * $priceone);

		}
		//Tinh them tien thue
		$vat = $array['vat'];
		$totalVat = round($totalPrice * $vat /100,2);
		$price_total = $totalPrice + $totalVat;
		
		$price_prepay =  str_replace(',','',$array['price_prepay']);
		$price_prepay =  fmNumberSave($price_prepay);
		$price_total =  fmNumberSave($price_total);
		if($price_prepay > $price_total){
			$price_prepay = $price_total;
		}
		elseif($price_prepay < 0){
			$price_prepay = 0;
		}
		if($price_prepay < $price_total){
			$insert['payments_status'] = -1; //Ghi nhan co cong no
		}
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
		$insert['price_prepay'] = fmNumberSave($price_prepay); 
		$insert['isout'] = 1;
		$insert['stt'] = $arrAuto['stt'];
		$insert['datepo'] = fmDateSave($array['datecreate']);
		$insert['place_of_delivery'] = $array['place_of_delivery'];
		$insert['deliverydate'] = fmDateSave($array['deliverydate']); 
		$insert['signature_x'] = $this->login->signature;
		$insert['signature_name_x'] = $this->login->fullname;
		$this->model->table($this->base_model->tb_output_createorders())->insert($insert);
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
		$arrPrice = $this->model->table($this->base_model->tb_goods())
					->where("id in ($goodlist)")
					->find_combo('id','buy_price');
		//$inputPriceone 
		foreach($inputList as $goodsid=>$input){
			$priceone = str_replace(',','',$inputPriceone[$goodsid]);
			$insertInput['quantity'] = fmNumberSave($input);
			$insertInput['goodsid'] = $goodsid;
			$insertInput['priceone'] = fmNumberSave($priceone);
			$insertInput['price'] = fmNumberSave($priceone * $input);
			$pricein = 0;
			if(isset($arrPrice[$goodsid])){
				$pricein = $arrPrice[$goodsid];
			}
			$insertInput['pricein'] = fmNumberSave($pricein);
			$this->model->table($this->base_model->tb_output())->insert($insertInput);
		}
		#region Nhập vào phiếu thu
		$arrIS =  array();
		$arrIS['receipts_code'] = $this->createPoReceipt($branchid,$array['datecreate']);
		$arrIS['uniqueid'] = $uniqueid;
		$arrIS['companyid'] = $companyid;
		$arrIS['branchid'] = $branchid;
		$arrIS['receipts_type'] = 1;
		$arrIS['payment'] = $array['payments'];
		$arrIS['amount'] = fmNumberSave($price_prepay);
		$arrIS['poid'] = $poid;
		$arrIS['usercreate'] = $array['usercreate'];
		$arrIS['datecreate'] = $timeNow;
		$this->model->table($this->base_model->tb_receipts())->insert($arrIS);
		#end
		$this->db->trans_complete();
		$arr = array();
		$arr['uniqueid'] = $uniqueid;
		$arr['poid'] = $poid;
		$arr['msg'] = '';
		return $arr;
	}
	//Ban theo don hang
	function savesOrder($array,$listQuantity,$description,$customer_type,$listPriceone,$uniqueid){
		#region Trun hang trong kho
		$timeNow  = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
		$companyid = $this->login->companyid;
		$branchid = $this->login->branchid;
		$array['companyid'] = $companyid;
		$array['branchid'] = $branchid;
		$array['employeeid'] = $this->login->id;
		$inputList = json_decode($listQuantity,true); //Số lương
		$inputPriceone =  json_decode($listPriceone,true);
		$this->db->trans_start();
		//Kiểm tra số lượng tồn kho
		$str_goodsid = '';
		foreach($inputList as $k=>$v){
			$str_goodsid.= ','.$k;
		}
		$str_goodsid = substr($str_goodsid,1);
		#region Kiem tra ma hang co trong kho chua
		$queryCheckInventory = $this->model->table($this->base_model->tb_inventory())
									->where('companyid',$companyid)
									->where('branchid',$branchid)
									->where('warehouseid',$array['warehouseid'])
									->where("goodsid in ($str_goodsid)")
									->find_combo('goodsid','warehouseid');
		foreach($inputList as $gid=>$q){
			if(!isset($queryCheckInventory[$gid])){//Chua co add vao voi so sluong = 0
				$arrAddInventorey = array();
				$arrAddInventorey['companyid'] = $companyid; 
				$arrAddInventorey['branchid'] = $branchid; 
				$arrAddInventorey['warehouseid'] = $array['warehouseid'];
				$arrAddInventorey['goodsid'] = $gid;
				$arrAddInventorey['quantity'] = 0;
				$this->model->table($this->base_model->tb_inventory())->insert($arrAddInventorey);
			}
		}
		#end
		$sqlCheck = "
			SELECT iv.quantity, iv.goodsid, concat(g.goods_code,' - ',g.goods_name) as goods_name
			FROM `".$this->base_model->tb_inventory()."` iv
			left join `".$this->base_model->tb_goods()."` g on g.id = iv.goodsid
			where iv.isdelete = 0
			and iv.companyid = '$companyid'
			and iv.branchid = '$branchid'
			and iv.goodsid in ($str_goodsid);
			;
		";
		$queryCheckIv = $this->model->query($sqlCheck)->execute();
		
		$listError = '';
		foreach($queryCheckIv as $item){
			if($inputList[$item->goodsid] > $item->quantity){
				$listError.= $item->goods_name .' SL tồn: '.$item->quantity .'</br>';
			}
		}
		if($listError != ''){
			$arr = array();
			$arr['uniqueid'] = 0;
			$arr['poid'] = 0;
			$arr['msg'] = 'Tồn kho không đủ <br>'.$listError;
			return $arr;
		}
		//Trừ hàng trong kho
		foreach($inputList as $kk=>$suquantity){
			$sqlUpdate = "
				UPDATE  `".$this->base_model->tb_inventory()."`  
				SET `quantity`= `quantity` - ".fmNumberSave($suquantity)." 
				WHERE `goodsid`='".$kk."'
				and `warehouseid` = '".$array['warehouseid']."'
				and `branchid`  = '".$this->login->branchid ."'
				;
			";
			$this->model->executeQuery($sqlUpdate);
		}
		#end
		//Lay so luong
		$insert = array();
		$totalQuantity = 0;
		$totalPrice = 0;
		foreach($inputList as $goodsid=>$input){
			$input = str_replace(',','',$input);
			$totalQuantity+=  $input;
			$priceone = str_replace(',','',$inputPriceone[$goodsid]);
			$totalPrice+= ($input * $priceone);
		}
		//Tinh them tien thue
		$vat = $array['vat'];
		$totalVat = round($totalPrice * $vat /100,2);
		$price_total = $totalPrice + $totalVat;
		
		$price_prepay =  str_replace(',','',$array['price_prepay']);
		$price_prepay = fmNumberSave($price_prepay);
		$price_total = fmNumberSave($price_total);
		
		if($price_prepay > $price_total){
			$price_prepay = $price_total;
		}
		elseif($price_prepay < 0){
			$price_prepay = 0;
		}
		if($price_prepay < $price_total){
			$insert['payments_status'] = -1; //Ghi nhan co cong no
		}
		// Insert vao bang hoa don nhap - hotel_input_createorders
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
		$insert['datecreate'] = $array['datecreate'] ;
		$insert['usercreate'] = $array['usercreate'];
		$insert['employeeid'] = $array['employeeid'];
		$insert['payments'] = $array['payments'];
		$insert['vat'] = (float)$array['vat'];
		$insert['customer_type'] = $customer_type;
		$insert['uniqueid'] = $uniqueid;
		$insert['quantity'] = fmNumberSave($totalQuantity);
		$insert['price'] = fmNumberSave($totalPrice);
		$insert['price_total'] = fmNumberSave($price_total);
		$insert['price_prepay'] = fmNumberSave($price_prepay); 
		$insert['isout'] = 1;
		$insert['place_of_delivery'] = $array['place_of_delivery'];
		$insert['signature_x'] = $this->login->signature;
		$insert['signature_name_x'] = $this->login->fullname;
		$insert['deliverydate'] = fmDateSave($array['deliverydate']); 
		$findPoid = $this->model->table($this->base_model->tb_output_createorders()) 
							->select('poid,id')
							->where('uniqueid',$uniqueid)
							->where('companyid',$companyid)
							->where('branchid',$branchid)
							->find();
		
		$poid = $findPoid->poid;
		$p = $this->model->table($this->base_model->tb_output_createorders())->save($findPoid->id,$insert);
		// Insert vao bang chi tiet nhap - hotel_input
	
		$insertInput = array();
		$insertInput['warehouseid'] = $array['warehouseid'];
		$insertInput['datecreate'] = $timeNow;
		$insertInput['usercreate'] = $array['usercreate'];
		$insertInput['uniqueid'] = $uniqueid;
		//Get Price
		$goodlist = '';
		foreach($inputList as $goodsid=>$input){ 
			$goodlist.= ','.$goodsid;
		}
		$goodlist = substr($goodlist,1);
		$arrPrice = $this->model->table($this->base_model->tb_goods())
					->where("id in ($goodlist)")
					->find_combo('id','buy_price');
		//$inputPriceone 
		foreach($inputList as $goodsid=>$input){ //goodsid = id out
			$priceone = str_replace(',','',$inputPriceone[$goodsid]);
			$insertInput['quantity'] = fmNumberSave($input);
			$insertInput['priceone'] = fmNumberSave($priceone);
			$insertInput['price'] = fmNumberSave($priceone * $input);
			$pricein = 0;
			if(isset($arrPrice[$goodsid])){
				$pricein = $arrPrice[$goodsid];
			}
			$insertInput['pricein'] = fmNumberSave($pricein);
			$this->model->table($this->base_model->tb_output())
						->where('goodsid',$goodsid)
						->where('uniqueid',$uniqueid)
						->where('poid',$poid)
						->where('id > 0')
						->update($insertInput);
		}
		#region Nhập vào phiếu thu
		$arrIS =  array();
		$arrIS['receipts_code'] = $this->createPoReceipt($branchid);
		$arrIS['uniqueid'] = $uniqueid;
		$arrIS['companyid'] = $companyid;
		$arrIS['branchid'] = $branchid;
		$arrIS['receipts_type'] = 1;
		$arrIS['payment'] = $array['payments'];
		$arrIS['amount'] = fmNumberSave($price_prepay);
		$arrIS['poid'] = $poid;
		$arrIS['usercreate'] = $array['usercreate'];
		$arrIS['datecreate'] = $timeNow;
		
		$this->model->table($this->base_model->tb_receipts())->insert($arrIS);
		#end
		$this->db->trans_complete();
		$arr = array();
		$arr['uniqueid'] = $uniqueid;
		$arr['poid'] = $poid;
		$arr['msg'] = '';
		return $arr;
	}
	function edits($array,$listQuantity,$description,$customer_type,$listPriceone,$id,$uniqueid){
		$timeNow  = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
		$companyid = $this->login->companyid;
		$branchid = $this->login->branchid;
		$array['companyid'] = $companyid;
		$array['branchid'] = $branchid;
		$array['employeeid'] = $this->login->id;
		$inputList = json_decode($listQuantity,true); //Số lương
		$inputPriceone =  json_decode($listPriceone,true);
		$this->db->trans_start();
		//Kiểm tra số lượng tồn kho
		$str_goodsid = '';
		foreach($inputList as $k=>$v){
			$str_goodsid.= ','.$k;
		}
		$str_goodsid = substr($str_goodsid,1);
		#region Kiem tra ma hang co trong kho chua
		$queryCheckInventory = $this->model->table($this->base_model->tb_inventory())
									->where('companyid',$companyid)
									->where('branchid',$branchid)
									->where('warehouseid',$array['warehouseid'])
									->where("goodsid in ($str_goodsid)")
									->find_combo('goodsid','quantity');
		
		foreach($inputList as $gid=>$q){
			if(!isset($queryCheckInventory[$gid])){//Chua co add vao voi so sluong = 0
				$arrAddInventorey = array();
				$arrAddInventorey['companyid'] = $companyid; 
				$arrAddInventorey['branchid'] = $branchid; 
				$arrAddInventorey['warehouseid'] = $array['warehouseid'];
				$arrAddInventorey['goodsid'] = $gid;
				$arrAddInventorey['quantity'] = 0;
				$this->model->table($this->base_model->tb_inventory())->insert($arrAddInventorey);
			}
		}
		#end
		//So luong hien tai trong kho
		$sqlCheck = "
			SELECT iv.quantity, iv.goodsid, concat(g.goods_code,' - ',DES_DECRYPT(g.goods_name,'".$this->login->skey ."')) as goods_name
			FROM `".$this->base_model->tb_inventory()."` iv
			left join `".$this->base_model->tb_goods()."` g on g.id = iv.goodsid
			where iv.isdelete = 0
			and iv.companyid = '$companyid'
			and iv.branchid = '$branchid'
			and iv.goodsid in ($str_goodsid)
			group by goodsid
			;
		";
		$queryCheckIv = $this->model->query($sqlCheck)->execute();
		//So luong da xuat
		$queryOut = $this->model->table($this->base_model->tb_output())
					   ->select('goodsid,quantity')
					   ->where("uniqueid in (".$uniqueid.")")
					   ->where('isdelete',0)
					   ->find_combo('goodsid','quantity');
		$listError = '';
		foreach($queryCheckIv as $item){
			$sl_da_xuat = 0;
			if(!empty($queryOut[$item->goodsid])){
				$sl_da_xuat = $queryOut[$item->goodsid];
			}
			$so_luong_xuat = (float)$inputList[$item->goodsid];
			$tong_so_luong = $item->quantity + $sl_da_xuat; 
			if($so_luong_xuat > $tong_so_luong){
				$listError.= $item->goods_name .' SL tồn: '.$item->quantity .'</br>';
			}
		}
		if($listError != ''){
			$arr = array();
			$arr['uniqueid'] = 0;
			$arr['poid'] = 0;
			$arr['msg'] = 'Tồn kho không đủ:<br>'.$listError;
			return $arr;
		}
		#region find data
		$findOrder = $this->model->table($this->base_model->tb_output_createorders())
								 ->select('poid,stt,datepo')
								 ->where('uniqueid',$uniqueid)
								 ->where('isdelete',0)
								 ->order_by('datecreate','DESC')
								 ->find();
		#end
		#region xoa tam thoi
		$queryOuts = $this->model->table($this->base_model->tb_output())
					   ->select('uniqueid,id,quantity,warehouseid,branchid,companyid')
					   ->where("uniqueid in (".$uniqueid.")")
					   ->where('isdelete',0)
					   ->find_all();
		foreach($queryOuts as $item){
			//Cong tra so luong vao kho
			$goodsid = $this->findID($item->id);//$array['goodsid'];
			$quantity = fmNumberSave($goodsid->quantity);
			$warehouseid = $goodsid->warehouseid;
			$branchid = $goodsid->branchid;
			$companyid = $goodsid->companyid;
			//Tru so luong trong kho
			$sqlUpdate = "
				UPDATE `".$this->base_model->tb_inventory()."` SET `quantity`=`quantity`+ $quantity 
				WHERE `id` > 0
				and `goodsid`= '".$goodsid->goodsid ."'
				and `branchid`= '$branchid'
				and `warehouseid`= '$warehouseid'
				and `companyid`= '$companyid'
				;
			";
			$this->model->executeQuery($sqlUpdate);				
		}
		$arrayDelete = array();
		$arrayDelete['dateupdate']  = $timeNow;
		$arrayDelete['isdelete'] = 1;
		$arrayDelete['userupdate'] = $this->login->username;
		$this->model->table($this->base_model->tb_output_createorders())
					   ->where("uniqueid in ($uniqueid)")
					   ->update($arrayDelete);
					   
		$this->model->table($this->base_model->tb_output())
					   ->where("uniqueid in ($uniqueid)")
					   ->update($arrayDelete);
		
		#end
		//Trừ hàng trong kho
		foreach($inputList as $kk=>$suquantity){
			$sqlUpdate = "
				UPDATE `".$this->base_model->tb_inventory()."` 
				SET `quantity`= `quantity` - ".fmNumberSave($suquantity)." 
				WHERE `goodsid`='".$kk."'
				and `warehouseid` = '".$array['warehouseid']."'
				and `branchid` = '".$this->login->branchid ."'
				;
			";
			$this->model->executeQuery($sqlUpdate);
		}
		// Get PO
		$querypo = $this->model->table($this->base_model->tb_output_createorders())
					  ->select('poid,uniqueid')
					  ->where('id',$id)
					  ->find();
		$poid = $querypo->poid;	
		$uniqueid =  $querypo->uniqueid;	
		//Kiem tra PO
		$poid = $array['poid']; 
		$setuppo = $this->login->setuppo;
		if($setuppo == 1){
			//Kiem tra ton tai PO
			$checkPOid = $this->model->table($this->base_model->tb_output_createorders())
								 ->select('poid')
								 ->where('poid',$poid )
								 ->where('uniqueid <>',$uniqueid)
								 ->where('isdelete',0)
								 ->find();
			if(!empty($checkPOid->poid)){
				$status['uniqueid'] = -2;
				$status['poid'] = $poid;
				$status['msg'] = 'Mã đơn hàng đã tồn tại';
				return $status; //PO đa tồn tại
			}
		}
		//print_r($uniqueid); exit;
		//Lay so luong
		$totalQuantity = 0;
		$totalPrice = 0;
		foreach($inputList as $goodsid=>$input){
			$input = str_replace(',','',$input);
			$totalQuantity+=  $input;
			$priceone = str_replace(',','',$inputPriceone[$goodsid]);
			$totalPrice+= ($input * $priceone);
		}
		//Tinh them tien thue
		$vat = $array['vat'];
		$totalVat = round($totalPrice * $vat /100,cfnumber());
		$price_total = $totalPrice + $totalVat;
		
		$price_prepay =  str_replace(',','',$array['price_prepay']);
		$price_total = fmNumberSave($price_total);
		$price_prepay = fmNumberSave($price_prepay);
		
		if($price_prepay > $price_total){
			$price_prepay = $price_total;
		}
		elseif($price_prepay < 0){
			$price_prepay = 0;
		}
		if($price_prepay < $price_total){
			$insert['payments_status'] = -1; //Ghi nhan co cong no
		}
		// Insert vao bang hoa don nhap - hotel_input_createorders
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
		$insert['price_total'] = fmNumberSave($price_total);
		$insert['price'] = fmNumberSave($totalPrice);
		$insert['price_prepay'] = fmNumberSave($price_prepay); 
		$insert['isout'] = 1;
		$insert['datepo'] =  $findOrder->datepo;
		$insert['stt'] = $findOrder->stt;
		$insert['place_of_delivery'] = $array['place_of_delivery'];
		$insert['deliverydate'] = fmDateSave($array['deliverydate']); 
		$insert['signature_x'] = $this->login->signature;
		$insert['signature_name_x'] = $this->login->fullname;
		$this->model->table($this->base_model->tb_output_createorders())->insert($insert);
		// Insert vao bang chi tiet nhap - hotel_input
			
		$insertInput = array();
		$insertInput['warehouseid'] = $array['warehouseid'];
		$insertInput['companyid'] = $companyid;
		$insertInput['branchid'] = $branchid;
		$insertInput['datecreate'] = $timeNow;
		$insertInput['usercreate'] = $array['usercreate'];
		$insertInput['poid'] = $poid;
		$insertInput['uniqueid'] = $uniqueid;
		//Get Price
		$goodlist = '';
		foreach($inputList as $goodsid=>$input){ 
			$goodlist.= ','.$goodsid;
		}
		$goodlist = substr($goodlist,1);
		$arrPrice = $this->model->table($this->base_model->tb_goods())
					->where("id in ($goodlist)")
					->find_combo('id','buy_price');
		//$inputPriceone 
		foreach($inputList as $goodsid=>$input){
			$priceone = str_replace(',','',$inputPriceone[$goodsid]);
			$insertInput['quantity'] = fmNumberSave($input);
			$insertInput['goodsid'] = $goodsid;
			$insertInput['priceone'] = fmNumberSave($priceone);
			$insertInput['price'] = fmNumberSave($priceone * $input);
			$pricein = 0;
			if(isset($arrPrice[$goodsid])){
				$pricein = $arrPrice[$goodsid];
			}
			$insertInput['pricein'] = $pricein;
			$this->model->table($this->base_model->tb_output())->insert($insertInput);
		}
		#region Nhập vào phiếu thu
		//Lấy lại code cũ
		$check = $this->model->table($this->base_model->tb_receipts())
							 ->select('receipts_code')
							 ->where('uniqueid',$uniqueid)
							 //->where('isdelete',0) kho can lay isdelete vi unique ton tao duy nhat cho 1 po
							 ->where('receipts_code is not null')
							  ->order_by('id','DESC')
							 ->find();
		//Xoa phieu thu cu
		$updateDelete = array();
		$updateDelete['isdelete'] = 1;
		$this->model->table($this->base_model->tb_receipts())
					->where('uniqueid',$uniqueid)
					->update($updateDelete);
		
		$arrIS =  array();
		$update['receipts_code'] = $check->receipts_code;
		$arrIS['uniqueid'] = $uniqueid;
		$arrIS['companyid'] = $companyid;
		$arrIS['branchid'] = $branchid;
		$arrIS['receipts_type'] = 1;
		$arrIS['payment'] = $array['payments'];
		$arrIS['amount'] = fmNumberSave($price_prepay);
		$arrIS['poid'] = $poid;
		$arrIS['usercreate'] = $array['usercreate'];
		$arrIS['datecreate'] = $timeNow;
		
		$this->model->table($this->base_model->tb_receipts())->insert($arrIS);
		#end
		$this->db->trans_complete();
		$arr = array();
		$arr['uniqueid'] = $uniqueid;
		$arr['poid'] = $poid;
		$arr['msg'] = '';
		return $arr;
	 }
	function findGoodsID($id){
		$output = $this->base_model->tb_output();
		$goods = $this->base_model->tb_goods();
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
		 $query = $this->model->table($this->base_model->tb_output())
					  ->select('*')
					  ->where('id',$id)
					  ->find();
		return $query;
	}
	function findListID($id,$unit=''){
		 $createorders = $this->base_model->tb_output_createorders();
		 $warehouse = $this->base_model->tb_warehouse();
		 $customer = $this->base_model->tb_customer();
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
		 $goods = $this->base_model->tb_goods();
		 $warehouse = $this->base_model->tb_warehouse();
		 $output = $this->base_model->tb_output();
		 $unit = $this->base_model->tb_unit();
		 $query = $this->model->table($this->base_model->tb_output())
					  ->select("warehouse_name,goods_code,goods_code2,DES_DECRYPT(goods_name,'".$this->login->skey ."') goods_name,poid,quantity,price,priceone,unit_name")
					  ->join($goods,$goods.'.id = '.$output.'.goodsid','left')
					  ->join($warehouse,$warehouse.'.id = '.$output.'.warehouseid','left')
					  ->join($unit,$unit.'.id = '.$goods.'.unitid','left')
					  ->where($output.".uniqueid in ($uniqueid)")
					  ->where($output.'.isdelete',0)
					  ->find_all();
		return $query;
	}
	function findUniqueid($uniqueid){
		 $sql = "
			SELECT s.id, s.uniqueid, s.goodsid, s.quantity, g.sale_price, (s.quantity * g.sale_price) as price, g.goods_code, g.goods_name,  un.unit_name, s.employeeid, s.customer_id, sc.phone, sc.address
			FROM `".$this->base_model->tb_output()."` s
			left join `".$this->base_model->tb_goods()."` g on g.id = s.goodsid and g.isdelete = 0
			left join `".$this->base_model->tb_unit()."` un on un.id = g.unitid
			left join `".$this->base_model->tb_customer()."` sc on sc.id = s.customer_id
			where s.uniqueid = '$uniqueid'
			and s.isdelete = 0
		 ";
		 $query = $this->model->query($sql)->execute();
		 return $this->model->query($sql)->execute();
	 }
	function findOrder($id){
		 $query = $this->model->table($this->base_model->tb_output_createorders())
					  ->select('*')
					  ->where('id',$id)
					  ->where('isout',0)
					  ->find();
		return $query;
	 }
	function deletes($id, $array){
		$this->db->trans_start();
		$result = $this->model->table($this->base_model->tb_output_createorders())
					   ->select('id,uniqueid')
					   ->where("id in ($id)")
					   ->find();	
		$query = $this->model->table($this->base_model->tb_output())
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
				UPDATE `".$this->base_model->tb_inventory()."` SET `quantity`=`quantity`+ $quantity 
				WHERE `id` > 0
				and `goodsid`= '".$goodsid->goodsid ."'
				and `branchid`= '$branchid'
				and `warehouseid`= '$warehouseid'
				and `companyid`= '$companyid'
				;
			 ";
			 $this->model->executeQuery($sqlUpdate);				
		}
		$this->model->table($this->base_model->tb_output_createorders())
					   ->where("uniqueid in ($uniqueid)")
					   ->update($array);
					   
		$this->model->table($this->base_model->tb_output())
					   ->where("uniqueid in ($uniqueid)")
					   ->update($array);
		$this->db->trans_complete();
		return 1;
	}
	function findGoods($id,$code){
		$code = trim($code);
		$companyid = $this->login->companyid;
		if(empty($code)){
			$and = " and s.id = '$id' ";
		}
		else{
			$and = " and s.goods_code = '$code' ";
		}
		$sql = "
			SELECT s.id, s.img ,s.id as goodsid, s.goods_code, DES_DECRYPT(s.goods_name,'".$this->login->skey ."') as goods_name, un.unit_name, s.sale_price, s.buy_price,
			'1' as quantity, '' as uniqueid, (1*s.sale_price) as price
			FROM `".$this->base_model->tb_goods()."` s
			left join `".$this->base_model->tb_unit()."` un on un.id = s.unitid
			where s.companyid = '$companyid'
			$and
			and s.isdelete = 0
		 ";
		 $query = $this->model->query($sql)->execute();
		 $array['datas'] = $query;
		 $array['finds'] = new stdClass();				 
		 return $array;
	}
	function getNoneCreateorders(){
		$sql = "
		SELECT column_name
		FROM information_schema.columns
		WHERE table_name='".$this->base_model->tb_output_createorders()."'; 
		";
		$query = $this->model->query($sql)->execute();
		$obj = new stdClass();
		foreach($query as $item){
			$clm = $item->column_name;
			$obj->$clm = null;
		}
		return $obj;
	}
	function findGoodsByPO($poid){
		$companyid = $this->login->companyid;
		$skey = $this->login->skey;
		$find = $this->model->table($this->base_model->tb_output_createorders())
							 ->select("place_of_delivery,deliverydate,poid,uniqueid,customer_id,customer_type,employeeid,warehouseid,payments,quantity,price,price_prepay,
							 DES_DECRYPT(customer_name,'".$skey."') as customer_name,
							 customer_address,
							 customer_phone,
							 customer_email,
							 DATE_FORMAT(datecreate,'%m-%d-%Y') as datecreate,description, (price - price_prepay) as cl
							 ")
							 ->where('isdelete',0)
							 ->where('companyid',$companyid)
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
			DES_DECRYPT(g.goods_name,'".$skey."') as goods_name,  un.unit_name,  g.sale_price as sale_price, (g.sale_price * s.quantity) as price 
			FROM `".$this->base_model->tb_output()."` s
			left join `".$this->base_model->tb_goods()."` g on g.id = s.goodsid and g.isdelete = 0
			left join `".$this->base_model->tb_unit()."` un on un.id = g.unitid
			where s.uniqueid = '$uniqueid'
			and s.isdelete = 0
		 ";
		 $query = $this->model->query($sql)->execute();
		 $array['datas'] = $query;
		 $array['finds'] = $find;				 
		 return $array;
	}
	function saveCustomer($arrays){
		foreach($arrays as $k=>$v){
			$kk = str_replace("_a_","",$k);
			$array[$kk] = $v;
		}
		$check = $this->model->table($this->base_model->tb_customer())
					  ->select('id')
					  ->where('isdelete',0)
					  ->where('customer_name',$array['customer_name'])
					  ->where('companyid',$this->login->companyid)
					  ->find();
		if(!empty($check->id)){
			return -1;	
		}
		$array['companyid'] = $this->login->companyid;
		$result = $this->model->table($this->base_model->tb_customer())->save('',$array);	
		return $result;
	}
	function getListExport($search){
		$sql = "";
		$companyid = $this->login->companyid;
		$branchid = $this->login->branchid;
		$sql.= " and c.companyid = '".$companyid."' ";	
		if($this->login->grouptype == 4){
			$sql.= " and c.usercreate = '".$this->login->groupname ." ";	
		}
		if(!empty($branchid)){
			$sql.= " and c.branchid in (".$branchid.") ";	
		}
		if(!empty($search['customer_name'])){
			$sql.= " and DES_DECRYPT(c.customer_name,'".$this->login->skey ."')  like '%".$search['customer_name']."%' ";	
		}
		if(!empty($search['customer_type'])){
			$sql.= " and c.customer_type in (".$search['customer_type'].") ";	
		}
		
		if(!empty($search['phone'])){
			$sql.= " and DES_DECRYPT(c.phone,'".$this->login->skey ."') like '%".$search['customer_name']."%' ";	
		}
		if(!empty($search['formdate'])){
			$sql.= " and c.datecreate <= '".date('Y-m-d',strtotime($search['formdate']))."' ";	
		}
		if(!empty($search['todate'])){
			$sql.= " and c.datecreate >= '".date('Y-m-d',strtotime($search['todate']))."' ";	
		}
		$sqlS = "
			SELECT so.*, g.goods_code, DES_DECRYPT(g.goods_name,'".$this->login->skey ."') as goods_name, ut.unit_name,
			DES_DECRYPT(cm.customer_name,'".$this->login->skey ."') as cmname, 
			DES_DECRYPT(cm.phone,'".$this->login->skey ."') as cmphone,
			DES_DECRYPT(cm.address,'".$this->login->skey ."') as cmaddress,cm.email as cmemail, c.customer_type, 
			DES_DECRYPT(e.employee_name,'".$this->login->skey ."') as employee_name
			FROM `".$this->base_model->tb_output()."` so
			left join `".$this->base_model->tb_output_createorders()."` c on c.uniqueid = so.uniqueid
			left join `".$this->base_model->tb_goods()."` g on g.id = so.goodsid and g.isdelete = 0
			left join `".$this->base_model->tb_unit()."` ut on ut.id = g.unitid
			LEFT JOIN `".$this->base_model->tb_customer()."` cm on cm.id = c.customer_id and cm.isdelete = 0
			LEFT JOIN `".$this->base_model->tb_employeesale()."` e on e.id = c.employeeid and e.isdelete = 0
			where so.isdelete = 0
			and c.isout = 1
		";
		$sqlS.= $sql;
		$query = $this->model->query($sqlS)->execute();
		return $query; 
	}
	function getDetailEdit($uniqueid=''){
		 $goods = $this->base_model->tb_goods();
		 $warehouse = $this->base_model->tb_warehouse();
		 $output = $this->base_model->tb_output();
		 $createorders = $this->base_model->tb_output_createorders();
		 $unit = $this->base_model->tb_unit();
		 $sql = "
			SELECT c.place_of_delivery, c.deliverydate, o.id, c.id as createordersid, c.uniqueid, c.customer_id, c.customer_type, c.customer_name, c.customer_address, c.customer_phone, c.customer_email, u.unit_name , c.poid, c.usercreate,
				c.employeeid, c.warehouseid, c.payments, o.quantity, o.priceone, o.price, g.id as goodsid, 
				g.goods_code, DES_DECRYPT(g.goods_name,'".$this->login->skey ."') as goods_name, 
				c.price as pricetotal, c.description, c.vat
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
		$yearDay = fmMonthSave($datecreate);
		$checkPOid = $this->model->table($this->base_model->tb_receipts())
							 ->select('receipts_code')
							 ->where("datepo like '$yearDay%'")
							 ->where('branchid',$branchid)
							 ->where('isdelete',0)
							 ->order_by('id','DESC')
							 ->find();
		if(!empty($checkPOid->receipts_code)){
			$poc = $checkPOid->receipts_code;
		}
		else{
			$poc = date('ym',strtotime($yearDay)).'00000';
		}
		$receipts_code = $poc + 1;
		return $receipts_code;
	}
	function createPoOrder($branchid,$datecreate){
		$yearDay = fmMonthSave($datecreate);
		//$yearDay = gmdate("Y-m", time() + 7 * 3600);
		$checkPOid = $this->model->table($this->base_model->tb_output_createorders())
							 ->select('poid,stt')
							 ->where("datepo like '$yearDay%'")
							 ->where('branchid',$branchid)
							 ->where('isdelete',0)
							 ->order_by('id','DESC')
							 ->find();
		if(!empty($checkPOid->poid)){
			$poc = $checkPOid->poid;
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
		$array['poid'] = $poc + 1;
		$array['stt'] = $stt + 1;
		return $array;
	}
}