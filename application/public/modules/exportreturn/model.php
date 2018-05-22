<?php
/**
 * @author 
 * @copyright 2016
 */
 class ExportreturnModel extends CI_Model{
	function __construct(){
		parent::__construct('');
		$this->login = $this->site->getSession('login');
		$this->ctr = 1;
	}
	function getSalesOder(){
		$tb = $this->base_model->loadTable();
		$sql = "
			select *
				from(
				SELECT od.goodsid, od.poid, od.quantity, 
				( 
					select outs.quantity 
					from `".$tb['hotel_output_return']."` outs 
					where outs.isdelete = 0 
					and outs.poid = od.poid 
					and outs.goodsid = od.goodsid
				) as quantityout
				 FROM `".$tb['hotel_input_createorders']."` coo 
				 LEFT JOIN `".$tb['hotel_input']."` od on coo.uniqueid = od.uniqueid
				 where coo.isdelete = 0
				 and od.isdelete = 0
				 group by od.goodsid, coo.poid 
				 having ( quantityout is null or quantity > quantityout)
				 ) t
				 group by t.poid
		";
		$query = $this->model->query($sql)->execute();
		return $query;
	}
	function getSearch($searchs){
		foreach($searchs as $key=>$val){
			$search[$key] = addslashes($val); 
		}
		$sql = "";
		$companyid = $this->login->companyid;
		$branchid = $this->login->branchid;
		$sql.= " and c.companyid = '".$companyid."' ";	
		if(!empty($branchid)){
			$sql.= " and c.branchid in (".$branchid.") ";	
		}
		if(!empty($search['supplierid'])){
			$sql.= " and c.supplierid in (".$search['supplierid'].") ";	
		}
		if(!empty($search['payments'])){
			$sql.= " and c.payments in (".$search['payments'].") ";	
		}
		if(!empty($search['formdate'])){
			$sql.= " and c.datecreate >= '".fmDateSave($search['formdate'])." 00:00:00' ";	
		}
		if(!empty($search['todate'])){
			$sql.= " and c.datecreate <= '".fmDateSave($search['todate'])." 23:59:59' ";	
		}
		return $sql;
	}
	function getList($search,$page,$rows){
		$searchs = $this->getSearch($search);
		$tb = $this->base_model->loadTable();
		$skey = $this->login->skey;
		$sql = "SELECT c.id, c.supplierid, c.warehouseid, c.payments, c.datecreate, c.usercreate ,c.uniqueid,c.poid,c.datepo,c.description, c.quantity, c.price, c.price_prepay, w.warehouse_name, DES_DECRYPT(sp.supplier_name,'".$skey."') supplier_name, c.uniqueid,
				  c.quantity,  c.price, c.soid
				FROM `".$tb['hotel_output_return']."` so
				LEFT JOIN `".$tb['hotel_output_createorders_return']."` AS c on c.uniqueid = so.uniqueid
				LEFT JOIN `".$tb['hotel_warehouse']."` w on w.id = c.warehouseid and w.isdelete = 0
				LEFT JOIN `".$tb['hotel_supplier']."` sp on sp.id = c.supplierid and sp.isdelete = 0
				left join `".$tb['hotel_goods']."` g on g.id = so.goodsid and g.isdelete = 0
				WHERE c.isdelete = 0 
				and so.isdelete = 0
				and g.isdelete  = 0
				$searchs
				group by c.uniqueid
				";
		if(empty($search['order'])){
			$sql.= ' ORDER BY c.id DESC, g.goods_code asc ';
		}
		else{
			$sql.= ' ORDER BY '.$search['order'].' '.$search['index'].', g.goods_code asc';
		}
		if($page != 0 && $rows != 0){
			$sql.= ' limit '.$page.','.$rows;
		}
		$query = $this->model->query($sql)->execute();
		return $query;
	}
	function getTotal($search){
		$searchs = $this->getSearch($search);
		$tb = $this->base_model->loadTable();
		$sql = "
				select count(1) total
				from(
				SELECT 1 as total
				FROM `".$tb['hotel_input']."` so
				LEFT JOIN `".$tb['hotel_goods']."` g on g.id = so.goodsid and g.isdelete = 0
				LEFT JOIN  `".$tb['hotel_output_return']."` ut on ut.id = g.unitid and ut.isdelete = 0
				LEFT JOIN `".$tb['hotel_output_createorders_return']."` AS c on c.uniqueid = so.uniqueid
				LEFT JOIN `".$tb['hotel_warehouse']."` w on w.id = c.warehouseid and w.isdelete = 0
				LEFT JOIN `".$tb['hotel_supplier']."` sp on sp.id = c.supplierid and sp.isdelete = 0
				WHERE c.isdelete = 0 
				and so.isdelete = 0
				and g.isdelete  = 0
				$searchs
				group by c.uniqueid ) temp
				";
		$query = $this->model->query($sql)->execute();
		return $query[0]->total;	
	}
	/*function updatePriceout($listPriceout,$listPriceone){
		$tb = $this->base_model->loadTable();
		//UPDATE gia xuat
		$inputPricout = json_decode($listPriceout,true);
		$sql = "UPDATE `".$tb['hotel_goods']."` SET `sale_price` = CASE id ";
		$str = "";
		foreach($inputPricout as $id=>$price){
			$price = fmNumberSave($price);
			$sql.= " WHEN $id THEN '$price' ";
			$str.=",".$id;
		}
		$sql.= " ELSE `sale_price` END ";
		$strID = substr($str,1);
		$sql.= "  WHERE id IN ($strID);"; 
		$this->model->executeQuery($sql);	
		//UPDATE Gia nhap
		$inputPricint = json_decode($listPriceone,true);
		$sqls = "UPDATE `".$tb['hotel_goods']."` SET `buy_price` = CASE id ";
		$strs = "";
		foreach($inputPricint as $id=>$price){
			$price = fmNumberSave($price);
			$sqls.= " WHEN $id THEN '$price' ";
			$strs.=",".$id;
		}
		$sqls.= " ELSE `buy_price` END ";
		$strID = substr($strs,1);
		$sqls.= "  WHERE id IN ($strID);";
		
		$this->model->executeQuery($sqls);
	}*/
	/*function getPOMax($companyid){
		$tb = $this->base_model->loadTable();
		$po = "
			SELECT max(oc.poid) poid
			FROM `".$tb['hotel_input_createorders']."` oc
			WHERE oc.companyid = '".$companyid."'
			ORDER BY oc.poid DESC 
			LIMIT 1;			
		";
		$queryPO = $this->model->query($po)->execute();
		if(!empty($queryPO[0]->poid)){
			$poid = $queryPO[0]->poid + 1;	
		}
		else{
			$poid = 1;
		}
		return $poid;
	}*/
	function saves($arrays,$priceone,$quantity,$price_prepay,$description,$listQuantity,$listPriceone,$goodstt,$uniqueid,$poid){
		foreach($arrays as $key=>$val){
			if($key == 'input_list'){ continue; }
			$array[$key] = addslashes($val); 
		}
		$tb = $this->base_model->loadTable();
		$timeNow  = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
		$this->db->trans_begin();
		$companyid = $this->login->companyid;
		$branchid = $this->login->branchid;
		$array['companyid'] = $companyid;
		$array['branchid'] = $branchid;
		
		$inputList = json_decode($listQuantity,true);	
		$inputPriceone = json_decode($listPriceone,true);
		$goodsttList = json_decode($goodstt,true);
		//Lay so luong
		$totalQuantity = 0;
		$totalPrice = 0;
		foreach($inputList as $goodsid=>$input){
			$input = fmNumberSave($input);
			$price = fmNumberSave($inputPriceone[$goodsid]);
			$totalQuantity+= $input;
			$totalPrice+= ($input * $price);
		}			
		$arrAuto = $this->createPoOrder($branchid,$array['datecreate']);
		// Insert vao bang hoa don nhap - hotel_input_createorders
		$insert['warehouseid'] = $array['warehouseid'];
		$insert['companyid'] = $companyid;
		$insert['branchid'] = $branchid;
		$insert['description'] = $description;
		$insert['payments'] = $array['payment'];
		$insert['supplierid'] = $array['supplierid'];
		$insert['datecreate'] = $timeNow;
		$insert['usercreate'] = $array['usercreate'];
		$insert['uniqueid'] = $uniqueid;
		$insert['poid'] = $arrAuto['poid'];
		$insert['soid'] = $poid; 
		$insert['stt'] = $arrAuto['stt'];
		$insert['quantity'] = fmNumberSave($totalQuantity);
		$insert['price'] = fmNumberSave($totalPrice);
		$insert['datepo'] = fmDateSave($array['datecreate']);

		$insert['signature'] = $this->login->signature;
		$insert['signature_name'] = $this->login->fullname;
		$this->model->table($tb['hotel_output_createorders_return'])->insert($insert);
		// Insert vao bang chi tiet nhap - hotel_input
		$insertInput = array();
		$insertInput['warehouseid'] = $array['warehouseid'];
		$insertInput['companyid'] = $companyid;
		$insertInput['branchid'] = $branchid;
		$insertInput['supplierid'] = $array['supplierid'];
		$insertInput['datecreate'] = $timeNow;;
		$insertInput['usercreate'] = $array['usercreate'];
		$insertInput['poid'] = $poid;
		$insertInput['uniqueid'] = $uniqueid;
		$inputList = json_decode($listQuantity,true);	
		$inputPriceone = json_decode($listPriceone,true);
		
		//Kiem tra so luong trong kho
		$str_goodsid = '';
		foreach($inputList as $k=>$v){
			$str_goodsid.= ','.$k;
		}
		$str_goodsid = substr($str_goodsid,1);
		$sql = "
			SELECT i.id, i.goodsid, if(i.shelflife = '0000-00-00','3000-12-31',i.shelflife) as  shelflife, i.quantity, concat(g.goods_code,' - ',DES_DECRYPT(g.goods_name,'".$this->login->skey ."')) as goods_name, g.isnegative
			FROM `".$tb['hotel_inventory']."` i
			left join `".$tb['hotel_goods']."` g on g.id = i.goodsid
			where i.companyid = '".$companyid."'
			and i.branchid = '".$branchid."'
			and i.goodsid in (".$str_goodsid.")
			and i.warehouseid = '".$array['warehouseid']."'
			and i.isdelete = 0
			and g.isdelete = 0
		";
		$queryCheckInventory = $this->model->query($sql)->execute();
		$arrGoodCode = array();
		$arrGoodCodeNegative = array();
		foreach($queryCheckInventory as $item){
			$arrGoodCode[$item->goodsid] = $item->goods_name;
			$arrGoodCodeNegative[$item->goodsid] = $item->isnegative;
			$arrInventoryGoods[$item->goodsid] = (float)$item->quantity;
		}
		$listError = '';
		foreach($arrGoodCode as $goodid=>$goods_name){ 
			$sl_tonkh = (int)$arrInventoryGoods[$goodid];
			$sl_ban = (int)$inputList[$goodid];
			if($arrGoodCodeNegative[$goodid] == 0){ //=1 cho phep xuat am
				if($sl_ban > $sl_tonkh){
					$listError.= $goods_name .' - Tồn kho: '.$sl_tonkh.'</br>';
				}
			}
		}
		if($listError != ''){
			$arr = array();
			$arr['uniqueid'] = 0;
			$arr['poid'] = 0;
			$arr['msg'] = ' Tồn kho không đủ: <br>'.$listError;
			return $arr;
		}
		foreach($inputList as $goodsid=>$input){
			$price = fmNumberSave($inputPriceone[$goodsid]);
			$input = fmNumberSave($input);
			$dateShelflife = '0000-00-00';
			$sttview = 0;
			if(isset($goodsttList[$goodsid])){
				$sttview = $goodsttList[$goodsid];
			}
			$insertInput['sttview'] = $sttview;
			$insertInput['goodsid'] = $goodsid;
			$insertInput['price'] = fmNumberSave($input * $price);
			$insertInput['priceone'] = $price;
			$insertInput['quantity'] = $input;
			$insertInput['shelflife'] = $dateShelflife;
			$this->model->table($tb['hotel_output_return'])->insert($insertInput);
			#region nhap hang hoa vao kho
			$sqlUpdate = "
				UPDATE `".$tb['hotel_inventory']."` SET `quantity`= `quantity` - '".fmNumberSave($input)."' 
				WHERE `goodsid` = '".$goodsid."'
				AND `branchid` = '".$branchid."'
				AND `warehouseid` = '". $array['warehouseid']."'
				;
			";
			$this->model->executeQuery($sqlUpdate);
			#end 
		}
		#region Nhập vào phiếu thu
		$receipts_code = $this->createPoReceipt($branchid,$array['datecreate']);
		$arrIS =  array();
		$arrIS['receipts_code'] = $receipts_code;
		$arrIS['uniqueid'] = $uniqueid;
		$arrIS['companyid'] = $companyid;
		$arrIS['branchid'] = $branchid;
		$arrIS['receipts_type'] = -1;
		$arrIS['payment'] =  $insert['payments'];
		$arrIS['amount'] = $insert['price'];
		$arrIS['poid'] = $poid;
		$arrIS['usercreate'] = $array['usercreate'];
		$arrIS['datecreate'] = $timeNow;
		$this->model->table($tb['hotel_receipts'])->insert($arrIS);
		#end
		$arr = array();
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$arr['uniqueid'] = $uniqueid;
			$arr['poid'] = 0;
			return $arr;
		}
		else{
			$this->db->trans_commit();
			$arr['uniqueid'] = $uniqueid;
			$arr['poid'] = $poid;
			return $arr;
		}
	}
	function getNoneData($tb){
		$sql = "
		SELECT column_name
		FROM information_schema.columns
		WHERE table_name='".$tb."'; 
		";
		$query = $this->model->query($sql)->execute();
		$obj = new stdClass();
		foreach($query as $item){
			$clm = $item->column_name;
			$obj->$clm = null;
		}
		return $obj;
	}
	function deletes($id, $array){
		//$arr = explode(',',$id);
		//List Uniqueid
		$tb = $this->base_model->loadTable();
		$this->db->trans_start();
		$query = $this->model->table($tb['hotel_output_createorders_return'])
					  ->select('uniqueid,id,poid')
					  ->where("id in ($id)")
					  ->find_all();
		$result = $this->model->table($tb['hotel_output_createorders_return'])
						   ->where("id in ($id)")
					       ->update($array);	
		$listUnit = "";
		foreach($query as $item){
			$listUnit.= ','.$item->uniqueid;
		}
		$listUnit = substr($listUnit,1);
		//List 
	    $queryDetail = $this->model->table($tb['hotel_output_return'])
					  ->select('id,goodsid,branchid,warehouseid,companyid,quantity,shelflife')
					  ->where("uniqueid in ($listUnit)")
					  ->find_all();
		$listid = '';			  
		foreach($queryDetail as $item){
			$goodsid = $item->goodsid;
			$branchid = $item->branchid;
			$warehouseid = $item->warehouseid;
			$companyid = $this->login->companyid;
			$quantity = $item->quantity;
			//Con so luong tra lai kho
			$sqlUpdate = "
				UPDATE `".$tb['hotel_inventory']."` SET `quantity`=`quantity` +  $quantity 
				WHERE `id` > 0
				and `goodsid`= '$goodsid'
				and `branchid`= '$branchid'
				and `warehouseid`= '$warehouseid'
				and `companyid`= '$companyid'
				;
			";
			$this->model->executeQuery($sqlUpdate);
			$listid.= ','.$item->id;
		}
		$listid = substr($listid,1);
		$result = $this->model->table($tb['hotel_output_return'])
						   ->where("id in ($listid)")
					       ->update($array);	
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return 1;
		} 
		else {
			$this->db->trans_commit();
			return 0;
		}
	}
	function findListID($id){
		 $tb = $this->base_model->loadTable();
		 $createorders = $tb['hotel_output_createorders_return'];
		 $warehouse = $tb['hotel_warehouse'];
		 $supplier = $tb['hotel_supplier'];
		 $query = $this->model->table($createorders)
					  ->select("signature, signature_name, datepo, uniqueid,poid,price,price_prepay, description,warehouse_name,
					  DES_DECRYPT(".$supplier.".supplier_name,'".$this->login->skey ."') as cname, 
					  DES_DECRYPT(".$supplier.".phone,'".$this->login->skey ."') as cphone, 
					  DES_DECRYPT(".$supplier.".address,'".$this->login->skey ."')  as caddress
					  ")
					  ->join($warehouse,$warehouse.'.id = '.$createorders.'.warehouseid','left')
					  ->join($supplier,$supplier.'.id = '.$createorders.'.supplierid','left')
					  ;
		if(empty($unit)){
			$query = $query->where($createorders.".id",$id);
		}
		else{
			$query = $query->where($createorders.".uniqueid",$unit);
		}
		$query = $query->where($createorders.'.isdelete',0)->find();
		return $query;
	}
	function findListUniqueID($uniqueid){
		$tb = $this->base_model->loadTable();
		$sql = "
			select sg.id, '0' stype , si.goodsid, sg.sale_price ,si.quantity, si.price as totalPrice, si.priceone as buy_price, sg. sale_price as price_out, sg.goods_code, DES_DECRYPT(sg.goods_name,'".$this->login->skey ."') as goods_name, su.unit_name, sg.shelflife as isshelflife, if(si.shelflife = '0000-00-00',0,si.shelflife) as shelflifeddate, gg.group_code, gg.group_name, sg.shelflife, gd.exchang,si.uniqueid, si.shelflife as shelflifeOut
			from `".$tb['hotel_input']."` si
			left join `".$tb['hotel_goods']."` sg on si.goodsid = sg.id
			left join `".$tb['hotel_goods_group_detail']."` gd on gd.goodid = sg.id and gd.isdelete = 0
			left join `".$tb['hotel_goods_group']."` gg on gg.id = gd.groupid and gg.isdelete = 0
			left join `".$tb['hotel_unit']."` su on su.id = sg.unitid
			where si.uniqueid = '$uniqueid'
			and si.isdelete = 0
			order by si.sttview asc
		"; 
		return $this->model->query($sql)->execute();
	}
	function findListIDDetail($uniqueid){
		 $tb = $this->base_model->loadTable();
		 $tbinput = $tb['hotel_output_return'];
		 $tbgoods = $tb['hotel_goods'];
		 $tbwarehouse = $tb['hotel_warehouse'];
		 $tbunit = $tb['hotel_unit'];
		 
		 $query = $this->model->table($tbinput)
					  ->select("warehouse_name,goods_code,
					  DES_DECRYPT(goods_name,'".$this->login->skey ."') as goods_name,
					  quantity,price,priceone,unit_name")
					  ->join($tbgoods,$tbgoods.'.id = '.$tbinput.'.goodsid','left')
					  ->join($tbwarehouse,$tbwarehouse.'.id = '.$tbinput.'.warehouseid','left')
					  ->join($tbunit,$tbunit.'.id = '.$tbgoods.'.unitid','left')
					  ->where($tbinput.".uniqueid in ($uniqueid)")
					  ->where($tbinput.'.isdelete',0)
					  ->order_by('sttview','asc')
					  ->find_all();
		return $query;
	}
	function getOrder($id,$unit=''){
		$skey = $this->login->skey;
		$tb = $this->base_model->loadTable();
		$tbcreateorders = $tb['hotel_output_createorders_return'];
		$tbsupplier = $tb['hotel_supplier'];
		
		$queryOrder = $this->model->table($tbcreateorders)
					  ->select("
					  signature, signature_name, 
					  $tbcreateorders.stt,$tbcreateorders.datepo,$tbcreateorders.id,$tbcreateorders.datecreate,poid,uniqueid,quantity,price,price_prepay, DES_DECRYPT(supplier_name,'$skey') as supplier_name, DES_DECRYPT(phone,'$skey') as phone,DES_DECRYPT(address,'$skey') as address")
					  ->join($tbsupplier,$tbsupplier.'.id = '.$tbcreateorders.'.supplierid','left');
			if(empty($unit)){
				$queryOrder = $queryOrder->where($tbcreateorders.'.id',$id);
			}
			else{
				$queryOrder = $queryOrder->where($tbcreateorders.'.uniqueid',$unit);
			}
			$queryOrder = $queryOrder->where($tbcreateorders.'.isdelete',0)->find();
		return $queryOrder;
	}
	function getListExport($search,$page,$rows){
		$sql = "";
		$companyid = $this->login->companyid;
		$branchid = $this->login->branchid;
		$skey = $this->login->skey;
		$sql.= " and c.companyid = '".$companyid."' ";	
		if(!empty($branchid)){
			$sql.= " and c.branchid in (".$branchid.") ";	
		}
		if(!empty($search['goodsid'])){
			$sql.= " and c.goodsid in (".$search['goodsid'].") ";	
		}
		if(!empty($search['supplierid'])){
			$sql.= " and c.supplierid in (".$search['supplierid'].") ";	
		}
		if(!empty($search['payments'])){
			$sql.= " and c.payments in (".$search['payments'].") ";	
		}
		if(!empty($search['formdate'])){
			$sql.= " and c.datecreate >= '".$search['formdate']." 00:00:00' ";	
		}
		if(!empty($search['todate'])){
			$sql.= " and c.datecreate >= '".$search['todate']." 23:59:59' ";	
		}
		if(!empty($search['goodsidsearch'])){
			$sql.= " and g.id in (".$search['goodsidsearch'].") ";	
		}
		$tb = $this->base_model->loadTable();
		$sqls = "
			SELECT i.id, i.poid, i.companyid, i.goodsid, i.branchid, i.warehouseid, i.quantity, i.priceone,  i.price,
			DES_DECRYPT(s.supplier_name,'".$skey."') as supplier_name
			,g.goods_code, 
			DES_DECRYPT(g.goods_name,'".$skey."') as goods_name, c.description
			,u.unit_name, c.datecreate, c.usercreate ,c.payments,  w.warehouse_name
			FROM `".$tb['hotel_input']."` i
			LEFT JOIN `".$tb['hotel_input_createorders']."` c on i.uniqueid = c.uniqueid
			LEFT JOIN `".$tb['hotel_supplier']."` s on s.id = c.supplierid 
			LEFT JOIN `".$tb['hotel_goods']."` g on g.id = i.goodsid
			left JOIN `".$tb['hotel_unit']."` u on u.id = g.unitid
			LEFT JOIN `".$tb['hotel_warehouse']."` w on w.id = c.warehouseid 
			where i.isdelete = 0
			and c.isdelete = 0
			$sql
		";
		$sqls.= ' ORDER BY c.poid desc, g.goods_code asc ';
		if($page != 0 && $rows != 0){
			$sqls.= ' limit '.$page.','.$rows;
		}
		$query = $this->model->query($sqls)->execute();
		return $query;
	}
	function getTempGoodSO($so){
		$tb = $this->base_model->loadTable();
		$skey = $this->login->skey;
		$sql = "
				SELECT sat.uniqueid, '0' as stype, sat.quantity, s.goods_code, s.id, s.img,DES_DECRYPT(s.goods_name,'".$skey."') as goods_name,
					 un.unit_name, sat.price, sat.priceone, s.shelflife
					,gg.group_code, gg.group_name, gd.exchang, sat.guarantee as guaranteedate,
					(
						select op.quantity
						from hotel_output_4 op
						where op.isdelete = 0
						and op.socode = sat.poid
						and op.goodsid = sat.goodsid
					) as quantityexport
				FROM `".$tb['hotel_input']."` sat
				left join `".$tb['hotel_goods']."` s on s.id = sat.goodsid
				left join `".$tb['hotel_unit']."` un on un.id = s.unitid
				left join `".$tb['hotel_goods_group_detail']."` gd on gd.goodid = s.id and gd.isdelete = 0
				left join `".$tb['hotel_goods_group']."` gg on gg.id = gd.groupid and gg.isdelete = 0
				where s.isdelete = 0
				and un.isdelete = 0
				and sat.poid = '$so'
				and sat.isdelete = 0
				and sat.poid not in (
					select outs.poid 
					from `".$tb['hotel_output_return']."` outs 
					where outs.isdelete = 0 
					and outs.poid = sat.poid 
					and outs.goodsid = sat.goodsid
				)
				group by sat.goodsid 
                having (quantity - quantityexport > 0 or quantityexport is null)
				order by sat.datecreate asc
		";
		$query = $this->model->query($sql)->execute();
		return $query;
	}
	function findOrderSO($so){
		$tb = $this->base_model->loadTable();
		$query = $this->model->table($tb['hotel_input_createorders'])
					  ->select('*')
					  ->where('poid',$so)
					  ->find();
		return $query;
	}
	function createPoReceipt($branchid,$datecreate){
		$tb = $this->base_model->loadTable();
		$yearDay = fmMonthSave($datecreate);
		$checkPOid = $this->model->table($tb['hotel_receipts'])
							 ->select('receipts_code')
							 ->where("datepo like '$yearDay%'")
							 ->where('branchid',$branchid)
							 ->where('isdelete',0)
							 ->order_by('id','DESC')
							 ->find();
							
		if(!empty($checkPOid->receipts_code)){
			$poid = str_replace(cfpt(),'',$checkPOid->receipts_code);
			$poc = (float)$poid;
		}
		else{
			$poc = date('ym',strtotime($yearDay)).'00000';
		}
		$receipts_code = cfpt(). ($poc + 1);
		return $receipts_code;
	}
	function createPoOrder($branchid,$datecreate){
		$tb = $this->base_model->loadTable();
		$yearDay = fmMonthSave($datecreate);
		//$yearDay = gmdate("Y-m", time() + 7 * 3600);
		$checkPOid = $this->model->table($tb['hotel_output_createorders_return'])
							 ->select('poid,stt')
							 ->where("datepo like '$yearDay%'")
							 ->where('branchid',$branchid)
							 ->where('isdelete',0)
							 ->order_by('id','DESC')
							 ->find();
		if(!empty($checkPOid->poid)){
			$poid = str_replace(cfpx(),'',$checkPOid->poid);
			$poc = (float)$poid;
		}
		else{
			$poc = date('ym',strtotime($yearDay)).'00000';
		}
		if(!empty($checkPOid->stt)){
			$stt = (float)$checkPOid->stt;
		}
		else{
			$stt = '0';
		}
		$array = array();
		$array['poid'] =  cfpx().($poc + 1);
		$array['stt'] = $stt + 1;
		return $array;
	}
}