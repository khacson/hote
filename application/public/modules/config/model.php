<?php
/**
 * @author 
 * @copyright 2015
 */
 class ConfigModel extends CI_Model{
	function __construct(){
		parent::__construct('hotel_config');
		$this->login = $this->site->getSession('login');
	}
	function getSearch($search){
		$sql = "";
		if(!empty($search['description'])){
			$sql.= " and c.description = '".$search['description']."' ";	
		}
		return $sql;
	}
	function getList($search,$page,$rows){
		$searchs = $this->getSearch($search);
		$sql = "SELECT c.id, c.description, c.config_key, c.config_val
				FROM hotel_config AS c
				WHERE c.isdelete = 0 
				$searchs
				";
		if(empty($search['order'])){
			$sql.= ' ORDER BY c.id  ASC';
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
		FROM hotel_config AS c
		WHERE c.isdelete = 0 
		$searchs	
		";
		$query = $this->model->query($sql)->execute();
		return $query[0]->total;	
	}
	function edits($array,$id){
		 $chek = $this->model
						->select('id')
						->table('hotel_config')
						->where('companyid',$array['companyid'])
						->find();
		 if(!empty($chek->id)){
			  $result = $this->model
						->table('hotel_config')
						->where('id',$chek->id)
						->update($array);	
		 }
		 else{
			$array['datecreate'] = $array['dateupdate'];
			$array['usercreate'] = $array['userupdate'];
			unset($array['dateupdate']);
			unset($array['userupdate']);
			$result = $this->model
						->table('hotel_config')
						->insert($array);
		 }
		 return 1;
	}
	function findID(){
		$query = $this->model->table('hotel_config')
					  ->select('*')
					  ->where('companyid',$this->login->companyid)
					  ->find();
		if(!empty($query->id)){
			return $query;
		}
		else{
			return $this->getNone();
		}
	}
	function getNone(){
		$sql = "
		SELECT column_name
		FROM information_schema.columns
		WHERE table_name='hotel_config'; 
		";
		$query = $this->model->query($sql)->execute();
		$obj = new stdClass();
		foreach($query as $item){
			$clm = $item->column_name;
			$obj->$clm = null;
		}
		return $obj;
	} 
}