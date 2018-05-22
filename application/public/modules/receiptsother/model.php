<?php
/**
 * @author 
 * @copyright 2018
 */
 class ReceiptsotherModel extends CI_Model{
	function __construct(){
		parent::__construct('');
		$this->login = $this->site->getSession('login');
	}
	function getPays(){
		$tb = $this->base_model->loadTable();
		$query = $this->model->table($tb['hotel_receipts_type'])
					  ->select('id,receipts_type_name')
					  ->where('isdelete',0)
					  ->find_all();
		return $query;
	}
	function getSearch($search){
		$companyid = $this->login->companyid;
		$branchid = $this->login->branchid;
	
		$sql = "";
		$sql.= " and p.receipts_type = -1";
		if(!empty($branchid)){
			$sql.= " and p.branchid in (".$branchid.") ";	
		}
		else{
			if(!empty($search['branchid'])){
				$sql.= " and p.branchid in (".$search['branchid'].") ";	
			}
		}
		if(!empty($search['payment'])){
			$sql.= " and p.payment in (".$search['payment'].") ";	
		}
		if(!empty($search['bankid'])){
			$sql.= " and p.bankid in (".$search['bankid'].") ";	
		}
		if(!empty($search['notes'])){
			$sql.= " and p.notes like '%".$search['notes']."%' ";	
		}
		if(!empty($search['receipts_code'])){
			$sql.= " and p.receipts_code like '%".$search['receipts_code']."%' ";	
		}
		if(!empty($search['amount'])){
			$sql.= " and p.amount like '%".$search['amount']."%' ";	
		}
		if(!empty($search['formdate'])){
			$sql.= " and p.datepo = '".fmDateSave($search['formdate'])."' ";	
		}
		return $sql;
	}
	function getList($search,$page,$rows){
		$skey = $this->login->skey;
		$searchs = $this->getSearch($search);
		$companyid = $this->login->companyid;
		$skey = $this->login->skey;
		$tb = $this->base_model->loadTable();
		$sql = "
				SELECT p.*, rt.receipts_type_name, b.bank_name
				FROM `".$tb['hotel_receipts']."` p
				LEFT JOIN `".$tb['hotel_receipts_type']."` rt on rt.id = p.typeid
				LEFT JOIN `".$tb['hotel_bank']."` b on b.id = p.bankid
				where p.isdelete = 0
				$searchs
				";
		if(empty($search['order'])){
			$sql.= ' ORDER BY p.id DESC ';
		}
		else{
			$sql.= ' ORDER BY '.$search['order'].' '.$search['index'].' ';
		}
		if($rows != 0){
			$sql.= ' limit '.$page.','.$rows;
		}
		$query = $this->model->query($sql)->execute();
		return $query;
	}
	function getTotal($search){
		$searchs = $this->getSearch($search);
		$tb = $this->base_model->loadTable();
		$sql = "
				SELECT count(1) total
				FROM `".$tb['hotel_receipts']."` p
				LEFT JOIN `".$tb['hotel_receipts_type']."` rt on rt.id = p.typeid
				LEFT JOIN `".$tb['hotel_bank']."` b on b.id = p.bankid
				where p.isdelete = 0
				and rt.isdelete = 0
				$searchs
		";
		$query = $this->model->query($sql)->execute();
		return $query[0]->total;	
	}
	function saves($array){
		$datepo = $array['datecreate'];
		$tb = $this->base_model->loadTable();
		$skey = $this->login->skey;
		$companyid = $this->login->companyid;
		$branchid = $this->login->branchid;
		$array['datepo'] = fmDateSave($array['datecreate']); 
		$poid = $this->createPOPay($branchid,$datepo);
		$array['receipts_code']  = $poid;
		$array['amount'] = fmNumberSave($array['amount']);
		$array['datecreate']  = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
		$array['usercreate'] = $this->login->username;
		$array['receipts_type'] = -1; //Chi khác
		$array['signature'] = $this->login->signature;
		$array['signature_name'] = $this->login->fullname;
		$array['branchid'] = $branchid;
		$array['datecreate']  = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
		$this->model->table($tb['hotel_receipts'])->insert($array);	
		$description = getLanguage('them-moi').': '.$poid;
		$this->base_model->addAcction(getLanguage('chi-khac'),$this->uri->segment(2),'','',$description);
		
		return 1;
	}
	function edits($array,$id){
		//Xóa phiếu chi cũ
		$this->db->trans_start();
		$acction_before = $this->findID($id);
		$datepo = $array['datecreate'];
		$tb = $this->base_model->loadTable();
		$this->model->table($tb['hotel_receipts'])->where('id',$id)->delete();
		$skey = $this->login->skey;
		$branchid = $this->login->branchid;
		$array['datepo'] = fmDateSave($datepo);
		$array['branchid'] = $branchid;
		$array['receipts_type'] = -1; //Chi khác
		$array['receipts_code']  = $acction_before->receipts_code;
		$array['amount'] = fmNumberSave($array['amount']);
		$array['datecreate']  = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
		$array['usercreate'] = $this->login->username;
		$array['signature'] = $this->login->signature;
		$array['signature_name'] = $this->login->fullname;
		$this->model->table($tb['hotel_receipts'])->insert($array);
		
		$poid = '';
		if(!empty($acction_before->receipts_code)){
			$poid = $acction_before->receipts_code;
		}
		$description = getLanguage('sua').': '.$poid;
		$this->base_model->addAcction(getLanguage('chi-khac'),$this->uri->segment(2),json_encode($acction_before),json_encode($array),$description);
		
		
		$this->db->trans_complete();		
		return 1;
	 }
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
			$receipts_code = str_replace(cfpt(),'',$checkPOid->receipts_code);
			$poc = (float)$receipts_code;
		}
		else{
			$poc = date('ym',strtotime($yearDay)).'00000';
		}
		return cfpt().($poc + 1);
	}
	function findID($id){
		$tb = $this->base_model->loadTable();
		$query = $this->model->table($tb['hotel_receipts'])
					  ->select('*')
					  ->where('id',$id)
					  ->find();
		return $query;
	 }
	function payType($id){
		$tb = $this->base_model->loadTable();
		$query = $this->model->table($tb['hotel_receipts_type'])
					  ->select('*')
					  ->where('id',$id)
					  ->find();
		return $query;
	 }
}