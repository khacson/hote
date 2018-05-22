<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author  
 * @copyright 2015
 */
class Shelflife extends CI_Controller {
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
		if (!isset($permission['view'])){
	    	redirect('authorize');
	    }
		$data->companyid = $this->login->companyid;
		$data->branchid = $this->login->branchid;
	    $data->permission = $permission;
		$data->csrfName = $this->security->get_csrf_token_name();
		$data->csrfHash = $this->security->get_csrf_hash();		
	    $data->controller = base_url().$this->route;
		$data->routes = $this->route;
		$data->goods = $this->base_model->getGoods('');
		//$data->customers = $this->base_model->getCustomer('');
		$data->warehouses = $this->base_model->getWarehouse('');	
		//$data->units = $this->base_model->getUnit('');
		///$data->employeesale = $this->base_model->getEmployeesale($data->companyid,$data->branchid);
		$data->suppliers = $this->base_model->getSupplier('');
		$data->warehouses = $this->base_model->getWarehouse('');	
		$data->orders = $this->base_model->getSalesinput($data->companyid,$data->branchid,0);		
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
		$data->datas = $query ;
		//$data->detail = $query['detail'];
		$data->start = $start;
		$data->permission = $this->base_model->getPermission($this->login, $this->route);
		
		$page_view=$this->site->pagination($count,$rows,5,$this->route,$page);
		$result->paging = $page_view;
		$result->csrfHash = $this->security->get_csrf_hash();
		$result->viewtotal = number_format($count); 
        $result->content = $this->load->view('list', $data, true);
		echo json_encode($result);
	}
	function getDataPrint(){
		$id = $this->input->post('id');
		$result = $data = new stdClass();
		$data->company = $this->login->company_name;
		$dataprint = $this->model->findListID($id);

		$result->detail = $dataprint['detail'];
		$result->result = $dataprint['result'];
		$result->content = $this->load->view('print', $data, true);
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
	function getCustomer(){
		$customer_id = $this->input->post('customer_id');
		$customer = $this->base_model->getCustomer($customer_id);
		echo json_encode($customer[0]);
	}
	function export(){
		$login = $this->login;
		$search = $_GET['search'];
		$searchs = json_decode($search,true);
		$query = $this->model->getList($searchs,0,0);
		//$data = new stdClass();
		//$datas = $query['result'];
		//$detail = $query['detail'];
		include(APPPATH . 'libraries/excel2013/PHPExcel/IOFactory' . EXT);
        $fileName = APPPATH . 'Template/nhapkho.xls';
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
		$arr[1] = 'KH đại lý';
		$arr[2] = 'KH lẽ'; 
		$i=6;
		foreach ($query as $item) { 
			$cname = $item->supplier_name;
			$phones = $item->phone;
			$caddress = $item->address;
			$shelflife = '';
			if(!empty($item->shelflife) && $item->shelflife != '0000-00-00' && $item->shelflife != '1970-01-01'){
				$shelflife = date(cfdate(),strtotime($item->shelflife));
			}
		
			$sheetIndex->setCellValueByColumnAndRow(0,$i,$i-5);
			$sheetIndex->setCellValueByColumnAndRow(1,$i,'PO'.$item->poid);
			$sheetIndex->setCellValueByColumnAndRow(2,$i,$item->goods_code);
			$sheetIndex->setCellValueByColumnAndRow(3,$i,$item->goods_name);
			$sheetIndex->setCellValueByColumnAndRow(4,$i,$item->quantity);
			$sheetIndex->setCellValueByColumnAndRow(5,$i,$item->priceone);
			$sheetIndex->setCellValueByColumnAndRow(6,$i,$item->quantity * $item->priceone);
			$sheetIndex->setCellValueByColumnAndRow(7,$i,$item->unit_name);
			$sheetIndex->setCellValueByColumnAndRow(8,$i,$shelflife);
			$sheetIndex->setCellValueByColumnAndRow(9,$i,$cname);
			$sheetIndex->setCellValueByColumnAndRow(10,$i,$phones);
			$sheetIndex->setCellValueByColumnAndRow(11,$i,$caddress);
			$sheetIndex->setCellValueByColumnAndRow(12,$i,$item->usercreate);
			$sheetIndex->setCellValueByColumnAndRow(13,$i,date('d-m-Y',strtotime($item->datecreate)));
			$i++;
		}
		$boderthin = "A5:N".($i-1); 
		$sheetIndex->getStyle($boderthin)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		#end
		$objPHPExcel->setActiveSheetIndex(0);
		$date = gmdate("dmYHis", time() + 7 * 3600);
		//$endxls = '.xls';
        $this->excel_model->exportExcel($objPHPExcel, $versionExcel, "nhaphang_".$date.'.xls');
	}
}