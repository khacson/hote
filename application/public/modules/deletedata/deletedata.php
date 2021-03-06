<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author  
 * @copyright 2018
 */
class Deletedata extends CI_Controller {
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
        $this->_deletes();
    }
	function _deletes(){
		$login = $this->login;
		$tb = $this->base_model->loadTable();
		//Xóa dữ liệu tam
		$sql = "truncate `".$tb['hotel_add_temp']."` ";
		$this->model->executeQuery($sql);
		//Xóa tồn kho
		$sql = "truncate `".$tb['hotel_inventory']."` ";
		$this->model->executeQuery($sql);
		//Xóa nhập kho
		$sql = "truncate `".$tb['hotel_input_createorders']."` ";
		$this->model->executeQuery($sql);
		$sql = "truncate `".$tb['hotel_input']."` ";
		$this->model->executeQuery($sql);
		//Xóa công nợ đầu kỳ
		$sql = "truncate `".$tb['hotel_liabilities']."` ";
		$this->model->executeQuery($sql);
		$sql = "truncate `".$tb['hotel_liabilities_buy']."` ";
		$this->model->executeQuery($sql);
		
		//Xóa thu chi
		$sql = "truncate `".$tb['hotel_receipts']."` ";
		$this->model->executeQuery($sql);
		$sql = "truncate `".$tb['hotel_pay']."` ";
		$this->model->executeQuery($sql);
		//Xóa đơn đặt hàng
		$sql = "truncate `".$tb['hotel_orders']."` ";
		$this->model->executeQuery($sql);
		$sql = "truncate `".$tb['hotel_orders_detail']."` ";
		$this->model->executeQuery($sql);
		//Xóa đơn bán hàng
		$sql = "truncate `".$tb['hotel_output']."` ";
		$this->model->executeQuery($sql);
		$sql = "truncate `".$tb['hotel_output_detail']."` ";
		$this->model->executeQuery($sql);
		//Xóa đơn hàng
		$sql = "truncate `".$tb['hotel_ponumber']."` ";
		$this->model->executeQuery($sql);
		
		echo "Xóa thành công";
	}
	function _view(){
		$data = new stdClass();
		$permission = $this->base_model->getPermission($this->login, $this->route);
		if (!isset($permission['view'])) {
	    	//redirect('authorize');
	    }
	    $data->permission = $permission;
		$data->csrfName = $this->security->get_csrf_token_name();
		$data->csrfHash = $this->security->get_csrf_hash();		
	    $data->controller = base_url().$this->route;
		$data->routes = $this->route;
		//$data->provinces = $this->base_model->getProvince();
		//$data->districs = $this->base_model->getDistric('');		
		$content = $this->load->view('view',$data,true);
		$this->site->write('content',$content,true);
		$this->site->write('title',getLanguage('tinh-thanh-pho'),true);
        $this->site->render();
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
	function form(){
		$login = $this->login;
		$id = $this->input->post('id');
		$find = $this->model->findID($id);
		if(empty($find->id)){
			$find = $this->base_model->getColumns('hotel_province');
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
        $result->content = $this->load->view('form', $data, true);
		$result->id = $id;
        echo json_encode($result);
	}
	function save() {
		$token =  $this->security->get_csrf_hash();
		$permission = $this->base_model->getPermission($this->login, $this->route);
		
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
		$description = getLanguage('them-moi').': '.$array['province_name'];
		$this->base_model->addAcction(getLanguage('tinh-thanh-pho'),$this->uri->segment(2),'','',$description);
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
		
		$array['dateupdate']  = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
		$array['userupdate'] = $this->login->username;
		//$array['ipupdate'] = $this->base_model->getMacAddress();
		$result['status'] =$this->model->edits($array,$id);
		$acction_before = $this->model->findID($id);
		$arr_log['func'] = $this->uri->segment(2);
		$description = getLanguage('sua').': '.$array['province_name'];
		$this->base_model->addAcction(getLanguage('tinh-thanh-pho'),$this->uri->segment(2),json_encode($acction_before),json_encode($array),$description);
		
		$result['csrfHash'] = $token;
		echo json_encode($result);
	}
	
}