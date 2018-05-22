<?php
/**
 * @author 
 * @copyright 2015
 */
 class EmployeesaleModel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->login = $this->site->getSession('login');
	}
	function getSearch($search){
		$sql = "";
		$companyid = $this->login->companyid;
		$branchid = $this->login->branchid;
		$sql.= " and c.companyid = '".$companyid."' ";	
		if(!empty($branchid)){
			$sql.= " and c.branchid in (".$branchid.") ";	
		}
		else{
			if(!empty($search['branchid'])){
				$sql.= " and c.branchid in (".$search['branchid'].") ";	
			}
		}
		if(!empty($search['employee_code'])){
			$sql.= " and c.employee_code like '%".$search['employee_code']."%' ";	
		}
		if(!empty($search['employee_name'])){
			$sql.= " and c.employee_name like '%".$search['employee_name']."%' ";	
		}
		if(!empty($search['sex'])){
			$sql.= " and c.sex = '".$search['sex']."' ";	
		}
		if(!empty($search['identity'])){
			$sql.= " and c.identity like '%".$search['identity']."%' ";	
		}
		return $sql;
	}
	function getList($search,$page,$rows){
		$searchs = $this->getSearch($search);
		$companyid = $this->login->companyid;
		$skey = $this->login->skey;
		$tb = $this->base_model->loadTable();
		$sql = "
				SELECT c.id,
				DES_DECRYPT(b.branch_name,'$skey') as branch_name,
				c.phone,
				c.employee_name,
				c.identity,
				c.branchid, c.companyid, c.employee_code, c.sex, c.birthday, c.identity_date, c.identity_from
				FROM `".$tb['hotel_employeesale']."` AS c
				LEFT JOIN `".$tb['hotel_branch']."` b on b.id = c.branchid
				WHERE c.isdelete = 0 
				and c.companyid = '".$companyid."' 
				and b.isdelete = 0 
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
		$searchs = $this->getSearch($search);
		$companyid = $this->login->companyid;
		$tb = $this->base_model->loadTable();
		$sql = " 
		SELECT count(1) total
		FROM `".$tb['hotel_employeesale']."` AS c
		LEFT JOIN `".$tb['hotel_branch']."` b on b.id = c.branchid
		WHERE c.isdelete = 0 
		and c.companyid = '".$companyid."' 
		and b.isdelete = 0 
		$searchs	
		";
		$query = $this->model->query($sql)->execute();
		return $query[0]->total;	
	}
	function saves($array){
		$companyid = $this->login->companyid;
		if(!empty($this->login->branchid)){
			$branchid = $this->login->branchid;
		}
		else{
			$branchid = $array['branchid'];
		}
		$tb = $this->base_model->loadTable();
		$skey = $this->login->skey;
		$check = $this->model->table($tb['hotel_employeesale'])
					  ->select('id')
					  ->where('isdelete',0)
					  ->where('employee_code',$array['employee_code'])
					  ->find();
		if(!empty($check->id)){
			return -1;	
		}
		if(!empty($array['identity_date'])){
			$array['identity_date'] = date('Y-m-d',strtotime($array['identity_date']));
		}
		else{
			$array['identity_date'] = null;
		}
		if(!empty($array['birthday'])){
			$array['birthday'] = date('Y-m-d',strtotime($array['birthday']));
		}
		else{
			$array['birthday'] = null;
		}
		$sql = "
				INSERT INTO `".$tb['hotel_employeesale']."` 
				(
				`branchid`,`companyid`, `employee_code`, `sex`, `birthday`, `identity_date`, `identity_from`, 
				`phone`, 
				`employee_name`,
				`identity`,
				`datecreate`, `usercreate`,`isdelete`) 
				VALUES 
				(
				'".$branchid."', 
				'".$companyid."', 
				'".$array['employee_code']."', 
				'".$array['sex']."', 
				'".$array['birthday']."', 
				'".$array['identity_date']."', 
				'".$array['identity_from']."', 
				'".$array['phone']."', 
				'".$array['employee_name']."', 
				'".$array['identity']."', 
				'".$array['datecreate']."', 
				'".$array['usercreate']."',
				'0');
			;
		";
		$result = $this->model->executeQuery($sql);	
		return 1;
	}
	function edits($array,$id){
		$companyid = $this->login->companyid;
		if(!empty($this->login->branchid)){
			$branchid = $this->login->branchid;
		}
		else{
			$branchid = $array['branchid'];
		}
		$tb = $this->base_model->loadTable();
		$skey = $this->login->skey;
		$check = $this->model->table($tb['hotel_employeesale'])
		 ->select('id')
		 ->where('isdelete',0)
		 ->where('id <>',$id)
		 ->where('employee_code',$array['employee_code'])
		 ->find();
		 if(!empty($check->id)){
			 return -1;	
		 }
		 if(!empty($array['identity_date'])){
			$array['identity_date'] = date('Y-m-d',strtotime($array['identity_date']));
		 }
		 else{
			 $array['identity_date'] = null;
		 }
		 if(!empty($array['birthday'])){
			$array['birthday'] = date('Y-m-d',strtotime($array['birthday']));
		 }
		 else{
			 $array['birthday'] = null;
		 }
		 $sql = "
			UPDATE `".$tb['hotel_employeesale']."` SET 
			`branchid`='".$branchid."',			
			`companyid`='".$companyid."',
			`employee_code`='".$array['employee_code']."', 
			`sex`='".$array['sex']."',			
			`birthday`='".$array['birthday']."',
			`identity_date`='".$array['identity_date']."', 
			`identity_from`= '".$array['identity_from']."',		
			`phone`= '".$array['phone']."',			
			`employee_name`= '".$array['employee_name']."',			
			`identity`= '".$array['identity']."',			
			`userupdate`='".$array['userupdate']."',
			`dateupdate`='".$array['dateupdate']."'
			WHERE `id`='$id';
		 ";
		 $this->model->executeQuery($sql);	
		 return $id;
	 }
	 function findID($id){
		 $tb = $this->base_model->loadTable();
		 $query = $this->model->table($tb['hotel_employeesale'])
					  ->select('*')
					  ->where('id',$id)
					  ->find();
		return $query;
	 }
}