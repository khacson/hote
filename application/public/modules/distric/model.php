<?php
/**
 * @author 
 * @copyright 2015
 */
 class DistricModel extends CI_Model{
	function __construct(){
		parent::__construct('hotel_district');
	}
	function getProvice() {
        $query = $this->model->table('hotel_province')
					  ->select('id,province_name')
					  ->where('isdelete',0)
					  ->find_all();
        return $query;
    }
	function getSearch($search){
		$sql = "";
		if(!empty($search['distric_name'])){
			$sql.= " and d.distric_name like '%".$search['distric_name']."%' ";	
		}
		if(!empty($search['provinceid'])){
			$sql.= " and d.provinceid in (".$search['provinceid'].") ";	
		}
		return $sql;
	}
	function getList($search,$page,$rows){
		$searchs = $this->getSearch($search);
		$sql = "SELECT d.id, d.distric_name, d.provinceid, p.province_name
				FROM hotel_district AS d
				LEFT JOIN hotel_province p on p.id = d.provinceid
				WHERE d.isdelete = 0 
				$searchs
				";
		if(empty($search['order'])){
			$sql.= ' ORDER BY d.id DESC ';
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
		FROM hotel_district AS d
		WHERE d.isdelete = 0 
		$searchs	
		";
		$query = $this->model->query($sql)->execute();
		return $query[0]->total;	
	}
	function saves($array){
		$check = $this->model->table('hotel_district')
					  ->select('id')
					  ->where('isdelete',0)
					  ->where('distric_name',$array['distric_name'])
					  ->find();
		if(!empty($check->id)){
			return -1;	
		}
		$array['friendlyurl'] = $this->site->friendlyURL($array['distric_name']);
		$result = $this->model->table('hotel_district')->insert($array);	
		return $result;
	}
	function edits($array,$id){
		 $check = $this->model->table('hotel_district')
		 ->select('id')
		 ->where('isdelete',0)
		 ->where('id <>',$id)
		 ->where('distric_name',$array['distric_name'])
		 ->find();
		 if(!empty($check->id)){
			 return -1;	
		 }
		 $array['friendlyurl'] = $this->site->friendlyURL($array['distric_name']);
		 $result = $this->model->table('hotel_district')->where('id',$id)->update($array);	
		 return $id;
	 }
	 function findID($id){
		 $query = $this->model->table('hotel_district')
					  ->select('*')
					  ->where('id',$id)
					  ->find();
		return $query;
	 }
}