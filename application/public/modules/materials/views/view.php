<style title="" type="text/css">
	table col.c1 { width: 70px; }
	table col.c2 { width: 50px; }
	table col.c3 { width: 50px; }
	table col.c4 { width: 110px;}
	table col.c5 { width: 170px;}
	table col.c6 { width: 150px;}
	table col.c7 { width: 90px;}
	table col.c8 { width: 90px;}
	table col.c9 { width: 115px;}
	table col.c10 { width: 115px;}
	table col.c11 { width: 100px;}
	table col.c12 { width: 110px;}
	table col.c13 { width: 100px;}
	table col.c14 { width: 150px;}
	table col.c15 { width: 80px;}
	table col.c16 { width: 60px;}
	table col.c17 { width: 160px;}
	table col.c18 { width: auto;}
	.col-md-4{ white-space: nowrap !important;}
</style>
<script type="text/javascript" src="<?=url_tmpl();?>fancybox/source/jquery.fancybox.pack.js"></script>  
<link href="<?=url_tmpl();?>fancybox/source/jquery.fancybox.css" rel="stylesheet" />
<div class="row">
	<?=$this->load->inc('breadcrumb');?>
</div>
<div class="portlet box blue mtop0">
	<div class="portlet-title">
		<div class="caption caption2">
			 <div class="brc mtop3"><i class="fa fa-bars"></i> <?=getLanguage('tim-thay');?> <span class="semi-bold viewtotal">0</span> <?=getLanguage('nguyen-phu-lieu');?></div>	
		</div>
		<div class="tools">
			<ul class="button-group pull-right"  style="margin-top:-5px; margin-bottom:5px;">
				<li id="search">
					<button class="button">
						<i class="fa fa-search"></i>
						<?=getLanguage('tim-kiem')?>
					</button>
				</li>
				<li id="refresh" >
					<button class="button">
						<i class="fa fa-refresh"></i>
						<?=getLanguage('lam-moi')?>
					</button>
				</li>
				<?php if(isset($permission['add'])){?>
				<li id="save" data-toggle="modal" data-target="#myModalFrom">
					<button class="button">
						<i class="fa fa-plus"></i>
						<?=getLanguage('them-moi')?>
					</button>
				</li>
				<?php } ?>
				<?php if(isset($permission['edit'])){?>
				<li id="edit" data-toggle="modal" data-target="#myModalFrom">
					<button class="button">
						<i class="fa fa-save"></i>
						<?=getLanguage('sua')?>
					</button>
				</li>
				<?php } ?>
				<?php if(isset($permission['import'])){?>
				<li id="import">
					<button class="button">
						<i class="fa fa-plus"></i>
						<?=getLanguage('import')?>
					</button>
				</li>
				<?php } ?>
				<?php if(isset($permission['delete'])){?>
				<li id="delete">
					<button class="button">
						<i class="fa fa-times"></i>
						<?=getLanguage('xoa')?>
					</button>
				</li>
				<?php } ?>
				<!--<li id="import">
					<a title="Nhập từ excel" class="" id="importgoods" data-toggle="modal" data-target="#myFrom" href="#">
						<button class="button">
							<i class="fa fa-arrow-up"></i>
							Nhập từ excel
						</button>
					</a>
				</li>-->
				<li id="export">
					<button class="button">
						<i class="fa fa-file-excel-o"></i>
						<?=getLanguage('export')?>
					</button>
				</li>
			</ul>
		</div>
	</div>
	<div class="portlet-body">
		<div class="portlet-body">
        	<div id="gridview" >
				<table class="resultset" id="grid"></table>
				<!--header-->
				<div id="cHeader">
					<div id="tHeader">    	
						<table id="tbheader" width="100%" cellspacing="0" border="1" >
							<?php for($i=1; $i< 19; $i++){?>
								<col class="c<?=$i;?>">
							<?php }?>
							<tr>	
								<th></th>
								<th><input type="checkbox" name="checkAll" id="checkAll" /></th>
								<th><?=getLanguage('stt')?></th>								
								<th id="ord_c.goods_code"><?=getLanguage('ma-hang-hoa')?></th>
								<th id="ord_c.goods_name"><?=getLanguage('ten-hang-hoa')?></th>
								<th id="ord_p.goods_tye_name"><?=getLanguage('loai-nguyen-phu-lieu')?></th>
								<th id="ord_ut.unit_name"><?=getLanguage('don-vi-tinh')?></th>
								<th><?=getLanguage('hinh-anh')?></th>
								<th id="ord_c.buy_price"><?=getLanguage('gia-nhap')?> (<?=configs()['currency'];?>)</th>
								<th id="ord_c.sale_price"><?=getLanguage('gia-xuat')?> (<?=configs()['currency'];?>)</th>
								<th id="ord_c.madein"><?=getLanguage('xuat-xu')?></th>
								<th id="ord_c.discountsales"><?=getLanguage('hoa-hong')?></th>
								<th id="ord_c.discounthotel_dly"><?=getLanguage('chiet-khau')?></th>
								<th id="ord_c.description"><?=getLanguage('ghi-chu')?></th>
								<th id="ord_c.quantitymin"><?=getLanguage('tk-toi-thieu')?></th>
								<th id="ord_c.shelflife"><?=getLanguage('hsd')?></th>
								<th id="ord_c.exchange_unit"><?=getLanguage('don-vi-qui-doi')?></th>
								<th></th>
							</tr>
						</table>
					</div>
				</div>
				<!--end header-->
				<!--body-->
				<div id="data">
					<div id="gridView">
						<table id="tbbody" width="100%" cellspacing="0" border="1">
							<?php for($i=1; $i < 19; $i++){?>
								<col class="c<?=$i;?>">
							<?php }?>
							<tr class="row-search">
								<td></td>
								<td></td>
								<td></td>
								<td>
									<input type="text" name="goods_code" id="goods_code" class="searchs form-control " />
								</td>
								<td>
									<input type="text" name="goods_name" id="goods_name" class="searchs form-control " />
								</td>
								<td>
									<select id="goods_type" name="goods_type" class="combos">
										<?php foreach($goodstypes as $item){?>
											<option value="<?=$item->id;?>"><?=$item->goods_tye_name;?></option>
										<?php }?>
									</select>
								</td>
								<td>
									<select id="unitid" name="unitid" class="combos">
										<?php foreach($units as $item){?>
											<option value="<?=$item->id;?>"><?=$item->unit_name;?></option>
										<?php }?>
									</select>
								</td>
								<td></td>
								<td>
									<input type="text" name="buy_price" id="buy_price" class="searchs form-control " />
								</td>
								<td>
									<input type="text" name="sale_price" id="sale_price" class="searchs form-control " />
								</td>
								<td>
									<input type="text" name="madein" id="madein" class="searchs form-control " />
								</td>
								<td>
									<input type="text" name="discountsales" id="discountsales" class="searchs form-control" />
								</td>
								<td></td>
								<td>
									<input type="text" name="description" id="description" class="searchs form-control" />
								</td>
								<td>
									<input type="text" name="quantitymin" id="quantitymin" class="searchs form-control" />
								</td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tbody id="grid-rows"></tbody>
						</table>
					</div>
				</div>
				<!--end body-->				
			</div>
		</div>
		<div class="portlet-body">
			<div class="fleft" id="paging"></div>
        </div>
	</div>		
