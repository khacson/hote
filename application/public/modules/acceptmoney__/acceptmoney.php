 <?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author sonnk
 * @copyright 2016
 */

class Acceptmoney extends CI_Controller {
    var $phonedetail;
	var $login;
    function __construct() {
        parent::__construct();
        $this->load->model(array('base_model','excel_model'));
        $this->phonedetail = 'g_processdetail';
		$this->login = $this->site->getSession('login');
		$this->route = $this->router->class;
		$this->load->library('upload');
    }
    function _remap($method, $params = array()) {
        $id = $this->uri->segment(2);
        if (method_exists($this, $method)) {
            return call_user_func_array(array($this, $method), $params);
        }
        $this->_view();
    }
    function _view() {
		$data = new stdClass();
        $login = $this->login;
        if (!isset($login->id)){
			redirect(base_url());
		}
		$permission = $this->base_model->getPermission($this->login, $this->route);
        if(!isset($permission['view'])) {
            redirect('authorize');
        }
		$data->branchid = $login->branchid;
		$data->branchs = $this->base_model->getBranch($login->branchid);
		$data->catalogPays = $this->base_model->getCatalogPay();
		$data->userAccepts = $this->base_model->getUserAcceptPay($login->branchid);
		$data->permission = $permission;
        $data->routes = $this->route; 
        $data->groupid = $login['groupid'];
		#gegion add log
		$ctrol = getLanguage('chi');
		$func =  getLanguage('xem');
		$data->userid = $login['id'];
		$this->base_model->addAcction($ctrol,$func,'','');
		#end	
		$data->dates = gmdate("d/m/Y",time() + 7 * 3600);
        $content = $this->load->view('view', $data, true);
        $this->site->write('content', $content, true);
        $this->site->render();
    }
	function form(){
		$permission = $this->base_model->getPermission($this->login, $this->route);
		$id = $this->input->post('id');
		$find = $this->model->findID($id);
		$login = $this->login; 
		if(empty($find->id)){
			$find = $this->base_model->getColumns('g_acceptmoney');
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
		$data->branchid = $login['branchid'];
		$data->branchs = $this->base_model->getBranch($login['branchid']);
		$data->catalogPays = $this->base_model->getCatalogPay();
		$userAccepts = $this->base_model->getUserAcceptPay($login['branchid']);
		$data->permission = $permission;
		$data->userAccepts = $userAccepts;
		$userid = $login['id'];
		$array = array();
		foreach($userAccepts as $key => $item){
			if($userid != $item->id){
				continue;
			}
			$array[$key] = $item;
		}
		$data->userTransfer = $array;
		$data->login = $login;
		$data->userid = $userid;
        $result->content = $this->load->view('form', $data, true);
		$result->id = $id;
        echo json_encode($result);
	}
	function getDataPrint(){
		$id = $_GET['id']; if(empty($id)){ return false; }
		$tb = $tb = $this->base_model->loadTable();
		$pay = $tb['g_acceptmoney'];
		$sql = "
			SELECT p.*, us1.fullname as nguoinhan, us1.phone as dtnguoinhan, us2.fullname as nguoichi 
			FROM `$pay` p
			left join g_users us1 on us1.id = p.useraceptid
			left join g_users us2 on us2.id = p.personid
			where p.id = '$id'
			;
		"; //personid
		$query = $this->model->query($sql)->execute();
		$tt = 0;
		if(!empty($query[0]->money)){
			$tt = $query[0]->money;
		}
		$result = new stdClass();
		$data = new stdClass();
		$data->finds = $query;
		$data->login = $this->login;
		$data->info = $this->site->getSession('info');
		$data->docso = $this->base_model->docso($tt);
		$result->content = $this->load->view('print', $data, true);
        echo json_encode($result);
	}
    function getList() {
        $permission = $this->base_model->getPermission($this->login, $this->route);
        if (!isset($permission['view'])) {
            //redirect('authorize');
        }
        $rows = 20; //$this->site->config['row'];
        $page = $this->input->post('page');
        $pageStart = $page * $rows;
        $rowEnd = ($page + 1) * $rows;
        $start = empty($page) ? 1 : $page + 1;
        $searchs = json_decode($this->input->post('search'), true);
        $data = new stdClass();
        $result = new stdClass();
        $query = $this->model->getList($searchs, $page, $rows);
        $count = $this->model->getTotal($searchs);
        $data->datas = $query;
        $data->start = $start;
        $data->permission = $permission;
        $page_view = $this->site->pagination($count, $rows, 5, $this->route, $page);
		if($count <= $rows){
			$page_view = '';
		}
		
        $result->paging = $page_view;
        $result->csrfHash = $this->security->get_csrf_hash();
        $result->viewtotal = $count;
        $result->content = $this->load->view('list', $data, true);
        echo json_encode($result);
    }
    function save() {
        $token = $this->security->get_csrf_hash();
        $permission = $this->base_model->getPermission($this->login, $this->route);
		$id = $this->input->post('id');
        if (!isset($permission['view'])) {
            redirect('authorize');
        }
        if (!isset($permission['add'])) {
            $result['status'] = 0;
            $result['csrfHash'] = $token;
            echo json_encode($result);
            exit;
        }
        $array = json_decode($this->input->post('search'), true);
		
        $login = $this->login;
        $array['datecreate'] = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
        $array['usercreate'] = $login['userlogin'];
        //$array['ipcreate'] = $this->base_model->getMacAddress();
		
        $result = $this->model->saves($array,$id);
		#region logfile
		$ctrol = getLanguage('chi');
		$func =  getLanguage('them-moi').': '.$array['money'];
		$this->base_model->addAcction($ctrol,$func,'','');	
		#end
        echo json_encode($result);
    }
	function edit() {
        $token = $this->security->get_csrf_hash();
        $permission = $this->base_model->getPermission($this->login, $this->route);
		$id = $this->input->post('id');
        if (!isset($permission['view'])) {
            redirect('authorize');
        }
        if (!isset($permission['edit'])) {
            $result['status'] = 0;
            $result['csrfHash'] = $token;
            echo json_encode($result);
            exit;
        }
        $array = json_decode($this->input->post('search'), true);
		
        $login = $this->login;
        $array['dateupdate'] = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
        $array['userupdate'] = $login['userlogin'];
		$findID = $this->model->findID($id);
        $result = $this->model->edits($array,$id);
		$findIDEnd = $this->model->findID($id);
		#region logfile
		$ctrol = getLanguage('chi');
		$func =  getLanguage('sua').': '.$array['money'];
		$this->base_model->addAcction($ctrol,$func,json_encode($findID),json_encode($findIDEnd));	
		#end
        echo json_encode($result);
    }
    function deletes() {
        $token = $this->security->get_csrf_hash();
        $id = $this->input->post('id');
        $permission = $this->base_model->getPermission($this->login, $this->route);
        if (!isset($permission['view'])) {
            redirect('authorize');
        }
        if (!isset($permission['delete'])) {
            $result['status'] = 0;
            $result['csrfHash'] = $token;
            echo json_encode($result);
            exit;
        }
		$findID = $this->model->findID($id);
        $login = $this->login;
        $array['dateupdate'] = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
        $array['userupdate'] = $login['userlogin'];
        $array['isdelete'] = 1;
        $this->model->deletes($id,$array);
        $result['status'] = 1;
        $result['csrfHash'] = $token;
		#region logfile
		$ctrol = getLanguage('chi');
		$func =  getLanguage('xoa').': '.$findID->money;
		$this->base_model->addAcction($ctrol,$func,json_encode($findID),'');	
		#end
        echo json_encode($result);
    }
	function export(){
		$search = json_decode($this->input->get('search'),true);
		$query = $this->model->getList($search,0,0);
		//$data = new stdClass();
		include(APPPATH . 'libraries/excel2013/PHPExcel/IOFactory' . EXT);       
		$versionExcel = 'Excel2007';
		//$objPHPExcel = new PHPExcel();
		$fileName = APPPATH . 'Template/acceptmoney.xlsx';
        $inputFileType = PHPExcel_IOFactory::identify($fileName);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($fileName);
        $sheetIndex = $objPHPExcel->setActiveSheetIndex(0);
        $sheetIndex->setTitle('Report');
        $sheetIndex->getDefaultStyle()->getFont()
                ->setName('Times New Roman')
                ->setSize(12);
		
		$sheetIndex->setCellValueByColumnAndRow(0,1,getLanguage('stt'));
		$sheetIndex->setCellValueByColumnAndRow(1,1,getLanguage('nguoi-nhan'));
		$sheetIndex->setCellValueByColumnAndRow(2,1,getLanguage('nguoi-giao'));
		$sheetIndex->setCellValueByColumnAndRow(3,1,getLanguage('so-tien'));
		$sheetIndex->setCellValueByColumnAndRow(4,1,getLanguage('ngay-ban-giao'));
		$sheetIndex->setCellValueByColumnAndRow(5,1,getLanguage('ghi-chu'));
		$sheetIndex->setCellValueByColumnAndRow(6,1,getLanguage('chi-nhanh'));
		
		$row = 2;
		foreach($query as $item){
			$sheetIndex->setCellValueByColumnAndRow(0,$row,$row-1);
			$sheetIndex->setCellValueByColumnAndRow(1,$row,$item->fullname);
			$sheetIndex->setCellValueByColumnAndRow(2,$row,$item->pfullname);
			$sheetIndex->setCellValueByColumnAndRow(3,$row,$item->money);
			$sheetIndex->setCellValueByColumnAndRow(4,$row,date(configs('cfdate').' H:i',strtotime($item->datecreate)));
			$sheetIndex->setCellValueByColumnAndRow(5,$row,$item->description);
			$sheetIndex->setCellValueByColumnAndRow(6,$row,$item->branch_name);
			$row++;
		}
		$boderthin = "A1:G".($row-1); 
		$sheetIndex->getStyle($boderthin)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		
		$objPHPExcel->setActiveSheetIndex(0);
		$filename = 'NTBG_'.gmdate("dmYHis", time() + 7 * 3600).'.xlsx';
		$this->excel_model->exportExcel($objPHPExcel, $versionExcel,$filename);
		exit;
	}
}