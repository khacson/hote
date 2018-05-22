<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @author  
 * @copyright 2015
 */
class Historyinputreturn extends CI_Controller {
    private $route;
	private $login;
	function __construct(){
		parent::__construct();	
		$this->load->model(array('model','base_model','excel_model'));
		$this->login = $this->site->getSession('login');
		$this->route = $this->router->class;
		$menus = $this->site->getSession('menus');
		$this->title = 'Lịch sử nhập kho';//$menus[$this->route];
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
		$data->companyid = $this->login->companyid;
		$data->branchid = $this->login->branchid;
		$skey = $this->login->skey;
	    $data->permission = $permission;
		$data->csrfName = $this->security->get_csrf_token_name();
		$data->csrfHash = $this->security->get_csrf_hash();		
	    $data->controller = base_url().$this->route;
		$data->routes = $this->route;
		
		$data->goodsType = $this->base_model->getGoodsType(''); 
		$data->branchs = $this->base_model->getBranch($data->branchid);
		$data->suppliers = $this->base_model->getSupplier('');
		//$data->warehouses = $this->base_model->getWarehouse('');	
		//$data->units = $this->base_model->getUnit('');	
		//$data->orders = $this->base_model->getSalesoutput($data->companyid,$data->branchid,0);
		$data->employeesale = $this->base_model->getEmployeesale($data->companyid,$data->branchid);
		//$data->find = $this->model->findIDs($id);
		$data->id = $id; 
		$data->setuppo = cfso();
		$dateNow =  gmdate("d-m-Y", time() + 7 * 3600); 
		$week = strtotime(date("d-m-Y", strtotime($dateNow))." -1 week"); 
		$week = strftime("%d-%m-%Y", $week);
		$data->fromdate  = date(cfdate(),strtotime($week));
		$data->todates  = gmdate(cfdate(), time() + 7 * 3600);
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
	function deletes() {
		$token =  $this->security->get_csrf_hash();
		$permission = $this->base_model->getPermission($this->login, $this->route);
		if (!isset($permission['delete'])){
			$result['status'] = 0;
			$result['csrfHash'] = $token;
			echo json_encode($result); exit;	
		}
		$id = $this->input->post('id');
		$login = $this->login;
		$array['dateupdate']  = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
		$array['isdelete'] = 1;
		$array['userupdate'] = $this->login->username;
		$this->model->deletes($id, $array);	
		
		$result['status'] = 1;	
		$result['csrfHash'] = $token;
		echo json_encode($result);
	}
	function export(){
		$login = $this->login;
		$search = $_GET['search'];
		$searchs = json_decode($search,true);
		$datas = $this->model->getList($searchs,0,0); 
		include(APPPATH . 'libraries/excel2013/PHPExcel/IOFactory' . EXT);
        $fileName = APPPATH . 'Template/nhaphangtralai.xls';
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
		
		$arrPay = array();
		$arrPay[1] = 'Tiền mặt';
		$arrPay[2] = 'Chuyển khoản';
		$arrPay[3] = 'Thẻ';
		$array = array();
		foreach ($datas as $item) { 
			if(isset($arrPay[$item->payments])){
				$payments = $arrPay[$item->payments];
			}
			else{
				$payments = "";
			}
			$conlai = $item->price - $item->price_prepay;
			if(empty($item->price_prepay)){
				$conlai = 0;
			}
			$goods_code = str_replace('<br>','',$item->goods_code);
			$sheetIndex->setCellValueByColumnAndRow(0,$i,$i-1);	
			$sheetIndex->setCellValueByColumnAndRow(1,$i,$item->poid);
			$sheetIndex->setCellValueByColumnAndRow(2,$i,$goods_code);
			$sheetIndex->setCellValueByColumnAndRow(3,$i,rNumber($item->quantity));
			$sheetIndex->setCellValueByColumnAndRow(4,$i,rNumber($item->price));
			$sheetIndex->setCellValueByColumnAndRow(5,$i,$item->customer_name);
			$sheetIndex->setCellValueByColumnAndRow(6,$i,$payments);
			$sheetIndex->setCellValueByColumnAndRow(7,$i,date(cfdate(),strtotime($item->datepo)));
			$sheetIndex->setCellValueByColumnAndRow(8,$i,$item->description);
			$sheetIndex->setCellValueByColumnAndRow(9,$i,$item->usercreate);
			$sheetIndex->setCellValueByColumnAndRow(10,$i,date(cfdate().' H:i:s',strtotime($item->datecreate)));
			$i++;
		}
		$boderthin = "A2:K".($i-1); 
		$sheetIndex->getStyle($boderthin)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->setActiveSheetIndex(0);
		$date = gmdate("dmYHis", time() + 7 * 3600);
		//$endxls = '.xls';
        $this->excel_model->exportExcel($objPHPExcel, $versionExcel, "nhaphang_".$date.'.xls');
	}
	function getDataPrint(){
		$id = $this->input->post('id');
		$unit = '';
		if(isset($_GET['unit'])){
			$unit = $_GET['unit'];
		}
		$result = $data = new stdClass();
		$data->company = $this->login->company_name;
		$dataprint = $this->model->getOrder($id,$unit);
		if(isset($dataprint->uniqueid)){
			$uniqueid = $dataprint->uniqueid;
		}
		else{
			$uniqueid = '';
		} 
		$dataprintDetail = $this->model->findListIDDetail($uniqueid); 
		$data->datas = $dataprint;
		$data->login = $this->login;
		$data->fmPrice = $this->base_model->docso($dataprint->price);
		$data->detail = $dataprintDetail;
		$result->content = $this->load->view('printpn', $data, true);
		echo json_encode($result);
	}
	function getDataPrintPC(){
		$id = $this->input->post('id');
		$result = $data = new stdClass();
		$data->company = $this->login->company_name;
		$dataprint = $this->model->findListID($id);
		$data->datas = $dataprint;
		$data->login = $this->login;
		$data->fmprice = $this->base_model->docso($dataprint->price);
		$result->content = $this->load->view('printpc', $data, true);
		echo json_encode($result);
	}
	
}