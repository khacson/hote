<?php
/**
 * @author 
 * @copyright 2018
 */
 class OrderroomhistoryModel extends CI_Model{
	function __construct(){
		parent::__construct('');
		$this->login = $this->site->getSession('login');
	}
	function findID($oderromid){
		$tb = $this->base_model->loadTable(); 
		$sql = "
			SELECT c.* 
			FROM `".$tb['hotel_customer_history']."` ch
			left join `".$tb['hotel_customer']."` c on c.id = ch.customerid
			where ch.oderromid = '$oderromid'
			;
		";
		$query = $this->model->query($sql)->execute();
		return $query;
	}
	function getPriceType(){
		$login = $this->login;
		$tb = $this->base_model->loadTable();
        $query = $this->model->table($tb['hotel_roomprice'])
					  ->select('id,roomprice_name')
					  ->where('branchid',$login->branchid)
					  ->find_combo('id','roomprice_name');
		$query['0'] = getLanguage('gia-chuan');
		$query['-1'] = getLanguage('thuong-luong');
        return $query;
	}
	function getPriceList() {
		$login = $this->login;
		$tb = $this->base_model->loadTable();
        $query = $this->model->table($tb['hotel_roomprice'])
					  ->select('id,roomprice_name')
					  ->where('isdelete',0)
					  ->where('branchid',$login->branchid)
					  ->order_by('roomprice_name')
					  ->find_all();
        return $query;
    }
	function getSearch($search){
		$sql = "";
		$branchid = $this->login->branchid;
		if(!empty($search['room_name'])){
			$sql.= " and r.room_name  like '%".($search['room_name'])."%' ";	
		}
		if(!empty($search['roomtypeid'])){
			$sql.= " and rt.id  in (".$search['roomtypeid'].") ";	
		}
		if(!empty($search['formdate'])){
			$sql.= " and odh.datecreate >= '".fmDateSave($search['formdate'])." 00:00:00' ";	
		}
		if(!empty($search['todate'])){
			$sql.= " and odh.datecreate <= '".fmDateSave($search['todate'])." 23:59:00' ";	
		}
		if(!empty($search['description'])){
			$sql.= " and odh.description  like '%".($search['description'])."%' ";	
		}
		if(!empty($search['price'])){
			$sql.= " and odh.price  like '%".($search['price'])."%' ";	
		}
		if(!empty($search['customer_phone'])){
			$sql.= " and odh.customer_phone  like '%".($search['customer_phone'])."%' ";	
		}
		if(!empty($search['customer_name'])){
			$sql.= " and odh.customer_name  like '%".($search['customer_name'])."%' ";	
		}
		if(!empty($search['customer_phone'])){
			$sql.= " and odh.customer_phone  like '%".($search['customer_phone'])."%' ";	
		}
		if(!empty($branchid)){
			$sql.= " and odh.branchid  = '".$branchid."' ";	
		}
		else{
			if(!empty($search['branchid'])){
				$sql.= " and odh.branchid  in (".$search['branchid'].") ";	
			}
		}
		return $sql;
	}
	function getList($search,$page,$rows){
		$tb = $this->base_model->loadTable();
		$searchs = $this->getSearch($search);
		$sql = "
				select odh.*, r.room_name, rt.roomtype_name,
				(
					select count(1) t
					from `".$tb['hotel_customer_history']."` ch
					where ch.oderromid = odh.id
				) total, br.branch_name
				from `".$tb['hotel_orderroom']."` odh
				left join `".$tb['hotel_room']."`  r on r.id = odh.roomid
				left join `".$tb['hotel_roomtype']."` rt on rt.id = r.roomtypeid
				LEFT JOIN `".$tb['hotel_branch']."` br on br.id = odh.branchid
				where odh.isdelete = 0
				$searchs
				";
		if(empty($search['order'])){
			$sql.= ' ORDER BY odh.datecreate desc ';
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
				select count(1) total
				from `".$tb['hotel_orderroom']."` odh
				left join `".$tb['hotel_room']."`  r on r.id = odh.roomid
				left join `".$tb['hotel_roomtype']."` rt on rt.id = r.roomtypeid
				where odh.isdelete = 0
				$searchs
				";
		$query = $this->model->query($sql)->execute();
		return $query[0]->total;	
	}
	function saves($array){
		$this->db->trans_begin();
		$tb = $this->base_model->loadTable();
		$branchid = $this->login->branchid;
		$check = $this->model->table($tb['hotel_roomtype'])
					  ->select('id')
					  ->where('isdelete',0)
					  ->where('roomtype_name',$array['roomtype_name'])
					  ->where('branchid',$branchid)
					  ->find();
		if(!empty($check->id)){
			return -1;	
		}
		$result = $this->model->table($tb['hotel_roomtype'])->insert($array);	
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
		 $tb = $this->base_model->loadTable();
		 $branchid = $this->login->branchid;
		 $check = $this->model->table($tb['hotel_roomtype'])
							 ->select('id')
							 ->where('isdelete',0)
							 ->where('id <>',$id)
							 ->where('roomtype_name',$array['roomtype_name'])
							 ->where('branchid',$branchid)
							 ->find();
		 if(!empty($check->id)){
			 return -1;	
		 }
		 $result = $this->model->table($tb['hotel_roomtype'])->where('id',$id)->update($array);	
		 if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return 0;
		}
		else{
			$this->db->trans_commit();
			return $id;
		}
	 }
}