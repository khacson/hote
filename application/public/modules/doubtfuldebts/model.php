<?php
/**
 * @author 
 * @copyright 2015
 */
 class DoubtfuldebtsModel extends CI_Model{
	function __construct(){
		parent::__construct('hotel_output');
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
		if(!empty($search['customer_name'])){
			$sql.= " and DES_DECRYPT(c.customer_name,'".$this->login->skey ."') like '%".$search['customer_name']."%' ";	
		}
		if(!empty($search['phone'])){
			$sql.= " and DES_DECRYPT(c.phone,'".$this->login->skey ."') like '%".$search['customer_name']."%' ";	
		}
		if(!empty($search['fax'])){
			$sql.= " and DES_DECRYPT(c.fax,'".$this->login->skey ."') like '%".$search['fax']."%' ";	
		}
		if(!empty($search['email'])){
			$sql.= " and DES_DECRYPT(c.email,'".$this->login->skey ."') like '%".$search['email']."%' ";	
		}
		if(!empty($search['employeeid'])){
			$sql.= " and c.employeeid in (".$search['employeeid'].") ";	
		}
		if(!empty($search['payments'])){
			$sql.= " and c.payments in (".$search['payments'].") ";	
		}
		if(!empty($search['payments_status'])){
			$sql.= " and c.payments_status in (".$search['payments_status'].") ";	
		}
		return $sql;
	}
	function getList($search,$page,$rows){
		$searchs = $this->getSearch($search);
		$sql = "SELECT c.*, s.goods_code,i.customer_type, i.customer_phone, 
		DES_DECRYPT(s.goods_name,'".$this->login->skey ."') as goods_name, 
		w.warehouse_name, 
		DES_DECRYPT(cm.customer_name,'".$this->login->skey ."') customer_name, 
		ut.unit_name, e.employee_code ,
		DES_DECRYPT(e.employee_name,'".$this->login->skey ."') as employee_name,
		s.unitid, i.payments, i.payments_status, i.customer_type, i.description
				FROM hotel_output AS c
				LEFT JOIN hotel_output_createorders i on i.uniqueid = c.uniqueid
				LEFT JOIN hotel_goods s on s.id = c.goodsid and s.isdelete = 0
				LEFT JOIN hotel_warehouse w on w.id = c.warehouseid and w.isdelete = 0
				LEFT JOIN hotel_customer cm on cm.id = i.customer_id and cm.isdelete = 0
				LEFT JOIN hotel_unit ut on ut.id = s.unitid and ut.isdelete = 0 
				LEFT JOIN hotel_employeesale e on e.id = i.employeeid and e.isdelete = 0 
				WHERE c.isdelete = 0 
				AND i.isout = 1
				AND i.payments_status = -1
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
		LEFT JOIN hotel_customer cm on cm.id = i.customer_id and cm.isdelete = 0
		LEFT JOIN hotel_unit ut on ut.id = s.unitid and ut.isdelete = 0 
		LEFT JOIN hotel_employeesale e on e.id = i.employeeid and e.isdelete = 0 
		WHERE c.isdelete = 0 
		AND i.isout = 1
		AND i.payments_status = -1
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
		
		$array['price'] = $array['priceone'] * $array['quantity'];
		$array['quantity'] = str_replace(",","",$array['quantity']);
		$array['priceone'] = str_replace(",","",$array['priceone']);
		
		if(empty($idselect) && empty($array['idss'])){
			$array['isorder'] = 1;
			 $array['isout'] = 1;
			 unset($array['idss']);
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
			 $result = $this->model->table('hotel_output')
							->where('id',$idselect)
							->update($array);
		}
		return $result;
	}
	function edits($array,$id){
		 $companyid = $this->login->companyid;
		 $branchid = $this->login->branchid;
		 //$array['companyid'] = $companyid;
		 //$array['branchid'] = $branchid;
		 //unset($array['idss']);
		 //$array['quantity'] = str_replace(",","",$array['quantity']);
		 //$array['priceone'] = str_replace(",","",$array['priceone']);
		 // $array['isout'] = 1;
		 //$array['price'] = $array['priceone'] * $array['quantity'];
		 $arr_Update = array();
		 $arr_Update['maturitydate'] = date('Y-m-d',strtotime($array['maturitydate']));
		 $result = $this->model->table('hotel_output')->where('id',$id)->update($arr_Update);	
		 return $id;
	 }
	 function findID($id){
		 $query = $this->model->table('hotel_output')
					  ->select('*')
					  ->where('id',$id)
					  ->find();
		return $query;
	 }
	 function findIDs($id){
		 $query = $this->model->table('hotel_output')
					  ->select('*')
					  ->where('id',$id)
					  ->where('isout',0)
					  ->find();
		return $query;
	 }
	 public function getSalesOutput($companyid,$branchid,$id) {
		    $query = $this->model
						  ->select('hotel_output_createorders.id,hotel_output.poid,hotel_output.uniqueid')
						  ->table('hotel_output_createorders')
						  ->join('hotel_output','hotel_output.poid = hotel_output_createorders.poid','left')
						  ->where('hotel_output_createorders.isdelete',0)
						  ->where('hotel_output_createorders.isout',0)
						  ->group_by('hotel_output.poid')
						  ;	
		    if(!empty($id)){
			   $query = $query->where('id',$id);
		    }
			if(!empty($companyid)){
			   $query = $query->where('hotel_output.companyid',$companyid);
		    }	
			if(!empty($branchid)){
			   $query = $query->where('hotel_output.branchid',$branchid);
		    }	
			$query = $query->order_by('hotel_output.id','DESC');
		    $query = $query->find_all();
			return $query;
		}
}