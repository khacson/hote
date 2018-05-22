<?php
/**
 * @author 
 * @copyright 2015
 */
 class CustomerModel extends CI_Model{
	function __construct(){
		parent::__construct('');
		$this->login = $this->site->getSession('login');
		
	}
	function getSearch($search){
		//$companyid = $this->login->companyid;
		$sql = "";
		if(!empty($search['customer_name'])){
			$sql.= " and c.customer_name like '%".$search['customer_name']."%' ";	
		}
		if(!empty($search['customer_code'])){
			$sql.= " and c.customer_code like '%".$search['customer_code']."%' ";	
		}
		if(!empty($search['phone'])){
			$sql.= " and c.phone like '%".$search['customer_name']."%' ";	
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
		if(!empty($search['customertypeid'])){
			$sql.= " and c.customertypeid in (".$search['customertypeid'].") ";	
		}
		if(!empty($search['customergroupid'])){
			$sql.= " and c.customergroupid in (".$search['customergroupid'].") ";	
		}
		if(!empty($search['activefieldsid'])){
			$sql.= " and c.activefieldsid in (".$search['activefieldsid'].") ";	
		}
		if(!empty($search['ownertypeid'])){
			$sql.= " and c.ownertypeid in (".$search['ownertypeid'].") ";	
		}
		if(!empty($search['taxcode'])){
			$sql.= " and c.taxcode like '%".$search['taxcode']."%' ";	
		}
		if(!empty($search['bankcode'])){
			$sql.= " and c.bankcode like '%".$search['bankcode']."%' ";	
		}
		if(!empty($search['bankname'])){
			$sql.= " and c.bankname like '%".$search['bankname']."%' ";	
		}
		if(!empty($search['contact_name'])){
			$sql.= " and c.contact_name like '%".$search['contact_name']."%' ";	
		}
		if(!empty($search['contact_phone'])){
			$sql.= " and c.contact_phone like '%".$search['contact_phone']."%' ";	
		}
		if(!empty($search['birthday'])){
			$sql.= " and c.birthday = '".fmDateSave($search['birthday'])."' ";	
		}
		return $sql;
	}
	function getList($search,$page,$rows){
		$skey = $this->login->skey;
		$tb = $this->base_model->loadTable();
		$searchs = $this->getSearch($search);
		//$companyid = $this->login->companyid;
		$sql = "
				SELECT c.*, ct.customertype_name, p.province_name,
				c.taxcode,c.bankcode,c.bankname, cg.customergroup_name, cf.activefields_name, co.ownertype_name
				FROM `".$tb['hotel_customer']."` AS c
				LEFT JOIN hotel_province p on p.id = c.provinceid 
				LEFT JOIN `".$tb['hotel_customertype']."` ct on ct.id = c.customertypeid 
				LEFT JOIN `".$tb['hotel_customergroup']."` cg on cg.id = c.customergroupid 
				LEFT JOIN `".$tb['hotel_customeractivefields']."` cf on cf.id = c.activefieldsid 
				LEFT JOIN `".$tb['hotel_customerownertype']."` co on co.id = c.ownertypeid 
				WHERE c.isdelete = 0  
				$searchs
				";
		if(empty($search['order'])){
			$sql.= ' ORDER BY c.id DESC ';
		}
		else{
			$sql.= ' ORDER BY '.$search['order'].' '.$search['index'].' ';
		}
		if(!empty($rows)){
			$sql.= ' limit '.$page.','.$rows;
		}
		$query = $this->model->query($sql)->execute();
		return $query;
	}
	function getTotal($search){
		$searchs = $this->getSearch($search);
		$tb = $this->base_model->loadTable();
		$sql = " 
		SELECT count(1) total
		FROM `".$tb['hotel_customer']."` AS c
		LEFT JOIN hotel_province p on p.id = c.provinceid and p.isdelete = 0
		LEFT JOIN hotel_district d on d.id = c.districid and d.isdelete = 0
		WHERE c.isdelete = 0 
		$searchs	
		";
		$query = $this->model->query($sql)->execute();
		return $query[0]->total;	
	}
	function saves($array,$checkprint){
		$skey = $this->login->skey;
		$tb = $this->base_model->loadTable();
		//$companyid = $this->login->companyid;
		if(!empty($array['birthday'])){
			$birthday = fmDateSave($array['birthday']);
		}
		else{
			$birthday = '0000-00-00';
		}
		$sqlCheck = "
			select s.id
			from `".$tb['hotel_customer']."` s
			where s.isdelete = 0
			and s.customer_code = '".$array['customer_code']."'
		";
		$check = $this->model->query($sqlCheck)->execute();
		if(!empty($check[0]->id)){
			return -1;	
		}
		$array['birthday'] = $birthday;
		$this->model->table($tb['hotel_customer'])->insert($array);
		return 1;
	}
	function edits($array,$id,$checkprint){
		$skey = $this->login->skey;
		//$companyid = $this->login->companyid;
		$tb = $this->base_model->loadTable();
		if(!empty($array['birthday'])){
			$birthday = fmDateSave($array['birthday']);
		}
		else{
			$birthday = '0000-00-00';
		}
		$sqlCheck = "
			select s.id
			from `".$tb['hotel_customer']."` s
			where s.isdelete = 0
			and s.id <> '$id'
			and s.customer_code = '".$array['customer_code']."'
		";
		$check = $this->model->query($sqlCheck)->execute();
		if(!empty($check[0]->id)){
			return -1;	
		}
		$array['birthday'] = $birthday;
		$this->model->table($tb['hotel_customer'])->save($id,$array);
		return $id;
	 }
	function findID($id){
		$skey = $this->login->skey;
		$tb = $this->base_model->loadTable();
		$query = $this->model->table($tb['hotel_customer'])
					  ->select("*")
					  ->where('id',$id)
					  ->find();
		return $query;
	 }
	function customerType(){
		$tb = $this->base_model->loadTable();
		$query = $this->model->table($tb['hotel_customertype'])
					  ->select("id,customertype_name")
					  ->order_by('ordering')
					  ->find_all();
		return $query;
	}
	function customerGroup(){
		$tb = $this->base_model->loadTable();
		$query = $this->model->table($tb['hotel_customergroup'])
					  ->select("id,customergroup_name")
					  ->order_by('ordering')
					  ->find_all();
		return $query;
	}
	function customerActiveFields(){
		$tb = $this->base_model->loadTable();
		$query = $this->model->table($tb['hotel_customeractivefields'])
					  ->select("id,activefields_name")
					  ->order_by('ordering')
					  ->find_all();
		return $query;
	}
	function customerOwnerType(){
		$tb = $this->base_model->loadTable();
		$query = $this->model->table($tb['hotel_customerownertype'])
					  ->select("id,ownertype_name")
					  ->order_by('ordering')
					  ->find_all();
		return $query;
	}
}