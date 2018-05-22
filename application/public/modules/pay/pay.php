<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author  
 * @copyright 2015
 */
class Pay extends CI_Controller {
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
		$branchid = $this->login->branchid;
	    $data->permission = $permission;
		$data->csrfName = $this->security->get_csrf_token_name();
		$data->csrfHash = $this->security->get_csrf_hash();		
	    $data->controller = base_url().$this->route;
		$data->routes = $this->route;
		//$data->goods = $this->base_model->getGoods('');
		$data->suppliers = $this->base_model->getSupplier('');
		$data->timeNow = gmdate(cfdate(), time() + 7 * 3600);
		//$data->warehouses = $this->base_model->getWarehouse('');	
		//$data->units = $this->base_model->getUnit('');	
		$data->orders = $this->base_model->getSalesInput($data->companyid,$branchid,0);
		//$data->employeesale = $this->base_model->getEmployeesale($data->companyid,$data->branchid);
		$data->branchs = $this->base_model->getBranch($branchid);
		$data->goodsType = $this->base_model->getGoodsType('');
		
		$data->find = $this->model->findIDs($id);
		//$data->pos = $this->model->getPO();
		$data->id = $id;
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
		$payments = $this->input->post('payments');
		$orderid = $this->input->post('uniqueid');
		$conlai = $this->input->post('conlai');
		$login = $this->login;
		$array['orderid'] = $orderid;
		$array['conlai'] = $conlai;
		$array['dateupdate']  = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
		$array['userupdate'] = $this->login->username;
		//$array['ipupdate'] = $this->base_model->getMacAddress();
		$result['status'] =$this->model->edits($orderid,$array,$id,$payments);
		$acction_before = $this->model->findID($id);
		$arr_log['func'] = $this->uri->segment(2);
		$result['csrfHash'] = $token;
		echo json_encode($result);
	}
	function viewDetail(){
		$tb = $this->base_model->loadTable();
		$result = $data = new stdClass();
		$uniqueid = $this->input->post('uniqueid');
		$sql = "
			select sg.goods_name, sg.goods_code, so.price, so.quantity, so.priceone
			from `".$tb['hotel_input']."` so
					left join `".$tb['hotel_goods']."`  sg on sg.id = so.goodsid
					where so.isdelete = 0
					and so.uniqueid = '$uniqueid'
					and sg.isdelete = 0
		";
		$query = $this->model->query($sql)->execute();
		$data->datas = $query;
		$result->content = $this->load->view('viewDetail', $data, true);
		echo json_encode($result);
	}
	function export(){
		$login = $this->login;
		$search = $_GET['search'];
		$searchs = json_decode($search,true);
		$datas = $this->model->getList($searchs,0,0);

		include(APPPATH . 'libraries/excel2013/PHPExcel/IOFactory' . EXT);
        $fileName = APPPATH . 'Template/liabilitiesbuy.xls';
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
		$arr_status = array();
		$arr_liabilities[1] = 'Công nợ đâu kỳ';
		$arr_liabilities[2] = 'Công nợ bán hàng';
		$array = array();
		foreach ($datas as $item) { 
			if(isset($arr_liabilities[$item->liabilities])){
				$liabilities = $arr_liabilities[$item->liabilities];
			}
			else{
				$liabilities = "";
			}
			if(!empty($item->expirationdate) && $item->expirationdate != '1970-01-01' && $item->expirationdate != '0000-00-00'){
				$expirationdate = date(cfdate(),strtotime($item->expirationdate));
			}
			else{
				$expirationdate = "";
			}
			if(!empty($item->poid)){
				$poid = $item->poid;
			}
			else{
				$poid = 'N/A';
			}
			if(empty($item->price_prepay)){
				$item->price_prepay = 0;
			}
			$goods_name = str_replace('<br>','',$item->goods_name);
			$sheetIndex->setCellValueByColumnAndRow(0,$i,$i-1);	
			$sheetIndex->setCellValueByColumnAndRow(1,$i,$item->supplier_name);
			$sheetIndex->setCellValueByColumnAndRow(2,$i,$item->poid);
			$sheetIndex->setCellValueByColumnAndRow(3,$i,$goods_name);
			$sheetIndex->setCellValueByColumnAndRow(4,$i,$item->quantity);
			$sheetIndex->setCellValueByColumnAndRow(5,$i,$item->price);
			$sheetIndex->setCellValueByColumnAndRow(6,$i,$item->price_prepay);
			$sheetIndex->setCellValueByColumnAndRow(7,$i,$item->price - $item->price_prepay);
			$sheetIndex->setCellValueByColumnAndRow(8,$i,$expirationdate);
			$sheetIndex->setCellValueByColumnAndRow(9,$i,date(cfdate(),strtotime($item->datecreate)));
			$sheetIndex->setCellValueByColumnAndRow(10,$i,$item->description);
			$sheetIndex->setCellValueByColumnAndRow(11,$i,$liabilities);
			$i++;
		}
		$boderthin = "A2:L".($i-1); 
		$sheetIndex->getStyle($boderthin)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		#end
		$objPHPExcel->setActiveSheetIndex(0);
		$date = gmdate("dmYHis", time() + 7 * 3600);
		//$endxls = '.xls';
        $this->excel_model->exportExcel($objPHPExcel, $versionExcel, "congnomuahang_".$date.'.xls');
	}
	function getDataPrintPC(){
		$orderid = $this->input->post('orderid');
		$id = $this->input->post('id');
		$result = $data = new stdClass();
		$data->company = $this->login->company_name;
		$data->login = $this->login;
		$dataprint = $this->model->findUniqueID($id,$orderid);
		$type = $this->model->payType($dataprint->pay_type);
		$data->datas = $dataprint;
		if(!empty($type->pay_type_name)){
			$data->type = $type->pay_type_name;
		}
		else{
			$data->type = '';
		}
		$data->fmprice = $this->base_model->docso($dataprint->amount);
		$result->content = $this->load->view('printpc', $data, true);
		echo json_encode($result);
	}
	function viewPOdetail(){
		$result = new stdClass();
		$data = new stdClass();
		$orderid = $this->input->post('id');
		$data->datas = $this->model->findUniqueidPop($orderid);
		$data->receipts =  $this->model->getPays($orderid);
		$result->content = $this->load->view('podetail', $data, true);
		echo json_encode($result);	exit;
	}
}