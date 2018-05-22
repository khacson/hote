<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author  
 * @copyright 2015
 */
class Salesprofitsup extends CI_Controller {
    private $route;
	private $login;
	function __construct(){
		parent::__construct();	
		$this->load->model(array('model','base_model','excel_model'));
		$this->login = $this->site->getSession('login');
		$this->route = $this->router->class;
		$menus = $this->site->getSession('menus');
		$this->title = $menus[$this->route];
		//$this->site->setTemplate('home');
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
		
		$data->companyid = $this->login->companyid;
		$data->branchid = $this->login->branchid;
	    $data->permission = $permission;
		$data->csrfName = $this->security->get_csrf_token_name();
		$data->csrfHash = $this->security->get_csrf_hash();		
	    $data->controller = base_url().$this->route;
		$data->routes = $this->route;
		$data->goods = $this->base_model->getGoods('');
		$data->suppliers = $this->base_model->getSupplier('');
		$data->customers = $this->base_model->getCustomer('');
		$data->warehouses = $this->base_model->getWarehouse('');	
		$data->units = $this->base_model->getUnit('');	
		$data->orders = $this->base_model->getSalesoutput($data->companyid,$data->branchid,0);
		$data->employeesale = $this->base_model->getEmployeesale($data->companyid,$data->branchid);
		
		$data->branchs = $this->base_model->getBranch('');
		
		$dateNow =  gmdate("d-m-Y", time() + 7 * 3600); 
		$week = strtotime(date("d-m-Y", strtotime($dateNow))." -1 week"); 
		$week = strftime("%d/%m/%Y", $week);
		$data->todates = $dateNow;
		$data->fromdates = $week;
		
		$content = $this->load->view('view',$data,true);
		$this->site->write('content',$content,true);
		$this->site->write('title',$this->title,true);
        $this->site->render();
	}
	function getDT(){
		$result = new stdClass();
		$searchs = json_decode($this->input->post('search'),true);
		$data = $this->model->getDT($searchs);
		//Doanh thu
		$arrdt = $data['dt'];
		if(!empty($arrdt[0]->price)){
			$dt = $arrdt[0]->price;
		}
		else{
			$dt = 0;
		}
		//Loi nhuan
		$arrln = $data['ln'];
		if(!empty($arrln[0]->price)){
			$ln = $arrln[0]->price;
		}
		else{
			$ln = 0;
		}
		//Hoa hong
		$arrhh = $data['hh'];
		if(!empty($arrhh[0]->discountsales)){
			$hh = round($arrhh[0]->discountsales);
		}
		else{
			$hh = 0;
		}
		$result->dtbh = number_format($dt);
		$result->lnbh = number_format($ln-$hh);
		$result->tvbh = number_format($dt-$ln);
		$result->hhbh = number_format($hh);
		echo json_encode($result);
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
	function export(){
		$login = $this->login;
		$search = $_GET['search'];
		$searchs = json_decode($search,true);
		$datas = $this->model->getList($searchs,0,0);

		include(APPPATH . 'libraries/excel2013/PHPExcel/IOFactory' . EXT);
        $fileName = APPPATH . 'Template/salesprofit.xls';
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
		foreach ($datas as $item) { 

			$sheetIndex->setCellValueByColumnAndRow(0,$i,$i-1);	
			$sheetIndex->setCellValueByColumnAndRow(1,$i,$item->goods_code);
			$sheetIndex->setCellValueByColumnAndRow(2,$i,$item->goods_name);
			$sheetIndex->setCellValueByColumnAndRow(3,$i,$item->supplier_name);
			$sheetIndex->setCellValueByColumnAndRow(4,$i,($item->quantity));
			$sheetIndex->setCellValueByColumnAndRow(5,$i,($item->price));
			$sheetIndex->setCellValueByColumnAndRow(6,$i,($item->o_quantity));
			$sheetIndex->setCellValueByColumnAndRow(7,$i,($item->o_price));
			$i++;
		}
		$boderthin = "A2:H".($i-1); 
		$sheetIndex->getStyle($boderthin)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		#end
		$objPHPExcel->setActiveSheetIndex(0);
		$date = gmdate("dmYHis", time() + 7 * 3600);
		//$endxls = '.xls';
        $this->excel_model->exportExcel($objPHPExcel, $versionExcel, "loinhuan_".$date.'.xls');
	}
	function getGoods(){
		$id = $this->input->post('id');
		$query = $this->model->findGoods($id);
		echo json_encode($query[0]);
	}
	function getDataPrint(){
		$id = $this->input->post('id');
		$result = $data = new stdClass();
		$data->company = $this->login->company_name;
		$dataprint = $this->model->findListID($id);
		$dataprintDetail = $this->model->findListIDDetail($id); 
		$data->datas = $dataprint;
		$data->detail = $dataprintDetail;
		$result->content = $this->load->view('printpn', $data, true);
		echo json_encode($result);
	}
	function thuChi(){
		$result = $data = new stdClass();
		$searchs = json_decode($this->input->post('search'),true);
		$result->content = $this->load->view('thuchi', $data, true);
		echo json_encode($result);
	}
}