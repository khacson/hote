<?php
/**
 * @author Son Nguyen
 * @copyright 2018
 */
 class OrderroomModel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->login = $this->site->getSession('login');
		$this->ctr = 101;
	}
	function findID($id){
		$tb = $this->base_model->loadTable();
        $query = $this->model->table($tb['hotel_room'])
					  ->where('isdelete',0)
					  ->where('id',$id)
					  ->find();
        return $query;
    }
	function findService($roomid){
		$tb = $this->base_model->loadTable();
        $query = $this->model->table($tb['hotel_add_temp'])
					  ->select('id')
					  ->where('roomid',$roomid)
					  ->limit(1)
					  ->find();
		$find = 0;
		if(!empty($query->id)){
			$find = $query->id;
		}
        return $find;
    }
	function getPriceList() {
		$login = $this->login;
		$tb = $this->base_model->loadTable();
        $query = $this->model->table($tb['hotel_roomprice'])
					  ->select('id,roomprice_name')
					  ->where('isdelete',0)
					  ->where('branchid',$login->branchid)
					  ->order_by('roomprice_name')
					  ->find_all();
        return $query;
    }
	function getRoomType($floorid=""){
		$login = $this->login;
		$tb = $this->base_model->loadTable();
		$and = "";
		if(!empty($floorid)){
			$and = " and r.floorid = '$floorid'";
		}
		if(!empty($login->branchid)){
			$and = " and r.branchid = '".$login->branchid ."'";
		}
		$sql = "
			select r.roomtypeid, count(1) total
				from `".$tb['hotel_room']."` r
				where r.isdelete = 0
				$and
				group by r.roomtypeid
		";
		$query =  $this->model->query($sql)->execute();
		$array = array();
		foreach($query as $item){
			$array[$item->roomtypeid] = $item->total;
		}
		return $array;
	}
	function getRoomList($floorid='', $roomtypeid='',$isstatus=''){
		$login = $this->login;
		$tb = $this->base_model->loadTable();
		$and = "";
		if(!empty($floorid)){
			$and.= " and r.floorid = '$floorid'";
		}
		if(!empty($roomtypeid)){
			$and.= " and r.roomtypeid = '$roomtypeid'";
		}
		if(!empty($isstatus)){
			$and.= " and r.isstatus = '$isstatus'";
		}
		if(!empty($login->branchid)){
			$and.= " and r.branchid = '".$login->branchid ."'";
		}
		$sql = "
			select r.*
				from `".$tb['hotel_room']."` r
				where r.isdelete = 0
				$and
				order by r.room_name asc
		";
		$datas =  $this->model->query($sql)->execute();
		//Phòng trống 
		$ands = "";
		if(!empty($floorid)){
			$ands.= " and r.floorid = '$floorid'";
		}
		if(!empty($roomtypeid)){
			$ands.= " and r.roomtypeid = '$roomtypeid'";
		}
		if(!empty($isstatus) && !empty($roomtypeid)){
			$and.= " and r.isstatus = '$isstatus'";
		}
		if(!empty($login->branchid)){
			$ands.= " and r.branchid = '".$login->branchid ."'";
		}
		$sql1 = "
			SELECT r.floorid, r.isstatus, count(1) total
			FROM hotel_room_6 r
			where r.isdelete = 0
			$ands
			group by r.floorid, r.isstatus
			;
		";
		$status =  $this->model->query($sql1)->execute();
		$array = array();
		$array['datas'] = $datas;
		$array['status'] = $status;
		return $array;
	}
	function checkPhone($phone){//Xóa khoảng trắng của số điện thoại
		$arrPhone = explode(' ',$phone);
		$strPhone = '';
		foreach($arrPhone as $key=>$val){
			if(!empty($val)){
				$strPhone.= $val;
			}
		}
		return $strPhone;
	}
	function findGoods($id,$code,$stype,$exchangs,$delete='',$isnew,$xkm,$uniqueid,$findgoods,$roomid){
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
						  ->where('roomid',$roomid)
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
						   ->where('roomid',$roomid)
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
				$arrAdd['roomid'] = $roomid;
				$arrAdd['datecreate'] = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
				$arrAdd['unitid'] = $findgoods->unitid; //Mặc đinh là đơn vị nhỏ nhất
				$this->model->table($tb['hotel_add_temp'])->insert($arrAdd);
			}
			else{//co roi update so luon
				$this->model->table($tb['hotel_add_temp'])->save($check->id,$arrAdd);
			}
		}
		return $this->getTempGood($userid,$isnew,$roomid);
	}
	function getTempGood($userid,$isnew = 0,$roomid){
		$tb = $this->base_model->loadTable();
		$skey = $this->login->skey;
		$branchid = $this->login->branchid;
		$and = ''; //sale_price
		$and.= " and sat.roomid = '$roomid'";
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
				un.unit_name, un.id as unitid, sat.unitid as satunitid, s.unitid_active, s.sale_price
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
	function checkTempData($query,$isnew,$roomid){
		$tb = $this->base_model->loadTable();
		foreach($query as $item){
			$check = $this->model->table($tb['hotel_add_temp'])
							     ->select('id')
								 ->where('contronller',$this->ctr)
								 ->where('goodid',$item->goodsid)
								 ->where('userid',$this->login->id)
								 ->where('isnew',$isnew)
								 ->where('roomid',$roomid)
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
				$arrAdd['roomid'] = $roomid;
				$arrAdd['guarantee'] = $item->guaranteeOut;
				$arrAdd['datecreate'] = gmdate("Y-m-d H:i:s", time() + 7 * 3600);;
				$this->model->table($tb['hotel_add_temp'])->insert($arrAdd);
			}
		}
	}
	function deleteTempData($detailid){
		$userid =  $this->login->id;
		$tb = $this->base_model->loadTable();
		$this->model->table($tb['hotel_add_temp'])
						  ->where('id',$detailid)
						  ->delete();
	}
	function saves($array,$itemList,$otherCus,$roomid,$id){
		$this->db->trans_start();
		$uniqueid = $this->base_model->getUniqueid();
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
		if(!empty($stringID)){
			$stringID = substr($stringID,1);
		}
		else{
			$stringID = 0;
		}
		//
		$tbTemp = $tb['hotel_add_temp'];
		$tbGoods = $tb['hotel_goods'];
		$unitNode = $tbGoods.'.unitid as unitidNode';
		$sql = "
			SELECT st.*, g.isnegative, g.unitid AS unitidNode, g.goods_name
			FROM `$tbTemp` st
			LEFT JOIN `$tbGoods` g ON g.id = goodid
			WHERE st.id IN ($stringID)
			AND st.roomid = '$roomid'
		";
		$queryTemp = $this->model->query($sql)->execute();
		#region kiểm kho
		if(count($queryTemp) > 0){	
			$listError = '';
			foreach($queryTemp as $item){
				//Kiểm tra số lượng trong kho
				$checkInventory = $this->model->table($tb['hotel_inventory'])
									   ->select('id,quantity')
									   ->where('branchid',$branchid)
									   ->where('goodsid',$item->goodid)
									   ->where('warehouseid',0)
									   ->where('isdelete',0)
									   ->find();
				if(empty($checkInventory->id)){
					//Them vao kho
					$arrAddInventorey = array();
					$arrAddInventorey['branchid'] = $branchid; 
					$arrAddInventorey['warehouseid'] = 0;
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
			if($listError != ''){
				$arr = array();
				$arr['status'] = 0;
				$arr['msg'] = ' Tồn kho không đủ: <br>'.$listError;
				return $arr; exit;
			}
		}
		#end
		#region Tru hang hoa trong kho
		if(count($queryTemp) > 0){
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
					AND `warehouseid` = '0'
					;
				";
				$this->model->executeQuery($sqlUpdate);
			}
		}  
		#end
		#region Check Phòng trống
		$checkRoomid = $this->model->table($tb['hotel_orderroom'])
								 ->select('id')
								 ->where('roomid',$roomid )
								 ->where('isnew',1 )
								 ->where('isdelete',0)
								 ->find();
		if(!empty($checkRoomid->id)){
			$arr = array();
			$arr['status'] = 0;
			$arr['msg'] = ' Phòng đang có khách';
			return $arr; exit;
		} 
		#end
		#region Lưu dữ liệu đặt phòng
		$arrRoomOder = array();
		$arrRoomOder['roomid'] = $roomid;
		$arrRoomOder['fromdate'] =  fmDateSave($array['fromdate']).' '.$array['fromdateHours'].':'.$array['fromdateMinute'];
		$arrRoomOder['todate'] = fmDateSave($array['todate']).' '.$array['todateHours'].':'.$array['todateMinute'];;
		$arrRoomOder['price'] = 0;
		$arrRoomOder['lease'] = $array['lease'];
		$arrRoomOder['price_type'] = $array['price_type'];
		$arrRoomOder['description'] = $array['description'];
		$arrRoomOder['isnew'] = 1;
		$arrRoomOder['datecreate'] = $timeNow;
		$arrRoomOder['usercreate'] =  $this->login->username;
		$arrRoomOder['branchid'] =  $branchid;
		$this->model->table($tb['hotel_orderroom'])->insert($arrRoomOder);
		//Cập nhật tình trạng đặt phòng vào table đặt phòng => 2 = Phòng có khách
		$this->model->table($tb['hotel_room'])
					->where('id',$roomid)
					->update(array('isstatus'=>2));
		$getOderRoom = $this->table($tb['hotel_orderroom'])
							->select('id')->where('isnew',1)
							->where('roomid',$roomid)
							->find();
		$oderromid = 0;
		if(!empty($getOderRoom->id)){
			$oderromid = $getOderRoom->id;
		}
		#end
		#region insert Customer
		$customer_name = $array['customer_name'];
		$customer_cmnd = $array['customer_cmnd'];
		$checkCustomer = $this->model->table($tb['hotel_customer'])
								 ->select('id')
								 ->where('customer_name',$customer_name )
								 ->where('identity',$customer_cmnd)
								 ->find();
		$customerid = 0;
		$arrCustomer  = array();
		$arrCustomer['customer_name'] = $customer_name;
		$arrCustomer['identity'] = $customer_cmnd;
		if(!empty($array['identity_date'])){
			$arrCustomer['identity_date'] = fmDateSave($array['identity_date']);
		}
		if(!empty($array['identity_from'])){
			$arrCustomer['identity_from'] = $array['identity_from'];
		}
		if(!empty($array['customer_phone'])){
			$arrCustomer['phone'] = $array['customer_phone'];
		}
		if(!empty($array['customer_address'])){
			$arrCustomer['address'] = $array['customer_address'];
		}
		if(!empty($array['customer_comppany'])){
			$arrCustomer['company_name'] = $array['customer_comppany'];
		}
		if(!empty($array['customer_mst'])){
			$arrCustomer['taxcode'] = $array['customer_mst'];
		}
		if(!empty($checkCustomer->id)){
			$customerid = $checkCustomer->id;
			$this->model->table($tb['hotel_customer'])->where('id',$customerid)->update($arrCustomer);
		}
		else{
			//Thêm mới khách hàng
			$arrCustomer['datecreate'] = $timeNow;
			$arrCustomer['usercreate'] =  $this->login->username;
			$this->model->table($tb['hotel_customer'])->insert($arrCustomer);
			$checkCustomer = $this->model->table($tb['hotel_customer'])
								 ->select('id')
								 ->where('customer_name',$customer_name )
								 ->where('identity',$customer_cmnd)
								 ->find();
			$customerid = $checkCustomer->id;
		}
		#end
		#region lịch sử đặt phòng khách hàng
		$arrHistory1 = array();
		$arrHistory1['customerid'] = $customerid;
		$arrHistory1['branchid'] = $branchid;
		$arrHistory1['roomid'] = $roomid;
		$arrHistory1['oderromid'] = $oderromid;
		$arrHistory1['datecreate'] = $timeNow;
		$this->model->table($tb['hotel_customer_history'])->insert($arrHistory1);
		#end
		#region khách hàng khách
		$otherCusArray = json_decode($otherCus,true);
		if(count($otherCusArray) > 0){
			 //Khách hàng 1
			 if(!empty($otherCusArray['c1']['customer_name1'])){
				 $arrC1 = array();
				 $arrC1['customer_name'] = $otherCusArray['c1']['customer_name1'];
				 $arrC1['identity'] = $otherCusArray['c1']['customer_cmnd1'];
				 if(!empty($otherCusArray['c1']['identity_date1'])){
					$arrC1['identity_date'] = fmDateSave($otherCusArray['c1']['identity_date1']);
				 }
				 if(!empty($otherCusArray['c1']['identity_from1'])){
					$arrC1['identity_from'] = $otherCusArray['c1']['identity_from1'];
				 }
				 if(!empty($otherCusArray['c1']['customer_phone1'])){
					$arrC1['phone'] = $otherCusArray['c1']['customer_phone1'];
				 }
				 if(!empty($otherCusArray['c1']['customer_address1'])){ 
					$arrC1['address'] = $otherCusArray['c1']['customer_address1'];
				 }
				 if(!empty($otherCusArray['c1']['customer_comppany1'])){ 
					$arrC1['company_name'] = $otherCusArray['c1']['customer_comppany1'];
				 }
				 if(!empty($otherCusArray['c1']['customer_mst1'])){ 
					$arrC1['taxcode'] = $otherCusArray['c1']['customer_mst1'];
				 }
				 //Check Insert 1
				 $checkCustomer1 = $this->model->table($tb['hotel_customer'])
								 ->select('id')
								 ->where('customer_name',$arrC1['customer_name'])
								 ->where('identity',$arrC1['identity'])
								 ->find();
				 if(!empty($checkCustomer1->id)){
					 $customerid1 = $checkCustomer1->id;
					 $this->model->table($tb['hotel_customer'])
								->where('id',$customerid1)
								->update($arrC1);
					
				 }
				 else{
					//Thêm mới khách hàng
					$arrC1['datecreate'] = $timeNow;
					$arrC1['usercreate'] =  $this->login->username;
					$this->model->table($tb['hotel_customer'])->insert($arrC1);
					$checkCustomer1 = $this->model->table($tb['hotel_customer'])
								 ->select('id')
								 ->where('customer_name',$arrC1['customer_name'])
								 ->where('identity',$arrC1['identity'])
								 ->find();
					$customerid1 = $checkCustomer1->id;
				 }
				 $arrHistory1 = array();
				 $arrHistory1['customerid'] = $customerid1;
				 $arrHistory1['branchid'] = $branchid;
				 $arrHistory1['roomid'] = $roomid;
				 $arrHistory1['oderromid'] = $oderromid;
				 $arrHistory1['datecreate'] = $timeNow;
				 $this->model->table($tb['hotel_customer_history'])->insert($arrHistory1);
			 }
			 //Khách hàng 2
			 if(!empty($otherCusArray['c2']['customer_name2'])){
				 $arrC2 = array();
				 $arrC2['customer_name'] = $otherCusArray['c2']['customer_name2'];
				 $arrC2['identity'] = $otherCusArray['c2']['customer_cmnd2'];
				 if(!empty($otherCusArray['c2']['identity_date2'])){
					$arrC2['identity_date'] = fmDateSave($otherCusArray['c2']['identity_date2']);
				 }
				 if(!empty($otherCusArray['c2']['identity_from2'])){
					$arrC2['identity_from'] = $otherCusArray['c2']['identity_from2'];
				 }
				 if(!empty($otherCusArray['c2']['customer_phone2'])){
					$arrC2['phone'] = $otherCusArray['c2']['customer_phone2'];
				 }
				 if(!empty($otherCusArray['c2']['customer_address2'])){ 
					$arrC2['address'] = $otherCusArray['c2']['customer_address2'];
				 }
				 if(!empty($otherCusArray['c2']['customer_comppany2'])){ 
					$arrC2['company_name'] = $otherCusArray['c2']['customer_comppany2'];
				 }
				 if(!empty($otherCusArray['c2']['customer_mst2'])){ 
					$arrC2['taxcode'] = $otherCusArray['c2']['customer_mst2'];
				 }
				 //Check Insert 2
				 $checkCustomer2 = $this->model->table($tb['hotel_customer'])
								 ->select('id')
								 ->where('customer_name',$arrC2['customer_name'])
								 ->where('identity',$arrC2['identity'])
								 ->find();
				 if(!empty($checkCustomer2->id)){
					 $customerid2 = $checkCustomer2->id;
					 $this->model->table($tb['hotel_customer'])
								->where('id',$customerid2)
								->update($arrC2);
				 }
				 else{
					//Thêm mới khách hàng
					$arrC2['datecreate'] = $timeNow;
					$arrC2['usercreate'] =  $this->login->username;
					$this->model->table($tb['hotel_customer'])->insert($arrC2);
					$checkCustomer2 = $this->model->table($tb['hotel_customer'])
								 ->select('id')
								 ->where('customer_name',$arrC2['customer_name'])
								 ->where('identity',$arrC2['identity'])
								 ->find();
					$customerid2 = $checkCustomer2->id;
				 }
				 $arrHistory1 = array();
				 $arrHistory1['customerid'] = $customerid2;
				 $arrHistory1['branchid'] = $branchid;
				 $arrHistory1['roomid'] = $roomid;
				 $arrHistory1['oderromid'] = $oderromid;
				 $arrHistory1['datecreate'] = $timeNow;
				 $this->model->table($tb['hotel_customer_history'])->insert($arrHistory1);
			 }
			 //Khách hàng 3
			 if(!empty($otherCusArray['c3']['customer_name3'])){
				 $arrC3 = array();
				 $arrC3['customer_name'] = $otherCusArray['c3']['customer_name3'];
				 $arrC3['identity'] = $otherCusArray['c3']['customer_cmnd3'];
				 if(!empty($otherCusArray['c3']['identity_date3'])){
					$arrC3['identity_date'] = fmDateSave($otherCusArray['c3']['identity_date3']);
				 }
				 if(!empty($otherCusArray['c3']['identity_from3'])){
					$arrC3['identity_from'] = $otherCusArray['c3']['identity_from3'];
				 }
				 if(!empty($otherCusArray['c3']['customer_phone3'])){
					$arrC3['phone'] = $otherCusArray['c3']['customer_phone3'];
				 }
				 if(!empty($otherCusArray['c3']['customer_address3'])){ 
					$arrC3['address'] = $otherCusArray['c3']['customer_address3'];
				 }
				 if(!empty($otherCusArray['c3']['customer_comppany3'])){ 
					$arrC3['company_name'] = $otherCusArray['c3']['customer_comppany3'];
				 }
				 if(!empty($otherCusArray['c3']['customer_mst3'])){ 
					$arrC3['taxcode'] = $otherCusArray['c3']['customer_mst3'];
				 }
				 //Check Insert 3
				 $checkCustomer3 = $this->model->table($tb['hotel_customer'])
								 ->select('id')
								 ->where('customer_name',$arrC3['customer_name'])
								 ->where('identity',$arrC3['identity'])
								 ->find();
				 if(!empty($checkCustomer3->id)){
					$customerid3 = $checkCustomer3->id;
					$this->model->table($tb['hotel_customer'])
								->where('id',$customerid3)
								->update($arrC3);
					
				 }
				 else{
					//Thêm mới khách hàng
					$arrC3['datecreate'] = $timeNow;
					$arrC3['usercreate'] =  $this->login->username;
					$this->model->table($tb['hotel_customer'])->insert($arrC3);
					$checkCustomer3 = $this->model->table($tb['hotel_customer'])
								 ->select('id')
								 ->where('customer_name',$arrC3['customer_name'])
								 ->where('identity',$arrC3['identity'])
								 ->find();
					$customerid3 = $checkCustomer3->id;
				 }
				 $arrHistory1 = array();
				 $arrHistory1['customerid'] = $customerid3;
				 $arrHistory1['branchid'] = $branchid;
				 $arrHistory1['roomid'] = $roomid;
				 $arrHistory1['oderromid'] = $oderromid;
				 $arrHistory1['datecreate'] = $timeNow;
				 $this->model->table($tb['hotel_customer_history'])->insert($arrHistory1);
			 }
		}
		#end
		#region Tạo phiếu xuất kho
		$arrAuto = $this->createPoOrder($branchid,$timeNow);
		$poid = $arrAuto['poid'];
		if(count($queryTemp) > 0){
			$insert = array();
			$insert['description'] = $array['description'];
			$insert['customerid'] = $customerid;
			$insert['datecreate'] = $timeNow;
			$insert['usercreate'] =  $this->login->username;
			$insert['branchid'] =  $this->login->branchid;
			$insert['uniqueid'] = $uniqueid;
			$insert['datepo'] = fmDateSave($timeNow);
			$insert['poid'] = $poid;
			$insert['roomid'] = $roomid;
			$insert['signature_x'] = $this->login->signature;
			$insert['signature_name_x'] = $this->login->fullname;
			$insert['warehouseid'] = 0;
			$orderid = $this->model->table($tb['hotel_output'])->insert($insert);
			//Insert Detail
			$i=1;
			foreach($queryTemp as $item){
				$insertInput = array();
				$insertInput['warehouseid'] = 0;
				$insertInput['branchid'] = $branchid;
				$insertInput['customerid'] = $customerid;
				$insertInput['datecreate'] = $timeNow;
				$insertInput['usercreate'] = $this->login->fullname;
				$insertInput['poid'] = $poid;
				$insertInput['orderid'] = $orderid;
				$insertInput['quantity'] = $item->quantity;
				$insertInput['unitid'] = $item->unitid;
				$insertInput['goodsid'] = $item->goodid;
				$insertInput['priceone'] = $item->price;
				$insertInput['price'] = fmNumberSave($item->quantity * $item->price);
				$insertInput['sttview'] = $i;
				$insertInput['discount'] = $item->discount;
				$insertInput['discount_value'] = $item->discount_value;
				$insertInput['discount_type'] = $item->discount_type;
				$insertInput['serial_number'] = $item->serial_number;
				$insertInput['cksp'] = $item->xkm;
				$this->model->table($tb['hotel_output_detail'])->insert($insertInput);
				$i++;
			}
		}
		#end	
		#region xóa dữ liệu
		if(!empty($stringID)){
			$this->model->table($tbTemp)->where("id in ($stringID)")->where("roomid",$roomid)->delete();
		}
		#end
		$this->db->trans_complete();
		$arr = array();
		
		$arr['status'] = 1;
		$arr['msg'] = '';
		return $arr;
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
 }