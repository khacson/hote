<?php
/**
 * @author 
 * @copyright 2015
 */
 class ImportexportModel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->login = $this->site->getSession('login');
	}
	function getSearch($search){
		$sql = "";
		$tb = $this->base_model->loadTable();
		$companyid = $this->login->companyid;
		$branchid = $this->login->branchid;
		if(!empty($branchid)){
			$sql.= " and i.branchid in (".$branchid.") ";	
		}
		else{
			if(!empty($search['branchid'])){
				$sql.= " and i.branchid in (".$search['branchid'].") ";	
			}
		}
		if(!empty($search['goodsid'])){
			$sql.= " and i.goodsid in (".$search['goodsid'].") ";	
		}
		if(!empty($search['branchid'])){
			$sql.= " and i.branchid in (".$search['branchid'].") ";	
		}
		if(!empty($search['warehouseid'])){
			$sql.= " and i.warehouseid in (".$search['warehouseid'].") ";	
		}
		if(!empty($search['locationid'])){
			if($search['locationid'] == -1){
				$sql.= " and (i.locationid in (0) or i.locationid is null)";	
			}
			else{
				$sql.= " and i.locationid in (".$search['locationid'].") ";	
			}
		}
		if(!empty($search['goods_type'])){
			$sql.= " and g.goods_type in (".$search['goods_type'].") ";	
		}
		if(!empty($search['goodsidsearch'])){
			$sql.= " and g.goods_code like '%".$search['goodsidsearch']."%' ";
		}
		if(!empty($search['goodsnamesearch'])){
			$sql.= " and g.goods_name like '%".$search['goodsnamesearch']."%' ";
		}
		return $sql;
	}
	function tonDauKy($search){
		$tb = $this->base_model->loadTable();
		$branchid = $this->login->branchid;
		$fromDate = fmDateSave($search['formdate']);
		$sql = "
			select sum(tt.quantity) as quantity, tt.goodsid, tt.branchid, tt.warehouseid
			from 
			(
			select sum(ip.quantity) as quantity, ip.goodsid, ip.branchid, ip.warehouseid
			from `".$tb['hotel_input']."` ip
			left join `".$tb['hotel_input_createorders']."` ic on ic.uniqueid = ip.uniqueid
			where ip.isdelete = 0
			and ip.branchid = 0
			and ic.datepo < '$fromDate'
			group by ip.goodsid, ip.branchid, ip.warehouseid
			union all
			select sum(ip.quantity) as quantity, ip.goodsid, ip.branchid, ip.warehouseid
			from `".$tb['hotel_input_return']."` ip
			left join `".$tb['hotel_input_return_orders']."` ic on ic.uniqueid = ip.uniqueid
			where ip.isdelete = 0
			and ip.branchid = '$branchid'
			and ic.datepo < '$fromDate'
			group by ip.goodsid, ip.branchid, ip.warehouseid ) tt
			group by tt.goodsid, tt.branchid, tt.warehouseid
		";
		$query = $this->model->query($sql)->execute();
		$array = array();
		foreach($query as $item){
			$array[$item->branchid][$item->warehouseid][$item->goodsid] = $item->quantity;
		}
		return $array;
	}
	function nhaKhoTrongKy($search){
		$tb = $this->base_model->loadTable();
		$fromDate = fmDateSave($search['formdate']);
		$todate = fmDateSave($search['todate']);
		$branchid = $this->login->branchid;
		$sql = "
			select sum(ip.quantity) as quantity, ip.goodsid, ip.branchid, ip.warehouseid
			from `".$tb['hotel_input']."` ip
			left join `".$tb['hotel_input_createorders']."` ic on ic.uniqueid = ip.uniqueid
			where ip.isdelete = 0
			and ip.branchid = '$branchid'
			and ic.datepo <= '$todate'
			and ic.datepo >= '$fromDate'
			group by ip.goodsid, ip.branchid, ip.warehouseid
		";
		$query = $this->model->query($sql)->execute();
		$array = array();
		foreach($query as $item){
			$array[$item->branchid][$item->warehouseid][$item->goodsid] = $item->quantity;
		}
		return $array;
	}
	function nhapHangTralai($search){
		$tb = $this->base_model->loadTable();
		$fromDate = fmDateSave($search['formdate']);
		$todate = fmDateSave($search['todate']);
		$branchid = $this->login->branchid;
		$sql = "
			select sum(ip.quantity) as quantity, ip.goodsid, ip.branchid, ip.warehouseid
			from `".$tb['hotel_input_return']."` ip
			left join `".$tb['hotel_input_return_orders']."` ic on ic.uniqueid = ip.uniqueid
			where ip.isdelete = 0
			and ip.branchid = '$branchid'
			and ic.datepo <= '$todate'
			and ic.datepo >= '$fromDate'
			group by ip.goodsid, ip.branchid, ip.warehouseid
		";
		$query = $this->model->query($sql)->execute();
		$array = array();
		foreach($query as $item){
			$array[$item->branchid][$item->warehouseid][$item->goodsid] = $item->quantity;
		}
		return $array;
	}
	function xuatKhoTrongKy($search){
		$tb = $this->base_model->loadTable();
		$fromDate = fmDateSave($search['formdate']);
		$todate = fmDateSave($search['todate']);
		$branchid = $this->login->branchid;
		$sql = "
			select sum(ip.quantity) as quantity, ip.goodsid, ip.branchid, ip.warehouseid
			from `".$tb['hotel_output']."` ip
			left join `".$tb['hotel_output_createorders']."` ic on ic.uniqueid = ip.uniqueid
			where ip.isdelete = 0
			and ip.branchid = '$branchid'
			and ic.datepo <= '$todate'
			and ic.datepo >= '$fromDate'
			group by ip.goodsid, ip.branchid, ip.warehouseid
		";
		$query = $this->model->query($sql)->execute();
		$array = array();
		foreach($query as $item){
			$array[$item->branchid][$item->warehouseid][$item->goodsid] = $item->quantity;
		}
		return $array;
	}
	function xuatTraNCC($search){
		$tb = $this->base_model->loadTable();
		$fromDate = fmDateSave($search['formdate']);
		$todate = fmDateSave($search['todate']);
		$branchid = $this->login->branchid;
		$sql = "
			select sum(ip.quantity) as quantity, ip.goodsid, ip.branchid, ip.warehouseid
			from `".$tb['hotel_output_return']."` ip
			left join `".$tb['hotel_output_createorders_return']."` ic on ic.uniqueid = ip.uniqueid
			where ip.isdelete = 0
			and ip.branchid = '$branchid'
			and ic.datepo <= '$todate'
			and ic.datepo >= '$fromDate'
			group by ip.goodsid, ip.branchid, ip.warehouseid
		";
		$query = $this->model->query($sql)->execute();
		$array = array();
		foreach($query as $item){
			$array[$item->branchid][$item->warehouseid][$item->goodsid] = $item->quantity;
		}
		return $array;
	}
	function getList($search,$page,$rows){
		$searchs = $this->getSearch($search);
		$skey = $this->login->skey;
		$tb = $this->base_model->loadTable();
		$sql = "
			SELECT g.goods_code, l.location_name, i.locationid, i.goodsid, i.branchid, i.warehouseid, i.id,
			g.goods_name, b.branch_name, w.warehouse_name, sum(i.quantity) quantity,ut.unit_name, g.buy_price
			FROM `".$tb['hotel_inventory']."` i
			left join `".$tb['hotel_goods']."` g on g.id = i.goodsid 
			left join `".$tb['hotel_branch']."` b on b.id = i.branchid 
			left join `".$tb['hotel_warehouse']."` w on w.id = i.warehouseid
			left join `".$tb['hotel_unit']."` ut on ut.id = g.unitid
			left join `".$tb['hotel_location']."` l on l.id = i.locationid
			where i.isdelete = 0
			and g.isdelete = 0
			$searchs
			group by i.goodsid, i.branchid, i.warehouseid
		";
		if(empty($search['order'])){
			$sql.= ' ORDER BY g.goods_code ASC ';
		}
		else{
			$sql.= ' ORDER BY '.$search['order'].' '.$search['index'].', g.goods_code ASC ';
		}
		if($rows != 0){
			$sql.= ' limit '.$page.','.$rows;
		}
		$query = $this->model->query($sql)->execute();
		return $query;
	}
	function getListSum ($search,$page,$rows){
		$searchs = $this->getSearch($search);
		$skey = $this->login->skey;
		$tb = $this->base_model->loadTable();
		$sql = "
			SELECT g.goods_code, i.goodsid, i.branchid, i.warehouseid, i.id,
			g.goods_name, sum(i.quantity) quantity, g.buy_price
			FROM `".$tb['hotel_inventory']."` i
			left join `".$tb['hotel_goods']."` g on g.id = i.goodsid 
			left join `".$tb['hotel_branch']."` b on b.id = i.branchid 
			left join `".$tb['hotel_warehouse']."` w on w.id = i.warehouseid
			left join `".$tb['hotel_unit']."` ut on ut.id = g.unitid
			left join `".$tb['hotel_location']."` l on l.id = i.locationid
			where i.isdelete = 0
			and g.isdelete = 0
			$searchs
			group by i.goodsid, i.branchid, i.warehouseid
		";
		$query = $this->model->query($sql)->execute();
		return $query;
	}
	function getTotal($search){
		$tb = $this->base_model->loadTable();
		$searchs = $this->getSearch($search);
		$sql = " 
		SELECT count(1) total
			FROM `".$tb['hotel_inventory']."` i
			left join `".$tb['hotel_goods']."` g on g.id = i.goodsid 
			left join `".$tb['hotel_branch']."` b on b.id = i.branchid 
			left join `".$tb['hotel_warehouse']."` w on w.id = i.warehouseid
			left join `".$tb['hotel_unit']."` ut on ut.id = g.unitid
			where i.isdelete = 0
			and g.isdelete = 0
		$searchs
		";
		$query = $this->model->query($sql)->execute();
		return $query[0]->total;	
	}
	function saves($array){
		$tb = $this->base_model->loadTable();
		#region validate
		if(empty($array['goodsid'])){
			return 'goodsid';
		}
		if(empty($array['warehouseid'])){
			return 'warehouseid';
		}
		if(empty($array['supplier_id'])){
			return 'supplier_id';
		}
		if(empty($array['quantity'])){
			return 'quantity';
		}
		if(empty($array['unitid'])){
			return 'unitid';
		}
		if(empty($array['priceone'])){
			return 'priceone';
		}
		if(empty($array['branchid'])){
			return 'branchid';
		}
		#end region validate
		
		#region insert into input
		$result = $this->model->table($tb['hotel_input'])->insert($array);
		#end region insert to input
		
		#region insert to inventory
		if($result){ // bắt đầu cập nhật kho
			$goodsInventory = $this->model->table($tb['hotel_inventory'])
						  ->select()
						  ->where('isdelete',0)
						  ->where('goodsid',$array['goodsid'])
						  ->where('warehouseid',$array['warehouseid'])
						  ->where('branchid',$array['branchid'])
						  ->find(); // chưa lấy theo đơn vị
			if(!empty($goodsInventory->id)){ // đã có hàng tồn
				$arrayInventory = array(
					'goodsid' => $array['goodsid'],
					'branchid' => $array['branchid'],
					'warehouseid' => $array['warehouseid'],
					'goods_status' => 1,
					'quantity' => (int)($array['quantity']+$goodsInventory->quantity),
					'unitid' => $array['unitid'],
					'userupdate' => $array['usercreate'],
					'dateupdate' => $array['datecreate'],
				);

			// print_r($goodsInventory); exit;
				$this->model->table($tb['hotel_inventory'])
							->where('id', $goodsInventory->id)
							->update($arrayInventory);
			}
			else{ // chưa có hàng tồn
				$arrayInventory = array(
					'goodsid' => $array['goodsid'],
					'branchid' => $array['branchid'],
					'warehouseid' => $array['warehouseid'],
					'goods_status' => 1,
					'quantity' => $array['quantity'],
					'unitid' => $array['unitid'],
					'usercreate' => $array['usercreate'],
					'datecreate' => $array['datecreate'],
				);
				$result = $this->model->table($tb['hotel_inventory'])->insert($arrayInventory);
			}
		}
		#end region insert to inventory
		return $result;
	}
	function edits($array,$id){
		$tb = $this->base_model->loadTable();
		$oldInput = $this->model->table($tb['hotel_input'])
								->select('quantity,goodsid,warehouseid,branchid')
								->where('isdelete',0)
								->where('id',$id)
								->find();
		$oldQuantity = !empty($oldInput->quantity) ? $oldInput->quantity : 0;
		$oldWarehouse = $oldInput->warehouseid;
		$oldBranch = $oldInput->branchid;
		$oldGoods = $oldInput->goodsid;
		$result = $this->model->table($tb['hotel_input'])->where('id',$id)->update($array);
		
		#region insert to inventory
		if(
			$oldWarehouse != $array['warehouseid'] || 
			$oldBranch != $array['branchid'] || 
			$oldGoods != $array['goodsid']
		){
			$goodsInventory = $this->model->table($tb['hotel_inventory'])
										  ->select()
										  ->where('isdelete',0)
										  ->where('goodsid',$oldGoods)
										  ->where('warehouseid',$oldWarehouse)
										  ->where('branchid',$oldBranch)
										  ->find(); // chưa lấy theo đơn vị
			// print_r($goodsInventory);
			if(!empty($goodsInventory->id)){ // đã có hàng tồn
				if($goodsInventory->quantity - $oldQuantity > 0){ // trừ ra
					$arrayInventory = array(
						'goodsid' => $oldGoods,
						'branchid' => $oldBranch,
						'warehouseid' => $oldWarehouse,
						'goods_status' => 1,
						'quantity' => (int)($goodsInventory->quantity - $oldQuantity),
						'unitid' => $array['unitid'],
						'userupdate' => $array['userupdate'],
						'dateupdate' => $array['dateupdate'],
					);

					$this->model->table($tb['hotel_inventory'])
								->where('id', $goodsInventory->id)
								->update($arrayInventory);
				} 
				else{ // delete luôn
					$this->model->table($tb['hotel_inventory'])
								->where('id', $goodsInventory->id)
								->delete();
				}
			}
			$goodsInventory = $this->model->table($tb['hotel_inventory'])
										  ->select()
										  ->where('isdelete',0)
										  ->where('goodsid',$array['goodsid'])
										  ->where('warehouseid',$array['warehouseid'])
										  ->where('branchid',$array['branchid'])
										  ->find(); // chưa lấy theo đơn vị
			if(!empty($goodsInventory->id)){ // đã có hàng tồn
				$arrayInventory = array(
					'goodsid' => $array['goodsid'],
					'branchid' => $array['branchid'],
					'warehouseid' => $array['warehouseid'],
					'goods_status' => 1,
					'quantity' => (int)($array['quantity']+($goodsInventory->quantity)),
					'unitid' => $array['unitid'],
					'userupdate' => $array['userupdate'],
					'dateupdate' => $array['dateupdate'],
				);
				
				$this->model->table($tb['hotel_inventory'])
							->where('id', $goodsInventory->id)
							->update($arrayInventory);
			}
			else{ // update qua 1 kho/chi nhánh khác chưa có hàng này
				$arrayInventory = array(
					'goodsid' => $array['goodsid'],
					'branchid' => $array['branchid'],
					'warehouseid' => $array['warehouseid'],
					'goods_status' => 1,
					'quantity' => (int)($array['quantity']),
					'unitid' => $array['unitid'],
					'usercreate' => $array['userupdate'],
					'datecreate' => $array['dateupdate'],
				);
				$result = $this->model->table($tb['hotel_inventory'])->insert($arrayInventory);
			}
		}
		else{
			$goodsInventory = $this->model->table($tb['hotel_inventory'])
										  ->select()
										  ->where('isdelete',0)
										  ->where('goodsid',$array['goodsid'])
										  ->where('warehouseid',$array['warehouseid'])
										  ->where('branchid',$array['branchid'])
										  ->find(); // chưa lấy theo đơn vị
			if(!empty($goodsInventory->id)){ // đã có hàng tồn
				$arrayInventory = array(
					'goodsid' => $array['goodsid'],
					'branchid' => $array['branchid'],
					'warehouseid' => $array['warehouseid'],
					'goods_status' => 1,
					'quantity' => (int)($array['quantity']+($goodsInventory->quantity - $oldQuantity)),
					'unitid' => $array['unitid'],
					'userupdate' => $array['userupdate'],
					'dateupdate' => $array['dateupdate'],
				);
				
				$this->model->table($tb['hotel_inventory'])
							->where('id', $goodsInventory->id)
							->update($arrayInventory);
			}
			else{ // update qua 1 kho/chi nhánh khác chưa có hàng này
				$arrayInventory = array(
					'goodsid' => $array['goodsid'],
					'branchid' => $array['branchid'],
					'warehouseid' => $array['warehouseid'],
					'goods_status' => 1,
					'quantity' => (int)($array['quantity']),
					'unitid' => $array['unitid'],
					'usercreate' => $array['userupdate'],
					'datecreate' => $array['dateupdate'],
				);
				$result = $this->model->table($tb['hotel_inventory'])->insert($arrayInventory);
			}
		}
		#end region insert to inventory
		 
		 return $id;
	 }
	function deletes($array, $id){
		$tb = $this->base_model->loadTable();
		$oldInput = $this->model->table($tb['hotel_input'])
								->select('quantity,goodsid,warehouseid,branchid')
								->where('isdelete',0)
								->where('id',$id)
								->find();
		$oldQuantity = !empty($oldInput->quantity) ? $oldInput->quantity : 0;
		$oldWarehouse = $oldInput->warehouseid;
		$oldBranch = $oldInput->branchid;
		$oldGoods = $oldInput->goodsid;
		
		$goodsInventory = $this->model->table($tb['hotel_inventory'])
									  ->select()
									  ->where('isdelete',0)
									  ->where('goodsid',$oldGoods)
									  ->where('warehouseid',$oldWarehouse)
									  ->where('branchid',$oldBranch)
									  ->find(); // chưa lấy theo đơn vị
		if(!empty($goodsInventory->id)){ // đã có hàng tồn
			$arrayInventory = array(
				'goodsid' => $oldGoods,
				'branchid' => $oldBranch,
				'warehouseid' => $oldWarehouse,
				'goods_status' => 1,
				'quantity' => (int)($goodsInventory->quantity - $oldQuantity),
				'userupdate' => $array['userupdate'],
				'dateupdate' => $array['dateupdate'],
			);
			
			$this->model->table($tb['hotel_inventory'])
						->where('id', $goodsInventory->id)
						->update($arrayInventory);
		}
		
		$this->model->table($tb['hotel_input'])
					->where('id', $id)
					->update($array);
		return $id;
	}
	function findID($id){
		$tb = $this->base_model->loadTable();
		$query = $this->model->table($tb['hotel_inventory'])
					  ->select('*')
					  ->where('id',$id)
					  ->find();
		return $query;
	 }
}