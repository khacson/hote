<style title="" type="text/css">
	table col.c1 { width: 50px; }
	table col.c2 { width: 120px; }
	table col.c3 { width: 180px;}
	table col.c4 { width: 80px;}
	table col.c5 { width: 100px;}
	table col.c6 { width: 120px;}
	table col.c7 { width: 120px;}
	table col.c8 { width: 150px;}
	table col.c9 { width: 150px;}
	table col.c10 { width: 120px;}
	table col.c11 { width: 150px;}
	table col.c12 { width: auto;}
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
					<label class="control-label col-md-4">Chi nhánh</label>
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
					<label class="control-label col-md-4">HT bán hàng</label>
					<div class="col-md-8">
						<select id="isorder" name="isorder" class="combos" >
							<option value=""></option>
							<option <?php if(!empty($id)){?> selected <?php }?> value="1">Theo đơn đặt hàng</option>
							<option <?php if(empty($id)){?> selected <?php }?> value="0">Bán hàng trực tiếp</option>
						</select>
					</div>
				</div>
			</div>
			
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4">Khách hàng</label>
					<div class="col-md-8">
							<select id="customer_id" name="customer_id" class="combos" >
								<option value=""></option>
								<?php foreach($customers as $item){?>
									<option
									<?php 
									if(!empty($find->customer_id) && $item->id == $find->customer_id){
										echo 'selected';
									}
									?> value="<?=$item->id;?>"><?=$item->customer_name;?></option>
								<?php }?>
							</select>
					</div>
				</div>
			</div>
		</div>
		<div class="row mtop10">
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4">Từ ngày</label>
					 <div class="col-md-8 input-group date date-picker" data-date-format="<?=cfdateHtml();?>">
						<input type="text" id="formdate" placeholder="<?=cfdateHtml();?>" name="formdate" class="form-control searchs" >
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
						<input type="text" id="todate" placeholder="<?=cfdateHtml();?>" name="todate" class="form-control searchs" >
                        <span class="input-group-btn ">
                            <button class="btn default btn-picker" type="button"><i class="fa fa-calendar "></i></button>
                        </span>
                    </div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4">Thanh toán </label>
					<div class="col-md-8">
						<select id="payments" name="payments" class="combos" >
							<option value=""></option>
							<option value="1">Tiền mặt</option>
							<option value="2">Chuyển khoản</option>
							<option value="3">Cấn trừ tiền hàng</option>
						</select>
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
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4">NV Bán hàng</label>
					<div class="col-md-8">
						<select id="employeeid" name="employeeid" class="combos" >
							<?php
							foreach($employeeSale as $item){?>
								<option value="<?=$item->id;?>"><?=$item->employee_name;?></option>
							<?php }?>
						</select>
					</div>
				</div>
			</div>
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
					<label class="control-label col-md-4">Thanh toán</label>
					<div class="col-md-8">
						<select id="thanhtoanid" name="thanhtoanid" class="combos" >
							<option value="1">Chưa thanh toán</option>
							<option value="2">Đã thanh toán</option>
						</select>
					</div>
				</div>
			</div>	
		</div>
	</div>
