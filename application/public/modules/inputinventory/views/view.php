<style title="" type="text/css">
	.col-md-4{ white-space: nowrap !important;}
	.col-md-3{ white-space: nowrap !important;}
</style>

<!-- BEGIN PORTLET-->
<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption mtop8">
			<b><i class="fa fa-pencil-square-o mleft10" style="margin-top:4px; font-size:15px;" aria-hidden="true"></i>
			<?=getLanguage('tao-phieu-nhap-kho');?></b>
		</div>
		<div class="tools">
			<ul class="button-group pull-right mbottom10">
				<li id="refresh" >
					<button class="button">
						<i class="fa fa-refresh"></i>
						<?=getLanguage('lam-moi')?>
					</button>
				</li>
				<?php if(isset($permission['add'])){?>
				<li id="save">
					<button class="button save-input">
						<i class="fa fa-save"></i>
						<?=getLanguage('luu');?>
					</button>
				</li>
				<?php } ?>
				<!--<li id="print">
					<button class="button">
						<i class="fa fa-print"></i>
						<?=getLanguage('luu-in');?>
					</button>
				</li>-->
				<li id="viewprint">
					<button class="button">
						<i class="fa fa-print"></i>
						<?=getLanguage('in-pn');?>
					</button>
				</li>
				<li id="viewprintpc">
					<button class="button">
						<i class="fa fa-print"></i>
						<?=getLanguage('phieu-chi');?>
					</button>
				</li>
				<li class="histoty">
					<a href="<?=base_url();?>historyinput.html">
						<button class="button">
							<i class="fa fa-history"></i>
							<?=getLanguage('lich-su');?>
						</button>
					</a>
				</li>
			</ul>
		</div>
	</div>
	<div class="portlet-body">
		<div class="row">
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label  class="control-label col-md-3"><?=getLanguage('don-hang');?> </label>
						<div class="col-md-9" style="">
							<select id="ponumberid" name="ponumberid" class="select2me form-control" data-placeholder="<?=getLanguage('chon-don-hang');?>">
								<?php if(count($suppliers) > 1){?>
								<option value=""></option>
								<?php }?>
								<?php foreach($ponumbers as $item){?>
									<option value="<?=$item->id;?>"><?=$item->ponumber;?></option>
								<?php }?>
							</select>
						</div>
					</div>
				</div>	
				<div class="col-md-4">
					<div class="form-group">
						<label class="control-label col-md-4"><?=getLanguage('nha-cung-cap');?> (<span class="red">*</span>)</label>
						<div class="col-md-7">
							<span id="loadSupplier">
								<select id="supplierid" name="supplierid" class="searchs select2me form-control" data-placeholder="<?=getLanguage('chon-nha-cung-cap');?>">
									<?php if(count($suppliers) > 1){?>
									<option value=""></option>
									<?php }?>
									<?php foreach($suppliers as $item){?>
										<option value="<?=$item->id;?>"><?=$item->supplier_name;?></option>
									<?php }?>
								</select>
							</span>
						</div>
						<div class="col-md-1" style="margin-left:-20px; margin-top:2px;">
							<a data-placement="left" title="<?=getLanguage('them-nha-cung-cap');?>" class="btn btn-sm btns" id="addSuppliers" data-toggle="modal" data-target="#myFrom" href="#">
								<i class="fa fa-plus" aria-hidden="true"></i>
							</a>
						</div>
					</div>
				</div>
				<div class="col-md-4" style="display:none;">
					<div class="form-group">
						<label class="control-label col-md-4"><?=getLanguage('nhap-kho');?> (<span class="red">*</span>)</label>
						<div class="col-md-8 ">
							<span id="loadWarehouse">
								<select id="warehouseid" name="warehouseid" class="searchs select2me form-control" data-placeholder="<?=getLanguage('chon-kho')?>">
							
									<?php 
									$totalW = count($warehouses);
									if($totalW > 1){?>
									<option value=""></option>
									<?php }?>
									<?php
									$selected = '';
									if($totalW == 1){
										$selected = 'selected';
									}
									foreach($warehouses as $item){
										if($totalW > 1){
											if(!empty($item->isdedault)){
												$selected = 'selected';
											}
											else{
												$selected = '';
											}
										}
										?>
										<option <?=$selected;?>
										value="<?=$item->id;?>"><?=$item->warehouse_name;?></option>
									<?php }?>
								</select>
							</span>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="control-label col-md-4"><?=getLanguage('ngay-nhap');?></label>
						 <div class="col-md-8 date date-picker" data-date-format="<?=cfdateHtml();?>">
							<?php 
							$datecreate =  gmdate(cfdate(), time() + 7 * 3600);
							?>
							<input value="<?=$datecreate;?>" type="text" id="datecreate" placeholder="<?=cfdateHtml();?>" name="datecreate" class="form-control searchs tab-event" >
							<span class="input-group-btn ">
								<button class="btn default btn-picker" type="button"><i class="fa fa-calendar "></i></button>
							</span>
						</div>
					</div>
				</div>
			</div>
			<div class="row mtop10">
				<div class="col-md-4">
					<div class="form-group">
						<label  class="control-label col-md-3"><?=getLanguage('hang-hoa');?> </label>
						<div class="col-md-9" style="">
							<input type="text" name="goodsid" id="goodsid" placeholder="<?=getLanguage('nhap-ma-ten-hoac-scan');?>" class="search form-control tab-event" />
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="control-label col-md-4"><?=getLanguage('ghi-chu');?></label>
						<div class="col-md-8 ">
							<input type="text" name="description" id="description" placeholder="" value="" class="searchs form-control tab-event" maxlength="250"/>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row mtop10">
			  <div class="col-md-12" style="">
					<div class="row">
						<table class="inputgoods">
							<thead>
								<tr class="thds">
									<td width="40" rowspan="2"><?=getLanguage('stt');?></td>
									<td rowspan="2" ><?=getLanguage('hang-hoa');?></td>
									<td width="100" rowspan="2"><?=getLanguage('dvt');?></td>
									<td width="90" rowspan="2"><?=getLanguage('so-luong');?></td>
									<td width="100" rowspan="2"><?=getLanguage('don-gia');?></td>
									<!--<td width="60" rowspan="2"><?=getLanguage('vat');?>(%)</td>-->
									<td width="200" colspan="2"><?=getLanguage('chiet-khau');?></td>
									<td width="120" rowspan="2"><?=getLanguage('thanh-tien');?></td>
									<td width="30" rowspan="2"></td>
								</tr>
								<tr class="thds">
								  <td ><?=configs()['currency'];?>/%<div style="font-size:10px; width:100%; float:left;"><i>Ex: 2% hoạc 2,000</i></div></td>
								  <td ><?=getLanguage('san-pham');?></td>
								</tr>
							</thead>
							<tbody class="gridView"></tbody>
						</table>
					</div>
			  </div>
			  <div class="col-md-12">
				   <div class="col-md-5">
				   </div><!--E 6-->
				   <div class="col-md-1"></div>
				   <div class="col-md-6">
					  <div class="row">
						<div class="col-md-12">
							<div class="col-md-3">
								 <div class="row">
									<?=getLanguage('tong');?>
								 </div>
							</div>
							<div class="col-md-6"></div>
							<div class="col-md-3 text-right" >
								<div class="row" id="total-amount">0</div>
							</div>
						</div><!--E Row-->
						<div class="col-md-12 mtopline">
							<div class="col-md-3">
								<div class="row">
									<?=getLanguage('giam-gia');?>
								</div>
							</div>
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<input type="text" name="discount" placeholder="" id="discount" class="form-input fm-number form-control text-right" value="" />
									</div>
									<div class="col-md-6">
										<div class="row">
											<select class="form-control select2me" id="input_discount_type" name="input_discount_type" >
												<option value="1"><?=configs()['currency'];?></option>
												<option value="2">%</option>
											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-3 text-right" >
								<div class="row" id="total-discount">0</div>
							</div>
						</div><!--E Row-->
						<div class="col-md-12 mtopline">
							<div class="col-md-3">
								<div class="row"><?=getLanguage('dieu-chinh');?></div>
							</div>
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<input type="text" name="adjustment" placeholder="" id="adjustment" class="form-input form-control text-right" value="" />
									</div>
									<div class="col-md-6"></div>
								</div>
							</div>
							<div class="col-md-3 text-right"><div class="row" id="total-adjustment">0</div></div>
						</div><!--E Row-->
						<div class="col-md-12 mtopline">
							<div class="col-md-3">
								<div class="row"><?=getLanguage('vat');?>(%)</div>
							</div>
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<input type="text" name="vat" placeholder="" id="vat" class="form-input form-control fm-number text-right" value="" />
									</div>
									<div class="col-md-6"></div>
								</div>
							</div>
							<div class="col-md-3 text-right"><div class="row" id="total-vat">0</div></div>
						</div><!--E Row-->
						
						<div class="col-md-12 mtopline">
							<div class="col-md-3">
								<div class="row"><?=getLanguage('thanh-toan');?></div>
							</div>
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<input type="text" name="price_prepay" placeholder="" id="price_prepay" class="form-input fm-number form-control text-right" value="" />
									</div>
									<div class="col-md-6">
										<div class="row">
											<select class="form-control select2me" id="price_prepay_type" name="price_prepay_type" >
												<option value="1"><?=configs()['currency'];?></option>
												<option value="2">%</option>
											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-3 text-right"><div class="row" id="total-tamung">0</div></div>
						</div><!--E Row-->
						<div class="col-md-12 mtopline">
							<div class="col-md-3">
								<div class="row"><?=getLanguage('ht-thanh-toan');?></div>
							</div>
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<select class="form-control select2me" id="payments" name="payments" >
											<option value="1"><?=getLanguage('tien-mat');?></option>
											<option value="2"><?=getLanguage('chuyen-khoan');?></option>
										</select>
									</div>
									<div class="col-md-6">
										<div class="row">
											<select id="bankid" name="bankid" class="select2me form-control" data-placeholder="<?=getLanguage('chon-ngan-hang')?>">
												<?php if(count($banks) > 1){?>
												<option value=""></option>
												<?php }?>
												<?php foreach($banks as $item){?>
													<option value="<?=$item->id;?>"><?=$item->bank_name;?></option>
												<?php }?>
											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-3 text-right"></div>
						</div><!--E Row-->
						<div class="col-md-12 mtopline">
							<div class="col-md-3">
								<div class="row"><b><?=getLanguage('tong-cong');?></b></div>
							</div>
							<div class="col-md-6">
								<input type="hidden" name="total_quantity" placeholder="" id="total_quantity" value="" />
							</div>
							<div class="col-md-3 text-right" >
								<div class="row" id="total-amount-end">0</div>
							</div>
						</div>
						<!--E Row-->
						<div class="col-md-12 mtopline">
							<div class="col-md-3">
								<div class="row"><b><?=getLanguage('con-lai');?></b></div>
							</div>
							<div class="col-md-6"></div>
							<div class="col-md-3 text-right" >
								<div class="row" id="total-amount-end_cl">0</div>
							</div>
						</div>
						<!--E Row-->
				   </div><!--E 6-->
				</div><!--E 6-->
			</div>
		</div>
	</div>
	<div class="portlet-title">
		<div class="caption mtop8"></div>
		<div class="tools">
			<ul class="button-group pull-right mbottom10">
				<li id="refresh2" >
					<button class="button">
						<i class="fa fa-refresh"></i>
						<?=getLanguage('lam-moi')?>
					</button>
				</li>
				<?php if(isset($permission['add'])){?>
				<li id="save2">
					<button class="button save-input">
						<i class="fa fa-save"></i>
						<?=getLanguage('luu');?>
					</button>
				</li>
				<?php } ?>
				<li id="viewprint2">
					<button class="button">
						<i class="fa fa-print"></i>
						<?=getLanguage('in-pn');?>
					</button>
				</li>
				<li id="viewprintpc2">
					<button class="button">
						<i class="fa fa-print"></i>
						<?=getLanguage('in-pc');?>
					</button>
				</li>
				<!--<li>
					<a title="Nhập từ excel" class="" id="importgoods" data-toggle="modal" data-target="#myFromImport" href="#">
						<button class="button">
							<i class="fa fa-arrow-up" aria-hidden="true"></i>Nhập từ excel
						</button>
					</a>
				</li>-->
				<li class="histoty">
					<a href="<?=base_url();?>historyinput.html">
						<button class="button">
							<i class="fa fa-history"></i>
							<?=getLanguage('lich-su');?>
						</button>
					</a>
				</li>
			</ul>
		</div>
	</div>
