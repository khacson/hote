<?php
/**
 * @author 
 * @copyright 2018
 */
 class RoomtypeModel extends CI_Model{
	function __construct(){
		parent::__construct('');
		$this->login = $this->site->getSession('login');
	}
	function findID($id){
		$tb = $this->base_model->loadTable(); 
		$query = $this->model->table($tb['hotel_roomtype'])
					  ->select('*')
					  ->where('id',$id)
					  ->find();
		return $query;
	 }
	function getSearch($search){
		$sql = "";
		$branchid = $this->login->branchid;
		if(!empty($search['roomtype_name'])){
			$sql.= " and rt.roomtype_name  like '%".addslashes($search['roomtype_name'])."%' ";	
		}
		if(!empty($search['description'])){
			$sql.= " and rt.description  like '%".addslashes($search['description'])."%' ";	
		}
		if(!empty($search['count_beds'])){
			$sql.= " and rt.count_beds  like '%".addslashes($search['count_beds'])."%' ";	
		}
		if(!empty($search['count_person'])){
			$sql.= " and rt.count_person  like '%".addslashes($search['count_person'])."%' ";	
		}
		if(!empty($branchid)){
			$sql.= " and rt.branchid  = '".$branchid."' ";	
		}
		else{
			if(!empty($search['branchid'])){
				$sql.= " and rt.branchid  in (".$search['branchid'].") ";	
			}
		}
		return $sql;
	}
	function getList($search,$page,$rows){
		$tb = $this->base_model->loadTable();
		$searchs = $this->getSearch($search);
		$sql = "SELECT rt.id, rt.roomtype_name,  rt.description, br.branch_name, rt.count_beds ,rt.count_person
				FROM `".$tb['hotel_roomtype']."` AS rt
				LEFT JOIN `".$tb['hotel_branch']."` br on br.id = rt.branchid
				WHERE rt.isdelete = 0 
				$searchs
				";
		if(empty($search['order'])){
			$sql.= ' ORDER BY rt.roomtype_name asc ';
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
		FROM `".$tb['hotel_roomtype']."` AS rt
		WHERE rt.isdelete = 0 
		$searchs	
		";
		$query = $this->model->query($sql)->execute();
		return $query[0]->total;	
	}
	function saves($array){
		$this->db->trans_begin();
		$tb = $this->base_model->loadTable();
		$branchid = $this->login->branchid;
		$check = $this->model->table($tb['hotel_roomtype'])
					  ->select('id')
					  ->where('isdelete',0)
					  ->where('roomtype_name',$array['roomtype_name'])
					  ->where('branchid',$branchid)
					  ->find();
		if(!empty($check->id)){
			return -1;	
		}
		$result = $this->model->table($tb['hotel_roomtype'])->insert($array);	
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
		 $check = $this->model->table($tb['hotel_roomtype'])
							 ->select('id')
							 ->where('isdelete',0)
							 ->where('id <>',$id)
							 ->where('roomtype_name',$array['roomtype_name'])
							 ->where('branchid',$branchid)
							 ->find();
		 if(!empty($check->id)){
			 return -1;	
		 }
		 $result = $this->model->table($tb['hotel_roomtype'])->where('id',$id)->update($array);	
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