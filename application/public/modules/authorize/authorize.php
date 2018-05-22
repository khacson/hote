<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author 
 * @copyright 2015
 */
class Authorize extends CI_Controller {
    
	function __construct(){
		parent::__construct();	
		$this->load->model(array('base_model'));
		$this->site->setTemplate('login');
		$this->route = $this->router->class;
		$this->login = $this->site->getSession('login');
	}
	function _remap($method, $params = array()) {
                if (method_exists($this, $method)) {
                    return call_user_func_array(array($this, $method), $params);
                }
                $this->_view();  
        }
	function _view(){
		if(!empty($this->login->username)){
			redirect(base_url().'home');
		}
		$data = new stdClass();
		$data->token = $this->security->get_csrf_hash();
		$data->routes = $this->route;
		$c_name_user = md5('hr_user');
		$c_name_pass = md5('hr_pass');
		if(isset($_COOKIE[$c_name_user])){
			$data->username = $_COOKIE[$c_name_user];
		}
		else{
			$data->username = '';
		}
		if(isset($_COOKIE[$c_name_pass])){
			$data->password = $_COOKIE[$c_name_pass];
		}
		else{
			$data->password = '';
		}
		
		$content = $this->load->view('view',$data,true);
		$this->site->write('content',$content,true);
        $this->site->render();
	}
	function login(){
		$debug = true;
		$u = $this->input->post("username");
		$p = $this->input->post("password");
		$remember = $this->input->post("remember");
		$captcha = md5(strtolower($this->input->post("captcha")));
		$captcha_sales =  $this->site->GetSession("captcha_sales");
		$pass = md5(md5($p)."Sales@SN");
		//print_r($pass); exit;
		$login = $this->model->login($u,$pass);
		$address = $_SERVER['REMOTE_ADDR'];
		$GMTTime = date("Y-m-d H:i:s");
		$token = $this->security->get_csrf_hash();
		// insert log
		$idtimelog = $this->model->insertTimeLog($u , $address, $GMTTime);
        $this->site->DeleteSession("login");
		//print_r($captcha.'--'.$captcha_sales); exit;
		$result = array();
		if($captcha != $captcha_sales){
			$result['status'] = 0;
			$result['token'] = $this->security->get_csrf_hash();
			echo json_encode($result); exit;
		}
		if(!empty($login->id)) {
			if($login->password != $pass){
				$result['status'] = 0;
				$result['token'] = $this->security->get_csrf_hash();
				echo json_encode($result); exit;
			}
				// set session
				//$login->schoolid = 0;
				$login->code = $idtimelog;
				$login->logtime = $GMTTime;
				$login->params = $this->model->getRouter($login->params);
				$lang = $this->model->getLanguage();
				unset($login->password);
				
				if(empty($login->companyid)){
					$login->companyid = 0;
				}
				$this->site->SetSession("login", $login);
				$listmenu = $this->model->getListMenu();
				$this->site->SetSession("menus",$listmenu);
				$this->site->SetSession("language", $lang);
				$this->site->SetSession("keylang","vn");
				$result['status'] = 1;
				$c_name_user = md5('hr_user');
				$c_name_pass = md5('hr_pass');
				
				if($remember == 1){
					setcookie($c_name_user,$u, time() + (86400 * 7),"/"); 
					setcookie($c_name_pass,$p, time() + (86400 * 7),"/"); 
				}
				else{
					setcookie($c_name_user,'', time() + (86400 * 7),"/"); 
					setcookie($c_name_pass,'', time() + (86400 * 7),"/"); 
				}
				$lg = $this->site->GetSession("login");
				$comid = $lg->companyid;
				$description = 'Tài khoản: '.$u;
				$this->base_model->addAcction2('Đăng nhập',$this->uri->segment(2),$description,$u,$comid);
				$result['token'] = $this->security->get_csrf_hash();
				echo json_encode($result);
		} 
		else {
			$result['status'] = 0;
			$result['token'] = $this->security->get_csrf_hash();
			echo json_encode($result);
		}
	}
	function captcha(){
        $captcha = $this->site->createCapcha('captcha_sales');   
    }
	function logout(){
		$lg = $this->site->GetSession("login");
		$description = 'Tài khoản: '.$lg->username;
		$this->base_model->addAcction('Đăng xuất',$this->uri->segment(2),'','',$description );
		$this->site->DeleteSession("login");
		$this->site->DeleteSession("menus");
		redirect('authorize');	
	}
}