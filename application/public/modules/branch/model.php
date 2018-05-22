<?php
/**
 * @author 
 * @copyright 2015
 */
 class BranchModel extends CI_Model{
	function __construct(){
		parent::__construct('');
		$this->login = $this->site->getSession('login');
	}
	function findID($id){
		 $skey = $this->login->skey;
		 $tb = $this->base_model->loadTable();
		 $query = $this->model->table($tb['hotel_branch'])
					  ->select("*")
					  ->where('id',$id)
					  ->find();
		return $query;
	}
	function getSearch($search){
		$sql = "";
		$companyid = $this->login->companyid;
		if(!empty($search['branch_name'])){
			$sql.= " and b.branch_name like '%".$search['branch_name']."%' ";	
		}
		if(!empty($search['phone'])){
			$sql.= " and b.phone like '%".$search['branch_name']."%' ";	
		}
		if(!empty($search['fax'])){
			$sql.= " and b.fax like '%".$search['fax']."%' ";	
		}
		if(!empty($search['email'])){
			$sql.= " and b.email like '%".$search['email']."%' ";	
		}
		if(!empty($search['provinceid'])){
			$sql.= " and b.provinceid in (".$search['provinceid'].") ";	
		}
		if(!empty($search['districid'])){
			$sql.= " and b.districid in (".$search['districid'].") ";	
		}
		return $sql;
	}
	function getList($search,$page,$rows){
		$tb = $this->base_model->loadTable();
		$skey = $this->login->skey;
		$searchs = $this->getSearch($search);
		$companyid = $this->login->companyid;
		$sql = "
				SELECT b.*,
				p.province_name, d.distric_name
				FROM `".$tb['hotel_branch']."` AS b
				LEFT JOIN hotel_province p on p.id = b.provinceid and p.isdelete = 0
				LEFT JOIN hotel_district d on d.id = b.districid and d.isdelete = 0
				WHERE b.isdelete = 0 
				$searchs
				";
		if(empty($search['order'])){
			$sql.= ' ORDER BY b.id DESC ';
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
		FROM `".$tb['hotel_branch']."` AS b
		LEFT JOIN hotel_province p on p.id = b.provinceid and p.isdelete = 0
		LEFT JOIN hotel_district d on d.id = b.districid and d.isdelete = 0
		WHERE b.isdelete = 0 
		$searchs	
		
		";
		$query = $this->model->query($sql)->execute();
		return $query[0]->total;	
	}
	function saves($array){
		$tb = $this->base_model->loadTable();
		$skey = $this->login->skey;
		$companyid = $this->login->companyid;
		$sqlCheck = "
			select s.id
			from `".$tb['hotel_branch']."` s
			where s.isdelete = 0
			and s.branch_name = '".$array['branch_name']."'
		";
		$check = $this->model->query($sqlCheck)->execute();
		if(!empty($check[0]->id)){
			return -1;	
		}
		$this->model->table($tb['hotel_branch'])->insert($array);
		return 1;
	}
	function edits($array,$id){
		$tb = $this->base_model->loadTable();
		$skey = $this->login->skey;
		$companyid = $this->login->companyid;
		$sqlCheck = "
			select s.id
			from `".$tb['hotel_branch']."` s
			where s.isdelete = 0
			and s.id <> '$id'
			and s.branch_name = '".$array['branch_name']."'
		 ";
		 $check = $this->model->query($sqlCheck)->execute();
		 if(!empty($check[0]->id)){
			return -1;	
		 }
		 $this->model->table($tb['hotel_branch'])->save($id,$array);
		 return $id;
	 }
	 
}