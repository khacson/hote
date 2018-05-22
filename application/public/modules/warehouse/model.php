<?php
/**
 * @author 
 * @copyright 2015
 */
 class WarehouseModel extends CI_Model{
	function __construct(){
		parent::__construct('');
		$this->login = $this->site->getSession('login');
	}
	function findID($id){
		 $tb = $this->base_model->loadTable();
		 $query = $this->model->table($tb['hotel_warehouse'])
					  ->select('*')
					  ->where('id',$id)
					  ->find();
		return $query;
	 }
	function getSearch($search){
		$sql = "";
		$companyid = $this->login->companyid;
		$sql.= " and c.companyid = '".$companyid."' ";
		if(!empty($search['warehouse_name'])){
			$sql.= " and c.warehouse_name like '%".$search['warehouse_name']."%' ";	
		}
		if(!empty($search['address'])){
			$sql.= " and c.address like '%".$search['address']."%' ";	
		}
		if(!empty($search['phone'])){
			$sql.= " and c.phone like '%".$search['phone']."%' ";	
		}
		if(!empty($search['name_contact'])){
			$sql.= " and c.name_contact like '%".$search['name_contact']."%' ";	
		}
		if(!empty($search['branchid'])){
			$sql.= " and c.branchid in (".$search['branchid'].") ";	
		}
		return $sql;
	}
	function getList($search,$page,$rows){
		$searchs = $this->getSearch($search);
		$tb = $this->base_model->loadTable();
		$skey = $this->login->skey;
		$sql = "SELECT c.*, c.branchid, p.province_name, d.distric_name,
				DES_DECRYPT(b.branch_name,'$skey') as branch_name
				FROM `".$tb['hotel_warehouse']."` AS c
				LEFT JOIN hotel_province p on p.id = c.provinceid and p.isdelete = 0
				LEFT JOIN hotel_district d on d.id = c.districid and d.isdelete = 0
				LEFT JOIN `".$tb['hotel_branch']."` b on b.id = c.branchid and b.isdelete = 0
				WHERE c.isdelete = 0  
				$searchs
				";
		if(empty($search['order'])){
			$sql.= ' ORDER BY c.id DESC ';
		}
		else{
			$sql.= ' ORDER BY '.$search['order'].' '.$search['index'].' ';
		}
		$sql.= ' limit '.$page.','.$rows;
		$query = $this->model->query($sql)->execute();
		return $query;
	}
	function getTotal($search){
		$tb = $this->base_model->loadTable();
		$searchs = $this->getSearch($search);
		$sql = " 
		SELECT count(1) total
		FROM `".$tb['hotel_warehouse']."` AS c
		LEFT JOIN hotel_province p on p.id = c.provinceid and p.isdelete = 0
		LEFT JOIN hotel_district d on d.id = c.districid and d.isdelete = 0
		LEFT JOIN `".$tb['hotel_branch']."` b on b.id = c.branchid and b.isdelete = 0
		WHERE c.isdelete = 0 
		$searchs	
		";
		$query = $this->model->query($sql)->execute();
		return $query[0]->total;	
	}
	function saves($array){
		$tb = $this->base_model->loadTable();
		$check = $this->model->table($tb['hotel_warehouse'])
					  ->select('id')
					  ->where('isdelete',0)
					  ->where('warehouse_name',$array['warehouse_name'])
					  ->where('companyid',$this->login->companyid)
					  ->find();
		if(!empty($check->id)){
			return -1;	
		}
		$array['companyid'] = $this->login->companyid;
		//$array['friendlyurl'] = $this->site->friendlyURL($array['warehouse_name']);
		$result = $this->model->table($tb['hotel_warehouse'])->insert($array);	
		return 1;
	}
	function edits($array,$id){
		$tb = $this->base_model->loadTable();
		 $check = $this->model->table($tb['hotel_warehouse'])
		 ->select('id')
		 ->where('isdelete',0)
		 ->where('id <>',$id)
		 ->where('warehouse_name',$array['warehouse_name'])
		 ->where('companyid',$this->login->companyid)
		 ->find();
		 if(!empty($check->id)){
			 return -1;	
		 }
		 $array['companyid'] = $this->login->companyid;
		 //$array['friendlyurl'] = $this->site->friendlyURL($array['warehouse_name']);
		 $result = $this->model->table($tb['hotel_warehouse'])->where('id',$id)->update($array);	
		 return $id;
	 }
	 
}