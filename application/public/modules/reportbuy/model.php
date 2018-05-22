<?php
/**
 * @author 
 * @copyright 2015
 */
 class ReportbuyModel extends CI_Model{
	function __construct(){
		parent::__construct('hotel_input');
		$this->login = $this->site->getSession('login');
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
		$sql = "
				SELECT s.goods_code, 
				DES_DECRYPT(s.goods_name,'".$this->login->skey ."') as goods_name, DES_DECRYPT(sp.supplier_name,'".$this->login->skey ."') as supplier_name, 
				sum(c.price) as price,sum(c.quantity) as quantity
				FROM hotel_input AS c
				LEFT JOIN hotel_goods s on s.id = c.goodsid and s.isdelete = 0
				LEFT JOIN hotel_supplier sp on sp.id = c.supplierid and s.isdelete = 0
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
		FROM hotel_input AS c
		LEFT JOIN hotel_goods s on s.id = c.goodsid and s.isdelete = 0
		LEFT JOIN hotel_supplier sp on sp.id = c.supplierid and s.isdelete = 0
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
	function findIDs($id){
		 $query = $this->model->table('hotel_input')
					  ->select('*')
					  ->where('id',$id)
					  ->find();
		return $query;
	 }
	function findListID($id){
		 $query = $this->model->table('hotel_input')
					  ->select('sum(price) as price, supplier_name, phone, address, description')
					  ->join('hotel_supplier','hotel_supplier.id = hotel_input.supplierid','left')
					  ->where("hotel_input.id in ($id)")
					  ->where('hotel_input.isdelete',0)
					  ->group_by('hotel_input.supplierid')
					  ->find();
		return $query;
	 }
	function findListIDDetail($id){
		 $query = $this->model->table('hotel_input')
					  ->select('warehouse_name,goods_code,goods_name,quantity,price,priceone,unit_name')
					  ->join('hotel_goods','hotel_goods.id = hotel_input.goodsid','left')
					  ->join('hotel_warehouse','hotel_warehouse.id = hotel_input.warehouseid','left')
					  ->join('hotel_unit','hotel_unit.id = hotel_goods.unitid','left')
					  ->where("hotel_input.id in ($id)")
					  ->where('hotel_input.isdelete',0)
					  ->find_all();
		return $query;
	}
}