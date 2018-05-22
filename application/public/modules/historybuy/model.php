<?php
/**
 * @author 
 * @copyright 2015
 */
 class HistorybuyModel extends CI_Model{
	function __construct(){
		parent::__construct('hotel_input');
		$this->login = $this->site->getSession('login');
	}
	function getPO(){
		 $companyid = $this->login->companyid;
		 $query = $this->model->table('hotel_input_createorders')
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
		if(!empty($search['poid'])){
			$sql.= " and c.poid in (".$search['poid'].") ";	
		}
		if(!empty($search['supplierid'])){
			$sql.= " and c.supplierid in (".$search['supplierid'].") ";	
		}
		if(!empty($search['payments'])){
			$sql.= " and c.payments in (".$search['payments'].") ";	
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
		$sql = "SELECT c.*, s.goods_code,
		DES_DECRYPT(s.goods_name,'".$this->login->skey ."') as goods_name, w.warehouse_name, 
		DES_DECRYPT(sp.supplier_name,'".$this->login->skey ."') supplier_name, 
		ut.unit_name, ic.payments, ic.description
				FROM hotel_input AS c
				LEFT JOIN hotel_input_createorders ic on ic.uniqueid = c.uniqueid
				LEFT JOIN hotel_goods s on s.id = c.goodsid and s.isdelete = 0
				LEFT JOIN hotel_warehouse w on w.id = c.warehouseid and w.isdelete = 0
				LEFT JOIN hotel_supplier sp on sp.id = c.supplierid and s.isdelete = 0
				LEFT JOIN hotel_unit ut on ut.id = s.unitid and s.isdelete = 0 
				WHERE c.isdelete = 0 
				$searchs
				";
		if(empty($search['order'])){
			$sql.= ' ORDER BY c.id DESC ';
		}
		else{
			$sql.= ' ORDER BY '.$search['order'].' '.$search['index'].' ';
		}
		if($rows != 0){
			$sql.= ' limit '.$page.','.$rows;
		}
		$query = $this->model->query($sql)->execute();
		return $query;
	}
	function getTotal($search){
		$searchs = $this->getSearch($search);
		$sql = " 
		SELECT count(1) total
		FROM hotel_input AS c
		LEFT JOIN hotel_goods s on s.id = c.goodsid and s.isdelete = 0
		LEFT JOIN hotel_warehouse w on w.id = c.warehouseid and w.isdelete = 0
		LEFT JOIN hotel_supplier sp on sp.id = c.supplierid and s.isdelete = 0
		LEFT JOIN hotel_unit ut on ut.id = s.unitid and s.isdelete = 0 
		WHERE c.isdelete = 0 
		$searchs	
		";
		$query = $this->model->query($sql)->execute();
		return $query[0]->total;	
	}
	function saves($array,$idselect){
		$companyid = $this->login->companyid;
		$branchid = $this->login->branchid;
		$array['companyid'] = $companyid;
		$array['branchid'] = $branchid;
		unset($array['price']);
		unset($array['formdate']);
		unset($array['todate']);
		$array['quantity'] = str_replace(",","",$array['quantity']);
		$array['priceone'] = str_replace(",","",$array['priceone']);
		$array['price'] = $array['priceone'] * $array['quantity'];
		//Them vao bang ton kho hotel_inventory
		$check = $this->model->table('hotel_inventory')
							 ->select('id,quantity')
							 ->where('companyid',$companyid)
							 ->where('branchid',$branchid)
							 ->where('warehouseid',$array['warehouseid'])
							 ->where('goodsid',$array['goodsid'])
							 ->find();
		if(empty($check->id)){ //Thêm vào kho
			$arr_inventory = array();
			$arr_inventory['goodsid'] = $array['goodsid'];
			$arr_inventory['warehouseid'] = $array['warehouseid'];
			$arr_inventory['companyid'] = $companyid;
			$arr_inventory['branchid'] = $branchid;
			$arr_inventory['quantity'] = $array['quantity'];
			$this->model->table('hotel_inventory')->insert($arr_inventory);
		}
		else{ //Con don so luong
			$sqlUpdate = "
				UPDATE `hotel_inventory` SET `quantity`= `quantity` + ".$array['quantity']." WHERE `id`='".$check->id ."';
			";
			$this->model->executeQuery($sqlUpdate);
		}
		$array['ipcreate'] = $this->base_model->getMacAddress();
		$result = $this->model->table('hotel_input')->insert($array);	
		return $result;
	}
	function edits($array,$id){
		 $companyid = $this->login->companyid;
		 $branchid = $this->login->branchid;
		 $array['companyid'] = $companyid;
		 $array['branchid'] = $branchid;
		 unset($array['price']);
		 unset($array['formdate']);
		 unset($array['todate']);
		 $array['quantity'] = str_replace(",","",$array['quantity']);
		 $array['priceone'] = str_replace(",","",$array['priceone']);
		 $array['price'] = $array['priceone'] * $array['quantity'];
		 
		 $check = $this->model->table('hotel_inventory')
							 ->select('id,quantity')
							 ->where('companyid',$companyid)
							 ->where('branchid',$branchid)
							 ->where('warehouseid',$array['warehouseid'])
							 ->where('goodsid',$array['goodsid'])
							 ->find();
		if(empty($check->id)){ //Thêm vào kho
			$arr_inventory = array();
			$arr_inventory['goodsid'] = $array['goodsid'];
			$arr_inventory['warehouseid'] = $array['warehouseid'];
			$arr_inventory['companyid'] = $companyid;
			$arr_inventory['branchid'] = $branchid;
			$arr_inventory['quantity'] = $array['quantity'];
			$this->model->table('hotel_inventory')->insert($arr_inventory);
		}
		else{ //Con don so luong
			//kiem tra so luong ban dau
			$find = $this->findID($id);
			$quantity = $find->quantity;
			$newQuantity = $array['quantity'] - $quantity;
			
			$sqlUpdate = "
				UPDATE `hotel_inventory` SET `quantity`= `quantity` + ".$newQuantity." WHERE `id`='".$check->id ."';
			";
			$this->model->executeQuery($sqlUpdate);
		}
		
		 $array['ipupdate'] = $this->base_model->getMacAddress();
		 $result = $this->model->table('hotel_input')->where('id',$id)->update($array);	
		 return $id;
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
	function deletes($id, $array){
		$result = $this->model->table('hotel_input')
					   ->where("id in ($id)")
					   ->update($array);	
		return 1;
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