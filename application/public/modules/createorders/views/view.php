<style title="" type="text/css">
	.col-md-4{ white-space: nowrap !important;}
	.col-md-3{ white-space: nowrap !important;}
</style>
<!-- BEGIN PORTLET-->
<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption mtop8">
			<b><i class="fa fa-pencil-square-o mleft10" style="margin-top:4px; font-size:15px;" aria-hidden="true"></i>
			<?=getLanguage('tao-bao-gia');?></b>
		</div>
		<div class="tools">
			<ul class="button-group pull-right mbottom10">
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
						Lưu và in
					</button>
				</li>-->
				<li id="viewPrint">
					<button class="button">
						<i class="fa fa-print"></i>
						<input type="hidden" id="unit" value="" />
						<?=getLanguage('in');?>
					</button>
				</li>
				<li>
					<a href= "<?=base_url();?>historyorder.html">
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
		<div class="row ">
			  <div class="col-md-7" style="width:70%; padding-left:10px; padding-right:10px;">
					<div class="row" style="margin-bottom:15px;">
						<div class="row">
							<div class="form-group col-md-12">
								<label  class="control-label col-md-2" style=";"><?=getLanguage('hang-hoa');?>(<span class="red">*</span>)</label>
								<div class="col-md-10">
									<input type="text" name="goodsid" id="goodsid" placeholder="" class="search form-control " />
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<table class="inputgoods">
							<thead>
								<tr class="thds">
									<td width="30" rowspan="2"><?=getLanguage('stt');?></td>
									<td rowspan="2" ><?=getLanguage('hang-hoa');?></td>
									<td width="75" rowspan="2"><?=getLanguage('dvt');?></td>
									<td width="85" rowspan="2"><?=getLanguage('so-luong');?></td>
									<td width="90" rowspan="2"><?=getLanguage('don-gia');?></td>
									<td width="150" colspan="2"><?=getLanguage('chiet-khau');?></td>
									<td width="100" rowspan="2"><?=getLanguage('thanh-tien');?></td>
									<td width="30" rowspan="2"></td>
								</tr>
								<tr class="thds">
								  <td ><?=configs()['currency'];?>/%</td>
								  <td ><?=getLanguage('san-pham');?></td>
								</tr>
							</thead>
							<tbody class="gridView"></tbody>
						</table>
					</div>
			  </div>
			  <div class="col-md-4" style="margin-left:1%; width:29%; border-left:1px dashed #c3cfd7;  margin-bottom:10px; padding-left:5px;">
					<div class="row">
						 <div class="col-md-11 bdb mleft12 tcler">
							<i class="fa fa-question-circle-o" aria-hidden="true"></i>
							<?=getLanguage('thong-tin-hoa-don');?>
						 </div>
					</div>
					<div class="row mtop10">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4"><?=getLanguage('ma-bao-gia');?> <?php if(!empty($setuppo)){?>(<span class="red">*</span>) <?php }?></label>
								<div class="col-md-8 ">
									<?php 
										$readonly = '';
										if(empty($setuppo)){
											$readonly = 'readonly';
										}
										else{
											if(!empty($poid)){
												$readonly = 'readonly';
											}
										}
									?>
									<input type="text" value="" name="poid" id="poid" <?=$readonly;?> class="form-control searchs"  />
								</div>
							</div>
						</div>
					</div>
					<div class="row mtop10">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4"><?=getLanguage('khach-hang');?> (<span class="red">*</span>)</label>
								<div class="col-md-7">
									<span id="loadCustomer">
										<select id="customerid" name="customerid" class="searchs select2me form-control" data-placeholder="<?=getLanguage('chon-khach-hang')?>">
											
											<option value=""></option>
											<?php foreach($customers as $item){?>
												<option value="<?=$item->id;?>"><?=$item->customer_name;?></option>
											<?php }?>
										</select>
									</span>
								</div>
								<div class="col-md-1" style="margin-left:-20px;">
									<a title="Thêm khách hàng" class="btn btn-sm btns" id="addSuppliers" data-toggle="modal" data-target="#myFrom" href="#">
										<i class="fa fa-plus" aria-hidden="true"></i>
									</a>
								</div>
							</div>
						</div>
					</div><!--E Row-->
					<div class="row mtop10">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4"><?=getLanguage('ngay-xuat');?></label>
								 <div class="col-md-8 date date-picker" data-date-format="<?=cfdateHtml();?>">
									<?php 
									$datecreate =  gmdate(cfdate(), time() + 7 * 3600);
									?>
									<input value="<?=$datecreate;?>" type="text" id="datecreate" placeholder="<?=cfdateHtml();?>" name="datecreate" class="form-control searchs " >
									<span class="input-group-btn ">
										<button class="btn default btn-picker" type="button"><i class="fa fa-calendar "></i></button>
									</span>
								</div>
							</div>
						</div>
					</div><!--E Row-->
					<div class="row mtop10">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4"><?=getLanguage('ngay-giao');?></label>
								 <div class="col-md-8 date date-picker" data-date-format="<?=cfdateHtml();?>">
									<input value="<?=$datecreate;?>" type="text" id="deliverydate" placeholder="<?=cfdateHtml();?>" name="deliverydate" class="form-control searchs " >
									<span class="input-group-btn ">
										<button class="btn default btn-picker" type="button"><i class="fa fa-calendar "></i></button>
									</span>
								</div>
							</div>
						</div>
					</div><!--E Row-->
					<div class="row mtop10">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4"><?=getLanguage('dia-diem-giao');?></label>
								<div class="col-md-8 ">
									<input type="text" name="place_of_delivery" id="place_of_delivery" placeholder="Địa điểm giao hàng" value="" class="searchs form-control " maxlength="100" />
								</div>
							</div>
						</div>
					</div>
					<div class="row mtop10">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4"><?=getLanguage('ghi-chu');?></label>
								<div class="col-md-8 ">
									<input maxlength="250" type="text" name="description" id="description" placeholder="" value="" class="searchs form-control " />
								</div>
							</div>
						</div>
					</div><!--E Row-->
					<div class="row mtop10">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4"><?=getLanguage('nv-ban-hang');?></label>
								<div class="col-md-8 ">
										<select id="employeeid" name="employeeid" class="searchs select2me form-control" data-placeholder="<?=getLanguage('chon-nhan-vien')?>">
											<option value=""></option>
											<?php
											foreach($employeesale as $item){?>
												<option 
												value="<?=$item->id;?>"><?=$item->employee_code;?> - <?=$item->employee_name;?></option>
											<?php }?>
										</select>
								</div>
							</div>
						</div>
					</div><!--E Row-->
					<div class="row mtop10">
						 <div class="col-md-11 bdb mleft12 tcler">
							<i class="fa fa-usd" aria-hidden="true"></i>
								<?=getLanguage('thong-tin-thanh-toan');?>
						 </div>
					</div>
					<div class="row mtop10">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4"><?=getLanguage('tong');?></label>
								<div class="col-md-8 ">
									<input type="text" name="total-amount" id="total-amount" readonly placeholder="" class="searchs form-control text-right fm-number" />
								</div>
							</div>
						</div>
					</div><!--E Row-->
					<div class="row mtop10">
						<div class="col-md-12">
							<div class="form-group">
								<div class="col-md-4">
									<label class="control-label"><?=getLanguage('giam-gia');?></label>
								</div>
								<div class="col-md-8 ">
									<div class="col-md-6" style="padding:0 !important; ">
										<input style="font-size:12px;" type="text" name="discount" id="discount" placeholder="" class="searchs form-control text-right fm-number" value="" />
									</div>
									<div class="col-md-6" style="padding:0 !important;">
										<select class="form-control select2me" id="input_discount_type" name="input_discount_type" >
											<option value="1"><?=configs()['currency'];?></option>
											<option value="2">%</option>
										</select>
										<input type="hidden" name="total-discount" id="total-discount"/>
									</div>
								</div>
							</div>
						</div>
					</div><!--E Row-->
					<div class="row mtop10">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4"><?=getLanguage('dieu-chinh');?></label>
								<div class="col-md-8 ">
									<input type="text" name="adjustment" id="adjustment" class="searchs form-control text-right" />
									<input type="hidden" name="total-adjustment" id="total-adjustment"  />
								</div>
							</div>
						</div>
					</div><!--E Row-->
					<div class="row mtop10">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4"><?=getLanguage('vat');?>(%)</label>
								<div class="col-md-8 ">
									<div class="col-md-6" style="padding:0 !important; ">
										<input maxlength="3" type="text" name="vat" id="vat" placeholder="" class="searchs form-control text-right fm-number " />
									</div>
									<div class="col-md-6" style="padding:0 !important;">
										<input type="text" name="total-vat" id="total-vat" placeholder="" readonly class="searchs form-control text-right fm-number " />
									</div>
								</div>
							</div>
						</div>
					</div><!--E Row-->
					<div class="row mtop10" style="display:none;">
						<div class="col-md-12">
							<div class="form-group">
								<div class="col-md-4">
									<label class="control-label"><?=getLanguage('thanh-toan');?></label>
								</div>
								<div class="col-md-8 ">
									<div class="col-md-6" style="padding:0 !important; ">
										<input style="font-size:12px;" type="text" name="price_prepay" id="price_prepay" placeholder="" class="searchs form-control text-right fm-number" value="" />
									</div>
									<div class="col-md-6" style="padding:0 !important;">
										<select class="form-control select2me" id="price_prepay_type" name="price_prepay_type" >
											<option value="1"><?=configs()['currency'];?></option>
											<option value="2">%</option>
										</select>
										<input type="hidden" name="total-tamung" id="total-tamung" />
									</div> 
								</div>
							</div>
						</div>
					</div><!--E Row total-tamung-->
					<div class="row mtop10" style="display:none;">
						<div class="col-md-12">
							<div class="form-group">
								<label title="<?=getLanguage('ht-thanh-toan');?>" class="control-label col-md-4"><?=getLanguage('ht-thanh-toan');?></label>
								<div class="col-md-8 ">
									<select id="payments" name="payments" class="searchs select2me form-control" >
										<option  value="1"><?=getLanguage('tien-mat');?></option>
										<option  value="2"><?=getLanguage('chuyen-khoan');?></option>
									</select>
								</div>
							</div>
						</div>
					</div><!--E Row-->
					<!--S Ngan hang-->
					<div class="row mtop10" style="display:none;">
						<div class="col-md-12">
							<div class="form-group">
								<label title="<?=getLanguage('ngan-hang');?>" class="control-label col-md-4"><?=getLanguage('ngan-hang');?></label>
								<div class="col-md-8 ">
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
					<!--E ngan hang-->
					<div class="row mtop10 mbottom10">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4"><?=getLanguage('tong-cong');?></label>
								<div class="col-md-8 ">
									<input type="text" name="total-amount-end" id="total-amount-end" readonly placeholder="" class="searchs form-control text-right fm-number" readonly />
								</div>
							</div>
						</div>
					</div><!--E Row-->
					<div class="row mtop10 mbottom10" style="display:none;">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4"><?=getLanguage('con-no');?></label>
								<div class="col-md-8 ">
									<input type="text" name="total-amount-end_cl" id="total-amount-end_cl" readonly placeholder="" class="searchs form-control text-right fm-number" />
								</div>
							</div>
						</div>
					</div><!--E Row-->
				</div>
		</div>
	</div>
	<div class="portlet-title">
		<div class="caption mtop8"></div>
		<div class="tools">
			<ul class="button-group pull-right mbottom10">
				<!--<li id="refresh" >
					<button class="button">
						<i class="fa fa-refresh"></i>
						<?=getLanguage('all','refresh')?>
					</button>
				</li>-->
				<?php if(isset($permission['add'])){?>
				<li id="save2">
					<button class="button save-input">
						<i class="fa fa-save"></i>
						<?=getLanguage('luu');?>
					</button>
				</li>
				<?php } ?>
				<!--<li id="print2">
					<button class="button">
						<i class="fa fa-print"></i>
						Lưu và in
					</button>
				</li>-->
				<li id="viewPrint2">
					<button class="button">
						<i class="fa fa-print"></i>
						<?=getLanguage('in');?>
					</button>
				</li>
				<li>
					<a href= "<?=base_url();?>historyorder.html">
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
	<div class="blockUI blockOverlay" style="width: 100%;height: 100%;top:0px;left:0px;position: absolute;background-color: rgb(0,0,0);opacity: 0.1;z-index: 1000;">
	</div>
	<div class="blockUI blockMsg blockElement" style="width: 30%;position: absolute;top: 15%;left:35%;text-align: center;">
		<img src="<?=url_tmpl()?>img/ajax_loader.gif" style="z-index: 2;position: absolute;"/>
	</div>
