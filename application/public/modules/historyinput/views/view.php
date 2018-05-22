<style title="" type="text/css">
	table col.c1 { width: 50px; }
	table col.c2 { width: 50px; }
	table col.c3 { width: 115px;}
	table col.c4 { width: 300px;}
	table col.c5 { width: 80px;}
	table col.c6 { width: 100px;}
	table col.c7 { width: 100px;}
	table col.c8 { width: 110px;}
	table col.c9 { width: 100px;}
	table col.c10 { width: 150px;}
	table col.c11 { width: 150px;}
	table col.c12 { width: 90px;}
	table col.c13 { width: 150px;}
	table col.c14 { width: 110px;}
	table col.c15 { width: 150px;}
	table col.c16 { width: 120px;}
	table col.c17 { width: auto;}
	.col-md-4{ white-space: nowrap !important;}
</style>

<!-- BEGIN PORTLET-->
<div class="row">
	<?=$this->load->inc('breadcrumb');?>
</div>	
<div class="portlet box blue mtop0">
	<div class="portlet-title portlet-title2">
		<div class="caption caption2">
			<div class="brc mtop3"><i class="fa fa-bars"></i> <?=getLanguage('tim-thay');?> <span class="semi-bold viewtotal">0</span> <?=getLanguage('phieu-nhap-kho');?></div>	
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
						<li>
							<a id="export">
								<button class="button">
									<i class="fa fa-file-excel-o"></i>&nbsp;<?=getLanguage('excel')?>
								</button>
							</a>
						</li>
						<?php if(isset($permission['delete'])){?>
						<li id="delete">
							<button class="button">
								<i class="fa fa-times"></i>&nbsp; <?=getLanguage('xoa')?>
							</button>
						</li>
						<?php } ?>
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
							<?php for($i=1; $i < 18; $i++){?>
								<col class="c<?=$i;?>">
							<?php }?>
							<tr>
								<th ><input type="checkbox" name="checkAll" id="checkAll" /></th>
								<th ><?=getLanguage('stt')?></th>
								<th id="ord_c.poid"><?=getLanguage('ma-phieu-nhap');?></th>
								<th id="ord_g.goods_name"><?=getLanguage('hang-hoa');?></th>
								<th id="ord_c.quantity"><?=getLanguage('so-luong');?></th>
								<th id="ord_c.price_total"><?=getLanguage('thanh-tien');?></th>
								<th id="ord_c.price_prepay_value"><?=getLanguage('tam-ung');?></th>
								<th id="ord_c.price_prepay_value"><?=getLanguage('da-thanh-toan');?></th>
								<th ><?=getLanguage('con-no')?></th>
								<th id="ord_c.supplierid"><?=getLanguage('nha-cung-cap');?></th>
								<th id="ord_c.payments"><?=getLanguage('ht-thanh-toan');?></th>
								<th id="ord_c.datepo"><?=getLanguage('ngay-nhap');?></th>
								<th id="ord_c.description"><?=getLanguage('ghi-chu');?></th>
								<th id="ord_c.usercreate"><?=getLanguage('nguoi-tao');?></th>
								<th id="ord_c.datecreate"><?=getLanguage('ngay-tao');?></th>
								<th ></th>
								<th ></th>
							</tr>
						</table>
					</div>
				</div>
				<!--end header-->
				<!--body-->
				<div id="data">
					<div id="gridView">
						<table id="tbbody" width="100%" cellspacing="0" border="1">
							<?php for($i=1; $i < 18; $i++){?>
								<col class="c<?=$i;?>">
							<?php }?>
							<tr class="row-search">
								<td></td>
								<td></td>
								<td>
									<input type="text" name="poid" id="poid" class="searchs form-control" />
								</td>
								<td>
									<input type="text" name="goods_name" id="goods_name" class="searchs form-control" />
								</td>
								<td>
									<input type="text" name="quantity" id="quantity" class="searchs form-control" />
								</td>
								<td>
									<input type="text" name="price_total" id="price_total" class="searchs form-control" />
								</td>
								<td>
									<input type="text" name="price_prepay_value" id="price_prepay_value" class="searchs form-control" />
								</td>
								<td></td>
								<td></td>
								<td>
									<div class="row">
										<div class="col-md-12">
											<select id="supplierid" name="supplierid" class="combos" >
												<?php foreach($suppliers as $item){?>
													<option value="<?=$item->id;?>"><?=$item->supplier_name;?></option>
												<?php }?>
											</select>
										</div>
									</div>
								</td>
								<td>
									<div class="row">
										<div class="col-md-12">
											<select id="payments" name="payments" class="combos" >
												<option value="1"><?=getLanguage('tien-mat');?></option>
												<option value="2"><?=getLanguage('chuyen-khoan');?></option>
											</select>
										</div>
									</div>
								</td>
								<td>
									 <div class="col-md-12" data-date-format="dd/mm/yyyy" style="display:inline-flex; padding-left:0; padding-right:25px;">
										<input style="float:left; text-align:center;" placeholder="Chọn ngày" type="text" id="datepo" placeholder="dd/mm/yyyy" name="datepo" class="form-control searchs" value="<?=$fromdates;?> - <?=$todates;?>" >
										<span class="input-group-btn" >
											<button class="btn default btn-picker datepoClick" type="button"><i class="fa fa-calendar "></i></button>
										</span>
									</div>
								</td>
								<td>
									<input type="text" name="description" id="description" class="searchs form-control" />
								</td>
								<td>
									<input type="text" name="usercreate" id="usercreate" class="searchs form-control" />
								</td> 
								<td>
									<div class="col-md-12" data-date-format="dd/mm/yyyy" style="display:inline-flex; padding-left:0; padding-right:25px;">
										<input style="float:left; text-align:center;" placeholder="Chọn ngày" type="text" id="datecreate" placeholder="dd/mm/yyyy" name="datecreate" class="form-control searchs" value="<?=$fromdates;?> - <?=$todates;?>" >
										<span class="input-group-btn" >
											<button class="btn default btn-picker datecreateClick" type="button"><i class="fa fa-calendar "></i></button>
										</span>
									</div>
								</td>
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
	<div class="blockUI blockOverlay" style="width: 100%;height: 100%;top:0px;left:0px;position: absolute;background-color: rgb(0,0,0);opacity: 0.1;z-index: 1000;">
	</div>
	<div class="blockUI blockMsg blockElement" style="width: 30%;position: absolute;top: 15%;left:35%;text-align: center;">
		<img src="<?=url_tmpl()?>img/ajax_loader.gif" style="z-index: 2;position: absolute;"/>
	</div>
