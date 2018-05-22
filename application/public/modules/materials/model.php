<?php
/**
 * @author 
 * @copyright 2016
 */
 class MaterialsModel extends CI_Model{
	function __construct(){
		parent::__construct('');
		$this->login = $this->site->getSession('login');
	}
	public function getGoodsType($typeid=''){
		$tb = $this->base_model->loadTable();
		$query = $this->model->table($tb['hotel_goods_type'])
						 ->select('id,goods_tye_name')
						 ->where('isdelete',0)
						 ->where('goods_type_group',2);
		if(!empty($typeid)){
		   $query = $query->where('id',$typeid);
		}	
		$query = $query->order_by('goods_tye_name','ASC');
		$query = $query->find_all();
		return $query;
	}
	function getSearch($search){
		$sql = "";
		$companyid = $this->login->companyid;
		if(!empty($search['goods_code'])){
			$sql.= " and c.goods_code like '%".$search['goods_code']."%' ";	
		}
		if(!empty($search['goods_code2'])){
			$sql.= " and c.goods_code2 like '%".$search['goods_code2']."%' ";	
		}
		if(!empty($search['goods_name'])){
			$sql.= " and c.goods_name like '%".$search['goods_name']."%' ";	
		}
		if(!empty($search['description'])){
			$sql.= " and c.description like '%".$search['description']."%' ";	
		}
		if(!empty($search['buy_price'])){
			$sql.= " and c.buy_price like '%".$search['buy_price']."%' ";	
		}
		if(!empty($search['sale_price'])){
			$sql.= " and c.sale_price like '%".$search['sale_price']."%' ";	
		}
		if(!empty($search['discountsales'])){
			$sql.= " and c.discountsales like '%".$search['discountsales']."%' ";	
		}
		if(!empty($search['madein'])){
			$sql.= " and c.madein like '%".$search['madein']."%' ";	
		}
		if(!empty($search['quantitymin'])){
			$sql.= " and c.quantitymin like '%".$search['quantitymin']."%' ";	
		}
		if(!empty($search['goods_type'])){
			$sql.= " and c.goods_type in (".$search['goods_type'].") ";	
		}
		return $sql;
	}
	function getList($search,$page,$rows){
		$searchs = $this->getSearch($search);
		$skey = $this->login->skey;
		$tb = $this->base_model->loadTable();
		$tb_goods = $tb['hotel_goods'];
		$tb_goods_type = $tb['hotel_goods_type'];
		$tb_unit = $tb['hotel_unit'];
		$tb_conversion = $tb['hotel_goods_conversion'];
		$sql = "
				SELECT c.isnegative, c.shelflife,c.isserial,c.quantitymin,c.img,c.goods_code, c.goods_code2 , c.discounthotel_dly, c.discounthotel_type_dly,
				c.goods_type, c.id, c.madein, c.discountsales, c.discounthotel_type, c.unitid, c.sale_price, c.buy_price, c.companyid, c.description,
				c.goods_name, vat,
				p.goods_tye_name,ut.unit_name, c.exchange_unit, 
				(select group_concat(concat(uni.unit_name,': ',gc.conversion))
					from `$tb_conversion` gc 
					left join `$tb_unit` uni on uni.id = gc.unitid
					where gc.goodsid = c.id
				) as exchanges
				FROM `$tb_goods` AS c
				LEFT JOIN `$tb_goods_type` p on p.id = c.goods_type and p.isdelete = 0 
				LEFT JOIN `$tb_unit` ut on ut.id = c.unitid and ut.isdelete = 0  
				WHERE c.isdelete = 0
				AND p.goods_type_group = 2
				$searchs 
				";
		if(empty($search['order'])){
			$sql.= ' ORDER BY c.id DESC ';
		}
		else{
			$sql.= ' ORDER BY '.$search['order'].' '.$search['index'].' ';
		}
		if($page != 0 || $rows != 0){
			$sql.= ' limit '.$page.','.$rows;
		}
		$query = $this->model->query($sql)->execute();
		return $query;
	}
	function getTotal($search){
		$tb = $this->base_model->loadTable();
		$searchs = $this->getSearch($search);
		$tb_goods = $tb['hotel_goods'];
		$tb_goods_type = $tb['hotel_goods_type'];
		$sql = " 
		SELECT count(1) total
		FROM `$tb_goods` AS c
		LEFT JOIN `$tb_goods_type` p on p.id = c.goods_type
		WHERE c.isdelete = 0 
		AND p.goods_type_group = 2
		$searchs	
		";
		$query = $this->model->query($sql)->execute();
		return $query[0]->total;	
	}
	function saves($array,$materials){
		$tb = $this->base_model->loadTable();
		$skey = $this->login->skey;
		$companyid = $this->login->companyid;
		//check ky tu dac biet
		$checkSpecial = $this->base_model->checkSpecial($array['goods_code']);
		if($checkSpecial == 0){
			return -2;
		}
		$check = $this->model->table($tb['hotel_goods'])
					  ->select('id')
					  ->where('isdelete',0)
					  ->where('goods_code',$array['goods_code'])
					  ->find();
		if(!empty($check->id)){
			return -1;	
		}
		$array['buy_price'] = fmNumberSave($array['buy_price']);
		$array['sale_price'] = fmNumberSave($array['sale_price']);
		$array['companyid'] = $this->login->companyid;
		$goodsid = $this->model->table($tb['hotel_goods'])->save('',$array);
		
		//Quy doi
		 $exchange_unit = explode(",",$array['exchange_unit']);
		 foreach($exchange_unit as $key => $val){
			$arr = explode('_',$val);
			if(!empty($arr[1])){
				$arrInsertChange = array();
				$arrInsertChange['unitid'] = $arr[0];
				$arrInsertChange['conversion'] = $arr[1];
				$arrInsertChange['goodsid'] = $goodsid;
				$arrInsertChange['datecreate'] = $array['datecreate'];
				$arrInsertChange['usercreate'] = $array['usercreate'];
				$this->model->table($tb['hotel_goods_conversion'])->insert($arrInsertChange);
			}
		 }
		return 1;
	}
	function edits($array,$materials,$id){
		 $skey = $this->login->skey;
		 $companyid = $this->login->companyid;
		 $tb = $this->base_model->loadTable();
		 $checkSpecial = $this->base_model->checkSpecial($array['goods_code']);
		 if($checkSpecial == 0){
			return -2;
		 }
		 $check = $this->model->table($tb['hotel_goods'])
		 ->select('id')
		 ->where('isdelete',0)
		 ->where('id <>',$id)
		 ->where('goods_code',$array['goods_code'])
		 ->find();
		 if(!empty($check->id)){
			 return -1;	
		 }
		 $array['buy_price'] = fmNumberSave($array['buy_price']);
		 $array['sale_price'] = fmNumberSave($array['sale_price']);
		 $array['discountsales'] = fmNumberSave($array['discountsales']);
		 $array['discounthotel_dly'] = fmNumberSave($array['discounthotel_dly']);
		 $array['companyid'] = $this->login->companyid;
		 $this->model->table($tb['hotel_goods'])->save($id,$array); 	 
		 //Quy doi 
		 $this->model->table($tb['hotel_goods_conversion'])->where('goodsid',$id)->delete();
		 $exchange_unit = explode(",",$array['exchange_unit']);
		 foreach($exchange_unit as $key => $val){
			$arr = explode('_',$val);
			if(!empty($arr[1])){
				$arrInsertChange = array();
				$arrInsertChange['unitid'] = $arr[0];
				$arrInsertChange['conversion'] = $arr[1];
				$arrInsertChange['goodsid'] = $id;
				$arrInsertChange['datecreate'] = $array['dateupdate'];
				$arrInsertChange['usercreate'] = $array['userupdate'];
				$this->model->table($tb['hotel_goods_conversion'])->insert($arrInsertChange);
			}
		 }
		 return $id; 
	 }
	 function findMaterial($goodsid){
		 $tb = $this->base_model->loadTable();
		 $skey = $this->login->skey;
		 $query = $this->model->table($tb['hotel_materials'])
					  ->select("*")
					  ->where('goodsid',$goodsid)
					  ->find_all();
		return $query;
	 }
	function findID($id){
		 $tb = $this->base_model->loadTable();
		 $skey = $this->login->skey;
		 $query = $this->model->table($tb['hotel_goods'])
					  ->select("*")
					  ->where('id',$id)
					  ->find();
		return $query;
	 }
	function findGoods($id,$code){
		$tb = $this->base_model->loadTable();
		$code = trim($code);
		$companyid = $this->login->companyid;
		if(empty($code)){
			$and = " and s.id = '$id' ";
		}
		else{
			$and = " and s.goods_code = '$code' ";
		}
		$sql = "
			SELECT s.id, s.goods_code,s.goods_name, un.unit_name, s.sale_price, s.buy_price
			FROM `".$tb['hotel_goods']."` s
			left join `".$tb['hotel_unit']."` un on un.id = s.unitid
			where  s.isdelete = 0
			$and
		 ";
		 return $this->model->query($sql)->execute();
	}
	function getMaterials(){
		$tb = $this->base_model->loadTable();
		$sql = "
			SELECT g.id, g.goods_name
			FROM `".$tb['hotel_goods']."` g
			left join `".$tb['hotel_goods_type']."` gt on gt.id = g.goods_type
			where g.isdelete = 0
			and gt.goods_type_group = 2
			order by g.goods_name 
		 ";
		 return $this->model->query($sql)->execute();
	}
}