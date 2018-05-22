<?php
 class BackupdbModel extends CI_Model{
	function __construct(){
		parent::__construct('hotel_backupdb');
	}
	function getSearch($search){
		$sql = "";
		if (!empty($search['fromdate'])) {
			$sql .= " AND datecreate >= '".$search['fromdate']."' ";
		}
		if (!empty($search['todate'])) {
			$sql .= " AND datecreate <= '".$search['todate']."' ";
		}
		return $sql;
	}
	function getList($search,$page,$numrows){
		$sql = "SELECT *
                        FROM hotel_backupdb
                        WHERE isdelete = 0";
		$sql.= $this->getSearch($search);
        if(empty($search['order'])){
			$sql .= " ORDER BY id DESC ";
		}
		else{
			$sql.= " ORDER BY ".$search['order']." ".$search['index']." ";
		} 
        $sql.= ' limit '.$page.','.$numrows;
		
		return $this->model->query($sql)->execute();
	}
	function getTotal($search){
		$sql = " SELECT COUNT(1) AS total
				FROM hotel_backupdb
				WHERE isdelete = 0 ";
		$sql.= $this->getSearch($search);
		$query = $this->model->query($sql)->execute();
		if(empty($query[0]->total)){
			return 0;
		}
		else{
			return $query[0]->total;
		}
	}
	function export($search){
		return $this->getList($search);
	}
	function saves($array){
		 $check = $this->model->table('hotel_manufacture')
		 ->select('id')
		 ->where('isdelete',0)
		 ->where('manufacture_name',$array['manufacture_name'])
		 ->find();
		 if(!empty($check->id)){
			 return -1;	
		 }
                 unset($array['fromdate']);
                 unset($array['todate']);
		 $result = $this->model
						->table('hotel_manufacture')
						->insert($array);	
		 return $result;
	}
	function edits($array,$id){
		 $check = $this->model->table('hotel_manufacture')
		 ->select('id')
		 ->where('isdelete',0)
		 ->where('manufacture_name',$array['manufacture_name'])
		 ->where('id <>',$id)
		 ->find();
		 if(!empty($check->id)){
			 return -1;	
		 }//print_r($array);exit;
		 unset($array['fromdate']);
                 unset($array['todate']);
		 $result = $this->model->table('hotel_manufacture')->save($id,$array);	
		 return $result;
	}
	
}