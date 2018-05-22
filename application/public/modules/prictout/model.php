<?php
/**
 * @author 
 * @copyright 2015
 */
 class PrictoutModel extends CI_Model{
	function __construct(){
		parent::__construct('');
		$this->login = $this->site->getSession('login');
	}
	public function getGoods($goodsid=''){
			$sql = 
			"
				select sg.id, sg.goods_code, DES_DECRYPT(sg.goods_name,'".$this->login->skey ."') as goods_name
				from `".$this->base_model->tb_goods()."` sg
				where sg.isdelete = 0
				and sg.companyid = '".$this->login->companyid ."'
			";
			if(!empty($goodsid)){
				$sql.= " and sg.id = '$goodsid'";
			}
			$sql.= " order by sg.goods_name ASC";
			$query = $this->model->query($sql)->execute();
			return $query;
		}
	function getSearch($search){
		$sql = "";
		$companyid = $this->login->companyid;
		if(!empty($search['price'])){
			$sql.= " and c.price like '%".addslashes($search['price'])."%' ";	
		}
		if(!empty($search['description'])){
			$sql.= " and c.description like '%".addslashes($search['description'])."%' ";	
		}
		if(!empty($search['goodsid'])){
			$sql.= " and c.goodsid in (".($search['goodsid']).") ";	
		}
		return $sql;
	}
	function getList($search,$page,$rows){
		$searchs = $this->getSearch($search);
		$skey = $this->login->skey;
		$sql = "SELECT c.id, c.description, c.price, c.goodsid, c.description,
				g.goods_code, 
				DES_DECRYPT(g.goods_name,'$skey') as goods_name
				FROM `".$this->base_model->tb_priceout() ."` AS c
				LEFT JOIN `".$this->base_model->tb_goods() ."` g on g.id = c.goodsid 
				WHERE c.isdelete = 0 
				and g.isdelete = 0
				$searchs
				";
		if(empty($search['order'])){
			$sql.= ' ORDER BY g.goods_code asc ';
		}
		else{
			$sql.= ' ORDER BY '.$search['order'].' '.$search['index'].' ';
		}
		$sql.= ' limit '.$page.','.$rows;
		$query = $this->model->query($sql)->execute();
		return $query;
	}
	function getTotal($search){
		$searchs = $this->getSearch($search);
		$sql = " 
		SELECT count(1) total
		FROM `".$this->base_model->tb_priceout() ."` AS c
		LEFT JOIN `".$this->base_model->tb_goods() ."` g on g.id = c.goodsid 
		WHERE c.isdelete = 0 
		and g.isdelete = 0
		$searchs	
		";
		$query = $this->model->query($sql)->execute();
		return $query[0]->total;	
	}
	function saves($array){
		$this->db->trans_begin();
		foreach($array as $key=>$val){
			$array[$key] = trim($val);
		}
		$check = $this->model->table($this->base_model->tb_priceout())
					  ->select('id')
					  ->where('isdelete',0)
					  ->where('price',$array['price'])
					  ->where('goodsid',$array['goodsid'])
					  ->find();
		if(!empty($check->id)){
			return -1;	
		}
		
		$result = $this->model->table($this->base_model->tb_priceout())->insert($array);	
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
		 foreach($array as $key=>$val){
			$array[$key] = trim($val);
		 }
		 $check = $this->model->table($this->base_model->tb_priceout())
		 ->select('id')
		 ->where('isdelete',0)
		 ->where('id <>',$id)
		 ->where('price',$array['price'])
	     ->where('goodsid',$array['goodsid'])
		 ->find();
		 if(!empty($check->id)){
			 return -1;	
		 }
		 
		 $result = $this->model->table($this->base_model->tb_serial())->where('id',$id)->update($array);	
		 if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return 0;
		}
		else{
			$this->db->trans_commit();
			return $id;
		}
	 }
	 function findID($id){
		 $query = $this->model->table($this->base_model->tb_priceout())
					  ->select('*')
					  ->where('id',$id)
					  ->find();
		return $query;
	 }
}