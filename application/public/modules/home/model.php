<?php
/**
 * @author Son Nguyen
 * @copyright 2015
 */
 class HomeModel extends CI_Model{
	function __construct(){
		//$this->load->database();
		parent::__construct();
		$this->login = $this->site->getSession('login');
	}
	function findID($id) {
        $query = $this->model->table('hr_groups')
					  ->where('isdelete',0)
					  ->where('id',$id)
					  ->find();
        return $query;
    }
	function getCustomer(){
		//$login = $this->login;
		$tb = $this->base_model->loadTable();
		$query = $this->model->table($tb['hotel_customer'])
					  ->select('count(1) total')
					  ->where('isdelete',0)
					  ->find();
		return $query;
	}
	function getSupplier(){
		//$login = $this->login;
		$tb = $this->base_model->loadTable();
		$query = $this->model->table($tb['hotel_supplier'])
					  ->select('count(1) total')
					  ->where('isdelete',0)
					  ->find();
		return $query;
	}
	function getGoods(){
		$tb = $this->base_model->loadTable();
		$query = $this->model->table($tb['hotel_goods'])
					  ->select('count(1) total')
					  ->where('isdelete',0)
					  ->find();
		return $query;
	}
	function getWarehouse(){
		$tb = $this->base_model->loadTable();
		$query = $this->model->table($tb['hotel_warehouse'])
					  ->select('count(1) total')
					  ->where('isdelete',0)
					  ->find();
		return $query;
	}
	function getOrders($fromdate, $todate){
		$branchid = $this->login->branchid;
		$tb = $this->base_model->loadTable();
		$and = "";
		if(!empty($branchid)){
			$and.= " and c.branchid = '$branchid'";
		}
		$sql = "
			SELECT date_Format(c.datecreate,'%Y-%m-%d') As datecreate,  sum(so.quantity * so.priceone) price
			FROM `".$tb['hotel_output_detail']."` so
			LEFT JOIN `".$tb['hotel_output']."`  c on c.id = so.orderid
			where so.isdelete = 0
			and c.isdelete = 0
			and c.datecreate >= '$fromdate 00:00:00'
			and c.datecreate <= '$todate 23:59:59'
			$and
			group by date_Format(c.datecreate,'%Y-%m-%d')
			;
		";
		return $this->model->query($sql)->execute();
	}
	function getCountOder($fromdate, $todate){
		$branchid = $this->login->branchid;
		$tb = $this->base_model->loadTable();
		$and = "";
		if(!empty($branchid)){
			$and.= " and so.branchid = '$branchid'";
		}
		$sql = "
			SELECT count(1) total
			FROM `".$tb['hotel_orders']."` so
			where so.isdelete = 0
			and so.datecreate >= '$fromdate 00:00:00'
			and so.datecreate <= '$todate 23:59:59'
			$and
			;
		";
		$query = $this->model->query($sql)->execute();
		$total = 0;
		if(!empty($query[0]->total)){
			$total = $query[0]->total;
		}
		return $total;
	}
	function doanhThuTrongNgay($fromdate,$todate){
		$branchid = $this->login->branchid;
		$tb = $this->base_model->loadTable();
		$and = "";
		if(!empty($branchid)){
			$and.= " and c.branchid = '$branchid'";
		}
		$sql = "
			SELECT sum(so.priceone * so.quantity) price
			FROM `".$tb['hotel_output_detail']."` so
			LEFT JOIN `".$tb['hotel_output']."`  c on c.id = so.orderid
			where so.isdelete = 0
			and c.isdelete = 0
			and c.datecreate >= '$fromdate 00:00:00'
			and c.datecreate <= '$todate 23:59:59'
			$and
			;
		";
		$query = $this->model->query($sql)->execute(); 
		if(empty($query[0]->price)){
			return 0;
		}
		else{
			return $query[0]->price;
		}
		
	}
	function getOrdersList($fromdate,$todate,$branchid){
		$branchid = $this->login->branchid;
		$tb = $this->base_model->loadTable();
		$and = "";
		if(!empty($branchid)){
			$and.= " and s.branchid = '$branchid'";
		}
		if(!empty($fromdate)){
			$and.= " and s.datecreate >= '$fromdate 00:00:00'";
		}
		if(!empty($todate)){
			$and.= " and s.datecreate <= '$todate 23:59:59'";
		}
		$sql = "
			SELECT DATE_FORMAT(s.datecreate,'%Y-%m-%d') as datecreate, count(1) total 
			FROM `".$tb['hotel_output']."` s
			LEFT JOIN `".$tb['hotel_output_detail']."` so on so.orderid = s.id
			where s.isdelete = 0
			and so.isdelete = 0
			$and
			group by DATE_FORMAT(s.datecreate,'%Y-%m-%d');
		";
		$query = $this->model->query($sql)->execute();
		return $query;
	}
	/*function getOrdersListPrice($fromdate,$todate,$branchid){
		$branchid = $this->login->branchid;
		$tb = $this->base_model->loadTable();
		$and = "";
		if(!empty($branchid)){
			$and.= " and s.branchid = '$branchid'";
		}
		if(!empty($fromdate)){
			$and.= " and s.datecreate >= '$fromdate 00:00:00'";
		}
		if(!empty($todate)){
			$and.= " and s.datecreate <= '$todate 23:59:59'";
		}
		$sql = "
			SELECT DATE_FORMAT(s.datecreate,'%Y-%m-%d') as datecreate, sum(so.price) total 
			FROM `".$tb['hotel_output']."` s
			LEFT JOIN `".$tb['hotel_output_detail']."` so on so.orderid = s.id
			where s.isdelete = 0
			and so.isdelete = 0
			$and
			group by DATE_FORMAT(s.datecreate,'%Y-%m-%d');
		";
		$query = $this->model->query($sql)->execute();
		return $query;
	}*/
	function getOrdersListOutgoods($fromdate,$todate,$branchid){
		$branchid = $this->login->branchid;
		$tb = $this->base_model->loadTable();
		$and = "";
		if(!empty($branchid)){
			$and.= " and c.branchid = '$branchid'";
		}
		$sql = "
			select *
			from(
			SELECT so.goodsid, g.goods_name,  sum(so.quantity) total
			FROM `".$tb['hotel_output_detail']."` so
			LEFT JOIN `".$tb['hotel_output']."` c on c.id = so.orderid
			LEFT JOIN `".$tb['hotel_goods']."` g on g.id = so.goodsid 
			where so.isdelete = 0
			and c.isdelete = 0
			and c.datecreate >= '$fromdate 00:00:00'
			and c.datecreate <= '$todate 23:59:59'
			and g.isdelete = 0
			group by so.goodsid
			) t
			order by t.total desc
			limit 10
			
		"; 
		$query = $this->model->query($sql)->execute();
		return $query;
	}
	function getByCatalog($fromdate,$todate,$branchid){
		$branchid = $this->login->branchid;
		$tb = $this->base_model->loadTable();
		$and = "";
		if(!empty($branchid)){
			$and.= " and c.branchid = '$branchid'";
		}
		$sql = "
			SELECT gt.id as goodsid, gt.goods_tye_name as goods_name,  sum(so.quantity) total
			FROM `".$tb['hotel_output_detail']."` so
			LEFT JOIN `".$tb['hotel_output']."` c on c.id = so.orderid
			LEFT JOIN `".$tb['hotel_goods']."` g on g.id = so.goodsid 
			LEFT JOIN `".$tb['hotel_goods_type']."` gt on gt.id = g.goods_type 
			where so.isdelete = 0
			and c.isdelete = 0
			and c.datecreate >= '$fromdate 00:00:00'
			and c.datecreate <= '$todate 23:59:59'
			and g.isdelete = 0
			and gt.isdelete = 0
			group by gt.id
			;
		"; 
		$query = $this->model->query($sql)->execute();
		return $query;
	}
 }