<?php
/**
 * @author 
 * @copyright 2015
 */
 class InventoryModel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->login = $this->site->getSession('login');
	}
	function getSearch($search){
		$sql = "";
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
		/*if(!empty($search['warehouseid'])){
			$sql.= " and i.warehouseid in (".$search['warehouseid'].") ";	
		}*/
		if(!empty($search['tonkhoid'])){
			if($search['tonkhoid'] == 1){
				$sql.= " and i.quantity > 0";	
			}
			elseif($search['tonkhoid'] == 2){
				$sql.= " and i.quantity <= 0";	
			}
			elseif($search['tonkhoid'] == 3){
				$sql.= " and i.quantity <= g.quantitymin ";	
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
	function getList($search,$page,$rows){
		$searchs = $this->getSearch($search);
		$tb = $this->base_model->loadTable();
		$skey = $this->login->skey;
		$sql = "
			SELECT g.goods_code, l.location_name, i.locationid, i.goodsid, i.branchid, i.warehouseid, i.id, g.quantitymin,
			g.goods_name, g.img, b.branch_name as branch_name,
			 w.warehouse_name, i.quantity ,ut.unit_name, uts.unit_name as exchange_unit,
			 (i.quantity / g.exchange) as exchange_quantity
			FROM `".$tb['hotel_inventory']."` i
			left join `".$tb['hotel_goods']."` g on g.id = i.goodsid 
			left join `".$tb['hotel_branch']."` b on b.id = i.branchid 
			left join `".$tb['hotel_warehouse']."` w on w.id = i.warehouseid
			left join `".$tb['hotel_unit']."` ut on ut.id = g.unitid
			left join `".$tb['hotel_location']."` l on l.id = i.locationid
			left join `".$tb['hotel_unit']."` uts on uts.id = g.exchange_unit
			where i.isdelete = 0
			$searchs
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