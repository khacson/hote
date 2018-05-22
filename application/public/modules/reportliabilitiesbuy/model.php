<?php
/**
 * @author 
 * @copyright 2015
 */
 class ReportliabilitiesbuyModel extends CI_Model{
	function __construct(){
		parent::__construct('');
		$this->login = $this->site->getSession('login');
	}
	function getPO(){
		 $companyid = $this->login->companyid;
		 $query = $this->model->table($this->base_model->tb_input_createorders())
					  ->select('id,poid')
					  ->where('payments',-1)
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
			$sql.= " and i.branchid in (".$branchid.") ";	
		}
		if(!empty($search['poid'])){
			$sql.= " and i.poid in (".$search['poid'].") ";		
		}
		if(!empty($search['supplierid'])){
			$sql.= " and i.supplierid in (".$search['supplierid'].") ";	
		}
		if(!empty($search['payments'])){
			$sql.= " and i.payments in (".$search['payments'].") ";	
		}
		return $sql;
	}
	function getList($search,$page,$rows){
		$searchs = $this->getSearch($search);
		$sql = "SELECT c.*, s.goods_code, 
		DES_DECRYPT(s.goods_name,'".$this->login->skey ."') as goods_name, w.warehouse_name, 
		DES_DECRYPT(sp.supplier_name,'".$this->login->skey ."') as supplier_name, 
		ut.unit_name, i.payments_status, i.description
				FROM `".$this->base_model->tb_input()."` AS c
				LEFT JOIN `".$this->base_model->tb_input_createorders()."` i on i.uniqueid = c.uniqueid
				LEFT JOIN `".$this->base_model->tb_goods()."` s on s.id = c.goodsid and s.isdelete = 0
				LEFT JOIN `".$this->base_model->tb_warehouse()."` w on w.id = c.warehouseid and w.isdelete = 0
				LEFT JOIN `".$this->base_model->tb_supplier()."` sp on sp.id = c.supplierid and s.isdelete = 0
				LEFT JOIN `".$this->base_model->tb_unit()."` ut on ut.id = s.unitid and ut.isdelete = 0 
				WHERE c.isdelete = 0 
				AND i.payments_status = -1
				$searchs
				";
		if(empty($search['order'])){
			$sql.= ' ORDER BY c.id DESC ';
		}
		else{
			$sql.= ' ORDER BY '.$search['order'].' '.$search['index'].' ';
		}
		if($page !=0 && $rows !=0){
			$sql.= ' limit '.$page.','.$rows;
		}
		$query = $this->model->query($sql)->execute();
		return $query;
	}
	function getTotal($search){
		$searchs = $this->getSearch($search);
		$sql = " 
		SELECT count(1) total
		FROM `".$this->base_model->tb_input()."` AS c
		LEFT JOIN `".$this->base_model->tb_input_createorders()."`  i on i.uniqueid = c.uniqueid
		LEFT JOIN `".$this->base_model->tb_goods()."` s on s.id = c.goodsid and s.isdelete = 0
		LEFT JOIN `".$this->base_model->tb_warehouse()."` w on w.id = c.warehouseid and w.isdelete = 0
		LEFT JOIN `".$this->base_model->tb_supplier()."` sp on sp.id = c.supplierid and s.isdelete = 0
		LEFT JOIN `".$this->base_model->tb_unit()."` ut on ut.id = s.unitid and ut.isdelete = 0 
		WHERE c.isdelete = 0 
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
		unset($array['price']);
		
		$array['quantity'] = str_replace(",","",$array['quantity']);
		$array['priceone'] = str_replace(",","",$array['priceone']);
		$array['price'] = $array['priceone'] * $array['quantity'];
		
		$result = $this->model->table($this->base_model->tb_input())->insert($array);	
		return $result;
	}
	function edits($array,$id){
		 $companyid = $this->login->companyid;
		 $branchid = $this->login->branchid;
		 //$array['companyid'] = $companyid;
		 //$array['branchid'] = $branchid;
		 //unset($array['price']);
		 //$array['quantity'] = str_replace(",","",$array['quantity']);
		 //$array['priceone'] = str_replace(",","",$array['priceone']);
		 //$array['price'] = $array['priceone'] * $array['quantity'];
		 $arr_Update = array();
		 $arr_Update['maturitydate'] = date('Y-m-d',strtotime($array['maturitydate']));
		 $result = $this->model->table($this->base_model->tb_input())->where('id',$id)->update($array);	
		 return $id;
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
	 function deletes($id, $array){
		$result = $this->model->table($this->base_model->tb_input())
					   ->where("id in ($id)")
					   ->update($array);	
		return 1;
	}
}