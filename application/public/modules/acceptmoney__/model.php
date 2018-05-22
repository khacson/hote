<?php
/**
 * @author sonnk
 * @copyright 2016
 */
class AcceptmoneyModel extends CI_Model
{
	function __construct(){
		parent::__construct('');
	}
	function findID($id) {
		$tb = $this->base_model->loadTable();
        $query = $this->model->table($tb['g_acceptmoney'])
					  ->where('isdelete',0)
					  ->where('id',$id)
					  ->find();
        return $query;
    }
	function getSearch($search){
		$sql = "";
		$login = $this->login;
		if(!empty($login['branchid'])){
			$sql.= " and p.branchid = '".$login['branchid']."' ";	
		}
		else{
			if(!empty($search['description'])){
				$sql.= " and p.branchid = '".$search['branchid']."' ";	
			}
		}
		if(!empty($search['fromdate'])){
			$sql.= " and p.datecreate >= '".fmDateSave($search['fromdate'])." 00:00:00' ";	
		}
		if(!empty($search['todate'])){
			$sql.= " and p.datecreate <= '".fmDateSave($search['todate'])." 23:59:59' ";	
		}
		if(!empty($search['catalogid'])){
			$sql.= " and p.catalogid  in (".$search['catalogid'].") ";	
		}
		if(!empty($search['useraceptid'])){
			$sql.= " and p.useraceptid  in (".$search['useraceptid'].") ";	
		}
		if(!empty($search['personid'])){
			$sql.= " and p.personid in (".$search['personid'].") ";	
		}
		if(!empty($search['receiptcode'])){
			$sql.= " and p.receiptcode like '%".fmNumberSave($search['receiptcode'])."%' ";	
		}
		if(!empty($search['money'])){
			$sql.= " and p.money like '%".fmNumberSave($search['money'])."%' ";	
		}
		if(!empty($search['description'])){
			$sql.= " and p.description like '%".$search['description']."%' ";	
		}
		return $sql;
	}
	function getList($search,$page,$rows){
		$tb = $this->base_model->loadTable();
		$searchs = $this->getSearch($search);
		$sql = " SELECT p.*, br.branch_name, u.fullname, us.fullname as pfullname
				FROM `".$tb['g_acceptmoney']."` AS p
				LEFT JOIN `".$tb['g_branch']."` br on br.id = p.branchid
				LEFT JOIN `g_users` u on u.id = p.useraceptid
				LEFT JOIN `g_users` us on us.id = p.personid
				WHERE p.isdelete = 0 
				$searchs
				and p.isdelete = 0
				ORDER BY p.money ASC 
				";
		if(!empty($rows)){
			$sql.= ' limit '.$page.','.$rows;
		}
		$query = $this->model->query($sql)->execute();
		return $query;
	}
	function getTotal($search){
		$tb = $this->base_model->loadTable();
		$searchs = $this->getSearch($search);
		$sql = " 
		SELECT count(1) total  
			FROM `".$tb['g_acceptmoney']."` AS p
			LEFT JOIN `".$tb['g_branch']."` br on br.id = p.branchid
			WHERE p.isdelete = 0
			$searchs	
			and br.isdelete = 0
		";
		$query = $this->model->query($sql)->execute();
		return $query[0]->total;	
	}
	function saves($array,$id){
		$result = array();
		$tb = $this->base_model->loadTable();
		$array['money'] = fmNumberSave($array['money']);
		//$array['datepay'] = fmDateSave($array['datepay']);
		//$array['personid'] = $this->login['id'];
		//Find user
		$finds = $this->model->table('g_users')->where('id',$array['useraceptid'])->find();
		if(!empty($finds->id)){
			$array['branchid'] = $finds->branchid;
		}
		$id = $this->model->table($tb['g_acceptmoney'])->save('',$array);	
		$result['id'] = $id;
		$result['status'] = 1;
		return $result;
	}
	function edits($array,$id){
		$result = array();
		$tb = $this->base_model->loadTable();
		$array['money'] = fmNumberSave($array['money']);
		//$array['datepay'] = fmDateSave($array['datepay']);
		//$array['personid'] = $this->login['id'];
		//Find user
		$finds = $this->model->table('g_users')->where('id',$array['useraceptid'])->find();
		if(!empty($finds->id)){
			$array['branchid'] = $finds->branchid;
		}
		$this->model->table($tb['g_acceptmoney'])
					->where('id',$id)
					->update($array);	
		$result['id'] = $id;
		$result['status'] = 1;
		return $result;
	}
	function deletes($id,$array){
		$tb = $this->base_model->loadTable();
		$this->model->table($tb['g_acceptmoney'])
					->where("id in ($id)")
					->update($array);
		return 1;
	}
}