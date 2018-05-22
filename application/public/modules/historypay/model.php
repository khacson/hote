<?php
/**
 * @author 
 * @copyright 2017
 */
 class HistorypayModel extends CI_Model{
	function __construct(){
		parent::__construct('');
		$this->login = $this->site->getSession('login');
	}
	function getSearch($search){
		$sql = "";
		$tb = $this->base_model->loadTable();
		$companyid = $this->login->companyid;
		$branchid = $this->login->branchid;
		if(!empty($branchid)){
			$sql.= " and sp.branchid in (".$branchid.") ";	
		}
		if(!empty($search['poid'])){
			$sql.= " and sp.poid like '%".$search['poid']."%' ";	
		}
		if(!empty($search['pay_code'])){
			$sql.= " and sp.pay_code like '%".$search['pay_code']."%' ";	
		}
		if(!empty($search['notes'])){
			$sql.= " and sp.notes like '%".$search['notes']."%' ";	
		}
		if(!empty($search['supplierid'])){
			$sql.= " and sp.supplierid in (".$search['supplierid'].") ";	
		}
		if(!empty($search['fromdate'])){
			$sql.= " and sp.datepo >= '".fmDateSave($search['fromdate'])." 00:00:00' ";	
		}
		if(!empty($search['todate'])){
			$sql.= " and sp.datepo <= '".fmDateSave($search['todate'])." 00:00:00' ";	
		}
		return $sql;
	}
	function getList($search,$page,$rows){
		$tb = $this->base_model->loadTable();
		$searchs = $this->getSearch($search); //price_prepay
		$having = '';
		$sql = "SELECT sp.*, pty.pay_type_name, spl.supplier_name
				FROM `".$tb['hotel_pay']."` sp
				LEFT JOIN `".$tb['hotel_pay_type']."` pty on pty.id = sp.pay_type and pty.isdelete = 0
				LEFT JOIN `".$tb['hotel_input_createorders']."` AS c on c.id = sp.orderid 
				and c.isdelete = 0 
				LEFT JOIN `".$tb['hotel_supplier']."` spl on spl.id = c.supplierid and spl.isdelete = 0
				WHERE sp.isdelete = 0
				$searchs
		";
		if(empty($search['order'])){
			$sql.= ' ORDER BY c.id DESC ';
		}
		else{
			$sql.= ' ORDER BY '.$search['order'].' '.$search['index'].' ';
		}
		if($rows !=0){
			$sql.= ' limit '.$page.','.$rows;
		}
		$query = $this->model->query($sql)->execute();
		return $query;
	}
	function getTotal($search){
		$tb = $this->base_model->loadTable();
		$searchs = $this->getSearch($search); //price_prepay
		$sql = "
				SELECT count(1) total
				FROM `".$tb['hotel_pay']."` sp
				LEFT JOIN `".$tb['hotel_pay_type']."` pty on pty.id = sp.pay_type and pty.isdelete = 0
				LEFT JOIN `".$tb['hotel_input_createorders']."` AS c on c.id = sp.orderid 
				and c.isdelete = 0 
				LEFT JOIN `".$tb['hotel_supplier']."` spl on spl.id = c.supplierid and spl.isdelete = 0
				WHERE sp.isdelete = 0
				$searchs
				";
		$query = $this->model->query($sql)->execute();
		return $query[0]->total;	
	}
	function findID($id){
		$tb = $this->base_model->loadTable();	
		$query = $this->model->table($tb['hotel_input'])
					  ->select('*')
					  ->where('id',$id)
					  ->find();
		return $query;
	}
	function findUniqueID($uniqueid){
		$tb = $this->base_model->loadTable();	
		$query = $this->model->table($tb['hotel_pay'])
					  ->select('*')
					  ->where('orderid',$uniqueid)
					  ->find();
		return $query;
	}
	function findIDs($id){
		$tb = $this->base_model->loadTable();
		$query = $this->model->table($tb['hotel_input'])
					  ->select('*')
					  ->where('id',$id)
					  ->find();
		return $query;
	}
	function payType($id){
		$tb = $this->base_model->loadTable();
		$query = $this->model->table($tb['hotel_pay_type'])
					  ->select('*')
					  ->where('id',$id)
					  ->find();
		return $query;
	 }
}