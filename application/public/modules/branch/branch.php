<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author  
 * @copyright 2015
 */
class Branch extends CI_Controller {
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
		$data->count_branch = $login->count_branch; 
	    $data->permission = $permission;
		$data->total = $this->model->getTotal(array()); //print_r($data); exit;
		$data->csrfName = $this->security->get_csrf_token_name();
		$data->csrfHash = $this->security->get_csrf_hash();		
	    $data->controller = base_url().$this->route;
		$data->routes = $this->route;
		$data->provinces = $this->base_model->getProvince();
		//$data->districs = $this->base_model->getDistric('');		
		$content = $this->load->view('view',$data,true);
		$this->site->write('content',$content,true);
		$this->site->write('title',getLanguage('khach-san'),true);
        $this->site->render();
	}
	function form(){
		$login = $this->login;
		$id = $this->input->post('id');
		$find = $this->model->findID($id);
		if(empty($find->id)){
			$tbs = $this->base_model->loadTable();
			$find = $this->base_model->getColumns($tbs['hotel_branch']);
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
		$data->branchid = $login->branchid;
		$data->branchs = $this->base_model->getBranch($login->branchid);	
        $result->content = $this->load->view('form', $data, true);
		$result->id = $id;
        echo json_encode($result); exit;
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
		foreach($searchss as $key=>$val){
			$searchs[$key] = addslashes($val); 
		}
		$data = new stdClass();
		$result = new stdClass();
		$query = $this->model->getList($searchs,$page,$rows);
		$count = $this->model->getTotal($searchs);
		$data->datas = $query;
		$data->start = $start;
		$data->permission = $this->base_model->getPermission($this->login, $this->route);
		
		$page_view=$this->site->pagination($count,$rows,5,$this->route,$page);
		$result->paging = $page_view;
		$result->csrfHash = $this->security->get_csrf_hash();
		$result->viewtotal = number_format($count); 
        $result->content = $this->load->view('list', $data, true);
		echo json_encode($result);
	}
	function save() {
		$result = array();
		$token =  $this->security->get_csrf_hash();
		$permission = $this->base_model->getPermission($this->login, $this->route);
		
		if (!isset($permission['add'])){
			$result['status'] = 0;
			$result['csrfHash'] = $token;
			echo json_encode($result); exit;	
		}
		$arrays = json_decode($this->input->post('search'),true);
		$array = array();
		foreach($arrays as $key=>$val){
			$array[$key] = addslashes($val); 
		}
		$login = $this->login;
		$count_branch = $login->count_branch;
		$total = $this->model->getTotal(array());
		if($total < $count_branch){
			$array['datecreate']  = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
			$array['usercreate'] = $this->login->username;
			$result['status'] =$this->model->saves($array);
			$description = getLanguage('them-moi').': '.$array['branch_name'];
			$this->base_model->addAcction(getLanguage('khach-san'),$this->uri->segment(2),'','',$description);
			echo json_encode($result); exit;
		}
		else{
			$result['status'] = -2;
			$result['count_branch'] = $count_branch;
			echo json_encode($result); exit;	
		}
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
		$arrays = json_decode($this->input->post('search'),true);
		$array = array();
		foreach($arrays as $key=>$val){
			$array[$key] = addslashes($val); 
		}
		$id = $this->input->post('id');
		$login = $this->login;
		$acction_before = $this->model->findID($id);
		$array['dateupdate']  = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
		$array['userupdate'] = $this->login->username;
		//$array['ipupdate'] = $this->base_model->getMacAddress();
		$result['status'] =$this->model->edits($array,$id);
		
		$arr_log['func'] = $this->uri->segment(2);
		$description = getLanguage('sua').': '.$array['branch_name'];
		$this->base_model->addAcction(getLanguage('khach-san'),$this->uri->segment(2),json_encode($acction_before),json_encode($array),$description);
		
		$result['csrfHash'] = $token;
		echo json_encode($result);
	}
	function deletes() {
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
		$checkExitInv = $this->model->table($tb['hotel_inventory'])
									  ->select('branchid')
									  ->where("branchid in ($id)")
									  ->where('isdelete',0)
									  ->find();
		if(!empty($checkExitInv->branchid)){
			$result['status'] = -1;	
			$result['csrfHash'] = $token;
			echo json_encode($result); exit;
		}
		#end
		$this->model->table($tb['hotel_branch'])
						->where("id in ($id)")
						->update($array);	
		
		$queryDelete = $this->model->table($tb['hotel_branch'])
					->select('group_concat(branch_name) as deletes')
					->where("id in ($id)")
					->find();
		$description = getLanguage('xoa').": ".$queryDelete->deletes;
		$this->base_model->addAcction(getLanguage('khach-san'),$this->uri->segment(2),'','',$description);
		
		$result['status'] = 1;	
		$result['csrfHash'] = $token;
		echo json_encode($result);
	}
	function getDistric(){
		$provinceid = $this->input->post('provinceid');
		$districs = $this->base_model->getDistric($provinceid);				
		$html = '<select id="districid" class="combo" name="districid"><option value=""></option>';
		foreach($districs as $item){
			$html.= '<option value="'.$item->id .'">'.$item->distric_name .'</option>';
		}
		$html.= '</select>';
		echo $html;
	}
}