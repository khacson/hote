<?php
/**
 * @author 
 * @copyright 2015
 */
 class SalesreportempModel extends CI_Model{
	function __construct(){
		parent::__construct('');
		$this->login = $this->site->getSession('login');
		$this->ctr = 5;
	}
	function getSearch($searchs){
		foreach($searchs as $key=>$val){
			$search[$key] = addslashes($val);
		}
		$sql = "";
		$companyid = $this->login->companyid;
		$branchid = $this->login->branchid;
		$skey = $this->login->skey;
		
		if($this->login->grouptype == 4){
			$sql.= " and c.usercreate = '".$this->login->username ."' ";	
		}
		if(!empty($branchid)){
			$sql.= " and c.branchid in (".$branchid.") ";	
		}
		else{
			if(!empty($search['branchid'])){
				$sql.= " and c.branchid in (".$search['branchid'].") ";	
			}
		}
		if(!empty($search['employeeid'])){
			$sql.= " and c.employeeid in (".$search['employeeid'].") ";	
		}
		if(!empty($search['customer_name'])){
			$sql.= " and c.customer_name like '%".$search['customer_name']."%' ";	
		}
		if(!empty($search['soid'])){
			$sql.= " and c.soid like '%".$search['soid']."%' ";	
		}
		if(!empty($search['phone'])){
			$sql.= " and c.phone  like '%".$search['customer_name']."%' ";	
		}
		if(!empty($search['formdate'])){
			$sql.= " and c.datecreate >= '".fmDateSave($search['formdate'])." 00:00:00' ";	
		}
		if(!empty($search['todate'])){
			$sql.= " and c.datecreate <= '".fmDateSave($search['todate'])." 23:59:00' ";	
		}
		if(!empty($search['poid'])){
			$sql.= " and so.poid like '%".$search['poid']."%' ";
		}
		if(!empty($search['goods_type'])){
			$sql.= " and g.goods_type in (".$search['goods_type'].") ";	
		}
		if(!empty($search['goodsidsearch'])){
			$sql.= " and g.goods_code like '%".$search['goodsidsearch']."%' ";
		}
		if(!empty($search['goodsnamesearch'])){
			$sql.= " and g.goods_name like '%".$search['goodsnamesearch']."%' ";
		}
		return $sql;
	}
	function getList($search,$page,$rows){
		$tb = $this->base_model->loadTable();
		$searchs = $this->getSearch($search);
		$skey = $this->login->skey;
		$sql = "SELECT c.poid, c.uniqueid,c.datecreate, c.usercreate, cm.customer_name as cname,g.goods_name , g.goods_code,
		 cm.phone as phones, sum(so.discount) discount, sum(so.price) price, sum(so.quantity) quantity,
		 sum(so.cksp) as cksp, e.employee_code, e.employee_name,
		 if(g.discounthotel_type = 2, sum(g.discountsales * so.quantity), sum(so.price * g.discountsales/100)) as discountsales
				FROM `".$tb['hotel_output_createorders']."`  AS c
				LEFT JOIN `".$tb['hotel_output']."` so on so.uniqueid = c.uniqueid
				LEFT JOIN `".$tb['hotel_employeesale']."` e on e.id = c.employeeid 
				LEFT JOIN `".$tb['hotel_customer']."` cm on cm.id = c.customer_id and cm.isdelete = 0
				left join `".$tb['hotel_goods']."` g on g.id = so.goodsid 
				WHERE c.isdelete = 0 
				and so.isdelete = 0
				and g.isdelete = 0
				and e.isdelete = 0
				$searchs
				group by c.employeeid, so.goodsid
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
		//print_r($sql); exit;
		$query = $this->model->query($sql)->execute();
		return $query;
	}
	function getTotal($search){
		$tb = $this->base_model->loadTable();
		$searchs = $this->getSearch($search);
		$sql = " 
		SELECT count(1) total
		FROM(
			SELECT 1
			FROM `".$tb['hotel_output_createorders']."`  AS c
			LEFT JOIN `".$tb['hotel_output']."` so on so.uniqueid = c.uniqueid
			LEFT JOIN `".$tb['hotel_customer']."` cm on cm.id = c.customer_id and cm.isdelete = 0
			left join `".$tb['hotel_goods']."` g on g.id = so.goodsid 
			WHERE c.isdelete = 0 
			and so.isdelete = 0
			and g.isdelete = 0
			$searchs
			group by g.id
		) t
		";
		$query = $this->model->query($sql)->execute();
		return $query[0]->total;	
	}	
}