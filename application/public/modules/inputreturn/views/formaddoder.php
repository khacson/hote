<style title="" type="text/css">
	.col-md-4{ white-space: nowrap !important;}
	.col-md-3{ white-space: nowrap !important;}
</style>
<!-- BEGIN PORTLET-->
<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption mtop8">
			<b><i class="fa fa-pencil-square-o mleft10" style="margin-top:4px; font-size:15px;" aria-hidden="true"></i>
			Nhập hàng trả lại - <?=$so;?></b>
		</div>
		<div class="tools">
			<ul class="button-group pull-right mbottom10">
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
				<li id="viewPrint">
					<button class="button">
						<i class="fa fa-print"></i>
						<input type="hidden" id="unit" value="" />
						Phiếu nhập
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
		<div class="row mtop20">
			  <div class="col-md-7" style="width:65%; padding-left:10px; padding-right:10px;">
					
					<div class="row mtop20">
						<div class="row">
							<div class="form-group">
								<label  class="control-label col-md-3" style="padding-left:30px;"></label>
								<div class="col-md-7" style="padding-left:0; margin-left:-3px;">
									
								</div>
								<div  style="margin-top:-40px; width:110px; height:90px; border: 1px solid #ddd;" class="col-md-2" id="viewImg" >
									<div style ="width:80px; height:90px; ">
										<div style="margin-top:35px; margin-left:10px;">Hình ảnh</div>
									</div>
								</div>
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
									<td width="100">Đơn giá</td>
									<td width="120">Thành tiền</td>
									<!--<td width="105">Hạn bảo hành</td>-->
									<td width="30"></td>
								</tr>
							</thead>
							<tbody class="gridView">
								<?php $i=1; 
									$tt = 0;
									foreach($datas as $item){
										$quantityexport = $item->quantityexport;
										if(empty($quantityexport)){
											$quantityexport = 0;
										}
										$quantity = $item->quantity - $quantityexport;
										$priceone = $item->priceone;
										$discount = $item->discount;
										$price = ($priceone * $quantity) - $discount;
									?>
									<tr class="tgrid" url= '<?=base_url();?>files/goods/<?=$item->img;?>'>
										<td class="stt" width="40" class="text-center"><?=$i;?></td>
										<td align="left">
											<b><?=$item->goods_code;?></b>-<?=$item->goods_name;?>
											<?php if($item->stype == 0 && !empty($item->group_code)){?>
												<br><i style="font-size:12px;">(<?=$item->group_code;?>-<?=$item->group_name;?>)</i>
											<?php }?>
		
											<input  goodid="<?=$item->id;?>" class="goodscode" type="hidden" value="<?=$item->goods_code;?>" />
		<input  goodid="<?=$item->id;?>" class="sttview" type="hidden" value="<?=$i;?>" />
		<input  goodid="<?=$item->id;?>" class="discount" type="hidden" value="<?=$item->discount;?>" />
											
										</td>
										<td width="60"><?=$item->unit_name;?></td>
										<td width="70"><input goodid="<?=$item->id;?>" uniqueid="<?=$item->uniqueid;?>" max="<?=$quantity;?>" min="0" type="number" name="quantity" id="<?=$item->goods_code;?>" placeholder="" class="search form-control quantity text-right fm-number" min="1" max="<?=$quantity;?>" value="<?=$quantity;?>" style="font-size:12px;"  /></td>
										
										<td width="100">
											<input readonly goodid="<?=$item->id;?>" type="text" name="priceone" id="priceone" placeholder="" class="search form-control priceone text-right fm-number" value="<?=fmNumber($priceone);?>" style="font-size:12px;"  />
										</td>
										<?php 
											$tt+= $price;
										?>
										<td width="100">
										<input goodid="<?=$item->id;?>" type="text" id="price" placeholder="" class="search form-control price buyprice text-right fm-number" value="<?=fmNumber($price);?>" style="font-size:12px; float:left; ;" />
									
										</td>
										<td width="40">
											<a class="deleteItem" id="<?=$item->id;?>" href="#">
												<i class="fa fa-times"></i>
											</a>
										</td>
									</tr>
									<?php $i++;}
									$vat = $finds->vat;
									$tt2 = $tt;
									$ttvat = $vat * $tt /100;
									$tt = $ttvat + $tt;
									?>
								<tr >
									<td colspan="5" style="text-align:right;">Tổng tiền:</td>
									<td class="ttprice" style="text-align:right; padding-right:10px !important;"><?=fmNumber($tt2);?></td>
									<td></td>
								</tr>
							</tbody>
						</table>
					</div>
			  </div>
			  <div class="col-md-4" style="margin-left:1%; width:34%; border-left:1px dashed #c3cfd7;  margin-bottom:10px; padding-left:5px;">
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
									<input readonly type="text" value="<?=$finds->poid;?>" name="poid" id="poid" class="form-control searchs"  />
								</div>
							</div>
						</div>
					</div>
					<div class="row mtop10">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4">Khách hàng(<span class="red">*</span>)</label>
								<div class="col-md-8">
									<span id="loadCustomer">
										<select id="customerid" name="customerid" class="combos" >
											<option value=""></option>
											<?php foreach($customers as $item){
												if($finds->customer_id != $item->id){
													continue;
												}
												?>
												<option value="<?=$item->id;?>"><?=$item->customer_name;?></option>
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
									<?php 
									$datepo =  $finds->datepo;
									if(empty($datepo) || $datepo == '0000-00-00'){
										$datepos =  gmdate(cfdate(), time() + 7 * 3600);;
									}
									else{
										$datepos =  date(cfdate(),strtotime($finds->datepo));
									}
									?>
									<input value="<?=$datepos;?>" type="text" id="datecreate" placeholder="<?=cfdateHtml();?>" name="datecreate" class="form-control searchs" >
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
									<input type="text" name="description" id="description" placeholder="" value="<?=$finds->description;?>" class="searchs form-control" />
								</div>
							</div>
						</div>
					</div><!--E Row-->
					
					<div class="row mtop10" style="display:none;">
						 <div class="col-md-11 bdb mleft12 tcler">
							<i class="fa fa-question-circle-o" aria-hidden="true"></i>
							Thông tin xuất kho
						 </div>
					</div>
					<div class="row mtop10" style="display:none;">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4">Kho xuất</label>
								<div class="col-md-8 ">
									<span id="loadWarehouse">
										<select id="warehouseid" name="warehouseid" class="combos" >
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
										<input <?php if($finds->payments == 1){?>checked<?php }?> type="radio" id="payments_1" name="payments" value="1"  />
										Tiền mặt</label>
									</div>
									<div class="col-md-4">
										<label class="control-label">
										<input <?php if($finds->payments == 2){?>checked<?php }?> type="radio"  id="payments_2" name="payments" value="2"  />
										CK</label>
									</div>
									<div class="col-md-4">
										<label class="control-label">
										<input <?php if($finds->payments == 3){?>checked<?php }?> type="radio"  id="payments_3" name="payments" value="3"  />
										Thẻ</label>
									</div>
								</div>
							</div>
						</div>
					</div><!--E Row-->
					<div class="row mtop10">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4">VAT(%)</label>
								<div class="col-md-8 ">
									<input maxlength="3" type="text" readonly name="vat" id="vat" placeholder="" value="<?=$finds->vat;?>" class="searchs valtotal form-control text-right fm-number" />
								</div>
							</div>
						</div>
					</div><!--E Row-->
					<div class="row mtop10">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4">Thành tiền</label>
								<div class="col-md-8 ">
									<input value="<?=fmNumber($tt);?>" type="text" name="input_total" id="input_total" readonly placeholder="" class="searchs form-control text-right fm-number" />
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
				<li id="viewPrint2">
					<button class="button">
						<i class="fa fa-print"></i>
						<input type="hidden" id="unit" value="" />
						Phiếu nhập
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
		margin-top:15px;
	}
	.thd{
		text-align:center;
	}
