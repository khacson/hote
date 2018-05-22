<?php
/**
 * @author 
 * @copyright 2015
 */
 class SalesprofitsupModel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->login = $this->site->getSession('login');
	}
	function getDT($search){
		$sql = "";
		$companyid = $this->login->companyid;
		$branchid = $this->login->branchid;
		$sql.= " and o.companyid = '".$companyid."' ";	
		if(!empty($branchid)){
			$sql.= " and o.branchid in (".$branchid.") ";	
		}
		if(!empty($search['datetime'])){
			$arrDate = explode('-',$search['datetime']);
			$fdates = trim($arrDate[0]);
			$fdate = explode('/',$fdates);
			$fromdate = $fdate[2].'-'. $fdate[1].'-'.$fdate[0].' 00:00:00';
			
			$ftos = trim($arrDate[1]);
			$fto = explode('/',$ftos);
			$todate = $fto[2].'-'. $fto[1].'-'.$fto[0].' 23:59:59';
			
			$sql.= " and o.datecreate >= '".$fromdate."' ";	
			$sql.= " and o.datecreate <= '".$todate."' ";	
		}
		if(!empty($search['goodsid'])){
			$sql.= " and o.goodsid in (".$search['goodsid'].") ";	
		}
		if(!empty($search['customerid'])){
			$sql.= " and oc.customerid in (".$search['customerid'].") ";	
		}
		if(!empty($search['branchid'])){
			$sql.= " and oc.branchid in (".$search['branchid'].") ";	
		}
		if(!empty($search['employeeid'])){
			$sql.= " and oc.employeeid in (".$search['employeeid'].") ";	
		}
		$sqlQuery = "
			SELECT sum(o.price) price 
			FROM `".$this->base_model->tb_output()."` o
			LEFT JOIN `".$this->base_model->tb_output_createorders()."` oc on oc.uniqueid = o.uniqueid
			WHERE o.isdelete = 0
			AND oc.isdelete = 0 
			$sql
			;
		";
		$query = $this->model->query($sqlQuery)->execute();
		$arr = array();
		$arr['dt'] = $query;
		//Loi nhuan ban hang
		$sqlQuery2 = "
			SELECT sum(o.price- (o.quantity * o.pricein)) as price
			FROM `".$this->base_model->tb_output()."` o
			LEFT JOIN `".$this->base_model->tb_output_createorders()."` oc on oc.uniqueid = o.uniqueid
			WHERE o.isdelete = 0
			AND oc.isdelete = 0 
			$sql
			;
		";
		$query2 = $this->model->query($sqlQuery2)->execute();
		$arr['ln'] = $query2;
		$sqlHH = "
			SELECT sum(if(g.discounthotel_type = 1, (o.price * g.discountsales/100), g.discountsales)) discountsales
			FROM `".$this->base_model->tb_output()."` o
			LEFT JOIN `".$this->base_model->tb_output_createorders()."` oc on oc.uniqueid = o.uniqueid
			LEFT join `".$this->base_model->tb_goods()."` g on g.id = o.goodsid
			WHERE o.isdelete = 0
			AND oc.isdelete = 0 
			$sql
			;
		";
		$query3 = $this->model->query($sqlHH)->execute();
		$arr['hh'] = $query3;
		return $arr;
	}
	function getSearch($search){
		$sql = "";
		$companyid = $this->login->companyid;
		$branchid = $this->login->branchid;
		$sql.= " and c.companyid = '".$companyid."' ";	
		if(!empty($branchid)){
			$sql.= " and c.branchid in (".$branchid.") ";	
		}
		if(!empty($search['supplierid'])){
			$sql.= " and c.supplierid in (".$search['supplierid'].") ";	
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
		$companyid = $this->login->companyid;
		$sql = "
				SELECT s.goods_code, 
				DES_DECRYPT(s.goods_name,'".$this->login->skey ."') as goods_name, DES_DECRYPT(sp.supplier_name,'".$this->login->skey ."') as supplier_name, sum(c.price) as price,sum(c.quantity) as quantity,
				(
				select sum(o.quantity)
				from `".$this->base_model->tb_output()."` o
				where c.goodsid = o.goodsid
				and o.isdelete = 0
				and o.companyid = '$companyid'
				group by o.goodsid
				) o_quantity,
				(
				select sum(o.price)
				from `".$this->base_model->tb_output()."` o
				where c.goodsid = o.goodsid
				and o.isdelete = 0
				and o.companyid = '$companyid'
				group by o.goodsid
				) o_price
				FROM `".$this->base_model->tb_input()."` AS c
				LEFT JOIN `".$this->base_model->tb_goods()."` s on s.id = c.goodsid and s.isdelete = 0
				LEFT JOIN `".$this->base_model->tb_supplier()."` sp on sp.id = c.supplierid and s.isdelete = 0
				WHERE c.isdelete = 0 
				$searchs
				group by s.goods_code, sp.id
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
		from(
		SELECT s.goods_code
		FROM `".$this->base_model->tb_input()."`  AS c
		LEFT JOIN `".$this->base_model->tb_goods()."` s on s.id = c.goodsid and s.isdelete = 0
		LEFT JOIN `".$this->base_model->tb_supplier()."` sp on sp.id = c.supplierid and s.isdelete = 0
		WHERE c.isdelete = 0 
		$searchs
		group by s.goods_code, sp.id
		) tt
		";
		$query = $this->model->query($sql)->execute();
		return $query[0]->total;	
	}
	function findGoods($id){
		 $sql = "
			SELECT s.id, s.goods_code, s.goods_name, un.unit_name, s.sale_price
			FROM `".$this->base_model->tb_goods()."` s
			left join `".$this->base_model->tb_unit()."` un on un.id = s.unitid
			where s.id = '$id'
			and s.isdelete = 0
		 ";
		 return $this->model->query($sql)->execute();
	 }
	function findID($id){
		 $query = $this->model->table($this->base_model->tb_input())
					  ->select('*')
					  ->where('id',$id)
					  ->find();
		return $query;
	 }
	function findIDs($id){
		 $query = $this->model->table($this->base_model->tb_input())
					  ->select('*')
					  ->where('id',$id)
					  ->find();
		return $query;
	 }
	function findListID($id){
		 $input = $this->base_model->tb_input();
		 $supplier = $this->base_model->tb_supplier();
		 $query = $this->model->table($input)
					  ->select('sum(price) as price, supplier_name, phone, address, description')
					  ->join($supplier,"$supplier.id = $input.supplierid",'left')
					  ->where("$input.id in ($id)")
					  ->where("$input.isdelete",0)
					  ->group_by("$input.supplierid")
					  ->find();
		return $query;
	 }
	function findListIDDetail($id){
		 $input = $this->base_model->tb_input();
		 $supplier = $this->base_model->tb_supplier();
		 $warehouse = $this->base_model->tb_warehouse();
		 $unit = $this->base_model->tb_unit();
		 $goods = $this->base_model->tb_goods();
		 
		 $query = $this->model->table($input)
					  ->select('warehouse_name,goods_code,goods_name,quantity,price,priceone,unit_name')
					  ->join($goods,"$goods.id = $input.goodsid",'left')
					  ->join($warehouse,"hotel_warehouse.id = $input.warehouseid",'left')
					  ->join($unit,"$unit.id = $goods.unitid",'left')
					  ->where("$input.id in ($id)")
					  ->where("$input.isdelete",0)
					  ->find_all();
		return $query;
	}
}