</div>
<!-- END PORTLET-->
<div class="loading" style="display: none;">
	<div class="blockUI blockOverlay" style="width: 100%;height: 100%;top:0px;left:0px;position: absolute;background-color: rgb(0,0,0);opacity: 0.1;z-index: 9999000;">
	</div>
	<div class="blockUI blockMsg blockElement" style="width: 30%;position: absolute;top: 15%;left:35%;text-align: center;">
		<img src="<?=url_tmpl()?>img/ajax_loader.gif" style="z-index: 2;position: absolute; z-index: 9999000;"/>
	</div>
</div>
 <!-- Modal -->
<div class="modal fade" id="myFrom" role="dialog">
	<div class="modal-dialog">
	  <!-- Modal content-->
	  <div class="modal-content">
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
		  <h4 class="modal-title"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Nhập hàng hóa từ excel</h4>
		</div>
		<div class="modal-body">
			<!--Content-->
			<input style="display:none;"  name="myfileImmport" id="myfileImmport" type="file"/>
			<ul class="button-group" style="margin:0px;">
				<li class="" onclick="javascript:document.getElementById('myfileImmport').click();">
				<button class="btnone" type="button">
				Chọn file</button>
				</li>
			</ul><br>
			<span class="red">*</span> Lưu ý: <br>
			- File mẩu xuất excel từ chương trình <br>
			- Cột "Tính hoa hồng": <br>
				&nbsp;&nbsp;&nbsp;+ Nếu tính hoa hồng <span style="color:#39F">là % thêm % sau giá bán</span> VD: 5%<br>
				&nbsp;&nbsp;&nbsp;+ Nếu tính hoa hồng <span style="color:#39F">là tiền mặt ghi số tiền</span> VD: 5.000<br>
			- Mã hàng, tên hàng hóa, loại hàng hóa, ĐVT: Không đươc trống

			
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
		<div id="viewImg-form-gridview" >
			
		</div>
	</div>
