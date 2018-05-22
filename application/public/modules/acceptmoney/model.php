<?php
/**
 * @author 
 * @copyright 2018
 */
 class AcceptmoneyModel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->login = $this->site->getSession('login');
	}
	function findID($id){
		$tb = $this->base_model->loadTable();
		$query = $this->model->table($tb['hotel_pay_type'])
					  ->select('*')
					  ->where('id',$id)
					  ->find();
		return $query;
	 }
	function getSearch($search){
		$sql = "";
		$login = $this->login;
		if(!empty($login->branchid)){
			$sql.= " and ac.branchid = '".$login->branchid ."' ";	
		}
		else{
			if(!empty($search['branchid'])){
				$sql.= " and ac.branchid = '".$search['branchid']."' ";	
			}
		}
		if(!empty($search['datecreate'])){
			$arrayDate = explode('-',$search['datecreate']);
			$fromdate = 0;
			if(!empty($arrayDate[0])){
				$fromdate = fmDateSave(trim($arrayDate[0]));
			}
			$todate = 0;
			if(!empty($arrayDate[1])){
				$todate = fmDateSave(trim($arrayDate[1]));
			}
			$sql.= " and ac.datecreate >= '".$fromdate." 00:00:00' ";	
			$sql.= " and ac.datecreate <= '".$todate." 23:59:59' ";	
			
		}
		if(!empty($search['useraceptid'])){
			$sql.= " and ac.useraceptid  in (".$search['useraceptid'].") ";	
		}
		if(!empty($search['personid'])){
			$sql.= " and ac.personid in (".$search['personid'].") ";	
		}
		if(!empty($search['receiptcode'])){
			$sql.= " and ac.receiptcode like '%".fmNumberSave($search['receiptcode'])."%' ";	
		}
		if(!empty($search['money'])){
			$sql.= " and ac.money like '%".fmNumberSave($search['money'])."%' ";	
		}
		if(!empty($search['description'])){
			$sql.= " and ac.description like '%".$search['description']."%' ";	
		}
		return $sql;
	}
	function getList($search,$page,$rows){
		$tb = $this->base_model->loadTable();
		$searchs = $this->getSearch($search);
		$sql = " SELECT ac.*, br.branch_name, u.fullname, us.fullname as pfullname
				FROM `".$tb['hotel_acceptmoney']."` AS ac
				LEFT JOIN `".$tb['hotel_branch']."` br on br.id = ac.branchid
				LEFT JOIN `hotel_users` u on u.id = ac.useraceptid
				LEFT JOIN `hotel_users` us on us.id = ac.personid
				WHERE ac.isdelete = 0 
				$searchs
				and ac.isdelete = 0
				ORDER BY ac.money ASC 
				";// print_r($sql); exit;
		if(!empty($rows)){
			$sql.= ' limit '.$page.','.$rows;
		}
		$query = $this->model->query($sql)->execute();
		return $query;
	}
	function getTotal($search){
		$tb = $this->base_model->loadTable();
		$searchs = $this->getSearch($search);
		$sql = " 
		SELECT count(1) total  
			FROM `".$tb['hotel_acceptmoney']."` AS ac
			LEFT JOIN `".$tb['hotel_branch']."` br on br.id = ac.branchid
			WHERE ac.isdelete = 0
			$searchs	
			and br.isdelete = 0
		";
		$query = $this->model->query($sql)->execute();
		return $query[0]->total;	
	}
	function saves($array){
		$result = array();
		$tb = $this->base_model->loadTable();
		$array['money'] = fmNumberSave($array['money']);
		//$array['datepay'] = fmDateSave($array['datepay']);
		//$array['personid'] = $this->login['id'];
		//Find user
		$finds = $this->model->table('hotel_users')->where('id',$array['useraceptid'])->find();
		if(!empty($finds->id)){
			$array['branchid'] = $finds->branchid;
		}
		$id = $this->model->table($tb['hotel_acceptmoney'])->save('',$array);	
		$result['id'] = $id;
		$result['status'] = 1;
		return $result;
	}
	function edits($array,$id){
		$result = array();
		$tb = $this->base_model->loadTable();
		$array['money'] = fmNumberSave($array['money']);
		//$array['datepay'] = fmDateSave($array['datepay']);
		//$array['personid'] = $this->login['id'];
		//Find user
		$finds = $this->model->table('hotel_users')->where('id',$array['useraceptid'])->find();
		if(!empty($finds->id)){
			$array['branchid'] = $finds->branchid;
		}
		$this->model->table($tb['hotel_acceptmoney'])
					->where('id',$id)
					->update($array);	
		$result['id'] = $id;
		$result['status'] = 1;
		return $result;
	}
	function deletes($id,$array){
		$tb = $this->base_model->loadTable();
		$this->model->table($tb['hotel_acceptmoney'])
					->where("id in ($id)")
					->update($array);
		return 1;
	}
}