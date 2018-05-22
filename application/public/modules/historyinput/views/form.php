<style title="" type="text/css">
	.col-md-4{ white-space: nowrap !important;}
	.col-md-3{ white-space: nowrap !important;}
</style>
<!-- BEGIN PORTLET-->
<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption mtop8 mleft10">
			<b><i class="fa fa-pencil-square-o" style="margin-top:4px; font-size:15px;" aria-hidden="true"></i>
			Tạo phiếu nhập</b>
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
				<li>
					<a href= "<?=$controller;?>">
						<button class="button">
							<i class="fa fa-chevron-circle-left"></i>
							Trở lại
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
								<tr class="thd">
									<td width="40">STT</td>
									<td style="min-width:100px;" >Hàng hóa</td>
									<td width="60">ĐVT</td>
									<td width="90">Số lương</td>
									<td width="100">Giá nhập</td>
									<td width="100">Thành tiền</td>
									<td width="30"></td>
								</tr>
							</thead>
							<tbody class="gridView">
								<?php $i=1; $tt= 0; foreach($datas as $item){
										$buy_price = $item->buy_price;
										$tt+= $item->totalPrice;
										?>
									<tr class="tgrid">
										<td class="stt" class="text-center"><?=$i;?></td>
										<td align="left">
											<b><?=$item->goods_code;?></b>-<?=$item->goods_name;?>
											<?php if($item->stype == 0){?>
												<br><i style="font-size:12px;">(<?=$item->group_code;?>-<?=$item->group_name;?>)</i>
											<?php }?>
											<input  goodid="<?=$item->id;?>" class="goodscode" type="hidden" value="<?=$item->goods_code;?>" />
											<input  goodid="<?=$item->id;?>" class="goodstt" type="hidden" value="<?=$i;?>" />
										</td>
										<td ><?=$item->unit_name;?></td>
										<td ><input min="1" goodid="<?=$item->id;?>" type="number" name="quantity" id="<?=$item->goods_code;?>" placeholder="" class="search form-control quantity text-right fm-number" value="<?=fmNumber($item->quantity);?>" /></td>
										<td ><input goodid="<?=$item->id;?>" type="text" name="priceone" id="priceone" placeholder="" style="font-size:12px;" class="search form-control priceone text-right fm-number" value="<?=fmNumber($buy_price);?>" /></td>
										<td ><input goodid="<?=$item->id;?>" type="text" id="price" placeholder="" style="font-size:12px;" class="search form-control price buyprice text-right fm-number" value="<?=fmNumber($item->totalPrice);?>" /></td>
										<td >
											<a title="Xóa"  class="deleteItem" id="<?=$item->id;?>" href="#">
												<i class="fa fa-times"></i>
											</a>
										</td>
									</tr>
									<?php $i++;}?>
								<tr >
									<td colspan="5" style="text-align:right;">Tổng tiền:</td>
									<td class="ttprice" style="text-align:right; padding-right:10px !important; font-size:12px;"><?=fmNumber($tt);?></td>
									<td></td>
									
								</tr>
							</tbody>
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
									<input maxlength="30" type="text" name="poid" id="poid" placeholder="" class="searchs form-control" <?php if(empty($setuppo)){?> readonly <?php }?> />
									<input type="hidden" id="unit" name="unit" readonly />
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
									<input value="<?=date(cfdate(),strtotime($datecreate));?>" type="text" id="datecreate" placeholder="<?=cfdateHtml();?>" name="datecreate" class="form-control searchs" >
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
									<input type="text" name="description" id="description" placeholder=""  class="searchs form-control" />
								</div>
							</div>
						</div>
					</div><!--E Row-->
					<div class="row mtop10">
						 <div class="col-md-11 bdb mleft12 tcler">
							<i class="fa fa-question-circle-o" aria-hidden="true"></i>
							Thông tin kho lưu
						 </div>
					</div>
					
					<div class="row mtop10">
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
								<label class="control-label col-md-4">Thanh toán</label>
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
									<input type="text" name="input_total" id="input_total" readonly placeholder="" value="<?=fmNumber($tt);?>" class="searchs form-control text-right fm-number" />
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
									<div class="col-md-7" style="padding:0 !important;">
										<label class="control-label">
											<input   type="radio" id="prepay_1" name="prepay" value="1"  />
											Tiền</label>
										<label class="control-label" style="margin-left:10px;">
											<input checked type="radio" id="prepay_2" name="prepay" value="2"  />
											%</label>
									</div>
									<div class="col-md-5" style="padding:0 !important; ">
										<input style="font-size:12px;" type="text" name="price_prepay" id="price_prepay" placeholder="" class="searchs form-control text-right fm-number" value="" />
									</div>
								</div>
							</div>
						</div>
					</div><!--E Row-->
					<div class="row mtop10 mbottom10">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4">Còn lại</label>
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
				<li>
					<a href= "<?=$controller;?>">
						<button class="button">
							<i class="fa fa-chevron-circle-left"></i>
							Trở lại
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
	/*var goodsList = JSON.parse('<?=json_encode($goods);?>');*/
	var inputList = {};
	var inputListCode = {};
	var cpage = 0;
	var percent = 1; // pham tram
	var search;
	var temp_goodsid = 0;
	var temp_goods_code = 0;
	var temp_stype = 0;
	var temp_exchangs = 0;
	$(function(){
		init();
		refresh();
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
	});
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
		search = getSearch();
		var obj = $.evalJSON(search);
		//STT
		var goodstt  = {};
		$('.goodstt ').each(function(e){
			var goodid = $(this).attr('goodid');
			var val = $(this).val();
			goodstt[goodid] = val;
		});
		//So luong
		var quantity  = {};
		$('.quantity ').each(function(e){
			var goodid = $(this).attr('goodid');
			var val = $(this).val();
			quantity[goodid] = val;
		});
		//Gia nhap
		var priceone = {};
		$('.priceone').each(function(e){
			var goodid = $(this).attr('goodid');
			var val = $(this).val();
			priceone[goodid] = val;
		});
		var setuppo = parseFloat('<?=$setuppo;?>');
		if(obj.poid == '' && setuppo == 1){
			$('#poid').focus();
			error('Mã đơn hàng <?=getLanguage('all','empty')?>'); return false;
		}
		if(obj.supplierid == ''){
			error('Nhà cung cấp <?=getLanguage('all','empty')?>'); 
			$('#supplierid').multipleSelect('focus');
			return false;	
		}
		var input_total = $('#input_total').val();
		var price_prepay = $('#price_prepay').val();
		var token = $('#token').val();
		obj.input_list = inputList;
		// console.log(obj);
		// return false;
	    $(".loading").show();
		var payments = $('input[name=payments]:checked').val();
		var description = $('#description').val();
		var uniqueid = $('#uniqueid').val();
		$.ajax({
			url : controller + func,
			type: 'POST',
			async: false,
			data: {csrf_stock_name:token,search:JSON.stringify(obj),id:id,description:description,priceone:JSON.stringify(priceone),payment:payments,percent:percent,quantity:JSON.stringify(quantity),goodstt:JSON.stringify(goodstt),uniqueid:uniqueid},
			success:function(datas){
				var obj = $.evalJSON(datas);  
				$("#token").val(obj.csrfHash);
				$(".loading").hide();
				if(obj.status == 0){
					if(func == 'save'){
						error('<?=getLanguage('all','add_failed')?>.'); return false;	
					}
					else{
						error('<?=getLanguage('all','edit_failed')?>.'); return false;	
					}
				}
				else if(obj.status == -1){
					error('Đơn hàng đã xuất <?=getLanguage('all','exist')?>.'); return false;		
				}
				else if(obj.status == -2){
					error('Mã đơn hàng đã tồn tại'); return false;		
				}
				else{
					$('.gridView').html('');
					$('#price_indebtedness,#input_total,#price_prepay').val('');
					$('#poid').val(obj.poid);
					$('#unit').val(obj.status);
					if(id == 0){
						success('Nhập kho thành công.');
						inputList = {};
					}
					else{
						 success('Nhập kho thành công.');
						 inputList = {};
						 print(id,obj.status);
					}
					
				}
			},
			error : function(){
				error('Nhập kho không thành công.');
			}
		});
	}
	function gooods(goodsid,code,stype,exchangs,deletes){ 
		$.ajax({
			url : controller + 'getGoods',
			type: 'POST',
			async: false,
			data: {id:goodsid,code:code,stype:stype,exchangs:exchangs,deletes:deletes,isnew:0},
			success:function(datas){
				var obj = $.evalJSON(datas); 
				$('.gridView').html(obj.content); //Add Grid view
				$('.ttprice').html(obj.totalPrice);
				$('#input_total').val(obj.totalPrice);
				//$('#price_prepay').val(obj.totalPrice);
				$('#uniqueid').val(obj.uniqueid);
				percent = 1; //gan gia tri tien = 0
				$('#price_prepay,#price_indebtedness').val('');
				$('#prepay_2').prop('checked', true);
				$('#goodsid').val('');
				actionTemp();
			}
		});
		calInputTotal();
	}
	function actionTemp(){
		//Xóa
		$('.deleteItem').each(function(){
			$(this).on('click',function(){
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
				var priceone = $(this).val();
				setPrice(idx)
				updatePriceOne(goodid,priceone);
			});
		});
		//Update so luong
		$('.quantity').each(function(idx){
			$(this).on('click',function(){
				var goodid = $(this).attr('goodid'); 
				var quantity = $(this).val();
				//Tinh tien
				setPrice(idx)
				updateQuantity(goodid,quantity);
			});
			$(this).on('keyup',function(){
				var goodid = $(this).attr('goodid'); 
				var quantity = $(this).val();
				//Tinh tien
				setPrice(idx);
				updateQuantity(goodid,quantity);
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
	function calInputTotal(){
		
		var total = 0; 
		$('.buyprice').each(function(){
			var price = $(this).val();
			price = price.replace(/[^0-9+\-Ee.]/g, '');
			total+= parseFloat(price);
		});
		
		var price_prepay = $("#price_prepay").val();
		if(price_prepay != ''){
			price_prepay = price_prepay.replace(/[^0-9+\-Ee.]/g, '');
			price_prepay = parseFloat(price_prepay);
		}
		else{
			price_prepay = 0;
		}
		$("#input_total").val(formatOne(total));
		$(".ttprice").html(formatOne(total));
		if($("#price_prepay").val() != ''){
			if(percent == 1){//Tinh theo %
				var tamung = (price_prepay * total / 100).toFixed(2);
				$('#price_indebtedness').val(formatOne(total-tamung));
			}
			else{//Tinh tien truc tiep
				$('#price_indebtedness').val(formatOne(total-price_prepay));
			}
			//price_indebtedness
		}
		
	}
	function updatePriceOne(goodid,priceone){
		$.ajax({
			url : controller + 'updatePriceOne',
			type: 'POST',
			async: false,
			data: {goodid:goodid, priceone:priceone},
			success:function(datas){
				
			}
		}); 
		calInputTotal();
	}
	function updateQuantity(goodid,quantity){
		$.ajax({
			url : controller + 'updateQuantity',
			type: 'POST',
			async: false,
			data: {goodid:goodid,quantity:quantity},
			success:function(datas){
			}
		}); 
		calInputTotal();
	}
	function init(){
		$('#prepay_2').prop('checked', true);
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
		$( "#price_prepay" ).keyup(function(e){
			if ((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode == 8 || e.keyCode == 46) { //0-9 only, backspace, delete
				var total = 0; 
				$('.buyprice').each(function(){
					var price = $(this).val();
					price = price.replace(/[^0-9+\-Ee.]/g, '');
					total+= parseFloat(price);
				});
				//Kiểm tra tam ưng
				var price_prepay = $("#price_prepay").val();
				price_prepay = price_prepay.replace(/[^0-9+\-Ee.]/g, '');
				if(percent == 1 && price_prepay != ''){//Tinh theo %
					price_prepay = parseFloat(price_prepay);
					if(price_prepay > 100){
						$("#price_prepay").val(100);
					}
				}
				else{//Tinh tien truc tiep
					
					price_prepay = parseFloat(price_prepay);
					console.log(total);
					if(price_prepay > total){
						$("#price_prepay").val(formatOne(total));
					}
				}
				calInputTotal();
			}
			else{
				e.preventDefault();
			}
			return false;
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
