<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author  
 * @copyright 2018
 */
class Supplier extends CI_Controller {
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
		$data->provinces = $this->base_model->getProvince();
		//$data->districs = $this->base_model->getDistric('');		
		$data->customerActiveFields = $this->model->customerActiveFields();
		$data->customerOwnerType = $this->model->customerOwnerType();				
		$content = $this->load->view('view',$data,true);
		$this->site->write('content',$content,true);
		$this->site->write('title',$this->title,true);
        $this->site->render();
	}
	function form(){
		$login = $this->login;
		$id = $this->input->post('id');
		$find = $this->model->findID($id);
		if(empty($find->id)){
			$tb = $this->base_model->loadTable();
			$find = $this->base_model->getColumns($tb['hotel_supplier']);
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
		$data->title = $result->title;
		$data->provinces = $this->base_model->getProvince();
		$data->customerActiveFields = $this->model->customerActiveFields();
		$data->customerOwnerType = $this->model->customerOwnerType();				
		$data->branchid = $login->branchid;
        $result->content = $this->load->view('form', $data, true);
		$result->id = $id;
        echo json_encode($result);
	}
	function getList(){
		$rows = 20; //$this->site->config['row'];
		$page = $this->input->post('page');
        $pageStart = $page * $rows;
        $rowEnd = ($page + 1) * $rows;
		$start = empty($page) ? 1 : $page+1;
		$searchss = json_decode($this->input->post('search'),true);
		$searchss['order'] = substr($this->input->post('order'),4);
		$searchss['index'] = $this->input->post('index');
		$data = new stdClass();
		$result = new stdClass();
		$searchs = array();
		foreach($searchss as $key=>$val){
			$searchs[$key] = addslashes($val); 
		}
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
		
		if (!isset($permission['add'])){
			$result['status'] = 0;
			$result['csrfHash'] = $token;
			echo json_encode($result); exit;	
		}
		$arrays = json_decode($this->input->post('search'),true);
		$array = array();
		foreach($arrays as $key=>$val){
			$array[$key] = addslashes($val); 
		}
		$checkprint = $this->input->post('checkprint');

		$login = $this->login;
		$array['datecreate']  = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
		$array['usercreate'] = $this->login->username;
		$result['status'] =$this->model->saves($array,$checkprint);
		$description = 'Thêm mới: '.$array['supplier_name'];
		$this->base_model->addAcction('Khách hàng',$this->uri->segment(2),'','',$description);
		$result['csrfHash'] = $token;
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
		$arrays = json_decode($this->input->post('search'),true);
		$array = array();
		foreach($arrays as $key=>$val){
			$array[$key] = addslashes($val); 
		}
		$checkprint = $this->input->post('checkprint');
		$id = $this->input->post('id');
		$login = $this->login;
		$acction_before = $this->model->findID($id);
		$array['dateupdate']  = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
		$array['userupdate'] = $this->login->username;
		$result['status'] =$this->model->edits($array,$id,$checkprint);
		$arr_log['func'] = $this->uri->segment(2);
		$description = 'Sửa: '.$array['supplier_name'];
		$this->base_model->addAcction('Khách hàng',$this->uri->segment(2),json_encode($acction_before),json_encode($array),$description);
		$result['csrfHash'] = $token;
		echo json_encode($result);
	}
	function deletes() {
		$token =  $this->security->get_csrf_hash();
		$tb = $this->base_model->loadTable();
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
		#region check edit
		$checkExitCus = $this->model->table($tb['hotel_output_createorders'])
									  ->select('supplier_id')
									  ->where("supplier_id in ($id)")
									  ->where('isdelete',0)
									  ->find();
		if(!empty($checkExitCus->supplier_id)){
			$result['status'] = -1;	
			$result['csrfHash'] = $token;
			echo json_encode($result); exit;
		}
		#end
		$this->model->table($tb['hotel_supplier'])
					->where("id in ($id)")
					->update($array);	
		$skey = $this->login->skey;
		$queryDelete = $this->model->table($tb['hotel_supplier'])
					->select("group_concat(DES_DECRYPT(supplier_name,'$skey')) as deletes")
					->where("id in ($id)")
					->find();
		$description = "Xóa: ".$queryDelete->deletes;
		$this->base_model->addAcction('Khách hàng',$this->uri->segment(2),'','',$description);
		
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
	function export(){
		$login = $this->login;
		$search = $_GET['search'];
		$searchs = json_decode($search,true);
		$datas = $this->model->getList($searchs,0,0);

		include(APPPATH . 'libraries/excel2013/PHPExcel/IOFactory' . EXT);
        $fileName = APPPATH . 'Template/khachhang.xls';
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
			$sheetIndex->setCellValueByColumnAndRow(1,$i,$item->supplier_code);
			$sheetIndex->setCellValueByColumnAndRow(2,$i,$item->supplier_name);
			$sheetIndex->setCellValueByColumnAndRow(3,$i,$item->phone);
			$sheetIndex->setCellValueByColumnAndRow(4,$i,$item->fax);
			$sheetIndex->setCellValueByColumnAndRow(5,$i,$item->email);
			$sheetIndex->setCellValueByColumnAndRow(6,$i,($item->address));
			$sheetIndex->setCellValueByColumnAndRow(7,$i,($item->province_name));
			$sheetIndex->setCellValueByColumnAndRow(8,$i,$item->taxcode);
			$sheetIndex->setCellValueByColumnAndRow(9,$i,$item->bankcode);
			$sheetIndex->setCellValueByColumnAndRow(10,$i,$item->bankname);
			$sheetIndex->setCellValueByColumnAndRow(11,$i,$item->usecontact);
			$sheetIndex->setCellValueByColumnAndRow(12,$i,$item->phoneusecontact);
			$i++;
		}
		$boderthin = "A2:M".($i-1); 
		$sheetIndex->getStyle($boderthin)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		#end
		$objPHPExcel->setActiveSheetIndex(0);
		$date = gmdate("dmYHis", time() + 7 * 3600);
		//$endxls = '.xls';
        $this->excel_model->exportExcel($objPHPExcel, $versionExcel, "Khachhang_".$date.'.xls');
	}
	function import(){ 
		  include(APPPATH.'libraries/excel2013/PHPExcel/IOFactory'.EXT);
		  $filename = $_FILES['userfile']['name'];
		  //$path = str_replace('\\','/',FCPATH).'/backup//';
		  if(@move_uploaded_file($_FILES['userfile']['tmp_name'], $filename))
		  $file= $filename;
		  $login = $this->login;
		  $tb = $this->base_model->loadTable();
		  $datecreate  = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
		  $usercreate = $login->username;
		  $companyid = $login->companyid;
		  $inputFileType = PHPExcel_IOFactory::identify($file);
		  $objReader = PHPExcel_IOFactory::createReader($inputFileType);
		  $objReader->setReadDataOnly(true);
		  $objPHPExcel = $objReader->load($file);
		  $objPHPExcel->setActiveSheetIndex(0);
		  $objWorksheet = $objPHPExcel->getActiveSheet();
		  $highestRow = $objWorksheet->getHighestRow(); // e.g. 10
		  $highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'
		  $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // e.g. 5
		  $i=1;
		  
		  $this->db->trans_start();
		  $provinces = $this->model->table('hotel_province')
							   ->select('friendlyurl,id')
							   ->where('isdelete',0)
							   ->find_combo('friendlyurl','id');	
		  $str_mst = '';  $str_tknh = ''; $str = ''; $str_code = '';					
		  for ($row = 2; $row <= $highestRow; ++$row){
			   $supplier_code = trim($objWorksheet->getCellByColumnAndRow(1, $row)->getValue());
			   if(substr($supplier_code,0,1)=='='){
					$supplier_code = $objWorksheet->getCellByColumnAndRow(1, $row)->getCalculatedValue();
			   }			   
			   if($supplier_code == ''){
				     $str =  '- Khách hàng không được trống.<br>';
			   }
			   $str_code.= ",'".$supplier_code."'";
			   $supplier_name = trim($objWorksheet->getCellByColumnAndRow(2, $row)->getValue());
			   if(substr($supplier_name,0,1)=='='){
					$supplier_name = $objWorksheet->getCellByColumnAndRow(2, $row)->getCalculatedValue();
			   }			   
			   if($supplier_name == ''){
				     $str =  '- Khách hàng không được trống.<br>';
			   }
			   $mst = trim($objWorksheet->getCellByColumnAndRow(8, $row)->getValue());
			   if(substr($mst,0,1)=='='){
					$mst = $objWorksheet->getCellByColumnAndRow(8, $row)->getCalculatedValue();
			   }
			   if(!empty($mst)){
				   $str_mst.= ",'".$mst."'";
			   }
			   $tknh = trim($objWorksheet->getCellByColumnAndRow(9, $row)->getValue());
			   if(substr($tknh,0,1)=='='){
					$tknh = $objWorksheet->getCellByColumnAndRow(9, $row)->getCalculatedValue();
			   }
			   if(!empty($tknh)){
				   $str_tknh.= ",'".$tknh."'";
			   }
		  }
		  //Kiêm tra mast
		  if(!empty($str_mst)){
			  $str_mst = substr($str_mst,1);
			  $listCus = $this->model->table($tb['hotel_supplier'])
					  ->select('taxcode,id')
					  ->where('taxcode in ('.$str_mst.')')
					  ->where('isdelete',0)
					  ->find_all();
			  if(count($listCus) > 0){
				  $str.= '- Mã số thuế đã tồn tại:<br>';
				  foreach($listCus as $item){
					   $str.= $item->taxcode .'<br>';
				  }
			  }
		  }
		  //Kiem tra tai khoan ngan hang
		  if(!empty($str_tknh)){
			  $str_tknh = substr($str_tknh,1);
			  $listBankCode = $this->model->table($tb['hotel_supplier'])
					  ->select('bankcode,id')
					  ->where('bankcode in ('.$str_tknh.')')
					  ->where('isdelete',0)
					  ->find_all();
			  if(count($listBankCode) > 0){
				  $str.= '- Tài khoản ngân hàng đã tồn tại:<br>';
				  foreach($listBankCode as $item){
					   $str.= $item->bankcode .'<br>';
				  }
			  }
		  }
		  //Kiem tra khach hang str_code
		   if(!empty($str_code)){
			  $str_code = substr($str_code,1);
			  $listCode = $this->model->table($tb['hotel_supplier'])
					  ->select('supplier_code,id')
					  ->where('supplier_code in ('.$str_code.')')
					  ->where('isdelete',0)
					  ->find_all();
			  if(count($listCode) > 0){
				  $str.= '- Mã khách hàng đã tồn tại:<br>';
				  foreach($listCode as $item){
					   $str.= $item->supplier_code .'<br>';
				  }
			  }
		  }
		  $result = new stdClass();
		  if($str != ""){
			 $result->status = 0; 
			 $result->content = $str;
			 echo json_encode($result);
			 exit;
		  }
		  $sql = '';
		  $datecreate  = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
		  $usercreate = $login->username;
		  $companyid = $login->companyid;
		  $skey = $this->login->skey;
		  for ($row = 2; $row <= $highestRow; ++$row){
			   $supplier_code = trim($objWorksheet->getCellByColumnAndRow(1, $row)->getValue());
			   if(substr($supplier_code,0,1)=='='){
					$supplier_code = $objWorksheet->getCellByColumnAndRow(1, $row)->getCalculatedValue();
			   }	
			   
			   $supplier_name = trim($objWorksheet->getCellByColumnAndRow(2, $row)->getValue());
			   if(substr($supplier_name,0,1)=='='){
					$supplier_name = $objWorksheet->getCellByColumnAndRow(2, $row)->getCalculatedValue();
			   }	
			   
			   $phone = trim($objWorksheet->getCellByColumnAndRow(3, $row)->getValue());
			   if(substr($phone,0,1)=='='){
					$phone = $objWorksheet->getCellByColumnAndRow(3, $row)->getCalculatedValue();
			   }
			   $fax = trim($objWorksheet->getCellByColumnAndRow(4, $row)->getValue());
			   if(substr($fax,0,1)=='='){
					$fax = $objWorksheet->getCellByColumnAndRow(4, $row)->getCalculatedValue();
			   }
			   $email = trim($objWorksheet->getCellByColumnAndRow(5, $row)->getValue());
			   if(substr($email,0,1)=='='){
					$email = $objWorksheet->getCellByColumnAndRow(5, $row)->getCalculatedValue();
			   }
			   $address = trim($objWorksheet->getCellByColumnAndRow(6, $row)->getValue());
			   if(substr($address,0,1)=='='){
					$address = $objWorksheet->getCellByColumnAndRow(6, $row)->getCalculatedValue();
			   }
			   $province_name = trim($objWorksheet->getCellByColumnAndRow(7, $row)->getValue());
			   if(substr($province_name,0,1)=='='){
					$province_name = $objWorksheet->getCellByColumnAndRow(7, $row)->getCalculatedValue();
			   }
			   $province_names = $this->site->friendlyURL($province_name);	 
			   $provinceid = 0;
			   if(isset($provinces[$province_names])){
				   $provinceid = $provinces[$province_names];
			   }
			   $taxcode = trim($objWorksheet->getCellByColumnAndRow(8, $row)->getValue());
			   if(substr($taxcode,0,1)=='='){
					$taxcode = $objWorksheet->getCellByColumnAndRow(8, $row)->getCalculatedValue();
			   }
			   $bankcode = trim($objWorksheet->getCellByColumnAndRow(9, $row)->getValue());
			   if(substr($bankcode,0,1)=='='){
					$bankcode = $objWorksheet->getCellByColumnAndRow(9, $row)->getCalculatedValue();
			   }
			   $bankname = trim($objWorksheet->getCellByColumnAndRow(10, $row)->getValue());
			   if(substr($bankname,0,1)=='='){
					$bankname = $objWorksheet->getCellByColumnAndRow(10, $row)->getCalculatedValue();
			   }
			   $usecontact = trim($objWorksheet->getCellByColumnAndRow(11, $row)->getValue());
			   if(substr($usecontact,0,1)=='='){
					$usecontact = $objWorksheet->getCellByColumnAndRow(11, $row)->getCalculatedValue();
			   }
			   $phoneusecontact = trim($objWorksheet->getCellByColumnAndRow(12, $row)->getValue());
			   if(substr($phoneusecontact,0,1)=='='){
					$phoneusecontact = $objWorksheet->getCellByColumnAndRow(12, $row)->getCalculatedValue();
			   }
			   $sql.= ",(
			   '".$supplier_code."', 
				DES_ENCRYPT('".$supplier_name."','$skey'), 
				DES_ENCRYPT('".$phone."','$skey'), 
				DES_ENCRYPT('".$fax."','$skey'),
				DES_ENCRYPT('".$email."','$skey'),
				DES_ENCRYPT('".$address."','$skey'), 
				'".$provinceid."', 
				'".addslashes($taxcode)."', 
				'".addslashes($bankcode)."', 
				'".addslashes($bankname)."', 
				'".addslashes($usecontact)."', 
				'".addslashes($phoneusecontact)."', 
				'".$companyid ."', 
				'".$datecreate."', 
				'".$usercreate."',
				'0')";
				$description = 'Import: '.$supplier_name;
				$this->base_model->addAcction('Khách hàng',$this->uri->segment(2),'','',$description);
		  }
		  $sql = substr($sql,1);
		  $insert = "
			INSERT INTO `".$tb['hotel_supplier']."` 
				(
				`supplier_code`,
				`supplier_name`,
				`phone`, 
				`fax`, 
				`email`, 
				`address`, 
				`provinceid`, 
				`taxcode`,
				`bankcode`, 
				`bankname`,
				`usecontact`,
				`phoneusecontact`,	
				`companyid`,	
			    `datecreate`, 
				`usercreate`,
				`isdelete`) 
				VALUES 
		  ";
		  $insert.= $sql;
		  $result = $this->model->executeQuery($insert);	
		  $this->db->trans_complete();
		  $result = new stdClass();
		  $result->status = 1; 
		  $result->content ="Import thành công ".($row-2)." khách hàng.";
		  echo json_encode($result);
		  exit;
	}
}