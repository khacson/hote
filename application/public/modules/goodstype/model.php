<?php
/**
 * @author 
 * @copyright 2015
 */
 class GoodstypeModel extends CI_Model{
	function __construct(){
		parent::__construct('');
		$this->login = $this->site->getSession('login');
	}
	function findID($id){
		$tb = $this->base_model->loadTable(); 
		$query = $this->model->table($tb['hotel_goods_type'])
					  ->select('*')
					  ->where('id',$id)
					  ->find();
		return $query;
	 }
	function getSearch($search){
		$sql = "";
		$companyid = $this->login->companyid;
		if(!empty($search['goods_tye_name'])){
			$sql.= " and c.goods_tye_name  like '%".addslashes($search['goods_tye_name'])."%' ";	
		}
		if(!empty($search['goods_type_group'])){
			$sql.= " and c.goods_type_group  in (".($search['goods_type_group']).") ";	
		}
		return $sql;
	}
	function getList($search,$page,$rows){
		$tb = $this->base_model->loadTable();
		$searchs = $this->getSearch($search);
		$sql = "SELECT c.id, c.goods_tye_name, c.goods_type_group
				FROM `".$tb['hotel_goods_type']."` AS c
				WHERE c.isdelete = 0 
				$searchs
				";
		if(empty($search['order'])){
			$sql.= ' ORDER BY c.id DESC ';
		}
		else{
			$sql.= ' ORDER BY '.$search['order'].' '.$search['index'].' ';
		}
		$sql.= ' limit '.$page.','.$rows;
		$query = $this->model->query($sql)->execute();
		return $query;
	}
	function getTotal($search){
		$tb = $this->base_model->loadTable();
		$searchs = $this->getSearch($search);
		$sql = " 
		SELECT count(1) total
		FROM `".$tb['hotel_goods_type']."` AS c
		WHERE c.isdelete = 0 
		$searchs	
		";
		$query = $this->model->query($sql)->execute();
		return $query[0]->total;	
	}
	function saves($array){
		$this->db->trans_begin();
		$tb = $this->base_model->loadTable();
		foreach($array as $key=>$val){
			$array[$key] = trim($val);
		}
		$check = $this->model->table($tb['hotel_goods_type'])
					  ->select('id')
					  ->where('isdelete',0)
					  ->where('goods_tye_name',$array['goods_tye_name'])
					  ->find();
		if(!empty($check->id)){
			return -1;	
		}
		$array['companyid'] = $this->login->companyid;
		$array['friendlyurl'] = $this->site->friendlyURL($array['goods_tye_name']);
		$result = $this->model->table($tb['hotel_goods_type'])->insert($array);	
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return 0;
		}
		else{
			$this->db->trans_commit();
			return 1;
		}
		
	}
	function edits($array,$id){
		 $this->db->trans_begin();
		 $tb = $this->base_model->loadTable();
		 foreach($array as $key=>$val){
			$array[$key] = trim($val);
		 }
		 $check = $this->model->table($tb['hotel_goods_type'])
		 ->select('id')
		 ->where('isdelete',0)
		 ->where('id <>',$id)
		 ->where('goods_tye_name',$array['goods_tye_name'])
		 ->find();
		 if(!empty($check->id)){
			 return -1;	
		 }
		 $array['companyid'] = $this->login->companyid;
		 $array['friendlyurl'] = $this->site->friendlyURL($array['goods_tye_name']);
		 $result = $this->model->table($tb['hotel_goods_type'])->where('id',$id)->update($array);	
		 if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return 0;
		}
		else{
			$this->db->trans_commit();
			return $id;
		}
	 }
	 
}