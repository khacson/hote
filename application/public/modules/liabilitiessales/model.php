<?php
/**
 * @author 
 * @copyright 2015
 */
 class LiabilitiessalesModel extends CI_Model{
	function __construct(){
		parent::__construct();
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
			$sql.= " and DES_DECRYPT(c.phone,'".$this->login->skey ."')  like '%".$search['customer_name']."%' ";	
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
		$tb = $this->base_model->loadTable();
		$searchs = $this->getSearch($search);
		$sql = "SELECT c.id, 
				(
				select GROUP_CONCAT(DES_DECRYPT(sg.goods_name,'".$this->login->skey ."'))
				from `".$tb['hotel_output']."` so
				left join `".$tb['hotel_goods']."` sg on sg.id = so.goodsid
				where so.isdelete = 0
				and sg.isdelete = 0
				and so.uniqueid = c.uniqueid
				) as goods_name,
				e.fullname as employee_name ,  e.username as employee_code, c.customer_name,
				DES_DECRYPT(cm.customer_name,'".$this->login->skey ."') as cmname,
				DES_DECRYPT(cm.phone,'".$this->login->skey ."') as cmphone,
				DES_DECRYPT(cm.address,'".$this->login->skey ."') as cmaddress,
				DES_DECRYPT(cm.email,'".$this->login->skey ."') as cmemail, 
				c.customer_type, c.payments_status, c.quantity, c.price_total , c.price, c.price_prepay,
				c.poid, c.customer_id, c.payments, c.description, c.datecreate, c.customer_address, c.customer_phone, c.customer_email
				FROM `".$tb['hotel_output_createorders']."` AS c
				LEFT JOIN `".$tb['hotel_customer']."` cm on cm.id = c.customer_id and cm.isdelete = 0
				LEFT JOIN `hotel_users` e on e.id = c.employeeid and e.isdelete = 0 
				WHERE c.isdelete = 0 
				AND c.isout = 1
				AND c.payments_status = -1
				$searchs
				";
		if(empty($search['order'])){
			$sql.= ' ORDER BY c.id DESC ';
		}
		else{
			$sql.= ' ORDER BY '.$search['order'].' '.$search['index'].' ';
		}
		if($page !=0 || $rows != 0){
			$sql.= ' limit '.$page.','.$rows;
		}
		//print_r($sql); exit;
		$query = $this->model->query($sql)->execute();
		return $query;
	}
	function getTotal($search){
		$tb = $this->base_model->loadTable();
		$searchs = $this->getSearch($search);
		$sql = " 
		SELECT count(1) total
		FROM `".$tb['hotel_output_createorders']."` AS c
		LEFT JOIN `".$tb['hotel_customer']."` cm on cm.id = c.customer_id and cm.isdelete = 0
		LEFT JOIN `hotel_users` e on e.id = c.employeeid and e.isdelete = 0 
		WHERE c.isdelete = 0 
		AND c.isout = 1
		AND c.payments_status = -1
		$searchs	
		";
		$query = $this->model->query($sql)->execute();
		return $query[0]->total;	
	}
	function edits($array,$id,$payments){
		$tb = $this->base_model->loadTable();		
		$this->db->trans_start();
		 $companyid = $this->login->companyid;
		 $branchid = $this->login->branchid;
		 //$array['price'] = $array['priceone'] * $array['quantity'];
		 $maturitydate = date('Y-m-d',strtotime($array['maturitydate']));
		  $array['add_price'] = str_replace(',','',$array['add_price']);
		  $array['price_cl'] = str_replace(',','',$array['price_cl']);
		  if((int)$array['price_cl'] == 0){
				$payments_status = 0;//$array['payments_status'];
		  }
		  else{
			  $payments_status = -1;
		  }
		 $price_prepay = $array['add_price'];
		 $queryFind = $this->model->table($tb['hotel_output_createorders'])
						   ->select('id,uniqueid,poid')
						   ->where('id',$id)
						   ->find();
		 $sqlUpdate = "
					UPDATE `".$tb['hotel_output_createorders']."` SET 
					`maturitydate`= '$maturitydate',
					`payments_status`= '$payments_status',
					`price_prepay`= `price_prepay` + $price_prepay
					WHERE `id` = '$id'
					;
				 ";
		 $this->model->executeQuery($sqlUpdate);
		 //Cập nhat hotel_liabilitieshotel_history
		 /*$arrAdd = array();
		 $arrAdd['companyid'] = $companyid;
		 $arrAdd['branchid'] = $branchid;
		 $arrAdd['orderid'] = $id;
		 $arrAdd['add_price'] = $array['add_price'];
		 $arrAdd['price_cl'] = $array['price_cl'];
		 $arrAdd['note'] = $array['note'];
		 $arrAdd['payments'] = $payments;
		 $arrAdd['datecreate']  = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
		 $arrAdd['usercreate'] = $this->login->username;
		 $this->model->table($this->base_model->tb_liabilitieshotel_history())->insert($arrAdd);*/
		 #region Nhập vào phiếu thu
		 $arrIS =  array();
		 $uniqueid = $queryFind->uniqueid;
		 $arrIS['uniqueid'] = $uniqueid;
		 $arrIS['companyid'] = $companyid;
		 $arrIS['branchid'] = $branchid;
		 $arrIS['receipts_type'] = 1;
		 $arrIS['payment'] = $payments;
		 $arrIS['amount'] = $array['add_price'];
		 $arrIS['poid'] = $queryFind->poid;
		 $arrIS['usercreate'] = $this->login->username;
		 $arrIS['datecreate'] = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
		
		 $this->model->table($tb['hotel_receipts'])->insert($arrIS);
		
		 $check = $this->model->table($tb['hotel_receipts'])
							 ->select('id')
							 ->where('uniqueid',$uniqueid)
							 ->order_by('id','DESC')
							 ->find();
		//print_r($check); exit;
		$update = array();
		$update['receipts_code'] = $check->id;
		$this->model->table($tb['hotel_receipts'])
					->where('id',$check->id)
					->where('isdelete',0)
					->update($update);
		#end
		 $this->db->trans_complete();
		 return $id;
	 }
	function findID($id){
		$tb = $this->base_model->loadTable();	
		$query = $this->model->table($tb['hotel_output_createorders'])
					  ->select('*')
					  ->where('id',$id)
					  ->find();
		return $query;
	 }
	function findIDs($id){
		$tb = $this->base_model->loadTable();
		$query = $this->model->table($tb['hotel_output_createorders'])
					  ->select('*')
					  ->where('id',$id)
					  ->where('isout',0)
					  ->find();
		return $query;
	 }
	 public function getSalesOutput($companyid,$branchid,$id) {
		$tb = $this->base_model->loadTable();
		$query = $this->model
						  ->select('poid')
						  ->table($tb['hotel_output_createorders'])
						  ->where('isdelete',0)
						  ->where('isout',1)
						  ->where('payments',-1)
						  ->where('payments_status',0)
						  ->where('poid <>',0)
						  ;	
		    if(!empty($id)){
			   $query = $query->where('id',$id);
		    }
			if(!empty($companyid)){
			   $query = $query->where('companyid',$companyid);
		    }	
			if(!empty($branchid)){
			   $query = $query->where('branchid',$branchid);
		    }	
			$query = $query->order_by('id','DESC');
		    $query = $query->find_all();
			return $query;
	 }
	 function getListDetailPO($id){
		$tb = $this->base_model->loadTable();
		$companyid = $this->login->companyid;
		 $sql = "
			SELECT h.*, oc.poid, oc.quantity, oc.price, oc.price_prepay
			FROM `".$tb['hotel_receipts']."` h
			left join `".$tb['hotel_output_createorders']."` oc on oc.uniqueid = h.uniqueid
			where h.isdelete = 0
			and oc.isdelete = 0
			and oc.companyid = '$companyid'
			and oc.id = '$id'
			;
		 ";
		 $query = $this->model->query($sql)->execute();
		 return $query; 
	 }
}