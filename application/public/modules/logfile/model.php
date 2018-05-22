<?php
/**
 * @author 
 * @copyright 2015
 */
 class LogfileModel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->login = $this->site->getSession('login');
	}
	function getSearch($search){
		$sql = "";
		$companyid = $this->login->companyid;
		if(!empty($search['ctrol'])){
			$sql.= " and c.ctrol like '%".addslashes($search['ctrol'])."%' ";	
		}
		if(!empty($search['formdate'])){
			$sql.= " and c.datecreate >= '".fmDateSave($search['formdate'])." 00:00:00' ";	
		}
		if(!empty($search['todate'])){
			$sql.= " and c.datecreate <= '".fmDateSave($search['todate'])." 23:59:59' ";	
		}
		return $sql;
	}
	function getList($search,$page,$rows){
		$tb = $this->base_model->loadTable();
		$searchs = $this->getSearch($search);
		$sql = "SELECT c.*
				FROM `".$tb['hotel_acction']."` AS c
				WHERE 0 = 0 
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
		FROM `".$tb['hotel_acction']."` AS c
		WHERE 0 = 0 
		$searchs	
		";
		$query = $this->model->query($sql)->execute();
		return $query[0]->total;	
	}
}