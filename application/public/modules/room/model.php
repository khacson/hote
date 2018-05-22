<?php
/**
 * @author 
 * @copyright 2018
 */
 class RoomModel extends CI_Model{
	function __construct(){
		parent::__construct('');
		$this->login = $this->site->getSession('login');
	}
	function findID($id){
		$tb = $this->base_model->loadTable(); 
		$query = $this->model->table($tb['hotel_room'])
					  ->select('*')
					  ->where('id',$id)
					  ->find();
		return $query;
	 }
	function getSearch($search){
		$sql = "";
		$branchid = $this->login->branchid;
		if(!empty($search['room_name'])){
			$sql.= " and r.room_name  like '%".addslashes($search['room_name'])."%' ";	
		}
		if(!empty($search['description'])){
			$sql.= " and r.description  like '%".addslashes($search['description'])."%' ";	
		}
		if(!empty($search['count_beds'])){
			$sql.= " and r.count_beds  like '%".addslashes($search['count_beds'])."%' ";	
		}
		if(!empty($search['count_person'])){
			$sql.= " and r.count_person  like '%".addslashes($search['count_person'])."%' ";	
		}
		if(!empty($search['price_week'])){
			$sql.= " and r.price_week  like '%".addslashes($search['price_week'])."%' ";	
		}
		if(!empty($search['price_month'])){
			$sql.= " and r.price_month  like '%".addslashes($search['price_month'])."%' ";	
		}
		if(!empty($search['floorid'])){
			$sql.= " and r.floorid  in (".$search['floorid'].") ";	
		}
		if(!empty($search['roomtypeid'])){
			$sql.= " and r.roomtypeid  in (".$search['roomtypeid'].") ";	
		}
		if(!empty($branchid)){
			$sql.= " and r.branchid  = '".$branchid."' ";	
		}
		else{
			if(!empty($search['branchid'])){
				$sql.= " and r.branchid  in (".$search['branchid'].") ";	
			}
		}
		return $sql;
	}
	function getList($search,$page,$rows){
		$tb = $this->base_model->loadTable();
		$searchs = $this->getSearch($search);
		$sql = "SELECT r.*, rt.roomtype_name,  br.branch_name, f.floor_name
				FROM `".$tb['hotel_room']."` AS r
				LEFT JOIN `".$tb['hotel_roomtype']."` rt on rt.id = r.roomtypeid
				LEFT JOIN `".$tb['hotel_floor']."` f on f.id = r.floorid
				LEFT JOIN `".$tb['hotel_branch']."` br on br.id = r.branchid
				WHERE r.isdelete = 0 
				$searchs
		";
		if(empty($search['order'])){
			$sql.= ' ORDER BY r.room_name asc ';
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
		FROM `".$tb['hotel_room']."` AS r
		WHERE r.isdelete = 0 
		$searchs	
		";
		$query = $this->model->query($sql)->execute();
		return $query[0]->total;	
	}
	function saves($array){
		$this->db->trans_begin();
		$branchid = $this->login->branchid;
		$tb = $this->base_model->loadTable();
		$array['price'] = fmNumberSave($array['price']);
		$array['price_hour'] = fmNumberSave($array['price_hour']);
		$array['price_hour_next'] = fmNumberSave($array['price_hour_next']);
		$array['price_week'] = fmNumberSave($array['price_week']);
		$array['price_month'] = fmNumberSave($array['price_month']);
		$array['isstatus'] = 1;
		$check = $this->model->table($tb['hotel_room'])
					  ->select('id')
					  ->where('isdelete',0)
					  ->where('room_name',$array['room_name'])
					  ->where('branchid',$branchid)
					  ->find();
		if(!empty($check->id)){
			return -1;	
		}
		$result = $this->model->table($tb['hotel_room'])->insert($array);	
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
		 $branchid = $this->login->branchid;
		 $tb = $this->base_model->loadTable();
		 $array['price'] = fmNumberSave($array['price']);
		 $array['price_hour'] = fmNumberSave($array['price_hour']);
		 $array['price_hour_next'] = fmNumberSave($array['price_hour_next']);
		 $array['price_week'] = fmNumberSave($array['price_week']);
		 $array['price_month'] = fmNumberSave($array['price_month']);
		 $check = $this->model->table($tb['hotel_room'])
		 ->select('id')
		 ->where('isdelete',0)
		 ->where('id <>',$id)
		 ->where('room_name',$array['room_name'])
		 ->where('branchid',$branchid)
		 ->find();
		 if(!empty($check->id)){
			 return -1;	
		 }
		 $result = $this->model->table($tb['hotel_room'])->where('id',$id)->update($array);	
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