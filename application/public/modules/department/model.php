<?php
/**
 * @author sonnk
 * @copyright 2016
 */
class DepartmentModel extends CI_Model
{
	function __construct(){
		parent::__construct('');
	}
	function findID($id) {
		$tb = $this->base_model->loadTable();
        $query = $this->model->table($tb['hotel_department'])
					  ->where('isdelete',0)
					  ->where('id',$id)
					  ->find();
        return $query;
    }
	function getSearch($search){
		$sql = "";
		if(!empty($search['departmanet_name'])){
			$sql.= " and d.departmanet_name like '%".$search['departmanet_name']."%' ";	
		}
		if(!empty($search['phone'])){
			$sql.= " and d.phone like '%".$search['phone']."%' ";	
		}
		if(!empty($search['fax'])){
			$sql.= " and d.fax like '%".$search['fax']."%' ";	
		}
		if(!empty($search['heads'])){
			$sql.= " and d.heads like '%".$search['heads']."%' ";	
		}
		return $sql;
	}
	function getList($search,$page,$rows){
		$tb = $this->base_model->loadTable();
		$searchs = $this->getSearch($search);
		$sql = " SELECT d.*
				FROM `".$tb['hotel_department']."` AS d
				WHERE d.isdelete = 0 
				$searchs
				
				";
		if(empty($search['order'])){
			$sql .= " ORDER BY d.departmanet_name ASC  ";
		}
		else{
			$sql.= " ORDER BY ".$search['order']." ".$search['index']." ";
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
			FROM `".$tb['hotel_department']."` AS d
			WHERE d.isdelete = 0
			$searchs	
		";
		$query = $this->model->query($sql)->execute();
		return $query[0]->total;	
	}
	function saves($array,$id){
		$tb = $this->base_model->loadTable();
		$check = $this->model->table($tb['hotel_department'])
					  ->select('id')
					  ->where('isdelete',0)
					  ->where('departmanet_name',$array['departmanet_name'])
					  ->find();
		 if(!empty($check->id)){
			return -1;	
		 }
		 $result = $this->model->table('hotel_department')->insert($array);	
		 return $result;
	}
	function edits($array,$id){
		$tb = $this->base_model->loadTable();
		$check = $this->model->table($tb['hotel_department'])
				  ->select('id')
				  ->where('isdelete',0)
				  ->where('departmanet_name',$array['departmanet_name'])
				  ->where('id <>',$id)
				  ->find();
		if(!empty($check->id)){
			return -1;	
		}
		$this->model->table($tb['hotel_department'])
					->where('id',$id)
					->update($array);	
		return $id;
		
	}
	function deletes($id,$array){
		$tb = $this->base_model->loadTable();
		$this->model->table($tb['hotel_department'])
					->where("id in ($id)")
					->update($array);
		return 1;
	}
}