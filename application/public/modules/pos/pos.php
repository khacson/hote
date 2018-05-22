<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author  
 * @copyright 2016
 */
class Pos extends CI_Controller {
    private $route;
	private $login;
	function __construct(){
		parent::__construct();	
		$this->load->model(array('model','base_model','excel_model'));
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
		//print_r($this->login);
		$id = $this->decode($this->uri->segment(2));
		$data->companyid = $this->login->companyid;
		$data->branchid = $this->login->branchid;
	    $data->permission = $permission;
		$data->csrfName = $this->security->get_csrf_token_name();
		$data->csrfHash = $this->security->get_csrf_hash();		
	    $data->controller = base_url().$this->route;
		$data->routes = $this->route;
		$data->goods = $this->base_model->getGoods('');
		$data->customers = $this->base_model->getCustomer('');
		$data->warehouses = $this->base_model->getWarehouse('');	
		$data->units = $this->base_model->getUnit('');	
		$data->orders = $this->base_model->getSalesoutput($data->companyid,$data->branchid,0);
		$data->employeesale = $this->base_model->getEmployeesale($data->companyid,$data->branchid);
		$data->salesOders = $this->model->getSalesOder();
		$id = (int)$id;
		$find = $this->model->findOrder($id); //print_r($find); exit;
		$data->id = $id;
		$data->find = $find;
		if(!empty($find->uniqueid)){
			$data->ordersDetail = $this->model->findUniqueid($find->uniqueid);
		}
		else{
			$data->ordersDetail = array();
		}
		$content = $this->load->view('view',$data,true);
		$this->site->write('content',$content,true);
		$this->site->write('title',$this->title,true);
        $this->site->render();
	}
	function decode($encoded) {
	  $offset = ord($encoded[0]) - 79;
	  $encoded = substr($encoded, 1);
	  for ($i = 0, $len = strlen($encoded); $i < $len; ++$i) {
		$encoded[$i] = ord($encoded[$i]) - $offset - 65;
	  }
	  return (int) $encoded;
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
	function getListSale(){
		$param = array();
        $numrows = 20;
        $data = new stdClass();
		$page = $this->input->post('page');
        $search = $this->input->post('search');
		$search = json_decode($search,true);
		$count = $this->model->getTotal($search);
        $data->datas = $this->model->getListSale($search, $page, $numrows);

        $result = new stdClass();
		$result->numrows = $numrows;
        $result->cPage = $page;
        $result->viewtotal = $count;
		if($count > $numrows){
			 $result->paging = $page_view;	
		}
		else{
			$result->paging = '';
		}
        $result->csrfHash = $this->security->get_csrf_hash();
        $result->content = $this->load->view('listsale', $data, true);
        echo json_encode($result);
	}
	function save() {
		$token =  $this->security->get_csrf_hash();
		$description =  $this->input->post('description');
		$customer_type = $this->input->post('customer_type');
		$permission = $this->base_model->getPermission($this->login, $this->route);
		$listQuantity = $this->input->post('quantity');
		$listPriceone = $this->input->post('priceone');
		$uniqueid = $this->input->post('uniqueid');
		$payments = $this->input->post('payments');
		$guarantee = $this->input->post('guarantee');
		$discount = $this->input->post('discount');
		$sttview = $this->input->post('sttview');
		$percent = $this->input->post('percent'); 
		$serial = $this->input->post('serial'); 
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
		$array['payments']  = $payments;
		$array['percent']  = $percent;
		$arr = $this->model->saves($uniqueid,$array,$listQuantity,$description,$customer_type,$listPriceone,$guarantee,$discount,$sttview,$serial);
		$result['status'] = $arr['uniqueid'];
		$result['poid'] = $arr['poid'];
		$result['msg'] = $arr['msg'];
		$result['csrfHash'] = $token;
		$this->base_model->addAcction($this->route,$this->uri->segment(2),'',json_encode($result));
		echo json_encode($result);
	}
	function edit(){
		$token =  $this->security->get_csrf_hash();
		$description =  $this->input->post('description');
		$customer_type = $this->input->post('customer_type');
		$permission = $this->base_model->getPermission($this->login, $this->route);
		$listQuantity = $this->input->post('quantity');
		$listPriceone = $this->input->post('priceone');
		$uniqueid = $this->input->post('uniqueid');
		$payments = $this->input->post('payments');
		$guarantee = $this->input->post('guarantee');
		$discount = $this->input->post('discount');
		$sttview = $this->input->post('sttview');
		$percent = $this->input->post('percent'); 
		$serial = $this->input->post('serial'); 
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
		$array['payments']  = $payments;
		$array['percent']  = $percent;
		$arr = $this->model->edits($uniqueid,$array,$listQuantity,$description,$customer_type,$listPriceone,$guarantee,$discount,$sttview,$serial);
		$result['status'] = $arr['uniqueid'];
		$result['poid'] = $arr['poid'];
		$result['msg'] = $arr['msg'];
		$result['csrfHash'] = $token;
		$this->base_model->addAcction($this->route,$this->uri->segment(2),'',json_encode($result));
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
		
		$this->model->deletes($id, $array);	
		$this->base_model->addAcction($this->route,$this->uri->segment(2));
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
		$id = $this->input->post('id');
		$result = $data = new stdClass();
		$data->login = $this->login;
		$dataprint = $this->model->findListID($id);
		$data->datas = $dataprint;
		$data->fmprice = $this->base_model->docso($dataprint->price);
		$result->content = $this->load->view('printpt', $data, true);
		echo json_encode($result);
	}
	function getDataPrintHDBH(){
		$id = $this->input->post('id');
		$result =  new stdClass();
		$data = new stdClass();
		if(isset($_GET['unit'])){
			$unit = $_GET['unit'];
		}
		else{
			$unit = '';
		}
		$data->login = $this->login;

		$dataprint = $this->model->findListID($id,$unit);
		$dataprintDetail = $this->model->findListIDDetail($unit); 
		//$data->price_prepay = $this->base_model->docso($dataprint->price);
		$data->datas = $dataprint;
		$data->detail = $dataprintDetail;
		//print_r($data->datas); exit;
		$result->content = $this->load->view('printhdbh', $data, true);
		echo json_encode($result);
	}
	function getDataPrintHDBHVAT(){
		$id = $this->input->post('id');
		$result =  new stdClass();
		$data = new stdClass();
		if(isset($_GET['unit'])){
			$unit = $_GET['unit'];
		}
		else{
			$unit = '';
		}
		$data->login = $this->login;

		$dataprint = $this->model->findListID($id,$unit);
		$dataprintDetail = $this->model->findListIDDetail($dataprint->uniqueid); 
		//$tongvat = round($dataprint->vat * $dataprint->price /100);
		//if(empty($dataprint->vat)){
		//	$tongvat = 0;
		//}
		//$data->price_prepay = $this->base_model->docso($dataprint->price + $tongvat);
		$data->datas = $dataprint;
		$data->detail = $dataprintDetail;
		//print_r($data->datas); exit;
		$result->content = $this->load->view('printhdbhvat', $data, true);
		echo json_encode($result);
	}
	function getDataPrintPX(){
		$id = $this->input->post('id');
		$result =  new stdClass();
		$data = new stdClass();
		if(isset($_GET['unit'])){
			$unit = $_GET['unit'];
		}
		else{
			$unit = '';
		}
		$data->login = $this->login;
		$dataprint = $this->model->findListID($id,$unit);
		$dataprintDetail = $this->model->findListIDDetail($dataprint->uniqueid); 
		/*$tongvat = round($dataprint->vat * $dataprint->price /100);
		if(empty($dataprint->vat)){
			$tongvat = 0;
		}
		$data->price_prepay = $this->base_model->docso($dataprint->price + $tongvat);*/
		$data->datas = $dataprint;
		$data->detail = $dataprintDetail;
		//print_r($data->datas); exit;
		$result->content = $this->load->view('printpx', $data, true);
		echo json_encode($result);
	}
	function getIDSS(){
		$data = new stdClass();
		$data->companyid = $this->login->companyid;
		$data->branchid = $this->login->branchid;
		$orders = $this->base_model->getSalesoutput($data->companyid,$data->branchid,0);
		$html = '<select id="idss" name="idss" class="combos" ><option value=""></option>';
		foreach($orders as $item){
			$html.= '<option value="'.$item->id .'">PO'.$item->poid .'</option>';
		}
		$html.= '</select>';
		echo $html;
	}
	function formAdd(){
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
		$data->groupTypes = $this->model->getGroupType();
		$data->customers = $this->base_model->getCustomer('');
		$data->employeesale = $this->base_model->getEmployeesale($companyid,$branchid);	
		
		$data->getuniqueid = $this->base_model->getUniqueid();
		$data->datecreate  = gmdate("d-m-Y", time() + 7 * 3600);
		$data->users = $this->login->fullname;
		$data->id = $id; 
		$datas =  $this->model->getTempGood($this->login->id,0); 
		$data->datas = $datas;
		if(isset($datas[0]->uniqueid)){
			$data->uniqueid = $datas[0]->uniqueid;
		}
		else{
			$data->uniqueid = 0;
		}
		$content = $this->load->view('form',$data,true);
		$this->site->write('content',$content,true);
		$this->site->write('title',$this->title,true);
        $this->site->render();
	}
	function formEdit($uniqueid='',$socode=''){
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
		//Xoa tao lai
		$this->model->deleteTempDataNew(1);
		
		//$data->goods = $this->base_model->getGoodsAutoCompelete(''); 
		$data->setuppo = $this->login->setuppo;
		$data->odersList = $this->base_model->getGoodsAutoCompeleteDH(''); 
		//$data->suppliers = $this->base_model->getSupplier('');
		$data->warehouses = $this->base_model->getWarehouse('');	
		//$data->units = $this->base_model->getUnit('');	
		//$data->orders = $this->base_model->getSalesoutput($data->companyid,$data->branchid,0);
		$data->customers = $this->base_model->getCustomer('');
		$data->employeesale = $this->base_model->getEmployeesale($companyid,$branchid);	
		//$data->find = $this->model->findIDs($id);
		$data->datecreate  = gmdate("d-m-Y", time() + 7 * 3600);
		$data->users = $this->login->fullname;
		$data->id = $id; 
		$data->socode = $socode;
		$details = $this->model->findListUniqueID($uniqueid);
		$this->model->checkTempData($details);
		$data->finds = $this->model->findOrderUniqueid($uniqueid);
		$data->datas =  $this->model->getTempGood($this->login->id,1);  
		$data->uniqueid = $uniqueid; 
		$content = $this->load->view('formEdit',$data,true);
		$this->site->write('content',$content,true);
		$this->site->write('title',$this->title,true);
        $this->site->render();
	}
	function getListAddSale(){
		$result = $data = new stdClass();
		$userid = $this->login->id;
		$isnew = 0;
		$data = $this->model->getTempGood($userid,$isnew);
		$result->content = $this->load->view('listAddData', $data, true);
		echo json_encode($result);
	}
	function getGoods(){
		$id = $this->input->post('id');
		$code = $this->input->post('code');
		$stype = $this->input->post('stype');
		$exchangs = $this->input->post('exchangs');
		$delete = $this->input->post('deletes');
		$isnew = $this->input->post('isnew');
		$vat = $this->input->post('vat');
		$query = $this->model->findGoods($id,$code,$stype,$exchangs,$delete,$isnew);
		$result = $data = new stdClass();		
		$data->datas = $query;
		$tt = 0; $uniqueid = 0;
		foreach($query as $item){
			$tt+= $item->price;
			$arrPrice = explode(';',$item->sale_price);	
			$uniqueid = $item->uniqueid;
		}
		$data->vat = $vat;
		$data->totalPrice = fmNumber($tt);
		$result->uniqueid = $uniqueid;
		$result->content = $this->load->view('listAdd', $data, true);
		//$this->db->trans_complete();
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
	function export(){
		$login = $this->login;
		$search = $_GET['search'];
		$searchs = json_decode($search,true);
		$query = $this->model->getList($searchs,0,0);
		//$data = new stdClass();
		include(APPPATH . 'libraries/excel2013/PHPExcel/IOFactory' . EXT);
        $fileName = APPPATH . 'Template\xuatbanhang.xls';
        $versionExcel = 'Excel5';
        $inputFileType = PHPExcel_IOFactory::identify($fileName);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($fileName);
        $sheetIndex = $objPHPExcel->setActiveSheetIndex(0);
        $sheetIndex->setTitle('Report');
        $sheetIndex->getDefaultStyle()->getFont()
                ->setName('Times New Roman')
                ->setSize(12);
		$sheetIndex->setCellValueByColumnAndRow(2,2,$login->company_name);
		$arr = array();
		$arr[1] = 'Khách hàng đại lý';
		$arr[2] = 'Khách hàng lẻ';
		$i = 6;
		foreach($query as $item){
			if(isset($arr[$item->customer_type])){
				$customer_type = $arr[$item->customer_type];
			}
			else{
				$customer_type = '';
			}
			if($item->customer_type == 0){
				$cname = $item->customer_name;
				$caddress = $item->customer_address;
				$cphone = $item->customer_phone;
				$cemail = $item->customer_email;
			}
			else{
				$cname = $item->cmname;
				$caddress = $item->cmaddress;
				$cphone = $item->cmphone;
				$cemail = $item->cmemail;
			}
			$conlai = $item->price_total - $item->price_prepay;
			if(empty($item->price_prepay)){
				$conlai = 0;
			}
			$socode = '';
			if(!empty($item->socode)){
				$socode = $item->socode;;
			}
	
			$sheetIndex->setCellValueByColumnAndRow(0,$i,$i-5);
			$sheetIndex->setCellValueByColumnAndRow(1,$i,$item->poid);
			$sheetIndex->setCellValueByColumnAndRow(2,$i,$socode);
			$sheetIndex->setCellValueByColumnAndRow(3,$i,$item->quantity);
			$sheetIndex->setCellValueByColumnAndRow(4,$i,$item->price_total);
			$sheetIndex->setCellValueByColumnAndRow(5,$i,$item->price_prepay);
			$sheetIndex->setCellValueByColumnAndRow(6,$i,$conlai);
			$sheetIndex->setCellValueByColumnAndRow(7,$i,$item->vat);
			$sheetIndex->setCellValueByColumnAndRow(8,$i,$item->discount);
			$sheetIndex->setCellValueByColumnAndRow(9,$i,$cname);
			$sheetIndex->setCellValueByColumnAndRow(10,$i,$item->usercreate);
			$sheetIndex->setCellValueByColumnAndRow(11,$i,date(cfdate().' H:i:s',strtotime($item->datecreate)));
			
			$i++;
		}
		$boderthin = "A5:L".($i-1); 
		$sheetIndex->getStyle($boderthin)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		#end
		$objPHPExcel->setActiveSheetIndex(0);
		$date = gmdate("dmYHis", time() + 7 * 3600);
		//$endxls = '.xls';
        $this->excel_model->exportExcel($objPHPExcel, $versionExcel, "xuatbanhang_".$date.'.xls');
	}
	function getFindGoods(){
		$goodscode = $this->input->post('goodscode');
		$query = $this->base_model->getGoodsAutoCompeleteIN($goodscode); 
		echo json_encode($query);
	}
	function updateDiscount(){
		$goodid = $this->input->post('goodid');
		$price = fmNumberSave($this->input->post('price'));
		$price_discount = fmNumberSave($this->input->post('price_discount'));
		$percent = $this->input->post('percent');
		if($percent == 1){
			$price_discount_val = rNumber(($price_discount * $price) /100) ;
		}
		else{
			$price_discount_val = rNumber($price_discount);
		} 
		$this->model->updateDiscount($price_discount_val,$goodid);
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
	function updateQuantity(){
		$goodid = $this->input->post('goodid');
		$quantity = $this->input->post('quantity');
		$this->model->updateQuantity($goodid,$quantity);
	}
	function updatePriceOne(){
		$goodid = $this->input->post('goodid');
		$priceone = $this->input->post('priceone');
		$this->model->updatePriceOne($goodid,$priceone);
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
	function addToList(){
		$uniqueid = $this->input->post('uniqueid');
		$goodid = $this->input->post('goodid');
		$price = $this->input->post('price');
		$goods_code = $this->input->post('goods_code');
		$this->model->addToList($uniqueid,$goodid,$price,$goods_code,0);
	}
}