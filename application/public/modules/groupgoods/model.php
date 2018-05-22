<?php
/**
 * @author 
 * @copyright 2015
 */
 class GroupgoodsModel extends CI_Model{
	function __construct(){
		parent::__construct('');
		$this->login = $this->site->getSession('login');
	}
	function getSearch($search){
		$sql = "";
		$companyid = $this->login->companyid;
		if(!empty($search['group_code'])){
			$sql.= " and c.group_code like '%".addslashes($search['group_code'])."%' ";	
		}
		if(!empty($search['group_name'])){
			$sql.= " and c.group_name like '%".addslashes($search['group_name'])."%' ";	
		}
		if(!empty($search['unitid'])){
			$sql.= " and c.unitid in (".addslashes($search['unitid']).") ";	
		}
		return $sql;
	}
	function getList($search,$page,$rows){
		$searchs = $this->getSearch($search);
		$skey = $this->login->skey;
		$tb = $this->base_model->loadTable();
		$sql = "SELECT c.id, c.unitid as unitidgroup ,c.group_code, c.group_name ,u.unit_name as unit_name_group, u1.unit_name, gd.id as detailid,gd.exchang, gd.groupid, gd.unitid ,g.goods_code, 
				DES_DECRYPT(g.goods_name,'$skey') as goods_name
				FROM `".$tb['hotel_goods_group']."` AS c
				LEFT JOIN `".$tb['hotel_goods_group_detail']."` gd on c.id = gd.groupid and gd.isdelete = 0
				LEFT JOIN `".$tb['hotel_goods']."` g on g.id = gd.goodid and g.isdelete = 0
				LEFT JOIN `".$tb['hotel_unit']."` u on u.id = c.unitid and u.isdelete = 0
				LEFT JOIN `".$tb['hotel_unit']."` u1 on u1.id = g.unitid and u1.isdelete = 0
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
		$searchs = $this->getSearch($search);
		$tb = $this->base_model->loadTable();
		$sql = " 
		SELECT count(1) total
				FROM `".$tb['hotel_goods_group']."` AS c
				LEFT JOIN `".$tb['hotel_goods_group_detail']."` gd on c.id = gd.groupid and gd.isdelete = 0
				LEFT JOIN `".$tb['hotel_goods']."` g on g.id = gd.goodid and g.isdelete = 0
				LEFT JOIN `".$tb['hotel_unit']."` u on u.id = c.unitid and u.isdelete = 0
				LEFT JOIN `".$tb['hotel_unit']."` u1 on u1.id = g.unitid and u1.isdelete = 0
				WHERE c.isdelete = 0 
		$searchs	
		";
		$query = $this->model->query($sql)->execute();
		return $query[0]->total;	
	}
	function findID($id){
		$tb = $this->base_model->loadTable();
		$query = $this->model->table($tb['hotel_goods_type'])
					  ->select('*')
					  ->where('id',$id)
					  ->find();
		return $query;
	 }
}