</div>
<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption caption2">
			<i class="fa fa-bars"><i class="mleft5">Có <span class="viewtotal"></span> <span class='lowercase'>hàng hóa đã bán</span></i></i>			
		</div>
		<div class="tools">
			<ul class="button-group pull-right" style="margin-top:-5px; margin-bottom:5px;">
				<li id="search">
					<button class="button">
						<i class="fa fa-search"></i>
						<?=getLanguage('all','search')?>
					</button>
				</li>
				<li id="refresh" >
					<button class="button">
						<i class="fa fa-refresh"></i>
						<?=getLanguage('all','refresh')?>
					</button>
				</li>
				<li id="thanhtoan">
					<button class="button">
						<i class="fa fa-usd"></i>
						Thanh toán hoa hồng
					</button>
				</li>
				<li id="export">
					<button class="button">
						<i class="fa fa-file-excel-o"></i>
						Excel
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
							<?php for($i=1; $i < 13; $i++){?>
								<col class="c<?=$i;?>">
							<?php }?>
							<tr>							
								<th>STT</th>
								<th>Đơn hàng</th>
								<th id="ord_g.goods_name">Hàng hóa</th>
								<th id="ord_so.quantity">Số lượng</th>
								<th id="ord_so.discount">Giảm giá</th>
								<th id="ord_so.price">Thành tiền</th>
								<th>Hoa hồng</th>
								<th>Nhân viên</th>
								<th id="ord_c.customer_name">Khách hàng</th>
								<th id="ord_c.usercreate">Người xuất</th>
								<th id="ord_c.datecreate">Ngày xuất</th>
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
<script>
	var controller = '<?=base_url().$routes;?>/';
	var csrfHash = '<?=$csrfHash;?>';
	var cpage = 0;
	var search;
	var idselect = '';
	var customer_type = 1;
	<?php if(!empty($find->customer_type) && $find->customer_type == 2){?>
		customer_type = 2;
	<?php }?>
	$(function(){
		init();
		refresh();
		if(customer_type == 1){
			$('.khdaily').show();
			$('.khle').hide();
		}
		else{
			$('.khle').show();
			$('.khdaily').hide();
		}
		$('#search').click(function(){
			$(".loading").show();
			searchList();	
		});
		$('#refresh').click(function(){
			$('.loading').show();
			$('.searchs').val('');
			$('select.combos').multipleSelect('uncheckAll');
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
		$('#exportsale').click(function(){
			var soid = getCombo('soid');
			if(soid == ''){
				window.location = controller+'formAdd';
			}
			else{
				window.location = controller+'formAddOder?so='+soid;
			}
		});
		//S tinh tong gia
		//setupPriceOne();
		//setupPrice();
		$("#btnAddOder").click(function(){
			$.ajax({
				url : controller + 'addOrder',
				type: 'POST',
				async: false,
				data: {},
				success:function(datas){
					var obj = $.evalJSON(datas); 
					$("#addOrder").prepend(obj.content);
				},
				error : function(){
					
				}
			});
			return false;
		});
		$('#delete').click(function(){ 
			deleteItem("Bạn muốn xóa đơn hàng");
		});
		$('#export').click(function(){ 
			 search = getSearch();
			 window.location = "<?=$controller;?>/export?search="+search;
		});
		$('#printpt').click(function(){
			var id = getCheckedId();
			if(id == ""){
				return false;
			}
			$.ajax({
				url : controller + 'getDataPrintPT',
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
		$('#printpx').click(function(){
			var id = getCheckedId();
			printPX(id);
			return false;
		});
	});
	function printPX(id){
		if(id == ""){
			return false;
		}
		$.ajax({
				url : controller + 'getDataPrintPX',
				type: 'POST',
				async: false,
				data: {id:id},
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
	function init(){
		$('#employeeid').multipleSelect({
			filter: true,
			placeholder:'Chọn nhân viên bán hàng',
			single: false,
			onClick: function(view) {
				searchList();
			}
		});
		$('#thanhtoanid').multipleSelect({
			filter: true,
			placeholder:'Chọn tình trạng',
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
		$('#payments').multipleSelect({
			filter: true,
			placeholder:'Chọn hình thức thanh toán',
			single: true
		});
		$('#goods_type').multipleSelect({
			filter: true,
			placeholder:'Chọn phân loại',
			single: false,
			onClick: function(view) {
				searchList();
			}
		});
		$('#customer_id').multipleSelect({
			filter: true,
			placeholder:'Chọn khách hàng',
			single: true,
			onClick: function(view) {
				var customer_id = getCombo('customer_id');
				$.ajax({
				url : controller + 'getCustomer',
				type: 'POST',
				async: false,
				data: {customer_id:customer_id},
					success:function(datas){
						var obj = $.evalJSON(datas);
						$('#customer_address').val(obj.address);
						$('#customer_phone').val(obj.phone);
						$('#customer_name').val(obj.customer_name);
					}
				});
			}
		});
		$('#warehouseid').multipleSelect({
			filter: true,
			placeholder:'Chọn kho',
			single: true
		});
		$('#isorder').multipleSelect({
			filter: true,
			placeholder:'Chọn hình thức bán hàng',
			single: true
		});
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
		$('select.combos').multipleSelect('uncheckAll');
	}
    function funcList(obj){
	}
	function refresh(){
		$('.loading').show();
		if(idselect == ''){
			$('.searchs').val('');		
			csrfHash = $('#token').val();
			$('select.combos').multipleSelect('uncheckAll');
			$('#customer_type').multipleSelect('setSelects',[1]);
			$('#idss').multipleSelect('disable');
			$('#quantity').val(1);
		}
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
