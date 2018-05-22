<?php
/**
 * @author 
 * @copyright 2015
 */
 class SerialnumberModel extends CI_Model{
	function __construct(){
		parent::__construct('');
		$this->login = $this->site->getSession('login');
	}
	public function getGoods($goodsid=''){
		$tb = $this->base_model->loadTable();
		$sql = 
		"
			select sg.id, sg.goods_code, DES_DECRYPT(sg.goods_name,'".$this->login->skey ."') as goods_name
			from `".$tb['hotel_goods']."` sg
			where sg.isdelete = 0
			and sg.isserial = 1
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
		if(!empty($search['sn'])){
			$sql.= " and c.sn like '%".addslashes($search['sn'])."%' ";	
		}
		if(!empty($search['sn'])){
			$sql.= " and c.imei like '%".addslashes($search['imei'])."%' ";	
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
		$tb = $this->base_model->loadTable();
		$searchs = $this->getSearch($search);
		$skey = $this->login->skey;
		$sql = "SELECT c.id, c.goodsid, c.sn, c.imei, c.description,
				g.goods_code, 
				DES_DECRYPT(g.goods_name,'$skey') as goods_name
				FROM `".$tb['hotel_seial']."` AS c
				LEFT JOIN `".$tb['hotel_goods']."` g on g.id = c.goodsid 
				WHERE c.isdelete = 0 
				and g.isdelete = 0
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
		$searchs = $this->getSearch($search);
		$tb = $this->base_model->loadTable();
		$sql = " 
		SELECT count(1) total
		FROM `".$tb['hotel_seial']."` AS c
		LEFT JOIN `".$tb['hotel_goods']."` g on g.id = c.goodsid 
		WHERE c.isdelete = 0 
		and g.isdelete = 0
		$searchs	
		";
		$query = $this->model->query($sql)->execute();
		return $query[0]->total;	
	}
	function saves($array){
		$tb = $this->base_model->loadTable();
		$this->db->trans_begin();
		foreach($array as $key=>$val){
			$array[$key] = trim($val);
		}
		$check = $this->model->table($tb['hotel_seial'])
					  ->select('id')
					  ->where('isdelete',0)
					  ->where('sn',$array['sn'])
					  ->where('goodsid',$array['goodsid'])
					  ->find();
		if(!empty($check->id)){
			return -1;	
		}
		
		$result = $this->model->table($tb['hotel_seial'])->insert($array);	
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
		$tb = $this->base_model->loadTable();
		$this->db->trans_begin();
		foreach($array as $key=>$val){
			$array[$key] = trim($val);
		}
		$check = $this->model->table($tb['hotel_seial'])
		 ->select('id')
		 ->where('isdelete',0)
		 ->where('id <>',$id)
		 ->where('sn',$array['sn'])
	     ->where('goodsid',$array['goodsid'])
		 ->find();
		 if(!empty($check->id)){
			 return -1;	
		 }
		 
		 $result = $this->model->table($tb['hotel_seial'])->where('id',$id)->update($array);	
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
		$tb = $this->base_model->loadTable();
		$query = $this->model->table($tb['hotel_seial'])
					  ->select('*')
					  ->where('id',$id)
					  ->find();
		return $query;
	 }
}