<?php
/**
 * @author 
 * @copyright 2015
 */
 class ShelflifeModel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->login = $this->site->getSession('login');
	}
	function getSearch($search){
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
		if(!empty($search['warehouseid'])){ //Đơn hàng
			$sql.= " and c.warehouseid in (".$search['warehouseid'].") ";	
		}
		if(!empty($search['supplierid'])){ 
			$sql.= " and c.id in (".$search['supplierid'].") ";	
		}
		if(!empty($search['customer_phone'])){ 
			$sql.= " and (c.customer_phone like '%".$search['customer_phone']."%' or DES_DECRYPT(cm.phone,'".$this->login->skey ."')  like '%".$search['customer_phone']."%')";	
		}
		if(!empty($search['formdate'])){
			$sql.= " and c.datecreate >= '".date('Y-m-d',strtotime($search['formdate']))." 00:00:00' ";	
		}
		if(!empty($search['todate'])){
			$sql.= " and c.datecreate <= '".date('Y-m-d',strtotime($search['todate']))." 23:59:59' ";	
		}
		return $sql;
	}
	function getList($search,$page,$rows){
		$searchs = $this->getSearch($search);
		$tb = $this->base_model->loadTable();
		$sql = "SELECT w.warehouse_name, c.supplierid,
				 DES_DECRYPT(sp.supplier_name,'".$this->login->skey ."') as supplier_name, 
				 DES_DECRYPT(sp.address,'".$this->login->skey ."') as address, 
				 DES_DECRYPT(sp.phone,'".$this->login->skey ."')  as phone,
				 so.id, so.goodsid, so.quantity, so.priceone, so.price, ut.unit_name,
				 DES_DECRYPT(g.goods_name,'".$this->login->skey ."')as goods_name, g.goods_code, c.poid, c.usercreate, c.datecreate, so.shelflife
				FROM `".$tb['hotel_input']."` so
				LEFT JOIN `".$tb['hotel_input_createorders']."` AS c on c.uniqueid = so.uniqueid
				LEFT JOIN `".$tb['hotel_warehouse']."` w on w.id = c.warehouseid and w.isdelete = 0
				LEFT JOIN `".$tb['hotel_supplier']."` sp on sp.id = c.supplierid 
				left join `".$tb['hotel_goods']."` g on g.id = so.goodsid and g.isdelete = 0
				left join `".$tb['hotel_unit']."` ut on ut.id = g.unitid
				WHERE so.isdelete = 0
				AND c.isdelete = 0 
				and g.isdelete = 0
				and sp.isdelete = 0
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
		return $query;
	}
	function getTotal($search){
		$searchs = $this->getSearch($search);
		$tb = $this->base_model->loadTable();
		$sql = "SELECT count(1) total
				FROM `".$tb['hotel_input']."` so
				LEFT JOIN `".$tb['hotel_input_createorders']."` AS c on c.uniqueid = so.uniqueid
				LEFT JOIN `".$tb['hotel_warehouse']."` w on w.id = c.warehouseid and w.isdelete = 0
				LEFT JOIN `".$tb['hotel_supplier']."` sp on sp.id = c.supplierid 
				left join `".$tb['hotel_goods']."` g on g.id = so.goodsid and g.isdelete = 0
				left join `".$tb['hotel_unit']."` ut on ut.id = g.unitid
				WHERE so.isdelete = 0
				AND c.isdelete = 0 
				and g.isdelete = 0
				and sp.isdelete = 0
				$searchs
				";
		$query = $this->model->query($sql)->execute();
		return $query[0]->total;	
	}
	function saves($array){
		//$this->model->trans_start();
		$tb = $this->base_model->loadTable();
		$array['branchid'] = $this->login->branchid;
		$array['companyid'] = $this->login->companyid;
		$arr_goodsid = $array['goodsid'];
		$array['uniqueid'] = $this->base_model->getUniqueid();
		$po = "SELECT oc.poid
							FROM `".$tb['hotel_input_createorders']."` oc
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
			$idinsert = $this->model->table($tb['hotel_input_createorders'])->insert($array);
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
					$this->model->table($tb['hotel_input'])->insert($array);
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
		$result = $this->model->table($tb['hotel_input_createorders'])
					   ->where("id in ($id)")
					   ->update($array);	
		
		$arrID = explode(',',$id);
		foreach($arrID as $k=>$val){
			$uniqueid = $this->findID($id)->uniqueid;
			$this->model->table($tb['hotel_input'])
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
			$idinsert = $this->model->table($tb['hotel_input_createorders'])
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
			$this->model->table($tb['hotel_input'])
						->where('uniqueid',$uniqueid)
						->update(array('isdelete'=>1));
			foreach($arr_goodsid as $key=>$sl){
				$array['goodsid'] = $key;
				$array['quantity'] = $sl;
				if(!empty($sl)){
					$this->model->table($tb['hotel_input'])->insert($array);
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
		$query = $this->model->table($tb['hotel_input_createorders'])
					  ->select('*')
					  ->where('id',$id)
					  ->find();
		return $query;
	 }
	function findListID($id){
		$tb = $this->base_model->loadTable();
		$sql = "
				SELECT c.*, w.warehouse_name,  
				 e.employee_code ,e.employee_name, cm.phone as phones
				FROM `".$tb['hotel_input_createorders']."` AS c
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