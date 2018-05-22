<?php
/**
 * @author 
 * @copyright 2015
 */
 class GuaranteeModel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->login = $this->site->getSession('login');
	}
	function getSearch($search){
		$sql = "";
		$companyid = $this->login->companyid;
		$branchid = $this->login->branchid;
	
		if($this->login->grouptype == 4){
			$sql.= " and c.usercreate = '".$this->login->username ."' ";	
		}
		if(!empty($branchid)){
			$sql.= " and c.branchid in (".$branchid.") ";	
		}
		else{
			if(!empty($search['branchid'])){
				$sql.= " and c.branchid in (".$search['branchid'].") ";	
			}
		}
		if(!empty($search['goodsid'])){
			//$sql.= " and DES_DECRYPT(c.customer_name,'".$this->login->skey ."')  like '%".$search['customer_name']."%' ";	
			$sql.= " and g.id in (".$search['goodsid'].") ";	
		}
		if(!empty($search['idss'])){ //Đơn hàng
			$sql.= " and c.poid in (".$search['idss'].") ";	
		}
		if(!empty($search['employeeid'])){ //Đơn hàng
			$sql.= " and c.employeeid in (".$search['employeeid'].") ";	
		}
		if(!empty($search['customer_id'])){ 
			$sql.= " and cm.id in (".$search['customer_id'].") ";	
		}
		if(!empty($search['customer_name'])){
			$sql.= " and c.customer_name like '%".$search['customer_name']."%' ";	
		}
		if(!empty($search['customer_phone'])){ 
			$sql.= " and c.customer_phone  like '%".$search['customer_phone']."%')";	
		}
		if(!empty($search['formdate'])){
			$sql.= " and c.datecreate >= '".fmDateSave($search['formdate'])." 00:00:00' ";	
		}
		if(!empty($search['todate'])){
			$sql.= " and c.datecreate <= '".fmDateSave($search['todate'])." 23:59:00' ";	
		}
		if(!empty($search['statusguarantee'])){
			$timeNow =  gmdate("Y-m-d", time() + 7 * 3600);
			if($search['statusguarantee'] == 1){
				$sql.= " and so.guarantee >= '".$timeNow."' ";	
			}
			elseif($search['statusguarantee'] == 2){
				$sql.= " and so.guarantee < '".$timeNow."' ";	
			}
		}
		if(!empty($search['serial_number'])){
			$sql.= " and so.serial_number like '%".$search['serial_number']."%' ";	
		}
		if(!empty($search['goods_type'])){
			$sql.= " and g.goods_type in (".$search['goods_type'].") ";	
		}
		if(!empty($search['goodsidsearch'])){
			$sql.= " and g.goods_code like '%".$search['goodsidsearch']."%' ";
		}
		if(!empty($search['goodsnamesearch'])){
			$sql.= " and g.goods_name like '%".$search['goodsnamesearch']."%' ";
		}
		return $sql;
	}
	function getList($search,$page,$rows){
		$tb = $this->base_model->loadTable();
		$searchs = $this->getSearch($search);
		$sql = "SELECT w.warehouse_name, e.username as employee_code ,
				 cm.customer_name, cm.address as caddress, e.fullname as employee_name,
				 cm.phone  as phones,c.id as orderid,
				 so.id, so.goodsid, so.quantity, so.priceone, so.price, ut.unit_name,
				 g.goods_name, g.goods_code, c.poid, c.usercreate, c.datecreate, c.customer_id, so.guarantee, so.serial_number
				FROM `".$tb['hotel_output']."` so
				LEFT JOIN `".$tb['hotel_output_createorders']."` AS c on c.uniqueid = so.uniqueid
				LEFT JOIN `".$tb['hotel_warehouse']."` w on w.id = c.warehouseid and w.isdelete = 0
				LEFT JOIN `".$tb['hotel_customer']."` cm on cm.id = c.customer_id and cm.isdelete = 0
				LEFT JOIN `hotel_users` e on e.id = c.employeeid and e.isdelete = 0
				left join `".$tb['hotel_goods']."` g on g.id = so.goodsid 
				left join `".$tb['hotel_unit']."` ut on ut.id = g.unitid
				WHERE so.isdelete = 0
				AND c.isdelete = 0 
				and g.isdelete = 0
				
				and (so.guarantee <> '0000-00-00' and so.guarantee <> '1970-01-01' and so.guarantee is not null)
				$searchs
				";
		if(empty($search['order'])){
			$sql.= ' ORDER BY so.poid desc, g.goods_code ASC  ';
		}
		else{
			$sql.= ' ORDER BY '.$search['order'].' '.$search['index'].' ';
		}
		if($page != 0 && $rows != 0){
			$sql.= ' limit '.$page.','.$rows;
		}
		$query = $this->model->query($sql)->execute();
		//$data['result'] = $query;
		return $query;
	}
	function getTotal($search){
		$tb = $this->base_model->loadTable();
		$searchs = $this->getSearch($search);
		$sql = "SELECT count(1) total
				FROM `".$tb['hotel_output']."` so
				LEFT JOIN `".$tb['hotel_output_createorders']."` AS c on c.uniqueid = so.uniqueid
				LEFT JOIN `".$tb['hotel_warehouse']."` w on w.id = c.warehouseid and w.isdelete = 0
				LEFT JOIN `".$tb['hotel_customer']."` cm on cm.id = c.customer_id and cm.isdelete = 0
				LEFT JOIN `hotel_users` e on e.id = c.employeeid and e.isdelete = 0
				left join `".$tb['hotel_goods']."` g on g.id = so.goodsid
				left join `".$tb['hotel_unit']."` ut on ut.id = g.unitid
				WHERE so.isdelete = 0
				AND c.isdelete = 0 
				and g.isdelete = 0
				and (so.guarantee <> '0000-00-00' and so.guarantee <> '1970-01-01' and so.guarantee is not null)
				$searchs
				";
		$query = $this->model->query($sql)->execute();
		return $query[0]->total;	
	}
	function saves($array){
		$tb = $this->base_model->loadTable();
		//$this->model->trans_start();
		$array['branchid'] = $this->login->branchid;
		$array['companyid'] = $this->login->companyid;
		$arr_goodsid = $array['goodsid'];
		$array['uniqueid'] = $this->base_model->getUniqueid();
		$po = "SELECT oc.poid
							FROM `".$tb['hotel_output_createorders']."` oc
							where oc.companyid = '".$array['companyid']."'
							order by oc.poid DESC 
							limit 1
							
							";
		$queryPO = $this->model->query($po)->execute();
		if(!empty($queryPO[0]->poid)){
			$array['poid'] = $queryPO[0]->poid + 1;	
		}
		else{
			$array['poid'] = 1;
		}		
		$strGoods = substr(json_encode($array['goodsid']),1,-1);
		$array['goodslistid'] = $strGoods;
		unset($array['goodsid']); 
		unset($array['formdate']);
		unset($array['todate']);
		if(count($arr_goodsid > 0)){
			$idinsert = $this->model->table($tb['hotel_output_createorders'])->insert($array);
			//Them bang chi tiet
			//unset($array['customer_id']);
			//unset($array['customer_type']);
			//unset($array['customer_name']);
			//unset($array['customer_phone']);
			//unset($array['customer_address']);
			//unset($array['poid']);
			unset($array['goodslistid']);
			$array['orderid'] = $idinsert;
			foreach($arr_goodsid as $key=>$sl){
				$array['goodsid'] = $key;
				$array['quantity'] = $sl;
				if(!empty($sl)){
					$this->model->table($tb['hotel_output'])->insert($array);
				}	
			}
			return $idinsert;
		}
		else{
			echo 0;
		}
		//$this->model->trans_complete();
	}
	function deletes($id, $array){
		$tb = $this->base_model->loadTable();
		$result = $this->model->table($tb['hotel_output_createorders'])
					   ->where("id in ($id)")
					   ->update($array);	
		
		$arrID = explode(',',$id);
		foreach($arrID as $k=>$val){
			$uniqueid = $this->findID($id)->uniqueid;
			$this->model->table($tb['hotel_output'])
						->where('uniqueid',$uniqueid)
						->update(array('isdelete'=>1));
		}
		return 1;
	}
	function edits($array,$id){
		$tb = $this->base_model->loadTable();
		$array['branchid'] = $this->login->branchid;
		$array['companyid'] = $this->login->companyid;
		$arr_goodsid = $array['goodsid'];
		$uniqueid = $this->findID($id)->uniqueid;
		$strGoods = substr(json_encode($array['goodsid']),1,-1);
		$array['goodslistid'] = $strGoods;
		unset($array['goodsid']); 
		unset($array['formdate']);
		unset($array['todate']);
		if(count($arr_goodsid > 0)){
			$idinsert = $this->model->table($tb['hotel_output_createorders'])
							 ->where('id',$id)
							 ->update($array);
			//Them bang chi tiet
			//unset($array['customer_id']);
			//unset($array['customer_type']);
			//unset($array['customer_name']);
			//unset($array['customer_phone']);
			//unset($array['customer_address']);
			//unset($array['poid']);
			unset($array['goodslistid']);
			$array['orderid'] = $idinsert;
			//Update isdelete
			$array['uniqueid'] = $uniqueid;
			$this->model->table($tb['hotel_output'])
						->where('uniqueid',$uniqueid)
						->update(array('isdelete'=>1));
			foreach($arr_goodsid as $key=>$sl){
				$array['goodsid'] = $key;
				$array['quantity'] = $sl;
				if(!empty($sl)){
					$this->model->table($tb['hotel_output'])->insert($array);
				}	
			}
			return $idinsert;
		}
		else{
			echo 0;
		}
		return $id;
	 }
	function findID($id){
		$tb = $this->base_model->loadTable();
		$query = $this->model->table($tb['hotel_output_createorders'])
					  ->select('*')
					  ->where('id',$id)
					  ->find();
		return $query;
	 }
	function findListID($id){
		$tb = $this->base_model->loadTable();
		$sql = "
				SELECT c.*, w.warehouse_name,  
				 e.username as employee_code ,e.fullname as employee_name, cm.phone as phones
				FROM `".$tb['hotel_output_createorders']."` AS c
				LEFT JOIN `".$tb['hotel_warehouse']."` w on w.id = c.warehouseid and w.isdelete = 0
				LEFT JOIN `".$tb['hotel_customer']."` cm on cm.id = c.customer_id and cm.isdelete = 0
				LEFT JOIN `hotel_users` e on e.id = c.employeeid and e.isdelete = 0
				WHERE c.isdelete = 0 
				AND c.isout = 0
				AND c.id in ($id)
				";
		$query = $this->model->query($sql)->execute();
		$data['detail'] = $this->getListDetail($query[0]->uniqueid);
		$data['result'] = $query[0];
		return $data;
	 }
}