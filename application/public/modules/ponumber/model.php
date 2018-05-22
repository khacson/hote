<?php
/**
 * @author 
 * @copyright 2018
 */
 class PonumberModel extends CI_Model{
	function __construct(){
		parent::__construct('');
		$this->login = $this->site->getSession('login');
	}
	function findID($id){
		$tb = $this->base_model->loadTable(); 
		$query = $this->model->table($tb['hotel_ponumber'])
					  ->select('*')
					  ->where('id',$id)
					  ->find();
		return $query;
	 }
	function getSearch($search){
		$sql = "";
		$companyid = $this->login->companyid;
		if(!empty($search['ponumber'])){
			$sql.= " and p.ponumber  like '%".addslashes($search['ponumber'])."%' ";	
		}
		if(!empty($search['quantity'])){
			$sql.= " and p.quantity  like '%".addslashes($search['quantity'])."%' ";	
		}
		if(!empty($search['description'])){
			$sql.= " and p.description  like '%".addslashes($search['description'])."%' ";	
		}
		if(!empty($search['dateinput'])){
			$sql.= " and p.dateinput = '".fmDateSave($search['dateinput'])."' ";	
		}
		if(!empty($search['supplierid'])){
			$sql.= " and p.supplierid  in (".($search['supplierid']).") ";	
		}
		return $sql;
	}
	function getList($search,$page,$rows){
		$tb = $this->base_model->loadTable();
		$searchs = $this->getSearch($search);
		$sql = "SELECT p.*, s.supplier_name
				FROM `".$tb['hotel_ponumber']."` AS p
				LEFT JOIN `".$tb['hotel_supplier']."` AS s on s.id = p.supplierid
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
		FROM `".$tb['hotel_ponumber']."` AS p
		WHERE p.isdelete = 0 
		$searchs	
		";
		$query = $this->model->query($sql)->execute();
		return $query[0]->total;	
	}
	function saves($array){
		$this->db->trans_begin();
		$tb = $this->base_model->loadTable();
		foreach($array as $key=>$val){
			$array[$key] = trim($val);
		}
		$check = $this->model->table($tb['hotel_ponumber'])
					  ->select('id')
					  ->where('isdelete',0)
					  ->where('ponumber',$array['ponumber'])
					  ->where('supplierid',$array['supplierid'])
					  ->find();
		if(!empty($check->id)){
			return -1;	
		}
		if(!empty($array['dateinput'])){
			$array['dateinput'] = fmDateSave($array['dateinput']);
		}
		else{
			$array['dateinput'] = '0000-00-00';
		}
		$result = $this->model->table($tb['hotel_ponumber'])->insert($array);	
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
		 foreach($array as $key=>$val){
			$array[$key] = trim($val);
		 }
		 $check = $this->model->table($tb['hotel_ponumber'])
		 ->select('id')
		 ->where('isdelete',0)
		 ->where('id <>',$id)
		 ->where('ponumber',$array['ponumber'])
		 ->where('supplierid',$array['supplierid'])
		 ->find();
		 if(!empty($check->id)){
			 return -1;	
		 }
		 if(!empty($array['dateinput'])){
			$array['dateinput'] = fmDateSave($array['dateinput']);
		 }
		 else{
			$array['dateinput'] = '0000-00-00';
		 }
		 $result = $this->model->table($tb['hotel_ponumber'])->where('id',$id)->update($array);	
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