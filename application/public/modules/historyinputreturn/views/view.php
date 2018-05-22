<style title="" type="text/css">
	table col.c1 { width: 50px; }
	table col.c2 { width: 50px; }
	table col.c3 { width: 130px;}
	table col.c4 { width: 250px;}
	table col.c5 { width: 90px;}
	table col.c6 { width: 115px;}
	table col.c7 { width: 115px;}
	table col.c8 { width: 115px;}
	table col.c9 { width: 120px;}
	table col.c10 { width: 110px;}
	table col.c11 { width: 110px;}
	table col.c12 { width: 150px;}
	table col.c13 { width: auto;}
	.col-md-4{ white-space: nowrap !important;}
</style>

<!-- BEGIN PORTLET-->
<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
			<?=$this->load->inc('breadcrumb');?>
		</div>
		<div class="tools">
			<a href="javascript:;" class="collapse">
			</a>
		</div>
	</div>
	<div class="portlet-body">
		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4">Chi nhánh </label>
					<div class="col-md-8">
						<select id="branchid" name="branchid" class="combos" >
							<?php foreach($branchs as $item){?>
								<option  value="<?=$item->id;?>"><?=$item->branch_name;?></option>
							<?php }?>
						</select>
					</div>
				</div>
			</div>
			
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4">Nhà cung cấp</label>
					<div class="col-md-8">
						<select id="supplierid" name="supplierid" class="combos" >
							<?php foreach($suppliers as $item){?>
								<option value="<?=$item->id;?>"><?=$item->supplier_name;?></option>
							<?php }?>
						</select>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4">Thanh toán</label>
					<div class="col-md-8">
						<select id="payments" name="payments" class="combos" >
							<option value="1">Tiền mặt</option>
							<option value="2">Chuyển khoản</option>
							<option value="3">Thẻ</option>
						</select>
					</div>
				</div>
			</div>
		</div>
		<div class="row mtop10">
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4">Mã đơn hàng</label>
					 <div class="col-md-8">
						<input type="text" id="poid" placeholder="Nhập mã đơn hàng" name="poid" class="form-control searchs" >
                    </div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4">Từ ngày</label>
					 <div class="col-md-8 input-group date date-picker" data-date-format="<?=cfdateHtml();?>">
						<input value="<?=$fromdate;?>" type="text" id="formdate" placeholder="<?=cfdateHtml();?>" name="formdate" class="form-control searchs" >
                        <span class="input-group-btn ">
                            <button class="btn default btn-picker" type="button"><i class="fa fa-calendar "></i></button>
                        </span>
                    </div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4">Đến ngày</label>
					 <div class="col-md-8 input-group date date-picker" data-date-format="<?=cfdateHtml();?>">
						<input type="text" id="todate" placeholder="<?=cfdateHtml();?>" name="todate" value= "<?=$todates;?>" class="form-control searchs" >
                        <span class="input-group-btn ">
                            <button class="btn default btn-picker" type="button"><i class="fa fa-calendar "></i></button>
                        </span>
                    </div>
				</div>
			</div>
		</div>
		<div class="row mtop10">
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4">Mã hàng</label>
					<div class="col-md-8">
						<input type="text" id="goodsidsearch" placeholder="Nhập mã hàng" name="goodsidsearch" class="form-control searchs" >
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4">Tên hàng</label>
					<div class="col-md-8">
						<input type="text" id="goodsnamesearch" placeholder="Nhập tên hàng" name="goodsnamesearch" class="form-control searchs" >
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4">Phân loại</label>
					<div class="col-md-8">
						<select id="goods_type" name="goods_type" class="combos" >
							<?php
							foreach($goodsType as $item){?>
								<option value="<?=$item->id;?>"><?=$item->goods_tye_name;?></option>
							<?php }?>
						</select>
					</div>
				</div>
			</div>
		</div>
		<div class="row mtop10">
			<div class="col-md-12">
				<div class="mright10" >
					<input type="hidden" name="id" id="id" />
					<input type="hidden" name="idselect" id="idselect" value="<?=$id;?>" />
					<input type="hidden" id="token" name="<?=$csrfName;?>" value="<?=$csrfHash;?>" />
					<!--<ul class="button-group pull-right">
						
					</ul>-->
				</div>		
			</div>
		</div>
	</div>
