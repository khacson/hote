<?php
/**
 * @author 
 * @copyright 2015
 */
 class UnitModel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->login = $this->site->getSession('login');
	}
	function getSearch($search){
		$sql = "";
		$companyid = $this->login->companyid;
		if(!empty($search['unit_name'])){
			$sql.= " and c.unit_name like '%".addslashes($search['unit_name'])."%' ";	
		}
		return $sql;
	}
	function getList($search,$page,$rows){
		$tb = $this->base_model->loadTable();
		$searchs = $this->getSearch($search);
		$sql = "SELECT c.id, c.unit_name
				FROM `".$tb['hotel_unit']."` AS c
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
		FROM `".$tb['hotel_unit']."` AS c
		WHERE c.isdelete = 0 
		$searchs	
		";
		$query = $this->model->query($sql)->execute();
		return $query[0]->total;	
	}
	function saves($array){
		$tb = $this->base_model->loadTable();
		$check = $this->model->table($tb['hotel_unit'])
					  ->select('id')
					  ->where('isdelete',0)
					  ->where('unit_name',$array['unit_name'])
					  ->where('companyid',$this->login->companyid)
					  ->find();
		if(!empty($check->id)){
			return -1;	
		}
		$array['companyid'] = $this->login->companyid;
		$array['friendlyurl'] = $this->site->friendlyURL($array['unit_name']);
		$result = $this->model->table($tb['hotel_unit'])->insert($array);	
		return $result;
	}
	function edits($array,$id){
		$tb = $this->base_model->loadTable();
		 $check = $this->model->table($tb['hotel_unit'])
		 ->select('id')
		 ->where('isdelete',0)
		 ->where('id <>',$id)
		 ->where('unit_name',$array['unit_name'])
		 ->where('companyid',$this->login->companyid)
		 ->find();
		 if(!empty($check->id)){
			 return -1;	
		 }
		 $array['companyid'] = $this->login->companyid;
		 $array['friendlyurl'] = $this->site->friendlyURL($array['unit_name']);
		 $result = $this->model->table($tb['hotel_unit'])->where('id',$id)->update($array);	
		 return $id;
	 }
	 function findID($id){
		 $tb = $this->base_model->loadTable();
		 $query = $this->model->table($tb['hotel_unit'])
					  ->select('*')
					  ->where('id',$id)
					  ->find();
		return $query;
	 }
}