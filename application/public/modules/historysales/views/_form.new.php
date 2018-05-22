<style title="" type="text/css">
	.col-md-4{ white-space: nowrap !important;}
	.col-md-3{ white-space: nowrap !important;}
</style>
<!-- BEGIN PORTLET-->
<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption mtop8">
			<b><i class="fa fa-pencil-square-o" style="margin-top:4px; font-size:15px;" aria-hidden="true"></i>
			Tạo phiếu nhập</b>
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
				<li>
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
			  <div class="col-md-7" style="margin-left:15px; width:65%;">
					<div class="row">
							<div class="form-group">
								<label class="control-label col-md-3" style="">Chọn hàng hóa(<span class="red">*</span>)</label>
								<div class="col-md-8" style="padding-left:0; margin-left:-3px;">
									<input type="text" name="goodsid" id="goodsid" placeholder="" class="search form-control" />
									<!--
									<select id="goodsid" name="goodsid" class="combos" >
										<?php foreach($goods as $item){?>
											<option  value="<?=$item->id;?>"><?=$item->goods_code;?> - <?=$item->goods_name;?></option>
										<?php }?>
									</select>
									-->
								</div>
								<div class="col-md-1 pleft0 text-right" >
									<a class="btn btn-sm btns" id="addGoodsList" href="#">
										<i class="fa fa-file-excel-o" aria-hidden="true"></i>
										Import
									</a>
								</div>
							</div>
					</div>
					<div class="row">
						<table class="inputgoods">
							<thead>
								<tr class="thd">
									<td width="40">STT</td>
									<td >Hàng hóa</td>
									<td width="60">ĐVT</td>
									<td width="70">Số lương</td>
									<td width="100">Giá nhập</td>
									<td width="100">Thành tiền</td>
									<td width="100">Giá bán</td>
									<td width="40"></td>
								</tr>
							</thead>
							<tbody class="gridView">
							
							</tbody>
						</table>
					</div>
			  </div>
			  <div class="col-md-4" style="margin-left:2%; width:30%; border-left:1px dashed #c3cfd7;  margin-bottom:10px;">
					<div class="row">
						 <div class="col-md-11 bdb mleft12 tcler">
							<i class="fa fa-question-circle-o" aria-hidden="true"></i>
							Thông tin hóa đơn
						 </div>
					</div>
					<div class="row mtop20">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4">Mã hóa đơn</label>
								<div class="col-md-8 pright5">
									<input type="text" name="poid" id="poid" placeholder="" class="searchs form-control" readonly />
								</div>
							</div>
						</div>
					</div>
					<div class="row mtop10">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4">Nhà cung cấp(<span class="red">*</span>)</label>
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
									<a title="Thêm nhà cung cấp" class="btn btn-sm btns" id="addSuppliers" data-toggle="modal" data-target="#myFrom" href="#">
										<i class="fa fa-plus" aria-hidden="true"></i>
									</a>
								</div>
							</div>
						</div>
					</div><!--E Row-->
					<div class="row mtop10">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4">Ngày nhập</label>
								 <div class="col-md-8 input-group date date-picker" data-date-format="dd-mm-yyyy">
									<input value="<?=$datecreate;?>" type="text" id="datecreate" placeholder="dd-mm-yyyy" name="datecreate" class="form-control searchs" >
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
								<label class="control-label col-md-4">Người nhập</label>
								<div class="col-md-8 pright5">
									<input type="text" name="usercreate" id="usercreate" placeholder="" value="<?=$users;?>" class="searchs form-control" />
								</div>
							</div>
						</div>
					</div><!--E Row-->
					<div class="row mtop10">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4">Ghi chú</label>
								<div class="col-md-8 pright5">
									<textarea class="searchs textarea" name="description" id="description"></textarea>
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
								<label class="control-label col-md-4">Lưu kho(<span class="red">*</span>)</label>
								<div class="col-md-7">
									<span id="loadSupplier">
										<select id="warehouseid" name="warehouseid" class="combos" >
											<option value=""></option>
											<?php foreach($warehouses as $item){?>
												<option value="<?=$item->id;?>"><?=$item->warehouse_name;?></option>
											<?php }?>
										</select>
									</span>
								</div>
								<div class="col-md-1" style="margin-left:-20px;">
									<a title="Thêm kho" class="btn btn-sm btns" id="addWarehouse" data-toggle="modal" data-target="#myFrom" href="#">
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
								<div class="col-md-8 pright5">
									<select id="payments" name="payments" class="combos" >
										<option value=""></option>
										<option value="1">Tiền mặt</option>
										<option value="2">Chuyển khoản</option>
										<option value="3">Cấn trừ tiền hàng</option>
										<option value="-1">Nợ khách hàng</option>
									</select>
								</div>
							</div>
						</div>
					</div><!--E Row-->
					<div class="row mtop10">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4">Tổng tiền</label>
								<div class="col-md-8 pright5">
									<input type="text" name="input_total" id="input_total" readonly placeholder="" class="searchs form-control text-right fm-number" />
								</div>
							</div>
						</div>
					</div><!--E Row-->
					<div class="row mtop10">
						<div class="col-md-12">
							<div class="form-group">
								<div class="col-md-4">
									<label class="control-label">Trả trước</label>
									<input type="checkbox" name="full_paid" id="full_paid" title="Trả đủ" checked="checked" />
								</div>
								<div class="col-md-8 pright5">
									<input type="text" name="price_prepay" id="price_prepay" placeholder="" class="searchs form-control text-right fm-number" />
								</div>
							</div>
						</div>
					</div><!--E Row-->
					<div class="row mtop10 mbottom10">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4">Còn nợ</label>
								<div class="col-md-8 pright5">
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
				<li id="refresh" >
					<button class="button">
						<i class="fa fa-refresh"></i>
						<?=getLanguage('all','refresh')?>
					</button>
				</li>
				<?php if(isset($permission['add'])){?>
				<li>
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
		<div class="modal-body">
			<!--Content-->
		</div>
		<div class="modal-footer">
		  <button type="button" id="addSups" class="btn btn-default">Lưu</button>
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
<script>
	var controller = '<?=base_url().$routes;?>/';
	var csrfHash = '<?=$csrfHash;?>';
	var goodsList = JSON.parse('<?=json_encode($goods);?>');;
	var inputList = {};
	var cpage = 0;
	var search;
	$(function(){
		init();
		refresh();
		$('#refresh').click(function(){
			$('.loading').show();
			refresh();
		});
		$('#save').click(function(){
			save('save','');
		});
		$('#edit').click(function(){
			var id = $("#id").val();
			if(id == ''){
				error('Vui lòng chọn dữ liệu cần sửa.'); return false;	
			}
			save('edit',id);
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
					$('.modal-body').html(obj.content);
					
				}
			});
		}); 
		$('#addSups').click(function(){
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
						$('.close').click();
					}
				},
				error : function(){
					error('Thêm nhà cung cấp không thành công.'); return false;
				}
			});
		});
		//E Them nha cung cap
		$('#print').click(function(){
			var id = getCheckedId();//$('#id').val();
			print(id);
		});
		$('#addGoodsList').click(function(){ 
			addRow();
		});
		$('.save-input').click(function(){
			save('save','');
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
	function save(func,id){
		search = getSearch();
		var obj = $.evalJSON(search);
		
		if(Object.keys(inputList).length < 1){
			error('Hàng hóa <?=getLanguage('all','empty')?>'); return false;	
		}
		if(obj.supplierid == ''){
			error('Nhà cung cấp <?=getLanguage('all','empty')?>'); return false;	
		}
		if(obj.warehouseid == ''){
			error('Kho <?=getLanguage('all','empty')?>'); return false;	
		}
		var input_total = $('#input_total').val();
		var price_prepay = $('#price_prepay').val();
		var token = $('#token').val();
		var idselect = $('#idselect').val();
		
		obj.input_list = inputList;
		// console.log(obj);
		// return false;
		
		$.ajax({
			url : controller + func,
			type: 'POST',
			async: false,
			data: {csrf_stock_name:token,search:JSON.stringify(obj),id:id},
			success:function(datas){
				var obj = $.evalJSON(datas); 
				$("#token").val(obj.csrfHash);
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
				else{
					if(id != ''){
						msg('Sửa thành công.');
					}
					else{
						msg('Nhập kho thành công.');
					}
					search = getSearch();
					getList(cpage,csrfHash);
				}
			},
			error : function(){
				msg('Nhập kho không thành công.');
			}
		});
	}
	function gooods(goodsid,uniqueid){ 
		$.ajax({
			url : controller + 'getGoods',
			type: 'POST',
			async: false,
			data: {id:goodsid},
			success:function(datas){
				var obj = $.evalJSON(datas); 
				$('.gridView').append(obj.content);
				$('.fm-number').number(true,0);
				//Edit
				$('.deleteItem').each(function(){
					$(this).click(function(){
						var ids = $(this).attr('id');
						if(typeof inputList[ids] !== 'undefined'){
							delete inputList[ids];
						}
						$(this).parent().parent().remove();
						var listCheck = '';
						$('.deleteItem').each(function(e){
							var ids = $(this).attr('id');
							$('.stt').eq(e).html(e+1);
							listCheck+= ','+ids;
						});
						// $('#goodsid').multipleSelect('setSelects', listCheck.split(','));
						calInputTotal();
					});
				});
				//quantity
				$('.quantity').each(function(e){
					$(this).keyup(function(e){
						if ((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode == 8 || e.keyCode == 46) { //0-9 only, backspace, delete
							var thisQuantity = $(this);
							var thisGoodsId = thisQuantity.attr('goodid');
							var thisParent = thisQuantity.parent().parent();
							var thisPriceOne = thisParent.find('.priceone');
							var thisBuyPrice = thisParent.find('.buyprice');
							var thisPrice = thisParent.find('.priceout');
							thisBuyPrice.val(thisQuantity.val() * thisPriceOne.val());
							
							inputList[thisGoodsId] = {
								quantity:thisQuantity.val(),
								priceone:thisPriceOne.val(),
								price:thisPrice.val()
							};
							calInputTotal();
							return true;
						}
						else{
							e.preventDefault();
							return false;
						}
					});
				});
				$('.priceone').each(function(e){
					$(this).keyup(function(e){
						if ((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode == 8 || e.keyCode == 46) { //0-9 only, backspace, delete
							var thisPriceOne = $(this);
							var thisGoodsId = thisPriceOne.attr('goodid');
							var thisParent = thisPriceOne.parent().parent();
							var thisQuantity = thisParent.find('.quantity');
							var thisBuyPrice = thisParent.find('.buyprice');
							var thisPrice = thisParent.find('.priceout');
							thisBuyPrice.val(thisQuantity.val() * thisPriceOne.val());
							
							inputList[thisGoodsId] = {
								quantity:thisQuantity.val(),
								priceone:thisPriceOne.val(),
								price:thisPrice.val()
							};
							calInputTotal();
							return true;
						}
						else{
							e.preventDefault();
							return false;
						}
					});
				});
				$('.priceout').each(function(e){
					$(this).keyup(function(e){
						if ((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode == 8 || e.keyCode == 46) { //0-9 only, backspace, delete
							var thisPrice = $(this);
							var thisGoodsId = thisPrice.attr('goodid');
							var thisParent = thisPrice.parent().parent();
							var thisQuantity = thisParent.find('.quantity');
							var thisPriceOne = thisParent.find('.priceone');
							
							inputList[thisGoodsId] = {
								quantity:thisQuantity.val(),
								priceone:thisPriceOne.val(),
								price:thisPrice.val()
							};
							return true;
						}
						else{
							e.preventDefault();
							return false;
						}
					});
				});
				calInputTotal();
			}
		});
	}
	function calInputTotal(){
		var inputTotal = 0;
		$('.buyprice ').each(function(e){
			buyPrice = $(this).val();
			if(isNaN(buyPrice)){
				buyPrice = 0;
			}
			buyPrice = parseInt(buyPrice);
			inputTotal += buyPrice;
		});
		// console.log(inputTotal);
		$('#input_total').val(inputTotal);
		var fullPaid = $('#full_paid').attr('checked');
		if(fullPaid == 'checked'){
			pricePrepaid = inputTotal;
			$('#price_prepay').val(pricePrepaid);
		}
		else{
			var pricePrepaid = $('#price_prepay').val();
			if(isNaN(pricePrepaid)){
				pricePrepaid = 0;
			}
			else{
				pricePrepaid = parseInt(pricePrepaid);
			}
			if(pricePrepaid > inputTotal){
				pricePrepaid = inputTotal;
				$('#price_prepay').val(pricePrepaid);
			}
		}
		$('#price_indebtedness').val(inputTotal - pricePrepaid);
		return true;
	}
	function getInputList(){
		var goodsid = '';
		for(var key in inputList){
			if(inputList.hasOwnProperty(key)){
				goodsid += (goodsid == '' ? '' : ',') + key;
			}
		}
		return goodsid;
	}
	function init(){
		$('#full_paid').click(function(){
			var fullPaid = $(this).attr('checked');
			if(fullPaid == 'checked'){
				var inputTotal = $('#input_total').val();
				if(isNaN(inputTotal)){
					inputTotal = 0;
				}
				else{
					inputTotal = parseInt(inputTotal);
				}
				pricePrepaid = inputTotal;
				$('#price_prepay').val(pricePrepaid);
				$('#price_indebtedness').val(0);
			}
		});
		$( "#price_prepay" ).keyup(function(e){
			if ((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode == 8 || e.keyCode == 46) { //0-9 only, backspace, delete
				var inputTotal = $('#input_total').val();
				if(isNaN(inputTotal)){
					inputTotal = 0;
				}
				else{
					inputTotal = parseInt(inputTotal);
				}
				var pricePrepaid = parseInt($(this).val());
				if(pricePrepaid >= inputTotal){
					pricePrepaid = inputTotal;
					$(this).val(pricePrepaid);
					$('#full_paid').attr('checked', true);
				}
				else{
					$('#full_paid').attr('checked', false);
				}
				$('#price_indebtedness').val(inputTotal - pricePrepaid);
			}
			else{
				e.preventDefault();
			}
			return false;
		});
		$( "#goodsid" ).keypress(function(e){
			if(e.keyCode == 13){
				var liObj = $('.ui-autocomplete').find('li');
				if(liObj.length == 1){
					liObj.click();
				}
			}
		});
		$( "#goodsid" ).click(function(){
			$(this).val('');
		});
		$( "#goodsid" ).autocomplete({
			source: goodsList,
			select: function( event, ui ) {
				event.preventDefault();
				$( "#goodsid" ).val( ui.item.label); //ui.item is your object from the array
				var goodsid = ui.item.value;
				if(typeof inputList[goodsid] === 'undefined'){
					inputList[goodsid] = 1;
					// var goodsid = getInputList();
					gooods(goodsid,'');
					$('#goodsid').val('');
				}
				else{
					var thisQuantity = $('#'+goodsid).parent().parent().find('.quantity');
					thisQuantity.focus();
					console.log();
				}
				return false;
			},
			focus: function(event, ui) {
				event.preventDefault();
				$("#goodsid").val(ui.item.label);
			}
		});
		
		$('.fm-number').number(true,0);
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
    function refresh(){
		$('.loading').show();
		//$('.searchs').val('');		
		csrfHash = $('#token').val();
		$('select.combos').multipleSelect('uncheckAll');
		$('#customer_type').multipleSelect('setSelects',[1]);
		$('#quantity').val(1);
		$('#payments').multipleSelect('setSelects',[1]);	
		$('.loading').hide();
	}
</script>
<script src="<?=url_tmpl();?>assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
