<?php
/**
 * @author 
 * @copyright 2018
 */
 class LiabilitiessaleModel extends CI_Model{
	function __construct(){
		parent::__construct('');
		$this->login = $this->site->getSession('login');
	}
	function findID($id){
		 $tb = $this->base_model->loadTable();
		 $query = $this->model->table($tb['hotel_liabilities'])
					  ->select('*')
					  ->where('id',$id)
					  ->find();
		return $query;
	}
	function findDetail($id){
		 $tb = $this->base_model->loadTable();
		 $query = $this->model->table($tb['hotel_receipts'])
					  ->select('*')
					  ->where('orderid',$id)
					  ->order_by('datecreate','desc')
					  ->find_all();
		return $query;
	}
	function getSearch($search){
		$sql = "";
		$companyid = $this->login->companyid;
		if(!empty($search['customerid'])){
			$sql.= " and l.customerid in (".$search['customerid'].") ";	
		}
		if(!empty($search['expirationdate'])){
			$sql.=" and l.expirationdate = '".fmDateSave($search['expirationdate'])." '";	
		}
		if(!empty($search['price'])){
			$sql.= " and l.price like '%".fmNumberSave($search['price'])."%' ";	
		}
		if(!empty($search['description'])){
			$sql.= " and l.description like '%".$search['description']."%' ";	
		}
		return $sql;
	}
	function getList($search,$page,$rows){
		$searchs = $this->getSearch($search);
		$tb = $this->base_model->loadTable();
		$skey = $this->login->skey;
		$sql = "SELECT l.*, c.customer_name,
				(
					select sum(amount)
					from `".$tb['hotel_receipts']."`
					where isdelete = 0
					and orderid = l.id
				) da_thanh_toan
				FROM `".$tb['hotel_liabilities']."` AS l
				LEFT JOIN `".$tb['hotel_customer']."` c on c.id = l.customerid 
				WHERE l.isdelete = 0  
				and l.liabilities = 2
				and c.isdelete = 0
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
		FROM `".$tb['hotel_liabilities']."` AS l
				LEFT JOIN `".$tb['hotel_customer']."` c on c.id = l.customerid 
				WHERE l.isdelete = 0  
				and l.liabilities = 2
				and c.isdelete = 0
				$searchs
		";
		$query = $this->model->query($sql)->execute();
		return $query[0]->total;	
	}
	function saves($array){
		$tb = $this->base_model->loadTable();
		if(empty($array['price'])){
			return 0;
		}
		$array['price'] = fmNumberSave($array['price']);
		$array['expirationdate'] =  fmDateSave($array['expirationdate']);
		$uniqueid = $this->base_model->getUniqueid();
		$array['liabilities'] = 1;
		$array['orderid'] = -1;
		$array['branchid'] = $this->login->branchid;
		//Check exit;
		$checkExit = $this->model->table($tb['hotel_liabilities'])
						  ->select('id')
						  ->where('liabilities',1)
						  ->where('customerid',$array['customerid'])
						  ->find();
		if(!empty($checkExit->id)){
			return -1;
		}
		$this->model->table($tb['hotel_liabilities'])->insert($array);	
		return 1;
	}
	function edits($array,$id){
		$tb = $this->base_model->loadTable();
		if(empty($array['price'])){
			return 0;
		}
		$array['price'] = fmNumberSave($array['price']);
		$array['expirationdate'] =  fmDateSave($array['expirationdate']);
		$array['liabilities'] = 1;
		$array['branchid'] = $this->login->branchid;
		//Check exit;
		$checkExit = $this->model->table($tb['hotel_liabilities'])
						  ->select('id')
						  ->where('liabilities',1)
						  ->where('customerid',$array['customerid'])
						  ->where('id <>',$id)
						  ->find();
		if(!empty($checkExit->id)){
			return -1;
		}
		$this->model->table($tb['hotel_liabilities'])->where('id',$id)->update($array);	
		return 1;
	 }
	//Tạo phiếu thu
	function saveRecept($array,$id){
		$tb = $this->base_model->loadTable();
		//$this->db->trans_start();
		$branchid = $this->login->branchid;
		$insert = array();
		$datepo = fmDateSave($array['datepo']);
		$poid = $this->createPoReceipt($branchid,$datepo);
		$insert['receipts_code']  = $poid;
		$insert['poid']  = $poid; //thu khac
		$insert['branchid']  = $branchid; //thu khac
		$insert['amount'] = fmNumberSave($array['amount']);
		$insert['datecreate']  = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
		$insert['usercreate'] = $this->login->username;
		$insert['signature'] = $this->login->signature;
		$insert['signature_name'] = $this->login->fullname;
		$insert['notes'] = $array['notes'];
		$insert['payment'] = $array['payment'];
		$insert['receipts_type'] = 1; //công nợ đầu kỳ
		$insert['bankid'] = $array['bankid'];
		if(empty($array['bankid'])){
			$insert['bankid'] = 0;
		}
		if( $array['payment'] == 1){
			$insert['bankid'] = 0;
		}
		$insert['orderid'] = $id;
		$insert['datepo'] = $datepo;
		$this->model->table($tb['hotel_receipts'])->insert($insert);	
		
		$description = getLanguage('them-moi').': '.$poid;
		$this->base_model->addAcction(getLanguage('phieu-thu'),$this->uri->segment(2),'','',$description);
		return $poid;
	 }
	function findPOID($receipts_code){
		$tb = $this->base_model->loadTable();
		$query = $this->model->table($tb['hotel_receipts'])
					  ->select('*')
					  ->where('receipts_code',$receipts_code);
		$query = $query->find();
		return $query;
	}
	 //Tạo mã phiếu thu
	function createPoReceipt($branchid,$datecreate){//Phieu thu
		$tb = $this->base_model->loadTable();
		$yearDay = fmMonthSave($datecreate);
		$checkPOid = $this->model->table($tb['hotel_receipts'])
							 ->select('receipts_code')
							 ->where("datepo like '$yearDay%'")
							 //->where('branchid',$branchid)
							 ->where('isdelete',0)
							 ->order_by('id','DESC')
							 ->find();
		$cfpt = cfpt();
		if(!empty($checkPOid->receipts_code)){
			$poid = str_replace($cfpt,'',$checkPOid->receipts_code);
			$poc = (float)$poid;
		}
		else{
			$poc = date('ym',strtotime($yearDay)).'00000';
		}
		$receipts_code = $cfpt.($poc + 1);
		return $receipts_code;
	}
}