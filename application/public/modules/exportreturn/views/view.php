<style title="" type="text/css">
	table col.c1 { width: 50px; }
	table col.c2 { width: 50px; }
	table col.c3 { width: 130px;}
	table col.c4 { width: 130px;}
	table col.c5 { width: 90px;}
	table col.c6 { width: 110px;}
	table col.c7 { width: 180px;}
	table col.c8 { width: 110px;}
	table col.c9 { width: 120px;}
	table col.c10 { width: 110px;}
	table col.c11 { width: 150px;}
	table col.c12 {  width: auto;}
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
					<label class="control-label col-md-4">Hàng hóa </label>
					<div class="col-md-8">
						<select id="goodsidsearch" name="goodsidsearch" class="combos" >
							<?php foreach($goods as $item){?>
								<option  value="<?=$item->id;?>"><?=$item->goods_code;?> - <?=$item->goods_name;?></option>
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
					<label class="control-label col-md-4">Kho</label>
					<div class="col-md-8">
						<span id="loadDistric">
							<select id="warehouseid" name="warehouseid" class="combos" >
								<?php
								foreach($warehouses as $item){?>
									<option value="<?=$item->id;?>"><?=$item->warehouse_name;?></option>
								<?php }?>
							</select>
						</span>
					</div>
				</div>
			</div>
		</div>
		<div class="row mtop10">
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
					<label class="control-label col-md-4">Mã phiếu nhập (<span class="red">*</span>)</label>
					 <div class="col-md-8">
						 
						 <select id="poid" name="poid" class="combos" >
							<option value=""></option>
							<?php foreach($soLists as $item){?>
								<option value="<?=$item->poid;?>"><?=$item->poid;?></option>
							<?php }?>
						</select>
                    </div>
				</div>
			</div>
			<div class="col-md-4"></div>
			<div class="col-md-4">
				<div class="mright10" >
					<input type="hidden" name="id" id="id" />
					<input type="hidden" name="idselect" id="idselect" value="<?=$id;?>" />
					<input type="hidden" id="token" name="<?=$csrfName;?>" value="<?=$csrfHash;?>" />
					<ul class="button-group pull-right">
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
					</ul>
				</div>		
			</div>
		</div>
	</div>
</div>
<div class="portlet box blue">
	<div class="portlet-title portlet-title2">
		<div class="caption caption2">
			<i class="fa fa-bars"><i class="mleft8">Có <span class="viewtotal"></span> <span class='lowercase'>đơn hàng trả lại </span></i></i>	NCC		
		</div>
		<div class="tools">
			 <ul class="button-group pull-right"  style="margin-top:-5px; margin-bottom:5px;">
						
						<?php if(isset($permission['add'])){?>
						<li id="exportreturn">
								<button class="button">
									<i class="fa fa-plus"></i>
									Xuất trả NCC
								</button>
						</li>
						<?php }?>
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
								In phiếu xuất
							</button>
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
							<?php for($i=1; $i < 13; $i++){?>
								<col class="c<?=$i;?>">
							<?php }?>
							<tr>							
								<th><input type="checkbox" name="checkAll" id="checkAll" /></th>
								<th><?=getLanguage('all','stt')?></th>
								<th id="ord_c.poid">Mã đơn hàng</th>	
								<th id="ord_c.soid">Mã phiếu nhập</th>								
								<th id="ord_c.quantity">Số lượng</th>
								<th id="ord_c.price">Thành tiền</th>
								<th id="ord_sp.supplier_name">Nhà cung cấp</th>
								<th id="ord_c.payments">PT thành toán</th>
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
							<?php for($i=1; $i < 13; $i++){?>
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
		$('#exportreturn').click(function(){
			var so = getCombo('poid');
			if(so == ''){
				warning('Chọn đơn hàng'); 
				return false;
			}
			window.location = controller + 'input?so='+so;
		});
		$('#print').click(function(){
			var id = getCheckedId();//$('#id').val();
			print(id);
		});
		$('#delete').click(function(){ 
			var msg = "Bạn muốn xóa đơn hàng này";
			deleteItem(msg);
		});
		
		$('#export').click(function(){
			var search = getSearch();
			window.location = controller+'/export?search='+search;
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
	function importExcel(){
		var data = new FormData();
		var objectfile = document.getElementById('myfileImmport').files;
		if(typeof(objectfile[0])  === "undefined") {
			error("Vui lòng chọn file"); return false;	
		}
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
	function init(){
		$('#goodsidsearch').multipleSelect({
			filter: true,
			placeholder:'Chọn hàng hóa',
			single: false,
			onClick: function(view) {
				searchList();
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
		$('#supplierid').multipleSelect({
			filter: true,
			placeholder:'Chọn nhà cung cấp',
			single: false,
			onClick: function(view) {
				searchList();
			}
		});
		$('#warehouseid').multipleSelect({
			filter: true,
			placeholder:'Chọn kho',
			single: false,
			onClick: function(view) {
				searchList();
			}
		});
		$('#poid').multipleSelect({
			filter: true,
			placeholder:'Chọn đơn hàng',
			single: true
		});
		$('select.combos').multipleSelect('uncheckAll');
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
	$('#printpc').click(function(){
			var id = getCheckedId();
			if(id == ""){
				return false;
			}
			$.ajax({
				url : controller + 'getDataPrint',
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
