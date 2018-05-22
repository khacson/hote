<?php
/**
 * @author Sonnk
 * @copyright 2015
 */
 
class incModelMenuright extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	function getOrders(){
		$login = $this->site->getSession('login');
		$tb = $this->base_model->loadTable();
		$query = $this->model->table($tb['hotel_output'])
							 ->select('poid,uniqueid,quantity')
							 ->where('branchid',$login->branchid)
							 ->where('isout',0)
							 ->where('isdelete',0)
							 ->find_all();
		return $query;
	}
}