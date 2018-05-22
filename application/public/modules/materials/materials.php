<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author  
 * @copyright 2016
 */
class Materials extends CI_Controller {
    private $route;
	private $login;
	function __construct(){
		parent::__construct();	
		$this->load->model(array('model','base_model','excel_model'));
		$this->login = $this->site->getSession('login');
		$this->route = $this->router->class;
		$menus = $this->site->getSession('menus');
		$this->title = $menus[$this->route];
		$this->load->library('upload');
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
		$data->goodstypes = $this->model->getGoodsType('');
		$data->locations = $this->base_model->getLocation();
		$data->units = $this->base_model->getUnit($companyid);		
		$content = $this->load->view('view',$data,true);
		$this->site->write('content',$content,true);
		$this->site->write('title',getLanguage('hang-hoa'),true);
        $this->site->render();
	}
	function form(){
		$login = $this->login;
		$id = $this->input->post('id');
		$find = $this->model->findID($id);
		if(empty($find->id)){
			$tbs = $this->base_model->loadTable();
			$find = $this->base_model->getColumns($tbs['hotel_goods']);
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
		$data->goodstypes = $this->model->getGoodsType('');
		$data->locations = $this->base_model->getLocation();
		$data->materials = $this->model->getMaterials();
		$data->materialList = $this->model->findMaterial($find->id);
		$data->units = $this->base_model->getUnit('');		
		$data->title = $result->title;
		$data->branchid = $login->branchid;
        $result->content = $this->load->view('form', $data, true);
		$result->id = $id;
        echo json_encode($result); exit;
	}
	function addGoodsType(){
		$data = new stdClass();
        $result = new stdClass();
		$result->content = $this->load->view('addGoodsType', $data, true);
        echo json_encode($result); exit;
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
		$materials =  $this->input->post('materials');
		$exchange_unit = $this->input->post('exchange_unit');
		$arrays = json_decode($this->input->post('search'),true);
		$arrays['exchange_unit'] = $exchange_unit;
		foreach($arrays as $key=>$val){
			$array[$key] = addslashes($val); 
		}
		if(isset($_FILES['userfile']) && $_FILES['userfile']['name'] != "") {
			$imge_name = $_FILES['userfile']['name'];
			$this->upload->initialize($this->set_upload_options());
			$image_data = $this->upload->do_upload('userfile', $imge_name); //Ten hinh 
			$array['img']  = $image_data;
			$resize = $this->resizeImg($image_data);	
		}
		$login = $this->login;
		$array['datecreate']  = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
		$array['usercreate'] = $this->login->username;
		$result['status'] =$this->model->saves($array,$materials);
		$description = getLanguage('them-moi').": ".$array['goods_code'].' - '.$array['goods_name'];
		$this->base_model->addAcction(getLanguage('hang-hoa'),$this->uri->segment(2),'','',$description);
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
		$materials = $this->input->post('materials');
		$exchange_unit = $this->input->post('exchange_unit');
		$arrays = json_decode($this->input->post('search'),true);
		$arrays['exchange_unit'] = $exchange_unit;
		foreach($arrays as $key=>$val){
			$array[$key] = addslashes($val); 
		}
		$id = $this->input->post('id');
		$login = $this->login;
		$acction_before = $this->model->findID($id);
		if(isset($_FILES['userfile']) && $_FILES['userfile']['name'] != "") {
			$imge_name = $_FILES['userfile']['name'];
			$this->upload->initialize($this->set_upload_options());
			$image_data = $this->upload->do_upload('userfile', $imge_name); //Ten hinh 
			$array['img']  = $image_data;
			$resize = $this->resizeImg($image_data);	
		}
		$array['dateupdate']  = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
		$array['userupdate'] = $this->login->username;
		$result['status'] =$this->model->edits($array,$materials,$id);
		
		$arr_log['func'] = $this->uri->segment(2);
		$description = getLanguage('sua').': '.$array['goods_code'].' - '.$array['goods_name'];
		$this->base_model->addAcction(getLanguage('hang-hoa'),$this->uri->segment(2),json_encode($acction_before),json_encode($array),$description);
		
		$result['csrfHash'] = $token;
		echo json_encode($result);
	}
	function resizeImg($image_data) {
        $this->load->library('image_lib');
        $configz = array();
        $configz['image_library'] = 'gd2';
        $configz['source_image'] = './files/goods/' . $image_data;
        $configz['new_image'] = './files/goods/' . $image_data;
        $configz['create_thumb'] = TRUE;
        $configz['maintain_ratio'] = TRUE;
        $configz['width'] = 600;
        $configz['height'] = 600;
		
        $this->image_lib->initialize($configz);
        $this->image_lib->resize();
        $this->image_lib->clear();
    }
	private function set_upload_options() {
        $config = array();
        $config['allowed_types'] = 'jpg|jpeg|gif|png';
        $config['upload_path'] = './files/goods/';
        $config['encrypt_nam'] = 'TRUE';
        $config['remove_spaces'] = TRUE;
        //$config['max_size'] = 0024;
        return $config;
    }
	function deletes() {
		$token =  $this->security->get_csrf_hash();
		$permission = $this->base_model->getPermission($this->login, $this->route);
		if (!isset($permission['delete'])){
			$result['status'] = 0;
			$result['csrfHash'] = $token;
			echo json_encode($result); exit;	
		}
		$tb = $this->base_model->loadTable();
		$id = $this->input->post('id');//print_r($id);exit;
		$login = $this->login;
		$array['dateupdate']  = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
		$array['isdelete'] = 1;
		$array['userupdate'] = $this->login->username;
		#region check inventory
		$checkExitgoods = $this->model->table($tb['hotel_inventory'])
									  ->select('goodsid')
									  ->where("goodsid in ($id)")
									  ->where('isdelete',0)
									  ->where('quantity <>',0)
									  ->find(); 
		if(!empty($checkExitgoods->goodsid)){
			$result['status'] = -1;	
			$result['csrfHash'] = $token;
			echo json_encode($result); exit;
		}
		#end
		//Xoa nhap hang
		$this->model->table($tb['hotel_goods_conversion'])->where("goodsid in ($id)")->delete();
		$this->model->table($tb['hotel_goods'])
					->where('id in ('.$id.')')
					->update($array);	
					
		$queryDelete = $this->model->table($tb['hotel_goods'])
					->select('group_concat(goods_code) as mahang')
					->where("id in ($id)")
					->find();
		$description = getLanguage('xoa').": ".$queryDelete->mahang;
		$this->base_model->addAcction(getLanguage('hang-hoa'),$this->uri->segment(2),'','',$description);
		
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
        $fileName = APPPATH . 'Template/hanghoa.xls';
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
		$array = array();
		$array[1] = '%';
		$array[2] = '';
		foreach ($datas as $item) { 
			 
			if(isset($array[$item->discounthotel_type])){
				$discounthotel_type = $array[$item->discounthotel_type];
			}
			else{
				$discounthotel_type = "";
			}
			if(isset($array[$item->discounthotel_type_dly])){
				$discounthotel_type_dly = $array[$item->discounthotel_type_dly];
			}
			else{
				$discounthotel_type_dly = "";
			}
			
			$isserial = "Không";
			if($item->isserial == 1){
				$isserial = 'Có';
			}
			$shelflife = 'Không';
			if($item->shelflife == 1){
				$shelflife = 'Có';
			}
			$sheetIndex->setCellValueByColumnAndRow(0,$i,$i-1);	
			$sheetIndex->setCellValueByColumnAndRow(1,$i,$item->goods_code);
			$sheetIndex->setCellValueByColumnAndRow(2,$i,$item->goods_name);
			$sheetIndex->setCellValueByColumnAndRow(3,$i,$item->goods_tye_name);
			$sheetIndex->setCellValueByColumnAndRow(4,$i,$item->unit_name);
			$sheetIndex->setCellValueByColumnAndRow(5,$i,($item->buy_price));
			$sheetIndex->setCellValueByColumnAndRow(6,$i,($item->sale_price));
			$sheetIndex->setCellValueByColumnAndRow(7,$i,$item->madein);
			$sheetIndex->setCellValueByColumnAndRow(8,$i,$item->vat);
			$sheetIndex->setCellValueByColumnAndRow(9,$i,$item->discountsales .$discounthotel_type);
			$sheetIndex->setCellValueByColumnAndRow(10,$i,$item->discounthotel_dly .$discounthotel_type_dly);
			
			$sheetIndex->setCellValueByColumnAndRow(11,$i,$item->description);
			$sheetIndex->setCellValueByColumnAndRow(12,$i,$item->quantitymin);
			//$sheetIndex->setCellValueByColumnAndRow(13,$i,$isserial);
			$sheetIndex->setCellValueByColumnAndRow(13,$i,$shelflife);
			$sheetIndex->setCellValueByColumnAndRow(14,$i,$item->exchanges);
			$i++;
		}
		$boderthin = "A2:O".($i-1); 
		$sheetIndex->getStyle($boderthin)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		#end
		$objPHPExcel->setActiveSheetIndex(0);
		$date = gmdate("dmYHis", time() + 7 * 3600);
		//$endxls = '.xls';
        $this->excel_model->exportExcel($objPHPExcel, $versionExcel, "hanghoa_".$date.'.xls');
	}
	function printBarcode(){
		$data = new stdClass();
		$permission = $this->base_model->getPermission($this->login, $this->route);
		if (!isset($permission['view'])) {
	    	redirect('authorize');
	    }
		$id = $this->uri->segment(2);
		$data->companyid = $this->login->companyid;
		$data->branchid = $this->login->branchid;
	    $data->permission = $permission;
		$data->csrfName = $this->security->get_csrf_token_name();
		$data->csrfHash = $this->security->get_csrf_hash();		
	    $data->controller = base_url().$this->route;
		$data->routes = $this->route;
		//$data->goods = $this->base_model->getGoodsAutoCompelete(''); 
		
		//$data->find = $this->model->findIDs($id);
		$data->datecreate  = gmdate("d-m-Y", time() + 7 * 3600);
		$data->users = $this->login->fullname;
		$data->id = $id; 
		$content = $this->load->view('form',$data,true);
		$this->site->write('content',$content,true);
		$this->site->write('title',$this->title,true);
        $this->site->render();
	}
	function getGoods(){
		$id = $this->input->post('id');
		$code = $this->input->post('code');
		$query = $this->model->findGoods($id,$code);
		$result = $data = new stdClass();
		$data->datas = $query;
		$result->content = $this->load->view('listAdd', $data, true);
		echo json_encode($result);
	}
	function addCatalog(){
		$goods_tye_name = $this->input->post('goods_tye_name');
		$goods_type_group = $this->input->post('goods_type_group');
		$tb = $this->base_model->loadTable();
		$check = $this->model->table($tb['hotel_goods_type'])
					  ->select('id')
					  ->where('isdelete',0)
					  ->where('goods_tye_name',$goods_tye_name)
					  ->find();
		$result = new stdClass();
		if(!empty($check->id)){
			$result->status = -1;
			echo json_encode($result); exit;
		}
		$array = array();
		
		$array['datecreate']  = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
		$array['usercreate'] = $this->login->username;
		$array['goods_type_group'] = $goods_type_group;
		$idadd = $this->model->table($tb['hotel_goods_type'])->save('',$array);	
		$result->status = 1;
		$result->idadd = $idadd;
		$result->content = $this->getCatalog();
		$description = getLanguage('loai-hang-hoa').": ".$txtCatalog;
		$this->base_model->addAcction(getLanguage('hang-hoa'),$this->uri->segment(2),'','',$description);
		echo json_encode($result);
	}
	function getCatalog(){
		$goodstypes = $this->base_model->getGoodsType('');
		$str = '<select id="goods_type" name="goods_type" class="combos" ><option value=""></option>';
		foreach($goodstypes as $item){
			$str.= '<option value="'.$item->id .'">'.$item->goods_tye_name .'</option>';
		}
		$str.= '</select>'; 
		return $str;				
	}
	function addUnit(){
		$tb = $this->base_model->loadTable();
		$txtUnit = $this->input->post('txtUnit');
		$check = $this->model->table($tb['hotel_unit'])
					  ->select('id')
					  ->where('isdelete',0)
					  ->where('unit_name',$txtUnit)
					  ->where('companyid',$this->login->companyid)
					  ->find();
		$result = new stdClass();
		if(!empty($check->id)){
			$result->status = 0;
			echo json_encode($result); exit;
		}
		$array = array();
		
		$array['datecreate']  = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
		$array['usercreate'] = $this->login->username;
		$array['unit_name'] = $txtUnit;
		$array['companyid'] = $this->login->companyid;
		$array['friendlyurl'] = $this->site->friendlyURL($txtUnit);
		$idadd = $this->model->table($tb['hotel_unit'])->save('',$array);	
		$result->status = 1;
		$result->idadd = $idadd;
		$result->content = $this->getUnit();
		$description = "Thêm mới đơn vị tính: ".$txtUnit;
		$this->base_model->addAcction(getLanguage('hang-hoa'),$this->uri->segment(2),'','',$description);
		echo json_encode($result);
	}
	function getUnit(){
		$units = $this->base_model->getUnit('');	
		$str = '<select id="unitid" name="unitid" class="combos" ><option value=""></option>';
		foreach($units as $item){
			$str.= '<option value="'.$item->id .'">'.$item->unit_name .'</option>';
		}
		$str.= '</select>'; 
		return $str;				
	}
	function getUnitChange(){
		$unitid = $this->input->post('unitid');
		$units = $this->base_model->getUnitOrther($unitid);	
		$str = '<select id="exchange_unit" name="exchange_unit" class="combos" >';
		foreach($units as $item){
			$str.= '<option value="'.$item->id .'">'.$item->unit_name .'</option>';
		}
		$str.= '</select>'; 
		echo $str;				
	}
	function import(){ 
		  include(APPPATH.'libraries/excel2013/PHPExcel/IOFactory'.EXT);
		  $filename = $_FILES['userfile']['name'];
		  if(@move_uploaded_file($_FILES['userfile']['tmp_name'], $filename))
		  $file= $filename;
		  $login = $this->login;
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
		  $str = "";
		  $this->db->trans_start();
		  $tb = $this->base_model->loadTable();
		  //Loai hang hoa
		  $goodsType = $this->model->table($tb['hotel_goods_type'])
							   ->select('friendlyurl,id')
							   ->where('isdelete',0)
							   ->where('companyid', $login->companyid)
							   ->find_all();		   
		  $arr_goods_type = array();
		  foreach($goodsType as $item){
			  $arr_goods_type[$item->friendlyurl] = $item->id;
		  }
		  //Don vi tinh
		  $unit = $this->model->table($tb['hotel_unit'])
							   ->select('friendlyurl,id')
							   ->where('isdelete',0)
							   ->where('companyid', $login->companyid)
							   ->find_all();
		  $arr_unit = array();
		  foreach($unit as $item){
			  $arr_unit[$item->friendlyurl] = $item->id;
		  }
		  
		  //$this->model->executeQuery("truncate hotel_goods;");
		  /*$goods = $this->model->table($tb['hotel_goods'])
					  ->select('goods_code,id')
					  ->where('companyid', $login->companyid)
					  ->where('isdelete',0)
					  ->find_all();
		  $arr_goods = array();
		  foreach($goods as $item){
			  $arr_goods[$item->goods_code] = $item->id;
		  }*/
		  $arr = array();
		  $strAddGoogsType = "";
		  $strAddDVT = "";
		  for ($row = 2; $row <= $highestRow; ++$row){
			   $goods_code = trim($objWorksheet->getCellByColumnAndRow(1, $row)->getValue());
			   if(substr($goods_code,0,1)=='='){
					$goods_code = $objWorksheet->getCellByColumnAndRow(1, $row)->getCalculatedValue();
			   }			   
			   if($goods_code == ''){
				     $arr[0] =  '- Mã hàng không được trống.<br>';
			   }
			   /*$checkSpecial = $this->base_model->checkSpecial($goods_code);
			   if($checkSpecial == 0){
					$arr[10] =  '- Mã hàng '.$goods_code.' không hợp lệ. Mã hàng không được chứ ký tự đặc biệt.<br>';
			   }*/
			   $goods_name = trim($objWorksheet->getCellByColumnAndRow(2, $row)->getValue());
			   if(substr($goods_name,0,1)=='='){
					$goods_name = $objWorksheet->getCellByColumnAndRow(2, $row)->getCalculatedValue();
			   }	
			   if($goods_name == ''){
				     $arr[1] =  '- Tên hàng không được trống.<br>';
			   }
			   $goods_type = trim($objWorksheet->getCellByColumnAndRow(3, $row)->getValue());
			   if(substr($goods_type,0,1)=='='){
					$goods_type = $objWorksheet->getCellByColumnAndRow(3, $row)->getCalculatedValue();
			   }
			   //if($goods_type == ''){
				//     $arr[2] =  '- Loại hàng không được trống.<br>';
			   //}
			   $goods_types = $this->site->friendlyURL($goods_type);	 			
			   $unitid = trim($objWorksheet->getCellByColumnAndRow(4, $row)->getValue());
			   if(substr($unitid,0,1)=='='){
					$unitid = $objWorksheet->getCellByColumnAndRow(4, $row)->getCalculatedValue();
			   }
			   $unitids = $this->site->friendlyURL($unitid);
			   //if($unitid == ''){
				//     $arr[3] =  '- Đơn vị tính không được trống.<br>';
			   //}
			   if($goods_type != ''){
					//Kiểm tra loai hang
					$query_goods_type = $this->model->table($tb['hotel_goods_type'])
										->select('id')
										->where('isdelete',0)
										->where('friendlyurl',$goods_types)
										->find();
					if(empty($query_goods_type->id)){
						$isGT = array();
						$isGT['goods_tye_name'] = $goods_type;
						$isGT['friendlyurl'] = $goods_types;
						$isGT['companyid'] = $companyid;
						$isGT['datecreate'] = $datecreate;
						$isGT['usercreate'] = $datecreate;
						$this->model->table($tb['hotel_goods_type'])->insert($isGT);
					}					
			   }
			   if($unitid != ''){
				   $query_unit = $this->model->table($tb['hotel_unit'])
										->select('id')
										->where('isdelete',0)
										->where('friendlyurl',$unitids)
										->find();
					if(empty($query_unit->id)){
						$isGT = array();
						$isGT['unit_name'] = $unitid;
						$isGT['friendlyurl'] = $unitids;
						$isGT['companyid'] = $companyid;
						$isGT['datecreate'] = $datecreate;
						$isGT['usercreate'] = $datecreate;
						$this->model->table($tb['hotel_unit'])->insert($isGT);
					}			
			   }
			   //Don vi quy doi
			   $unitidChange = trim($objWorksheet->getCellByColumnAndRow(16, $row)->getValue());
			   if($unitidChange != ''){
				   $query_unitidChange = $this->model->table($tb['hotel_unit'])
										->select('id')
										->where('isdelete',0)
										->where('friendlyurl',$unitidChange)
										->find();
					if(empty($query_unitidChange->id)){
						$unitids = $this->site->friendlyURL($unitidChange);
						$isGT = array();
						$isGT['unit_name'] = $unitidChange;
						$isGT['friendlyurl'] = $unitids;
						$isGT['companyid'] = $companyid;
						$isGT['datecreate'] = $datecreate;
						$isGT['usercreate'] = $datecreate;
						$this->model->table($tb['hotel_unit'])->insert($isGT);
					}			
			   }
		  }
		  $str = '';
		  foreach($arr as $k=>$v){
			  $str.= $v;
		  }
		  $result = new stdClass();
		  if($str != ""){
			 $result->status = 0; 
			 $result->content = $str;
			 echo json_encode($result);
			 exit;
		  }
		  #region load lai sao khi them moi
		  //Loai hang hoa
		  /*$goodsType = $this->model->table($tb['hotel_goods_type'])
							   ->select('friendlyurl,id')
							   ->where('isdelete',0)
							   ->where('companyid', $login->companyid)
							   ->find_all();		   
		  $arr_goods_type = array();
		  foreach($goodsType as $item){
			  $arr_goods_type[$item->friendlyurl] = $item->id;
		  }
		  //Don vi tinh
		  $unit = $this->model->table($tb['hotel_unit'])
							   ->select('friendlyurl,id')
							   ->where('isdelete',0)
							   ->where('companyid', $login->companyid)
							   ->find_all();
		  $arr_unit = array();
		  foreach($unit as $item){
			  $arr_unit[$item->friendlyurl] = $item->id;
		  }*/
		  #end
		  $skey = $this->login->skey;
		  $tb_goods = $tb['hotel_goods'];
		  for ($row = 2; $row <= $highestRow; ++$row){
			    //1 - MA
				$goods_code = trim($objWorksheet->getCellByColumnAndRow(1, $row)->getValue()); 
				if(substr($goods_code,0,1)=='='){
					$goods_code = $objWorksheet->getCellByColumnAndRow(1, $row)->getCalculatedValue();
			    }
				//2 - Tên
				$goods_name = trim($objWorksheet->getCellByColumnAndRow(2, $row)->getValue());
				if(substr($goods_name,0,1)=='='){
					$goods_name = $objWorksheet->getCellByColumnAndRow(2, $row)->getCalculatedValue();
			    }
				//3 - Loai
				$goods_type = trim($objWorksheet->getCellByColumnAndRow(3, $row)->getValue());
				if(substr($goods_type,0,1)=='='){
					$goods_type = $objWorksheet->getCellByColumnAndRow(3, $row)->getCalculatedValue();
			    }
				//4 - Don vi	
				$unitid = trim($objWorksheet->getCellByColumnAndRow(4, $row)->getValue());
				if(substr($unitid,0,1)=='='){
					$unitid = $objWorksheet->getCellByColumnAndRow(4, $row)->getCalculatedValue();
			    }
				//5 - Gia nhap
				$buy_price = trim($objWorksheet->getCellByColumnAndRow(5, $row)->getValue());
				if(substr($buy_price,0,1)=='='){
					$buy_price = $objWorksheet->getCellByColumnAndRow(5, $row)->getCalculatedValue();
			    }
				//6 - Gia xuat
				$sale_price = trim($objWorksheet->getCellByColumnAndRow(6, $row)->getValue());
				if(substr($sale_price,0,1)=='='){
					$sale_price = $objWorksheet->getCellByColumnAndRow(6, $row)->getCalculatedValue();
			    }
				//7 Xuat xu
				$madein = trim($objWorksheet->getCellByColumnAndRow(7, $row)->getValue());
				if(substr($madein,0,1)=='='){
					$madein = $objWorksheet->getCellByColumnAndRow(7, $row)->getCalculatedValue();
			    }
				//8 - VAT
				$vat = trim($objWorksheet->getCellByColumnAndRow(8, $row)->getValue());
				if(substr($vat,0,1)=='='){
					$vat = $objWorksheet->getCellByColumnAndRow(8, $row)->getCalculatedValue();
			    }
				//9 - Hoa hong
				$discountsales = trim($objWorksheet->getCellByColumnAndRow(9, $row)->getValue());
				if(substr($discountsales,0,1)=='='){
					$discountsales = $objWorksheet->getCellByColumnAndRow(9, $row)->getCalculatedValue();
			    }
				//1 phan tran, 2 Tien truc tiep
				if (strpos($discountsales, '%') !== false) {
					$discounthotel_type = 1;
				} else {
					$discounthotel_type = 2;
				}
				//10 Hoa hong dai ly
				$discounthotel_dly = trim($objWorksheet->getCellByColumnAndRow(10, $row)->getValue());
				if(substr($discounthotel_dly,0,1)=='='){
					$discounthotel_dly = $objWorksheet->getCellByColumnAndRow(10, $row)->getCalculatedValue();
			    }
				//1 phan tran, 2 Tien truc tiep
				if (strpos($discounthotel_dly, '%') !== false) {
					$discounthotel_type_dly = 1;
				} else {
					$discounthotel_type_dly = 2;
				}
				//11 - Ghi chu
				$description = trim($objWorksheet->getCellByColumnAndRow(11, $row)->getValue());
				if(substr($description,0,1)=='='){
					$description = $objWorksheet->getCellByColumnAndRow(11, $row)->getCalculatedValue();
			    }
				//12 - Ton kho toi thieu
				$quantitymin = trim($objWorksheet->getCellByColumnAndRow(12, $row)->getValue());
				if(substr($quantitymin,0,1)=='='){
					$quantitymin = $objWorksheet->getCellByColumnAndRow(12, $row)->getCalculatedValue();
			    }
				//13 - Serial
				$isserial = trim($objWorksheet->getCellByColumnAndRow(13, $row)->getValue());
				if(substr($isserial,0,1)=='='){
					$isserial = $objWorksheet->getCellByColumnAndRow(13, $row)->getCalculatedValue();
			    }
				$isserial = $this->site->friendlyURL($isserial);	
				if($isserial == 'co'){
					$isserial = 1;
				}
				else{
					$isserial = 0;
				}
				//14 - Han su dung
				$shelflife = trim($objWorksheet->getCellByColumnAndRow(14, $row)->getValue());
				$shelflife = $this->site->friendlyURL($shelflife);	
				if(substr($shelflife,0,1)=='='){
					$shelflife = $objWorksheet->getCellByColumnAndRow(14, $row)->getCalculatedValue();
			    }
				if($shelflife == 'co'){
					$shelflife = 1;
				}
				else{
					$shelflife = 0;
				}
				//15 - Ma nha cung cap
				$goods_code2 = trim($objWorksheet->getCellByColumnAndRow(15, $row)->getValue());
				if(substr($goods_code2,0,1)=='='){
					$goods_code2 = $objWorksheet->getCellByColumnAndRow(15, $row)->getCalculatedValue();
			    }
				//16 - Quy doi
				$exchange = trim($objWorksheet->getCellByColumnAndRow(16, $row)->getValue());
				if(substr($exchange,0,1)=='='){
					$exchange = $objWorksheet->getCellByColumnAndRow(16, $row)->getCalculatedValue();
			    }
				//17 - Don vui quy doi
				$exchange_unit = trim($objWorksheet->getCellByColumnAndRow(17, $row)->getValue());
				if(substr($exchange_unit,0,1)=='='){
					$exchange_unit = $objWorksheet->getCellByColumnAndRow(17, $row)->getCalculatedValue();
			    }
				//kiem tra ma hang
				$check = $this->model->table($tb['hotel_goods'])
							  ->select('id')
							  ->where('isdelete',0)
							  ->where('goods_code',$goods_code)
							  ->find();
				$goods_types = $this->site->friendlyURL($goods_type);	 
				$goods_type_check = $this->model->table($tb['hotel_goods_type'])
							  ->select('id')
							  ->where('isdelete',0)
							  ->where('friendlyurl',$goods_types)
							  ->find();
				if(!empty($goods_type_check->id)){
					$goods_type_id = $goods_type_check->id;
				}
				else{
					$goods_type_id = 0;
				}
				//Kiem tra don vi tinh
				$unitids = $this->site->friendlyURL($unitid);
				$unit_check = $this->model->table($tb['hotel_unit'])
							  ->select('id')
							  ->where('isdelete',0)
							  ->where('friendlyurl',$unitids)
							  ->find();
				if(!empty($unit_check->id)){
					$unnit_id = $unit_check->id;
				}
				else{
					$unnit_id = 0;
				}
				//Don vi quy doi
				$exchange_unit_url = $this->site->friendlyURL($exchange_unit);
				$unit_change_check = $this->model->table($tb['hotel_unit'])
							  ->select('id')
							  ->where('isdelete',0)
							  ->where('friendlyurl',$exchange_unit_url)
							  ->find();
				if(!empty($unit_change_check->id)){
					$unit_chang_id = $unit_change_check->id;
				}
				else{
					$unit_chang_id = 0;
				}
				
				$arrInsert = array();
				$arrInsert['goods_code'] = $goods_code;
				$arrInsert['goods_type'] = $goods_type_id;
				$arrInsert['madein'] = $madein;
				$arrInsert['discountsales'] = str_replace('%','',$discountsales);
				$arrInsert['discounthotel_type'] = $discounthotel_type;
				
				$arrInsert['discounthotel_dly'] =  str_replace('%','',$discounthotel_dly);
				$arrInsert['discounthotel_type_dly'] = $discounthotel_type_dly;
				$arrInsert['unitid'] = $unnit_id;
				$arrInsert['sale_price'] = $sale_price;
				$arrInsert['buy_price'] = $buy_price;
				$arrInsert['description'] = $description;
				$arrInsert['goods_name'] = $goods_name;
				
				$arrInsert['datecreate'] = $datecreate;
				$arrInsert['usercreate'] = $usercreate;
				$arrInsert['quantitymin'] = $quantitymin;
				$arrInsert['isserial'] = $isserial;
				$arrInsert['shelflife'] = $shelflife;
				$arrInsert['goods_code2'] = $goods_code2;
				$arrInsert['exchange'] = $exchange;
				$arrInsert['exchange_unit'] = $unit_chang_id;
				
				if(empty($check->id)){
					$this->model->table($tb['hotel_goods'])->insert($arrInsert);
					$description = "Import: ".$goods_code.' - '.$goods_name;
					$this->base_model->addAcction(getLanguage('hang-hoa'),$this->uri->segment(2),'','',$description);
				}
				else{
					$this->model->table($tb['hotel_goods'])->save($check->id,$arrInsert);
					$description = "Import: Sửa ".$goods_code.' - '.$goods_name;
					$this->base_model->addAcction(getLanguage('hang-hoa'),$this->uri->segment(2),'','',$description);
				}
		 }
		 $this->db->trans_complete();
		 $result = new stdClass();
		 $result->status = 1; 
		 $result->content ="Import thành công ".($row-2)." hàng hóa.";
		 echo json_encode($result);
		 exit;
	}
	function loadRawdata(){
		
	}
}