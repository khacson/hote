<?php
/**
 * @author 
 * @copyright 2015
 */
 class HistorysellModel extends CI_Model{
	function __construct(){
		parent::__construct('hotel_output');
		$this->login = $this->site->getSession('login');
	}
	function getSearch($search){
		$sql = "";
		$companyid = $this->login->companyid;
		$branchid = $this->login->branchid;
		$sql.= " and i.companyid = '".$companyid."' ";	
		if(!empty($branchid)){
			$sql.= " and i.branchid in (".$branchid.") ";	
		}
		if(!empty($search['customer_name'])){
			$sql.= " and DES_DECRYPT(i.customer_name like,'".$this->login->skey ."') '%".$search['customer_name']."%' ";	
		}
		if(!empty($search['phone'])){
			$sql.= " and DES_DECRYPT(i.phone,'".$this->login->skey ."')  like '%".$search['customer_name']."%' ";	
		}
		if(!empty($search['employeeid'])){
			$sql.= " and i.employeeid in (".$search['employeeid'].") ";	
		}
		if(!empty($search['payments'])){
			$sql.= " and i.payments in (".$search['payments'].") ";	
		}
		if(!empty($search['idss'])){
			$sql.= " and i.poid in (".$search['idss'].") ";	
		}
		if(!empty($search['formdate'])){
			$sql.= " and i.datecreate <= '".date('Y-m-d',strtotime($search['formdate']))."' ";	
		}
		if(!empty($search['todate'])){
			$sql.= " and i.datecreate >= '".date('Y-m-d',strtotime($search['todate']))."' ";	
		}
		return $sql;
	}
	function getList($search,$page,$rows){
		$searchs = $this->getSearch($search);
		$sql = "SELECT c.*, s.goods_code, 
		DES_DECRYPT(s.goods_name,'".$this->login->skey ."') as goods_name, 
		DES_DECRYPT(e.employee_name,'".$this->login->skey ."')as employee_name, 
		w.warehouse_name, ut.unit_name, e.employee_code ,
		i.payments, i.customer_type, i.customer_name, i.customer_phone, i.description
				FROM hotel_output AS c
				LEFT JOIN hotel_output_createorders i on i.uniqueid = c.uniqueid
				LEFT JOIN hotel_goods s on s.id = c.goodsid and s.isdelete = 0
				LEFT JOIN hotel_warehouse w on w.id = c.warehouseid and w.isdelete = 0
				left join hotel_unit ut on ut.id = s.unitid
				LEFT JOIN hotel_employeesale e on e.id = i.employeeid and e.isdelete = 0 
				WHERE c.isdelete = 0 
				AND i.isout = 1
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
		SELECT count(1) total
		FROM hotel_output AS c
		LEFT JOIN hotel_output_createorders i on i.uniqueid = c.uniqueid
		LEFT JOIN hotel_goods s on s.id = c.goodsid and s.isdelete = 0
		LEFT JOIN hotel_warehouse w on w.id = c.warehouseid and w.isdelete = 0
		LEFT JOIN hotel_employeesale e on e.id = i.employeeid and e.isdelete = 0 
		left join hotel_unit ut on ut.id = s.unitid
		WHERE c.isdelete = 0 
		AND i.isout = 1
		$searchs	
		";
		$query = $this->model->query($sql)->execute();
		return $query[0]->total;	
	}
	function saves($array,$idselect,$priceone_obj,$quantity_obj){
		$companyid = $this->login->companyid;
		$branchid = $this->login->branchid;
		$array['companyid'] = $companyid;
		$array['branchid'] = $branchid;
		unset($array['price']);
		unset($array['unitid']);
		unset($array['customer_id']);
		
		if(empty($idselect) && empty($array['idss'])){
			 $array['isorder'] = 1;
			 $array['isout'] = 1;
			 unset($array['idss']);
			 $array['quantity'] = str_replace(",","",$array['quantity']);
			 $array['priceone'] = str_replace(",","",$array['priceone']);
			 $array['price'] = $array['priceone'] * $array['quantity'];
			 $result = $this->model->table('hotel_output')->insert($array);	
		}
		else{
			 unset($array['idss']);
			 $check = $this->model->table('hotel_output')
					  ->select('id,isout')
					  ->where('isdelete',0)
					  ->where('id',$idselect)
					  ->where('isout',1)
					  ->find();
			 if(!empty($check->id)){
				return -1;	
			 }
			 $array['isout'] = 1;
			  $array['isorder'] = 0;
			 foreach($quantity_obj as $idup => $val){
				 $array['quantity'] = str_replace(",","",$val);
				 $array['priceone'] = str_replace(",","",$priceone_obj[$idup]);
				 $array['price'] = $array['priceone'] * $array['quantity'];
				 $result = $this->model->table('hotel_output')
							->where('id',$idup)
							->where('isdelete',0)
							->update($array);
			 }
		}
		return $result;
	}
	function edits($array,$id,$priceone_obj,$quantity_obj){
		 $companyid = $this->login->companyid;
		 $branchid = $this->login->branchid;
		 $array['companyid'] = $companyid;
		 $array['branchid'] = $branchid;
		 unset($array['idss']);
		 unset($array['price']);
		 unset($array['unitid']);
		 unset($array['customer_id']);
		 $array['quantity'] = str_replace(",","",$array['quantity']);
		 $array['priceone'] = str_replace(",","",$array['priceone']);
		 $array['isout'] = 1;
		 $array['price'] = $array['priceone'] * $array['quantity'];
		 $result = $this->model->table('hotel_output')->where('id',$id)->update($array);	
		 return $id;
	 }
	function findID($id){
		 $query = $this->model->table('hotel_output')
					  ->select('*')
					  ->where('id',$id)
					  ->find();
		return $query;
	}
	function findListID($id){
		 $query = $this->model->table('hotel_output')
					  ->select('sum(price) as price, customer_name, customer_phone, customer_address, description')
					  ->where("id in ($id)")
					  ->where('isdelete',0)
					  ->group_by('uniqueid')
					  ->find();
		return $query;
	 }
	function findListIDDetail($id){
		 $query = $this->model->table('hotel_output')
					  ->select('warehouse_name,goods_code,goods_name,poid,quantity,price,priceone,unit_name')
					  ->join('hotel_goods','hotel_goods.id = hotel_output.goodsid','left')
					  ->join('hotel_warehouse','hotel_warehouse.id = hotel_output.warehouseid','left')
					  ->join('hotel_unit','hotel_unit.id = hotel_goods.unitid','left')
					  ->where("hotel_output.id in ($id)")
					  ->where('hotel_output.isdelete',0)
					  ->find_all();
		return $query;
	}
	function findUniqueid($uniqueid){
		 $sql = "
			SELECT s.id, s.uniqueid, s.goodsid, s.quantity, g.sale_price, (s.quantity * g.sale_price) as price, g.goods_code, g.goods_name,  un.unit_name
			FROM hotel_output s
			left join hotel_goods g on g.id = s.goodsid and g.isdelete = 0
			left join hotel_unit un on un.id = g.unitid
			where s.uniqueid = '$uniqueid'
			and s.isdelete = 0
		 ";
		 return $this->model->query($sql)->execute();
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
	function findOrder($id){
		 $query = $this->model->table('hotel_output_createorders')
					  ->select('*')
					  ->where('id',$id)
					  ->where('isout',0)
					  ->find();
		return $query;
	 }
	function deletes($id, $array){
		$result = $this->model->table('hotel_output')
					   ->where("id in ($id)")
					   ->update($array);	
		$query = $this->model->table('hotel_output')
					   ->select('uniqueid')
					   ->where("id in ($id)")
					   ->group_by('uniqueid')
					   ->find_all();
		foreach($query as $item){
			$uniqueid = $item->uniqueid;
			$this->model->table('hotel_output_createorders')
					   ->where("uniqueid in ($uniqueid)")
					   ->update($array);	
		}
		return 1;
	}
}