</div>
<!-- view Img -->
<!--S Modal -->
<div id="myModalFrom" class="modal fade" role="dialog">
  <div class="modal-dialog w900">
    <!-- Modal content-->
    <div class="modal-content ">
      <!--<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="modalTitleFrom"></h4>
      </div>-->
      <div id="loadContentFrom" class="modal-body">
      </div>
      <div class="modal-footer">
		 <button id="actionSave" type="button" class="btn btn-info" ><i class="fa fa-save" aria-hidden="true"></i>  <?=getLanguage('luu');?></button>
        <button id="close" type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> <?=getLanguage('dong');?></button>
      </div>
    </div>
  </div>
</div>
<!--E Modal -->
<!--S Modal -->
<div id="myModalFromType" class="modal fade" role="dialog">
  <div class="modal-dialog w500">
    <!-- Modal content-->
    <div class="modal-content ">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="modalTitleFromType"><?=getLanguage('them-loai-nguyen-phu-lieu');?></h4>
      </div>
      <div id="loadContentFromType" class="modal-body">
		  <!--S Content-->
		  <!--E Content-->
      </div>
      <div class="modal-footer">
		 <button id="actionSaveType" type="button" class="btn btn-info" ><i class="fa fa-save" aria-hidden="true"></i>  <?=getLanguage('luu');?></button>
        <button id="close" type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> <?=getLanguage('dong');?></button>
      </div>
    </div>
  </div>
