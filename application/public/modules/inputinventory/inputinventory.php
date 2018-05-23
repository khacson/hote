<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author  
 * @copyright 2018
 */
class Inputinventory extends CI_Controller {
    private $route;
	private $login;
	function __construct(){
		parent::__construct();	
		$this->load->model(array('model','base_model','excel_model'));
		$this->login = $this->site->getSession('login');
		$this->route = $this->router->class;
		$menus = $this->site->getSession('menus');
		$this->title = $menus[$this->route];
		$this->site->setTemplate('close');
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
		$companyid = $this->login->companyid;
		$branchid = $this->login->branchid;
	    $data->permission = $permission;
		$data->csrfName = $this->security->get_csrf_token_name();
		$data->csrfHash = $this->security->get_csrf_hash();		
	    $data->controller = base_url().$this->route;
		$data->routes = $this->route;
		$data->ponumbers = $this->model->getPonumber(); 
		$data->setuppo = $this->login->setuppo;
		//$data->odersList = $this->base_model->getGoodsAutoCompeleteDH(''); 
		$data->suppliers = $this->base_model->getSupplier('');
		$data->warehouses = $this->base_model->getWarehouse('');	
		$data->banks = $this->base_model->getBank();	
		//$data->orders = $this->base_model->getSalesoutput($data->companyid,$data->branchid,0);
		$data->suppliers = $this->base_model->getSupplier('');
		//$data->employeesale = $this->base_model->getEmployeesale('');	
		//$data->getOderList = $this->model->getOderList();
		$data->datecreate  = gmdate("d-m-Y", time() + 7 * 3600);
		$data->users = $this->login->fullname;
		$data->id = $id; 
		
		$content = $this->load->view('view',$data,true);
		$this->site->write('content',$content,true);
		$this->site->write('title',$this->title,true);
        $this->site->render();
	}
	function save() {
		$permission = $this->base_model->getPermission($this->login, $this->route);
		$search = $this->input->post('search');
		$itemList =  $this->input->post('itemList');
		$payments = $this->input->post('payments'); 
		
		$uniqueid = $this->base_model->getUniqueid();
		if (!isset($permission['add'])){
			$result['status'] = 0;
			$result['csrfHash'] = $token;
			echo json_encode($result); exit;	
		}
		$array = json_decode($search,true);
		$isnew = 0;
		$login = $this->login;
		$array['warehouseid'] = 0;
		$arr = $this->model->saves($uniqueid,$itemList,$array,$isnew);
		$result['status'] = $arr['uniqueid'];
		$result['poid'] = $arr['poid'];
		$array['soid']  = '';
		$result['msg'] = $arr['msg'];
		if(empty($arr['msg'])){
			$result['uniqueidnew'] = $this->base_model->getUniqueid();
		}
		$result['csrfHash'] = 0;
		echo json_encode($result);
	}
	function edit(){
		$permission = $this->base_model->getPermission($this->login, $this->route);
		$search = $this->input->post('search');
		$itemList =  $this->input->post('itemList');
		$payments = $this->input->post('payments'); 
		
		$uniqueid = $this->base_model->getUniqueid();
		if (!isset($permission['add'])){
			$result['status'] = 0;
			$result['csrfHash'] = $token;
			echo json_encode($result); exit;	
		}
		$array = json_decode($search,true);
		$isnew = 1;
		$login = $this->login;
		$array['warehouseid'] = 0;
		$arr = $this->model->edits($uniqueid,$itemList,$array,$isnew);
		$result['status'] = $arr['uniqueid'];
		$result['poid'] = $arr['poid'];
		$array['soid']  = '';
		$result['msg'] = $arr['msg'];
		if(empty($arr['msg'])){
			$result['uniqueidnew'] = $this->base_model->getUniqueid();
		}
		$result['csrfHash'] = 0;
		echo json_encode($result);
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
		//$data->fmPrice = $this->base_model->docso($dataprint->price);
		$data->detail = $dataprintDetail;
		$result->content = $this->load->view('printpn', $data, true);
		echo json_encode($result);
	}
	function viewPhieunhapkho(){
		$id = $this->input->post('id');
		$unit = '';
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
		$data->detail = $dataprintDetail;
		$result->content = $this->load->view('viewpnk', $data, true);
		echo json_encode($result);
	}
	function getDataPrintPC(){
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
		//$data->fmPrice = $this->base_model->docso($dataprint->price);
		$data->detail = $dataprintDetail;
		$result->content = $this->load->view('printpn', $data, true);
		echo json_encode($result);
	}
	function formEdit($orderid=''){
		$data = new stdClass();
		$permission = $this->base_model->getPermission($this->login, $this->route);
		if (!isset($permission['view'])) {
	    	redirect('authorize');
	    }
		$companyid = $this->login->companyid;
		$branchid = $this->login->branchid;
	    $data->permission = $permission;
		$data->csrfName = $this->security->get_csrf_token_name();
		$data->csrfHash = $this->security->get_csrf_hash();		
	    $data->controller = base_url().$this->route;
		$data->routes = $this->route;
		$data->setuppo = $this->login->setuppo;
		
		$data->suppliers = $this->base_model->getSupplier('');
		$data->warehouses = $this->base_model->getWarehouse('');	
		$data->banks = $this->base_model->getBank();	
		$data->ponumbers = $this->model->getPonumber(); 
		
		$data->datecreate  = gmdate("d-m-Y", time() + 7 * 3600);
		$data->users = $this->login->fullname;
		$data->id = $orderid; 
		
		$details = $this->model->findListUniqueID($orderid);
		if(empty($details[0]->uniqueid)){
			redirect('historyinput');
		}
		$data->finds = $details[0];
		$data->poid = $details[0]->poid; 
		$data->uniqueid = $details[0]->uniqueid;
		$isnew = 1;
		//Xoa tao lai
		$this->model->deleteTempDataNew($isnew);  
		$this->model->checkTempData($details,$isnew);
		
		$content = $this->load->view('edit',$data,true);
		$this->site->write('content',$content,true);
		$this->site->write('title',$this->title,true);
        $this->site->render();
		
	}
	function formAddOder(){
		$data = new stdClass();
		$permission = $this->base_model->getPermission($this->login, $this->route);
		if (!isset($permission['view'])) {
	    	redirect('authorize');
	    }
		if(!isset($_GET['so'])){
			$this->_view();
		}
		$so = $_GET['so'];
		$so = str_replace('"','',$so);
		$id = $this->uri->segment(2);
		$companyid = $this->login->companyid;
		$branchid = $this->login->branchid;
	    $data->permission = $permission;
		$data->csrfName = $this->security->get_csrf_token_name();
		$data->csrfHash = $this->security->get_csrf_hash();		
	    $data->controller = base_url().$this->route;
		$data->routes = $this->route;
		//$data->suppliers = $this->base_model->getSupplier('');
		$data->warehouses = $this->base_model->getWarehouse('');	
		//$data->units = $this->base_model->getUnit('');	
		//$data->orders = $this->base_model->getSalesoutput($data->companyid,$data->branchid,0);
		$data->customers = $this->base_model->getCustomer('');
		//$data->employeesale = $this->base_model->getEmployeesale($companyid,$branchid);	
		$data->setuppo = $this->login->setuppo;
		$data->finds = $this->model->findOrderSO($so);
		$data->datecreate  = gmdate("d-m-Y", time() + 7 * 3600);
		$data->users = $this->login->fullname;
		$data->id = $id; 
		$datas =  $this->model->getTempGoodSO($so); 
		$data->datas = $datas;
		if(isset($datas[0]->uniqueid)){
			$data->uniqueid = $datas[0]->uniqueid;
		}
		else{
			$data->uniqueid = 0;
		}
		$data->so = $so;
		$content = $this->load->view('formaddoder',$data,true);
		$this->site->write('content',$content,true);
		$this->site->write('title',$this->title,true);
        $this->site->render();
	}
	function getGoods(){
		$id = $this->input->post('id');
		$code = $this->input->post('code');
		$stype = $this->input->post('stype');
		$exchangs = $this->input->post('exchangs');
		$delete = $this->input->post('deletes');
		$isnew = $this->input->post('isnew');
		$vat = $this->input->post('vat');
		$xkm = $this->input->post('xkm');
		$uniqueid = $this->input->post('uniqueid');
		$result = $data = new stdClass();		
		//Lay hinh anh
		$tb = $this->base_model->loadTable();
		$findgoods = $this->model->table($tb['hotel_goods'])
								 ->select('id,unitid,unitid_active,goods_code,img,discountsales_dly,discountsales_type_dly,sale_price')
								 ->where('goods_code',$code )
								 ->where('isdelete',0)
								 ->find();
		if(empty($findgoods->id) && $delete != 'delete'){
			$result->status = 0;
			echo json_encode($result);
			exit;
		}
		if(!empty($findgoods->id)){
			$result->imgs = $findgoods->img;
			$query = $this->model->findGoods($id,$code,$stype,$exchangs,$delete,$isnew,$xkm,$uniqueid,$findgoods);
			$data->datas = $query;
			$tt = 0; 
			$result->uniqueid = $uniqueid;
			$result->content = $this->load->view('listAdd', $data, true);
		}
		$result->status = 1;
		echo json_encode($result);
	}
	function loadDataTempAdd(){
		$result = $data = new stdClass();	
		$isnew = $this->input->post('isnew');
		$userid =  $this->login->id;
		$data->datas = $this->model->getTempGood($userid,$isnew);
		$result->content = $this->load->view('listAdd', $data, true);
		echo json_encode($result);
	}
	function addSupplier(){
		$result = $data = new stdClass();
		$data->provinces = $this->base_model->getProvince();
		$result->content = $this->load->view('formAddSupplier', $data, true);
		echo json_encode($result);
	}
	function saveSupplier(){
		$search = $this->input->post('search');
		$array = json_decode($search,true);
		$result = new stdClass();
		$login = $this->login;
		$array['datecreate']  = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
		$array['usercreate'] = $this->login->username;
		$status = $this->model->saveSupplier($array);
		if($status != -1){
			$result->suppliers = $this->getSupplier($status);
			$result->status = $status;
		}
		else{
			$result->suppliers = "";
			$result->status = $status;
		}
		$description = 'Thêm mới: '.$array['_a_supplier_name'];
		$this->base_model->addAcction('Nhập kho - Nhà cung cấp',$this->uri->segment(2),'','',$description );
		echo json_encode($result);
	}
	function getSupplier($id){
		$suppliers = $this->base_model->getSupplier('');
		$html = '<select id="supplierid" name="supplierid" class="combos" >
		<option value=""></option>';
		foreach($suppliers as $item){
			if($item->id == $id){
				$slect = "selected";
			}
			else{
				$slect = "";
			}
			$html.= '<option '.$slect.'  value="'.$item->id .'">'.$item->supplier_name .'</option>';
		}
		$html.= '</select>';
		return $html;
	}
	function loadSupplierByPO(){
		$poid = $this->input->post('poid');
		$suppliers = $this->model->getSupplier($poid);
		$html = '<select id="supplierid" name="supplierid" class="select2me form-control" >';
		foreach($suppliers as $item){
			$html.= '<option value="'.$item->id .'">'.$item->supplier_name .'</option>';
		}
		$html.= '</select>';
		echo $html;
	}
	function deleteTempData(){
		$goodid = $this->input->post('goodid');
		$this->model->deleteTempData($goodid);
	}
	function deleteTempDataEdit(){
		$goodid = $this->input->post('goodid');
		$detailid = $this->input->post('detailid');
		$status = $this->model->deleteTempDataEdit($goodid,$detailid);
		echo $status;
	}
	function updatePriceOne(){
		$goodid = $this->input->post('goodid');
		$quantity = $this->input->post('quantity');
		$priceone = $this->input->post('priceone');
		$discount = $this->input->post('discount');
		$xkm = $this->input->post('xkm');
		$isnew = $this->input->post('isnew');
		$unitid = $this->input->post('unitid');
		$data = $this->model->updatePriceOne($goodid,$priceone,$quantity,$discount,$xkm,$isnew,$unitid);
		$result = new stdClass();
		$result->price = fmNumber($data->price);
		$result->discount = fmNumber($data->discount);
		$result->priceEnd = fmNumber($data->price - $data->discount);		
		echo json_encode($result); exit;
	}
	function getNewPrice(){
		$isnew = $this->input->post('isnew');
		$data = $this->model->getNewPrice($isnew);
		$result = new stdClass();
		$result->price = fmNumber($data->price);
		$result->discount = fmNumber($data->discount);
		$result->priceEnd = fmNumber($data->price - $data->discount);		
		echo json_encode($result); exit;
	}
	function updateUnit(){
		$goodid = $this->input->post('goodid');
		$unitid = $this->input->post('unitid');
		$isnew = $this->input->post('isnew');
		$this->model->updateUnit($goodid,$unitid,$isnew);
	}
	/*function getDiscountorder(){
		$result = $data = new stdClass();		
 		$goodid = $this->input->post('goodid');
		$price = $this->input->post('price');
		$isnew = $this->input->post('isnew');
		$data->price = $price;
		$data->find = $this->model->getDiscountorder($goodid,$price,$isnew);		
		$result->content =  $this->load->view('discount', $data, true);
		echo json_encode($result);
	}*/
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
	function getFindGoods(){ 
		$goodscode = $this->input->post('goodscode');
		$query = $this->base_model->getGoodsAutoCompeleteIN($goodscode); 
		echo json_encode($query);
	}
	function import(){ 
		  include(APPPATH.'libraries/excel2013/PHPExcel/IOFactory'.EXT);
		  $filename = $_FILES['userfile']['name'];
		  if(@move_uploaded_file($_FILES['userfile']['tmp_name'], $filename))
		  $file= $filename;
		  $login = $this->login;
		  $datecreate  = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
		  $usercreate = $login->username;
		  $skey = $login->skey;
		  $tb = $this->base_model->loadTable();
		  $inputFileType = PHPExcel_IOFactory::identify($file);
		  $objReader = PHPExcel_IOFactory::createReader($inputFileType);
		  $objReader->setReadDataOnly(true);
		  $objPHPExcel = $objReader->load($file);
		  $objPHPExcel->setActiveSheetIndex(0);
		  $objWorksheet = $objPHPExcel->getActiveSheet();
		  $highestRow = $objWorksheet->getHighestRow(); // e.g. 10
		  $highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'
		  $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // e.g. 5

		  $branchid = $login->branchid;
		  $companyid =  $login->companyid;
 		  $i=1;
		  $result = new stdClass();
		  $str = "";
		  if($highestRow > 501){
			 $result->status = -1; 
			 $result->content = $str;
			 echo json_encode($result);
			 exit;
		  }
		  //hotel_supplier
		  $arrSupplier = $this->model->table($tb['hotel_supplier'])
							   ->select('supplier_code,id')
							   ->where('isdelete',0)
							   ->find_combo('supplier_code','id');
		  //Hang hoa
		  $arrGoods = $this->model->table($tb['hotel_goods'])
							   ->select('goods_code,id')
							   ->where('isdelete',0)
							   ->find_combo('goods_code','id');
		  $setuppo = cfso(); 
		  $arr = array();
		  $arr_po = array(); $arr_goodsCode = array();
		  $arrs =  array();
		  for ($row = 2; $row <= $highestRow; ++$row){
			   $goods_code = trim($objWorksheet->getCellByColumnAndRow(1, $row)->getValue());
			   if(substr($goods_code,0,1)=='='){
					$goods_code = $objWorksheet->getCellByColumnAndRow(1, $row)->getCalculatedValue();
			   }			   
			   if($goods_code == ''){
				     $arr[0] =  '- Mã hàng không được trống.<br>';
			   }
			   $findGoods = $this->model->table($tb['hotel_goods'])
							   ->select('goods_code,id')
							   ->where('isdelete',0)
							   ->where('goods_code',$goods_code)
							   ->find();
				if(empty($findGoods->id)){
					 $arr['6_'.$row] = "Mã hàng `$goods_code` không tồn tại. <br>";
				}
			    $isupplier = trim($objWorksheet->getCellByColumnAndRow(3, $row)->getValue());
			    if(substr($isupplier,0,1)=='='){
					$isupplier = $objWorksheet->getCellByColumnAndRow(3, $row)->getCalculatedValue();
			    }	
			    if($isupplier == ''){
				     $arr[1] =  '- Mã nhà cung cấp không được trống.<br>';
			    }
			    $arrs[$isupplier] = $row;
			   //Kiem tra nha cung cap
			   $findSupplier = $this->model->table($tb['hotel_supplier'])
							   ->select('supplier_code,id')
							   ->where('isdelete',0)
							   ->where('supplier_code',$isupplier)
							   ->find();
				//Kiem tra nha cung cap
				if(empty($findSupplier->id)){
				      $arr['2'.$row] =  '- Mã nhà cung cấp "'.$isupplier.'" không tồn tại <br>';
				}
		  }
		  $str = '';
		  foreach($arr as $k=>$v){
			  $str.= $v;
		  }
		  if($str != ""){
			 $result->status = 0; 
			 $result->content = $str;
			 echo json_encode($result);
			 exit;
		  }
		  $this->db->trans_start();
		  $skey = $this->login->skey;
		  //$poid = $this->model->getPOMax($companyid);					 
		  //setuppo
		  $tt = 0; $totalQuantity = 0;
		  for ($row = 2; $row <= $highestRow; ++$row){
			     $uniqueid = $this->base_model->getUniqueid();
				 //Lay danh sanh don hang
				 $dateMonth  = gmdate("Y-m", time() + 7 * 3600);
			     $listPO =  $this->model->createPoOrder($branchid,$dateMonth);
			     $poid = $listPO['poid'];
			     $stt = $listPO['stt'];	 
				//Cột 1 - Mã hàng
				$goods_code = trim($objWorksheet->getCellByColumnAndRow(1, $row)->getValue()); 
				if(substr($goods_code,0,1)=='='){
					$goods_code = $objWorksheet->getCellByColumnAndRow(1, $row)->getCalculatedValue();
				}
				$findGoods = $this->model->table($tb['hotel_goods'])
							   ->select('goods_code,id')
							   ->where('isdelete',0)
							   ->where('goods_code',$goods_code)
							   ->find();
				if(!empty($findGoods->id)){
					$goodsid = $findGoods->id;
				}
				else{
					$goodsid = -1;
				}
				//Cột 3 - Nhà cung cấp
				$isupplier = trim($objWorksheet->getCellByColumnAndRow(3, $row)->getValue());
				if(substr($isupplier,0,1)=='='){
					$isupplier = $objWorksheet->getCellByColumnAndRow(3, $row)->getCalculatedValue();
				}	
				$findSupplier = $this->model->table($tb['hotel_supplier'])
							   ->select('supplier_code,id')
							   ->where('isdelete',0)
							   ->where('supplier_code',$isupplier)
							   ->find();
				//Kiem tra nha cung cap
				if(!empty($findSupplier->id)){
				   $isupplierid = $findSupplier->id; 
				}
				else{
					$isupplierid = -1;
				}
				//Cột 4 - số lượng
				$iquantity = trim($objWorksheet->getCellByColumnAndRow(6, $row)->getValue());
				if(substr($iquantity,0,1)=='='){
					$iquantity = $objWorksheet->getCellByColumnAndRow(6, $row)->getCalculatedValue();
				}
				if(empty($iquantity)){
					$iquantity = 0;
				}
				//Côtj 5 Đơn giá
				$priceone = trim($objWorksheet->getCellByColumnAndRow(5, $row)->getValue());
				if(substr($priceone,0,1)=='='){
					$priceone = $objWorksheet->getCellByColumnAndRow(5, $row)->getCalculatedValue();
				}	
				//Cột 6 - Thanh toán
				$payments = trim($objWorksheet->getCellByColumnAndRow(6, $row)->getValue());
				if(substr($payments,0,1)=='='){
					$payments = $objWorksheet->getCellByColumnAndRow(6, $row)->getCalculatedValue();
				}
				//Cột 7 Ghi chu
				$description = trim($objWorksheet->getCellByColumnAndRow(7, $row)->getValue());
				if(substr($description,0,1)=='='){
					$description = $objWorksheet->getCellByColumnAndRow(7, $row)->getCalculatedValue();
				}
				$prices = $priceone * $iquantity;
				//Them du lieu
				$insertInput = array();
				$insertInput['sttview'] = $row;
				$insertInput['goodsid'] = $goodsid;
				$insertInput['price'] = rNumber($prices);
				$insertInput['priceone'] = $priceone;
				$insertInput['quantity'] = $iquantity;
				$insertInput['uniqueid'] = $uniqueid;
				$insertInput['poid'] = $poid;
				$insertInput['datecreate'] = $datecreate;
				$insertInput['usercreate'] = $this->login->username;
				$insertInput['branchid'] = $branchid;
				$this->model->table($tb['hotel_input'])->insert($insertInput);
				//Kiêm tra so luong trong kho
				$check = $this->model->table($tb['hotel_inventory'])
										->select('id,quantity')
										->where('branchid',$branchid)
										->where('goodsid',$goodsid)
										->find();
				if(empty($check->id)){ // Chua co trong kho
					$arr_inventory = array();
					$arr_inventory['goodsid'] = $goodsid;
					$arr_inventory['warehouseid'] = 0;
					$arr_inventory['branchid'] = $branchid;
					$arr_inventory['quantity'] = $iquantity;
					$this->model->table($tb['hotel_inventory'])->insert($arr_inventory);
				}
				else{ // Da co trong kho
					$sqlUpdate = "
						UPDATE `".$tb['hotel_inventory']."` SET `quantity`= `quantity` + ".$iquantity." WHERE `id`='".$check->id ."';
					";
					$this->model->executeQuery($sqlUpdate);
				}
				#end
				 #region ghi phieu chi
				 $pay_code = $this->model->createPOPay($branchid,$datecreate);
				 $arrIS =  array();
				 
				 $arrIS['uniqueid'] = $uniqueid;
				 $arrIS['branchid'] = $branchid;
				 $arrIS['pay_type'] = 1;
				 $arrIS['payment'] = $payments; 
				 $arrIS['amount'] = $prices;
				 $arrIS['poid'] = $poid;
				 $arrIS['usercreate'] = $this->login->username;
				 $arrIS['datecreate'] = $datecreate;
				 $arrIS['pay_code'] = $pay_code;
				 $arrIS['datepo'] = $datecreate;
				 $this->model->table($tb['hotel_pay'])->insert($arrIS);
				 #end
				 #region Them bang don hang
				 $insert['warehouseid'] = 0;
				 $insert['branchid'] = $branchid;
				 $insert['description'] = $description;
				 $insert['payments'] = $payments;
				 $insert['supplierid'] = $isupplierid;
				 $insert['datecreate'] = $datecreate;
				 $insert['usercreate'] = $this->login->username;
				 $insert['uniqueid'] = $uniqueid;
				 $insert['poid'] = $poid;
				 $insert['quantity'] = fmNumberSave($totalQuantity);
				 $insert['price'] = fmNumberSave($tt);
				
				 $insert['datepo'] = $datecreate;
				 $insert['stt'] = $stt;
				 $insert['percent'] = 2;
				 $insert['signature'] = $this->login->signature;
				 $insert['signature_name'] = $this->login->fullname;
				 $this->model->table($tb['hotel_input_createorders'])->insert($insert);
				 #end
		 }
		
		 $this->db->trans_complete();
		 $result = new stdClass();
		 $result->status = 1; 
		 $result->content ="Nhập thành công ".($row-2)." hàng hóa.";
		 echo json_encode($result);
		 exit;
	}
}