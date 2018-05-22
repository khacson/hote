<?php
/**
 * @author 
 * @copyright 2016
 */
 class HistoryinputreturnModel extends CI_Model{
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
		if(!empty($search['goodsidsearch'])){
			$sql.= " and g.goods_code like '%".$search['goodsidsearch']."%' ";
		}
		if(!empty($search['goodsnamesearch'])){
			$sql.= " and CAST(DES_DECRYPT(g.goods_name,'".$skey."') as CHAR(250)) like '%".$search['goodsnamesearch']."%' ";
		}
		
		return $sql;
	}
	function getList($search,$page,$rows){
		$searchs = $this->getSearch($search);
		$tb = $this->base_model->loadTable();
		$skey = $this->login->skey;
		$sql = "SELECT c.id, c.customerid, c.warehouseid, c.payments, c.datecreate, c.usercreate ,c.uniqueid,c.poid,c.datepo,c.description, sum(so.quantity) as quantity, c.price, c.price_prepay,  sp.customer_name, c.uniqueid,
				  c.price,
				 (
					select group_concat(concat(gg.goods_code,' - ', gg.goods_name) SEPARATOR ',<br>')
					from `".$tb['hotel_goods']."` gg
					where FIND_IN_SET (gg.id,(group_concat(so.goodsid)))
				) goods_code 
				 
				FROM `".$tb['hotel_input_return']."` so
				LEFT JOIN `".$tb['hotel_input_return_orders']."` AS c on c.uniqueid = so.uniqueid
				LEFT JOIN `".$tb['hotel_customer']."` sp on sp.id = c.customerid 
				left join `".$tb['hotel_goods']."` g on g.id = so.goodsid
				WHERE c.isdelete = 0 
				and so.isdelete = 0
				and g.isdelete  = 0
				and sp.isdelete = 0
				$searchs
				group by c.uniqueid
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
				SELECT count(1) as total
				FROM `".$tb['hotel_input_return_orders']."` c
				LEFT JOIN `".$tb['hotel_customer']."` sp on sp.id = c.customerid 
				WHERE c.isdelete = 0
				and sp.isdelete = 0
				$searchs
				";
		$query = $this->model->query($sql)->execute();
		return $query[0]->total;	
	}
	function deletes($id, $array){
		$tb = $this->base_model->loadTable();
		$this->db->trans_start();
		$query = $this->model->table($tb['hotel_input_createorders'])
					  ->select('uniqueid,id,poid')
					  ->where("id in ($id)")
					  ->find_all();
		foreach($query as $item){
			$detail = $this->model->table($tb['hotel_input'])
						   ->select('id,uniqueid, quantity, priceone, poid')
						   ->where("uniqueid",$item->uniqueid)
						   ->where('isdelete',0)
					       ->find_all();
			//Tr so luong vao kho
			foreach($detail as $items){
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
			$description = 'Xóa: Đơn hàng '.$item->poid;
			$this->base_model->addAcction('Nhập hàng trả lại',$this->uri->segment(2),$dataOld,'',$description );	
			#end
		}
		//Xoa du lieu
		foreach($query as $item){
			$detail = $this->model->table($tb['hotel_input'])
						   ->where("uniqueid",$item->uniqueid)
					       ->delete();
			$detail = $this->model->table($tb['hotel_pay'])
						   ->where("uniqueid",$item->uniqueid)
					       ->delete();			   
		}
		$this->model->table($tb['hotel_input_createorders'])
					  ->where("id in ($id)")
					  ->delete();
		
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return 1;
		} 
		else {
			$this->db->trans_commit();
			return 0;
		}
	}
}