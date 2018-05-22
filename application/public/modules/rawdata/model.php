<?php
/**
 * @author 
 * @copyright 2015
 */
 class RawdataModel extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	function findID($id){
		 $tb = $this->base_model->loadTable();
		 $query = $this->model->table($tb['hotel_rawdata'])
					  ->select('*')
					  ->where('id',$id)
					  ->find();
		return $query;
	 }
	function getUnit() {
        $query = $this->model->table('hotel_unit')
					  ->select('id,unit_name')
					  ->where('isdelete',0)
					  ->find_all();
        return $query;
    }
	function getSearch($search){
		$sql = "";
		if(!empty($search['rawdata_name'])){
			$sql.= " and r.rawdata_name like '%".$search['rawdata_name']."%' ";	
		}
		if(!empty($search['description'])){
			$sql.= " and r.description like '%".$search['description']."%' ";	
		}
		if(!empty($search['unitid'])){
			$sql.= " and r.unitid in (".$search['unitid'].") ";	
		}
		return $sql;
	}
	function getList($search,$page,$rows){
		$searchs = $this->getSearch($search);
		$tb = $this->base_model->loadTable();
		$sql = "SELECT r.id, r.rawdata_name, r.description, r.unitid, un.unit_name
				FROM `".$tb['hotel_rawdata']."` AS r
				LEFT JOIN `".$tb['hotel_unit']."`  un on un.id = r.unitid
				WHERE r.isdelete = 0 
				$searchs
				";
		if(empty($search['order'])){
			$sql.= ' ORDER BY r.id DESC ';
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
		FROM `".$tb['hotel_rawdata']."` AS r
		WHERE r.isdelete = 0 
		$searchs	
		";
		$query = $this->model->query($sql)->execute();
		return $query[0]->total;	
	}
	function saves($array){
		$tb = $this->base_model->loadTable();
		$check = $this->model->table($tb['hotel_rawdata'])
					  ->select('id')
					  ->where('isdelete',0)
					  ->where('rawdata_name',$array['rawdata_name'])
					  ->find();
		if(!empty($check->id)){
			return -1;	
		}
		$result = $this->model->table($tb['hotel_rawdata'])->insert($array);	
		return $result;
	}
	function edits($array,$id){
		 $tb = $this->base_model->loadTable();
		 $check = $this->model->table($tb['hotel_rawdata'])
		 ->select('id')
		 ->where('isdelete',0)
		 ->where('id <>',$id)
		 ->where('rawdata_name',$array['rawdata_name'])
		 ->find();
		 if(!empty($check->id)){
			 return -1;	
		 }
		 $result = $this->model->table($tb['hotel_rawdata'])->where('id',$id)->update($array);	
		 return $id;
	 }
	 
}