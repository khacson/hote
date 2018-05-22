<style title="" type="text/css">
	.col-md-4{ white-space: nowrap !important;}
	.col-md-3{ white-space: nowrap !important;}
</style>
<!-- BEGIN PORTLET-->
<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption mtop8">
			<b><i class="fa fa-pencil-square-o mleft10" style="margin-top:4px; font-size:15px;" aria-hidden="true"></i>
			Sửa phiếu nhập kho</b>
		</div>
		<div class="tools">
			<ul class="button-group pull-right mbottom10">
				<li id="refresh" >
					<button class="button">
						<i class="fa fa-refresh"></i>
						<?=getLanguage('all','refresh')?>
					</button>
				</li>
				<?php if(isset($permission['add'])){?>
				<li id="save">
					<button class="button save-input">
						<i class="fa fa-save"></i>
						Lưu
					</button>
				</li>
				<?php } ?>
				<li id="print">
					<button class="button">
						<i class="fa fa-print"></i>
						Lưu và in
					</button>
				</li>
				<li id="viewprint">
					<button class="button">
						<i class="fa fa-print"></i>
						In
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
							Lịch sử
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
							<div class="form-group">
								<label  class="control-label col-md-2" style="padding-left:30px;">Hàng hóa(<span class="red">*</span>)</label>
								<div class="col-md-10" style="padding-left:0; margin-left:-3px;">
									<input type="text" name="goodsid" id="goodsid" placeholder="" class="search form-control tab-event" />
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<table class="inputgoods">
							<thead>
								<tr class="thds">
									<td width="30" rowspan="2">STT</td>
									<td rowspan="2" >Hàng hóa</td>
									<td width="75" rowspan="2">Đơn vị</td>
									<td width="85" rowspan="2">Số lương</td>
									<td width="90" rowspan="2">Đơn giá</td>
									<td width="100" rowspan="2">Thành tiền</td>
									<td width="150" colspan="2">Chiết khấu</td>
									<td width="30" rowspan="2"></td>
								</tr>
								<tr class="thds">
								  <td >Tiền/%</td>
								  <td >Sản phẩm</td>
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
							Thông tin hóa đơn
						 </div>
					</div>
					<div class="row mtop10">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4">Mã đơn hàng <?php if(!empty($setuppo)){?>(<span class="red">*</span>) <?php }?></label>
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
									<input type="text" value="<?=$finds->poid;?>" name="poid" id="poid" <?=$readonly;?> class="form-control searchs"  />
								</div>
							</div>
						</div>
					</div>
					<div class="row mtop10">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4">Nhà CC(<span class="red">*</span>)</label>
								<div class="col-md-7">
									<span id="loadSupplier">
										<select id="supplierid" name="supplierid" class="combos" >
											<option value=""></option>
											<?php foreach($suppliers as $item){?>
												<option value="<?=$item->id;?>"><?=$item->supplier_name;?></option>
											<?php }?>
										</select>
									</span>
								</div>
								<div class="col-md-1" style="margin-left:-20px;">
									<a data-placement="left" title="Thêm mới nhà cung cấp" class="btn btn-sm btns" id="addSuppliers" data-toggle="modal" data-target="#myFrom" href="#">
										<i class="fa fa-plus" aria-hidden="true"></i>
									</a>
								</div>
							</div>
						</div>
					</div><!--E Row-->
					<div class="row mtop10">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4">Ngày nhập ĐH</label>
								 <div class="col-md-8 input-group date date-picker" data-date-format="<?=cfdateHtml();?>">
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
					</div><!--E Row-->
					<div class="row mtop10">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4">Ghi chú</label>
								<div class="col-md-8 ">
									<input type="text" name="description" id="description" placeholder="" value="" class="searchs form-control tab-event" maxlength="250"/>
								</div>
							</div>
						</div>
					</div><!--E Row-->
					<div class="row mtop10" style="display:none;">
						 <div class="col-md-11 bdb mleft12 tcler">
							<i class="fa fa-question-circle-o" aria-hidden="true"></i>
							Thông tin Nhập kho
						 </div>
					</div>
					<div class="row mtop10" style="display:none;">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4">Kho nhập</label>
								<div class="col-md-8 ">
									<span id="loadWarehouse">
										<!--<select id="warehouseid" name="warehouseid" class="combos" >
											<option value=""></option>
											<?php
											$selected = '';
											$warehouseDefault = 0;
											if(count($warehouses) == 1){
												$selected = 'selected';
												$warehouseDefault = $warehouses[0]->id;
											}
											foreach($warehouses as $item){?>
												<option <?=$selected;?>
												value="<?=$item->id;?>"><?=$item->warehouse_name;?></option>
											<?php }?>
										</select>-->
									</span>
								</div>
							</div>
						</div>
					</div><!--E Row-->
					<div class="row mtop10">
						 <div class="col-md-11 bdb mleft12 tcler">
							<i class="fa fa-usd" aria-hidden="true"></i>
								Thông tin thanh toán
						 </div>
					</div>
					<div class="row mtop10">
						<div class="col-md-12">
							<div class="form-group">
								<label title="Hình thức thanh toán" class="control-label col-md-4">HT thanh toán</label>
								<div class="col-md-8 ">
									<div class="col-md-4 pleft0">
										<label class="control-label">
										<input checked type="radio" id="payments_1" name="payments" value="1"  />
										Tiền mặt</label>
									</div>
									<div class="col-md-4">
										<label class="control-label">
										<input type="radio"  id="payments_2" name="payments" value="2"  />
										CK</label>
									</div>
									<div class="col-md-4">
										<label class="control-label">
										<input type="radio"  id="payments_3" name="payments" value="3"  />
										Thẻ</label>
									</div>
								</div>
							</div>
						</div>
					</div><!--E Row-->
					
					<div class="row mtop10">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4">Tổng tiền</label>
								<div class="col-md-8 ">
									<input type="text" name="input_total" id="input_total" readonly placeholder="" class="searchs form-control text-right fm-number" />
								</div>
							</div>
						</div>
					</div><!--E Row-->
					<!--<div class="row mtop10">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4">VAT(%)</label>
								<div class="col-md-8 ">
									<input maxlength="3" type="text" name="vat" id="vat" placeholder="" class="searchs valtotal form-control text-right fm-number tab-event" />
								</div>
							</div>
						</div>
					</div><!--E Row-->
					<div class="row mtop10">
						<div class="col-md-12">
							<div class="form-group">
								<div class="col-md-4">
									<label class="control-label">Tạm ứng</label>
								</div>
								<div class="col-md-8 ">
									<div class="col-md-6" style="padding:0 !important;">
										<label class="control-label">
											<input type="radio" id="prepay_1" name="prepay" value="1"  />
											Tiền</label>
										<label class="control-label" style="margin-left:10px;">
											<input  type="radio" id="prepay_2" name="prepay" value="2"  />
											%</label>
									</div>
									<div class="col-md-6" style="padding:0 !important; ">
										<input checked style="font-size:12px;" type="text" name="price_prepay" id="price_prepay" placeholder="" class="searchs form-control text-right fm-number" value="" />
									</div>
								</div>
							</div>
						</div>
					</div><!--E Row-->
					<div class="row mtop10 mbottom10">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4">Còn nợ</label>
								<div class="col-md-8 ">
									<input type="text" name="price_indebtedness" id="price_indebtedness" readonly placeholder="" class="searchs form-control text-right fm-number" />
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
				<li id="refresh2" >
					<button class="button">
						<i class="fa fa-refresh"></i>
						<?=getLanguage('all','refresh')?>
					</button>
				</li>
				<?php if(isset($permission['add'])){?>
				<li id="save2">
					<button class="button save-input">
						<i class="fa fa-save"></i>
						Lưu
					</button>
				</li>
				<?php } ?>
				<li id="print2">
					<button class="button">
						<i class="fa fa-print"></i>
						Lưu và in
					</button>
				</li>
				<li id="viewprint2">
					<button class="button">
						<i class="fa fa-print"></i>
						In
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
							Lịch sử
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
<!--S My form-->
<!-- Modal -->
<div class="modal fade" id="myFrom" role="dialog">
	<div class="modal-dialog">
	  <!-- Modal content-->
	  <div class="modal-content">
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
		  <h4 class="modal-title"><i class="fa fa-plus" aria-hidden="true"></i> Thêm mới nhà cung cấp</h4>
		</div>
		<div class="modal-bodys">
			<!--Content-->
		</div>
		<div class="modal-footer">
		  <button type="button" id="addSups" class="btn btn-default">Lưu</button>
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
<input id="uniqueid" name="uniqueid" type="hidden" />
<link href="<?=url_tmpl();?>css/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src="<?=url_tmpl();?>js/jquery-ui.js" type="text/javascript"></script>
<script type="text/javascript" src="<?=url_tmpl();?>fancybox/source/jquery.fancybox.pack.js"></script>  
<link href="<?=url_tmpl();?>fancybox/source/jquery.fancybox.css" rel="stylesheet" />

