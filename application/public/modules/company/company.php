<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author  
 * @copyright 2015
 */
class Company extends CI_Controller {
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
		$permission = $this->base_model->getPermission($this->login, $this->route);
		if (!isset($permission['view'])) {
	    	redirect('authorize');
	    }
	    $data->permission = $permission;
		$data->csrfName = $this->security->get_csrf_token_name();
		$data->csrfHash = $this->security->get_csrf_hash();		
	    $data->controller = base_url().$this->route;
		$data->routes = $this->route;
		$data->provinces = $this->base_model->getProvince();
		//$data->districs = $this->base_model->getDistric('');
		$content = $this->load->view('view',$data,true);
		$this->site->write('content',$content,true);
		$this->site->write('title',getLanguage('cong-ty'),true);
        $this->site->render();
	}
	function form(){
		$login = $this->login;
		$id = $this->input->post('id');
		$find = $this->model->findID($id);
		if(empty($find->id)){
			$find = $this->base_model->getColumns('hotel_company');
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
		$data->provinces = $this->base_model->getProvince($find->provinceid);
		$data->districs = $this->base_model->getDistric($find->provinceid);
		$data->branchid = $login->branchid;
        $result->content = $this->load->view('form', $data, true);
		$result->id = $id;
        echo json_encode($result);
	}
	function createTable(){
		$sql = "
			SELECT TABLE_NAME as tables
			FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA='sales'
		";	
		$query = $this->db->query($sql);
		$querys = $query->result();
		$arrListTb = array();
		foreach ($querys as $key=>$val){
			$tbName = $val->tables;
			 $pos = strpos($tbName,'_0');
			 if ($pos !== false) {
				$arrListTb[$tbName] = 1;
			 }
		}
		foreach($arrListTb as $tb=>$v){
			
		
		}
		$sqlT = "
			DESCRIBE hotel_receipts_22; 
		";
		$query2 = $this->db->query($sqlT);
		$querys2 = $query2->result();
		foreach($querys2 as $kk=>$obj){
			$Field = $obj->Field;
			$Type = $obj->Type;
			$Null = $obj->Null;
			$Key = $obj->Field;
			print_r($obj); exit;
		}
		
		//print_r($arrListTb); exit;
		exit;
	}
	function getList(){
		$rows = 20; //$this->site->config['row'];
		$page = $this->input->post('page');
        $pageStart = $page * $rows;
        $rowEnd = ($page + 1) * $rows;
		$start = empty($page) ? 1 : $page+1;
		$searchs = json_decode($this->input->post('search'),true);
		$searchs['order'] = substr($this->input->post('order'),4);
		$searchs['index'] = $this->input->post('index');
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
		$token =  $this->security->get_csrf_hash();
		$permission = $this->base_model->getPermission($this->login, $this->route);
		$result = array();
		if (!isset($permission['add'])){
			$result['status'] = 0;
			$result['csrfHash'] = $token;
			echo json_encode($result); exit;	
		}
		$array = json_decode($this->input->post('search'),true);
		if(isset($_FILES['userfile']) && $_FILES['userfile']['name'] != "") {
			$imge_name = $_FILES['userfile']['name'];
			$this->upload->initialize($this->set_upload_options());
			$image_data = $this->upload->do_upload('userfile', $imge_name); //Ten hinh 
			$array['logo']  = $image_data;
			//$resize = $this->resizeImg($image_data);	
		}
		$date = gmdate("Y-m-d", time() + 7 * 3600);
		$login = $this->login;
		$array['datecreate']  = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
		$array['usercreate'] = $this->login->username;
		$status = $this->model->saves($array);
		$sqlUpdate = "";
		
		$this->base_model->addAcction(getLanguage('cong-ty'),$this->uri->segment(2),'',json_encode($result));
		$result['status'] = $status;
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
		if(isset($_FILES['userfile']) && $_FILES['userfile']['name'] != "") {
			$imge_name = $_FILES['userfile']['name'];
			$this->upload->initialize($this->set_upload_options());
			$image_data = $this->upload->do_upload('userfile', $imge_name); //Ten hinh 
			$array['logo']  = $image_data;
			//$resize = $this->resizeImg($image_data);	
		}
		$id = $this->input->post('id');
		$login = $this->login;
		
		$array['dateupdate']  = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
		$array['userupdate'] = $this->login->username;
		//$array['ipupdate'] = $this->base_model->getMacAddress();
		$result['status'] =$this->model->edits($array,$id);
		$acction_before = $this->model->findID($id);
		$arr_log['func'] = $this->uri->segment(2);
		$this->base_model->addAcction(getLanguage('cong-ty'),$this->uri->segment(2),json_encode($acction_before),json_encode($result));
		
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
		$id = $this->input->post('id');//print_r($id);exit;
		$login = $this->login;
		$array['dateupdate']  = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
		$array['isdelete'] = 1;
		$array['userupdate'] = $this->login->username;
		
		$this->model->where("id in ($id)")->update($array);	
		$this->base_model->addAcction(getLanguage('cong-ty'),$this->uri->segment(2));
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
	function getDistricForm(){
		$provinceid = $this->input->post('provinceid');
		$districs = $this->base_model->getDistric($provinceid);				
		$html = '<select id="input_districid" class="combos-input" name="input_districid"><option value=""></option>';
		foreach($districs as $item){
			$html.= '<option value="'.$item->id .'">'.$item->distric_name .'</option>';
		}
		$html.= '</select>';
		echo $html;
	}
	function resizeImg($image_data) {
        $this->load->library('image_lib');
        $configz = array();
        $configz['image_library'] = 'gd2';
        $configz['source_image'] = './files/company/' . $image_data;
        $configz['new_image'] = './files/company/' . $image_data;
        $configz['create_thumb'] = TRUE;
        $configz['maintain_ratio'] = TRUE;
        $configz['width'] = 200;
        $configz['height'] = 160;
		
        $this->image_lib->initialize($configz);
        $this->image_lib->resize();
        $this->image_lib->clear();
    }
	private function set_upload_options() {
        $config = array();
        $config['allowed_types'] = 'jpg|jpeg|gif|png';
        $config['upload_path'] = './files/company/';
        $config['encrypt_nam'] = 'TRUE';
        $config['remove_spaces'] = TRUE;
        //$config['max_size'] = 0024;
        return $config;
    }
}