<?php
/**
 * @author 
 * @copyright 2015
 */
 class LocationModel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->login = $this->site->getSession('login');
	}
	function getSearch($search){
		$sql = "";
		if(!empty($search['location_name'])){
			$sql.= " and l.location_name like '%".addslashes($search['location_name'])."%' ";	
		}
		if(!empty($search['description'])){
			$sql.= " and l.description like '%".addslashes($search['description'])."%' ";	
		}
		return $sql;
	}
	function getList($search,$page,$rows){
		$tb = $this->base_model->loadTable();
		$searchs = $this->getSearch($search);
		$sql = "SELECT l.id, l.location_name, l.description
				FROM `".$tb['hotel_location']."` AS l
				WHERE l.isdelete = 0 
				$searchs
				";
		if(empty($search['order'])){
			$sql.= ' ORDER BY l.id DESC ';
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
		FROM `".$tb['hotel_location']."` AS l
		WHERE l.isdelete = 0 
		$searchs	
		";
		$query = $this->model->query($sql)->execute();
		return $query[0]->total;	
	}
	function saves($array){
		$tb = $this->base_model->loadTable();
		$check = $this->model->table($tb['hotel_location'])
					  ->select('id')
					  ->where('isdelete',0)
					  ->where('location_name',$array['location_name'])
					  ->where('companyid',$this->login->companyid)
					  ->find();
		if(!empty($check->id)){
			return -1;	
		}
		$array['companyid'] = $this->login->companyid;
		$array['friendlyurl'] = $this->site->friendlyURL($array['location_name']);
		$result = $this->model->table($tb['hotel_location'])->insert($array);	
		return $result;
	}
	function edits($array,$id){
		$tb = $this->base_model->loadTable();
		 $check = $this->model->table($tb['hotel_location'])
		 ->select('id')
		 ->where('isdelete',0)
		 ->where('id <>',$id)
		 ->where('location_name',$array['location_name'])
		 ->where('companyid',$this->login->companyid)
		 ->find();
		 if(!empty($check->id)){
			 return -1;	
		 }
		 $array['companyid'] = $this->login->companyid;
		 $array['friendlyurl'] = $this->site->friendlyURL($array['location_name']);
		 $result = $this->model->table($tb['hotel_location'])->where('id',$id)->update($array);	
		 return $id;
	 }
	 function findID($id){
		 $tb = $this->base_model->loadTable();
		 $query = $this->model->table($tb['hotel_location'])
					  ->select('*')
					  ->where('id',$id)
					  ->find();
		return $query;
	 }
}