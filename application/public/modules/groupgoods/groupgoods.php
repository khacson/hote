<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author  
 * @copyright 2015
 */
class Groupgoods extends CI_Controller {
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
	    	redirect('authorize');
	    }
	    $data->permission = $permission;
		$data->csrfName = $this->security->get_csrf_token_name();
		$data->csrfHash = $this->security->get_csrf_hash();		
	    $data->controller = base_url().$this->route;
		$data->routes = $this->route;
		$data->goods = $this->base_model->getGoods(''); 
		$data->units = $this->base_model->getUnit('');	
		
		$content = $this->load->view('view',$data,true);
		$this->site->write('content',$content,true);
		$this->site->write('title',$this->title,true);
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
	function save() {
		$token =  $this->security->get_csrf_hash();
		$permission = $this->base_model->getPermission($this->login, $this->route);
		
		if (!isset($permission['add'])){
			$result['status'] = 0;
			$result['csrfHash'] = $token;
			echo json_encode($result); exit;	
		}
		$array = json_decode($this->input->post('search'),true);
		$id = $this->input->post('id');
		$login = $this->login;
		$arrays = array();
		$arrays['group_code'] = $array['group_code'];
		$arrays['group_name'] = $array['group_name'];
		$arrays['unitid'] = $array['unitid'];
		$tb = $this->base_model->loadTable();
		$check = $this->checkExit($array['group_code'],$id);
		if($check == 1){
			$result['status'] = -1;
			$result['csrfHash'] = $token;
			echo json_encode($result); exit;
		}
		if(empty($id)){
			$arrays['datecreate']  = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
			$arrays['usercreate'] = $this->login->username;
			$result['status'] =$this->model->table($tb['hotel_goods_group'])->save('',$arrays);	
		}
		else{
			$arrays['dateupdate']  = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
			$arrays['userupdate'] = $this->login->username;
			$result['status'] =$this->model->table($tb['hotel_goods_group'])->save($id,$arrays);	
		}
		$description = "Thêm mới: ".$array['group_code'].' - '.$array['group_name'];
		$this->base_model->addAcction('Nhóm hàng',$this->uri->segment(2),'','',$description);
		$result['csrfHash'] = $token;
		echo json_encode($result);
	}
	function checkExit($code,$id){
		$tb = $this->base_model->loadTable();
		$query = $this->model->table($tb['hotel_goods_group'])
							 ->select('id')
							 ->where('isdelete',0)
							 ->where('group_code',$code);
							
		if(!empty($id)){
			$query = $query->where('id <>',$id);
		}
		$query = $query->find();
		if(empty($query->id)){
			return 0;
		}
		else{
			return 1;
		}
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
		$result['status'] =$this->model->edits($array,$id);
		
		$arr_log['func'] = $this->uri->segment(2);
		$description = "Sửa: ".$array['group_code'].' - '.$array['group_name'];
		$this->base_model->addAcction('Nhóm hàng',$this->uri->segment(2),json_encode($acction_before),$array,$description);
		$result['csrfHash'] = $token;
		echo json_encode($result);
	}
	function deletes() {
		$token =  $this->security->get_csrf_hash();
		$tb = $this->base_model->loadTable();
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

		$this->model->table($tb['hotel_goods_group'])
					->where("id in ($id)")
					->update($array);	
		$this->model->table($tb['hotel_goods_group_detail'])
					->where("groupid in ($id)")
					->update($array);	

		$queryDelete = $this->model->table($tb['hotel_goods_group'])
					->select('group_concat(group_code) as group_code')
					->where("id in ($id)")
					->find();
		$description = "Xóa: ".$queryDelete->group_code;
		$this->base_model->addAcction('Nhóm hàng',$this->uri->segment(2),'','',$description);
		$result['status'] = 1;	
		$result['csrfHash'] = $token;
		echo json_encode($result);
	}
	function deleteDetail() {
		$tb = $this->base_model->loadTable();
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
	
		$this->model->table($tb['hotel_goods_group_detail'])
					->where("groupid in ($id)")
					->update($array);	
		
		$queryDelete = $this->model->table($tb['hotel_goods_group_detail'])
					->select('group_concat(goods_code) as goods_code')
					->join($tb['hotel_goods'],$tb['hotel_goods'].'.id ='.$tb['hotel_goods_group_detail'].'.goodid','left')
					->where($tb['hotel_goods_group_detail'].".id in ($id)")
					->find();
		$description = "Xóa: ".$queryDelete->goods_code;
		$this->base_model->addAcction('Nhóm hàng - hàng',$this->uri->segment(2),'','',$description);
		$result['status'] = 1;	
		$result['csrfHash'] = $token;
		echo json_encode($result);
	}
	function addUnit(){
		$tb = $this->base_model->loadTable();
		$txtUnit = $this->input->post('txtUnit');
		$check = $this->model->table($tb['hotel_unit'])
					  ->select('id')
					  ->where('isdelete',0)
					  ->where('unit_name',$txtUnit)
					  ->where('companyid',$this->login->companyid)
					  ->find();
		$result = new stdClass();
		if(!empty($check->id)){
			$result->status = 0;
			echo json_encode($result); exit;
		}
		$array = array();
		
		$array['datecreate']  = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
		$array['usercreate'] = $this->login->username;
		$array['unit_name'] = $txtUnit;
		$array['companyid'] = $this->login->companyid;
		$array['friendlyurl'] = $this->site->friendlyURL($txtUnit);
		$idadd = $this->model->table($tb['hotel_unit'])->save('',$array);	
		$result->status = 1;
		$result->idadd = $idadd;
		$result->content = $this->getUnit();
		
		$description = 'Thêm mới: '.$txtUnit;
		$this->base_model->addAcction('Nhóm hàng - Đơn vị tính',$this->uri->segment(2),'','',$description);
		
		echo json_encode($result);
	}
	function getUnit(){		
		$units = $this->base_model->getUnit('');	
		$str = '<select id="unitid" name="unitid" class="combos" ><option value=""></option>';
		foreach($units as $item){
			$str.= '<option value="'.$item->id .'">'.$item->unit_name .'</option>';
		}
		$str.= '</select>'; 
		return $str;				
	}
	function getFindUnit(){
		$tb = $this->base_model->loadTable();
		$goodsid = $this->input->post('goodsid');
		$check = $this->model->table($tb['hotel_goods'])
					  ->select('unitid')
					  ->where('id',$goodsid)
					  ->find();
		if(!empty($check->unitid)){
			echo $check->unitid;
		}
		else{
			echo '';
		}
	}
	function saveDetail(){
		$tb = $this->base_model->loadTable();
		$token =  $this->security->get_csrf_hash();
		$permission = $this->base_model->getPermission($this->login, $this->route);
		$this->db->trans_begin();
		if (!isset($permission['add'])){
			$result['status'] = 0;
			$result['csrfHash'] = $token;
			echo json_encode($result); exit;	
		}
		$array = json_decode($this->input->post('search'),true);
		
		$query = $this->model->table($tb['hotel_goods_group'])
					  ->select('id')
					  ->where('isdelete',0)
					  ->where('group_code',$array['group_code'])
					  ->find();
		if(empty($query->id)){
			$arrayss = array();
			$arrayss['group_code'] = $array['group_code'];
			$arrayss['group_name'] = $array['group_name'];
			$arrayss['unitid'] = $array['unitid'];
			$arrayss['datecreate']  = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
			$arrayss['usercreate'] = $this->login->username;
			$groupid = $this->model->table($tb['hotel_goods_group'])->save('',$arrayss);	
		}
		else{
			$groupid = $query->id;
		}		
		//Kiem tra ton tai
		$querys = $this->model->table($tb['hotel_goods_group_detail'])
					  ->select('id')
					  ->where('isdelete',0)
					  ->where('goodid',$array['goodsid'])
					  ->where('groupid',$groupid)
					  ->find();
		$good =  $this->model->table($tb['hotel_goods'])
					  ->select('id,unitid,goods_code')
					  ->where('isdelete',0)
					  ->where('id',$array['goodsid'])
					  ->find();
					  
		if(empty($good->id)){
			$result['status'] = 0;
			$result['csrfHash'] = $token;
			echo json_encode($result); exit;
		}				  
		$login = $this->login;
		$arrays = array();
		if(empty($array['change'])){
			$array['change'] = 1;
		}
		$arrays['datecreate']  = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
		$arrays['usercreate'] = $this->login->username;
		$arrays['unitid'] = $good->unitid;
		$arrays['goodid'] = $array['goodsid'];
		$arrays['groupid'] = $groupid;
		$arrays['exchang'] = $array['change'];
		if(empty($querys->id)){
			$result['status'] =$this->model
							    ->table($tb['hotel_goods_group_detail'])
								->save('',$arrays);
		}
		else{
			$result['status'] =$this->model
							    ->table($tb['hotel_goods_group_detail'])
								->save($querys->id,$arrays);
		}
		$description = 'Thêm mới: '.$good->goods_code .'('.$array['group_name'].')';
		$this->base_model->addAcction('Nhóm hàng - Hàng',$this->uri->segment(2),'','',$description);
		$result['csrfHash'] = $token;
		if ($this->db->trans_status() === FALSE){
			$result['status'] = 0;
			$this->db->trans_rollback();
		}
		else{
			$this->db->trans_commit();
		}
		echo json_encode($result);
	}
}