<?php
/**
 * @author 
 * @copyright 2015
 */
 class ProvinceModel extends CI_Model{
	function __construct(){
		parent::__construct('hotel_province');
	}
	function findID($id) {
        $query = $this->model->table('hotel_province')
					  ->where('isdelete',0)
					  ->where('id',$id)
					  ->find();
        return $query;
    }
	function getSearch($search){
		$sql = "";
		if(!empty($search['province_name'])){
			$sql.= " and p.province_name = '".$search['province_name']."' ";	
		}
		return $sql;
	}
	function getList($search,$page,$rows){
		$searchs = $this->getSearch($search);
		$sql = "SELECT p.id, p.province_name
				FROM hotel_province AS p
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
		$searchs = $this->getSearch($search);
		$sql = " 
		SELECT count(1) total
		FROM hotel_province AS p
		WHERE p.isdelete = 0 
		$searchs	
		";
		$query = $this->model->query($sql)->execute();
		return $query[0]->total;	
	}
	function saves($array){
		$check = $this->model->table('hotel_province')
					  ->select('id')
					  ->where('isdelete',0)
					  ->where('province_name',$array['province_name'])
					  ->find();
		if(!empty($check->id)){
			return -1;	
		}
		$array['friendlyurl'] = $this->site->friendlyURL($array['province_name']);
		$result = $this->model->table('hotel_province')->insert($array);	
		return $result;
	}
	function edits($array,$id){
		 $check = $this->model->table('hotel_province')
		 ->select('id')
		 ->where('isdelete',0)
		 ->where('id <>',$id)
		 ->where('province_name',$array['province_name'])
		 ->find();
		 if(!empty($check->id)){
			 return -1;	
		 }
		 $array['friendlyurl'] = $this->site->friendlyURL($array['province_name']);
		 $result = $this->model->table('hotel_province')->where('id',$id)->update($array);	
		 return $id;
	 }
}