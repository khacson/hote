<?php
/**
 * @author 
 * @copyright 2015
 */
 class ReportsellpoModel extends CI_Model{
	function __construct(){
		parent::__construct('hotel_input');
		$this->login = $this->site->getSession('login');
	}
	function getPO(){
		 $companyid = $this->login->companyid;
		 $query = $this->model->table('hotel_output_createorders')
					  ->select('id,poid')
					  ->where('companyid',$companyid)
					  ->where('isdelete',0)
					  ->find_all();
		return $query;
	}
	function getSearch($search){
		$sql = "";
		$companyid = $this->login->companyid;
		$branchid = $this->login->branchid;
		$sql.= " and c.companyid = '".$companyid."' ";	
		if(!empty($branchid)){
			$sql.= " and c.branchid in (".$branchid.") ";	
		}
		if(!empty($search['customer_type'])){
			$sql.= " and c.customer_type in (".$search['customer_type'].") ";	
		}
		if(!empty($search['customer_id'])){
			$sql.= " and c.customer_id in (".$search['customer_id'].") ";	
		}
		if(!empty($search['customer_name'])){
			$sql.= " and c.customer_name like '%".$search['customer_name']."%' ";	
		}
		if(!empty($search['payments_status'])){
			$sql.= " and c.payments_status in (".$search['payments_status'].") ";	
		}
		if(!empty($search['formdate'])){
			$sql.= " and c.datecreate <= '".date('Y-m-d',strtotime($search['formdate']))."' ";	
		}
		if(!empty($search['todate'])){
			$sql.= " and c.datecreate >= '".date('Y-m-d',strtotime($search['todate']))."' ";	
		}
		return $sql;
	}
	function getList($search,$page,$rows){
		$searchs = $this->getSearch($search);
		$sql = "
				SELECT c.customer_type,c.poid,c.quantity, c.price,c.price_prepay, DES_DECRYPT(sp.customer_name,'".$this->login->skey ."') as customer_name,
				(
				select GROUP_CONCAT(DES_DECRYPT(sg.goods_name,'".$this->login->skey ."'))
				from hotel_output so
				left join hotel_goods sg on sg.id = so.goodsid
				where so.isdelete = 0
				and sg.isdelete = 0
				and so.uniqueid = c.uniqueid
				) as goods_name
				FROM hotel_output_createorders AS c
				LEFT JOIN hotel_customer sp on sp.id = c.customer_id
				WHERE c.isdelete = 0 
				AND c.isout = 1
				$searchs
				";
		if(empty($search['order'])){
			$sql.= ' ORDER BY c.id DESC ';
		}
		else{
			$sql.= ' ORDER BY '.$search['order'].' '.$search['index'].' ';
		}
		if($page != 0 && $rows != 0){
			$sql.= ' limit '.$page.','.$rows;
		}
		$query = $this->model->query($sql)->execute();
		return $query;
	}
	function getTotal($search){
		$searchs = $this->getSearch($search);
		$sql = " 
		select count(1) total
		FROM hotel_output_createorders AS c
		LEFT JOIN hotel_customer sp on sp.id = c.customer_id
		WHERE c.isdelete = 0 
		AND c.isout = 1
		$searchs
		";
		$query = $this->model->query($sql)->execute();
		return $query[0]->total;	
	}
	function findGoods($id){
		 $sql = "
			SELECT s.id, s.goods_code, s.goods_name, un.unit_name, s.sale_price
			FROM hotel_goods s
			left join hotel_unit un on un.id = s.unitid
			where s.id = '$id'
			and s.isdelete = 0
		 ";
		 return $this->model->query($sql)->execute();
	 }
	function findID($id){
		 $query = $this->model->table('hotel_input')
					  ->select('*')
					  ->where('id',$id)
					  ->find();
		return $query;
	 }
}