<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author  
 * @copyright 2015
 */
class Importexport extends CI_Controller {
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
	    	//redirect('authorize');
	    }
	    $data->permission = $permission;
		$data->csrfName = $this->security->get_csrf_token_name();
		$data->csrfHash = $this->security->get_csrf_hash();		
	    $data->controller = base_url().$this->route;
		$data->routes = $this->route;
		$branchid = $this->login->branchid;
		
		$data->locations = $this->base_model->getLocation();
		//$data->goods = $this->base_model->getGoods('');
		$data->warehouses = $this->base_model->getWarehouse('');
		$data->suppliers = $this->base_model->getSupplier('');
		//$data->units = $this->base_model->getUnit('');
		$data->branchs = $this->base_model->getBranch($branchid);
		$data->goodsType = $this->base_model->getGoodsType('');
		
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
		$data->tonDauKys = $this->model->tonDauKy($searchs);
		$data->nhaKhoTrongKys = $this->model->nhaKhoTrongKy($searchs);
		$data->nhapHangTralais = $this->model->nhapHangTralai($searchs);
		$data->xuatKhoTrongKys = $this->model->xuatKhoTrongKy($searchs);
		$data->xuatTraNCC  = $this->model->xuatTraNCC($searchs);
		$query = $this->model->getList($searchs,$page,$rows);
		$querySum = $this->model->getListSum($searchs,$page,$rows);
		$count = $this->model->getTotal($searchs);
		$data->datas = $query;
		$data->querySum = $querySum;
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
        $fileName = APPPATH . 'Template/xuatnhapton.xls';
        $versionExcel = 'Excel5';
        $inputFileType = PHPExcel_IOFactory::identify($fileName);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($fileName);
        $sheetIndex = $objPHPExcel->setActiveSheetIndex(0);
        $sheetIndex->setTitle('Report');
        $sheetIndex->getDefaultStyle()->getFont()
                ->setName('Times New Roman')
                ->setSize(12);
				
		$tonDauKys = $this->model->tonDauKy($searchs);
		$nhaKhoTrongKys = $this->model->nhaKhoTrongKy($searchs);
		$nhapHangTralais = $this->model->nhapHangTralai($searchs);
		$xuatKhoTrongKys = $this->model->xuatKhoTrongKy($searchs);
		$xuatTraNCC  = $this->model->xuatTraNCC($searchs);
		$i= 2; 
		foreach ($datas as $item) { 
			if(isset($tonDauKys[$item->branchid][$item->warehouseid][$item->goodsid])){
				$tondau = $tonDauKys[$item->branchid][$item->warehouseid][$item->goodsid];
			}
			else{
				$tondau = 0;
			}
			if(isset($nhaKhoTrongKys[$item->branchid][$item->warehouseid][$item->goodsid])){
				$nhapkho = $nhaKhoTrongKys[$item->branchid][$item->warehouseid][$item->goodsid];
			}
			else{
				$nhapkho = 0;
			}
			if(isset($nhapHangTralais[$item->branchid][$item->warehouseid][$item->goodsid])){
				$nhaphangtralai = $nhapHangTralais[$item->branchid][$item->warehouseid][$item->goodsid];
			}
			else{
				$nhaphangtralai = 0;
			}
			if(isset($xuatKhoTrongKys[$item->branchid][$item->warehouseid][$item->goodsid])){
				$xuatkho = $xuatKhoTrongKys[$item->branchid][$item->warehouseid][$item->goodsid];
			}
			else{
				$xuatkho = 0;
			}
			if(isset($xuatTraNCC[$item->branchid][$item->warehouseid][$item->goodsid])){
				$xuatkhotrancc = $xuatTraNCC[$item->branchid][$item->warehouseid][$item->goodsid];
			}
			else{
				$xuatkhotrancc = 0;
			}
			$toncuoi = ($tondau + $nhapkho + $nhaphangtralai) - ($xuatkho + $xuatkhotrancc);
			$sheetIndex->setCellValueByColumnAndRow(0,$i,$i-1);	
			$sheetIndex->setCellValueByColumnAndRow(1,$i,$item->goods_code);
			$sheetIndex->setCellValueByColumnAndRow(2,$i,$item->goods_name);
			$sheetIndex->setCellValueByColumnAndRow(3,$i,$item->unit_name);
			$sheetIndex->setCellValueByColumnAndRow(4,$i,$tondau);
			$sheetIndex->setCellValueByColumnAndRow(5,$i,$nhapkho);
			$sheetIndex->setCellValueByColumnAndRow(6,$i,$nhaphangtralai);
			$sheetIndex->setCellValueByColumnAndRow(7,$i,$xuatkho);
			$sheetIndex->setCellValueByColumnAndRow(8,$i,$xuatkhotrancc);
			$sheetIndex->setCellValueByColumnAndRow(9,$i,$toncuoi);
			$sheetIndex->setCellValueByColumnAndRow(10,$i,$toncuoi * $item->buy_price);
			$i++;
		}
		$boderthin = "A2:K".($i-1); 
		$sheetIndex->getStyle($boderthin)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		#end
		$objPHPExcel->setActiveSheetIndex(0);
		$date = gmdate("dmYHis", time() + 7 * 3600);
		//$endxls = '.xls';
        $this->excel_model->exportExcel($objPHPExcel, $versionExcel, "xuatnhapton_".$date.'.xls');
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
}