</div>
<div class="portlet box blue">
	<div class="portlet-title portlet-title2">
		<div class="caption caption2">
			<i class="fa fa-bars"><i class="mleft8">Có <span class="viewtotal"></span> <span class='lowercase'>đơn hàng</span></i></i>			
		</div>
		<div class="tools">
			 <ul class="button-group pull-right"  style="margin-top:-5px; margin-bottom:5px;">
						<li id="search">
							<button class="button">
								<i class="fa fa-search"></i>
								<?=getLanguage('all','search')?>
							</button>
						</li>
						<li id="view">
							<button class="button">
								<i class="fa fa-search-plus"></i>
								Xem
							</button>
						</li>
						<li id="refresh" >
							<button class="button">
								<i class="fa fa-refresh"></i>
								<?=getLanguage('all','refresh')?>
							</button>
						</li>
						<li>
							<a id="export">
								<button class="button">
									<i class="fa fa-file-excel-o"></i>Xuất excel
								</button>
							</a>
						</li>
						<li id="printpc">
							<button class="button">
								<i class="fa fa-print"></i>
								In phiếu chi
							</button>
						</li>
						<li>
							<a id="print" href= "#">
								<button class="button">
									<i class="fa fa-print"></i>In phiếu NK
								</button>
							</a>
						</li>
						<?php if(isset($permission['delete'])){?>
						<li id="delete">
							<button class="button">
								<i class="fa fa-times"></i>
								<?=getLanguage('all','delete')?>
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
							<?php for($i=1; $i < 14; $i++){?>
								<col class="c<?=$i;?>">
							<?php }?>
							<tr>							
								<th><input type="checkbox" name="checkAll" id="checkAll" /></th>
								<th><?=getLanguage('all','stt')?></th>
								<th id="ord_c.poid">Mã đơn hàng</th>	
								<th>Hàng hoá</th>									
								<th id="ord_c.quantity">Số lượng</th>
								<th id="ord_c.price">Tổng tiền</th>
								<th id="ord_sp.supplier_name">Khách hàng</th>
								<th id="ord_c.payments">PT thành toán</th>
								<th id="ord_c.datepo">Ngày nhập ĐH</th>
								<th id="ord_c.description">Ghi chú</th>
								<th id="ord_c.usercreate">Người nhập</th>
								<th id="ord_c.datecreate">Ngày nhập</th>
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
							<?php for($i=1; $i < 14; $i++){?>
								<col class="c<?=$i;?>">
							<?php }?>
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
 <!-- Modal -->
<div class="modal fade" id="myFrom" role="dialog">
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
</div>
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
			var msg = "Bạn muốn xóa đơn hàng này";
			deleteItem(msg);
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
		var todates = '<?=$todates;?>';
		$('#todate').val(todates);
		var fromdate = '<?=$fromdate;?>';
		$('#formdate').val(fromdate);
	}
	function init(){
		$( "#goodsnamesearch" ).autocomplete({
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
		});
		$('#payments').multipleSelect({
			filter: true,
			placeholder:'Chọn hình thức thanh toán',
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
			placeholder:'Chọn nhà cung cấp',
			single: false,
			onClick: function(view) {
				searchList();
			}
		});
		$('#goods_type').multipleSelect({
			filter: true,
			placeholder:'Chọn chủng loại',
			single: false,
			onClick: function(view) {
				searchList();
			}
		});
		$('#branchid').multipleSelect({
			filter: true,
			placeholder:'Chọn chi nhánh',
			single: false,
			onClick: function(view) {
				searchList();
			}
		});
		
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
<script src="<?=url_tmpl();?>assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
