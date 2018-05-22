<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @author 
 * @copyright 2015
 */
class User extends CI_Controller {
    private $route;
	private $login;
	function __construct(){
		parent::__construct();	
		$this->load->model(array('model','base_model'));
		$this->login = $this->site->getSession('login');
		$this->route = $this->router->class;
		$menus = $this->site->getSession('menus');
		$this->title = $menus[$this->route];
		$this->load->library('upload');
	}
	function _remap($method, $params = array()) {
        if (method_exists($this, $method)) {
            return call_user_func_array(array($this, $method), $params);
        }
        $this->_view();
    }
	function _view(){
		$data = new stdClass();
		$login = $this->login;
		$permission = $this->base_model->getPermission($login, $this->route);
		if (!isset($permission['view'])) {
	    	redirect('authorize');
	    }
		//print_r($this->login);
		$companyid = $login->companyid;
		$data->grouptype = $login->grouptype;
		$data->iswarehouse = $login->count_room;
		$data->isbranh = $login->count_branch;
		//$orgeducationid = $this->login->orgeducationid;
	    $data->permission = $permission;
		$data->companyid = $companyid;
		$data->csrfName = $this->security->get_csrf_token_name();
		$data->csrfHash = $this->security->get_csrf_hash();
		$data->routes = $this->route;
		$data->login = $login;
	    $data->controller = base_url().($this->uri->segment(1));
		$data->branchs = $this->base_model->getBranch('',$companyid);
	    $data->groups = $this->model->getGroupList($companyid);
		$data->departments = $this->base_model->getDepartment($login->departmentid);
		$content = $this->load->view('view',$data,true);
		$this->site->write('content',$content,true);
		$this->site->write('title',$this->title,true);
        $this->site->render();
	}
	function form(){
		$login = $this->login;
		$id = $this->input->post('id');
		$find = $this->model->findID($id);
		if(empty($find->id)){
			$find = $this->base_model->getColumns('hotel_users');
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
		$data->groups = $this->model->getGroupList($login->companyid);
		$data->departments = $this->base_model->getDepartment($login->departmentid);
        $result->content = $this->load->view('form', $data, true);
		$result->id = $id;
        echo json_encode($result);
	}
	function getList(){
		if(!isset($_POST['csrf_stock_name'])){
			//show_404();
		}
		$param = array();
		$numrows = 20; 
		$data = new stdClass();

		$page = $this->input->post('page'); 
		$search = $this->input->post('search');
		$search = json_decode($search,true);
		$search = $this->model->changueSearch($search);
		$query = $this->model->getList($search,$page,$numrows);
		$data->start = empty($page) ? 1 : $page + 1;

		$count = $this->model->getTotal($search);
		$data->datas = $query;
		$page_view=$this->site->pagination($count,$numrows,5,'user/',$page);
		$data->permission = $this->base_model->getPermission($this->login, $this->route);
		$result = new stdClass();
		$result->paging = $page_view;
        $result->cPage = $page;
		$result->viewtotal = $count; 
		$data->permission = $this->base_model->getPermission($this->login, $this->route);
		$result->csrfHash = $this->security->get_csrf_hash();
        $result->content = $this->load->view('list', $data, true);
		echo json_encode($result);
	}
	function getDetail(){
		$id = $this->input->get('id');
		if (!empty($id)) {
			$user = $this->model->table('hotel_users')->where('id', $id)->find();
			echo json_encode($user);
		}
	}
	function save() {
		
		$permission = $this->base_model->getPermission($this->login, $this->route);
		$token =  $this->security->get_csrf_hash();
		$array = json_decode($this->input->post('search'),true);
		$array = $this->model->changueSearch($array);//print_r($array);exit;
		if (!isset($permission['add'])){
			$result['status'] = 0;
			$result['csrfHash'] = $token;
			echo json_encode($result); exit;	
		}
		if(isset($_FILES['userfile']) && $_FILES['userfile']['name'] != "") {
			$imge_name = $_FILES['userfile']['name'];
			$this->upload->initialize($this->set_upload_options());
			$image_data = $this->upload->do_upload('userfile', $imge_name); //Ten hinh 
			$array['image']  = $image_data;
			$resize = $this->resizeImg($image_data);	
		}
		if(isset($_FILES['userfiles']) && $_FILES['userfiles']['name'] != "") {
			$imge_name = $_FILES['userfiles']['name'];
			$this->upload->initialize($this->set_upload_options());
			$image_data = $this->upload->do_upload('userfiles', $imge_name); //Ten hinh 
			$array['signature']  = $image_data;
			$resize = $this->resizeImg($image_data);	
		}
		$login = $this->login;
		$array['datecreate']  = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
		$array['usercreate'] = $login->username;
		$result['status'] =$this->model->saves($array);
		$this->base_model->addAcction($this->route,$this->uri->segment(2),'',json_encode($array));
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
		$array = $this->model->changueSearch($array);
		$id = $this->input->post('id');
		$login = $this->login;
		if(isset($_FILES['userfile']) && $_FILES['userfile']['name'] != "") {
			$imge_name = $_FILES['userfile']['name'];
			$this->upload->initialize($this->set_upload_options());
			$image_data = $this->upload->do_upload('userfile', $imge_name); //Ten hinh 
			$array['image']  = $image_data;
			$resize = $this->resizeImg($image_data);	
		}
		if(isset($_FILES['userfiles']) && $_FILES['userfiles']['name'] != "") {
			$imge_name = $_FILES['userfiles']['name'];
			$this->upload->initialize($this->set_upload_options());
			$image_data = $this->upload->do_upload('userfiles', $imge_name); //Ten hinh 
			$array['signature']  = $image_data;
			$resize = $this->resizeImg($image_data);	
		}
		if(empty($array['password'])){
			 unset($array['password']);
		}
		$array['dateupdate']  = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
		$array['userupdate'] = $login->username;
		$acction_before = $this->model->base_model->findID('hotel_users',$id);
		$this->base_model->addAcction($this->route,$this->uri->segment(2),json_encode($acction_before),json_encode($array));
		$result['status'] =$this->model->edits($array,$id);
		$result['csrfHash'] = $token;
		echo json_encode($result);
	}
	function resizeImg($image_data) {
        $this->load->library('image_lib');
        $configz = array();
        $configz['image_library'] = 'gd2';
        $configz['source_image'] = './files/user/' . $image_data;
        $configz['new_image'] = './files/user/' . $image_data;
        $configz['create_thumb'] = TRUE;
        $configz['maintain_ratio'] = TRUE;
        $configz['width'] = 100;
        $configz['height'] = 100;
		
        $this->image_lib->initialize($configz);
        $this->image_lib->resize();
        $this->image_lib->clear();
    }
	private function set_upload_options() {
        $config = array();
        $config['allowed_types'] = 'jpg|jpeg|gif|png';
        $config['upload_path'] = './files/user/';
        $config['encrypt_nam'] = 'TRUE';
        $config['remove_spaces'] = TRUE;
        //$config['max_size'] = 0024;
        return $config;
    }
	function deletes() {
		$token =  $this->security->get_csrf_hash();
		$id = $this->input->post('id');
		$permission = $this->base_model->getPermission($this->login, $this->route);
		if (!isset($permission['delete'])){
			$result['status'] = 0;
			$result['csrfHash'] = $token;
			echo json_encode($result); exit;	
		}
		$login = $this->login;
		$array['dateupdate']  = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
		$array['userupdate'] = $login->username;
		$array['ipupdate'] = $this->base_model->getMacAddress();
		$array['isdelete'] = 1;
		$this->model->table('hotel_users')->save($id, $array);	
		$this->base_model->addAcction($this->route,$this->uri->segment(2));
		$result['status'] = 1;	
		$result['csrfHash'] = $token;
		echo json_encode($result);
	}
	function getSchool(){
		 $orgeducationid = $this->input->post('orgeducationid');
		 $schools = $this->base_model->getSchool('',$orgeducationid);
		 $str = '<select name="schoolid" id="schoolid" class="combos tab-event" >';
		 $str.= '<option value=""></option>';
		 foreach($schools as $item){
			 $str.= '<option value="'.$item->id .'">'.$item->school_name .'</option>';
		 }
		 echo $str;
	}
}