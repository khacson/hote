<?php
/**
 * @author 
 * @copyright 2015
 */
 class FloorsModel extends CI_Model{
	function __construct(){
		parent::__construct('');
		$this->login = $this->site->getSession('login');
	}
	function findID($id){
		$tb = $this->base_model->loadTable(); 
		$query = $this->model->table($tb['hotel_floor'])
					  ->select('*')
					  ->where('id',$id)
					  ->find();
		return $query;
	 }
	function getSearch($search){
		$sql = "";
		$branchid = $this->login->branchid;
		if(!empty($search['floor_name'])){
			$sql.= " and f.floor_name  like '%".addslashes($search['floor_name'])."%' ";	
		}
		if(!empty($search['description'])){
			$sql.= " and f.description  like '%".addslashes($search['description'])."%' ";	
		}
		if(!empty($branchid)){
			$sql.= " and f.branchid  = '".$branchid."' ";	
		}
		else{
			if(!empty($search['branchid'])){
				$sql.= " and f.branchid  in (".$search['branchid'].") ";	
			}
		}
		return $sql;
	}
	function getList($search,$page,$rows){
		$tb = $this->base_model->loadTable();
		$searchs = $this->getSearch($search);
		$sql = "SELECT f.id, f.floor_name,  f.description, br.branch_name
				FROM `".$tb['hotel_floor']."` AS f
				LEFT JOIN `".$tb['hotel_branch']."` br on br.id = f.branchid
				WHERE f.isdelete = 0 
				$searchs
				";
		if(empty($search['order'])){
			$sql.= ' ORDER BY f.floor_name asc ';
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
		FROM `".$tb['hotel_floor']."` AS f
		WHERE f.isdelete = 0 
		$searchs	
		";
		$query = $this->model->query($sql)->execute();
		return $query[0]->total;	
	}
	function saves($array){
		$this->db->trans_begin();
		$tb = $this->base_model->loadTable();
		$branchid = $this->login->branchid;
		$check = $this->model->table($tb['hotel_floor'])
					  ->select('id')
					  ->where('isdelete',0)
					  ->where('floor_name',$array['floor_name'])
					  ->where('branchid',$branchid)
					  ->find();
		if(!empty($check->id)){
			return -1;	
		}
		$result = $this->model->table($tb['hotel_floor'])->insert($array);	
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
		 $branchid = $this->login->branchid;
		 $check = $this->model->table($tb['hotel_floor'])
					 ->select('id')
					 ->where('isdelete',0)
					 ->where('id <>',$id)
					 ->where('floor_name',$array['floor_name'])
					 ->where('branchid',$branchid)
					 ->find();
		 if(!empty($check->id)){
			 return -1;	
		 }
		 $result = $this->model->table($tb['hotel_floor'])->where('id',$id)->update($array);	
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