<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author  
 * @copyright 2015
 */
class Historysell extends CI_Controller {
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
		$id = $this->uri->segment(2);
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
		$find = $this->model->findOrder($id);
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
		$idselect = $this->input->post('idselect');
		$priceone = '{'.substr($this->input->post('priceone'),1).'}';
		$quantity = '{'.substr($this->input->post('quantity'),1).'}';
		$priceone_obj = json_decode($priceone,true);
		$quantity_obj = json_decode($quantity,true);
		if (!isset($permission['add'])){
			$result['status'] = 0;
			$result['csrfHash'] = $token;
			echo json_encode($result); exit;	
		}
		$array = json_decode($this->input->post('search'),true);

		$login = $this->login;
		$array['datecreate']  = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
		$array['usercreate'] = $this->login->username;
		$result['status'] =$this->model->saves($array,$idselect,$priceone_obj,$quantity_obj);
		$this->base_model->addAcction($this->route,$this->uri->segment(2),'',json_encode($result));
		$result['csrfHash'] = $token;
		echo json_encode($result);
	}
	function edit() {
		$token =  $this->security->get_csrf_hash();
		$permission = $this->base_model->getPermission($this->login, $this->route);
		$priceone = '{'.$this->input->post('priceone').'}';
		$quantity = '{'.$this->input->post('quantity').'}';
		$priceone_obj = json_decode($priceone,true);
		$quantity_obj = json_decode($quantity,true);
		
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
		$result['status'] =$this->model->edits($array,$id,$priceone_obj,$quantity_obj);
		$acction_before = $this->model->findID($id);
		$arr_log['func'] = $this->uri->segment(2);
		$this->base_model->addAcction($this->route,$this->uri->segment(2),json_encode($acction_before),json_encode($result));
		
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
	function getGoods(){
		$id = $this->input->post('id');
		$query = $this->model->findGoods($id);
		echo json_encode($query[0]);
	}
	function getFormOrder(){
		$id = $this->input->post('id');
		$isorder =  $this->input->post('isorder');
		$udid = $this->model->findOrder($id);
		if(!empty($udid->uniqueid)){
			$uniqueid = $udid->uniqueid;
		}
		else{
			$uniqueid = 0;
		}
		$result = $data = new stdClass();
		$data->isorder = $isorder;
		$data->goods = $this->base_model->getGoods('');
		$data->ordersDetail = $this->model->findUniqueid($uniqueid);
		$result->content = $this->load->view('addorder', $data, true);
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
		$data->company = $this->login->company_name;
		$dataprint = $this->model->findListID($id);
		$data->datas = $dataprint;
		$result->content = $this->load->view('printpt', $data, true);
		echo json_encode($result);
	}
	function getDataPrintPX(){
		$id = $this->input->post('id');
		$result = $data = new stdClass();
		$data->company = $this->login->company_name;
		$dataprint = $this->model->findListID($id);
		$dataprintDetail = $this->model->findListIDDetail($id); 
		$data->datas = $dataprint;
		$data->detail = $dataprintDetail;
		$result->content = $this->load->view('printpx', $data, true);
		echo json_encode($result);
	}
	function export(){
		$login = $this->login;
		$search = $_GET['search'];
		$searchs = json_decode($search,true);
		$datas = $this->model->getList($searchs,0,0);

		include(APPPATH . 'libraries/excel2013/PHPExcel/IOFactory' . EXT);
        $fileName = APPPATH . 'Template/banhang.xls';
        $versionExcel = 'Excel5';
        $inputFileType = PHPExcel_IOFactory::identify($fileName);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($fileName);
        $sheetIndex = $objPHPExcel->setActiveSheetIndex(0);
        $sheetIndex->setTitle('Report');
        $sheetIndex->getDefaultStyle()->getFont()
                ->setName('Times New Roman')
                ->setSize(12);
		$i= 2; 
		$arr = array();
		$arr[1] = 'KH đại lý';
		$arr[2] = 'KH lẽ';
		
		$arrPay = array();
		$arrPay[1] = 'Tiền mặt';
		$arrPay[2] = 'Chuyển khoản';
		$arrPay[3] = 'Cấn trừ tiền hàng';
		$arrPay[-1] = 'Nợ khách hàng';
		$array = array();
		foreach ($datas as $item) { 
			if(isset($arrPay[$item->payments])){
				$payments = $arrPay[$item->payments];
			}
			else{
				$payments = "";
			}
			if(isset($arr[$item->customer_type])){
				$customer_type = $arr[$item->customer_type];
			}
			else{
				$customer_type = '';
			}
			if(!empty($item->poid)){
				$poid = 'PO'.$item->poid;
			}
			else{
				$poid = 'N/A';
			}
			$sheetIndex->setCellValueByColumnAndRow(0,$i,$i-1);	
			$sheetIndex->setCellValueByColumnAndRow(1,$i,$poid);
			$sheetIndex->setCellValueByColumnAndRow(2,$i,$item->goods_code);
			$sheetIndex->setCellValueByColumnAndRow(3,$i,$item->goods_name);
			$sheetIndex->setCellValueByColumnAndRow(4,$i,$item->warehouse_name);
			$sheetIndex->setCellValueByColumnAndRow(5,$i,($item->quantity));
			$sheetIndex->setCellValueByColumnAndRow(6,$i,($item->priceone));
			$sheetIndex->setCellValueByColumnAndRow(7,$i,($item->price));
			$sheetIndex->setCellValueByColumnAndRow(8,$i,$item->unit_name);
			$sheetIndex->setCellValueByColumnAndRow(9,$i,$customer_type);
			$sheetIndex->setCellValueByColumnAndRow(10,$i,$item->customer_name);
			$sheetIndex->setCellValueByColumnAndRow(11,$i,$item->customer_phone);
			$sheetIndex->setCellValueByColumnAndRow(12,$i,$item->employee_code .' - '.$item->employee_name);
			$sheetIndex->setCellValueByColumnAndRow(13,$i,$payments);
			$sheetIndex->setCellValueByColumnAndRow(14,$i,$item->description);
			$sheetIndex->setCellValueByColumnAndRow(15,$i,$item->usercreate);
			$sheetIndex->setCellValueByColumnAndRow(16,$i,date('d-m-Y',strtotime($item->datecreate)));
			$i++;
		}
		$boderthin = "A2:P".($i-1); 
		$sheetIndex->getStyle($boderthin)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		#end
		$objPHPExcel->setActiveSheetIndex(0);
		$date = gmdate("dmYHis", time() + 7 * 3600);
		//$endxls = '.xls';
        $this->excel_model->exportExcel($objPHPExcel, $versionExcel, "lichsubanhang_".$date.'.xls');
	}
}