<script>
	var controller = '<?=base_url().$routes;?>/';
	var csrfHash = '<?=$csrfHash;?>';
	var goodsList = '';
	var orderList = '';//
	var inputList = {};
	var cpage = 0;
	var search;
	var percent = 0;
	$(function(){
		$('#vat').val('');
		init();
		gridView(1);
		refresh();
		formatNumberKeyUp('fm-number');
		formatNumber('fm-number');
		var isorder = 0;
		var type = 1;
		/*$('.dateOneGuarantee').datepicker().on('changeDate', function (ev) {
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
		});*/
		/*$('.selectAllGuarantee').datepicker().on('changeDate', function (ev){
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
		});*/
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
						error('Nhà cung cấp đã tồn tại.'); return false;
					}
					else{
						$('#loadSupplier').html(obj.suppliers);
						$('#supplierid').multipleSelect({
							filter: true,
							placeholder:'Chọn nhà cung cấp',
							single: true
						});
						success('Thêm nhà cung cấp thành công.'); 
						$('.close').click();
					}
				},
				error : function(){
					error('Thêm nhà cung cấp không thành công.'); return false;
				}
			});
		});
		//Them  moi kho hang
		/*$('#addWarehouse').click(function(){
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
		});*/
		$('#save2').click(function(){
			save('edit',0);
		});
		$('#save').click(function(){
			save('edit',0);
		});
		$('#print').click(function(){
			save('edit','print');
		});
		$('#print2').click(function(){
			save('edit','print');
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
		$('#price_prepay').keyup(function(e){
			 calInputTotal3();
		});
		clickViewImg();
		actionTemp();
		setDefault();
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
				tabControl();				
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
		search = getSearch();
		var obj = $.evalJSON(search);
		var quantity = {};
		$('.quantity').each(function(e){
			var goodid = $(this).attr('goodid');
			var val = $(this).val();
			quantity[goodid] = val;
		});
		if(JSON.stringify(quantity) == '{}'){
			warning('Hàng hóa <?=getLanguage('all','empty')?>'); return false;	
		}
		if(obj.supplierid == ''){
			warning('Chọn nhà cung cấp'); return false;
		}
		var setuppo = parseFloat('<?=$setuppo;?>');
		if(obj.poid == '' && setuppo == 1){
			$('#poid').focus();
			warning('Mã đơn hàng <?=getLanguage('all','empty')?>'); return false;
		}
		//E don gia
		if(obj.customerid == ''&& checkCus == 1){
			warning('Khách hàng <?=getLanguage('all','empty')?>'); return false;	
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
		//var place_of_delivery = $('#place_of_delivery').val();
		$.ajax({
			url : controller + func,
			type: 'POST',
			async: false,
			data: {csrf_stock_name:token,search:JSON.stringify(obj),description:description,orderid:'<?=$id;?>', price_prepay:price_prepay,payments:payments,prepay:prepay},
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
						success('Nhập kho thành công.');
					}
					else{
						$('#unit').val(obj.status);
						$('#poid').val(obj.poid);
						$('.gridView').html('');
						success('Nhập kho thành công.');
						$('#uniqueidnew').val(obj.uniqueidnew);
						$('#uniqueid').val(obj.status);
						//inputList = {};
						print(0,obj.status);
					}
				}
			},
			error : function(){
				$(".loading").hide();
				error('Nhập kho không thành công.'); return false;
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
			data: {vat:vat,xkm:xkm, id:goodsid,code:code,stype:stype,exchangs:exchangs,deletes:deletes,isnew:1,uniqueid:uniqueid},
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
		var warehouseDefault = '<?=$warehouseDefault;?>';
		var poid = '<?=$finds->poid;?>';
		var supplierid = '<?=$finds->supplierid;?>';
		var payments = '<?=$finds->payments;?>';
		$("#payments_1,#payments_2,#payments_3").prop( "checked", false );
		$('#poid').val(poid);
		$('#supplierid').multipleSelect('setSelects',[supplierid]);
		$('#datecreate').val('<?=$finds->datepo;?>');
		$('#description').val('<?=$finds->description;?>');
		$("#payments_"+payments).prop( "checked", true );
		
		//$('#customer_phone').val('');
		//$('#customer_address').val('');
		//$('#customer_email').val('');
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
		var xkm = $('#xkm_'+goodid).val();
		//var discount_types = $('#discount_'+goodid).attr('discount_types');
		$.ajax({
			url : controller + 'updatePriceOne',
			type: 'POST',
			//async: false,
			data: {goodid:goodid, priceone:priceone,quantity:quantity,discount:discount,xkm:xkm,isnew:1},
			success:function(datas){
				var object = $.evalJSON(datas); 
				$('.tongtienhang').html(object.price);
				$('.ttchietkhau').html(object.discount);
				$('#input_total').val(object.priceEnd);
				$('#price_prepay').val(object.priceEnd);
				$('#prepay_1').prop('checked',true);
				$('#price_indebtedness').val(0);
			}
		}); 
	}
	function calInputTotal(){
		$.ajax({
			url : controller + 'getNewPrice',
			type: 'POST',
			async: false,
			data: {isnew:1},
			success:function(datas){
				var object = $.evalJSON(datas); 
				$('.tongtienhang').html(object.price);
				$('.ttchietkhau').html(object.discount);
				$('#input_total').val(object.priceEnd);
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
		//Serial 
		//Giam gia
		$('.discount').each(function(idx){
			$(this).on('keyup',function(){
				var goodid = $(this).attr('goodid'); 
				//setPrice(idx);
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
				updateDataTemp(goodid);
			});
			$(this).on('dblclick',function(){
				$(this).select();
			});
		});
		$('.unitid').each(function(){ 
			$(this).on('change',function(){
				var goodid = $(this).attr('goodid'); 
				var unitid = $(this).val();
				$.ajax({
					url : controller + 'updateUnit',
					type: 'POST',
					async: false,
					data: {unitid:unitid,goodid:goodid,isnew:1},
					success:function(datas){
						
					}
				}); 
			});
		});
	}
	function setPrice(goodid){
		var priceone = $('#priceone_'+goodid).val();
		var quantity = $('#quantity_'+goodid).val();
		var discount = $('#discount_'+goodid).val();
		if(discount == ''){
			discount = '0';
		}
		if (typeof priceone === "undefined") {
			priceone = ',0';
		}
		priceone = priceone.replace(/[^0-9+\-Ee.]/g, '');
		if (typeof quantity === "undefined") {
			quantity = ',0';
		}
		quantity = quantity.replace(/[^0-9+\-Ee.]/g, '');
		discount = discount.replace(/[^0-9+\-Ee.]/g, '');
		$('#price_'+goodid).val(formatOne(priceone*quantity));
	}
	function calInputTotal2(){
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
	}
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
		$('#supplierid').multipleSelect({
			filter: true,
			placeholder:'Chọn nhà cung cấp',
			single: true
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
		$('#customer_type').multipleSelect('setSelects',[1]);
		$('#quantity').val(1);
		$('#payments').multipleSelect('setSelects',[1]);	
		$('.loading').hide();
	}
</script>
<script src="<?=url_tmpl();?>assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
