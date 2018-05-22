<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author  
 * @copyright 2015
 */
class Payother extends CI_Controller {
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
		$companyid = $this->login->companyid;
	    $data->permission = $permission;
		$data->csrfName = $this->security->get_csrf_token_name();
		$data->csrfHash = $this->security->get_csrf_hash();		
	    $data->controller = base_url().$this->route;
		$data->routes = $this->route;
		$data->timeNow = gmdate(cfdate(), time() + 7 * 3600);
		$data->branchs = $this->base_model->getBranch('',$companyid);
		$data->banks = $this->base_model->getBank();	
		$data->pays = $this->model->getPays();		
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
	function form(){
		$login = $this->login;
		$id = $this->input->post('id');
		$find = $this->model->findID($id);
		if(empty($find->id)){
			$tbs = $this->base_model->loadTable();
			$find = $this->base_model->getColumns($tbs['hotel_pay']);
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
		$data->pays = $this->model->getPays();		
		$data->banks = $this->base_model->getBank();	
		$data->branchid = $login->branchid;
        $result->content = $this->load->view('form', $data, true);
		$result->id = $id;
        echo json_encode($result); exit;
	}
	function save() {
		$permission = $this->base_model->getPermission($this->login, $this->route);
		if (!isset($permission['add'])){
			$result['status'] = 0;
			$result['csrfHash'] =  '';
			echo json_encode($result); exit;	
		}
		$array = json_decode($this->input->post('search'),true);
		$login = $this->login;
		$array['usercreate'] = $this->login->username;
		$result['status'] =$this->model->saves($array);
		$result['csrfHash'] = '';
		echo json_encode($result);
	}
	function edit() {
		$permission = $this->base_model->getPermission($this->login, $this->route);
		if (!isset($permission['edit'])){
			$result['status'] = 0;
			$result['csrfHash'] =  '';
			echo json_encode($result); exit;	
		}
		$array = json_decode($this->input->post('search'),true);
		$id = $this->input->post('id');
		$login = $this->login;
		$array['dateupdate']  = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
		$array['userupdate'] = $this->login->username;
		$result['status'] =$this->model->edits($array,$id);
		$result['csrfHash'] =  '';
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
		$tb = $this->base_model->loadTable();
		$query = $this->model->table($tb['hotel_pay'])
					->where("id in ($id)")
					->find_all();
		foreach($query as $item){
			$this->model->table($tb['hotel_pay'])
					->where('id',$item->id)
					->delete();	
			$description = getLanguage('xoa').": ".$item->pay_code;
			$this->base_model->addAcction(getLanguage('chi-khac'),$this->uri->segment(2),'','',$description);
		}
		$result['status'] = 1;	
		$result['csrfHash'] = $token;
		echo json_encode($result);
	}
	function export(){
		$login = $this->login;
		$search = $_GET['search'];
		$searchs = json_decode($search,true);
		$query = $this->model->getList($searchs,0,0);
		//$data = new stdClass();
		include(APPPATH . 'libraries/excel2013/PHPExcel/IOFactory' . EXT);
        $fileName = APPPATH . 'Template\phieuchikhac.xls';
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
		$arrPay = array();
		$arrPay[1] = 'Tiền mặt';
		$arrPay[2] = 'CK';
		$arrPay[3] = 'Thẻ';

		$i= 3; 
		$arrClm = array('A','B','F','G','H','I','J','K','L');
		foreach($query as $item){
			if(isset($arrPay[$item->payment])){
				$payment = $arrPay[$item->payment];
			}
			else{
				$payment = "";
			} 	
			$sheetIndex->setCellValueByColumnAndRow(0,$i,$i-2);
			$sheetIndex->setCellValueByColumnAndRow(1,$i,$item->pay_code);
			$sheetIndex->setCellValueByColumnAndRow(2,$i,$item->pay_type_name);
			$sheetIndex->setCellValueByColumnAndRow(3,$i,number_format($item->amount));
			$sheetIndex->setCellValueByColumnAndRow(4,$i,$payment);
			$sheetIndex->setCellValueByColumnAndRow(5,$i,$item->branch_name);
			$sheetIndex->setCellValueByColumnAndRow(6,$i,$item->notes);
			$sheetIndex->setCellValueByColumnAndRow(7,$i,date(cfdate(),strtotime($item->datepo)));
			$sheetIndex->setCellValueByColumnAndRow(8,$i,date(cfdate().' H:i:s',strtotime($item->datecreate)));
			$sheetIndex->setCellValueByColumnAndRow(9,$i,$item->usercreate);
			
			$i++;
		}
		$boderthin = "A3:J".($i-1); 
		$sheetIndex->getStyle($boderthin)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		#end
		$objPHPExcel->setActiveSheetIndex(0);
		$date = gmdate("dmYHis", time() + 7 * 3600);
		//$endxls = '.xls';
        $this->excel_model->exportExcel($objPHPExcel, $versionExcel, "phieuchikhac_".$date.'.xls');
	}
	function getDataPrintPC(){
		$id = $this->input->post('id');
		$result = $data = new stdClass();
		$data->company = $this->login->company_name;
		$data->login = $this->login;
		$dataprint = $this->model->findID($id);
		$type = $this->model->payType($dataprint->pay_type);
		$data->datas = $dataprint;
		$data->type = $type->pay_type_name;
		$data->fmprice = $this->base_model->docso($dataprint->amount);
		$result->content = $this->load->view('printpc', $data, true);
		echo json_encode($result);
	}
}