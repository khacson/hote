<?php
/**
 * @author 
 * @copyright 2015
 */
 class BankModel extends CI_Model{
	function __construct(){
		parent::__construct('');
		$this->login = $this->site->getSession('login');
	}
	function findID($id){
		$tb = $this->base_model->loadTable(); 
		$query = $this->model->table($tb['hotel_bank'])
					  ->select('*')
					  ->where('id',$id)
					  ->find();
		return $query;
	 }
	function getSearch($search){
		$sql = "";
		$companyid = $this->login->companyid;
		if(!empty($search['bank_code'])){
			$sql.= " and b.bank_code  like '%".addslashes($search['bank_code'])."%' ";	
		}
		if(!empty($search['bank_name'])){
			$sql.= " and b.bank_name  like '%".addslashes($search['bank_name'])."%' ";	
		}
		if(!empty($search['description'])){
			$sql.= " and b.description  like '%".addslashes($search['description'])."%' ";	
		}
		return $sql;
	}
	function getList($search,$page,$rows){
		$tb = $this->base_model->loadTable();
		$searchs = $this->getSearch($search);
		$sql = "SELECT b.id, b.bank_name, b.bank_code, b.description
				FROM `".$tb['hotel_bank']."` AS b
				WHERE b.isdelete = 0 
				$searchs
				";
		if(empty($search['order'])){
			$sql.= ' ORDER BY b.id DESC ';
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
		FROM `".$tb['hotel_bank']."` AS b
		WHERE b.isdelete = 0 
		$searchs	
		";
		$query = $this->model->query($sql)->execute();
		return $query[0]->total;	
	}
	function saves($array){
		$this->db->trans_begin();
		$tb = $this->base_model->loadTable();
		foreach($array as $key=>$val){
			$array[$key] = trim($val);
		}
		$check = $this->model->table($tb['hotel_bank'])
					  ->select('id')
					  ->where('isdelete',0)
					  ->where('bank_name',$array['bank_name'])
					  ->find();
		if(!empty($check->id)){
			return -1;	
		}
		$result = $this->model->table($tb['hotel_bank'])->insert($array);	
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return 0;
		}
		else{
			$this->db->trans_commit();
			return 1;
		}
		
	}
	function edits($array,$id){
		 $this->db->trans_begin();
		 $tb = $this->base_model->loadTable();
		 foreach($array as $key=>$val){
			$array[$key] = trim($val);
		 }
		 $check = $this->model->table($tb['hotel_bank'])
		 ->select('id')
		 ->where('isdelete',0)
		 ->where('id <>',$id)
		 ->where('bank_name',$array['bank_name'])
		 ->find();
		 if(!empty($check->id)){
			 return -1;	
		 }
		 $result = $this->model->table($tb['hotel_bank'])->where('id',$id)->update($array);	
		 if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return 0;
		}
		else{
			$this->db->trans_commit();
			return $id;
		}
	 }
}