</div> 

 <!-- Modal -->
<div class="modal fade" id="myFrom" role="dialog">
	<div class="modal-dialog">
	  <!-- Modal content-->
	  <div class="modal-content">
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
		  <h4 class="modal-title"><i class="fa fa-plus" aria-hidden="true"></i> <?=getLanguage('them-khach-hang');?></h4>
		</div>
		<div class="modal-body">
			<!--Content-->
		</div>
		<div class="modal-footer">
		  <button type="button" id="addSups" class="btn btn-default"><?=getLanguage('luu');?></button>
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
<!-- view Img -->
<!--E My form-->
<link href="<?=url_tmpl();?>css/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src="<?=url_tmpl();?>js/jquery-ui.js" type="text/javascript"></script>
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
<input id="uniqueid" name="uniqueid" type="hidden" />
<input id="uniqueidnew" name="uniqueidnew" value="<?=$uniqueid;?>" type="hidden" />
<script type="text/javascript" src="<?=url_tmpl();?>fancybox/source/jquery.fancybox.pack.js"></script>  
<link href="<?=url_tmpl();?>fancybox/source/jquery.fancybox.css" rel="stylesheet" />
<script>
	var controller = '<?=base_url().$routes;?>/';
	var csrfHash = '<?=$csrfHash;?>';
	var goodsList = '';
	var orderList = JSON.parse('<?=json_encode($odersList);?>');;
	var inputList = {};
	var cpage = 0;
	var search;
	var percent = 0;
	$(function(){
		$('#vat').val('');
		handleSelect2();
		init();
		gridView();
		refresh();
		ComponentsPickers.init();
		formatNumberKeyUp('fm-number');
		formatNumber('fm-number');
		var isorder = 0;
		var type = 1;
		$('.dateOneGuarantee').datepicker().on('changeDate', function (ev) {
			var goodid = $(this).attr('goodid');
			var guarantee = $('#guarantee_'+goodid).val();
			$.ajax({
				url : controller + 'updateGuarantee',
				type: 'POST',
				async: false,
				data: {goodid:goodid,guarantee:guarantee},
				success:function(datas){}
			});
			$('.datepicker').hide();
		});
		$('.selectAllGuarantee').datepicker().on('changeDate', function (ev){
			var guarantee = $('#guarantee').val();
			$('.guarantees').val(guarantee);
			$.ajax({
				url : controller + 'updateAllGuarantee ',
				type: 'POST',
				async: false,
				data: {guarantee:guarantee},
				success:function(datas){}
			});
			$('.datepicker').hide();
		});
		$('#refresh').click(function(){
			$('.loading').show();
			refresh();
		});
		$('#vat').keyup(function(e){
			 calInputTotal();
		});
		$('.closeModal').click(function(){
			gooods(0,0,0,0,'refresh'); 
			//$('.close').click();
		});
		$('.closeTop').click(function(){
			gooods(0,0,0,0,'refresh'); 
		});
		//S Them nha cung cap
		$('#addSuppliers').click(function(){
			$.ajax({
				url : controller + 'addCustomer',
				type: 'POST',
				async: false,
				data: {id:''},
				success:function(datas){
					var obj = $.evalJSON(datas); 
					$('.modal-body').html(obj.content);
					
				}
			});
		});
		$('#addSups').click(function(){
			var _a_customer_code = $('#_a_customer_code').val();
			if(_a_customer_code == ''){
				$('#_a_customer_code').focus();
				warning('Mã khách hàng không được trống'); return false;
			}
			var _a_customer_name = $('#_a_customer_name').val();
			if(_a_customer_name == ''){
				$('#_a_customer_name').focus();
				warning('Tên khách hàng không được trống'); return false;
			}
			 var sups = getAddSupplier();
			 $.ajax({
				url : controller + 'saveCustomer',
				type: 'POST',
				async: false,
				data: {search:sups},
				success:function(datas){
					var obj = $.evalJSON(datas);
					if(obj.status == -1){
						error('Khách hàng đã tồn tại.'); return false;
					}
					else{
						$('#loadCustomer').html(obj.customer);
						
						$('.close').click();
					}
				},
				error : function(){
					error('Thêm khách hàng không thành công.'); return false;
				}
			});
		});
		$('#print').click(function(){
			var id = getCheckedId();//$('#id').val();
			print(id);
		});
		$('#addGoodsList').click(function(){ 
			return false;
		});
		$('#save').click(function(){
			save('save','');
		});
		$('#save2').click(function(){
			save('save',0);
		});
		$('#print').click(function(){
			save('save','print');
		});
		$('#print2').click(function(){
			save('save','print');
		});
		$('#viewPrint').click(function(){
			var unit = $('#unit').val();
			printSave(0,unit);
		});
		$('#viewPrint2').click(function(){
			var unit = $('#unit').val();
			printSave(0,unit);
		});
		$("input[name='isorder']" ).click(function(){
			var type = $(this).val();
			inputList = {};
			isorderType(type);
		});
		$('#viewPrintHDBH2,#viewPrintHDBH').click(function(){
			viewPrintHDBH();
		});
		/*$('#viewPrintHDBH3,#viewPrintHDBH3s').click(function(){
			viewPrintHDBHVAT();
		});*/
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
	function gridView(){ 
		$.ajax({
			url : controller + 'loadDataTempAdd',
			type: 'POST',
			async: false,
			data: {isnew:0},
			success:function(datas){
				var obj = $.evalJSON(datas);
				$('.gridView').html(obj.content);
				formatNumberKeyUp('fm-number');
				formatNumber('fm-number');				
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
	function getAddWarehouse(){
		var str = '';
		$('input.sup_txt2').each(function(){
			str += ',"'+ $(this).attr('id') +'":"'+ $(this).val().trim() +'"';
		});
		$('select.sup_combo2').each(function(){
			str += ',"'+ $(this).attr('id') +'":"'+ getCombo($(this).attr('id')) +'"';
		});
		return '{'+ str.substr(1) +'}';
	}
	function save(func,id){ 
		var itemList = getTemIDs(); 
		var customerid = $('#customerid').val();
		if(itemList == '' || itemList == '{}'){
			warning("<?=getLanguage('hang-hoa-khong-duong-trong');?>"); return false;	
		}
		if(customerid == ''){
			warning("<?=getLanguage('chon-khach-hang');?>"); return false;
		}
		var datecreate = $('#datecreate').val();
		var deliverydate = $('#deliverydate').val();
		var description = $('#description').val();
		var place_of_delivery = $('#place_of_delivery').val();
		var employeeid = $('#employeeid').val();
		
		var discount = $('#discount').val();
		var input_discount_type = $('#input_discount_type').val();
		var adjustment = $('#adjustment').val();
		var price_prepay = $('#price_prepay').val();
		var price_prepay_type = $('#price_prepay_type').val();
		var vat = $('#vat').val();
		var objReqest = {};
		objReqest['description'] = description;
		objReqest['customerid'] = customerid;
		objReqest['datecreate'] = datecreate;
		objReqest['deliverydate'] = deliverydate;
		objReqest['place_of_delivery'] = place_of_delivery;
		objReqest['employeeid'] = employeeid;
		
		//tong_so_luong
		objReqest['discount'] = discount;
		objReqest['adjustment'] = adjustment;
		objReqest['discount_type'] = input_discount_type;
		objReqest['price_prepay'] = price_prepay;
		objReqest['price_prepay_type'] = price_prepay_type;
		objReqest['total_discount'] = $('#total-discount').val();
		objReqest['total_adjustment'] = $('#total-adjustment').val();
		objReqest['total_tamung'] = $('#total-tamung').val();
		objReqest['total_tongcong'] = $('#total-amount-end').val();
		objReqest['total_amount'] = $('#total-amount').val(); 
		objReqest['payments'] = $('#payments').val();
		objReqest['tong_so_luong'] = $('#tong_so_luong').html(); 
		objReqest['tong_ck_soluong'] = $('#tong_ck_soluong').val(); 
		objReqest['bankid'] = $('#bankid').val();
		objReqest['vat'] = $('#vat').val();
		objReqest['vat_value'] = $('#total-vat').val();
		var search =  JSON.stringify(objReqest); 
		$(".loading").show();
		$.ajax({
			url : controller + func,
			type: 'POST',
			async: false,
			data: {itemList:itemList,search:search},
			success:function(datas){
				var obj = $.evalJSON(datas);  //return false;
				$(".loading").hide();
				if(obj.status == 0){
					error(obj.msg); return false;	
				}
				else{
					$('#unit').val(obj.status);
					$('#poid').val(obj.poid);
					$('.gridView').html('');
					//inputList = {};
					$('#uniqueidnew').val(obj.uniqueidnew);
					$('#uniqueid').val(obj.status);
					success("<?=getLanguage('tao-bao-gia-khong-thanh-cong');?> "+ obj.poid);
				}
			},
			error : function(){
				$(".loading").hide();
				error("<?=getLanguage('tao-bao-gia-khong-thanh-cong');?>"); return false;
			}
		});
	}
	function printSave(id,unit){
		var token = $('#token').val();
		$.ajax({
			url : controller + 'getDataPrintPX?unit='+unit,
			type: 'POST',
			async: false,
			data: {csrf_stock_name:token,id:id},
			success:function(datas){
				var object = $.evalJSON(datas); 
				var disp_setting = "toolbar=yes,location=yes,directories=yes,menubar=no,";
			disp_setting += "scrollbars=yes,width=900, height=500, left=0.0, top=0.0";
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
	function gooods(goodsid,code,stype,exchangs,deletes){ 
	    var vat = $('.valtotal').val();
		var uniqueid = $('#uniqueidnew').val();
		$.ajax({
			url : controller + 'getGoods',
			type: 'POST',
			async: false,
			data: {vat:vat,id:goodsid,code:code,stype:stype,exchangs:exchangs,deletes:deletes,isnew:0,uniqueid:uniqueid},
			success:function(datas){
				var obj = $.evalJSON(datas); 
				
				if(obj.status == 0){
					error('Hàng hóa không tồn tại trong hệ thống'); return false;
				}
				$('.gridView').html(obj.content); //Add Grid view
				//$('.ttprice').html(obj.totalPrice);
				$('#uniqueid').val(obj.uniqueid);
				percent = 0; //gan gia tri tien = 0
				$('#vat').val('');
				$('#prepay_1').prop('checked', true);
				$('#price_indebtedness').val('');
				$('#goodsid').val('');
				formatNumberKeyUp('fm-number');
				formatNumber('fm-number');
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
		/*$('.tgrid').each(function(){
			$(this).click(function(){ 
				 var url = $(this).attr('url');
				 //viewImg(url);
				var htmlImg = '<img id="clickViewImg" alt="Hình ảnh" style ="width:80px; height:85px; padding:5px 0;" src= '+url+' />';
				$('#viewImg').html(htmlImg);
				$('#goodsid').val('');
				//$('#goodsid').focus();
				$('#clickViewImg').click(function(){
					 var url = $(this).attr('src');
					 viewImg(url);
				});
			});
		});*/
	}
	function setDefault(){
		var warehouseDefault = 0;
		var datecreate = '<?=gmdate(cfdate(), time() + 7 * 3600);?>'; 
		$('#poid').val('');
		$('#description').val('');
		$('#datecreate').val(datecreate);
		$('#deliverydate').val(datecreate);
	}
	function updateDataTemp(goodid){
		var priceone = $('#priceone_'+goodid).val();
		var quantity = $('#quantity_'+goodid).val();
		var discount = $('#discount_'+goodid).val();
		var xkm = $('#xkm_'+goodid).val();
		var unitid = $('#unitid_'+goodid).val();
		//var discount_types = $('#discount_'+goodid).attr('discount_types');
		$.ajax({
			url : controller + 'updatePriceOne',
			type: 'POST',
			async: true,
			data: {goodid:goodid, priceone:priceone,quantity:quantity,discount:discount,xkm:xkm,isnew:0,unitid:unitid},
			success:function(datas){
				var object = $.evalJSON(datas); 
			}
		}); 
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
		//DVT
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
		//console.log(priceEnds);
		$('#price_'+goodid).val(formatOne(priceEnds));
		calInputTotal();
	}
	function calInputTotal(){
		var t_quantity = 0;
		$('.quantity').each(function(){
			var quantity = $(this).val();
			if (quantity == '') {
				quantity = '0';
			}
			quantity = parseFloat(quantity.replace(/[^0-9+\-Ee.]/g, ''));
			t_quantity+= quantity;
		});
		//console.log(t_quantity);
		$('#tong_so_luong').html(formatOne(t_quantity)); //tong_so_luong
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
		$('#total-amount').val(formatOne(t_buyprice));
		//Giam giá total-amount
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
		$('#total-discount').val(formatOne(giamGia));
		//console.log('dieu chinh: '+giamGia);
		//Giam gia 
		var adjustment = $('#adjustment').val();
		if (adjustment == '') {
			adjustment = '0';
		}
		adjustment = parseFloat(adjustment.replace(/[^0-9+\-Ee.]/g, ''));
		$('#total-adjustment').val(formatOne(adjustment));
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
		$('#total-vat').val(formatOne(totalVat));
		
		var tong_congs = tong_cong + totalVat;
		$('#total-amount-end').val(formatOne(tong_congs));
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
		$('#total-tamung').val(formatOne(tamUng));
		//Con lai
		$('#total-amount-end_cl').val(formatOne(tong_congs-tamUng));
	}
	/*function calInputTotal2(){
		var tongtienhang = $('.tongtienhang').html();
		var ttchietkhau = $('.ttchietkhau').html();
		if(ttchietkhau == ''){
			ttchietkhau = '0';
		}
		tongtienhang = parseFloat(tongtienhang.replace(/[^0-9+\-Ee.]/g, ''));
		ttchietkhau = parseFloat(ttchietkhau.replace(/[^0-9+\-Ee.]/g, ''));
		var thanhtoan = tongtienhang - ttchietkhau;
		var vat = $('#vat').val();
		if(vat == ''){
			vat = '0';
		}
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
	}
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
	/*
	function updateSerial(goodid,serial_number){
		$.ajax({
			url : controller + 'updateSerial',
			type: 'POST',
			async: false,
			data: {goodid:goodid, serial_number:serial_number,isnew:0},
			success:function(datas){}
		}); 
		//calInputTotal();
	}*/
	function init(){
		$('#prepay_1').prop('checked', true);
		$('#shelflife').change(function () {
			$('.shelflifes').val($('#shelflife').val());
		});
		$('#prepay_1').click(function(){//Tien 
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
		});
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
	function print(id){
		if(id == ''){ return false;}
		var token = $('#token').val();
		$.ajax({
			url : controller + 'getDataPrint',
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
		$('#quantity').val(1);
		$('.loading').hide();
	}
</script>

