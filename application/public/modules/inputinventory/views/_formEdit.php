<style title="" type="text/css">
	.col-md-4{ white-space: nowrap !important;}
	.col-md-3{ white-space: nowrap !important;}
</style>
<!-- BEGIN PORTLET-->
<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption mtop8 mleft10">
			<b><i class="fa fa-pencil-square-o" style="margin-top:4px; font-size:15px;" aria-hidden="true"></i>
			Sửa phiếu nhập</b>
		</div>
		<div class="tools">
			<!--<b><i class="fa fa-pencil-square-o" style="margin-top:4px; font-size:15px;" aria-hidden="true"></i>
			Tạo phiếu nhập</b>-->
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
		<div class="row">
			  <div class="col-md-7" style="margin-left:0px; width:65%; padding-right:0px;">
					<div class="row">
							<div class="form-group">
								<label class="control-label col-md-3" style="">Hàng hóa(<span class="red">*</span>)</label>
								<div class="col-md-9" style="padding-left:0; padding-right:0px;">
									<input placeholder="Nhận mã hàng, tên hàng hoạc nhóm hàng" type="text" name="goodsid" id="goodsid" placeholder="" class="search form-control" />
								</div>
								<!--<div class="col-md-1 pleft0 text-right" >
									<a class="btn btn-sm btns" id="addGoodsList" href="#">
										<i class="fa fa-file-excel-o" aria-hidden="true"></i>
										Import
									</a>
								</div>-->
							</div>
					</div>
					<div class="row">
						<table class="inputgoods">
							<thead>
								<tr class="thds">
									<td width="30" rowspan="2">STT</td>
									<td rowspan="2" >Hàng hóa</td>
									<td width="85" rowspan="2">Số lượng</td>
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
			  <div class="col-md-4" style="padding-left:5px; padding-right:5px; margin-left:2%; width:33%; border-left:1px dashed #c3cfd7;  margin-bottom:10px;">
					<div class="row">
						 <div class="col-md-11 bdb mleft12 tcler">
							<i class="fa fa-question-circle-o" aria-hidden="true"></i>
							Thông tin hóa đơn
						 </div>
					</div>
					<div class="row mtop20">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4">Mã đơn hàng <?php if(!empty($setuppo)){?>(<span class="red">*</span>) <?php }?></label>
								<div class="col-md-8 ">
									<input type="text" name="poid" id="poid" placeholder="" class="searchs form-control" <?php if(empty($setuppo)){?> readonly <?php }?> value = "<?=$find->poid;?>" />
									<input type="hidden" id="unit" name="unit" readonly value = "<?=$find->uniqueid;?>" />
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
												<option  <?php if($find->supplierid == $item->id){?> selected <?php }?> value="<?=$item->id;?>"><?=$item->supplier_name;?></option>
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
									<input value="<?=date(cfdate(),strtotime($find->datecreate));?>"  type="text" id="datecreate" placeholder="<?=cfdateHtml();?>" name="datecreate" class="form-control searchs" >
									<span class="input-group-btn ">
										<button class="btn default btn-picker" type="button"><i class="fa fa-calendar "></i></button>
									</span>
								</div>
							</div>
						</div>
					</div><!--E Row-->
					<!--E Row-->
					<div class="row mtop10">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4">Ghi chú</label>
								<div class="col-md-8 ">
									<input type="text" name="description" id="description" placeholder="" value="<?=$find->description;?>" class="searchs form-control" />
								</div>
							</div>
						</div>
					</div><!--E Row-->
					<div class="row mtop10"  style="display:none">
						 <div class="col-md-11 bdb mleft12 tcler">
							<i class="fa fa-question-circle-o" aria-hidden="true"></i>
							Thông tin kho lưu
						 </div>
					</div>
					
					<div class="row mtop10" style="display:none">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4">Lưu kho</label>
								<div class="col-md-7">
									<span id="loadWarehouse">
										<select id="warehouseid" name="warehouseid" class="combos" >
											<option value=""></option>
											<?php foreach($warehouses as $item){?>
												<option value="<?=$item->id;?>"><?=$item->warehouse_name;?></option>
											<?php }?>
										</select>
									</span>
								</div>
								<div class="col-md-1" style="margin-left:-20px;">
									<a  title="Thêm mới kho" class="btn btn-sm btns" id="addWarehouse" data-toggle="modal" data-target="#myFromWarehouse" href="#">
										<i class="fa fa-plus" aria-hidden="true"></i>
									</a>
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
								<label class="control-label col-md-4">HT tThanh toán</label>
								<div class="col-md-8 ">
									<div class="col-md-4 pleft0">
										<label class="control-label">
										<input  <?php if($find->payments ==1){?> checked <?php }?> type="radio" id="payments_1" name="payments" value="1"  />
										Tiền mặt</label>
									</div>
									<div class="col-md-4">
										<label class="control-label">
										<input  <?php if($find->payments ==2){?> checked <?php }?> type="radio"  id="payments_2" name="payments" value="2"  />
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
									<input type="text" name="input_total" id="input_total" readonly placeholder=""  class="searchs form-control text-right fm-number" />
								</div>
							</div>
						</div>
					</div><!--E Row-->
					<div class="row mtop10">
						<div class="col-md-12">
							<div class="form-group">
								<div class="col-md-4">
									<label class="control-label">Tạm ứng</label>
									<!--<input type="checkbox" name="full_paid" id="full_paid" title="Trả đủ" checked="checked" />-->
								</div>
								<div class="col-md-8 ">
									<div class="col-md-6" style="padding:0 !important;">
										<label class="control-label">
											<input  checked type="radio" id="prepay_1" name="prepay" value="1"  />
											Tiền</label>
										<label class="control-label" style="margin-left:10px;">
											<input  type="radio" id="prepay_2" name="prepay" value="2"  />
											%</label>
									</div>
									<div class="col-md-6" style="padding:0 !important; ">
										<input type="text" name="price_prepay" id="price_prepay" placeholder="" class="searchs form-control text-right fm-number" value="<?=fmNumber($find->price_prepay);?>" />
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
									<input type="text" name="price_indebtedness" id="price_indebtedness" readonly placeholder="" value="0" class="searchs form-control text-right fm-number" />
								</div>
							</div>
						</div>
					</div><!--E Row-->
				</div>
		</div>
	</div>
	<div class="portlet-title fixbuttom">
		<div class="caption mtop8"></div>
		<div class="tools">
			<ul class="button-group pull-right mbottom10">
				<!--<li id="saveTemp">
					<button class="button save-input">
						<i class="fa fa-save"></i>
						Lưu tạm
					</button>
				</li>-->
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
<div class="modal fade" id="myFromWarehouse" role="dialog">
	<div class="modal-dialog">
	  <!-- Modal content-->
	  <div class="modal-content">
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
		  <h4 class="modal-title"><i class="fa fa-plus" aria-hidden="true"></i> Thêm mới kho hàng</h4>
		</div>
		<div class="modal-body-warehouse">
			<!--Content-->
		</div>
		<div class="modal-footer">
		  <button type="button" id="saveWarehouse" class="btn btn-default">Lưu</button>
		</div>
	  </div>
	  
	</div>
