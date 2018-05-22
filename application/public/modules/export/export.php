<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author  
 * @copyright 2015
 */
class Export extends CI_Controller {
    private $route;
	private $login;
	function __construct(){
		parent::__construct();	
		$this->load->model(array('model','base_model','excel_model'));
		$this->login = $this->site->getSession('login');
		$this->route = $this->router->class;
		$menus = $this->site->getSession('menus');
		$this->title = $menus[$this->route];
		$this->site->setTemplate('close');
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
		$id = $this->uri->segment(2);
		$companyid = $this->login->companyid;
		$branchid = $this->login->branchid;
	    $data->permission = $permission;
		$data->csrfName = $this->security->get_csrf_token_name();
		$data->csrfHash = $this->security->get_csrf_hash();		
	    $data->controller = base_url().$this->route;
		$data->routes = $this->route;
		//$data->goods = $this->base_model->getGoodsAutoCompelete(''); 
		$data->setuppo = $this->login->setuppo;
		$data->odersList = $this->base_model->getGoodsAutoCompeleteDH(''); 
		//$data->suppliers = $this->base_model->getSupplier('');
		$data->warehouses = $this->base_model->getWarehouse('');	
		//$data->units = $this->base_model->getUnit('');	
		//$data->orders = $this->base_model->getSalesoutput($data->companyid,$data->branchid,0);
		$data->customers = $this->base_model->getCustomer('');
		$data->employeesale = $this->base_model->getEmployeesale('');	
		$data->getOderList = $this->model->getOderList();
		$data->datecreate  = gmdate("d-m-Y", time() + 7 * 3600);
		$data->users = $this->login->fullname;
		$data->banks = $this->base_model->getBank();	
		$data->id = $id; 
		$data->uniqueid = $id;
		$content = $this->load->view('view',$data,true);
		$this->site->write('content',$content,true);
		$this->site->write('title',$this->title,true);
        $this->site->render();
	}
	function save() {
		$token =  $this->security->get_csrf_hash();
		$description =  $this->input->post('description');
		$permission = $this->base_model->getPermission($this->login, $this->route);
		
		$search = $this->input->post('search');
		$itemList =  $this->input->post('itemList');
		$uniqueid = $this->base_model->getUniqueid();
		if (!isset($permission['add'])){
			$result['status'] = 0;
			$result['csrfHash'] = $token;
			echo json_encode($result); exit;	
		}
		$array = json_decode($this->input->post('search'),true);
		if(empty($array['warehouseid'])){
			$array['warehouseid'] = 0;
		}
		$isnew = 0;
		$login = $this->login;
		$arr = $this->model->saves($uniqueid,$itemList,$array,$isnew);
		$result['status'] = $arr['uniqueid'];
		$result['poid'] = $arr['poid'];
		$array['soid']  = '';
		$result['msg'] = $arr['msg'];
		if(empty($arr['msg'])){
			$result['uniqueidnew'] = $this->base_model->getUniqueid();
		}
		$result['csrfHash'] = $token;
		echo json_encode($result);
	}
	function edit(){
		$token =  $this->security->get_csrf_hash();
		$description =  $this->input->post('description');
		$permission = $this->base_model->getPermission($this->login, $this->route);
		
		$search = $this->input->post('search');
		$itemList =  $this->input->post('itemList');
		$uniqueid = $this->base_model->getUniqueid();
		if (!isset($permission['add'])){
			$result['status'] = 0;
			$result['csrfHash'] = $token;
			echo json_encode($result); exit;	
		}
		$array = json_decode($this->input->post('search'),true);
		if(empty($array['warehouseid'])){
			$array['warehouseid'] = 0;
		}
		$isnew = 0;
		$login = $this->login;
		$arr = $this->model->edits($uniqueid,$itemList,$array,$isnew);
		$result['status'] = $arr['uniqueid'];
		$result['poid'] = $arr['poid'];
		$array['soid']  = '';
		$result['msg'] = $arr['msg'];
		if(empty($arr['msg'])){
			$result['uniqueidnew'] = $this->base_model->getUniqueid();
		}
		$result['csrfHash'] = $token;
		echo json_encode($result);
	}
	function getOderListData(){
		$orderid =  $this->input->post('oderpoid');
		$isnew =  $this->input->post('isnew');
		$this->model->deleteTempDataNew($isnew);
		$details = $this->model->findListOder($orderid);
		$this->model->checkTempData($details,$isnew);
		$item = $details[0];
		echo json_encode($item);
	}
	function saveso() {
		$token =  $this->security->get_csrf_hash();
		$description =  $this->input->post('description');
		$permission = $this->base_model->getPermission($this->login, $this->route);
		$isnew = 2;
		$soid = $this->input->post('soid');
		$percent = $this->input->post('prepay');
		$payments = $this->input->post('payments'); 
		$price_prepay = $this->input->post('price_prepay'); 
		$uniqueid = $this->input->post('uniqueid');
		if (!isset($permission['add'])){
			$result['status'] = 0;
			$result['csrfHash'] = $token;
			echo json_encode($result); exit;	
		}
		$array = json_decode($this->input->post('search'),true);
		if(empty($array['warehouseid'])){
			$array['warehouseid'] = 0;
		}
		$login = $this->login;
		$array['price_prepay']  = $price_prepay;
		$array['payments']  = $payments;
		$array['percent']  = $percent;
		$array['soid']  = $soid; 
		$array['description']  = $description;
		$arr = $this->model->saves($uniqueid,$array,$isnew);
		$result['status'] = $arr['uniqueid'];
		$result['poid'] = $arr['poid'];
		$result['msg'] = $arr['msg'];
		if(empty($arr['msg'])){
			$result['uniqueidnew'] = $this->base_model->getUniqueid();
		}
		$result['csrfHash'] = $token;
		echo json_encode($result);
	}
	function addOrder(){
		$counts = $this->site->GetSession('counts');
		if(empty($counts)){
			$counts = 1;
		}
		$this->site->SetSession('counts',$counts + 1);
		$result = $data = new stdClass();
		$data->goods = $this->base_model->getGoods('');
		$data->counts = $counts = $this->site->GetSession('counts');
		$result->content = $this->load->view('addorder', $data, true);
		echo json_encode($result);
	}
	function getFormOrder(){
		$id = $this->input->post('id');
		$isorder =  $this->input->post('isorder');
		$udid = $this->model->findOrder($id);
		if(!empty($udid->uniqueid)){
			$uniqueid = $udid->uniqueid;
		}
		else{
			$uniqueid = '-1';
		}
		$result = $data = new stdClass();
		$data->isorder = $isorder;
		$data->goods = $this->base_model->getGoods('');
		$ordersDetail = $this->model->findUniqueid($uniqueid);
		$total = 0;
		foreach($ordersDetail as $item){
			$total = $total + $item->price;
		}
		$data->ordersDetail = $ordersDetail;
		if(isset($ordersDetail[0]->employeeid)){
			$customer_id = $ordersDetail[0]->customer_id;
			$employeeid =  $ordersDetail[0]->employeeid;
			$phone =  $ordersDetail[0]->phone;
			$address =  $ordersDetail[0]->address;
		}
		else{
			$customer_id = 0;
			$employeeid = 0;
			$phone = '';
			$address = '';
		}
		$result->customer_id = $customer_id;
		$result->employeeid = $employeeid;
		$result->phone = $phone;
		$result->address = $address;
		$result->content = $this->load->view('addorder', $data, true);
		$result->totalPrice = number_format($total);
		echo json_encode($result);
	}
	function getCustomer(){
		$customer_id = $this->input->post('customer_id');
		$customer = $this->base_model->getCustomer($customer_id);
		echo json_encode($customer[0]);
	}
	function getDataPrintPT(){
		$result =  new stdClass();
		$data = new stdClass();
		if(isset($_GET['unit'])){
			$unit = trim($_GET['unit']);
		}
		else{
			$unit = '';
		}
		$data->login = $this->login;
		$query = $this->model->findListID($unit);
		$arr = array();
		$arrDetail = array();
		$tt3 = 0;
		foreach($query as $item){
			 $tongtiens = $item->quantity * $item->priceone;
			 $thanhtiens = ($item->quantity * $item->priceone ) - $item->discount;
			 $tt3+= $thanhtiens;
		}
		$data->price = $tt3;
		$data->docso = $this->base_model->docso($tt3);
		$data->finds = $query[0];
		$result->content = $this->load->view('printpt', $data, true);
		echo json_encode($result);
	}
	function getDataPrintHDBHPOS(){
		$result =  new stdClass();
		$data = new stdClass();
		if(isset($_GET['unit'])){
			$unit = trim($_GET['unit']);
		}
		else{
			$unit = '';
		}
		$data->login = $this->login;
		$query = $this->model->findListID($unit);
		/*$arr = array();
		$arrDetail = array();
		foreach($query as $item){
			$arr[$item->goods_type] = $item->goods_tye_name;
			$arrDetail[$item->goods_type][$item->id] = $item;
		}*/
		$data->detail = $query;
		$data->finds = $query[0];
		$result->content = $this->load->view('hdblpos', $data, true);
		echo json_encode($result);
	}
	function getDataPrintHDBH(){
		$result =  new stdClass();
		$data = new stdClass();
		$poid = '';
		if(isset($_GET['poid'])){
			$poid = trim($_GET['poid']);
		}
		$data->login = $this->login;
		$query = $this->model->findListID($poid);
		$arr = array();
		$arrDetail = array();
		foreach($query as $item){
			$arr[$item->goods_type] = $item->goods_tye_name;
			$arrDetail[$item->goods_type][$item->id] = $item;
		}
		$data->groups = $arr;
		$data->detail = $arrDetail;
		$data->finds = $query[0];
		$result->content = $this->load->view('hdbl', $data, true);
		echo json_encode($result);
	}
	function getDataPrintHDBHVAT(){
		$result =  new stdClass();
		$data = new stdClass();
		if(isset($_GET['unit'])){
			$unit = trim($_GET['unit']);
		}
		else{
			$unit = '';
		}
		$data->login = $this->login;
		$query = $this->model->findListID($unit);
		$arr = array();
		$arrDetail = array();
		foreach($query as $item){
			$arr[$item->goods_type] = $item->goods_tye_name;
			$arrDetail[$item->goods_type][$item->id] = $item;
		}
		$data->groups = $arr;
		$data->detail = $arrDetail;
		$data->finds = $query[0];
		$result->content = $this->load->view('hdvat', $data, true);
		echo json_encode($result);
	}
	function getDataPrintPX(){
		$result =  new stdClass();
		$data = new stdClass();
		$poid = '';
		if(isset($_GET['poid'])){
			$poid = trim($_GET['poid']);
		}
		$data->login = $this->login;
		$query = $this->model->findListID($poid);
		$arr = array();
		$arrDetail = array();
		foreach($query as $item){
			$arr[$item->goods_type] = $item->goods_tye_name;
			$arrDetail[$item->goods_type][$item->id] = $item;
		}
		$data->groups = $arr;
		$data->detail = $arrDetail;
		$data->finds = $query[0];
		$result->content = $this->load->view('phieuxuat', $data, true);
		echo json_encode($result);
	}
	function viewPhieuxuatkho(){
		$result =  new stdClass();
		$data = new stdClass();
		$id = $this->input->post('id');
		$data->login = $this->login;
		$query = $this->model->findListID("",$id);
		$arr = array();
		$arrDetail = array();
		foreach($query as $item){
			$arr[$item->goods_type] = $item->goods_tye_name;
			$arrDetail[$item->goods_type][$item->id] = $item;
		}
		$data->groups = $arr;
		$data->detail = $arrDetail;
		$data->finds = $query[0];
		$result->content = $this->load->view('viewphieuxuat', $data, true);
		echo json_encode($result);
	}
	function formEdit($orderid=''){
		$data = new stdClass();
		$permission = $this->base_model->getPermission($this->login, $this->route);
		if (!isset($permission['view'])) {
	    	redirect('authorize');
	    }
		$isnew = 1;
		$id = $this->uri->segment(2);
		$companyid = $this->login->companyid;
		$branchid = $this->login->branchid;
	    $data->permission = $permission;
		$data->csrfName = $this->security->get_csrf_token_name();
		$data->csrfHash = $this->security->get_csrf_hash();		
	    $data->controller = base_url().$this->route;
		$data->routes = $this->route;
		//Xoa tao lai
		$this->model->deleteTempDataNew(1);
		$data->setuppo = $this->login->setuppo;
		//$data->odersList = $this->base_model->getGoodsAutoCompeleteDH(''); 
		
		$data->warehouses = $this->base_model->getWarehouse('');	
		$data->customers = $this->base_model->getCustomer('');
		$data->employeesale = $this->base_model->getEmployeesale();	
		$data->datecreate  = gmdate("d-m-Y", time() + 7 * 3600);
		$data->users = $this->login->fullname;
		$data->id = $id; 
		
		$details = $this->model->findListUniqueID($orderid);
		$this->model->checkTempData($details,$isnew);
		$data->finds = $this->model->findOrderUniqueid($orderid);
		$data->datas =  $this->model->getTempGood($this->login->id,1);  
		$data->uniqueid = $orderid; 
		$content = $this->load->view('edit',$data,true);
		$this->site->write('content',$content,true);
		$this->site->write('title',$this->title,true);
        $this->site->render();
	}
	function formEditSO(){
		$data = new stdClass();
		$permission = $this->base_model->getPermission($this->login, $this->route);
		if (!isset($permission['view'])) {
	    	redirect('authorize');
	    }
		$isnew = 2;
		$soid = '';
		if(isset($_GET['soid'])){
			$soid = $_GET['soid'];
		}
		$userid =  $this->login->id;
		$companyid = $this->login->companyid;
		$branchid = $this->login->branchid;
	    $data->permission = $permission;
		$data->csrfName = $this->security->get_csrf_token_name();
		$data->csrfHash = $this->security->get_csrf_hash();		
	    $data->controller = base_url().$this->route;
		$data->routes = $this->route;
		//Xoa tao lai
		$this->model->deleteTempDataNewSO($soid,$isnew);
		$data->setuppo = $this->login->setuppo;
		//$data->odersList = $this->base_model->getGoodsAutoCompeleteDH(''); 
		//$data->warehouses = $this->base_model->getWarehouse('');	
		$data->customers = $this->base_model->getCustomer('');
		$data->employeesale = $this->base_model->getEmployeesale($companyid,$branchid);	
		$data->datecreate  = gmdate("d-m-Y", time() + 7 * 3600);
		$data->users = $this->login->fullname;
		$data->id = ''; 
		$details = $this->model->findListSO($soid); 
		$this->model->checkTempData($details,$isnew); //print_r($details ); exit;
		if(empty($details[0]->orderid)){
			redirect('export');
		}
		$orderid = $details[0]->orderid;
		$data->soid = $soid;
		$data->finds = $this->model->findOrderUniqueidSO($orderid);
		$data->datas = $this->model->getTempGood($userid,$isnew,$soid);
		$data->uniqueid = $orderid; 
		$data->getOderList = $this->model->getOderList();
		$content = $this->load->view('formEditSO',$data,true);
		$this->site->write('content',$content,true);
		$this->site->write('title',$this->title,true);
        $this->site->render();
	}
	function formAddOder(){
		$data = new stdClass();
		$permission = $this->base_model->getPermission($this->login, $this->route);
		if (!isset($permission['view'])) {
	    	redirect('authorize');
	    }
		if(!isset($_GET['so'])){
			$this->_view();
		}
		$so = $_GET['so'];
		$so = str_replace('"','',$so);
		$id = $this->uri->segment(2);
		$companyid = $this->login->companyid;
		$branchid = $this->login->branchid;
	    $data->permission = $permission;
		$data->csrfName = $this->security->get_csrf_token_name();
		$data->csrfHash = $this->security->get_csrf_hash();		
	    $data->controller = base_url().$this->route;
		$data->routes = $this->route;
		//$data->suppliers = $this->base_model->getSupplier('');
		$data->warehouses = $this->base_model->getWarehouse('');	
		//$data->units = $this->base_model->getUnit('');	
		//$data->orders = $this->base_model->getSalesoutput($data->companyid,$data->branchid,0);
		$data->customers = $this->base_model->getCustomer('');
		//$data->employeesale = $this->base_model->getEmployeesale($companyid,$branchid);	
		$data->setuppo = $this->login->setuppo;
		$data->finds = $this->model->findOrderSO($so);
		$data->datecreate  = gmdate("d-m-Y", time() + 7 * 3600);
		$data->users = $this->login->fullname;
		$data->id = $id; 
		$datas =  $this->model->getTempGoodSO($so); 
		$data->datas = $datas;
		if(isset($datas[0]->uniqueid)){
			$data->uniqueid = $datas[0]->uniqueid;
		}
		else{
			$data->uniqueid = 0;
		}
		$data->so = $so;
		$content = $this->load->view('formaddoder',$data,true);
		$this->site->write('content',$content,true);
		$this->site->write('title',$this->title,true);
        $this->site->render();
	}
	function getGoods(){
		$id = $this->input->post('id');
		$code = $this->input->post('code');
		$stype = $this->input->post('stype');
		$exchangs = $this->input->post('exchangs');
		$delete = $this->input->post('deletes');
		$isnew = $this->input->post('isnew');
		$vat = $this->input->post('vat');
		$xkm = $this->input->post('xkm');
		$uniqueid = $this->input->post('uniqueid');
		$result = new stdClass();		
		 $data = new stdClass();		
		//Lay hinh anh
		$tb = $this->base_model->loadTable();
		$findgoods = $this->model->table($tb['hotel_goods'])
								 ->select('unitid,id,unitid_active,goods_code,img,discountsales_dly,discountsales_type_dly,sale_price')
								 ->where('goods_code',$code )
								 ->where('isdelete',0)
								 ->find();
		if(empty($findgoods->id) && $delete != 'delete'){
			$result->status = 0;
			echo json_encode($result);
			exit;
		}
		if(!empty($findgoods->id)){
			$result->imgs = $findgoods->img;
			$query = $this->model->findGoods($id,$code,$stype,$exchangs,$delete,$isnew,$xkm,$uniqueid,$findgoods);
			$data->datas = $query;
			$tt = 0; 
			$result->uniqueid = $uniqueid;
			$result->content = $this->load->view('listAdd', $data, true);
		}
		$result->status = 1;
		echo json_encode($result);
	}
	function loadDataTempAdd(){
		$result = $data = new stdClass();	
		$isnew = $this->input->post('isnew');
		$userid =  $this->login->id;
		$data->datas = $this->model->getTempGood($userid,$isnew);
		$result->content = $this->load->view('listAdd', $data, true);
		echo json_encode($result);
	}
	function addCustomer(){
		$result = $data = new stdClass();
		$data->provinces = $this->base_model->getProvince();
		$result->content = $this->load->view('formaddCustomer', $data, true);
		echo json_encode($result);
	}
	function saveCustomer(){
		$search = $this->input->post('search');
		$array = json_decode($search,true);
		$result = new stdClass();
		$login = $this->login;
		$array['datecreate']  = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
		$array['usercreate'] = $this->login->username;
		$status = $this->model->saveCustomer($array);
		if($status != -1){
			$result->customer = $this->getCustomer2($status);
			$result->status = $status;
		}
		else{
			$result->customer = "";
			$result->status = $status;
		}
		echo json_encode($result);
	}
	function getCustomer2($id){
		$suppliers = $this->base_model->getCustomer('');
		$html = '<select id="customerid" name="customerid" class="combos" >
											<option value=""></option>';
		foreach($suppliers as $item){
			if($item->id == $id){
				$slect = "selected";
			}
			else{
				$slect = "";
			}
			$html.= '<option '.$slect.'  value="'.$item->id .'">'.$item->customer_name .'</option>';
		}
		$html.= '</select>';
		return $html;
	}
	function updateGuarantee(){
		$goodid = $this->input->post('goodid');
		if(empty($goodid)){ echo 0;}
		$guarantee = $this->input->post('guarantee');
		$this->model->updateGuarantee($goodid,$guarantee);
	}
	function updateAllGuarantee(){
		$guarantee = $this->input->post('guarantee');
		$this->model->updateAllGuarantee($guarantee);
	}
	function deleteTempData(){
		$goodid = $this->input->post('goodid');
		$this->model->deleteTempData($goodid);
	}
	function deleteTempDataEdit(){
		$goodid = $this->input->post('goodid');
		$detailid = $this->input->post('detailid');
		$status = $this->model->deleteTempDataEdit($goodid,$detailid);
		echo $status;
	}
	function updatePriceOne(){
		$goodid = $this->input->post('goodid');
		$quantity = $this->input->post('quantity');
		$priceone = $this->input->post('priceone');
		$discount = $this->input->post('discount');
		$xkm = $this->input->post('xkm');
		$isnew = $this->input->post('isnew');
		$unitid = $this->input->post('unitid');
		$data = $this->model->updatePriceOne($goodid,$priceone,$quantity,$discount,$xkm,$isnew,$unitid);
		$result = new stdClass();
		$result->price = fmNumber($data->price);
		$result->discount = fmNumber($data->discount);
		$result->priceEnd = fmNumber($data->price - $data->discount);		
		echo json_encode($result); exit;
	}
	function getNewPrice(){
		$isnew = $this->input->post('isnew');
		$data = $this->model->getNewPrice($isnew);
		$result = new stdClass();
		$result->price = fmNumber($data->price);
		$result->discount = fmNumber($data->discount);
		$result->priceEnd = fmNumber($data->price - $data->discount);		
		echo json_encode($result); exit;
	}
	function updateSerial(){
		$goodid = $this->input->post('goodid');
		$serial_number = $this->input->post('serial_number');
		$isnew = $this->input->post('isnew');
		$this->model->updateSerial($goodid,$serial_number,$isnew);
	}
	function getDiscountorder(){
		$result = $data = new stdClass();		
 		$goodid = $this->input->post('goodid');
		$price = $this->input->post('price');
		$isnew = $this->input->post('isnew');
		$data->price = $price;
		$data->find = $this->model->getDiscountorder($goodid,$price,$isnew);		
		$result->content =  $this->load->view('discount', $data, true);
		echo json_encode($result);
	}
	function getDiscountorderSO(){
		$result = $data = new stdClass();		
 		$goodid = $this->input->post('goodid');
		$poid = $this->input->post('poid');
		$price = $this->input->post('price');
		$data->price = $price;
		$data->find = $this->model->getDiscountorderSO($goodid,$poid);		
		$result->content =  $this->load->view('discount', $data, true);
		echo json_encode($result);
	}
	function getFindGoodsSearch(){
		$goodscode = $this->input->post('goodscode');
		$query = $this->base_model->getGoodsAutoCompeleteSearch($goodscode); 
		echo json_encode($query);
	}
	function getFindGoodsSearchDes(){
		$goodscode = $this->input->post('goodscode');
		$query = $this->base_model->getGoodsAutoCompeleteSearchDes($goodscode); 
		echo json_encode($query);
	}
	function getFindGoods(){
		$goodscode = $this->input->post('goodscode');
		$query = $this->base_model->getGoodsAutoCompeleteIN($goodscode); 
		echo json_encode($query);
	}
	function updateUnit(){
		$goodid = $this->input->post('goodid');
		$unitid = $this->input->post('unitid');
		$isnew = $this->input->post('isnew');
		$this->model->updateUnit($goodid,$unitid,$isnew);
	}
}