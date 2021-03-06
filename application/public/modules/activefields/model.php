<?php
/**
 * @author 
 * @copyright 2018
 */
 class ActivefieldsModel extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	function findID($id) {
		$tb = $this->base_model->loadTable();
        $query = $this->model->table($tb['hotel_customeractivefields'])
					  ->where('isdelete',0)
					  ->where('id',$id)
					  ->find();
        return $query;
    }
	function getSearch($search){
		$sql = "";
		if(!empty($search['activefields_name'])){
			$sql.= " and p.activefields_name = '".$search['activefields_name']."' ";	
		}
		return $sql;
	}
	function getList($search,$page,$rows){
		$tb = $this->base_model->loadTable();
		$searchs = $this->getSearch($search);
		$sql = "SELECT p.*
				FROM `".$tb['hotel_customeractivefields']."` AS p
				WHERE p.isdelete = 0 
				$searchs
				";
		if(empty($search['order'])){
			$sql.= ' ORDER BY p.id DESC ';
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
		FROM `".$tb['hotel_customeractivefields']."` AS p
		WHERE p.isdelete = 0 
		$searchs	
		";
		$query = $this->model->query($sql)->execute();
		return $query[0]->total;	
	}
	function saves($array){
		$tb = $this->base_model->loadTable();
		$check = $this->model->table($tb['hotel_customeractivefields'])
					  ->select('id')
					  ->where('isdelete',0)
					  ->where('activefields_name',$array['activefields_name'])
					  ->find();
		if(!empty($check->id)){
			return -1;	
		}
		$result = $this->model->table($tb['hotel_customeractivefields'])->insert($array);	
		return $result;
	}
	function edits($array,$id){
		 $tb = $this->base_model->loadTable();
		 $check = $this->model->table($tb['hotel_customeractivefields'])
							 ->select('id')
							 ->where('isdelete',0)
							 ->where('id <>',$id)
							 ->where('activefields_name',$array['activefields_name'])
							 ->find();
		 if(!empty($check->id)){
			 return -1;	
		 }
		 $result = $this->model->table($tb['hotel_customeractivefields'])->where('id',$id)->update($array);	
		 return $id;
	 }
}