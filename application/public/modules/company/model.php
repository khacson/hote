<?php
/**
 * @author 
 * @copyright 2015
 */
 class CompanyModel extends CI_Model{
	function __construct(){
		parent::__construct('hotel_company');
		$this->login = $this->site->getSession('login');
	}
	function getSearch($search){
		$sql = "";
		if(!empty($search['company_name'])){
			$sql.= " and c.company_name like '%".$search['company_name']."%' ";	
		}
		if(!empty($search['phone'])){
			$sql.= " and c.phone like '%".$search['phone']."%' ";	
		}
		if(!empty($search['fax'])){
			$sql.= " and c.fax like '%".$search['fax']."%' ";	
		}
		if(!empty($search['email'])){
			$sql.= " and c.email like '%".$search['email']."%' ";	
		}
		if(!empty($search['provinceid'])){
			$sql.= " and c.provinceid in (".$search['provinceid'].") ";	
		}
		if(!empty($search['districid'])){
			$sql.= " and c.districid in (".$search['districid'].") ";	
		}
		$login = $this->login;
		if(!empty($login->companyid)){
			$sql .= " AND c.id = '".$login->companyid ."' ";
		}
		return $sql;
	}
	function getList($search,$page,$rows){
		$searchs = $this->getSearch($search);
		$sql = "SELECT c.*, p.province_name, d.distric_name
				FROM hotel_company AS c
				LEFT JOIN hotel_province p on p.id = c.provinceid and p.isdelete = 0
				LEFT JOIN hotel_district d on d.id = c.districid and d.isdelete = 0
				WHERE c.isdelete = 0 
				$searchs
				";
		if(empty($search['order'])){
			$sql.= ' ORDER BY c.id DESC ';
		}
		else{
			$sql.= ' ORDER BY '.$search['order'].' '.$search['index'].' ';
		}
		$sql.= ' limit '.$page.','.$rows;
		$query = $this->model->query($sql)->execute();
		return $query;
	}
	function getTotal($search){
		$searchs = $this->getSearch($search);
		$sql = " 
		SELECT count(1) total
		FROM hotel_company AS c
		LEFT JOIN hotel_province p on p.id = c.provinceid
		LEFT JOIN hotel_district d on d.id = c.districid 
		WHERE c.isdelete = 0 
		$searchs	
		";
		$query = $this->model->query($sql)->execute();
		return $query[0]->total;	
	}
	function saves($array){
		$this->db->trans_start();
		$check = $this->model->table('hotel_company')
					  ->select('id')
					  ->where('isdelete',0)
					  ->where('company_name',$array['company_name'])
					  ->where('phone',$array['phone'])
					  ->find();
		if(!empty($check->id)){
			return -1;	
		}
		if(empty($array['count_room'])){
			$array['count_room'] = 1;
		}
		if(empty($array['count_branch'])){
			$array['count_branch'] = 1;
		}
		$data = $this->rand(). gmdate("ymdHis",time() + 7 * 3600).$this->site->friendlyURL($array['phone']).$this->site->friendlyURL($array['company_name']);
		$sql = "
				INSERT INTO `hotel_company` 
				(`company_name`, `phone`, `fax`, `email`, `address`, `provinceid`, `districid`, `count_room`, `count_branch`, `datecreate`, `usercreate`,`skeys`) 
				VALUES 
				('".$array['company_name']."', '".$array['phone']."', '".$array['fax']."', '".$array['email']."', '".$array['address']."', '".$array['provinceid']."', '".$array['districid']."', '".$array['count_room']."', '".$array['count_branch']."', '".$array['datecreate']."', '".$array['usercreate']."',DES_ENCRYPT('$data','sonnk2504'));
			;
		";
		$result = $this->model->executeQuery($sql);	
		$check = $this->model->table('hotel_company')
					  ->select('id')
					  ->where('isdelete',0)
					  ->where('company_name',$array['company_name'])
					  ->order_by('id','DESC')
					  ->find();
		$companyid = $check->id; 
		$this->createTable($companyid);
		$this->db->trans_complete();
		return 1;
	}
	function createTable($companyid){
		$this->db->trans_start();
		#region tao table
		#region hotel_acction_
		$sql1 = "
			CREATE TABLE `hotel_acction_$companyid` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `ctrol` char(100) DEFAULT NULL,
			  `func` char(50) DEFAULT NULL,
			  `description` varchar(250) DEFAULT NULL,
			  `acction_before` varchar(5000) DEFAULT NULL,
			  `action_after` varchar(5000) DEFAULT NULL,
			  `datecreate` datetime DEFAULT NULL,
			  `usercreate` char(50) DEFAULT NULL,
			  `ipcreate` char(50) DEFAULT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
		";
		$this->model->executeQuery($sql1);
		#end
		#region hotel_branch_
		$sql2 = "
			CREATE TABLE `hotel_branch_$companyid` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `branch_name` char(100) DEFAULT NULL,
			  `phone` char(50) DEFAULT NULL,
			  `fax` char(50) DEFAULT NULL,
			  `email` char(100) DEFAULT NULL,
			  `address` char(100) DEFAULT NULL,
			  `provinceid` int(11) DEFAULT NULL,
			  `districid` int(11) DEFAULT NULL,
			  `companyid` int(11) DEFAULT '0',
			  `datecreate` datetime DEFAULT NULL,
			  `usercreate` char(50) DEFAULT NULL,
			  `dateupdate` datetime DEFAULT NULL,
			  `userupdate` char(50) DEFAULT NULL,
			  `isdelete` tinyint(1) DEFAULT '0',
			  PRIMARY KEY (`id`),
			  KEY `idx_company` (`companyid`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Chi nhánh';
		";
		$this->model->executeQuery($sql2);
		#end
		#region hotel_customer_15
		$sql3 = "
			CREATE TABLE `hotel_customer_$companyid` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `customer_code` char(30) DEFAULT NULL,
			  `customer_name` char(100) DEFAULT NULL,
			  `phone` char(50) DEFAULT NULL,
			  `fax` char(50) DEFAULT NULL,
			  `email` char(70) DEFAULT NULL,
			  `address` char(100) DEFAULT NULL,
			  `provinceid` int(11) DEFAULT NULL,
			  `districid` int(11) DEFAULT NULL,
			  `companyid` int(11) DEFAULT '0',
			  `usecontact` char(50) DEFAULT NULL,
			  `phoneusecontact` char(50) DEFAULT NULL,
			  `taxcode` char(25) DEFAULT NULL,
			  `bankcode` char(30) DEFAULT NULL,
			  `bankname` char(100) DEFAULT NULL,
			  `birthday` date DEFAULT NULL,
			  `checkprint` tinyint(1) DEFAULT '0',
			  `datecreate` datetime DEFAULT NULL,
			  `usercreate` char(50) DEFAULT NULL,
			  `dateupdate` datetime DEFAULT NULL,
			  `userupdate` char(50) DEFAULT NULL,
			  `isdelete` tinyint(1) DEFAULT '0',
			  PRIMARY KEY (`id`),
			  KEY `idx_company` (`companyid`),
			  KEY `idx_taxcode` (`taxcode`),
			  KEY `idx_code` (`customer_code`),
			  KEY `idx_bankcode` (`bankcode`)
			) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
		";
		$this->model->executeQuery($sql3);
		#end
		#region hotel_employeesale_
		$sql4 = "
			CREATE TABLE `hotel_employeesale_$companyid` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `branchid` int(11) DEFAULT NULL,
				  `companyid` int(11) DEFAULT NULL,
				  `employee_code` char(25) DEFAULT NULL,
				  `employee_name` char(50) DEFAULT NULL,
				  `sex` tinyint(1) DEFAULT '1',
				  `birthday` date DEFAULT NULL,
				  `identity` char(25) DEFAULT NULL,
				  `identity_date` date DEFAULT NULL,
				  `identity_from` varchar(100) DEFAULT NULL,
				  `phone` char(25) DEFAULT NULL,
				  `datecreate` datetime DEFAULT NULL,
				  `usercreate` char(50) DEFAULT NULL,
				  `dateupdate` datetime DEFAULT NULL,
				  `userupdate` char(50) DEFAULT NULL,
				  `isdelete` tinyint(1) DEFAULT '0',
				  PRIMARY KEY (`id`),
				  KEY `idx_company` (`companyid`)
				) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

		";
		$this->model->executeQuery($sql4);
		#end
		#region hotel_export_return_15
		$sql5 = "
			CREATE TABLE `hotel_export_return_$companyid` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `poid` char(30) DEFAULT NULL,
			  `datepo` date DEFAULT NULL,
			  `uniqueid` bigint(20) DEFAULT NULL,
			  `companyid` int(11) DEFAULT NULL,
			  `goodsid` int(11) DEFAULT NULL,
			  `quantity` int(11) DEFAULT NULL,
			  `priceone` double DEFAULT NULL COMMENT 'Gia nhap',
			  `price_out` double DEFAULT NULL COMMENT 'Gia xuat',
			  `price` double DEFAULT NULL,
			  `usercreate` char(50) DEFAULT NULL,
			  `datecreate` datetime DEFAULT NULL,
			  `ipcreate` char(35) DEFAULT NULL,
			  `userupdate` char(50) DEFAULT NULL,
			  `dateupdate` datetime DEFAULT NULL,
			  `ipupdate` char(50) DEFAULT NULL,
			  `isdelete` tinyint(1) DEFAULT '0',
			  PRIMARY KEY (`id`),
			  KEY `idx_googdid` (`goodsid`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;

		";
		$this->model->executeQuery($sql5);
		#end
		#region hotel_export_return_orders_
		$sql6 = "
			CREATE TABLE `hotel_export_return_orders_$companyid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `poid` char(30) DEFAULT NULL,
  `datepo` date DEFAULT NULL,
  `uniqueid` bigint(20) DEFAULT NULL,
  `companyid` int(11) DEFAULT NULL,
  `branchid` int(11) DEFAULT NULL,
  `warehouseid` int(11) DEFAULT NULL,
  `customerid` int(11) DEFAULT NULL COMMENT 'khach hang le kho co id',
  `customer_type` tinyint(2) DEFAULT NULL,
  `customer_name` char(100) DEFAULT NULL,
  `customer_address` char(150) DEFAULT NULL,
  `customer_phone` char(30) DEFAULT NULL,
  `customer_email` char(70) DEFAULT NULL,
  `employeeid` int(11) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `payments` tinyint(1) DEFAULT NULL,
  `vat` double DEFAULT NULL,
  `price_depreciation` double DEFAULT NULL COMMENT 'khau hao',
  `quantity` double DEFAULT NULL,
  `price` double DEFAULT NULL,
  `price_total` double DEFAULT NULL,
  `price_prepay` double DEFAULT NULL COMMENT 'khau hao',
  `usercreate` char(50) DEFAULT NULL,
  `datecreate` datetime DEFAULT NULL,
  `ipcreate` char(35) DEFAULT NULL,
  `userupdate` char(50) DEFAULT NULL,
  `dateupdate` datetime DEFAULT NULL,
  `ipupdate` char(50) DEFAULT NULL,
  `isdelete` tinyint(1) DEFAULT '0',
  `isnew` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

		";
		$this->model->executeQuery($sql6);
		#end
		#region 
		$sql7 = "
					";
		$this->model->executeQuery($sql7);
		#end
		$sql8 = "
			CREATE TABLE `hotel_goods_$companyid` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `goods_code` char(50) DEFAULT NULL,
			  `goods_code2` char(50) DEFAULT NULL,
			  `goods_name` blob,
			  `goods_type` int(11) DEFAULT NULL,
			  `madein` varchar(250) DEFAULT NULL,
			  `discountsales` double DEFAULT '0',
			  `discounthotel_type` tinyint(1) DEFAULT '1' COMMENT '1 %, 2 Tien',
			  `unitid` int(11) DEFAULT NULL,
			  `shelflife` tinyint(1) DEFAULT '0' COMMENT '1 co han su dung',
			  `img` char(100) DEFAULT NULL,
			  `sale_price` char(150) DEFAULT NULL,
			  `buy_price` double DEFAULT NULL,
			  `companyid` int(11) DEFAULT NULL,
			  `vat` double DEFAULT NULL COMMENT '%',
			  `description` varchar(500) DEFAULT NULL,
			  `location` char(50) DEFAULT NULL,
			  `quantitymin` double DEFAULT NULL,
			  `isserial` tinyint(1) DEFAULT '0',
			  `guarantee` date DEFAULT NULL,
			  `isnegative` tinyint(1) DEFAULT '0' COMMENT '1 cho phep xuat am',
			  `datecreate` datetime DEFAULT NULL,
			  `usercreate` char(50) DEFAULT NULL,
			  `dateupdate` datetime DEFAULT NULL,
			  `userupdate` char(50) DEFAULT NULL,
			  `isdelete` tinyint(1) DEFAULT '0',
			  PRIMARY KEY (`id`),
			  KEY `idx_company` (`companyid`),
			  KEY `idx_goods_type` (`goods_type`),
			  KEY `idx_unitid` (`unitid`),
			  KEY `idx_code` (`goods_code`)
			) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
			";
		$this->model->executeQuery($sql8);
		$sql9 = "
			CREATE TABLE `hotel_goods_group_$companyid` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `group_code` char(30) DEFAULT NULL,
			  `group_name` char(150) DEFAULT NULL,
			  `unitid` int(11) DEFAULT NULL,
			  `usercreate` char(50) DEFAULT NULL,
			  `datecreate` datetime DEFAULT NULL,
			  `userupdate` char(50) DEFAULT NULL,
			  `dateupdate` datetime DEFAULT NULL,
			  `isdelete` tinyint(1) DEFAULT '0',
			  PRIMARY KEY (`id`),
			  KEY `idx_unitid` (`unitid`)
			) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

		";
		$this->model->executeQuery($sql9);
		$sql10 = "
			CREATE TABLE `hotel_goods_group_detail_$companyid` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `groupid` int(11) DEFAULT NULL,
			  `goodid` int(11) DEFAULT NULL,
			  `unitid` int(11) DEFAULT NULL,
			  `exchang` double DEFAULT NULL,
			  `usercreate` char(50) DEFAULT NULL,
			  `datecreate` datetime DEFAULT NULL,
			  `userupdate` char(50) DEFAULT NULL,
			  `dateupdate` datetime DEFAULT NULL,
			  `isdelete` tinyint(1) DEFAULT '0',
			  PRIMARY KEY (`id`),
			  KEY `idx_unitid` (`unitid`),
			  KEY `idx_groupid` (`groupid`),
			  KEY `idx_goodid` (`goodid`)
			) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
		$this->model->executeQuery($sql10);
		
		$sql11 = "CREATE TABLE `hotel_goods_type_$companyid` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `goods_tye_name` varchar(250) DEFAULT NULL,
					  `friendlyurl` char(200) DEFAULT NULL,
					  `companyid` int(11) DEFAULT NULL,
					  `description` varchar(500) DEFAULT NULL,
					  `datecreate` datetime DEFAULT NULL,
					  `usercreate` char(50) DEFAULT NULL,
					  `dateupdate` datetime DEFAULT NULL,
					  `userupdate` char(50) DEFAULT NULL,
					  `isdelete` tinyint(1) DEFAULT '0',
					  PRIMARY KEY (`id`),
					  KEY `idx_companyid` (`companyid`),
					  KEY `idx_url` (`friendlyurl`)
					) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
					";
		$this->model->executeQuery($sql11);
		
		$sql12 = "
			CREATE TABLE `hotel_input_$companyid` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `sttview` int(11) DEFAULT NULL,
			  `poid` char(30) DEFAULT NULL,
			  `uniqueid` bigint(20) DEFAULT NULL,
			  `companyid` int(11) DEFAULT NULL,
			  `ponumber` int(11) DEFAULT NULL,
			  `goodsid` int(11) DEFAULT NULL,
			  `branchid` int(11) DEFAULT NULL,
			  `warehouseid` int(11) DEFAULT NULL,
			  `supplierid` int(11) DEFAULT NULL COMMENT 'khach hang le kho co id',
			  `quantity` double DEFAULT NULL,
			  `priceone` double DEFAULT NULL COMMENT 'Gia nhap',
			  `price_out` double DEFAULT NULL COMMENT 'Gia xuat',
			  `price` double DEFAULT NULL,
			  `guarantee` date DEFAULT NULL,
			  `shelflife` date DEFAULT NULL,
			  `usercreate` char(50) DEFAULT NULL,
			  `datecreate` datetime DEFAULT NULL,
			  `ipcreate` char(35) DEFAULT NULL,
			  `userupdate` char(50) DEFAULT NULL,
			  `dateupdate` datetime DEFAULT NULL,
			  `ipupdate` char(50) DEFAULT NULL,
			  `isdelete` tinyint(1) DEFAULT '0',
			  `isnew` tinyint(1) DEFAULT '0',
			  PRIMARY KEY (`id`),
			  KEY `idx_googdid` (`goodsid`)
			) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
			";
		$this->model->executeQuery($sql12);
		$sql13 = "
			CREATE TABLE `hotel_input_createorders_$companyid` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `poid` char(30) DEFAULT NULL,
			  `datepo` date DEFAULT NULL,
			  `stt` int(11) DEFAULT '0',
			  `soquyen` int(11) DEFAULT '0',
			  `uniqueid` bigint(20) DEFAULT NULL,
			  `companyid` int(11) DEFAULT NULL,
			  `ponumber` int(11) DEFAULT NULL,
			  `branchid` int(11) DEFAULT NULL,
			  `warehouseid` int(11) DEFAULT NULL,
			  `supplierid` int(11) DEFAULT NULL COMMENT 'khach hang le kho co id',
			  `description` varchar(500) DEFAULT NULL,
			  `quantity` double DEFAULT NULL,
			  `price` double DEFAULT NULL,
			  `price_prepay` double DEFAULT NULL COMMENT 'tam ung',
			  `tax` double DEFAULT NULL,
			  `payments` tinyint(1) DEFAULT NULL,
			  `payments_status` tinyint(1) DEFAULT '0' COMMENT '- 1 con no khach hang',
			  `maturitydate` date DEFAULT NULL,
			  `isnew` tinyint(1) DEFAULT '0',
			  `percent` tinyint(1) DEFAULT NULL,
			  `percent_value` double DEFAULT NULL,
			  `usercreate` char(50) DEFAULT NULL,
			  `datecreate` datetime DEFAULT NULL,
			  `ipcreate` char(35) DEFAULT NULL,
			  `signature` varchar(250) DEFAULT NULL,
			  `signature_name` char(50) DEFAULT NULL,
			  `userupdate` char(50) DEFAULT NULL,
			  `dateupdate` datetime DEFAULT NULL,
			  `ipupdate` char(50) DEFAULT NULL,
			  `isdelete` tinyint(1) DEFAULT '0',
			  PRIMARY KEY (`id`),
			  KEY `idx_uniqueid` (`uniqueid`),
			  KEY `idx_company` (`companyid`),
			  KEY `idx_branchid` (`branchid`),
			  KEY `idx_poid` (`poid`),
			  KEY `idx_addList` (`isdelete`,`isnew`,`usercreate`)
			) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
			";
		$this->model->executeQuery($sql13);
		
		$sql14 = "
			CREATE TABLE `hotel_input_return_$companyid` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `warehouseid` int(11) DEFAULT NULL,
			  `branchid` int(11) DEFAULT NULL,
			  `poid` char(30) DEFAULT NULL,
			  `datepo` date DEFAULT NULL,
			  `uniqueid` bigint(20) DEFAULT NULL,
			  `companyid` int(11) DEFAULT NULL,
			  `goodsid` int(11) DEFAULT NULL,
			  `quantity` int(11) DEFAULT NULL,
			  `priceone` double DEFAULT NULL COMMENT 'Gia nhap',
			  `price_out` double DEFAULT NULL COMMENT 'Gia xuat',
			  `price` double DEFAULT NULL,
			  `discount` double DEFAULT NULL,
			  `guarantee` date DEFAULT NULL,
			  `usercreate` char(50) DEFAULT NULL,
			  `datecreate` datetime DEFAULT NULL,
			  `ipcreate` char(35) DEFAULT NULL,
			  `userupdate` char(50) DEFAULT NULL,
			  `dateupdate` datetime DEFAULT NULL,
			  `ipupdate` char(50) DEFAULT NULL,
			  `isdelete` tinyint(1) DEFAULT '0',
			  PRIMARY KEY (`id`),
			  KEY `idx_googdid` (`goodsid`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;

		";
		$this->model->executeQuery($sql14);
		
		$sql15 = "
			CREATE TABLE `hotel_input_return_orders_$companyid` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `soid` char(30) DEFAULT NULL,
				  `poid` char(30) DEFAULT NULL,
				  `datepo` date DEFAULT NULL,
				  `uniqueid` bigint(20) DEFAULT NULL,
				  `companyid` int(11) DEFAULT NULL,
				  `branchid` int(11) DEFAULT NULL,
				  `warehouseid` int(11) DEFAULT NULL,
				  `customerid` int(11) DEFAULT NULL COMMENT 'khach hang le kho co id',
				  `customer_type` tinyint(2) DEFAULT NULL,
				  `customer_name` char(100) DEFAULT NULL,
				  `customer_address` char(150) DEFAULT NULL,
				  `customer_phone` char(30) DEFAULT NULL,
				  `customer_email` char(70) DEFAULT NULL,
				  `employeeid` int(11) DEFAULT NULL,
				  `description` varchar(500) DEFAULT NULL,
				  `payments` tinyint(1) DEFAULT NULL,
				  `vat` double DEFAULT NULL,
				  `price_depreciation` double DEFAULT NULL COMMENT 'khau hao',
				  `quantity` double DEFAULT NULL,
				  `price` double DEFAULT NULL,
				  `price_total` double DEFAULT NULL,
				  `price_prepay` double DEFAULT NULL COMMENT 'khau hao',
				  `place_of_delivery` date DEFAULT NULL,
				  `deliverydate` date DEFAULT NULL,
				  `signature_x` char(100) DEFAULT NULL,
				  `signature_name_x` char(100) DEFAULT NULL,
				  `usercreate` char(50) DEFAULT NULL,
				  `datecreate` datetime DEFAULT NULL,
				  `ipcreate` char(35) DEFAULT NULL,
				  `userupdate` char(50) DEFAULT NULL,
				  `dateupdate` datetime DEFAULT NULL,
				  `ipupdate` char(50) DEFAULT NULL,
				  `isdelete` tinyint(1) DEFAULT '0',
				  `isnew` tinyint(1) DEFAULT '0',
				  PRIMARY KEY (`id`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8;

		";
		$this->model->executeQuery($sql15);
		
		$sql16 = "
			CREATE TABLE `hotel_inventory_$companyid` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `companyid` int(11) DEFAULT NULL,
				  `branchid` int(11) DEFAULT NULL,
				  `warehouseid` int(11) DEFAULT NULL,
				  `goodsid` int(11) DEFAULT NULL,
				  `goods_status` tinyint(1) DEFAULT '1',
				  `shelflife` date DEFAULT NULL,
				  `quantity` double DEFAULT NULL,
				  `locationid` int(11) DEFAULT '0',
				  `userupdate` char(50) DEFAULT NULL,
				  `dateupdate` datetime DEFAULT NULL,
				  `isdelete` tinyint(1) DEFAULT '0',
				  PRIMARY KEY (`id`),
				  KEY `idx_googdid` (`goodsid`),
				  KEY `idx_companny` (`companyid`),
				  KEY `idx_warehouse` (`warehouseid`),
				  KEY `idx_branch` (`branchid`)
				) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
		";
		$this->model->executeQuery($sql16);
		
		$sql17 = "
			CREATE TABLE `hotel_location_$companyid` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `location_name` varchar(250) DEFAULT NULL,
				  `friendlyurl` char(200) DEFAULT NULL,
				  `description` varchar(250) DEFAULT NULL,
				  `companyid` int(11) DEFAULT NULL,
				  `datecreate` datetime DEFAULT NULL,
				  `usercreate` char(50) DEFAULT NULL,
				  `dateupdate` datetime DEFAULT NULL,
				  `userupdate` char(50) DEFAULT NULL,
				  `isdelete` tinyint(1) DEFAULT '0',
				  PRIMARY KEY (`id`),
				  KEY `idx_url` (`friendlyurl`),
				  KEY `idx_companyid` (`companyid`)
				) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
		";
		$this->model->executeQuery($sql17);
		
		$sql18 = "
			CREATE TABLE `hotel_output_$companyid` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `sttview` int(11) DEFAULT NULL,
			  `soid` int(11) DEFAULT NULL,
			  `socode` char(30) DEFAULT NULL,
			  `poid` char(30) DEFAULT NULL,
			  `serial_number` char(25) DEFAULT NULL,
			  `uniqueid` bigint(20) NOT NULL,
			  `companyid` int(11) DEFAULT '0',
			  `goodsid` int(11) DEFAULT '0',
			  `branchid` int(11) DEFAULT '0',
			  `warehouseid` int(11) DEFAULT '0',
			  `quantity` double DEFAULT '0',
			  `priceone` double DEFAULT NULL,
			  `price` double DEFAULT NULL,
			  `discount` double DEFAULT NULL,
			  `pricein` double DEFAULT NULL,
			  `isorder` tinyint(1) DEFAULT '0',
			  `guarantee` date DEFAULT NULL,
			  `usercreate` char(50) DEFAULT NULL,
			  `datecreate` datetime DEFAULT NULL,
			  `userupdate` char(50) DEFAULT NULL,
			  `dateupdate` datetime DEFAULT NULL,
			  `isdelete` tinyint(1) DEFAULT '0',
			  PRIMARY KEY (`id`),
			  KEY `idx_googdid` (`goodsid`),
			  KEY `idx_company` (`companyid`),
			  KEY `idx_branch` (`branchid`),
			  KEY `idx_warehouse` (`warehouseid`),
			  KEY `idx_uniqueid` (`uniqueid`),
			  KEY `idx_socode` (`socode`)
			) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

		";
		$this->model->executeQuery($sql18);
		
		$sql19 = "
			CREATE TABLE `hotel_output_createorders_$companyid` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `soid` int(11) DEFAULT NULL,
				  `socode` char(30) DEFAULT NULL,
				  `poid` char(30) NOT NULL DEFAULT '0',
				  `datepo` date DEFAULT NULL,
				  `stt` int(11) DEFAULT NULL,
				  `uniqueid` bigint(20) NOT NULL,
				  `customer_id` int(11) DEFAULT '0',
				  `customer_type` tinyint(1) DEFAULT '1',
				  `customer_name` varchar(250) DEFAULT NULL,
				  `customer_address` varchar(250) DEFAULT NULL,
				  `customer_phone` char(50) DEFAULT NULL,
				  `customer_email` char(70) DEFAULT NULL,
				  `companyid` int(11) DEFAULT '0',
				  `employeeid` int(11) DEFAULT '0',
				  `branchid` int(11) DEFAULT '0',
				  `warehouseid` int(11) DEFAULT '0',
				  `isout` tinyint(1) DEFAULT '0',
				  `isorder` tinyint(1) DEFAULT '0',
				  `payments` tinyint(1) DEFAULT '0',
				  `payments_status` tinyint(1) DEFAULT '0',
				  `maturitydate` date DEFAULT NULL,
				  `quantity` double DEFAULT NULL,
				  `price_total` double DEFAULT NULL,
				  `price` double DEFAULT NULL,
				  `price_prepay` double DEFAULT NULL,
				  `vat` double DEFAULT NULL,
				  `percent_value` double DEFAULT NULL,
				  `description` varchar(500) DEFAULT NULL,
				  `place_of_delivery` varchar(250) DEFAULT NULL,
				  `deliverydate` date DEFAULT NULL,
				  `signature` varchar(250) DEFAULT NULL,
				  `signature_name` char(50) DEFAULT NULL,
				  `signature_x` varchar(250) DEFAULT NULL,
				  `signature_name_x` char(50) DEFAULT NULL,
				  `usercreate` char(50) DEFAULT NULL,
				  `datecreate` datetime DEFAULT NULL,
				  `userupdate` char(50) DEFAULT NULL,
				  `dateupdate` datetime DEFAULT NULL,
				  `isdelete` tinyint(1) DEFAULT '0',
				  `isnew` tinyint(1) DEFAULT '1',
				  PRIMARY KEY (`id`),
				  KEY `idx_unique` (`uniqueid`),
				  KEY `idx_company` (`companyid`),
				  KEY `idx_usercreate` (`usercreate`),
				  KEY `idx_poid` (`poid`),
				  KEY `idx_soid` (`soid`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		";
		$this->model->executeQuery($sql19);
		
		$sql20 = "
			CREATE TABLE `hotel_output_createorders_order_$companyid` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `poid` char(30) NOT NULL DEFAULT '0',
				  `datepo` date DEFAULT NULL,
				  `stt` int(11) DEFAULT NULL,
				  `uniqueid` bigint(20) NOT NULL,
				  `customer_id` int(11) DEFAULT '0',
				  `customer_type` tinyint(1) DEFAULT '1',
				  `customer_name` varchar(250) DEFAULT NULL,
				  `customer_address` varchar(250) DEFAULT NULL,
				  `customer_phone` char(50) DEFAULT NULL,
				  `customer_email` char(70) DEFAULT NULL,
				  `companyid` int(11) DEFAULT '0',
				  `employeeid` int(11) DEFAULT '0',
				  `branchid` int(11) DEFAULT '0',
				  `warehouseid` int(11) DEFAULT '0',
				  `payments` tinyint(1) DEFAULT '0',
				  `payments_status` tinyint(1) DEFAULT '0',
				  `maturitydate` date DEFAULT NULL,
				  `quantity` double DEFAULT NULL,
				  `price_total` double DEFAULT NULL,
				  `price` double DEFAULT NULL,
				  `price_prepay` double DEFAULT NULL,
				  `vat` double DEFAULT NULL,
				  `percent_value` double DEFAULT NULL,
				  `description` varchar(500) DEFAULT NULL,
				  `place_of_delivery` varchar(250) DEFAULT NULL,
				  `deliverydate` date DEFAULT NULL,
				  `guarantee` date DEFAULT NULL,
				  `signature` varchar(250) DEFAULT NULL,
				  `signature_name` char(50) DEFAULT NULL,
				  `signature_x` varchar(250) DEFAULT NULL,
				  `signature_name_x` char(50) DEFAULT NULL,
				  `usercreate` char(50) DEFAULT NULL,
				  `datecreate` datetime DEFAULT NULL,
				  `userupdate` char(50) DEFAULT NULL,
				  `dateupdate` datetime DEFAULT NULL,
				  `isdelete` tinyint(1) DEFAULT '0',
				  `isnew` tinyint(1) DEFAULT '1',
				  PRIMARY KEY (`id`),
				  KEY `idx_unique` (`uniqueid`),
				  KEY `idx_company` (`companyid`),
				  KEY `idx_usercreate` (`usercreate`),
				  KEY `idx_poid` (`poid`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8;

		";
		$this->model->executeQuery($sql20);
		
		$sql21 = "
			CREATE TABLE `hotel_output_createorders_return_$companyid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `soid` char(30) DEFAULT NULL,
  `poid` char(30) DEFAULT NULL,
  `datepo` date DEFAULT NULL,
  `stt` int(11) DEFAULT '0',
  `soquyen` int(11) DEFAULT '0',
  `uniqueid` bigint(20) DEFAULT NULL,
  `companyid` int(11) DEFAULT NULL,
  `ponumber` int(11) DEFAULT NULL,
  `branchid` int(11) DEFAULT NULL,
  `warehouseid` int(11) DEFAULT NULL,
  `supplierid` int(11) DEFAULT NULL COMMENT 'khach hang le kho co id',
  `description` varchar(500) DEFAULT NULL,
  `quantity` double DEFAULT NULL,
  `price` double DEFAULT NULL,
  `price_prepay` double DEFAULT NULL COMMENT 'tam ung',
  `tax` double DEFAULT NULL,
  `payments` tinyint(1) DEFAULT '1',
  `payments_status` tinyint(1) DEFAULT '0' COMMENT '- 1 con no khach hang',
  `maturitydate` date DEFAULT NULL,
  `isnew` tinyint(1) DEFAULT '0',
  `percent` tinyint(1) DEFAULT NULL,
  `percent_value` double DEFAULT NULL,
  `usercreate` char(50) DEFAULT NULL,
  `datecreate` datetime DEFAULT NULL,
  `ipcreate` char(35) DEFAULT NULL,
  `signature` varchar(250) DEFAULT NULL,
  `signature_name` char(50) DEFAULT NULL,
  `userupdate` char(50) DEFAULT NULL,
  `dateupdate` datetime DEFAULT NULL,
  `ipupdate` char(50) DEFAULT NULL,
  `isdelete` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_uniqueid` (`uniqueid`),
  KEY `idx_company` (`companyid`),
  KEY `idx_branchid` (`branchid`),
  KEY `idx_poid` (`poid`),
  KEY `idx_addList` (`isdelete`,`isnew`,`usercreate`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

		";
		$this->model->executeQuery($sql21);
		
		$sql22 = "
			CREATE TABLE `hotel_output_order_$companyid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sttview` int(11) DEFAULT NULL,
  `poid` char(30) DEFAULT NULL,
  `uniqueid` bigint(20) NOT NULL,
  `companyid` int(11) DEFAULT '0',
  `goodsid` int(11) DEFAULT '0',
  `branchid` int(11) DEFAULT '0',
  `warehouseid` int(11) DEFAULT '0',
  `quantity` double DEFAULT '0',
  `priceone` double DEFAULT NULL,
  `price` double DEFAULT NULL,
  `discount` double DEFAULT NULL,
  `isorder` tinyint(1) DEFAULT '0',
  `guarantee` date DEFAULT NULL,
  `usercreate` char(50) DEFAULT NULL,
  `datecreate` datetime DEFAULT NULL,
  `userupdate` char(50) DEFAULT NULL,
  `dateupdate` datetime DEFAULT NULL,
  `isdelete` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_googdid` (`goodsid`),
  KEY `idx_company` (`companyid`),
  KEY `idx_branch` (`branchid`),
  KEY `idx_warehouse` (`warehouseid`),
  KEY `idx_uniqueid` (`uniqueid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

		";
		$this->model->executeQuery($sql22);
		
		$sql23 = "
			CREATE TABLE `hotel_output_return_$companyid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sttview` int(11) DEFAULT NULL,
  `poid` char(30) DEFAULT NULL,
  `uniqueid` bigint(20) DEFAULT NULL,
  `companyid` int(11) DEFAULT NULL,
  `ponumber` int(11) DEFAULT NULL,
  `goodsid` int(11) DEFAULT NULL,
  `branchid` int(11) DEFAULT NULL,
  `warehouseid` int(11) DEFAULT NULL,
  `supplierid` int(11) DEFAULT NULL COMMENT 'khach hang le kho co id',
  `quantity` double DEFAULT NULL,
  `priceone` double DEFAULT NULL COMMENT 'Gia nhap',
  `price_out` double DEFAULT NULL COMMENT 'Gia xuat',
  `price` double DEFAULT NULL,
  `guarantee` date DEFAULT NULL,
  `shelflife` date DEFAULT NULL,
  `usercreate` char(50) DEFAULT NULL,
  `datecreate` datetime DEFAULT NULL,
  `ipcreate` char(35) DEFAULT NULL,
  `userupdate` char(50) DEFAULT NULL,
  `dateupdate` datetime DEFAULT NULL,
  `ipupdate` char(50) DEFAULT NULL,
  `isdelete` tinyint(1) DEFAULT '0',
  `isnew` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_googdid` (`goodsid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	
		";
		$this->model->executeQuery($sql23);
		
		$sql24 = "
			CREATE TABLE `hotel_pay_$companyid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `poid` char(30) DEFAULT NULL,
  `pay_code` char(30) DEFAULT NULL,
  `datepo` date DEFAULT NULL,
  `uniqueid` varchar(45) DEFAULT NULL,
  `companyid` int(11) DEFAULT NULL,
  `branchid` varchar(45) DEFAULT NULL,
  `pay_type` int(11) DEFAULT NULL,
  `payment` tinyint(1) DEFAULT NULL COMMENT 'thanh toan',
  `amount` double DEFAULT NULL,
  `notes` varchar(250) DEFAULT NULL,
  `usercreate` char(50) NOT NULL,
  `datecreate` datetime NOT NULL,
  `dateupdate` datetime DEFAULT NULL,
  `userupdate` char(50) DEFAULT NULL,
  `isdeletype` tinyint(1) DEFAULT NULL,
  `isdelete` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_code` (`pay_code`),
  KEY `idx_uniqueid` (`uniqueid`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

		";
		$this->model->executeQuery($sql24);
		
		$sql25 = "
			CREATE TABLE `hotel_pay_type_$companyid` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `pay_type_name` char(100) DEFAULT NULL,
			  `companyid` varchar(45) DEFAULT NULL,
			  `usercreate` char(50) NOT NULL,
			  `datecreate` datetime NOT NULL,
			  `dateupdate` datetime DEFAULT NULL,
			  `userupdate` char(50) DEFAULT NULL,
			  `isdelete` tinyint(1) NOT NULL DEFAULT '0',
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

		";
		$this->model->executeQuery($sql25);
		
		$sql26 = "
			CREATE TABLE `hotel_priceout_$companyid` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `goodsid` int(11) DEFAULT NULL,
			  `price` double DEFAULT NULL,
			  `description` varchar(250) DEFAULT NULL,
			  `usercreate` char(50) DEFAULT NULL,
			  `datecreate` datetime DEFAULT NULL,
			  `userupdate` char(50) DEFAULT NULL,
			  `dateupdate` datetime DEFAULT NULL,
			  `isdelete` tinyint(1) DEFAULT '0',
			  PRIMARY KEY (`id`),
			  KEY `idx_goodid` (`goodsid`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;

		";
		$this->model->executeQuery($sql26);
		
		$sql27 = "
			CREATE TABLE `hotel_receipts_$companyid` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `receipts_code` char(30) DEFAULT NULL,
			  `uniqueid` varchar(45) DEFAULT NULL,
			  `poid` char(30) DEFAULT NULL,
			  `datepo` date DEFAULT NULL,
			  `companyid` int(11) DEFAULT NULL,
			  `branchid` varchar(45) DEFAULT NULL,
			  `receipts_type` int(11) DEFAULT NULL,
			  `payment` tinyint(1) DEFAULT NULL COMMENT 'thanh toan',
			  `amount` double DEFAULT NULL,
			  `notes` varchar(250) DEFAULT NULL,
			  `usercreate` char(50) NOT NULL,
			  `datecreate` datetime NOT NULL,
			  `dateupdate` datetime DEFAULT NULL,
			  `userupdate` char(50) DEFAULT NULL,
			  `isdeletype` tinyint(1) DEFAULT NULL,
			  `isdelete` tinyint(1) NOT NULL DEFAULT '0',
			  PRIMARY KEY (`id`),
			  KEY `idx_code` (`receipts_code`),
			  KEY `idx_uniqueid` (`uniqueid`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;

		";
		$this->model->executeQuery($sql27);
		
		$sql28 = "
			CREATE TABLE `hotel_seial_$companyid` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `goodsid` int(11) DEFAULT NULL,
				  `uniqueid` bigint(20) DEFAULT NULL,
				  `sn` char(50) DEFAULT NULL,
				  `imei` char(50) DEFAULT NULL,
				  `description` varchar(250) DEFAULT NULL,
				  `usercreate` char(50) DEFAULT NULL,
				  `datecreate` datetime DEFAULT NULL,
				  `userupdate` char(50) DEFAULT NULL,
				  `dateupdate` datetime DEFAULT NULL,
				  `isdelete` tinyint(1) DEFAULT '0',
				  PRIMARY KEY (`id`),
				  KEY `idx_goodid` (`goodsid`)
				) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

		";
		$this->model->executeQuery($sql28);
		
		$sql29 = "
			CREATE TABLE `hotel_supplier_$companyid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_code` char(30) DEFAULT NULL,
  `supplier_name` blob,
  `phone` blob,
  `fax` blob,
  `email` blob,
  `address` blob,
  `provinceid` int(11) DEFAULT NULL,
  `districid` int(11) DEFAULT NULL,
  `companyid` int(11) DEFAULT '0',
  `usecontact` char(50) DEFAULT NULL,
  `phoneusecontact` blob,
  `taxcode` char(25) DEFAULT NULL,
  `bankcode` char(30) DEFAULT NULL,
  `bankname` char(100) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `datecreate` datetime DEFAULT NULL,
  `usercreate` char(50) DEFAULT NULL,
  `dateupdate` datetime DEFAULT NULL,
  `userupdate` char(50) DEFAULT NULL,
  `isdelete` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_company` (`companyid`),
  KEY `idx_code` (`supplier_code`),
  KEY `idx_taxcode` (`taxcode`),
  KEY `idx_bankcode` (`bankcode`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='nhà cung cấp';

		";
		$this->model->executeQuery($sql29);
		
		$sql30 = "
			CREATE TABLE `hotel_unit_$companyid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unit_name` varchar(250) DEFAULT NULL,
  `friendlyurl` char(200) DEFAULT NULL,
  `companyid` int(11) DEFAULT NULL,
  `datecreate` datetime DEFAULT NULL,
  `usercreate` char(50) DEFAULT NULL,
  `dateupdate` datetime DEFAULT NULL,
  `userupdate` char(50) DEFAULT NULL,
  `isdelete` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_url` (`friendlyurl`),
  KEY `idx_companyid` (`companyid`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

		";
		$this->model->executeQuery($sql30);
		
		$sql31 = "
			CREATE TABLE `hotel_warehouse_$companyid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `warehouse_name` varchar(150) DEFAULT NULL,
  `address` varchar(250) DEFAULT NULL,
  `branchid` int(11) DEFAULT NULL,
  `provinceid` int(11) DEFAULT NULL,
  `districid` int(11) DEFAULT NULL,
  `companyid` int(11) DEFAULT '0',
  `datecreate` datetime DEFAULT NULL,
  `usercreate` char(50) DEFAULT NULL,
  `dateupdate` datetime DEFAULT NULL,
  `userupdate` char(50) DEFAULT NULL,
  `isdelete` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_company` (`companyid`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='Kho hàng';

		";
		$this->model->executeQuery($sql31);
		
		$sql32 = "
			CREATE TABLE `hotel_xuat_nhap_ton_$companyid` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `istype` tinyint(1) DEFAULT '1' COMMENT '1 nhap 2 xuat',
				  `deviceid` int(11) DEFAULT NULL,
				  `uniqueid` bigint(20) DEFAULT NULL,
				  `part_type` tinyint(1) DEFAULT '0' COMMENT '0 passed, 1 untest, 2 scrap, 3 fail',
				  `sl_ton` double DEFAULT NULL,
				  `gia_ton` double DEFAULT NULL,
				  `sl_nhap` double DEFAULT NULL,
				  `gia_nhap` double DEFAULT NULL,
				  `sl_xuat` double DEFAULT NULL,
				  `gia_xuat` double DEFAULT NULL,
				  `gia_ban` double DEFAULT NULL,
				  `ton_kho` double DEFAULT NULL,
				  `gia_binh_quan` double DEFAULT NULL,
				  `gia_von_ton_kho` double DEFAULT NULL,
				  `datecreate` datetime DEFAULT NULL,
				  `usercreate` char(50) DEFAULT NULL,
				  `isdelete` tinyint(1) DEFAULT '0',
				  PRIMARY KEY (`id`),
				  KEY `idx_uniqueid` (`uniqueid`),
				  KEY `idx_deviceid` (`deviceid`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		";
		$this->model->executeQuery($sql32);
		
		$sql33 = "
			CREATE TABLE `hotel_receipts_type_$companyid` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `receipts_type_name` char(100) DEFAULT NULL,
			  `companyid` varchar(45) DEFAULT NULL,
			  `usercreate` char(50) NOT NULL,
			  `datecreate` datetime NOT NULL,
			  `dateupdate` datetime DEFAULT NULL,
			  `userupdate` char(50) DEFAULT NULL,
			  `isdelete` tinyint(1) NOT NULL DEFAULT '0',
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

		";
		$this->model->executeQuery($sql33);
		#end
		#Thêm mặc định loại phiếu chi
		$datecreate  = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
		$usercreate = $this->login->username;
		$sqlAdd = "
			INSERT INTO `hotel_receipts_type_$companyid` (`receipts_type_name`, `companyid`, `usercreate`, `datecreate`) VALUES ('Thu bán hàng', '$companyid', '$usercreate', '$datecreate');
		";
		$this->model->executeQuery($sqlAdd);
		$sqlAdd = "
			INSERT INTO `hotel_pay_type_$companyid` (`pay_type_name`, `companyid`, `usercreate`, `datecreate`) VALUES ('Chi mua hàng', '$companyid', '$usercreate', '$datecreate');
		";
		$this->model->executeQuery($sqlAdd);
		#end
		$this->db->trans_complete();
	}
	function rand(){
		$pool = '20122804';
		$str = '';
		for ($i = 0; $i < 4; $i++){
			$str .= substr($pool, mt_rand(0, strlen($pool) -1), 1);
		}
		return $str;
	}
	function edits($array,$id){
		 $check = $this->model->table('hotel_company')
		 ->select('id')
		 ->where('isdelete',0)
		 ->where('id <>',$id)
		 ->where('company_name',$array['company_name'])
		 ->where('phone',$array['phone'])
		 ->find();
		 if(!empty($check->id)){
			 return -1;	
		 }
		 //$array['friendlyurl'] = $this->site->friendlyURL($array['company_name']);
		 $result = $this->model->table('hotel_company')->where('id',$id)->update($array);	
		 return $id;
	 }
	function findID($id){
		 $query = $this->model->table('hotel_company')
					  ->select('*')
					  ->where('id',$id)
					  ->find();
		return $query;
	 }
}