</div>
<!--E Modal -->
<input type="hidden" name="id" id="id" />
<script>
	var controller = '<?=base_url().$routes;?>/';
	var csrfHash = '<?=$csrfHash;?>';
	var cpage = 0;
	var search;
	$(function(){
		//$('#discounthotel_type_1').prop('checked',true);
		//$('#discounthotel_type_dly_1').prop('checked',true);
		//$('#isnegative').prop('checked', false);   
		init();
		refresh();
		formatNumber('fm-number');
		formatNumberKeyUp('fm-number');
		$('#search').click(function(){
			$(".loading").show();
			searchList();	
		});
		$('#refresh').click(function(){
			$('.loading').show();
			refresh();
		});
		$('#export').click(function(){
			window.location = controller + 'export?search='+getSearch();
		});
		$('#actionSaveType').live('click',function(){
			var goods_tye_names = $('#goods_tye_names').val();
			var goods_type_group = $('#goods_type_groups').val();
			if(goods_tye_names == ''){
				 error("Loại hàng hóa không được trống"); return false;
			}
			$.ajax({
				url : controller + 'addCatalog',
				type: 'POST',
				async: false,
				data: {goods_tye_name:goods_tye_names,goods_type_group:goods_type_groups},
				success:function(datas){
					var obj = $.evalJSON(datas); 
					if(obj.status == 0){
						 error("Thêm mới không thành công"); 
					}
					else if(obj.status == -1){
						 error("Loại hàng hóa đã tồn tại"); 
					}
					else{
						$('#loadgoodstype').html(obj.content);
						success("Thêm mới thành công");
					}
				}
			});
		});
		/*
		$('#addUnit').live('click',function(){
			var txtUnit = $('#txtUnit').val();
			if(txtUnit == ''){
				 error("Đơn vị tính không được trống"); return false;
			}
			$.ajax({
				url : controller + 'addUnit',
				type: 'POST',
				async: false,
				data: {txtUnit:txtUnit},
				success:function(datas){
					var obj = $.evalJSON(datas); 
					if(obj.status == 0){
						 error("Đơn vị tính đã tồn tại"); 
					}
					else{
						$('#loadunit').html(obj.content);
						$('#unitid').multipleSelect({
							filter: true,
							placeholder:'Chọn đơn vị tính',
							single: true,
							plus:true,
							idplus:'addUnit',
							idtxt:'txtUnit',
							src:'<?=url_tmpl();?>img/plus.png'
						});
						$("#unitid").multipleSelect("setSelects", [obj.idadd]);
					}
				}
			});
		});*/
		$('#addGoods').click(function(){
			importExcel();
		});
		//$('#isserial').multipleSelect('setSelects',[0]);
		//$('#shelflife').multipleSelect('setSelects',[0]);
		$('#save').click(function(){
			$('#id').val('');
			loadForm();
		});
		$('#edit').click(function(){
			var id = $('#id').val();
			if(id == ''){
				warning(cldcs);
				return false;
			} 
			loadForm(id);
		});
		$("#delete").click(function(){
			var id = getCheckedId();
			if(id == ''){ return false;}
			confirmDelete(id);
			return false
		});
		$(document).keypress(function(e) {
			 var id = $("#id").val();
			 if (e.which == 13) {
				$(".loading").show();
				searchList();
			 }
		});
		$('#actionSave').click(function(){
			save();
		});	
		searchFunction();
	});
	function searchFunction(){
		$("#goods_code,#goods_name,#buy_price,#sale_price,#discountsales,#madein,#description,#quantitymin").keyup(function() {
			searchList();	
		});
	}
	function loadForm(id){
		$.ajax({
			url : controller + 'form',
			type: 'POST',
			async: false,
			data:{id:id},  
			success:function(datas){
				var obj = $.evalJSON(datas); 
				$('#loadContentFrom').html(obj.content);
				$('#modalTitleFrom').html(obj.title);
				$('#input_distric_name').select();
				$('#id').html(obj.id);
			}
		});
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
				if(obj.status == 0){
					error(obj.content); return false;	
				}
				else{
					success(obj.content);
					$('.close').click();
					refresh();
					return false;	
				}
				$('#loads').hide();
			}
		});
	}
	function save(){
		var id = $('#id').val(); 
		var func = 'save';
		if(id != ''){
			func = 'edit';
		}
		var search = getFormInput();
		var obj = $.evalJSON(search); 
		if(obj.pay_type_name == ''){
			warning("<?=getLanguage('loai-phieu-chi')?>"); return false;	
		}
		if(obj.goods_code == ''){
			//$('#goods_code').focus();
			warning('Mã hàng hóa <?=getLanguage('empty')?>'); return false;	
		}
		if(obj.goods_name == ''){
			//$('#goods_name').focus();
			warning('Tên hàng hóa <?=getLanguage('empty')?>'); return false;	
		}
		if(obj.unitid == ''){
			warning('Chọn đơn vị tính'); return false;	
		}
		var locationid = getCombo('locationid');
		if(locationid  != ''){
			var arrlocationid = locationid.split(',');
			if(arrlocationid.length  > 1){
				 warning('Chọn tối đa một vị trí'); return false;
			}
		}
		if(locationid  == '-1'){
			warning('Vị trí không phù hợp'); return false;
		}
		$('.loading').show();
		//Hoa hong dai ly
		var exchange_unit = getCombo('exchange_unit');
		var token = $('#token').val();
		var materials = ''; 
		var data = new FormData();
		var objectfile = document.getElementById('imageEnable').files;
		data.append('userfile', objectfile[0]);
		data.append('search', search);
		data.append('materials', materials);
		data.append('exchange_unit', exchange_unit);
		data.append('id',id);
		$.ajax({
			url : controller + func,
			type: 'POST',
			async: false,
			data: data,
			enctype: 'multipart/form-data',
			processData: false,  
			contentType: false,   
			success:function(datas){
				var obj = $.evalJSON(datas); 
				$('.loading').hide();
				$("#token").val(obj.csrfHash);
				if(obj.status == 0){
					if(id == ''){
						error(tmktc); return false;	
					}
					else{
						error(sktc); return false;	
					}
				}
				else if(obj.status == -1){
					error(dldtt); return false;		
				}
				else if(obj.status == -2){
					error("<?=getLanguage('ma-hang-hoa-khong-hop-le')?>"); return false;		
				}
				else{
					if(id == ''){
						success(tmtc); 
					}
					else{
						success(stc); 
					}
					refresh();
				}
			},
			error : function(){
				$('.loading').hide();
				if(id == ''){
					error(tmktc); return false;	
				}
				else{
					error(sktc); return false;	
				}
			}
		});
	}
	function init(){
		//$('#goods_code').focus();
		$('#goods_type').multipleSelect({
			filter: true,
			single: false,
			placeholder: "<?=getLanguage('chon-loai-nguyen-phu-lieu')?>",
			onClick: function(view){
				searchList();
			}
			//plus:true,
			//idplus:'addCatalog',
			//idtxt:'txtCatalog',
			//src:'<?=url_tmpl();?>img/plus.png'
		});
		$('#discounthotel_type').multipleSelect({
			filter: true,
			single: false,
			placeholder:  "<?=getLanguage('chon-loai')?>"
		});
		$('#shelflife').multipleSelect({
			filter: true,
			single: false,
			placeholder:  "<?=getLanguage('chon-loai')?>"
		});
		$('#isserial').multipleSelect({
			filter: true,
			single: true,
			placeholder:  "<?=getLanguage('chon-loai')?>"
		});
		$('#unitid').multipleSelect({
			filter: true,
			placeholder: "<?=getLanguage('chon-don-vi-tinh')?>",
			single: false,
			onClick: function(view){
				searchList();
			}
			//plus:true,
			//idplus:'addUnit',
			//idtxt:'txtUnit',
			//src:'<?=url_tmpl();?>img/plus.png',
			//onClick: function(view){
				/*var unitid = getCombo('unitid');
				var texts = getComboText('unitid');
				$.ajax({
					url : controller + 'getUnitChange',
					type: 'POST',
					async: false,
					data: {unitid:unitid}, 
					success:function(datas){
						$('#loadunitChange').html(datas);
						$("#exchange_unit").multipleSelect({
							filter: true,
							placeholder:'Chọn đơn vị',
							single: false,
							idtxt:'txtTime',
							textbox:1,
							textboxpln:'='+texts,
							textboxtitle:'Quy đổi đơn vị',
							textboxwidth:60,
							textboxid:'exchange_unit_',
							onClick: function(view){
								
							}
						});	
						$('#exchange_unit').multipleSelect('uncheckAll');
					}
				});*/
			//}
		});
		$('#locationid').multipleSelect({
			filter: true,
			placeholder: "<?=getLanguage('chon-vi-tri')?>",
			// single: true
		});
		$('#isnegative').multipleSelect({
			filter: true,
			placeholder: "<?=getLanguage('chon-loai')?>"
		});
	}
    function funcList(obj){
		$('.edit').each(function(e){
			$(this).click(function(){ 
				 var goods_code = $('.goods_code').eq(e).html().trim();
				 var goods_name = $('.goods_name').eq(e).html().trim();
				 var description = $('.description').eq(e).html().trim();

				 var buy_price = $('.buy_price').eq(e).html().trim();
				 var sale_price = $(this).attr('sale_price');
				 var quantitymin = $('.quantitymin').eq(e).html().trim();
				 
				 var madein = $('.madein').eq(e).html().trim();
				 //ar goods_code2 = $('.goods_code2').eq(e).html().trim();
				 
				 var id = $(this).attr('id');
				 var goods_type = $(this).attr('goods_type');
				 var discounthotel_type = $(this).attr('discounthotel_type');
				 var isnegative = $(this).attr('isnegative');
				 var unitid = $(this).attr('unitid');
				 var locationid =  $(this).attr('locationid');
				 var isserial =  $(this).attr('isserial');
				 var shelflife = $(this).attr('shelflife');
				 
				 var discountsales = $(this).attr('discountsales');
				 var discounthotel_type = $(this).attr('discounthotel_type');
				 var discounthotel_dly = $(this).attr('discounthotel_dly');
				 var discounthotel_type_dly = $(this).attr('discounthotel_type_dly');
				 var exchange_unit = $(this).attr('exchange_unit');
				 
				 $('#id').val(id);	
				 $('#goods_code').val(goods_code);
				 $('#goods_name').val(goods_name);
				 $('#description').val(description);
				 $('#discountsales').val(discountsales);
				 $('#discounthotel_dly').val(discounthotel_dly);
				 $('#madein').val(madein);
				 $('#buy_price').val(buy_price);
				 $('#sale_price').val(sale_price);
				 //$('#vat').val(vat);
				 $('#locationid').multipleSelect('setSelects',[locationid]);
				 //$('#goods_code2').val(goods_code2);
				 $('#quantitymin').val(quantitymin);
				 
				 $('#goods_type').multipleSelect('setSelects', goods_type.split(','));
				 //$('#discounthotel_type').multipleSelect('setSelects', discounthotel_type.split(','));
				 $('#unitid').multipleSelect('setSelects', unitid.split(','));
				 $('#isserial').multipleSelect('setSelects', isserial.split(','));
				 $('#shelflife').multipleSelect('setSelects', shelflife.split(','));
				 
				 //Quy doi don vi
				 var texts = getComboText('unitid');
				 $.ajax({
					url : controller + 'getUnitChange',
					type: 'POST',
					async: false,
					data: {unitid:unitid}, 
					success:function(datas){
						$('#loadunitChange').html(datas);
						$("#exchange_unit").multipleSelect({
							filter: true,
							placeholder:'Chọn đơn vị',
							single: false,
							idtxt:'txtTime',
							textbox:1,
							textboxpln:'='+texts,
							textboxtitle:'Quy đổi đơn vị',
							textboxwidth:60,
							textboxid:'exchange_unit_',
							onClick: function(view){
								
							}
						});	
						$('#exchange_unit').multipleSelect('setSelects', exchange_unit.split(','));
					}
				});
			});
			function getIDChecked(){
				return 1;	
			} 
		});	
		$(".viewImg").each(function(e) {
			$(this).click(function() {
				var id = $(this).attr('id');
				viewImg(id);
			});
		});
		$('.edititem').each(function(e){
			$(this).click(function(){
				var id = $(this).attr('id');
				loadForm(id);
			});
		});
		$('.deleteitem').each(function(e){
			$(this).click(function(){
				var id = $(this).attr('id');
				confirmDelete(id);
				return false
			});
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
				$('#viewImg-form-gridview').html('<img style="width:600px; height:500px;" src="<?=base_url();?>files/goods/'+url+'" />');
			}
		});
    }
	function refresh(){
		$('.loading').show();
		$('.searchs').val('');		
		csrfHash = $('#token').val();
		$('select.combos').multipleSelect('uncheckAll');
		search = getSearch();
		getList(cpage,csrfHash);	
	}
	function searchList(){
		search = getSearch();
		csrfHash = $('#token').val();
		getList(0,csrfHash);	
	}
</script>

