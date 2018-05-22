<?php
/**
 * @author 
 * @copyright 2017
 */
 class CreateordersModel extends CI_Model{
	function __construct(){
		parent::__construct('');
		$this->login = $this->site->getSession('login');
		$this->ctr = 2;
	}
	function getOderList(){
		$tb = $this->base_model->loadTable();
		$query = $this->model->table($tb['hotel_output_createorders_order'])
					  ->select('poid,id')
					  ->where('isdelete',0)
					  ->find_all();
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
	function saves($uniqueid,$array){
		$this->db->trans_start();
		$tb = $this->base_model->loadTable();
		$timeNow  = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
		$companyid = $this->login->companyid;
		$branchid = $this->login->branchid;
		$userid = $this->login->id;
		
		$tbTemp = $tb['hotel_add_temp'];
		$tbGoods = $tb['hotel_goods'];
		$queryTemp = $this->model->table($tbTemp)
					->select($tbTemp.'.*, isnegative, goods_name')
					->join($tbGoods,$tbGoods.'.id='.$tbTemp.'.goodid','left')
					->where($tbTemp.'.contronller',$this->ctr)
					->where($tbTemp.'.userid',$userid)
					->where($tbTemp.'.uniqueid',$uniqueid)
					->where($tbTemp.'.isnew',0)
					->where($tbGoods.'.isdelete',0)
					->order_by($tbTemp.'.datecreate','asc')
					->find_all();	
		$arrGoods = array();
		$arrNegative = array();
		$arrGoodName = array();
		foreach($queryTemp as $item){
			$checkInventory = $this->model->table($tb['hotel_inventory'])
								   ->select('id')
								   ->where('branchid',$branchid)
								   ->where('goodsid',$item->goodid)
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
			}
			if(isset($arrGoods[$item->goodid])){
				$arrGoods[$item->goodid]+= $item->quantity;
			}
			else{
				$arrGoods[$item->goodid] = $item->quantity;	
			}
			$arrNegative[$item->goodid] = $item->isnegative;
			$arrGoodName[$item->goodid] = $item->goods_name;
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
			$checkPOid = $this->model->table($tb['hotel_output_createorders_order'])
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
		#region Tinh tien
		$t_tien = 0;
		foreach($queryTemp as $item){
			$quantity = $item->quantity;	
			$price = $item->price;
			$discount = $item->discount_value;	
			$thanhtien = ($quantity * $price) - $discount;
			$t_tien += $thanhtien; 
		}
		$vat = 0;
		if(!empty($array['vat'])){
			$vat = fmNumberSave($array['vat']);
		}
		$tontienthanhtoan = (($vat * $t_tien)/100) + $t_tien;
		#end 
		$insert = array();
		#region tinh tam ung
		$price_prepay = fmNumberSave($array['price_prepay']);
		if(empty($price_prepay)){
			$price_prepay = 0;
		}
		$insert['payments_status'] = 0;
		if($array['percent'] == 2){//Tinh %
			if($price_prepay > 100){ $price_prepay = 100; }
			$insert['percent_value'] = fmNumberSave($price_prepay);
			$prepays = fmNumberSave($price_prepay) * fmNumberSave($tontienthanhtoan) / 100; 
			$insert['price_prepay'] = $prepays;
			if($price_prepay < 100){
				$insert['payments_status'] = -1;  //con no
			}
		}
		else{//Tiem mat
			$insert['price_prepay'] = $price_prepay;
			if($price_prepay < fmNumberSave($tontienthanhtoan)){
				$insert['payments_status'] = -1; 
			}
		}
		#end
		#region insert
		$timeNow = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
		$insert['branchid'] = $branchid;
		$insert['description'] = $array['description'];
		$insert['customer_id'] = $array['customerid'];
		$insert['datecreate'] = $timeNow;
		$insert['usercreate'] =  $this->login->username;
		$insert['employeeid'] = $array['employeeid'];
		$insert['payments'] = $array['payments'];
		$insert['vat'] = (float)$array['vat'];
		$insert['uniqueid'] = $uniqueid;
		$insert['poid'] = $poid;
		$insert['price'] = fmNumberSave($t_tien);
		$insert['price_total'] = fmNumberSave($tontienthanhtoan);
		$insert['stt'] = $arrAuto['stt'];
		$insert['datepo'] = fmDateSave($array['datecreate']);
		
		$insert['place_of_delivery'] = $array['place_of_delivery'];
		$insert['deliverydate'] = fmDateSave($array['deliverydate']); 
		$insert['signature_x'] = $this->login->signature;
		$insert['signature_name_x'] = $this->login->fullname;
		$insert['warehouseid'] = 0;//$array['warehouseid'];
		$this->model->table($tb['hotel_output_createorders_order'])->insert($insert);	
		#end
		$orderid = $this->model->table($tb['hotel_output_createorders_order'])	
							   ->select('id')
							   ->where('uniqueid',$uniqueid)
							   ->find()->id;
		#region them bang detail
		$i=1;
		foreach($queryTemp as $item){
			$insertInput = array();
			$insertInput['warehouseid'] = 0;
			$insertInput['branchid'] = $branchid;
			$insertInput['datecreate'] = $timeNow;
			$insertInput['usercreate'] = $this->login->fullname;
			$insertInput['poid'] = $poid;
			$insertInput['orderid'] = $orderid;
			$insertInput['unitid'] = $item->unitid;
			$insertInput['quantity'] = $item->quantity;
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
			$this->model->table($tb['hotel_output_order'])->insert($insertInput);
			$i++;
		}
		#end
		#region Xoa du lieu bang tam
		$userid =  $this->login->id;
		$this->model->table($tb['hotel_add_temp'])
					->where('contronller',$this->ctr)
					->where('userid',$userid)
					->where('isnew',0)
					->delete();	
		#end
		#region ghi log
		$description = 'Thêm mới: Đơn hàng '.$poid;
		$this->base_model->addAcction('Đơn đặt hàng',$this->uri->segment(2),'','',$description );	
		#end
		$this->db->trans_complete();
		$arr = array();
		$arr['uniqueid'] = $uniqueid;
		//$arr['uniqueidnew'] = 
		$arr['poid'] = $poid;
		$arr['msg'] = '';
		return $arr;
	}
	function edits($orderid,$array){
		$this->db->trans_start();
		$tb = $this->base_model->loadTable();
		$timeNow  = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
		$companyid = $this->login->companyid;
		$branchid = $this->login->branchid;
		$userid = $this->login->id;
		#region lay thong tin ban dau
		$checkPOid = $this->model->table($tb['hotel_output_createorders_order'])
								 ->select('uniqueid,poid,stt')
								 ->where('id',$orderid)
								 ->where('branchid',$branchid)
								 ->where('isdelete',0)
								 ->find();	
		$uniqueid = $checkPOid->uniqueid;
		$poid = $checkPOid->poid;
		$stt = $checkPOid->stt;
		#end
		//Lay du lieu ban dau
		$queryOld = $this->model->table($tb['hotel_output_order'])
					->select('goodsid,quantity,priceone,discount,discount_type,discount_value,cksp')
					->where('orderid',$orderid)
					->where('branchid',$branchid)
					->find_all();
		
		$tbTemp = $tb['hotel_add_temp'];
		$tbGoods = $tb['hotel_goods'];
		$queryTemp = $this->model->table($tbTemp)
					->select($tbTemp.'.*, isnegative, goods_name')
					->join($tbGoods,$tbGoods.'.id='.$tbTemp.'.goodid','left')
					->where($tbTemp.'.contronller',$this->ctr)
					->where($tbTemp.'.userid',$userid)
					//->where($tbTemp.'.orderid',$orderid)
					->where($tbTemp.'.isnew',1)
					->where($tbGoods.'.isdelete',0)
					->order_by($tbTemp.'.datecreate','asc')
					->find_all();	
		#region xoa du lieu cu
		$this->model->table($tb['hotel_output_order'])
					->where('orderid',$orderid)
					->where('branchid',$branchid)
					->delete();
		
		#end
		$arrGoods = array();
		$arrNegative = array();
		$arrGoodName = array();
		foreach($queryTemp as $item){
			
			$checkInventory = $this->model->table($tb['hotel_inventory'])
								   ->select('id')
								   ->where('branchid',$branchid)
								   ->where('goodsid',$item->goodid)
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
			}
			if(isset($arrGoods[$item->goodid])){
				$arrGoods[$item->goodid]+= $item->quantity;
			}
			else{
				$arrGoods[$item->goodid] = $item->quantity;	
			}
			$arrNegative[$item->goodid] = $item->isnegative;
			$arrGoodName[$item->goodid] = $item->goods_name;
		}
		#region Tao po
		/*$setuppo = $this->login->setuppo;
		$arrAuto = $this->createPoOrder($branchid,$array['datecreate']);
		if($setuppo == 0){
			$poid = $arrAuto['poid'];
		}
		else{
			$poid = $array['poid']; 
			//Kiem tra ton tai PO
			$checkPOid = $this->model->table($tb['hotel_output_createorders_order'])
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
		#region Tinh tien
		$t_tien = 0;
		foreach($queryTemp as $item){
			$quantity = $item->quantity;	
			$price = $item->price;
			$discount = $item->discount_value;	
			$thanhtien = ($quantity * $price) - $discount;
			$t_tien += $thanhtien; 
		}
		$vat = 0;
		if(!empty($array['vat'])){
			$vat = fmNumberSave($array['vat']);
		}
		$tontienthanhtoan = (($vat * $t_tien)/100) + $t_tien;
		#end 
		$insert = array();
		#region tinh tam ung
		$price_prepay = fmNumberSave($array['price_prepay']);
		if(empty($price_prepay)){
			$price_prepay = 0;
		}
		$insert['payments_status'] = 0;
		if($array['percent'] == 2){//Tinh %
			if($price_prepay > 100){ $price_prepay = 100; }
			$insert['percent_value'] = fmNumberSave($price_prepay);
			$prepays = fmNumberSave($price_prepay) * fmNumberSave($tontienthanhtoan) / 100; 
			$insert['price_prepay'] = $prepays;
			if($price_prepay < 100){
				$insert['payments_status'] = -1;  //con no
			}
		}
		else{//Tiem mat
			$insert['price_prepay'] = $price_prepay;
			if($price_prepay < fmNumberSave($tontienthanhtoan)){
				$insert['payments_status'] = -1; 
			}
		}
		#end
		#region insert
		$timeNow = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
		$insert['branchid'] = $branchid;
		$insert['description'] = $array['description'];
		$insert['customer_id'] = $array['customerid'];
		$insert['datecreate'] = $timeNow;
		$insert['usercreate'] =  $this->login->username;
		$insert['employeeid'] = $array['employeeid'];
		$insert['payments'] = $array['payments'];
		$insert['vat'] = (float)$array['vat'];
		$insert['uniqueid'] = $uniqueid;
		$insert['poid'] = $poid;
		$insert['price'] = fmNumberSave($t_tien);
		$insert['price_total'] = fmNumberSave($tontienthanhtoan);
		$insert['stt'] = $stt;
		$array['datecreate'] = date('Y-m-d',strtotime($array['datecreate']));
		$insert['datepo'] = fmDateSave($array['datecreate']);
		$insert['place_of_delivery'] = $array['place_of_delivery'];
		$insert['deliverydate'] = fmDateSave($array['deliverydate']); 
		$insert['signature_x'] = $this->login->signature;
		$insert['signature_name_x'] = $this->login->fullname;
		$insert['warehouseid'] = 0;//$array['warehouseid'];
		$this->model->table($tb['hotel_output_createorders_order'])->where('id',$orderid)->update($insert);	
		#end
		#region them bang detail
		$i=1; 
		foreach($queryTemp as $item){
			$insertInput = array();
			$insertInput['warehouseid'] = 0;
			$insertInput['branchid'] = $branchid;
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
			$this->model->table($tb['hotel_output_order'])->insert($insertInput);
			$i++;
		}
		#end
		#region Xoa du lieu bang tam
		$userid =  $this->login->id;
		$this->model->table($tb['hotel_add_temp'])
					->where('contronller',$this->ctr)
					->where('userid',$userid)
					->where('isnew',1)
					->delete();	
		#end
		#region ghi log
		$description = 'Sửa: Đơn hàng '.$poid;
		$this->base_model->addAcction('Đơn đặt hàng',$this->uri->segment(2),json_encode($queryOld),'',$description );	
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
		$output = $tb['hotel_output_order'];
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
		$query = $this->model->table($tb['hotel_output_order'])
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
			FROM `".$tb['hotel_output_createorders_order']."` so
			LEFT join `".$tb['hotel_output_order']."` oo on oo.orderid = so.id
			left join `".$tb['hotel_customer']."` c on c.id = so.customer_id and c.isdelete = 0
			left join hotel_province pr on pr.id = c.provinceid and pr.isdelete = 0
			left join hotel_district d on d.id = c.districid and d.isdelete = 0
			left join `".$tb['hotel_goods']."` g on g.id = oo.goodsid
			left join `".$tb['hotel_goods_type']."` gt on gt.id = g.goods_type and gt.isdelete =0
			left join `".$tb['hotel_unit']."` un on un.id = oo.unitid and un.isdelete = 0
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
		$query = $this->model->table($tb['hotel_output_createorders_order'])
					  ->select('*')
					  ->where('id',$id)
					  ->where('isout',0)
					  ->find();
		return $query;
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
				$arrAdd['unitid'] = $findgoods->unitid;
				$arrAdd['discount'] = $findgoods->discounthotel_dly;
				if(!empty($findgoods->discounthotel_dly)){
					$arrAdd['discount_type'] = $findgoods->discounthotel_type_dly;
				}
				else{
					$arrAdd['discount_type'] = 2;
				}
				if($xkm == 1){
					$arrAdd['discount'] = 0;
					$arrAdd['price'] = 0;
				}
				//Tinh tien
				if($findgoods->discounthotel_type_dly == 1){//Tinh phần trăm
					$ptr = $findgoods->discounthotel_dly * $findgoods->sale_price / 100;
					$arrAdd['discount_value'] = fmNumberSave($ptr);
				}
				else{
					$arrAdd['discount_value'] = $findgoods->discounthotel_dly;
				}
				$arrAdd['datecreate'] = gmdate("Y-m-d H:i:s", time() + 7 * 3600);;
				$this->model->table($tb['hotel_add_temp'])->insert($arrAdd);
			}
			else{//co roi update so luon
				$this->model->table($tb['hotel_add_temp'])->save($check->id,$arrAdd);
			}
		}
		return $this->getTempGood($userid,$isnew);
	}
	function getTempGood($userid,$isnew = 0){
		$tb = $this->base_model->loadTable();
		$skey = $this->login->skey;
		$branchid = $this->login->branchid;
		$sql = "
				SELECT  sat.id as satid, if(sat.discount_type=1,'%','') as satdiscount_type, sat.discount_type as discount_types, sat.discount_value, sat.xkm,sat.serial_number, sat.discount, sat.uniqueid, sat.stype, s.goods_code, s.id, s.img,s.goods_name,un.unit_name, s.shelflife, s.discounthotel_dly,s.discounthotel_type_dly,sat.guarantee as guaranteedate,
				if(sat.quantity is not null,sat.quantity,1) as quantity,
				if(sat.price is not null,sat.price,s.sale_price) as sale_price,
				if(sat.discount is not null,sat.discount,s.discounthotel_dly) as discount, s.isserial, sat.vat,
				if(sat.discount is not null,2,s.discounthotel_type_dly) as discount_type,
				(
					select group_concat(concat(gc.unitid,'::', unt.unit_name) SEPARATOR '___') as unitChange
						from `".$tb['hotel_goods_conversion']."` gc
						left join `".$tb['hotel_unit']."` unt on unt.id = gc.unitid
						where unt.isdelete = 0
						and gc.goodsid = s.id
				) as unit_exchange,
				un.unit_name, un.id as unitid, sat.unitid as satunitid
				
				FROM `".$tb['hotel_add_temp']."` sat
				left join `".$tb['hotel_goods']."` s on s.id = sat.goodid
				left join `".$tb['hotel_unit']."` un on un.id = s.unitid
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
				$arrAdd['unitid'] = $item->unitid;
				$arrAdd['contronller'] = $this->ctr;
				$arrAdd['userid'] = $this->login->id;
				$arrAdd['stype'] = $item->stype;
				$arrAdd['isnew'] = 1;
				$arrAdd['uniqueid'] = $item->id;
				$arrAdd['goodid'] = $item->goodsid;
				$arrAdd['quantity'] = $item->quantity;
				$arrAdd['price'] = $item->buy_price;
				$arrAdd['discount'] = $item->discount;
				$arrAdd['discount_value'] = $item->discount_value;
				$arrAdd['discount_type'] = $item->discount_type;
				$arrAdd['guarantee'] = $item->guaranteeOut;
				$arrAdd['xkm'] = $item->cksp;
				if(!empty($item->serial_number)){
					$arrAdd['serial_number'] = $item->serial_number;
				}
				$arrAdd['vat'] = $item->vat;
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
		WHERE table_name='".$tb['hotel_output_createorders_order']."'; 
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
		$tb = $this->base_model->loadTable();
		$companyid = $this->login->companyid;
		$skey = $this->login->skey;
		$find = $this->model->table($tb['hotel_output_createorders_order'])
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
			FROM `".$tb['hotel_output_order']."` s
			left join `".$tb['hotel_goods']."` g on g.id = s.goodsid and g.isdelete = 0
			left join `".$tb['hotel_unit']."` un on un.id = g.unitid
			where s.uniqueid = '$uniqueid'
			and s.isdelete = 0
		 ";
		 $query = $this->model->query($sql)->execute();
		 $array['datas'] = $query;
		 $array['finds'] = $find;				 
		 return $array;
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
		 $output = $tb['hotel_output_order'];
		 $createorders = $tb['hotel_output_createorders_order'];
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
		$checkPOid = $this->model->table($tb['hotel_receipts'])
							 ->select('receipts_code')
							 ->where("datepo like '$yearDay%'")
							 ->where('branchid',$branchid)
							 ->where('isdelete',0)
							 ->order_by('id','DESC')
							 ->find();
		$cfpt = cfpt();
		if(!empty($checkPOid->receipts_code)){
			$poid = str_replace($cfpt,'',$checkPOid->receipts_code);
			$poc = (float)$poid;
		}
		else{
			$poc = date('ym',strtotime($yearDay)).'00000';
		}
		$receipts_code = $cfpt.($poc + 1);
		return $receipts_code;
	}
	function createPoOrder($branchid,$datecreate){
		$tb = $this->base_model->loadTable();
		$yearDay = fmMonthSave($datecreate);
		$configs = configs();
		if($configs['cfdh_type'] == 0){		
			$checkPOid = $this->model->table($tb['hotel_output_createorders_order'])
					 ->select('poid,stt')
					 ->where("datepo like '$yearDay%'")
					 ->where('branchid',$branchid)
					 ->where('isdelete',0)
					 ->order_by('id','DESC')
					 ->find();
			if(!empty($checkPOid->poid)){
				$poid = str_replace($configs['cfdh'],'',$checkPOid->poid);
				$poc = trim($configs['cfdh']).((float)$poid + 1);
			}
			else{
				if(empty($configs['cfdh_default'])){
					$configs['cfdh_default'] = '00001';
				}
				$poc = trim($configs['cfdh']).date('ym',strtotime($yearDay)).trim($configs['cfdh_default']);
			}
		}
		else{
			$checkPOid = $this->model->table($tb['hotel_output_createorders_order'])
					 ->select('poid,stt')
					 ->where("datepo like '$yearDay%'")
					 ->where('branchid',$branchid)
					 ->where('isdelete',0)
					 ->order_by('id','DESC')
					 ->find();
					 
			if(!empty($checkPOid->poid)){
				$poid = str_replace($configs['cfdh'],'',$checkPOid->poid);
				if(empty($configs['cfdh_default'])){
					$configs['cfdh_default'] = '00001';
				}
				$poc = trim($configs['cfdh']). $this->base_model->createPO($configs['cfdh_default'], $poid);
			}
			else{
				if(empty($configs['cfdh_default'])){
					$configs['cfdh_default'] = '00001';
				}
				$poc = trim($configs['cfdh']).trim($configs['cfdh_default']);
			}
		}
		$checkSTT = $this->model->table($tb['hotel_output_createorders_order'])
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
			FROM `".$tb['hotel_output_order_order']."`  sat
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
	function updatePriceOne($goodid,$priceone,$quantity,$discount,$xkm,$isnew){
		$userid =  $this->login->id;
		$tb = $this->base_model->loadTable();
		$array = array();
		$pos = strpos($discount,'%');
		if ($pos !== false) {
			$discount_types = 1;
		} else {
			$discount_types = 2;
		}
		$discount = fmNumberSave(str_replace('%','',$discount));
		$priceone = fmNumberSave($priceone);
		$quantity = fmNumberSave($quantity);
		
		$array['price'] = $priceone;
		$array['quantity'] = $quantity;
		if($discount_types == 2){
			$discount = $discount;
		}
		else{
			$discount = $discount * $priceone / 100;
		}
		$total = $priceone * $quantity;
		if($discount > $total){
			$discount = $total;
		}
		//$array['discount_value'] = $discount * $quantity;
		$array['discount_value'] = $discount;
		$array['xkm'] = $xkm;
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
			select sg.id, '0' stype ,si.serial_number , si.goodsid, sg.sale_price ,si.quantity, si.price as totalPrice, si.priceone as buy_price, sg. sale_price as price_out, sg.goods_code, sg.goods_name, su.unit_name, sg.guarantee as isguarantee, if(si.guarantee = '0000-00-00',0,si.guarantee) as guaranteedate, sg.guarantee, si.guarantee as guaranteeOut, si.discount, si.discount_value, si.discount_type, si.cksp,
			(
				SELECT oc.vat
				FROM `".$tb['hotel_output_createorders_order']."` oc
				where oc.id = si.orderid
				and oc.branchid = '$branchid'
				limit 1
			) as vat, si.unitid
			from `".$tb['hotel_output_order']."` si
			left join `".$tb['hotel_goods']."` sg on si.goodsid = sg.id
			left join `".$tb['hotel_unit']."` su on su.id = sg.unitid
			where si.orderid = '$orderid'
			and si.isdelete = 0
			order by si.sttview asc
		"; 
		return $this->model->query($sql)->execute();
	}
	function findOrderUniqueid($orderid){
		$tb = $this->base_model->loadTable();
		$query = $this->model->table($tb['hotel_output_createorders_order'])
					  ->select('*')
					  ->where('id',$orderid)
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