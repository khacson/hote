<?php
/**
 * @author 
 * @copyright 2015
 */
 class ReceipttypeModel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->login = $this->site->getSession('login');
	}
	 function findID($id){
		$tb = $this->base_model->loadTable();
		$query = $this->model->table($tb['hotel_receipts_type'])
					  ->select('*')
					  ->where('id',$id)
					  ->find();
		return $query;
	 }
	function getSearch($search){
		$sql = "";
		$companyid = $this->login->companyid;
		if(!empty($search['receipts_type_name'])){
			$sql.= " and c.receipts_type_name like '%".$search['receipts_type_name']."%' ";	
		}
		return $sql;
	}
	function getList($search,$page,$rows){
		$tb = $this->base_model->loadTable();
		$searchs = $this->getSearch($search);
		$sql = "SELECT c.id, c.receipts_type_name
				FROM `".$tb['hotel_receipts_type']."` AS c
				WHERE c.isdelete = 0 
				$searchs
				";
		if(empty($search['order'])){
			$sql.= ' ORDER BY c.receipts_type_name asc ';
		}
		else{
			$sql.= ' ORDER BY '.$search['order'].' '.$search['index'].' ';
		}
		if(empty($page)){ $page = 0;}
		$sql.= ' limit '.$page.','.$rows;
		$query = $this->model->query($sql)->execute();
		return $query;
	}
	function getTotal($search){
		$tb = $this->base_model->loadTable();
		$searchs = $this->getSearch($search);
		$sql = " 
		SELECT count(1) total
		FROM `".$tb['hotel_receipts_type']."` AS c
		WHERE c.isdelete = 0 
		$searchs	
		";
		$query = $this->model->query($sql)->execute();
		return $query[0]->total;	
	}
	function saves($array){
		$tb = $this->base_model->loadTable();
		$check = $this->model->table($tb['hotel_receipts_type'])
					  ->select('id')
					  ->where('isdelete',0)
					  ->where('receipts_type_name',$array['receipts_type_name'])
					  ->where('companyid',$this->login->companyid)
					  ->find();
		if(!empty($check->id)){
			return -1;	
		}
		$array['companyid'] = $this->login->companyid;
		//$array['friendlyurl'] = $this->site->friendlyURL($array['receipts_type_name']);
		$result = $this->model->table($tb['hotel_receipts_type'])->insert($array);	
		return $result;
	}
	function edits($array,$id){
		$tb = $this->base_model->loadTable();
		 $check = $this->model->table($tb['hotel_receipts_type'])
		 ->select('id')
		 ->where('isdelete',0)
		 ->where('id <>',$id)
		 ->where('receipts_type_name',$array['receipts_type_name'])
		 ->where('companyid',$this->login->companyid)
		 ->find();
		 if(!empty($check->id)){
			 return -1;	
		 }
		 $array['companyid'] = $this->login->companyid;
		 //$array['friendlyurl'] = $this->site->friendlyURL($array['receipts_type_name']);
		 $result = $this->model->table($tb['hotel_receipts_type'])->where('id',$id)->update($array);	
		 return $id;
	 }
	
}