</div>
<div class="loading" style="display: none;">
	<div class="blockUI blockOverlay" style="width: 100%;height: 100%;top:0px;left:0px;position: absolute;background-color: rgb(0,0,0);opacity: 0.1;z-index: 9999000;">
	</div>
	<div class="blockUI blockMsg blockElement" style="width: 30%;position: absolute;top: 15%;left:35%;text-align: center; z-index: 9999000;">
		<img src="<?=url_tmpl()?>img/ajax_loader.gif" style="z-index: 2;position: absolute; z-index: 9999000;"/>
	</div>
</div> 
<!--S My form-->
<!-- Modal -->
<div class="modal fade" id="myFrom" role="dialog">
	<div class="modal-dialog">
	  <!-- Modal content-->
	  <div class="modal-content">
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
		  <h4 class="modal-title"><i class="fa fa-plus" aria-hidden="true"></i> <?=getLanguage('them-nha-cung-cap');?></h4>
		</div>
		<div class="modal-bodys">
			<!--Content-->
		</div>
		<div class="modal-footer">
		  <button type="button" id="addSups" class="btn btn-default"><?=getLanguage('lu');?></button>
		</div>
	  </div>
	</div>
</div>
<!--E My form-->
 <!-- Modal -->
<div class="modal fade" id="myFromImport" role="dialog">
	<div class="modal-dialog">
	  <!-- Modal content-->
	  <div class="modal-content">
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
		  <h4 class="modal-title"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Nhập kho từ excel</h4>
		</div>
		<div class="modal-body">
			<!--Content-->
			<input style="display:none;"  name="myfileImmport" id="myfileImmport" type="file"/>
			<ul class="button-group" style="margin:0px;">
				
				<li class="" onclick="javascript:document.getElementById('myfileImmport').click();">
				<button class="btnone" type="button">
				Chọn file</button>
				</li>
				<li id="downloadfile" style="margin-left:10px;" >
				<button class="btnone" type="button">
				Download file mẩu</button>
				</li>
			</ul><br>
			<span class="red">*</span> Lưu ý: <br>
			- File mẩu xuất excel từ chương trình <br>
			<?php if(empty($setuppo)){?>
			- Cột "Đơn hàng" hệ thống tự tăng (không nhập)<br>
			<?php }?>
			- Cột "Thanh toán": <br>
				&nbsp;&nbsp;&nbsp;+ Nếu thanh toán <span style="color:#39F">tiền mặt </span>điền 1<br>
				&nbsp;&nbsp;&nbsp;+ Nếu thanh toán <span style="color:#39F">chuyển khoản </span>điền 2<br>
				&nbsp;&nbsp;&nbsp;+ Nếu thanh toán <span style="color:#39F">thẻ </span>điền 3<br>
			
			- Sheet chứa dữ liệu là sheet đầu tiên</br>
			
		</div>
		<div class="modal-footer">
			 <img id="loads" src="<?=url_tmpl()?>img/ajax_loader.gif" style="z-index: 2;position: absolute; bottom: 5px; right: 120px; display:none;"/>
		  <button type="button" id="addGoods" class="btn btn-default">
		  <i class="fa fa-save" aria-hidden="true"></i>
		  Lưu</button>
		</div>
	  </div>
	  
	</div>