</div> 

<link type="text/css" href="<?=url_tmpl();?>css/daterangepicker.css"  rel="stylesheet">	
<script type="text/javascript" src="<?=url_tmpl();?>js/moment.js"></script>
<script type="text/javascript" src="<?=url_tmpl();?>js/daterangepicker.js"></script>
 <!-- Modal -->
<!--<div class="modal fade" id="myFrom" role="dialog">
	<div class="modal-dialog">
	  <div class="modal-content">
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
		  <h4 class="modal-title"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Nhập kho từ excel</h4>
		</div>
		<div class="modal-body">
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
			- Mã hàng, nhà cung cấp, số lượng, đơn vị tính, thanh toán: Không được trống<br>
			- Sheet chứa dữ liệu là sheet đầu tiên

			
		</div>
		<div class="modal-footer">
		  <button type="button" id="addGoods" class="btn btn-default">
		  <i class="fa fa-save" aria-hidden="true"></i>
		  Lưu</button>
		</div>
	  </div>
	  
	</div>
</div>-->
<!--E My form-->
<script>
	var controller = '<?=base_url().$routes;?>/';
	var csrfHash = '<?=$csrfHash;?>';
	var cpage = 0;
	var search;
	var idselect = '<?=$id;?>';
	var arr = [];
	$(function(){
		init();
		searchList();
		$('#search').click(function(){
			$(".loading").show();
			searchList();	
		});
		$('#refresh').click(function(){
			$('.loading').show();
			refresh();
		});
		$('#save').click(function(){
			save('save','');
		});
		$('#export').click(function(){
			window.location = controller + 'export?search='+getSearch();
		});
		$('#print').click(function(){
			var id = getCheckedId();//$('#id').val();
			print(id);
		});
		$('#delete').click(function(){ 
			var id = getCheckedId();
			if(id == ''){ return false;}
			confirmDelete(id);
			return false
		});
		$('#addGoods').click(function(){
			importExcel();
		});
		$('#downloadfile').click(function(){
			window.location = '<?=base_url();?>files/template/file_mau_nha_kho.xls';
		});
		$(document).keypress(function(e) {
			 var id = $("#id").val();
			 if (e.which == 13) {
				  $(".loading").show();
				  searchList();	
			 }
		});
		$('#datepo,#datecreate').daterangepicker({
			 locale: {
			  format: 'DD/MM/YYYY'
			},
			startDate: '<?=$fromdates;?>',
			endDate: '<?=$todates;?>',
			timePicker: false,
        	timePickerIncrement: 8,
        	showDropdowns: true
			
		});
		$('.datecreateClick').click(function(){
			$('#datepo').click();
		});
		$('.datepoClick').click(function(){
			$('#datepo').click();
		});
		setDefault();
		searchFunction();
	});
	function searchFunction(){
		$("#poid,#goods_name,#quantity,#price_total,#price_prepay_value,#description,#usercreate").keyup(function() {
			searchList();	
		});
		$('#datepo').on('apply.daterangepicker', function(ev, picker) {
			searchList();	
		});
		$('#datecreate').on('apply.daterangepicker', function(ev, picker) {
			searchList();	
		});
	}
	/*function deleteItems(){
		var msg = "<?=getLanguage('ban-muon-xoa-phieu-nhap-nay');?>";
		var id = getCheckedId(); 
		var token = $('#token').val();
		var yess = 'Có';
		var nos = 'Không';
		var texts = msg+'?';
		$.msgBox({
			title:'Message',
			type:'confirm',
			content:texts,
			buttons:[{value:yess},{value:nos}],
			success: function(result) {
				if (result == yess) {
					var token = $('#token').val();			
					$.ajax({
						url : controller + 'deletes',
						type: 'POST',
						async: false,
						data: {csrf_stock_name:token,id:id},
						success:function(datas){
							var obj = $.evalJSON(datas); 
							$('#token').val(obj.csrfHash);
							if(obj.status == -1){
								error('Đơn hàng đã thanh toán bạn không được xóa','Lỗi'); return false;
							}
							if(obj.status == 0){
								error('Xóa không thành công','Lỗi'); return false;
							}
							else{
								success('Xóa thành công','Thông báo');
								refresh();	
							}
						},
						error : function(){
							 error('Xóa không thành công','Lỗi'); return false;
						}
					});

				}
				else{
					return false;
				}
			}
		});
	}*/
	function setDefault(){
		
	}
	function init(){
		/*$( "#goodsnamesearch" ).autocomplete({
			source: function( request, response ) {
				$.ajax( {
					url: controller+"getFindGoodsSearchDes",
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
					}
				} );
			},
			select: function( event, ui ){ 
				event.preventDefault();
				$( "#goodsnamesearch" ).val( ui.item.label); //ui.item is your object from the array
				return false;
			},
			focus: function(event, ui) {
				event.preventDefault();
				$("#goodsnamesearch").val(ui.item.label);
			}
		});
		$( "#goodsidsearch" ).autocomplete({
			source: function( request, response ) {
				$.ajax( {
					url: controller+"getFindGoodsSearch",
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
					}
				} );
			},
			select: function( event, ui ){ 
				event.preventDefault();
				$( "#goodsidsearch" ).val( ui.item.label); //ui.item is your object from the array
				return false;
			},
			focus: function(event, ui) {
				event.preventDefault();
				$("#goodsidsearch").val(ui.item.label);
			}
		});*/
		$('#payments').multipleSelect({
			filter: true,
			placeholder:"<?=getLanguage('chon-hinh-thuc-thanh-toan');?>",
			single: false,
			onClick: function(view) {
				searchList();
			}
		});
		/*
		$('#warehouseid').multipleSelect({
			filter: true,
			placeholder:'Chọn kho',
			single: false,
			onClick: function(view) {
				searchList();
			}
		});*/
		$('#supplierid').multipleSelect({
			filter: true,
			placeholder:"<?=getLanguage('chon-nha-cung-cap');?>",
			single: false,
			onClick: function(view) {
				searchList();
			}
		});
		$('#goods_type').multipleSelect({
			filter: true,
			placeholder:"<?=getLanguage('chon-chung-loai');?>",
			single: false,
			onClick: function(view) {
				searchList();
			}
		});
		/*$('#branchid').multipleSelect({
			filter: true,
			placeholder:'Chọn chi nhánh',
			single: false,
			onClick: function(view) {
				searchList();
			}
		});
		*/
		$('select.combos').multipleSelect('uncheckAll');
	}
	function print(id){
		if(id == ''){ return false;}
		var token = $('#token').val();
		$.ajax({
			url : '<?=base_url();?>inputinventory/' + 'getDataPrint',
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
	$('#printpc').click(function(){
			var id = getCheckedId();
			if(id == ""){
				return false;
			}
			$.ajax({
				url : '<?=base_url();?>inputinventory/' + 'getDataPrintPC',
				type: 'POST',
				async: false,
				data: {id:id},
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
		});
    function funcList(obj){
		$('.edit').each(function(e){
			$(this).click(function(){  
				 var id = $(this).attr('id');
				 var payments = $(this).attr('payments');
				 var warehouseid = $(this).attr('warehouseid');
				 var supplierid = $(this).attr('supplierid');
				 //
				 $('#payments').multipleSelect('setSelects', payments.split(','));
				 $('#warehouseid').multipleSelect('setSelects', warehouseid.split(','));
				 $('#supplierid').multipleSelect('setSelects', supplierid.split(','));
				 
				 var uniqueid = $(this).attr('uniqueid');
				 $('.loading').hide();
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
				var msg = "<?=getLanguage('ban-muon-xoa-phieu-nhap-nay');?>";
				deleteItems(msg);
			});
		});
	}
	function refresh(){
		$('.loading').show();
		$('.searchs').val('');		
		csrfHash = $('#token').val();
		$('select.combos').multipleSelect('uncheckAll');
		$('#customer_type').multipleSelect('setSelects',[1]);
		//$('#goodsidsearch').multipleSelect('uncheckAll');
		$('#quantity').val(1);
		search = getSearch();
		getList(cpage,csrfHash);	
	}
	function searchList(){
		search = getSearch();
		csrfHash = $('#token').val();
		getList(0,csrfHash);	
	}
</script>
