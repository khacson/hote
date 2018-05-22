 <?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author sonnk
 * @copyright 2016
 */
class Import extends CI_Controller {

    var $phonedetail;
    function __construct() {
        parent::__construct();
        $this->load->model(array("excel_model"));
		$this->login = $this->site->getSession('login');
    }
    function _remap($method, $params = array()) {
        $id = $this->uri->segment(2);
        if (method_exists($this, $method)) {
            return call_user_func_array(array($this, $method), $params);
        }
        $this->_view();
    }
    function _view() {
        //$this->site->set_tpl('home');
        //$login = $this->site->GetSession("login");
        
		
		$str = '{ "infor":{ "model": "AppleiPhone 4S", "ios": "7.1.2", "part_no": " MD240LL","imei" :"990002652789858", "capacity": "16", "sn": "C28KK0JKDTD3", "color": "white", "carrier": "Verizon", "bluetooth": "e4:25:e7:62:5d:46", "wifi": "e4:25:e7:62:5d:45", "manufacture": "Apple", "uniqueid": "201405301446091000", "ponumber": "46817", "customer": "Encore", "gsc_elpn": "", "model_no": "", "customer_model": "ERS-MD277LL/A", "baseband": "5.2.00", "elapsed_time_zeroit": "00:01:57", "ulock": " 0 "}, "systemdata":{ "checkfordeadpixel": "1", "audio": "1", "videorecord": "1", "camera": "1", "wifi": "0", "bluetooth": "1", "recordback": "1", "proximitySensor": "1"}, "userdata":{}, "login":{ "username": "sp_rec_03", "workflow": "1","processid": "1"}, "stationid": "2901082014", "destination": "10", "fmip": "3", "ulock": "0"}';
		print_r(json_decode($str));
		exit;
		
		
		$time_begin = date("Y-m-d", strtotime(date("Y-m-d"))- ($report_duration*86400));
		
		print_r($time_begin); exit;
		print_r("<br>");
		print_r(date("Y"));
		print_r("<br>");
		var_dump($w); 
		exit;
		$cer =  base_url().'files/getsupport.pem';
		$url = 'https://getsupport.apple.com/GetCoverage.action';
		$url = 'https://getsupport.apple.com/GetproductgroupList.action';
		
		$data = array('serialId' => 'C8RGR3L1DP0V');
		
        $content = $this->load->view('view', '', true);
        $this->site->write('content', $content, true);
        $this->site->render();
        
    }
    function add() {
        $this->load->helper('form');
        $content = $this->load->view('upload', null, true);
        echo $content;
    }
	function readexcel(){ //Nợ khác HR
		  include(APPPATH.'libraries/excel2013/PHPExcel/IOFactory'.EXT);
		  $filename = $_FILES['myfile']['name'];
		  if(@move_uploaded_file($_FILES['myfile']['tmp_name'], $filename))
		  $file= $filename;
		  $login = $this->login;
		  $datecreate  = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
		  $usercreate = $login->username;

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
		  //Loai hang hoa
		  $goodsType = $this->model->table('hotel_goods_type')
							   ->select('friendlyurl,id')
							   ->where('isdelete',0)
							   ->find_all();
		  $arr_goods_type = array();
		  foreach($goodsType as $item){
			  $arr_goods_type[$item->friendlyurl] = $item->id;
		  }
		  //Don vi tinh
		  $unit = $this->model->table('hotel_unit')
							   ->select('friendlyurl,id')
							   ->where('isdelete',0)
							   ->find_all();
		  $arr_unit = array();
		  foreach($unit as $item){
			  $arr_unit[$item->friendlyurl] = $item->id;
		  }
		
		  /*$sql_insert = "
			INSERT INTO `hotel_goods` (`goods_code`, `goods_name`, `goods_type`, `madein`, `discountsales`, `discounthotel_type`, `unitid`, `sale_price`, `buy_price`, `companyid`, `description`, `datecreate`, `usercreate`) 
			VALUES 
		  ";*/
		  
		  //$this->model->executeQuery("truncate hotel_goods;");
		  $this->model->table('hotel_goods')
					  ->where('companyid', $login->companyid)
					  ->delete();
		  for ($row = 2; $row <= $highestRow; ++$row){
				$goods_code = trim($objWorksheet->getCellByColumnAndRow(1, $row)->getValue()); 
				$goods_name = trim($objWorksheet->getCellByColumnAndRow(2, $row)->getValue());
				$goods_type = trim($objWorksheet->getCellByColumnAndRow(3, $row)->getValue());
				$goods_types = $this->site->friendlyURL($goods_type);	 			
				$unitid = trim($objWorksheet->getCellByColumnAndRow(4, $row)->getValue());
				$unitids = $this->site->friendlyURL($unitid);
				$buy_price = trim($objWorksheet->getCellByColumnAndRow(5, $row)->getValue());
				$sale_price = trim($objWorksheet->getCellByColumnAndRow(6, $row)->getValue());
				$madein = trim($objWorksheet->getCellByColumnAndRow(7, $row)->getValue());
				$discountsales = trim($objWorksheet->getCellByColumnAndRow(8, $row)->getValue());
				//1 phan tran, 2 Tien truc tiep
				
				$discounthotel_type = trim($objWorksheet->getCellByColumnAndRow(9, $row)->getValue());
				if(isset($arr_goods_type[$goods_types])){
					$goods_typeid = $arr_goods_type[$goods_types];
				}
				else{
					if(empty($goods_type)){
						echo "Loại hàng `$goods_type` chưa thêm vào danh mục"; exit;
					}
					else{
						$goods_typeid = 0;
					}
				} 
				if(isset($arr_unit[$unitids])){
					$unitids = $arr_unit[$unitids];
				}
				else{
					if(!empty($unitid)){
						echo "Đơn vị tính `$unitid` chưa thêm vào danh mục"; exit;
					}
					else{
						$unitids = 0;
					}
				}
				 
				$description = trim($objWorksheet->getCellByColumnAndRow(10, $row)->getValue());
				$arr_insert = array();
				$arr_insert['goods_code'] = $goods_code;
				$arr_insert['goods_name'] = $goods_name;
				$arr_insert['goods_type'] = $goods_typeid;
				$arr_insert['madein'] = $madein;
				$arr_insert['discountsales'] = $discountsales;
				$arr_insert['discounthotel_type'] = $discounthotel_type;
				$arr_insert['unitid'] = $unitids;
				$arr_insert['buy_price'] = $buy_price;
				$arr_insert['sale_price'] = $sale_price;
				$arr_insert['companyid'] = $login->companyid;
				$arr_insert['description'] = $description;
				$arr_insert['datecreate'] = $datecreate;
				$arr_insert['usercreate'] = $usercreate;
				$this->model->table('hotel_goods')->insert($arr_insert);
		 }
		 echo "Import thành công ".($row-2)." hàng hóa.";
	}
}