</div>
<!--E My form-->
<!-- view Img -->
<div id="viewImg-form" style="display:none;">
	<div class="">
		<div id="viewImg-form-gridview" ></div>
	</div>
</div>
<input type="hidden" name="unit" placeholder="" id="unit" value="" />
<input type="hidden" name="poid" placeholder="" id="poid" value="" />
<input type="hidden" id="uniqueid" name="uniqueid" />
<!-- view Img -->
<!--E My form-->
<style type="text/css">
	.inputgoods{
		width:98%;	
		margin-left:15px;
		margin-top:0px;
	}
	.thd{
		text-align:center;
	}
	.thds td{
		background:#f7f7f7;
	}
</style>

<link href="<?=url_tmpl();?>css/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src="<?=url_tmpl();?>js/jquery-ui.js" type="text/javascript"></script>
<script type="text/javascript" src="<?=url_tmpl();?>fancybox/source/jquery.fancybox.pack.js"></script>  
<link href="<?=url_tmpl();?>fancybox/source/jquery.fancybox.css" rel="stylesheet" />

<script>
	var controller = '<?=base_url().$routes;?>/';
	var csrfHash = '';
	var goodsList = '';
	var orderList = '';//
	var inputList = {};
	var cpage = 0;
	var search;
	var percent = 0;
	$(function(){
		$('#vat').val('');
		init();
		handleSelect2();
		gridView(0);
		refresh();
		formatNumberKeyUp('fm-number');
		formatNumber('fm-number');
		
		ComponentsPickers.init();
		var isorder = 0;
		var type = 1;
		$('#addSuppliers').click(function(){
			$.ajax({
				url : controller + 'addSupplier ',
				type: 'POST',
				async: false,
				data: {},
				success:function(datas){
					var obj = $.evalJSON(datas);
					$('.modal-bodys').html(obj.content);
					return false;
				}
			});
			$('.datepicker').hide();
		});
		$('#ponumberid').click(function(){
			var poid = $('#ponumberid').val();
			$.ajax({
				url : controller + 'loadSupplierByPO',
				type: 'POST',
				async: false,
				data: {poid:poid},
				success:function(datas){
					$('#loadSupplier').html(datas);
					$('#supplierid').select2({
						placeholder: "<?=getLanguage('chon-nha-cung-cap');?>",
						allowClear: true
					});
					return false;
				}
			});
			$('.datepicker').hide();
		});
		$('#refresh').click(function(){
			$('.loading').show();
			refresh();
		});
		$('.closeModal').click(function(){
			gooods(0,0,0,0,'refresh'); 
			//$('.close').click();
		});
		$('.closeTop').click(function(){
			gooods(0,0,0,0,'refresh'); 
		});
		//S Them nha cung cap
		$('#addSups').click(function(){
			//Ma nha cung cap
			var _a_supplier_code = $('#_a_supplier_code').val();
			if(_a_supplier_code == ''){
				error('Mã nhà cung cấp không được trống.'); 
				$('#_a_supplier_code').focus();
				return false;	
			}
			//Ten nha cung cap
			var _a_supplier_name = $('#_a_supplier_name').val();
			if(_a_supplier_name == ''){
				error('Tên nhà cung cấp không được trống.'); 
				$('#_a_supplier_name').focus();
				return false;	
			}
			var sups = getAddSupplier();
			$.ajax({
				url : controller + 'saveSupplier',
				type: 'POST',
				async: false,
				data: {search:sups},
				success:function(datas){
					var obj = $.evalJSON(datas);
					if(obj.status == -1){
						error("<?=getLanguage('nha-cung-cap-da-ton-tai');?>"); return false;
					}
					else{
						$('#loadSupplier').html(obj.suppliers);
						$('#supplierid').select2({
							placeholder: "<?=getLanguage('chon-nha-cung-cap');?>",
							allowClear: true
						});
						success("<?=getLanguage('them-nha-cung-cap-thanh-cong');?>"); 
						$('.close').click();
					}
				},
				error : function(){
					error("<?=getLanguage('them-nha-cung-cap-thanh-cong');?>"); return false;
				}
			});
		});
		//Them  moi kho hang
		$('#addWarehouse').click(function(){
			$.ajax({
				url : controller + 'addWarehouse',
				type: 'POST',
				async: false,
				data: {id:''},
				success:function(datas){
					var obj = $.evalJSON(datas); 
					$('.modal-body-warehouse').html(obj.content);
				}
			});
		});
		$('#save2').click(function(){
			save('save',0);
		});
		$('#save').click(function(){
			save('save',0);
		});
		$('#print').click(function(){
			save('save','print');
		});
		$('#print2').click(function(){
			save('save','print');
		});
		$('#viewprint').click(function(){
			var unit = $('#uniqueid').val(); 
			if(unit == ''){ return false;}
			print(0,unit);
		});
		$('#viewprint2').click(function(){
			var unit = $('#uniqueid').val(); 
			if(unit == ''){ return false;}
			print(0,unit);
		});
		$('#addGoods').click(function(){
			importExcel();
		});
		$('#downloadfile').click(function(){
			window.location = '<?=base_url();?>files/template/file_mau_nha_kho.xls';
		});
		$('#discount').keyup(function(e){
			 calInputTotal();
		}); 
		$('#input_discount_type').change(function(e){
			 calInputTotal();
		}); 
		//Thanh toan 
		$('#price_prepay').keyup(function(e){
			 calInputTotal();
		}); 
		$('#price_prepay_type').change(function(e){
			 calInputTotal();
		}); 
		//Điều chỉnh giá
		$('#adjustment').keyup(function(e){
			 calInputTotal();
		}); 
		$('#vat').keyup(function(e){
			 calInputTotal();
		}); 
		$("#bankid").prop("disabled",true );
		$('#payments').change(function(){
			var payments = $(this).val();
			if(payments == '1'){
				$("#bankid").prop("disabled",true);
			}
			else{
				$("#bankid").prop("disabled",false);
			}
		});
		clickViewImg();
		actionTemp();
		setDefault();
		calInputTotal(); //Set tinh tong
	});
	function gridView(isnew){
		$.ajax({
			url : controller + 'loadDataTempAdd',
			type: 'POST',
			async: false,
			data: {isnew:isnew},
			success:function(datas){
				var obj = $.evalJSON(datas);
				$('.gridView').html(obj.content);			
			}
		});
	}
	function getAddSupplier(){
		var str = '';
		$('input.sup_txt').each(function(){
			str += ',"'+ $(this).attr('id') +'":"'+ $(this).val().trim() +'"';
		});
		$('select.sup_combo').each(function(){
			str += ',"'+ $(this).attr('id') +'":"'+ getCombo($(this).attr('id')) +'"';
		});
		return '{'+ str.substr(1) +'}';
	}	
	function save(func,id){ 
		//var search = getSearch();
		//var obj = $.evalJSON(search);
		//var quantity = {};
		/*
		if(JSON.stringify(quantity) == '{}'){
			warning("<?=getLanguage('hang-hoa-khong-duong-trong');?>"); return false;	
		}
		if(obj.supplierid == ''){
			warning("<?=getLanguage('chon-nha-cung-cap');?>"); return false;
		}
		var setuppo = parseFloat('<?=$setuppo;?>');
		if(obj.poid == '' && setuppo == 1){
			$('#poid').focus();
			warning("<?=getLanguage('ma-don-khong-duong-trong');?>"); return false;
		}
		//E don gia
		if(obj.customerid == ''&& checkCus == 1){
			warning("<?=getLanguage('chon-nha-cung-cap');?>"); return false;	
		}
		var warehouseid = $('#warehouseid').val();
		if(warehouseid == ''){
			warning("<?=getLanguage('chon-kho');?>"); return false;
		}
		var input_total = $('#input_total').val();
		var price_prepay = $('#price_prepay').val();
		var token = $('#token').val();
		var payments = $('input[name=payments]:checked').val();
		var prepay = $('input[name=prepay]:checked').val();
		var uniqueid = $('#uniqueidnew').val();
		// return false;
		$(".loading").show();
		var description = $('#description').val();
		*/
		//var place_of_delivery = $('#place_of_delivery').val();
		var itemList = getTemIDs(); 
		var ponumberid = $('#ponumberid').val();
		var supplierid = $('#supplierid').val();
		var warehouseid = $('#warehouseid').val();
		if(itemList == '' || itemList == '{}'){
			warning("<?=getLanguage('hang-hoa-khong-duong-trong');?>"); return false;	
		}
		if(supplierid == ''){
			warning("<?=getLanguage('chon-nha-cung-cap');?>"); return false;
		}
		/*if(warehouseid == ''){
			warning("<?=getLanguage('chon-kho-nhap');?>"); return false;
		}*/
		var datecreate = $('#datecreate').val();
		var description = $('#description').val();
		var discount = $('#discount').val();
		var input_discount_type = $('#input_discount_type').val();
		var adjustment = $('#adjustment').val();
		var price_prepay = $('#price_prepay').val();
		var price_prepay_type = $('#price_prepay_type').val();
		var vat = $('#vat').val();
		var objReqest = {};
		objReqest['description'] = description;
		objReqest['ponumberid'] = ponumberid;
		objReqest['supplierid'] = supplierid;
		objReqest['warehouseid'] = supplierid;
		objReqest['datecreate'] = datecreate;
		objReqest['discount'] = discount;
		objReqest['adjustment'] = adjustment;
		objReqest['discount_type'] = input_discount_type;
		objReqest['price_prepay'] = price_prepay;
		objReqest['price_prepay_type'] = price_prepay_type;
		objReqest['total_discount'] = $('#total-discount').html();
		objReqest['total_adjustment'] = $('#total-adjustment').html();
		objReqest['total_tamung'] = $('#total-tamung').html();
		objReqest['total_tongcong'] = $('#total-amount-end').html();
		objReqest['total_amount'] = $('#total-amount').html(); 
		objReqest['payments'] = $('#payments').val();
		objReqest['tong_so_luong'] = $('#tong_so_luong').html(); 
		objReqest['tong_ck_soluong'] = $('#tong_ck_soluong').html(); 
		objReqest['bankid'] = $('#bankid').val();
		objReqest['vat'] = $('#vat').val();
		objReqest['vat_value'] = $('#total-vat').html();
		var search =  JSON.stringify(objReqest); 
		$.ajax({
			url : controller + func,
			type: 'POST',
			async: false,
			data: {itemList:itemList,search:search},
			success:function(datas){
				var obj = $.evalJSON(datas);  //return false;
				$("#token").val(obj.csrfHash);
				$(".loading").hide();
				$('#input_total,#price_prepay,#price_indebtedness').val('');
				if(obj.status == 0){
					error(obj.msg); return false;	
				}
				else{
					if(id == 0){
						$('#unit').val(obj.status);
						$('#poid').val(obj.poid);
						$('.gridView').html('');
						//inputList = {};
						$('#uniqueidnew').val(obj.uniqueidnew);
						$('#uniqueid').val(obj.status);
						success("<?=getLanguage('nhap-kho-thanh-cong');?> "+ obj.poid);
					}
					else{ //poid
						$('#unit').val(obj.status);
						$('#poid').val(obj.poid);
						$('.gridView').html('');
						success("<?=getLanguage('nhap-kho-thanh-cong');?> "+ obj.poid);
						$('#uniqueidnew').val(obj.uniqueidnew);
						$('#uniqueid').val(obj.status);
						//inputList = {};
						print(0,obj.status);
					}
				}
			},
			error : function(){
				$(".loading").hide();
				error("<?=getLanguage('nhap-kho-khong-thanh-cong');?>"); return false;
			}
		});
	}
	function gooods(goodsid,code,stype,exchangs,deletes){ 
	    var vat = $('.valtotal').val();
		var xkm = 0;
		if($('#xuatkm').is(':checked')){
			xkm = 1;
		}
		var uniqueid = $('#uniqueidnew').val();
		$.ajax({
			url : controller + 'getGoods',
			type: 'POST',
			async: false,
			data: {vat:vat,xkm:xkm, id:goodsid,code:code,stype:stype,exchangs:exchangs,deletes:deletes,isnew:0,uniqueid:uniqueid},
			success:function(datas){
				var obj = $.evalJSON(datas); 
				if(obj.status == 0){
					error('Hàng hóa không tồn tại trong hệ thống'); return false;
				}
				$('.gridView').html(obj.content); //Add Grid view
				//$('.ttprice').html(obj.totalPrice);
				$('#uniqueid').val(obj.uniqueid);
				formatNumberKeyUp('fm-number');
				formatNumber('fm-number');
				percent = 0; //gan gia tri tien = 0
				$('#vat').val('');
				$('#prepay_1').prop('checked', true);
				$('#price_indebtedness').val('');
				$('#goodsid').val('');
				actionTemp();
				clickViewImg();
			}
		});
	}
	function clickViewImg(){
		$('.viewImg').each(function(){
			$(this).click(function(){
				 var url = $(this).attr('src');
				 viewImg(url); return false;
			});
		});
	}
	function setDefault(){
	}
	function print(id,unit){
		var token = $('#token').val();
		$.ajax({
			url : controller + 'getDataPrint?unit='+unit,
			type: 'POST',
			async: false,
			data: {csrf_stock_name:token,id:id},
			success:function(datas){
				var object = $.evalJSON(datas); 
				var disp_setting = "toolbar=yes,location=yes,directories=yes,menubar=no,";
			disp_setting += "scrollbars=yes,width=1000, height=500, left=0.0, top=0.0";
				var docprint = window.open("certificate", "certificate", disp_setting);
				docprint.document.open();
				docprint.document.write('<html>');
				//docprint.document.write(css);
				docprint.document.write('<body onLoad="self.print()">');
				docprint.document.write(object.content);
				docprint.document.write('</body></html>');
				docprint.document.close();
				docprint.focus();
			}
		});
		return false;
	}
	function updateDataTemp(goodid){
		var priceone = $('#priceone_'+goodid).val();
		var quantity = $('#quantity_'+goodid).val();
		var discount = $('#discount_'+goodid).val();
		var unitid = $('#unitid_'+goodid).val();
		var xkm = $('#xkm_'+goodid).val();
		var vat = 0;//$('#vat_'+goodid).val();
		//var discount_types = $('#discount_'+goodid).attr('discount_types');
		$.ajax({
			url : controller + 'updatePriceOne',
			type: 'POST',
			//async: false,
			data: {goodid:goodid, priceone:priceone,quantity:quantity,discount:discount,xkm:xkm,isnew:0,vat:vat,unitid:unitid},
			success:function(datas){
				var object = $.evalJSON(datas); 
				/*$('.tongtienhang').html(object.price);
				$('.ttchietkhau').html(object.discount);
				$('#input_total').val(object.priceEnd);
				$('#price_prepay').val(object.priceEnd);
				$('#prepay_1').prop('checked',true);
				$('#price_indebtedness').val(0);*/
			}
		}); 
	}
	function calInputTotal(){
		/*$.ajax({
			url : controller + 'getNewPrice',
			type: 'POST',
			async: false,
			data: {isnew:0},
			success:function(datas){
				var object = $.evalJSON(datas); 
				$('.tongtienhang').html(object.price);
				$('.ttchietkhau').html(object.discount);
				$('#input_total').val(object.priceEnd);
			}
		});*/
		//Tong so luong
		var t_quantity = 0;
		$('.quantity').each(function(){
			var quantity = $(this).val();
			if (quantity == '') {
				quantity = '0';
			}
			quantity = parseFloat(quantity.replace(/[^0-9+\-Ee.]/g, ''));
			t_quantity+= quantity;
		});
		$('#tong_so_luong').html(formatOne(t_quantity));
		//Tong so luong giam tong_ck_soluong
		var t_xuatkhuyenmai  = 0;
		$('.xuatkhuyenmai').each(function(){
			var xuatkhuyenmai  = $(this).val();
			if (xuatkhuyenmai  == '') {
				xuatkhuyenmai  = '0';
			}
			xuatkhuyenmai  = parseFloat(xuatkhuyenmai.replace(/[^0-9+\-Ee.]/g, ''));
			t_xuatkhuyenmai += xuatkhuyenmai ;
		});
		$('#tong_ck_soluong').html(formatOne(t_xuatkhuyenmai));
		//Thanh tien 
		var t_buyprice = 0;
		$('.buyprice').each(function(){
			var buyprice  = $(this).val();
			if (buyprice  == '') {
				buyprice  = '0';
			}
			buyprice  = parseFloat(buyprice.replace(/[^0-9+\-Ee.]/g, ''));
			t_buyprice += buyprice ;
		}); 
		$('#tongtienhang').html(formatOne(t_buyprice));
		$('#total-amount').html(formatOne(t_buyprice));
		//Giam giá
		var discount = $('#discount').val();
		if (discount == '') {
			discount = '0';
		}
		discount = parseFloat(discount.replace(/[^0-9+\-Ee.]/g, ''));
		var input_discount_type = parseFloat($('#input_discount_type').val());
		var giamGia = discount;
		if(input_discount_type == 2){
			giamGia = (t_buyprice * discount)/100;
		}
		$('#total-discount').html(formatOne(giamGia));
		//console.log('dieu chinh: '+giamGia);
		//Giam gia 
		var adjustment = $('#adjustment').val();
		if (adjustment == '') {
			adjustment = '0';
		}
		adjustment = parseFloat(adjustment.replace(/[^0-9+\-Ee.]/g, ''));
		$('#total-adjustment').html(formatOne(adjustment));
		//console.log('dieu chinh: '+adjustment);
		//VAT
		var vat = $('#vat').val();
		if (vat == '') {
			vat = '0';
		}
		vat = parseFloat(vat.replace(/[^0-9+\-Ee.]/g, ''));
		//Tong cong
		var tong_cong = t_buyprice - giamGia + (adjustment);
		//VAT
		var totalVat = (tong_cong * vat)/100;
		//console.log(tong_cong);
		//console.log(totalVat);
		$('#total-vat').html(formatOne(totalVat));
		
		var tong_congs = tong_cong + totalVat;
		$('#total-amount-end').html(formatOne(tong_congs));
		//Tam ung
		var price_prepay = $('#price_prepay').val();
		if (price_prepay == '') {
			price_prepay = '0';
		}
		price_prepay = parseFloat(price_prepay.replace(/[^0-9+\-Ee.]/g, ''));
		var price_prepay_type = parseFloat($('#price_prepay_type').val());
		var tamUng = price_prepay;
		if(price_prepay_type == 2){
			tamUng = (tong_congs * price_prepay)/100;
		}
		$('#total-tamung').html(formatOne(tamUng));
		//Con lai
		$('#total-amount-end_cl').html(formatOne(tong_congs-tamUng));
	}
	function actionTemp(){
		//Xóa
		$('.deleteItem').each(function(){ 
			$(this).on('click',function(){
				$(this).parent().parent().remove();
				var goodid = $(this).attr('id'); 
				$.ajax({
					url : controller + 'deleteTempData',
					type: 'POST',
					async: false,
					data: {goodid:goodid},
					success:function(datas){
						gooods(0,0,0,0,'delete');
					}
				}); 
				calInputTotal();
			});
		});
		//Update don gia 
		$('.priceone').each(function(idx){
			$(this).on('keyup',function(){
				var goodid = $(this).attr('goodid'); 
				setPrice(goodid);
				updateDataTemp(goodid);
			});
			$(this).on('change',function(){
				var goodid = $(this).attr('goodid'); 
				setPrice(goodid);
				updateDataTemp(goodid);
			});
			$(this).on('dblclick',function(){
				$(this).select();
			});
		});
		$('.quantity').each(function(idx){
			$(this).on('click',function(){
				var goodid = $(this).attr('goodid'); 
				$(this).select();
				setPrice(goodid);
				updateDataTemp(goodid);
			});
			$(this).on('keyup',function(){
				var goodid = $(this).attr('goodid'); 
				setPrice(goodid);
				updateDataTemp(goodid);
			});
			$(this).on('dblclick',function(){
				$(this).select();
			});
		});
		//VAT
		$('.vat').each(function(idx){
			$(this).on('keyup',function(){
				var goodid = $(this).attr('goodid'); 
				setPrice(goodid);
				updateDataTemp(goodid);
			});
			$(this).on('dblclick',function(){
				$(this).select();
			});
		});
		//Giam gia
		$('.discount').each(function(idx){
			$(this).on('keyup',function(){
				var goodid = $(this).attr('goodid'); 
				setPrice(goodid);
				updateDataTemp(goodid);
			});
			$(this).on('dblclick',function(){
				$(this).select();
			});
		});
		//Xuất khuyến mải
		$('.xuatkhuyenmai').each(function(idx){
			$(this).on('keyup',function(){
				var goodid = $(this).attr('goodid'); 
				setPrice(goodid);
				updateDataTemp(goodid);
			});
			$(this).on('dblclick',function(){
				$(this).select();
			});
		});
		$('.unitid').each(function(){ 
			$(this).on('change',function(){
				var goodid = $(this).attr('goodid'); 
				updateDataTemp(goodid);
			});
		});
	}
	function setPrice(goodid){
		var priceone = $('#priceone_'+goodid).val();
		var quantity = $('#quantity_'+goodid).val();
		var discount = $('#discount_'+goodid).val();
		//var vat = $('#vat_'+goodid).val();
		var xkm = $('#xkm_'+goodid).val();
		if (xkm == '') {
			xkm = '0';
		}
		xkm = parseFloat(xkm.replace(/[^0-9+\-Ee.]/g, ''));
		//priceone
		if (priceone == '') {
			priceone = '0';
		}
		priceone = parseFloat(priceone.replace(/[^0-9+\-Ee.]/g, ''));
		//quantity
		if (quantity == '') {
			quantity = ',0';
		}
		quantity = parseFloat(quantity.replace(/[^0-9+\-Ee.]/g, ''));
		
		//Tinh Tong
		var quantityEnd = quantity - xkm; //Giam gia sản phẩm thì trừ sản phẩm trước
		var priceEnd = quantityEnd * priceone; 
		//Tinh giảm giá
		var k = discount.split('%');
		var tinhtheo = 0;
		if(k.length > 1){
			tinhtheo = 1;
		}
		//discount
		if(discount == ''){
			discount = '0';
		}
		discount = discount.replace(/[^0-9+\-Ee.]/g, '');
		//Tinh theo %
		var giamGia = 0;
		if(tinhtheo == 1){
			giamGia = (priceEnd * discount)/100;
		}
		else{//Giam tiền
			giamGia = discount;
		}
		var priceEnds = priceEnd - giamGia;
		$('#price_'+goodid).val(formatOne(priceEnds));
		calInputTotal();
	}
	/*function calInputTotal2(){
		$('#prepay_1').prop('checked',true);
		percent = 0;
		var tongtienhang = $('.tongtienhang').html();
		var ttchietkhau = $('.ttchietkhau').html();
		if(ttchietkhau == ''){
			ttchietkhau = '0';
		}
		tongtienhang = parseFloat(tongtienhang.replace(/[^0-9+\-Ee.]/g, ''));
		ttchietkhau = parseFloat(ttchietkhau.replace(/[^0-9+\-Ee.]/g, ''));
		var thanhtoan = tongtienhang - ttchietkhau;
		var vat = '0';//$('#vat').val();
		vat = parseFloat(vat.replace(/[^0-9+\-Ee.]/g, ''));
		var tienvat = (vat * thanhtoan)/100;
		$('#input_total').val(formatOne(tienvat + thanhtoan));
		$('#price_prepay').val(formatOne(tienvat + thanhtoan));
		//Tinh con no
		var input_total = $('#input_total').val();
		input_total = parseFloat(input_total.replace(/[^0-9+\-Ee.]/g, ''));
		var price_prepay = $('#price_prepay').val();
		price_prepay = parseFloat(price_prepay.replace(/[^0-9+\-Ee.]/g, ''));
		$('#price_indebtedness').val(formatOne(input_total - price_prepay));
	}*/
	/*
	function calInputTotal3(){ 
		//Tinh con no
		var input_total = $('#input_total').val();
		input_total = parseFloat(input_total.replace(/[^0-9+\-Ee.]/g, ''));
		var price_prepay = $('#price_prepay').val();
		if(price_prepay == ''){
			price_prepay = '0';
		}
		price_prepay = parseFloat(price_prepay.replace(/[^0-9+\-Ee.]/g, ''));
		var type = parseInt($('input[name=prepay]:checked').val());
		var price_prepays = price_prepay;
		//console.log(price_prepay);
		if(type == 2){ //Pham tram
			price_prepays = (price_prepay * input_total) / 100;
		}
		if(price_prepays > input_total){
			$('#price_prepay').val(formatOne(input_total));
			$('#price_indebtedness').val(0);
		}
		else{
			$('#price_indebtedness').val(formatOne(input_total - price_prepays));
		}
	}*/
	function init(){
		/*$('#shelflife').change(function () {
			$('.shelflifes').val($('#shelflife').val());
		});*/
		/*$('#prepay_1').click(function(){//Tien 
			var inputTotal = $('#input_total').val();
			inputTotal = parseFloat(inputTotal.replace(/[^0-9+\-Ee.]/g, ''));
			var pricePrepay = $('#price_prepay').val();
			pricePrepay = parseFloat(pricePrepay.replace(/[^0-9+\-Ee.]/g, ''));
			if(percent == 0){
				$('#price_prepay').val(pricePrepay);
			}
			else{
				var perc = pricePrepay * inputTotal / 100;
				pricePrepay = formatOne(perc.toFixed(2));
				$('#price_prepay').val(pricePrepay);
				pricePrepay = parseFloat(pricePrepay.replace(/[^0-9+\-Ee.]/g, ''));
				$('#price_indebtedness').val(formatOne(inputTotal-pricePrepay));
			}
			percent = 0;
		});*/
		/*
		$('#prepay_2').click(function(){//Phan tram
			var inputTotal = $('#input_total').val();
			inputTotal = parseFloat(inputTotal.replace(/[^0-9+\-Ee.]/g, ''));
			var pricePrepay = $('#price_prepay').val();
			pricePrepay = parseFloat(pricePrepay.replace(/[^0-9+\-Ee.]/g, ''));
			if(percent == 1){
				$('#price_prepay').val(pricePrepay);
			}
			else{
				var perc = pricePrepay * 100 / inputTotal;
				pricePrepay = formatOne(perc.toFixed(2));
				$('#price_prepay').val(pricePrepay);
				var pricePrepay2 = pricePrepay * inputTotal / 100;
				pricePrepay = parseFloat(pricePrepay.replace(/[^0-9+\-Ee.]/g, ''));
				$('#price_indebtedness').val(formatOne(inputTotal-pricePrepay2));
			}
			percent = 1;
		});
		*/
		$( "#goodsid" ).keypress(function(e){
			if(e.keyCode == 13){ //dung may Scan
				var goods_code = $.trim($(this).val());
				if(goods_code == ''){
					return false;
				}			
				gooods(temp_goodsid,temp_goods_code,temp_stype,temp_exchangs,'');
			}
		});
		$( "#goodsid" ).click(function(){
			$(this).focus();
		});
		$( "#goodsid" ).dblclick(function(){
			$(this).select();
		});
		$( "#goodsid" ).autocomplete({
			//source: goodsList,
			source: function( request, response ) {
				$.ajax( {
					url: controller+"getFindGoods",
					dataType: "json",
					type: 'POST',
					async: false,
					data: {
						goodscode: request.term
					},
					success: function( data ) {
						response( data.length === 1 && data[ 0 ].length === 0 ? [] : data );
						if (data.length === 0){
							return false;
						}
						temp_goodsid = data[0].goodsid;
						temp_goods_code = data[0].goods_code;
						temp_stype = data[0].stype;
						temp_exchangs = data[0].exchangs;											
					}
				} );
			},
			select: function( event, ui ){ 
				event.preventDefault();
				$( "#goodsid" ).val( ui.item.label); //ui.item is your object from the array
				var goodsid = ui.item.value;
				var goods_code = ui.item.goods_code;
				gooods(goodsid,goods_code,ui.item.stype,ui.item.exchangs,'');
				return false;
			},
			focus: function(event, ui) {
				event.preventDefault();
				$("#goodsid").val(ui.item.label);
			}
		});
	}
	function viewImg(url) {
		$.fancybox({
			'width': 600,
			'height': 500,
			'autoSize' : false,
			'hideOnContentClick': true,
			'enableEscapeButton': true,
			'titleShow': true,
			'href': "#viewImg-form",
			'scrolling': 'no',
			'afterShow': function(){
				$('#viewImg-form-gridview').html('<img style="width:600px; height:500px;" src="'+url+'" />');
			}
		});
    }
    function refresh(){
		$('.loading').show();
		//$('.searchs').val('');		
		csrfHash = $('#token').val();
		//$('#customer_type').multipleSelect('setSelects',[1]);
		$('#quantity').val(1);
		//$('#payments').multipleSelect('setSelects',[1]);	
		$('.loading').hide();
	}
</script>
