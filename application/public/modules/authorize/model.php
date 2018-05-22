<?php
/**
 * @author Son Nguyen
 * @copyright 2015
 */
 class AuthorizeModel extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	function infoCompany($companyid){ //Lay so kho so chi nhanh
		$sql = "
			SELECT DES_DECRYPT(c.`skeys`,'sonnk2504') AS skeys, c.count_warehouse,c.count_branch, c.id, c.mst
			FROM `hotel_company` c
			WHERE c.id = '$companyid'
		";
		$query = $this->model->query($sql)->execute();
		return $query[0];
	}
	function login($u, $p) {
		$sql = "
			SELECT cf.* , u.id, u.username,u.password ,u.fullname, u.mobile, u.email, u.groupid, 
			u.image,u.signature,g.groupname, g.grouptype, g.params, c.company_name, g.companyid, 
			u.branchid, c.count_room, c.count_branch, c.phone as cphone, 
			c.address as caddress, c.fax as cfax, p.province_name, d.distric_name, u.departmentid,
			c.logo,signature,DES_DECRYPT(c.`skeys`,'sonnk2504') as skey, c.mst, c.setuppo
			
						FROM hotel_users u
						LEFT Join hotel_groups g on g.id = u.groupid
						LEFT Join hotel_company c on c.id = g.companyid and u.isdelete = 0
						LEFT Join hotel_province p on p.id = c.provinceid and p.isdelete = 0
						LEFT Join hotel_district d on d.id = c.districid and d.isdelete = 0
						LEFT JOIN hotel_config cf on cf.companyid = c.id
						where u.isdelete = 0
						and u.username = '$u'
						and g.isdelete = 0
			;
		";
		$query = $this->model->query($sql)->execute();
		//print_r($query); exit;
		if(!empty($query[0]->username)){
			return $query[0];
		}
		else{
			return array();
		}
	}
	function getListMenu(){
		$menu = $this->model->table('hotel_menus')
							->select('name,route')
							->where('isdelete',0)
							->where('route <>','')
							->where('route <>','#')
							->find_all();
		$arr = array();
		foreach($menu as $item){
			$arr[$item->route] = $item->name;
		}
		return $arr;
	}
	function getRouter($str){
		$json = json_decode($str);
		$menu = $this->model->table('hotel_menus')
							->select('id,route')
							->where('isdelete',0)
							->where('route <>','')
							->find_all();
		$arr_menu = array();
		foreach($menu as $item){
			$arr_menu[$item->id] = $item->route;
		}
		$arr_right = array();
		foreach($json as $id=>$right){
			if(isset($arr_menu[$id])){
				$arr_right[$arr_menu[$id]] = $right;
			}	
		}
		return $arr_right;
	}
	function insertTimeLog($uid , $address, $GMTTime){
		$data['timelogin'] = $GMTTime;
		$data['ipaddress'] = $address;
		$data['username'] = $uid;	
		$id = $this->model->table('hotel_time_login')->save('', $data);
		return $id;
	}
	function getLanguage($lang=''){
		if($lang != ""){
			$langs = $lang;	
		}
		else{
			$langs = "vn";	
		}
		$query = $this->model->table('hotel_translate')
					  ->select('keyword,translation')
					  ->where('isdelete',0)
					  ->where('langkey',$langs)
					  ->find_all();
		$arr = array();
		foreach($query as $item){
			$arr[$item->keyword]	= $item->translation;
		}
		return $arr;
	}
}