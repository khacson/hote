<style title="" type="text/css">
	.col-md-4{ white-space: nowrap !important;}
	.col-md-3{ white-space: nowrap !important;}
</style>
<!-- BEGIN PORTLET-->
<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption mtop8 mleft10">
			<b><i class="fa fa-pencil-square-o" style="margin-top:4px; font-size:15px;" aria-hidden="true"></i>
			Xuất trả NCC</b>
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
								<?php $i=1; $tt= 0;
										foreach($datas as $item){
										$tt+= $item->price;
										?>
									<tr class="tgrid">
										<td class="stt" class="text-center"><?=$i;?></td>
										<td align="left">
											<b><?=$item->goods_code;?></b>-<?=$item->goods_name;?>
											<?php if($item->stype == 0 && !empty($item->group_code)){?>
												<br><i style="font-size:12px;">(<?=$item->group_code;?>-<?=$item->group_name;?>)</i>
											<?php }?>
											<input  goodid="<?=$item->id;?>" class="goodscode" type="hidden" value="<?=$item->goods_code;?>" />
											<input  goodid="<?=$item->id;?>" class="goodstt" type="hidden" value="<?=$i;?>" />
										</td>
										<td ><?=$item->unit_name;?></td>
										<td ><input max="<?=$item->quantity;?>" min="1" goodid="<?=$item->id;?>" type="number" name="quantity" id="<?=$item->goods_code;?>" placeholder="" class="search form-control quantity text-right fm-number" value="<?=fmNumber($item->quantity);?>" /></td>
										<td ><input goodid="<?=$item->id;?>" type="text" name="priceone" id="priceone" placeholder="" style="font-size:12px;" class="search form-control priceone text-right fm-number" value="<?=fmNumber($item->priceone);?>" readonly /></td>
										<td ><input goodid="<?=$item->id;?>" type="text" id="price" placeholder="" style="font-size:12px;" class="search form-control price buyprice text-right fm-number" readonly value="<?=fmNumber($item->price);?>" /></td>
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
								<label class="control-label col-md-4">Mã phiếu nhập (<span class="red">*</span>) </label>
								<div class="col-md-8 ">
									<input maxlength="30" type="text" name="poid" id="poid" placeholder="" value="<?=$finds->poid;?>" class="searchs form-control" readonly />
									
								</div>
							</div>
						</div>
					</div>
					<div class="row mtop10">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4">Nhà CC(<span class="red">*</span>)</label>
								<div class="col-md-8">
									<span id="loadSupplier">
										<select id="supplierid" name="supplierid" class="combos" >
											<option value=""></option>
											<?php foreach($suppliers as $item)
											{
												if($finds->supplierid != $item->id){
													continue;
												}
												?>
												<option value="<?=$item->id;?>"><?=$item->supplier_name;?></option>
											<?php }?>
										</select>
									</span>
								</div>
							</div>
						</div>
					</div><!--E Row-->
					<div class="row mtop10">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4">Ngày nhập</label>
								 <div class="col-md-8 input-group date date-picker" data-date-format="<?=cfdateHtml();?>">
									<input value="<?=date(cfdate(),strtotime($finds->datepo));?>" type="text" id="datecreate" placeholder="<?=cfdateHtml();?>" name="datecreate" class="form-control searchs" >
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
									<input type="text" name="description" id="description" placeholder="" value="<?=$finds->description;?>"  class="searchs form-control" />
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
								<div class="col-md-8">
									<span id="loadWarehouse">
										<select id="warehouseid" name="warehouseid" class="combos" >
											<option value=""></option>
											<?php foreach($warehouses as $item){?>
												<option value="<?=$item->id;?>"><?=$item->warehouse_name;?></option>
											<?php }?>
										</select>
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
								<label class="control-label col-md-4">Thanh toán</label>
								<div class="col-md-8 ">
									<div class="col-md-4 pleft0">
										<label class="control-label">
										<input <?php if($finds->payments == 1){?> checked <?php }?> type="radio" id="payments_1" name="payments" value="1"  />
										Tiền mặt</label>
									</div>
									<div class="col-md-4">
										<label class="control-label">
										<input <?php if($finds->payments == 2){?> checked <?php }?> type="radio"  id="payments_2" name="payments" value="2"  />
										CK</label>
									</div>
									<div class="col-md-4">
										<label class="control-label">
										<input <?php if($finds->payments == 2){?> checked <?php }?> type="radio"  id="payments_3" name="payments" value="3"  />
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
	var percent = 0; // tiền mặt
	var search;
	var temp_goodsid = 0;
	var temp_goods_code = 0;
	var temp_stype = 0;
	var temp_exchangs = 0;
	$(function(){
		init();
		refresh();
		actionTemp();
		$('#refresh').click(function(){
			$('.loading').show();
			refresh();
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
		var uniqueid = '<?=$finds->uniqueid;?>';
		var poid = '<?=$finds->poid;?>';
		$.ajax({
			url : controller + func,
			type: 'POST',
			async: false,
			data: {csrf_stock_name:token,search:JSON.stringify(obj),id:id,description:description,priceone:JSON.stringify(priceone),payment:payments,percent:percent,quantity:JSON.stringify(quantity),goodstt:JSON.stringify(goodstt),uniqueid:uniqueid,poid:poid},
			success:function(datas){
				var obj = $.evalJSON(datas);  
				$("#token").val(obj.csrfHash);
				$(".loading").hide();
				if(obj.status == 0){
					error('Xuất kho không thành công. '+obj.msg); return false;	
				}
				else{
					$('.gridView').html('');
					$('#price_indebtedness,#input_total,#price_prepay').val('');
					$('#poid').val(obj.poid);
					$('#unit').val(obj.status);
					if(id == 0){
						success('Xuất trả NCC thành công.','Thông báo');
					}
					else{
						success('Xuất trả NCC thành công.','Thông báo');
						print(id,obj.status);
					}
					
				}
			},
			error : function(){
				error('Xuất trả NCCkhông thành công.');
			}
		});
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
				//updatePriceOne(goodid,priceone);
			});
		});
		//Update so luong
		$('.quantity').each(function(idx){
			$(this).on('click',function(){
				var goodid = $(this).attr('goodid'); 
				var quantity = $(this).val();
				//Tinh tien
				setPrice(idx)
				//updateQuantity(goodid,quantity);
			});
			$(this).on('keyup',function(){
				var goodid = $(this).attr('goodid'); 
				var max = $(this).attr('max'); 
				var quantity = $(this).val();
				if(parseFloat(max) < quantity){
					$(this).val(max); return false;
				}
				//Tinh tien
				setPrice(idx);
				//updateQuantity(goodid,quantity);
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
		$("#input_total").val(formatOne(total));
		$("#price_prepay").val(formatOne(total));
		$(".ttprice").html(formatOne(total));
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
		$( "#goodsid" ).click(function(){
			$(this).focus();
		});
		$( "#goodsid" ).dblclick(function(){
			$(this).select();
		});
		//console.log(goodsList);
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
		var unit = '<?=$finds->uniqueid;?>';
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
		$('#quantity').val(1);
		//$('#payments').multipleSelect('setSelects',[1]);
		var supplierid = '<?=$finds->supplierid;?>';
		var warehouseid = '<?=$finds->warehouseid;?>';
		$('#supplierid').multipleSelect('setSelects',[supplierid]);
		$('#warehouseid').multipleSelect('setSelects',[warehouseid]);
		$('.loading').hide();
	}
</script>
<script src="<?=url_tmpl();?>assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
