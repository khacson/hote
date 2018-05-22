<?php
/**
 * @author 
 * @copyright 2015
 */
 class CompanyModel extends CI_Model{
	function __construct(){
		parent::__construct('hotel_company');
		$this->login = $this->site->getSession('login');
	}
	function getSearch($search){
		$sql = "";
		if(!empty($search['company_name'])){
			$sql.= " and c.company_name like '%".$search['company_name']."%' ";	
		}
		if(!empty($search['phone'])){
			$sql.= " and c.phone like '%".$search['phone']."%' ";	
		}
		if(!empty($search['fax'])){
			$sql.= " and c.fax like '%".$search['fax']."%' ";	
		}
		if(!empty($search['email'])){
			$sql.= " and c.email like '%".$search['email']."%' ";	
		}
		if(!empty($search['provinceid'])){
			$sql.= " and c.provinceid in (".$search['provinceid'].") ";	
		}
		if(!empty($search['districid'])){
			$sql.= " and c.districid in (".$search['districid'].") ";	
		}
		$login = $this->login;
		if(!empty($login->companyid)){
			$sql .= " AND c.id = '".$login->companyid ."' ";
		}
		return $sql;
	}
	function getList($search,$page,$rows){
		$searchs = $this->getSearch($search);
		$sql = "SELECT c.*, p.province_name, d.distric_name
				FROM hotel_company AS c
				LEFT JOIN hotel_province p on p.id = c.provinceid and p.isdelete = 0
				LEFT JOIN hotel_district d on d.id = c.districid and d.isdelete = 0
				WHERE c.isdelete = 0 
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
		$sql = " 
		SELECT count(1) total
		FROM hotel_company AS c
		LEFT JOIN hotel_province p on p.id = c.provinceid
		LEFT JOIN hotel_district d on d.id = c.districid 
		WHERE c.isdelete = 0 
		$searchs	
		";
		$query = $this->model->query($sql)->execute();
		return $query[0]->total;	
	}
	function saves($array){
		$this->db->trans_start();
		$check = $this->model->table('hotel_company')
					  ->select('id')
					  ->where('isdelete',0)
					  ->where('company_name',$array['company_name'])
					  ->where('phone',$array['phone'])
					  ->find();
		if(!empty($check->id)){
			return -1;	
		}
		if(empty($array['count_warehouse'])){
			$array['count_warehouse'] = 1;
		}
		if(empty($array['count_branch'])){
			$array['count_branch'] = 1;
		}
		$data = $this->rand(). gmdate("ymdHis",time() + 7 * 3600).$this->site->friendlyURL($array['phone']).$this->site->friendlyURL($array['company_name']);
		$sql = "
				INSERT INTO `hotel_company` 
				(`company_name`, `phone`, `fax`, `email`, `address`, `provinceid`, `districid`, `count_warehouse`, `count_branch`, `datecreate`, `usercreate`,`skeys`) 
				VALUES 
				('".$array['company_name']."', '".$array['phone']."', '".$array['fax']."', '".$array['email']."', '".$array['address']."', '".$array['provinceid']."', '".$array['districid']."', '".$array['count_warehouse']."', '".$array['count_branch']."', '".$array['datecreate']."', '".$array['usercreate']."',DES_ENCRYPT('$data','sonnk2504'));
			;
		";
		//$result = $this->model->executeQuery($sql);	
		$check = $this->model->table('hotel_company')
					  ->select('id')
					  ->where('isdelete',0)
					  ->where('company_name',$array['company_name'])
					  ->order_by('id','DESC')
					  ->find();
		$companyid = $check->id; 
		$this->createTable($companyid);
		$this->db->trans_complete();
		return 1;
	}
	function createTable(){
		$sql = "
			SELECT TABLE_NAME as tables
			FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA='sales'
		";
		$result = $this->model->executeQuery($sql);	
		print_r($result); exit;
	}
	
	function rand(){
		$pool = '20122804';
		$str = '';
		for ($i = 0; $i < 4; $i++){
			$str .= substr($pool, mt_rand(0, strlen($pool) -1), 1);
		}
		return $str;
	}
	function edits($array,$id){
		 $check = $this->model->table('hotel_company')
		 ->select('id')
		 ->where('isdelete',0)
		 ->where('id <>',$id)
		 ->where('company_name',$array['company_name'])
		 ->where('phone',$array['phone'])
		 ->find();
		 if(!empty($check->id)){
			 return -1;	
		 }
		 //$array['friendlyurl'] = $this->site->friendlyURL($array['company_name']);
		 $result = $this->model->table('hotel_company')->where('id',$id)->update($array);	
		 return $id;
	 }
	function findID($id){
		 $query = $this->model->table('hotel_company')
					  ->select('*')
					  ->where('id',$id)
					  ->find();
		return $query;
	 }
}