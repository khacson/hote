<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author  
 * @copyright 2018
 */
class Liabilitiessale extends CI_Controller {
    private $route;
	private $login;
	function __construct(){
		parent::__construct();	
		$this->load->model(array('model','base_model'));
		$this->login = $this->site->getSession('login');
		$this->route = $this->router->class;
		$menus = $this->site->getSession('menus');
		$this->title = $menus[$this->route];
	}
	function _remap($method, $params = array()) {
        if (method_exists($this, $method)) {
            return call_user_func_array(array($this, $method), $params);
        }
        $this->_view();
    }
	function _view(){
		$data = new stdClass();
		$permission = $this->base_model->getPermission($this->login, $this->route);
		if (!isset($permission['view'])) {
	    	//redirect('authorize');
	    }
		$login = $this->login;
		$companyid = $this->login->companyid;
		
	    $data->permission = $permission;
		$data->csrfName = $this->security->get_csrf_token_name();
		$data->csrfHash = $this->security->get_csrf_hash();		
	    $data->controller = base_url().$this->route;
		$data->routes = $this->route;
		
		$data->customers = $this->base_model->getCustomer();	
		$content = $this->load->view('view',$data,true);
		$this->site->write('content',$content,true);
		$this->site->write('title',getLanguage('cong-no-ban-hang'),true);
        $this->site->render();
	}
	function form(){
		$login = $this->login;
		$id = $this->input->post('id');
		$find = $this->model->findID($id);
		if(empty($find->id)){
			$tb = $this->base_model->loadTable();
			$find = $this->base_model->getColumns($tb['hotel_liabilities']);
		}
		$data = new stdClass();
        $result = new stdClass();
		$data->finds = $find;  
		if(empty($id)){
			$result->title = getLanguage('them-moi');
		}
		else{
			$result->title = getLanguage('sua');
		}
		$data->title = $result->title;
		$data->details = $this->model->findDetail($id);
		$data->customers = $this->base_model->getCustomer();	
		$data->branchid = $login->branchid;
        $result->content = $this->load->view('form', $data, true);
		$result->id = $id;
        echo json_encode($result);
	}
	function formPay(){
		$login = $this->login;
		$id = $this->input->post('id');
		$find = $this->model->findID($id);
		$tb = $this->base_model->loadTable();
		if(empty($find->id)){
			$find = $this->base_model->getColumns($tb['hotel_liabilities']);
		}
		$data = new stdClass();
        $result = new stdClass();
		$data->finds = $find;  
		if(empty($id)){
			$result->title = getLanguage('them-moi');
		}
		else{
			$result->title = getLanguage('sua');
		}
		$customerid = $find->customerid;
		$data->customers = $this->model->table($tb['hotel_customer'])
						  ->select('id,customer_name')
						  ->where('id',$customerid)
						  ->find();
		
		$data->title = $result->title;
		$details = $this->model->findDetail($id);
		$amount = 0;
		foreach($details as $item){
			$amount+= $item->amount;
		}
		$data->details = $details;
		$data->amount = $amount;
		$data->banks = $this->base_model->getBank();	
		$data->branchid = $login->branchid;
        $result->content = $this->load->view('formPay', $data, true);
		$result->id = $id;
        echo json_encode($result);
	}
	function getList(){
		$rows = 20; //$this->site->config['row'];
		$page = $this->input->post('page');
        $pageStart = $page * $rows;
        $rowEnd = ($page + 1) * $rows;
		$start = empty($page) ? 1 : $page+1;
		$searchss = json_decode($this->input->post('search'),true);
		$searchss['order'] = substr($this->input->post('order'),4);
		$searchss['index'] = $this->input->post('index');
		$data = new stdClass();
		$result = new stdClass();
		$searchs = array();
		foreach($searchss as $key=>$val){
			$searchs[$key] = addslashes($val); 
		}
		$query = $this->model->getList($searchs,$page,$rows);
		$count = $this->model->getTotal($searchs);
		$data->datas = $query;
		$data->start = $start;
		$data->permission = $this->base_model->getPermission($this->login, $this->route);
		//print_r($query); exit;
		$page_view=$this->site->pagination($count,$rows,5,$this->route,$page);
		$result->paging = $page_view;
		$result->csrfHash = $this->security->get_csrf_hash();
		$result->viewtotal = number_format($count); 
        $result->content = $this->load->view('list', $data, true);
		echo json_encode($result);
	}
	function save() {
		$token =  $this->security->get_csrf_hash();
		$permission = $this->base_model->getPermission($this->login, $this->route);
		
		$result = array();
		if (!isset($permission['add'])){
			$result['status'] = 0;
			$result['csrfHash'] = $token;
			echo json_encode($result); exit;	
		}
		$array = json_decode($this->input->post('search'),true);
		$login = $this->login;
		$array['datecreate']  = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
		$array['usercreate'] = $this->login->username;
		$result['status'] =$this->model->saves($array);
		$description = getLanguage('them-moi');
		$this->base_model->addAcction(getLanguage('cong-no-ban-hang'),$this->uri->segment(2),'','',$description);
		$result['csrfHash'] = $token;
		echo json_encode($result);
	}
	function edit() {
		$token =  $this->security->get_csrf_hash();
		$permission = $this->base_model->getPermission($this->login, $this->route);
		if (!isset($permission['edit'])){
			$result['status'] = 0;
			$result['csrfHash'] = $token;
			echo json_encode($result); exit;	
		}
		$array = json_decode($this->input->post('search'),true);
		$id = $this->input->post('id');
		$login = $this->login;
		$acction_before = $this->model->findID($id);
		$array['dateupdate']  = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
		$array['userupdate'] = $this->login->username;
		//$array['ipupdate'] = $this->base_model->getMacAddress();
		$result['status'] =$this->model->edits($array,$id);
		
		$arr_log['func'] = $this->uri->segment(2);
		$description = getLanguage('sua');;
		$this->base_model->addAcction(getLanguage('cong-no-ban-hang'),$this->uri->segment(2),json_encode($acction_before),json_encode($array),$description);
		$result['csrfHash'] = $token;
		echo json_encode($result);
	}
	function deletes(){
		$token =  $this->security->get_csrf_hash();
		$permission = $this->base_model->getPermission($this->login, $this->route);
		if (!isset($permission['delete'])){
			$result['status'] = 0;
			$result['csrfHash'] = $token;
			echo json_encode($result); exit;	
		}
		$tb = $this->base_model->loadTable();
		$id = $this->input->post('id');//print_r($id);exit;
		$login = $this->login;
		$array['dateupdate']  = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
		$array['isdelete'] = 1;
		$array['userupdate'] = $this->login->username;
		#region check edit
		$finds = $this->model->findID($id);
		$checkExit = $this->model->table($tb['hotel_receipts'])
									  ->select('uniqueid')
									  ->where('isdelete',0)
									  ->where('uniqueid',$finds->uniqueid)
									  ->find();
		if(!empty($checkExit->uniqueid)){
			$result['status'] = -1;	
			$result['csrfHash'] = $token;
			echo json_encode($result); exit;
		}
		#end
		$acction_before = $this->model->findID($id);
		$this->model->table($tb['hotel_liabilities'])
					->where('id',$id)
					->delete();
		$description = getLanguage('xoa').": ".$finds->uniqueid;
		$this->base_model->addAcction(getLanguage('cong-no-ban-hang'),$this->uri->segment(2),json_encode($acction_before),'',$description);
		
		$result['status'] = 1;	
		$result['csrfHash'] = $token;
		echo json_encode($result);
	}
	function getDetail(){
		$id = $this->input->post('id');
		$result = new stdClass();
		$data = new stdClass();
		$data->details = $this->model->findDetail($id);
		$result->content = $this->load->view('listdetail', $data, true);
		echo json_encode($result); exit;
	}
	function saveRecept(){
		$tb = $this->base_model->loadTable();
		$id = $this->input->post('id');
		$amount = $this->input->post('money');
		$description = $this->input->post('description');
		$payment = $this->input->post('payment');
		$bankid = $this->input->post('bankid');
		$datepo =  $this->input->post('datepo');
		$array = array();
		$array['notes'] = $description;
		$array['amount'] = $amount;
		$array['payment'] = $payment;
		$array['bankid'] = $bankid;
		$array['datepo'] = $datepo;
		$poid = $this->model->saveRecept($array,$id);
		echo $poid;		
		//Tao phieu thu
	}
	function getDataPrintPT(){
		$ptid = $this->input->post('ptid');
		$result = $data = new stdClass();
		$data->company = $this->login->company_name;
		$data->login = $this->login;
		$dataprint = $this->model->findPOID($ptid); 
		if(empty($dataprint->id)){
			exit;
		}
		/*
		$type = $this->model->payType($dataprint->receipts_type);
		
		if(!empty($type->receipts_type_name)){
			$data->type = $type->receipts_type_name;
		}
		else{
			$data->type = '';
		}*/
		$data->datas = $dataprint;
		$data->type = '';
		$data->fmprice = $this->base_model->docso($dataprint->amount);
		$result->content = $this->load->view('printpt', $data, true);
		echo json_encode($result);
	}
}