<style title="" type="text/css">
	.col-md-4{ white-space: nowrap !important;}
	.col-md-3{ white-space: nowrap !important;}
</style>
<!-- BEGIN PORTLET-->
<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption mtop8">
			<b><i class="fa fa-barcode" style="margin-top:4px; font-size:15px;" aria-hidden="true"></i>
			In mã vạch</b>
		</div>
		<div class="tools">
			<ul class="button-group pull-right mbottom10">
				<li id="viewprint">
					<button class="button">
						<i class="fa fa-print"></i>
						In
					</button>
				</li>
				<li id="print">
					<button class="button">
						<i class="fa fa-file-pdf-o"></i>
						Xuất file pdf
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
			  <div class="col-md-7" style="margin-left:15px; width:60%;">
					<div class="row">
							<div class="form-group">
								<label class="control-label col-md-3" style="">Chọn hàng hóa</label>
								<div class="col-md-9" style="padding-left:0; margin-left:-3px; padding-right:0;">
									<input type="text" name="goodsid" id="goodsid" placeholder="Nhập mã hoạc tên hàng hóa" class="search form-control" />
								</div>
							</div>
					</div>
					<div class="row">
						<table class="inputgoods">
							<thead>
								<tr class="thd">
									<td width="40">STT</td>
									<td width="150">Mã hàng</td>
									<td >Tên hàng</td>
									<td width="80">Số lượng</td>
									<td width="40"></td>
								</tr>
							</thead>
							<tbody class="gridView">
							</tbody>
						</table>
					</div>
			  </div>
			  <div class="col-md-4" style="margin-left:2%; width:35%; border-left:1px dashed #c3cfd7;  margin-bottom:10px;">
					<div class="row">
						 <div class="col-md-11 bdb mleft12 tcler">
							<i class="fa fa-cogs" aria-hidden="true"></i>
							Thiết lập in mã vạch
						 </div>
					</div>
					<div class="row mtop20">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4"><b>Khổ giấy</b></label>
								<div class="col-md-8 pright5">
									<label class="control-label col-md-4">
									<input type="radio" name="papersize" value="1"/>
									&nbsp;A5 - No.108 - 40 tem
									</label>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4"></label>
								<div class="col-md-8 pright5">
									<label class="control-label col-md-4">
									<input checked type="radio" name="papersize" value="2"/>
									&nbsp;A4 - No.145 - 65 tem
									</label>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4"></label>
								<div class="col-md-8 pright5">
									<label class="control-label col-md-4">
									<input type="radio" name="papersize" value="3"/>
									&nbsp;A4 - No.138 - 100 tem
									</label>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4"></label>
								<div class="col-md-8 pright5">
									<label class="control-label col-md-4">
									<input type="radio" name="papersize" value="4"/>
									&nbsp;A4 - No.146 - 180 tem
									</label>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4"></label>
								<div class="col-md-8 pright5">
									<label class="control-label col-md-4">
									<input type="radio" name="papersize" value="5"/>
									&nbsp;AW - No0039 - máy in tem
									</label>
								</div>
							</div>
						</div>
					</div>
					<div class="row  mtop20">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4"><b>Loại tem</b></label>
								<div class="col-md-8 pright5">
									<label class="control-label col-md-4">
									<input type="radio" name="papertype" value="1"/>
									&nbsp;Chỉ in mã vạch
									</label>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4"><b></b></label>
								<div class="col-md-8 pright5">
									<label class="control-label col-md-4">
									<input type="radio" name="papertype" value="2"/>
									&nbsp;In mã và tên
									</label>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4"><b></b></label>
								<div class="col-md-8 pright5">
									<label class="control-label col-md-4">
									<input checked type="radio" name="papertype" value="3"/>
									&nbsp;In mã và giá bán
									</label>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4"><b></b></label>
								<div class="col-md-8 pright5">
									<label class="control-label col-md-4">
									<input  type="radio" name="papertype" value="3"/>
									&nbsp;In đầy đủ thông tin
									</label>
								</div>
							</div>
						</div>
					</div>
				</div>
		</div>
	</div>
	<div class="portlet-title">
		<div class="caption mtop8"></div>
		<div class="tools">
			<ul class="button-group pull-right mbottom10">
				<li id="viewprint">
					<button class="button">
						<i class="fa fa-print"></i>
						In
					</button>
				</li>
				<li id="print">
					<button class="button">
						<i class="fa fa-file-pdf-o"></i>
						Xuất file pdf
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
<script>
	var controller = '<?=base_url().$routes;?>/';
	var csrfHash = '<?=$csrfHash;?>';
	var goodsList = JSON.parse('<?=json_encode($goods);?>');
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
	function gooods(goodsid,uniqueid,code){ 
		$.ajax({
			url : controller + 'getGoods',
			type: 'POST',
			async: false,
			data: {id:goodsid,code:code},
			success:function(datas){
				var obj = $.evalJSON(datas); 
				$('.gridView').prepend(obj.content); //Add Grid view
				deleteItem();
				//Edit
				formatNumber('fm-number');
				formatNumberKeyUp('fm-number');
				
				stt();
			}
		});
	}
	function deleteItem(){
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
			});
		});
	}
	function stt(){
		$('.stt').each(function(idx){
			 $(this).html(idx+1);
		});
	}
	function init(){
		$( "#price_prepay" ).keyup(function(e){
			if ((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode == 8 || e.keyCode == 46) { //0-9 only, backspace, delete
				var inputTotal = $('#input_total').val();
				inputTotal = parseInt(inputTotal.replace(/[^0-9+\-Ee.]/g, ''));
				var pricePrepay = $('#price_prepay').val();
				pricePrepay = parseInt(pricePrepay.replace(/[^0-9+\-Ee.]/g, ''));
				if((inputTotal-pricePrepay) < 0){
					$('#price_indebtedness').val(0);
					$('#price_prepay').val(formatOne(inputTotal));
				}
				else{
					$('#price_indebtedness').val(formatOne(inputTotal-pricePrepay));
				}
			}
			else{
				e.preventDefault();
			}
			return false;
		});
		$( "#goodsid" ).keypress(function(e){
			if(e.keyCode == 13){ //Scan
				var code = $(this).val();
				gooods('','',code);
				$(this).select();
			}
		});
		$( "#goodsid" ).click(function(){
			$(this).focus();
		});
		$( "#goodsid" ).dblclick(function(){
			$(this).select();
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
					gooods(goodsid,'','');
					$('#goodsid').val('');
				}
				else{
					var thisQuantity = $('#'+goodsid).parent().parent().find('.quantity');
					thisQuantity.focus();
				}
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
		//
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
		$('.loading').hide();
	}
</script>
<script src="<?=url_tmpl();?>assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
