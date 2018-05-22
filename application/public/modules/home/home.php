<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author Son Nguyen 
 * @copyright 2015
 */
class Home extends CI_Controller {
    private $route;
	private $login;
	function __construct(){
		parent::__construct();	
		$this->load->model(array('model','base_model'));
		$this->login = $this->site->getSession('login');
		$lang = $this->site->lang;
		$this->route = $this->router->class;
		$this->site->setTemplate('home');
	}
	function _remap($method, $params = array()) {
        if (method_exists($this, $method)) {
            return call_user_func_array(array($this, $method), $params);
        }
        $this->_view();
    }
	function _view(){
		$data = new stdClass();
		$today =  gmdate("Y-m-d", time() + 7 * 3600); 
		$yesterday = date('Y-m-d',strtotime(date("Y-m-d", strtotime($today))." -1 day")); 
		$data->csrfName = $this->security->get_csrf_token_name();
		$data->csrfHash = $this->security->get_csrf_hash();		
	    $data->controller = base_url().$this->route;
		$data->routes = $this->route;
		
		$data->branchs = $this->base_model->getBranch('');
		$data->dates = gmdate("n/Y", time() + 7 * 3600); 
		
		$year = gmdate("Y", time() + 7 * 3600);
		$month = gmdate("m", time() + 7 * 3600);
		$now = (int)gmdate("d", time() + 7 * 3600);
		$time = strtotime("$year-$month-1");
		$n = date('t',$time); 
		
		$fromdate = $year.'-'.$month.'-01';
		$todate = $year.'-'.$month.'-'. gmdate("d", time() + 7 * 3600); 
		
		
		$dateNow =  gmdate("d-m-Y", time() + 7 * 3600); 
		$week = strtotime(date("d-m-Y", strtotime($dateNow))." -1 week"); 
		$week = strftime("%d/%m/%Y", $week);
		$data->todates = $dateNow;
		$data->fromdates = $week;
		
		$title_page = 'Quản lý khách sạn, resort, nhà nghỉ';
		
		$content = $this->load->view('view',$data,true);
		$this->site->write('content',$content,true);
		$this->site->write('title',$title_page,true);
        $this->site->render();
	}
	function getGeneralSearch(){
		$result = new stdClass();
		$data = new stdClass();
		$datetime = $this->input->post('datetime');
		$branchid = $this->input->post('branchid');
		$arrDate = explode('-',$datetime);
		if(isset($arrDate[0])){
			$formDate = $this->site->friendlyURL(trim($arrDate[0]));
			$formDate = date('Y-m-d',strtotime($formDate));
		}
		else{
			$formDate = '';
		}
		if(isset($arrDate[1])){
			$toDate = $this->site->friendlyURL(trim($arrDate[1]));
			$toDate = date('Y-m-d',strtotime($toDate));
		}
		else{
			$toDate = '';
		}
		$today =  $toDate; 
		$yesterday = date('Y-m-d',strtotime(date("Y-m-d", strtotime($today))." -1 day")); 
		//$data->customers = $this->model->getCustomer()->total;
		$doanhthutrongngays = $this->model->doanhThuTrongNgay($today,$today);
		$homqua = $this->model->doanhThuTrongNgay($yesterday,$yesterday);
		$result->doanhthutrongngays = number_format($doanhthutrongngays);
		$sovoihomqua = $doanhthutrongngays -  $homqua;
		if($sovoihomqua > 0){
			$sovoihomquas = '+'.number_format($sovoihomqua);
		}
		else{
			$sovoihomquas = number_format($sovoihomqua);
		}
		$result->sovoihomquas = $sovoihomquas;
		$result->customers = $this->model->getCustomer()->total;
		$result->suppliers = $this->model->getSupplier()->total;
		$result->oders = $this->model->getCountOder($formDate, $toDate);
		echo json_encode($result);
	}
	function getEmployee(){
		$schoolid = $this->login->schoolid;
		$departmentid = $this->input->post('departmentid');
		$radio = $this->input->post('radio');
		$employees = $this->base_model->getEmployee($schoolid,$departmentid);
		$html = '<select name="staffid" id="staffid" class="combos" >';
		if(!empty($radio)){
			$html.= '<option value=""></option>';
		}
		foreach($employees as $item){
			if(empty($item->code)){
				$employeeName = $item->fullname;
			}
			else{
				$employeeName = $item->code .' - '.$item->fullname;
			}
			$html.= '<option value="'.$item->id .'">'.$employeeName.'</option>';
		}
		$html.= '</select>';
		echo $html;
	}
	function search(){
		$result = $data = new stdClass();
		$datetime = $this->input->post('datetime');
		$branchid = $this->input->post('branchid');
		$arrDate = explode('-',$datetime);
		if(isset($arrDate[0])){
			$formDate = $this->site->friendlyURL(trim($arrDate[0]));
			$formDate = date('Y-m-d',strtotime($formDate));
		}
		else{
			$formDate = '';
		}
		if(isset($arrDate[1])){
			$toDate = $this->site->friendlyURL(trim($arrDate[1]));
			$toDate = date('Y-m-d',strtotime($toDate));
		}
		else{
			$toDate = '';
		}
		//Tong doanh thu
		$doanhthu = $this->model->doanhThuTrongNgay($formDate,$toDate);
		if(empty($doanhthu)){
			$result->doanhthu = 0 . 'đ';
		}
		else{
			$result->doanhthu = number_format($doanhthu). 'đ';
		}
		//Theo so luong
		$query = $this->model->getOrdersList($formDate,$toDate,$branchid);
		$bill = $this->bill($query);
		$data->bill = $bill;
		$result->content = $this->load->view('bill', $data, true);
		
		//Theo tien
		//$queryPrice = $this->model->getOrdersListPrice($formDate,$toDate,$branchid);
		//$billPrice = $this->bill($queryPrice);
		//$data->billPrice = $billPrice;
		//$result->content2 = $this->load->view('bill2', $data, true);	
		$queryPrice = $this->model->getByCatalog($formDate,$toDate,$branchid);
		$data2 = new stdClass();
		$billPrice = $this->bill2($queryPrice);
		$data2->billPrice = $billPrice;
		$result->content2 = $this->load->view('bill2', $data2, true);	
		
		//Thong ke theo hang
		$queryOuputGoods = $this->model->getOrdersListOutgoods($formDate,$toDate,$branchid); 
		//print_r($queryOuputGoods); exit;
		$billInput = $this->bill2($queryOuputGoods);
		
		$data->billInput = $billInput;
		$result->content3 = $this->load->view('bill3', $data, true);
		//Chart Clm
		$clm = $this->clmChart($formDate, $toDate);
		$data->listdate = $clm;
		$data->dates = date('d/m/Y',strtotime($formDate)).' đến '.date('d/m/Y',strtotime($toDate));
		$result->content4 = $this->load->view('bill4', $data, true);
		echo json_encode($result);
	}
	function bill2($data){
		$str = '';
		foreach($data as $item){
			if(empty($item->total)){
				$precents = 0;
			}
			else{
				$precents = $item->total;
			}
			$goods_name = $item->goods_name;
			$str.= ",{name: '".$goods_name."',y:".$precents."}";
		}
		if(!empty($str)){
			$str = substr($str,1);
		}
		return $str;
	}
	function bill($data){
		/*$total = 0;
		foreach($data as $item){
			$total+= $item->total;
		}*/
		$str = '';
		foreach($data as $item){
			//$precent = $item->total/$total *100;
			if(empty($item->total)){
				$precents = 0;
			}
			else{
				$precents = $item->total;
			}
			$date = date('d-m-Y',strtotime($item->datecreate));
			$str.= ",{name: '".$date."',y:$precents}
			";
		}
		if(!empty($str)){
			$str = substr($str,1);
		}
		return $str;
	}
	function clmChart($fromdate, $todate){
		$datas = $this->model->getOrders($fromdate, $todate); 
		$str = '';
		$arr = array();
		if(count($datas) > 0){
			foreach($datas as $item){
				$date = date('d-m-Y',strtotime($item->datecreate));
				$prices = round($item->price /1000000,2);
				$str.= ",{name: '$date',y: $prices}";
			}
			$str = substr($str,1);
		}
		else{
			$str = '';
		}
		return $str;
	}
	function deleteData(){
		$sql = "truncate hotel_branch_4;";
		//$this->model->executeQuery($sql);
		
		$sql = "truncate hotel_customer_4;";
		//$this->model->executeQuery($sql);
		
		$sql = "truncate hotel_employeesale_4;";
		$this->model->executeQuery($sql);
		
		$sql = "truncate hotel_export_return_4;";
		$this->model->executeQuery($sql);
		
		$sql = "truncate hotel_export_return_orders_4;";
		$this->model->executeQuery($sql);
		
		$sql = "truncate hotel_goods_4;";
		//$this->model->executeQuery($sql);
		
		$sql = "truncate hotel_goods_type_4;";
		//$this->model->executeQuery($sql);
		
		$sql = "truncate hotel_input_4;";
		$this->model->executeQuery($sql);
		
		$sql = "truncate hotel_input_createorders_4;";
		$this->model->executeQuery($sql);
		
		$sql = "truncate hotel_input_return_4;";
		$this->model->executeQuery($sql);
		
		$sql = "truncate hotel_input_return_orders_4;";
		$this->model->executeQuery($sql);
		
		$sql = "truncate hotel_inventory_4;";
		$this->model->executeQuery($sql);
		
		$sql = "truncate hotel_location_4;";
		$this->model->executeQuery($sql);
		
		$sql = "truncate hotel_output_4;";
		$this->model->executeQuery($sql);
		
		$sql = "truncate hotel_output_createorders_4;";
		$this->model->executeQuery($sql);
		
		$sql = "truncate hotel_pay_4;";
		$this->model->executeQuery($sql);
		
		$sql = "truncate hotel_pay_type_4;";
		$this->model->executeQuery($sql);
		
		$sql = "truncate hotel_receipts_4;";
		$this->model->executeQuery($sql);
		
		$sql = "truncate hotel_receipts_type_4;";
		$this->model->executeQuery($sql);
		
		$sql = "truncate hotel_supplier_4;";
		//$this->model->executeQuery($sql);
		
		$sql = "truncate hotel_unit_4;";
		$this->model->executeQuery($sql);
		
		$sql = "truncate hotel_warehouse_4;";
		$this->model->executeQuery($sql);
		echo "OK";
	}
}