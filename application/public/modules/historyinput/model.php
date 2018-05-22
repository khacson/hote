<?php
/**
 * @author 
 * @copyright 2016
 */
 class HistoryinputModel extends CI_Model{
	function __construct(){
		parent::__construct('');
		$this->login = $this->site->getSession('login');
		$this->ctr = 1;
	}
	function getSearch($searchs){
		foreach($searchs as $key=>$val){
			$search[$key] = addslashes($val); 
		}
		$sql = "";
		$companyid = $this->login->companyid;
		$branchid = $this->login->branchid;
		$skey = $this->login->skey;
		
		if(!empty($branchid)){
			$sql.= " and c.branchid in (".$branchid.") ";	
		}
		else{
			if(!empty($search['branchid'])){
				$sql.= " and c.branchid in (".$search['branchid'].") ";	
			}
		}
		if(!empty($search['supplierid'])){
			$sql.= " and c.supplierid in (".$search['supplierid'].") ";	
		}
		if(!empty($search['payments'])){
			$sql.= " and c.payments in (".$search['payments'].") ";	
		}
		if(!empty($search['goods_type'])){
			$sql.= " and g.goods_type in (".$search['goods_type'].") ";	
		}
		if(!empty($search['formdate'])){
			$sql.= " and c.datecreate >= '".fmDateSave($search['formdate'])." 00:00:00' ";	
		}
		if(!empty($search['todate'])){
			$sql.= " and c.datecreate <= '".fmDateSave($search['todate'])." 23:59:59' ";	
		}
		if(!empty($search['poid'])){
			$poid = str_replace(cfpn(),'',$search['poid']);
			$sql.= " and c.poid like '%".$poid."%' ";	
		}
		if(!empty($search['quantity'])){
			$sql.= " and c.quantity like '%".$search['quantity']."%' ";
		}
		if(!empty($search['goods_name'])){
			$sql.= " and g.goods_name like '%".$search['goodsnamesearch']."%' ";
		}
		if(!empty($search['price_total'])){
			$sql.= " and c.price_total like '%".$search['price_total']."%' ";
		}
		if(!empty($search['price_prepay_value'])){
			$sql.= " and c.price_prepay_value like '%".$search['price_prepay_value']."%' ";
		}
		if(!empty($search['description'])){
			$sql.= " and c.description like '%".$search['description']."%' ";
		}
		if(!empty($search['usercreate'])){
			$sql.= " and c.usercreate like '%".$search['usercreate']."%' ";
		}
		return $sql;
	}
	function getList($search,$page,$rows){
		$searchs = $this->getSearch($search);
		$tb = $this->base_model->loadTable();
		$skey = $this->login->skey;
		$sql = "SELECT c.id,c.price_prepay_type, c.supplierid, c.warehouseid, c.payments, c.datecreate, c.usercreate ,c.uniqueid,c.poid,c.datepo,c.description,  sum(so.quantity + if(so.cksp is null,0,so.cksp)) as quantity, c.price_total, c.price_prepay,sp.supplier_name, c.uniqueid, sum(so.cksp) as cksp,
		sum(so.discount_value) as discount_value, 
				 c.price,
				 (
					select group_concat(concat(gg.goods_code,' - ', goods_name) SEPARATOR ',<br>')
					from `".$tb['hotel_goods']."` gg
					where FIND_IN_SET (gg.id,(group_concat(so.goodsid)))
				) goods_code, 
				(
					SELECT sum(p.amount)
					FROM `".$tb['hotel_pay']."` p
					where p.isdelete = 0
					and p.orderid = c.id
				) as amount 
				FROM `".$tb['hotel_input']."` so
				LEFT JOIN `".$tb['hotel_input_createorders']."` AS c on c.id = so.orderid
				LEFT JOIN `".$tb['hotel_supplier']."` sp on sp.id = c.supplierid and sp.isdelete = 0
				left join `".$tb['hotel_goods']."` g on g.id = so.goodsid
				WHERE c.isdelete = 0 
				and so.isdelete = 0
				and g.isdelete  = 0
				$searchs
				group by c.id
				";
		if(empty($search['order'])){
			$sql.= ' ORDER BY c.id DESC, g.goods_code asc ';
		}
		else{
			$sql.= ' ORDER BY '.$search['order'].' '.$search['index'].', g.goods_code asc';
		}
		if($rows != 0){
			$sql.= ' limit '.$page.','.$rows;
		}
		//print_r($sql); exit;
		$query = $this->model->query($sql)->execute();
		return $query;
	}
	function getTotal($search){
		$searchs = $this->getSearch($search);
		$tb = $this->base_model->loadTable();
		$sql = "
				select count(1) total
				from(
				SELECT 1 as total
				FROM `".$tb['hotel_input']."` so
				LEFT JOIN `".$tb['hotel_input_createorders']."` AS c on c.id = so.orderid
				LEFT JOIN `".$tb['hotel_supplier']."` sp on sp.id = c.supplierid and sp.isdelete = 0
				left join `".$tb['hotel_goods']."` g on g.id = so.goodsid
				WHERE c.isdelete = 0 
				and so.isdelete = 0
				and g.isdelete  = 0
				 and g.isdelete = 0
				$searchs
				group by c.id ) temp
				";
		$query = $this->model->query($sql)->execute();
		return $query[0]->total;	
	}
	function deletes($id, $array){
		//$arr = explode(',',$id);
		//List Uniqueid
		$tb = $this->base_model->loadTable();
		$branchid = $this->login->branchid;
		$reseponse = array();
		$this->db->trans_start();
		$query = $this->model->table($tb['hotel_input_createorders'])
					  ->select('id as orderid,id,poid,uniqueid')
					  ->where("id in ($id)")
					  ->find_all();
		//Kiem tra don hang da thanh toan chua, neu da thanh toan thi kho duong xoa
		$chekPay = $detail = $this->model->table($tb['hotel_pay'])
						   ->select('id')
						   ->where("orderid",$id)
					       ->find();
		if(!empty($chekPay->id)){
			$reseponse['status'] = -2;////////////return -1;
			$reseponse['msg'] = getLanguage('don-hang-da-thanh-toan-ban-khong-duoc-xoa');
			return $reseponse;
		}		
		foreach($query as $item){
			$detail = $this->model->table($tb['hotel_input'])
						   ->select('id,orderid, quantity, priceone, poid, goodsid')
						   ->where("orderid",$item->orderid)
						   ->where('isdelete',0)
					       ->find_all();
			//Tr so luong vao kho
			foreach($detail as $items){
				$goodsid = $items->goodsid;
				$quantity = $items->quantity;
				$sqlUpdate = "
					UPDATE `".$tb['hotel_inventory']."` SET `quantity`=`quantity`- $quantity 
					WHERE `id` > 0
					and `goodsid`= '$goodsid'
					and `branchid`= '$branchid'
					;
				";
				$this->model->executeQuery($sqlUpdate);
			}
			$dataOld = json_encode($detail);
			#region ghi log
			$description = getLanguage('xoa').': '.$item->poid;
			$this->base_model->addAcction(getLanguage('nhap-kho'),$this->uri->segment(2),$dataOld,'',$description );	
			#end
		}
		//Xoa du lieu
		foreach($query as $item){
			$detail = $this->model->table($tb['hotel_input'])
						   ->where("orderid",$item->orderid)
					       ->delete();
			//Xoa phieu chi
			$detail = $this->model->table($tb['hotel_pay'])
						   ->where("orderid",$id)
					       ->delete();
			//Xoa cong no
			$detail = $this->model->table($tb['hotel_liabilities_buy'])
						   ->where("orderid",$id)
					       ->delete();
		}
		$this->model->table($tb['hotel_input_createorders'])
					  ->where("id in ($id)")
					  ->delete();
		
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$reseponse['status'] = 0;////////////return -1;
			$reseponse['msg'] = '';
			return $reseponse;
		} 
		else {
			$this->db->trans_commit();
			$reseponse['status'] = 1;////////////return -1;
			$reseponse['msg'] = "";
			return $reseponse;
		}
	}
}