</div>
<!--E My form-->
<style type="text/css">
	.inputgoods{
		width:98%;	
		margin-left:15px;
		margin-top:15px;
	}
	.thd{
		text-align:center;
	}
</style>
<input id="uniqueid" name="uniqueid" value="<?=$uniqueid;?>" type="hidden" />
<script>
	var controller = '<?=base_url().$routes;?>/';
	var csrfHash = '<?=$csrfHash;?>';
	
	var inputList = {};
	var inputListCode = {};
	var cpage = 0;
	var percent = 0; //Tien
	var search;
	var temp_goodsid = 0;
	var temp_goods_code = 0;
	var temp_stype = 0;
	var temp_exchangs = 0;
	$(function(){
		init();
		refresh();
		gridView();
		actionTemp();
		$('.dateOneShelflifes').datepicker().on('changeDate', function (ev) {
			var goodid = $(this).attr('goodid');
			var shelflifes = $('#shelflifes_'+goodid).val();
			$.ajax({
				url : controller + 'updateShelflifes',
				type: 'POST',
				async: false,
				data: {goodid:goodid,shelflife:shelflifes},
				success:function(datas){}
			});
			$('.datepicker').hide();
		});
		$('#selectAllShelflife').datepicker().on('changeDate', function (ev){
			var shelflifes = $('#shelflife').val();
			$.ajax({
				url : controller + 'updateAllShelflifes',
				type: 'POST',
				async: false,
				data: {shelflifes:shelflifes},
				success:function(datas){}
			});
			$('.datepicker').hide();
		});
		$('#refresh').click(function(){
			$('.loading').show();
			refresh();
		});
		//S Them nha cung cap
		$('#addSuppliers').click(function(){
			$.ajax({
				url : controller + 'addSupplier',
				type: 'POST',
				async: false,
				data: {id:''},
				success:function(datas){
					var obj = $.evalJSON(datas); 
					$('.modal-bodys').html(obj.content);
					
				}
			});
		});
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
		$('#saveWarehouse').click(function(){
			 var warehouse = getAddWarehouse();
			 var warehouse_name = $('#warehouse_name').val();
			 if(warehouse_name == ''){
				 error('Tên kho hàng không được trống.'); return false;
			 }
			 $.ajax({
				url : controller + 'saveWarehouse',
				type: 'POST',
				async: false,
				data: {search:warehouse},
				success:function(datas){
					var obj = $.evalJSON(datas);
					if(obj.status == -1){
						error('Kho đã tồn tại.'); return false;
					}
					else if(obj.status == 0){
						error('Thêm kho hàng không thành công.'); return false;
					}
					else{
						$('#loadWarehouse').html(obj.warehouses);
						$('#warehouseid').multipleSelect({
							filter: true,
							placeholder:'Chọn kho',
							single: true
						});
						success('Thêm kho hàng thành công.');
						$('.close').click();
						
					}
				},
				error : function(){
					error('Thêm kho hàng không thành công.'); return false;
				}
			});
		});
		$('#addGoodsList').click(function(){ 
			return false;
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
			var unit = $('#unit').val(); 
			if(unit == ''){ return false;}
			print(0,unit);
		});
		$('#viewprint2').click(function(){
			var unit = $('#unit').val(); 
			if(unit == ''){ return false;}
			print(0,unit);
		});
		$('#addGoods').click(function(){
			importExcel();
		});
		$('#downloadfile').click(function(){
			window.location = '<?=base_url();?>files/template/file_mau_nha_kho.xls';
		});
		setDefault();
	});
	function setDefault(){
		var supplierid = '<?=$find->supplierid;?>';
		$('#supplierid').multipleSelect('setSelects',[supplierid]);
		var conno = '<?=fmNumber($find->price - $find->price_prepay);?>';
		$('#price_indebtedness').val(conno);
	}
	function importExcel(){
		var data = new FormData();
		var objectfile = document.getElementById('myfileImmport').files;
		if(typeof(objectfile[0])  === "undefined") {
			error("Vui lòng chọn file"); return false;	
		}
		$('#loads').show();
		data.append('userfile', objectfile[0]);
		$.ajax({
			url : controller + 'import',
			type: 'POST',
			async: false,
			data: data,
			enctype: 'multipart/form-data',
			processData: false,  
			contentType: false,   
			success:function(datas){
				var obj = $.evalJSON(datas); 
				$('#loads').hide();
				if(obj.status == 0){
					error(obj.content); return false;	
				}
				else if(obj.status == -1){
					error('Bạn được nhập tối đa 500 hàng hóa'); return false;	
				}
				else{
					msg(obj.content); 
					$('.close').click();
					refresh();
					return false;	
				}
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
	function gridView(){
		$.ajax({
			url : controller + 'loadDataTempAdd',
			type: 'POST',
			async: false,
			data: {isnew:1},
			success:function(datas){
				var obj = $.evalJSON(datas);
				$('.gridView').html(obj.content);
				tabControl();				
			}
		});
	}
	function save(func,id){
		search = getSearch();
		var obj = $.evalJSON(search);
		//STT
		var setuppo = parseFloat('<?=$setuppo;?>');
		if(obj.poid == '' && setuppo == 1){
			$('#poid').focus();
			warning('Mã đơn hàng <?=getLanguage('all','empty')?>'); return false;
		}
		if(obj.supplierid == ''){
			warning('Nhà cung cấp <?=getLanguage('all','empty')?>'); 
			$('#supplierid').multipleSelect('focus');
			return false;	
		}
		var input_total = $('#input_total').val();
		var price_prepay = $('#price_prepay').val();
		var token = $('#token').val();
		// console.log(obj);
		// return false;
	    $(".loading").show();
		var payments = $('input[name=payments]:checked').val();
		var description = $('#description').val();
		var uniqueid = $('#uniqueid').val();
		var prepay = $('input[name=prepay]:checked').val();
		$.ajax({
			url : controller + 'edit',
			type: 'POST',
			async: false,
			data: {csrf_stock_name:token,search:JSON.stringify(obj),id:id,description:description,payment:payments,percent:percent,uniqueid:uniqueid,price_prepay:price_prepay,prepay:prepay},
			success:function(datas){
				var obj = $.evalJSON(datas);  
				$("#token").val(obj.csrfHash);
				$(".loading").hide();
				//status
				if(parseInt(obj.status) == -2){
					error('Đơn hàng đã thanh toán. Bạn không được sửa đơn hàng này.'); return false;	
				}
				if(parseInt(obj.status) == -3){
					error('Mã đơn hàng đã tồn tại.'); return false;	
				}
				if(obj.status == 0){
					error('<?=getLanguage('all','edit_failed')?>.'); return false;	
				}
				else{
					$('.gridView').html('');
					$('#price_indebtedness,#input_total,#price_prepay').val('');
					$('#poid').val(obj.poid);
					$('#unit').val(obj.status);
					$('#uniqueid').val(obj.uniqueidnew);
					if(id == 0){
						success('Sửa nhập kho thành công.');
						inputList = {};
					}
					else{
						 success('Sửa nhập kho thành công.');
						 inputList = {};
						 print(id,obj.status);
					}
					
				}
			},
			error : function(){
				error('Sửa nhập kho không thành công.');
			}
		});
	}
	function gooods(goodsid,code,stype,exchangs,deletes){ 
		var uniqueid = $('#uniqueid').val();
		$.ajax({
			url : controller + 'getGoods',
			type: 'POST',
			async: false,
			data: {id:goodsid,code:code,stype:stype,exchangs:exchangs,deletes:deletes,isnew:1,uniqueid:uniqueid},
			success:function(datas){
				var obj = $.evalJSON(datas); 
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
		calInputTotal();
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
		//Update so luong
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
	}
	function setPrice(idx){
		var priceone = $('.priceone').eq(idx).val();
		var quantity = $('.quantity').eq(idx).val();
		if (typeof priceone === "undefined") {
			priceone = ',0';
		}
		priceone = priceone.replace(/[^0-9+\-Ee.]/g, '');
		if (typeof quantity === "undefined") {
			quantity = ',0';
		}
		quantity = quantity.replace(/[^0-9+\-Ee.]/g, '');
		$('.priceone').eq(idx).val(formatOne(priceone));
		$('.price').eq(idx).val(formatOne(priceone*quantity));
	}
	function updateDataTemp(goodid){
		var priceone = $('#priceone_'+goodid).val();
		var quantity = $('#quantity_'+goodid).val();
		var discount = $('#discount_'+goodid).val();
		var xkm = $('#xkm_'+goodid).val();
		$.ajax({
			url : controller + 'updatePriceOne',
			type: 'POST',
			async: false,
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
	function clickViewImg(){
		$('#clickViewImg').click(function(){
			 var url = $(this).attr('src');
			 viewImg(url);
		});
		$('.tgrid').each(function(){
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
				$('#input_total').val(object.price);
				$('#price_prepay').val(object.price);
			}
		}); 
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
				//console.log(pricePrepay);
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
		$('#price_prepay').keyup(function(e){
			 calInputTotal3();
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
		//console.log(goodsList);
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
		//$('.fm-number').number(true,0);
		$('#payments').multipleSelect({
			filter: true,
			placeholder:'Chọn hình thức thanh toán',
			single: true
		});
		$('#supplierid').multipleSelect({
			filter: true,
			placeholder:'Chọn nhà cung cấp',
			single: true
		});
		$('#warehouseid').multipleSelect({
			filter: true,
			placeholder:'Chọn kho',
			single: true
		});
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
    function refresh(){
		$('.loading').show();
		//$('.searchs').val('');		
		csrfHash = $('#token').val();
		$('select.combos').multipleSelect('uncheckAll');
		$('#customer_type').multipleSelect('setSelects',[1]);
		$('#quantity').val(1);
		$('#payments').multipleSelect('setSelects',[1]);
		<?php if(count($warehouses) == 1){
			if(!empty($warehouses[0]->id)){
				$warehousesid = $warehouses[0]->id;
			}
			else{
				$warehousesid = 0;
			}
			?>
			$('#warehouseid').multipleSelect('setSelects',[<?=$warehousesid;?>]);
		<?php }?>
		$('.loading').hide();
	}
</script>
<script src="<?=url_tmpl();?>assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
