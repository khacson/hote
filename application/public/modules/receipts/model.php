<?php
/**
 * @author 
 * @copyright 2018
 */
 class ReceiptsModel extends CI_Model{
	function __construct(){
		parent::__construct('');
		$this->login = $this->site->getSession('login');
	}
	function getSearch($search){
		$sql = "";
		$tb = $this->base_model->loadTable();
		$companyid = $this->login->companyid;
		$branchid = $this->login->branchid;
		if(!empty($branchid)){
			$sql.= " and p.branchid in (".$branchid.") ";	
		}
		if(!empty($search['poid'])){
			$sql.= " and p.poid like '%".$search['poid']."%' ";	
		}
		if(!empty($search['receipts_code'])){
			$sql.= " and p.receipts_code like '%".$search['receipts_code']."%' ";	
		}
		if(!empty($search['amount'])){
			$sql.= " and p.amount like '%".$search['amount']."%' ";	
		}
		if(!empty($search['customerid'])){
			$sql.= " and p.customerid in (".$search['customerid'].") ";	
		}
		if(!empty($search['payment'])){
			$sql.= " and p.payment in (".$search['payment'].") ";	
		}
		
		return $sql;
	}
	function getList($search,$page,$rows){
		$tb = $this->base_model->loadTable();
		$searchs = $this->getSearch($search); //price_prepay
		$having = '';
		$sql = "SELECT p.*, sp.customer_name, b.bank_name
				FROM `".$tb['hotel_receipts']."` p
				LEFT JOIN `".$tb['hotel_bank']."` AS b on b.id = p.bankid 
				LEFT JOIN `".$tb['hotel_customer']."` sp on sp.id = p.customerid 
				WHERE p.isdelete = 0
				AND p.receipts_type > 0
				$searchs
				";
		if(empty($search['order'])){
			$sql.= ' ORDER BY p.id DESC ';
		}
		else{
			$sql.= ' ORDER BY '.$search['order'].' '.$search['index'].' ';
		}
		if($rows !=0){
			$sql.= ' limit '.$page.','.$rows;
		}
		
		$query = $this->model->query($sql)->execute();
		return $query;
	}
	function getTotal($search){
		$tb = $this->base_model->loadTable();
		$searchs = $this->getSearch($search); //price_prepay
		$sql = "
				SELECT count(1) total
				FROM `".$tb['hotel_receipts']."` p
				WHERE p.isdelete = 0
				AND p.receipts_type > 0
				$searchs
				";
		$query = $this->model->query($sql)->execute();
		return $query[0]->total;	
	}
	function edits($orderid,$array,$id,$payments){
		$tb = $this->base_model->loadTable();
		$this->db->trans_start();
		$companyid = $this->login->companyid;
		$branchid = $this->login->branchid;
		$insert = array();
		
		$poid = $this->createPOPay($branchid,$array['datepo']);
		$insert['receipts_code']  = $poid;
		$insert['poid']  = $array['poid']; //Chi khac
		$insert['branchid']  = $branchid; //Chi khac
		$insert['amount'] = fmNumberSave($array['amount']);
		$insert['datecreate']  = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
		$insert['usercreate'] = $this->login->username;
		$insert['companyid'] = $companyid;
		$insert['signature'] = $this->login->signature;
		$insert['signature_name'] = $this->login->fullname;
		$insert['notes'] = $array['description'];
		$insert['payment'] = $payments;
		$insert['receipts_type'] = 1;
		$insert['orderid'] = $array['orderid'];
		$insert['datepo'] = fmDateSave($array['datepo']);
		$this->model->table($tb['hotel_receipts'])->insert($insert);	
		
		$description = 'Tạo phiếu chi: '.$poid;
		$this->base_model->addAcction('Phiếu chi',$this->uri->segment(2),'','',$description);
	
		$this->db->trans_complete();
		return $id;
	}
	/*function dsCongNo($array,$id,$payments,$datecreate){
		$tb = $this->base_model->loadTable();
		$sql = "SELECT lb.id, lb.price, 
				(
					SELECT sum(p.amount)
					FROM `".$tb['receipts_type']."` p
					where p.isdelete = 0
					and p.uniqueid = c.uniqueid
				) as price_prepay
				FROM `".$tb['hotel_liabilities_buy']."` lb
				LEFT JOIN `".$tb['hotel_input_createorders']."` AS c on c.uniqueid = lb.uniqueid and c.isdelete = 0 and lb.liabilities = 2
				LEFT JOIN `".$tb['hotel_customer']."` sp on sp.id = lb.customerid 
				WHERE sp.isdelete = 0
				group by lb.uniqueid  
				having (lb.price > price_prepay or price_prepay is null)
				order by lb.datecreate asc 
				";
		return $this->model->query($sql)->execute();
	}
	function conNo($array,$id,$payments){
		$uniqueid = $array['uniqueid'];
		$tb = $this->base_model->loadTable();
		$having = '';
		$sql = "SELECT  lb.customerid, lb.datecreate, lb.id, lb.price, lb.uniqueid,
				(
					SELECT sum(p.amount)
					FROM `".$tb['receipts_type']."` p
					where p.isdelete = 0
					and p.uniqueid = '$uniqueid'
				) as price_prepay
				FROM `".$tb['hotel_liabilities_buy']."` lb
				WHERE lb.isdelete = 0
				AND lb.uniqueid = '$uniqueid'
				";
		$query = $this->model->query($sql)->execute();
		if(empty($query[0]->id)){
			$arr = array();
			$arr['customerid'] = 0;
			$arr['conno'] = 0;
			$arr['datecreate'] = '0000-00-00';
			return $arr;
		}
		else{
			$price = $query[0]->price;
			if(empty($query[0]->price_prepay)){
				$price_prepay = 0;
			}
			else{
				$price_prepay = $query[0]->price_prepay;
			}
			$arr = array();
			$arr['customerid'] = $query[0]->customerid;
			$arr['conno'] = $price - $price_prepay;
			$arr['datecreate'] = $query[0]->datecreate;
			return $arr;
		}
	}*/
	function createPOPay($branchid,$datecreate){
		$yearDay = fmMonthSave($datecreate);
		$tb = $this->base_model->loadTable();
		$checkPOid = $this->model->table($tb['hotel_receipts'])
							 ->select('receipts_code')
							 ->where("datepo like '$yearDay%'")
							 ->where('branchid',$branchid)
							 ->where('isdelete',0)
							 ->order_by('id','DESC')
							 ->limit(1)
							 ->find();
		if(!empty($checkPOid->receipts_code)){
			$receipts_code = str_replace(cfpc(),'',$checkPOid->receipts_code);
			$poc = (float)$receipts_code;
		}
		else{
			$poc = date('ym',strtotime($yearDay)).'00000';
		}
		return cfpc().($poc + 1);
	}
	function findID($id){
		$tb = $this->base_model->loadTable();	
		$query = $this->model->table($tb['hotel_input'])
					  ->select('*')
					  ->where('id',$id)
					  ->find();
		return $query;
	}
	function findUniqueID($id,$orderid){
		$tb = $this->base_model->loadTable();	
		$query = $this->model->table($tb['hotel_receipts'])
					  ->select('*')
					  ->where('orderid',$orderid);
		if(!empty($id)){
			$query = $query->where('id',$id);
		}
		$query = $query->order_by('datecreate','desc')
					  ->find();
		return $query;
	}
	function findIDs($id){
		$tb = $this->base_model->loadTable();
		$query = $this->model->table($tb['hotel_input'])
					  ->select('*')
					  ->where('id',$id)
					  ->find();
		return $query;
	}
	function payType($id){
		$tb = $this->base_model->loadTable();
		$query = $this->model->table($tb['hotel_pay_type'])
					  ->select('*')
					  ->where('id',$id)
					  ->find();
		return $query;
	}
	/*function findUniqueidPop($orderid){
		$tb = $this->base_model->loadTable();
		$sql = "
			select o.id, g.goods_code, g.goods_name, un.unit_name, o.quantity, o.cksp, o.priceone, o.discount_value
			from `".$tb['hotel_input']."` o
			left join `".$tb['hotel_goods']."` g on g.id = o.goodsid
			left join `".$tb['hotel_unit']."` un on un.id = g.unitid
			where o.isdelete = 0
			and o.orderid = '$orderid'
			and g.isdelete = 0
			and un.isdelete = 0
		";
		return $this->model->query($sql)->execute();
	}
	function getPays($orderid){
		$tb = $this->base_model->loadTable();
		$query = $this->model->table($tb['receipts_type'])
							 ->where('orderid',$orderid)
							 ->where('isdelete',0)
							 ->find_all();
		return $query;
	}*/
}