</style>
<input id="uniqueid" name="uniqueid" value="<?=$uniqueid;?>" type="hidden" />
<script type="text/javascript" src="<?=url_tmpl();?>fancybox/source/jquery.fancybox.pack.js"></script>  
<link href="<?=url_tmpl();?>fancybox/source/jquery.fancybox.css" rel="stylesheet" />
<script>
	var controller = '<?=base_url().$routes;?>/';
	var csrfHash = '<?=$csrfHash;?>';
	var goodsList = '';
	var inputList = {};
	var cpage = 0;
	var search;
	$(function(){
		init();
		refresh();
		formatNumberKeyUp('fm-number');
		formatNumber('fm-number');
		var isorder = 0;
		
		$('#refresh').click(function(){
			$('.loading').show();
			refresh();
		});
		$('#vat').keyup(function(e){
			 calInputTotal();
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
		clickViewImg();
		actionTemp();
		setDefault();
	});
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
		
		var setuppo = parseFloat('<?=$setuppo;?>');
		if(obj.poid == '' && setuppo == 1){
			$('#poid').focus();
			warning('Mã đơn hàng <?=getLanguage('all','empty')?>'); return false;
		}
		//E So luong
		//S Don gia
		var priceone = {};
		$('.priceone').each(function(e){
			var goodid = $(this).attr('goodid');
			var val = $(this).val();
			priceone[goodid] = val; 
		});
		//Giam gia
		var discount = {};
		$(".discount").each(function(e){
			var goodid = $(this).attr('goodid');
			var val = $(this).val();
			discount[goodid] = val;
		});
		//So ttt
		var sttview = {};
		$(".sttview").each(function(e){
			var goodid = $(this).attr('goodid');
			var val = $(this).val();
			sttview[goodid] = val;
		});
		//E don gia
		var customer_name = $('#customer_name').val();
		if(obj.customerid == ''){
			warning('Khách hàng <?=getLanguage('all','empty')?>'); return false;	
		}
		var input_total = $('#input_total').val();
		var price_prepay = $('#price_prepay').val();
		var token = $('#token').val();
		var idselect = $('#idselect').val();
		var payments = $('input[name=payments]:checked').val();
		var uniqueid = $('#uniqueid').val();
		// return false;
		$(".loading").show();
		var description = $('#description').val();
		var poid = '<?=$finds->poid;?>';
		$.ajax({
			url : controller + func,
			type: 'POST',
			async: false,
			data: {csrf_stock_name:token,search:JSON.stringify(obj),id:id,description:description,quantity:JSON.stringify(quantity),priceone:JSON.stringify(priceone),isorder:isorder,uniqueid:uniqueid,payments:payments,discount:JSON.stringify(discount),sttview:JSON.stringify(sttview),poid:poid},
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
						inputList = {};
						success('Nhập hàng trả lại thành công.');
					}
					else{
						$('#unit').val(obj.status);
						$('#poid').val(obj.poid);
						$('.gridView').html('');
						success('Nhập hàng trả lại thành công.');
						inputList = {};
						printSave(0,obj.status);
						
					}
				}
			},
			error : function(){
				$(".loading").hide();
				error('Nhập hàng trả lại không thành công.'); return false;
			}
		});
	}
	function printSave(id,unit){
		var token = $('#token').val();
		var uniqueid = '<?=$finds->uniqueid;?>';
		$.ajax({
			url : controller + 'getDataPrintPX?unit='+uniqueid,
			type: 'POST',
			async: false,
			data: {csrf_stock_name:token,id:id},
			success:function(datas){
				var object = $.evalJSON(datas); 
				var disp_setting = "toolbar=yes,location=yes,directories=yes,menubar=no,";
			disp_setting += "scrollbars=yes,width=800, height=500, left=0.0, top=0.0";
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
	function clickViewImg(){
		$('#clickViewImg').click(function(){
			 var url = $(this).attr('src');
			 viewImg(url);
		});
		$('.tgrid').each(function(){
			$(this).click(function(){ 
				 var url = $(this).attr('url');
				 //viewImg(url);
				var htmlImg = '<img id="clickViewImg" alt="Hình ảnh" style ="width:80px; height:90px;" src= '+url+' />';
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
	function setDefault(){
		var warehouseDefault = '<?=$finds->warehouseid;?>';
		var customerid = '<?=$finds->customer_id;?>';
		$('#customerid').multipleSelect('setSelects',[customerid]);
		$('#warehouseid').multipleSelect('setSelects',[warehouseDefault]);
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
			});
		});
		$('.priceone').each(function(idx){
			$(this).on('change',function(){
				var goodid = $(this).attr('goodid'); 
				var priceone = $(this).val();
				setPrice(idx)
			});
		});
		//Update so luong
		$('.quantity').each(function(idx){
			$(this).on('click',function(){
				var goodid = $(this).attr('goodid'); 
				var quantity = $(this).val();
				//Tinh tien
				setPrice(idx)
			});
			$(this).on('keyup',function(){
				var goodid = $(this).attr('goodid'); 
				var quantity = $(this).val();
				var max = $(this).attr('max'); 
				if(parseFloat(max) < quantity){
					$(this).val(max); return false;
				}
				setPrice(idx);
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
		$('.price').eq(idx).val(formatOne(priceone*quantity));
	}
	function calInputTotal(){
		var total = 0; 
		$('.priceone').each(function(inx){
			var price = $(this).val();
			if(price == ''){
				price = '0';
			}
			var quantity = $('.quantity').eq(inx).val();
			if(quantity == ''){
				quantity = '0';
			}
			var discount = $('.discount').eq(inx).val();
			if(discount == ''){
				discount = 0;
			}
			else{
				discount = parseFloat(discount);
			}
			price = parseFloat(price.replace(/[^0-9+\-Ee.]/g, ''));
			quantity = parseFloat(quantity.replace(/[^0-9+\-Ee.]/g, ''));
			var tPrice = (quantity * price) - discount;
			total+= tPrice;
		});
		var vat = $('.valtotal').val();
		if(vat != ''){
			vat = parseFloat(vat.replace(/[^0-9+\-Ee.]/g, ''));
			if(vat > 100){ 
				val = 100; 
				$('.valtotal').val(val);
			}
		}
		else{
			vat = 0;
		}
		var cfnumber = parseFloat('<?=cfnumber()?>');
		var allTotal = (vat * total / 100) + total;
		allTotal = allTotal.toFixed(cfnumber);
		$("#input_total").val(formatOne(allTotal));
		//$("#price_prepay").val(formatOne(allTotal));
		$(".ttprice").html(formatOne(allTotal));
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
		$('#customerid').multipleSelect({
			filter: true,
			placeholder:'Chọn khách hàng',
			single: true
		});
		$('#warehouseid').multipleSelect({
			filter: true,
			placeholder:'Chọn kho',
			single: true
		});
		$('#employeeid').multipleSelect({
			filter: true,
			placeholder:'Chọn nhân viên',
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
		csrfHash = $('#token').val();
		$('#quantity').val(1);
		$('#payments').multipleSelect('setSelects',[1]);	
		$('.loading').hide();
	}
</script>
<script src="<?=url_tmpl();?>assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
