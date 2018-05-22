<?php
/**
 * @author 
 * @copyright 2017
 */
 class HistoryreceiptsModel extends CI_Model{
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
		if(!empty($search['customerid'])){
			$sql.= " and sp.customerid in (".$search['customerid'].") ";	
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
		$sql = "SELECT sp.*, pty.receipts_type_name, spl.customer_name
				FROM `".$tb['hotel_receipts']."` sp
				LEFT JOIN `".$tb['hotel_receipts_type']."` pty on pty.id = sp.receipts_type and pty.isdelete = 0
				LEFT JOIN `".$tb['hotel_output_createorders']."` AS c on c.id = sp.orderid 
				and c.isdelete = 0 
				LEFT JOIN `".$tb['hotel_customer']."` spl on spl.id = c.customer_id and spl.isdelete = 0
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
				FROM `".$tb['hotel_receipts']."` sp
				LEFT JOIN `".$tb['hotel_receipts_type']."` pty on pty.id = sp.receipts_type and pty.isdelete = 0
				LEFT JOIN `".$tb['hotel_output_createorders']."` AS c on c.id = sp.orderid 
				and c.isdelete = 0 
				LEFT JOIN `".$tb['hotel_customer']."` spl on spl.id = c.customer_id and spl.isdelete = 0
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
		$query = $this->model->table($tb['hotel_receipts'])
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
		$query = $this->model->table($tb['hotel_receipts_type'])
					  ->select('*')
					  ->where('id',$id)
					  ->find();
		return $query;
	 }
}