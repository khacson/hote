<?php
 class UserModel extends CI_Model{
	function __construct(){
		parent::__construct('hotel_users');
		$this->login = $this->site->getSession('login');
	}
	public function getGroupList($companyid) {
		//$login = $this->login;
		$query = $this->model->table('hotel_groups')
						 ->select('id,groupname')
						 ->where('isdelete',0);	
		if(!empty($companyid)){
			$query = $query->where('companyid',$companyid);
		}
		$query = $query->find_all();
		return $query;
	}
	function findID($id) {
        $query = $this->model->table('hotel_users')
					  ->where('isdelete',0)
					  ->where('id',$id)
					  ->find();
        return $query;
    }
	function getSearch($search){
		$sql = "";
		if (!empty($search['username'])) {
			$sql .= " AND u.username LIKE '%".$search['username']."%' ";
		}
		if (!empty($search['fullname'])) {
			$sql .= " AND u.fullname LIKE '%".$search['fullname']."%' ";
		}
		if (!empty($search['email'])) {
			$sql .= " AND u.email LIKE '%".$search['email']."%' ";
		}
		if (!empty($search['phone'])) {
			$sql .= " AND u.phone LIKE '%".$search['phone']."%' ";
		}
		if (!empty($search['groupid'])) {
			$sql .= " AND u.groupid = '".$search['groupid']."' ";
		}
		$login = $this->login;
		if(!empty($login->companyid)){
			$sql .= " AND u.companyid = '".$login->companyid ."' ";
		}
		return $sql;
	}
	function getList($search,$page,$numrows){
		$tb = $this->base_model->loadTable();
		$branch = $tb['hotel_branch'];
		$skey = $this->login->skey;
		
		$sql = " SELECT u.id,u.username,u.branchid, u.fullname, u.groupid, u.image, c.company_name, u.signature,
				 u.mobile, u.email, u.datecreate, g.groupname,g.grouptype, u.companyid, u.warehouseid, 
				 DES_DECRYPT(b.branch_name,'$skey') as branch_name
				FROM hotel_users AS u 
				LEFT JOIN hotel_groups AS g ON g.id = u.groupid
				LEFT JOIN hotel_company AS c ON c.id = g.companyid AND c.isdelete = 0
				LEFT JOIN `".$branch."` AS b ON b.id = u.branchid
				WHERE u.isdelete = 0 
				AND g.isdelete = 0
				";
		$sql.= $this->getSearch($search);
		$sql .= " ORDER BY u.id DESC ";
        $sql.= ' limit '.$page.','.$numrows;
		
		return $this->model->query($sql)->execute();
	}
	function getTotal($search){
		$sql = " SELECT COUNT(1) AS total
				FROM hotel_users AS u 
				LEFT JOIN hotel_groups AS g ON g.id = u.groupid
				LEFT JOIN hotel_company AS c ON c.id = g.companyid AND c.isdelete = 0
				WHERE u.isdelete = 0 
				AND g.isdelete = 0
				
				";
		$sql.= $this->getSearch($search);
		$query = $this->model->query($sql)->execute();
		if(empty($query[0]->total)){
			return 0;
		}
		else{
			return $query[0]->total;
		}
	}
	function export($search){
		return $this->getList($search);
	}
	function saves($array){
		 $login = $this->login;
		 $check = $this->model->table('hotel_users')
		 ->select('id')
		 ->where('isdelete',0)
		 ->where('username',$array['username'])
		 ->find();
		 if(!empty($check->id)){
			 return -1;	
		 }
		 unset($array['cfpassword']);
		 $array['companyid'] =  $this->getGroup($array['groupid']);
		 $array['password'] =  md5(md5($array['password'])."Sales@SN");
		 $result = $this->model
						->table('hotel_users')
						->insert($array);	
		 return $result;
	}
	function edits($array,$id){
		 $check = $this->model->table('hotel_users')
		 ->select('id')
		 ->where('isdelete',0)
		 ->where('username',$array['username'])
		 ->where('id <>',$id)
		 ->find();
		 if(!empty($check->id)){
			 return -1;	
		 }//print_r($array);exit;
		 unset($array['cfpassword']);
		 $array['companyid'] = $this->getGroup($array['groupid']);
		 if(isset($array['password']) && $array['password']!=""){
			 $array['password'] =  md5(md5($array['password'])."Sales@SN");
		 }
		 $result = $this->model->table('hotel_users')->save($id,$array);	
		 return $result;
	}
	function getGroup($groupid){
		$companyid = $this->model->table('hotel_groups')
					  ->select('id,companyid')
					  ->where('isdelete',0)
					  ->where('id',$groupid)
					  ->find()->companyid;
		return $companyid;
		
	}
	function changueSearch($search){//print_r($search);exit;
		$groupid = '';//print_r($search['customers']);exit;
		if(isset($search['groupid'])){			
			$arr_g = explode("__",$search['groupid']);
			$groupid = isset($arr_g[0])?$arr_g[0]:"";
		}		
		unset($search['groupid']);
		$search['groupid'] = $groupid;		
		return $search;
	}
}