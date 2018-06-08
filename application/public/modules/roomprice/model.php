<?php
/**
 * @author 
 * @copyright 2018
 */
 class RoompriceModel extends CI_Model{
	function __construct(){
		parent::__construct('');
		$this->login = $this->site->getSession('login');
	}
	function findID($id){
		$tb = $this->base_model->loadTable(); 
		$query = $this->model->table($tb['hotel_roomprice'])
					  ->select('*')
					  ->where('id',$id)
					  ->find();
		return $query;
	 }
	 function findListDetail($id){
		$tb = $this->base_model->loadTable(); 
		$query = $this->model->table($tb['hotel_roomprice_detail'])
					  ->select('*')
					  ->where('roompriceid',$id)
					  ->find_all();
		$array = array();
		foreach($query as $item){
			$array[$item->roomid]['price'] = $item->price;
			$array[$item->roomid]['price_night'] = $item->price_night;
			$array[$item->roomid]['price_week'] = $item->price_week;
			$array[$item->roomid]['price_month'] = $item->price_month;
			$array[$item->roomid]['price_hour'] = $item->price_hour;
			$array[$item->roomid]['price_hour_1'] = $item->price_hour_1;
			$array[$item->roomid]['price_hour_2'] = $item->price_hour_2;
			$array[$item->roomid]['price_hour_3'] = $item->price_hour_3;
			$array[$item->roomid]['price_hour_4'] = $item->price_hour_4;
			$array[$item->roomid]['price_hour_5'] = $item->price_hour_5;
			$array[$item->roomid]['price_hour_6'] = $item->price_hour_6;
			$array[$item->roomid]['price_hour_7'] = $item->price_hour_7;
		}
		return $array;
	 }
	 
	function getSearch($search){
		$sql = "";
		$branchid = $this->login->branchid;
		if(!empty($search['roomprice_name'])){
			$sql.= " and rt.roomprice_name  like '%".addslashes($search['roomprice_name'])."%' ";	
		}
		if(!empty($search['description'])){
			$sql.= " and rt.description  like '%".addslashes($search['description'])."%' ";	
		}
		if(!empty($branchid)){
			$sql.= " and rt.branchid  = '".$branchid."' ";	
		}
		else{
			if(!empty($search['branchid'])){
				$sql.= " and rt.branchid  in (".$search['branchid'].") ";	
			}
		}
		return $sql;
	}
	function getList($search,$page,$rows){
		$tb = $this->base_model->loadTable();
		$searchs = $this->getSearch($search);
		$sql = "SELECT rt.*,br.branch_name
				FROM `".$tb['hotel_roomprice']."` AS rt
				LEFT JOIN `".$tb['hotel_branch']."` br on br.id = rt.branchid
				WHERE rt.isdelete = 0 
				$searchs
				";
		if(empty($search['order'])){
			$sql.= ' ORDER BY rt.roomprice_name asc ';
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
		FROM `".$tb['hotel_roomprice']."` AS rt
		WHERE rt.isdelete = 0 
		$searchs	
		";
		$query = $this->model->query($sql)->execute();
		return $query[0]->total;	
	}
	function saves($array,$valueItem,$issave){
		$this->db->trans_begin();
		$tb = $this->base_model->loadTable();
		$branchid = $this->login->branchid;
		$check = $this->model->table($tb['hotel_roomprice'])
					  ->select('id')
					  ->where('isdelete',0)
					  ->where('roomprice_name',$array['roomprice_name'])
					  ->where('branchid',$branchid)
					  ->find();
		if(!empty($check->id)){
			return -1;	
		}
		$array['branchid'] = $branchid;
		$id = $this->model->table($tb['hotel_roomprice'])->save('',$array);	
		//if
		$theongay = $valueItem['theongay']; 
		$quadem = $valueItem['quadem']; 
		$theogio = $valueItem['theogio']; 
		
		$giothu1 = $valueItem['giothu1']; 
		$giothu2 = $valueItem['giothu2'];
		$giothu3 = $valueItem['giothu3'];
		$giothu4 = $valueItem['giothu4'];
		$giothu5 = $valueItem['giothu5'];
		$giothu6 = $valueItem['giothu6'];
		$giothu7 = $valueItem['giothu7'];
		
		$giotuan = $valueItem['giotuan']; 
		$giothang = $valueItem['giothang']; 
		
		if($issave == 1){//Láy giá phòng đầu ap cho toàn bộ các phòng
			$i = 1;
			$arrayDetail = array();
			foreach($theongay as $key=>$val){
				if($i == 1){
					$arrayDetail['price'] =  fmNumberSave(trim($val));
					$arrayDetail['price_night'] =  fmNumberSave(trim($quadem[$key]));
					$arrayDetail['price_week'] =  fmNumberSave(trim($giotuan[$key]));
					$arrayDetail['price_month'] =  fmNumberSave(trim($giothang[$key]));
					$arrayDetail['price_hour'] =  fmNumberSave(trim($theogio[$key]));
					$arrayDetail['price_hour_1'] =  fmNumberSave(trim($giothu1[$key]));
					$arrayDetail['price_hour_2'] =  fmNumberSave(trim($giothu2[$key]));
					$arrayDetail['price_hour_3'] =  fmNumberSave(trim($giothu3[$key]));
					$arrayDetail['price_hour_4'] =  fmNumberSave(trim($giothu4[$key]));
					$arrayDetail['price_hour_5'] =  fmNumberSave(trim($giothu5[$key]));
					$arrayDetail['price_hour_6'] =  fmNumberSave(trim($giothu6[$key]));
					$arrayDetail['price_hour_7'] =  fmNumberSave(trim($giothu7[$key]));
				}
				if($i > 1){
					break;
				}
				$i++;
			}
			$arrayDetail['branchid'] = $branchid;
			$arrayDetail['roompriceid'] = $id; 
			foreach($theongay as $key=>$val){
				$arrayDetail['roomid'] = $key;
				$this->model->table($tb['hotel_roomprice_detail'])->insert($arrayDetail);	
			}
		}
		else{
			$arrayDetail = array();
			foreach($theongay as $key=>$val){
				$arrayDetail['price'] =  fmNumberSave(trim($val));
				if(!empty($val)){
					$arrayDetail['price_night'] =  fmNumberSave(trim($quadem[$key]));
					$arrayDetail['price_week'] =  fmNumberSave(trim($giotuan[$key]));
					$arrayDetail['price_month'] =  fmNumberSave(trim($giothang[$key]));
					$arrayDetail['price_hour'] =  fmNumberSave(trim($theogio[$key]));
					$arrayDetail['price_hour_1'] =  fmNumberSave(trim($giothu1[$key]));
					$arrayDetail['price_hour_2'] =  fmNumberSave(trim($giothu2[$key]));
					$arrayDetail['price_hour_3'] =  fmNumberSave(trim($giothu3[$key]));
					$arrayDetail['price_hour_4'] =  fmNumberSave(trim($giothu4[$key]));
					$arrayDetail['price_hour_5'] =  fmNumberSave(trim($giothu5[$key]));
					$arrayDetail['price_hour_6'] =  fmNumberSave(trim($giothu6[$key]));
					$arrayDetail['price_hour_7'] =  fmNumberSave(trim($giothu7[$key]));
					$arrayDetail['branchid'] = $branchid;
					$arrayDetail['roompriceid'] = $id;
					$arrayDetail['roomid'] = $key;
					$this->model->table($tb['hotel_roomprice_detail'])->insert($arrayDetail);	
				}
			}
		}
		
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return 0;
		}
		else{
			$this->db->trans_commit();
			return 1;
		}
		
	}
	function edits($array,$id,$valueItem,$issave){
		$this->db->trans_begin();
		$tb = $this->base_model->loadTable();
		$branchid = $this->login->branchid;
		$check = $this->model->table($tb['hotel_roomprice'])
							 ->select('id')
							 ->where('isdelete',0)
							 ->where('id <>',$id)
							 ->where('roomprice_name',$array['roomprice_name'])
							 ->where('branchid',$branchid)
							 ->find();
		if(!empty($check->id)){
			return -1;	
		}
		$array['branchid'] = $branchid;
		$result = $this->model->table($tb['hotel_roomprice'])->where('id',$id)->update($array);	
		$theongay = $valueItem['theongay']; 
		$theogio = $valueItem['theogio']; 
		$quadem = $valueItem['quadem']; 
		$giothu1 = $valueItem['giothu1']; 
		$giothu2 = $valueItem['giothu2'];
		$giothu3 = $valueItem['giothu3'];
		$giothu4 = $valueItem['giothu4'];
		$giothu5 = $valueItem['giothu5'];
		$giothu6 = $valueItem['giothu6'];
		$giothu7 = $valueItem['giothu7'];
		
		$giotuan = $valueItem['giotuan']; 
		$giothang = $valueItem['giothang'];  
		$this->model->table($tb['hotel_roomprice_detail'])->where('roompriceid',$id)->delete();
		if($issave == 1){//Láy giá phòng đầu ap cho toàn bộ các phòng
			$i = 1;
			$arrayDetail = array();
			foreach($theongay as $key=>$val){
				if($i == 1){
					$arrayDetail['price'] =  fmNumberSave(trim($val));
					$arrayDetail['price_night'] =  fmNumberSave(trim($quadem[$key]));
					$arrayDetail['price_week'] =  fmNumberSave(trim($giotuan[$key]));
					$arrayDetail['price_month'] =  fmNumberSave(trim($giothang[$key]));
					$arrayDetail['price_hour'] =  fmNumberSave(trim($theogio[$key]));
					$arrayDetail['price_hour_1'] =  fmNumberSave(trim($giothu1[$key]));
					$arrayDetail['price_hour_2'] =  fmNumberSave(trim($giothu2[$key]));
					$arrayDetail['price_hour_3'] =  fmNumberSave(trim($giothu3[$key]));
					$arrayDetail['price_hour_4'] =  fmNumberSave(trim($giothu4[$key]));
					$arrayDetail['price_hour_5'] =  fmNumberSave(trim($giothu5[$key]));
					$arrayDetail['price_hour_6'] =  fmNumberSave(trim($giothu6[$key]));
					$arrayDetail['price_hour_7'] =  fmNumberSave(trim($giothu7[$key]));
				}
				if($i > 1){
					break;
				}
				$i++;
			}
			$arrayDetail['branchid'] = $branchid;
			$arrayDetail['roompriceid'] = $id;
			foreach($theongay as $key=>$val){
				$arrayDetail['roomid'] = $key;
				$this->model->table($tb['hotel_roomprice_detail'])->insert($arrayDetail);	
			}
		}
		else{
			$arrayDetail = array();
			foreach($theongay as $key=>$val){
				$arrayDetail['price'] =  fmNumberSave(trim($val));
				if(!empty($val)){
					$arrayDetail['price_night'] =  fmNumberSave(trim($quadem[$key]));
					$arrayDetail['price_week'] =  fmNumberSave(trim($giotuan[$key]));
					$arrayDetail['price_month'] =  fmNumberSave(trim($giothang[$key]));
					$arrayDetail['price_hour'] =  fmNumberSave(trim($theogio[$key]));
					$arrayDetail['price_hour_1'] =  fmNumberSave(trim($giothu1[$key]));
					$arrayDetail['price_hour_2'] =  fmNumberSave(trim($giothu2[$key]));
					$arrayDetail['price_hour_3'] =  fmNumberSave(trim($giothu3[$key]));
					$arrayDetail['price_hour_4'] =  fmNumberSave(trim($giothu4[$key]));
					$arrayDetail['price_hour_5'] =  fmNumberSave(trim($giothu5[$key]));
					$arrayDetail['price_hour_6'] =  fmNumberSave(trim($giothu6[$key]));
					$arrayDetail['price_hour_7'] =  fmNumberSave(trim($giothu7[$key]));
					$arrayDetail['branchid'] = $branchid;
					$arrayDetail['roompriceid'] = $id;
					$arrayDetail['roomid'] = $key;
					$this->model->table($tb['hotel_roomprice_detail'])->insert($arrayDetail);	
				}
			}
		}
		
		 if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return 0;
		}
		else{
			$this->db->trans_commit();
			return $id;
		}
	 }
	function getRoomList(){
		$login = $this->login;
		$tb = $this->base_model->loadTable();
		$and = "";
		if(!empty($login->branchid)){
			$and = " and r.branchid = '".$login->branchid ."'";
		}
		$sql = "
			select r.*
				from `".$tb['hotel_room']."` r
				where r.isdelete = 0
				$and
				order by r.room_name asc
		";
		$query =  $this->model->query($sql)->execute();
		return $query;
	}
}