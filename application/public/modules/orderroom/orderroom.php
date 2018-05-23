<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author Son Nguyen 
 * @copyright 2018
 */
class Orderroom extends CI_Controller {
    private $route;
	private $login;
	function __construct(){
		parent::__construct();	
		$this->load->model(array('model','base_model'));
		$this->login = $this->site->getSession('login');
		$lang = $this->site->lang;
		$this->route = $this->router->class;
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
		$today =  gmdate("Y-m-d", time() + 7 * 3600); 
		$yesterday = date('Y-m-d',strtotime(date("Y-m-d", strtotime($today))." -1 day")); 
		$data->csrfName = $this->security->get_csrf_token_name();
		$data->csrfHash = $this->security->get_csrf_hash();		
	    $data->controller = base_url().$this->route;
		$data->routes = $this->route;
		$login = $this->login;
		
		$data->floors = $this->base_model->getFloor($login->branchid);
		$data->roomTypes = $this->base_model->getRoomType($login->branchid);
		$data->roomLists = $this->model->getRoomList();
		
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
		
		
		$title_page = getLanguage('dat-phong');
		
		$content = $this->load->view('view',$data,true);
		$this->site->write('content',$content,true);
		$this->site->write('title',$title_page,true);
        $this->site->render();
	}
	function loadRoomList(){
		$result= new stdClass();
		$data= new stdClass();
		
		$floorid = $this->input->post('floorid');
		$roomtypeid = $this->input->post('roomtypeid');
		$isstatus = $this->input->post('isstatus');
		
		$data->timenow =  gmdate("d/m/Y H:i", time() + 7 * 3600); 
		$query = $this->model->getRoomList($floorid, $roomtypeid,$isstatus);
		$status = $query['status'];
		$trinhtrangphong = array();
		$trinhtrangphong['phongtrong'] = 0;
		$trinhtrangphong['cokhach'] = 0;
		$trinhtrangphong['chuadon'] = 0;
		$trinhtrangphong['suachua'] = 0;
		$arrFloor = array();
		foreach($status as $item){
			if($item->isstatus == 1){
				$trinhtrangphong['phongtrong'] += $item->total;
				if(isset($arrFloor[$item->floorid])){
					$arrFloor[$item->floorid] += $item->total;
				}
				else{
					$arrFloor[$item->floorid] = $item->total;
				}
			}
			if($item->isstatus == 2){
				$trinhtrangphong['cokhach'] += $item->total;
			}
			if($item->isstatus == 3){
				$trinhtrangphong['chuadon'] += $item->total;
			}
			if($item->isstatus == 4){
				$trinhtrangphong['suachua'] += $item->total;
			}
		} 
		$data->roomLists = $query['datas'];
		$data->roomTotals = $this->model->getRoomType($floorid);
		$result->content = $this->load->view('roomlist', $data, true);	
		echo json_encode($result);
	}
	function roomDetail(){
		$result= new stdClass();
		$data= new stdClass();
		
		$roomid = $this->input->post('roomid');
		
		$data->timenow =  gmdate("d/m/Y H:i", time() + 7 * 3600); 
		$finds = $this->model->findID($roomid);
		$data->hours = gmdate("H", time() + 7 * 3600); 
		$data->minute = gmdate("i", time() + 7 * 3600); 
		
		$data->findService = $this->model->findService($roomid);
		
		$data->fromdate = date(cfdate(),strtotime(gmdate("Y-m-d", time() + 7 * 3600)));
		$data->todate = date(cfdate(),strtotime(gmdate("Y-m-d", time() + 7 * 3600)));
		$data->finds = $finds;
		
		$data->priceLists = $this->model->getPriceList();
		
		$data->title =  getLanguage('dat-phong');
		$result->content = $this->load->view('roomDetail', $data, true);	
		$result->title = getLanguage('phong').' '. $finds->room_name;
		echo json_encode($result);
	}
	function getPrice(){
		$result= new stdClass();
		$data= new stdClass();
		$tb = $this->base_model->loadTable();
		$roomid = $this->input->post('roomid');
		$lease = $this->input->post('lease');//Hinh thu thue
		$price_type = $this->input->post('price_type');//Gia ap dung
		//0 = Giá chuẩn
		//-1 = Giá thương lương
		$prices = 0;
		if($price_type == -1){
			$prices = '';
		}
		elseif($price_type == 0){//Gia chuẩn
			//1 Theo ngày
			//2 Theo giờ
			//3 Theo tuan
			//4 Theo thang
			$getPrice = $this->model->table($tb['hotel_room'])
					  ->where('isdelete',0)
					  ->where('id',$roomid)
					  ->find();
			if($lease == 2){
				$prices = number_format($getPrice->price_hour);
			}
			elseif($lease == 3){
				$prices = number_format($getPrice->price_week);
			}
			elseif($lease == 4){
				$prices = number_format($getPrice->price_month);
			}
			else{
				$prices = number_format($getPrice->price);
			}
		}
		else{//Gia theo đặt
			$getPrice = $this->model->table($tb['hotel_roomprice_detail'])
					  ->where('roomid',$roomid)
					  ->where('roompriceid',$price_type)
					  ->find();
			if(empty($getPrice->id)){
				echo 0; exit;
			}
			if($lease == 2){
				$prices = number_format($getPrice->price_hour);
			}
			elseif($lease == 3){
				$prices = number_format($getPrice->price_week);
			}
			elseif($lease == 4){
				$prices = number_format($getPrice->price_month);
			}
			else{
				$prices = number_format($getPrice->price);
			}
		}
		echo $prices; exit;
		//echo json_encode($result);
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
	function autocompleteSearchName(){
		if(!empty($_GET['name'])){
			$name = $_GET['name'];
			$query = $this->getAutocompleteSearch($name,'');
			ob_clean();
			echo json_encode($query); exit;
		}
	}
	function autocompleteSearchCMND(){
		if(!empty($_GET['cmnd'])){
			$cmnd = $_GET['cmnd'];
			$query = $this->getAutocompleteSearch('',$cmnd);
			ob_clean();
			echo json_encode($query); exit;
		}
	}
	public function getAutocompleteSearch($name,$cmnd){
		ob_clean();
		$tb = $this->base_model->loadTable();
		$name = trim($name);
		$cmnd = trim($cmnd);
		if(!empty($name)){
			$sql = "
				select c.id, c.customer_name, c.phone, c.identity, c.identity_date,c.identity_from, c.address, c.customer_name as label, c.company_name, c.taxcode as company_mst
				from `".$tb['hotel_customer']."` c
				where c.customer_name like '%$name%'
				order by c.customer_name asc
				limit 20
			";
			$query = $this->model->query($sql)->execute();
		}
		else{
			$sql = "
				select c.id, c.customer_name, c.phone, c.identity, c.identity_date,c.identity_from, c.address,  c.customer_name as label, c.company_name, c.taxcode as company_mst
				from `".$tb['hotel_customer']."` c
				where c.identity like '%$cmnd%'
				order by c.identity asc
				limit 20
			";
			$query = $this->model->query($sql)->execute();
		}
		
		
		$array = array();
		#region header
		$objectHeader = new stdClass();
		$objectHeader->stt = "<div class='cchead ccstt'>".getLanguage('stt')."</div>";
		$objectHeader->customer_name = "<div class='cchead customer_name ccstt'>".getLanguage('ten-khach-hang')."</div>";
		$objectHeader->identity = "<div class='cchead identity'>".getLanguage('cmnd')."</div>";
		$objectHeader->phone = "<div class='cchead phone'>".getLanguage('dien-thoai')."</div>";
		$objectHeader->identity_from = '';
		$objectHeader->address = '';
		$objectHeader->identity_date = '';
		$objectHeader->label = '';
		$objectHeader->company_name = '';
		$objectHeader->company_mst = '';
		$array[0] = $objectHeader;
		$i= 1;
		#end
		foreach($query as $item){
			
			$ngayxuat = $item->ngayxuat;
			$object = new stdClass();
			$object->stt = $i;
			$object->id = $item->id;
			$object->customer_name = $item->customer_name;
			$object->identity = $item->identity;
			$object->phone = $item->phone;
			$object->identity_from = $item->identity_from;
			$object->address = $item->address;
			$object->identity_date = date(cfdate(),strtotime($item->identity_date));
			if(empty($item->identity_date)){
				$object->identity_date = '';
			}
			$object->label = $item->label;
			$object->company_name = $item->company_name;
			$object->company_mst = $item->company_mst;
			$array[$i] = $object;
			$i++;
		}
		return $array;
	}
	function getFindGoods(){
		$goodscode = $this->input->post('goodscode');
		$query = $this->base_model->getGoodsAutoCompeleteIN($goodscode); 
		echo json_encode($query);
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
		$roomid = $this->input->post('roomid');
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
			$query = $this->model->findGoods($id,$code,$stype,$exchangs,$delete,$isnew,$xkm,$uniqueid,$findgoods,$roomid);
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
		$roomid = $this->input->post('roomid');
		$data->datas = $this->model->getTempGood($userid,$isnew,$roomid);
		$result->content = $this->load->view('listAdd', $data, true);
		echo json_encode($result);
	}
	function deleteTempData(){
		$detailid = $this->input->post('detailid');
		$this->model->deleteTempData($detailid);
	}
	function tabcustomerLoad(){
		$result =  new stdClass();	
		$data = new stdClass();	
		$roomid = $this->input->post('roomid');
		//$data->datas = $this->model->getTempGood($userid,$isnew,$roomid);
		$result->content = $this->load->view('customerOther', $data, true);
		echo json_encode($result);
	}
	function tabserviceLoad(){
		$result =  new stdClass();	
		$data = new stdClass();	
		$roomid = $this->input->post('roomid');
		$data->roomid = $roomid;
		//$data->datas = $this->model->getTempGood($userid,$isnew,$roomid);
		$result->content = $this->load->view('service', $data, true);
		echo json_encode($result);
	}
	function save(){
		$permission = $this->base_model->getPermission($this->login, $this->route);
		$array = json_decode($this->input->post('search'),true);
		$itemList = $this->input->post('itemList');
		$otherCus = $this->input->post('otherCus');
		$roomid = $this->input->post('roomid');
		$id = $this->input->post('id');
		if (!isset($permission['add'])){
			$result['status'] = 0;
			$result['csrfHash'] = $token;
			echo json_encode($result); exit;	
		}
		$arr = $this->model->saves($array,$itemList,$otherCus,$roomid,$id);
		$result['status'] = $arr['status'];
		$result['msg'] = $arr['msg'];
		echo json_encode($result);
		exit;
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
}