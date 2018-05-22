<style title="" type="text/css">
	table col.c1 { width: 50px; }
	table col.c2 { width: 50px; }
	table col.c3 { width: 80px;}
	table col.c4 { width: 150px;}
	table col.c5 { width: 120px;}
	table col.c6 { width: 80px;}
	table col.c7 { width: 80px;}
	table col.c8 { width: 90px;}
	table col.c9 { width: 60px;}
	table col.c10 { width: 80px;}
	table col.c11 { width: 130px;}
	table col.c12 { width: 100px;}
	table col.c13 { width: 180px;}
	table col.c14 { width: 120px;}
	table col.c15 { width: 150px;}
	table col.c16 { width: auto;}
	.col-md-4{ white-space: nowrap !important;}
</style>

<!-- BEGIN PORTLET-->
<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-search" style="margin-top:2px;"></i>
			<?=getLanguage('all','search')?>
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
					<label class="control-label col-md-4">Đơn hàng</label>
					<div class="col-md-8">
						<select id="idss" name="idss" class="combos" >
							<option value=""></option>
							<?php foreach($orders as $item){?>
								<option value="<?=$item->id;?>">PO<?=$item->poid;?></option>
							<?php }?>
						</select>
					</div>
				</div>
			</div>
			<!---->
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4">Loại khách hàng</label>
					<div class="col-md-8">
						<select id="customer_type" name="customer_type" class="combos" >
							<option value=""></option>
							<option value="1">KH đại lý</option>
							<option value="2">KH lẽ</option>
						</select>
					</div>
				</div>
			</div>
		</div>
		<div class="row mtop10">
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4">Khách hàng</label>
					<div class="col-md-8">
						<span class="khdaily">
							<select id="customer_id" name="customer_id" class="combos" >
								<option value=""></option>
								<?php foreach($customers as $item){?>
									<option
									value="<?=$item->id;?>"><?=$item->customer_name;?></option>
								<?php }?>
							</select>
						</span>
						<span class="khle" >
							<input type="text" name="customer_name" id="customer_name" placeholder="" class="searchs form-control"
							/>
						</span>
					</div>
				</div>
			</div>
			<div class="col-md-4 khles" style="display:nones;">
				<div class="form-group">
					<label class="control-label col-md-4">Điện thoại</label>
					<div class="col-md-8">
						<input type="text" name="customer_phone" id="customer_phone" placeholder="" class="searchs form-control" 
						<?php 
							if(!empty($find->customer_phone)){
								echo 'value="'.($find->customer_phone).'"';
							}
							?> />
					</div>
				</div>
			</div>
			<div class="col-md-4 khles" style="display:nones;">
				<div class="form-group">
					<label class="control-label col-md-4">Địa chỉ</label>
					<div class="col-md-8">
						<input type="text" name="customer_address" id="customer_address" placeholder="" class="searchs form-control"  />
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
							<option value=""></option>
							<?php foreach($employeesale as $item){?>
								<option value="<?=$item->id;?>"><?=$item->employee_code;?> - <?=$item->employee_name;?></option>
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
							<option value=""></option>
							<option value="1">Tiền mặt</option>
							<option value="2">Chuyển khoản</option>
							<option value="3">Cấn trừ tiền hàng</option>
							<option value="-1">Khách hàng nợ</option>
						</select>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4">Ghi chú</label>
					<div class="col-md-8">
						<input type="text" name="description" id="description" placeholder="" class="searchs form-control" />
					</div>
				</div>
			</div>
		</div>
		<div class="row mtop10">
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4">Hàng hóa</label>
					<div class="col-md-8">
						<select id="goodsid" name="goodsid" class="combos" >
							<option value=""></option>
							<?php foreach($goods as $item){?>
								<option value="<?=$item->id;?>"><?=$item->goods_code;?> - <?=$item->goods_name;?></option>
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
								<option value=""></option>
								<?php foreach($warehouses as $item){?>
									<option value="<?=$item->id;?>"><?=$item->warehouse_name;?></option>
								<?php }?>
							</select>
						</span>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4">Từ ngày bán</label>
					 <div class="col-md-8 input-group date date-picker" data-date-format="dd-mm-yyyy">
						<input type="text" id="formdate" placeholder="dd-mm-yyyy" name="formdate" class="form-control searchs" >
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
					<label class="control-label col-md-4">Đến ngày bán</label>
					 <div class="col-md-8 input-group date date-picker" data-date-format="dd-mm-yyyy">
						<input type="text" id="todate" placeholder="dd-mm-yyyy" name="todate" class="form-control searchs" >
                        <span class="input-group-btn ">
                            <button class="btn default btn-picker" type="button"><i class="fa fa-calendar "></i></button>
                        </span>
                    </div>
				</div>
			</div>
		</div>
		<div class="row mtop10">
			<div class="col-md-4">
			</div>
			<div class="col-md-8">
				
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
						<li id="refresh" >
							<button class="button">
								<i class="fa fa-refresh"></i>
								<?=getLanguage('all','refresh')?>
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
		</div>
	</div>
</div>
<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-bars"><i class="mleft5">Có <span class="viewtotal"></span> <span class='lowercase'>đơn hàng đã xuất</span></i></i>			
		</div>
		<div class="tools">
			<a href="javascript:;" class="collapse">
			</a>
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
							<?php for($i=1; $i < 17; $i++){?>
								<col class="c<?=$i;?>">
							<?php }?>
							<tr>							
								<th><input type="checkbox" name="checkAll" id="checkAll" /></th>
								
								<th><?=getLanguage('all','stt')?></th>	
								<th id="ord_s.id">PO</th>				
								<th id="ord_s.goods_name">Hàng hóa</th>
								<th id="ord_w.warehouse_name">Kho</th>
								<th id="ord_c.quantity">Số lượng</th>
								<th id="ord_c.priceone">Đơn giá</th>
								<th id="ord_c.price">Thành tiền</th>
								<th id="ord_ut.unit_name">ĐVT</th>
								<th id="ord_c.customer_type">Loại KH</th>
								<th id="ord_cm.customer_name">Khách hàng</th>
								<th id="ord_c.customer_phone">Điện thoại</th>
								<th id="ord_c.employee_code">NV Bán hàng</th>
								<th id="ord_c.payments">Thanh toán</th>
								<th id="ord_c.description">Ghi chú</th>
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
							<?php for($i=1; $i < 17; $i++){?>
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
	var idselect = '<?=$id;?>';
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
		$('#export').click(function(){
			window.location = controller + 'export?search='+getSearch();
		});
		$('#printpt').click(function(){
			var id = getCheckedId();
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
			$.ajax({
				url : controller + 'getDataPrintPX',
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
	});
	function init(){
		if(idselect == ''){
			$('#line').hide();
		}
		goodsid();
		$('#employeeid').multipleSelect({
			filter: true,
			placeholder:'Chọn nhân viên',
			single: true
		}); 
		$('#payments').multipleSelect({
			filter: true,
			placeholder:'Chọn hình thức thanh toán',
			single: true
		});
		$('#customer_type').multipleSelect({
			filter: true,
			placeholder:'Chọn loại khách hàng',
			single: true,
			onClick: function(view) {
				var customer_type = getCombo('customer_type');
				if(customer_type ==1){
					$('.khdaily').show();
					$('.khle').hide();
				}
				else{
					$('.khdaily').hide();
					$('.khle').show();
				}
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
		$('#idss').multipleSelect({
			filter: true,
			placeholder:'Chọn đơn hàng',
			single: true,
			onClick: function(view) {
				var isorder = parseInt(getCombo('isorder'));
				var idss = getCombo('idss');
				$("#banghangdh").html('');
				$.ajax({
					url : controller + 'getFormOrder',
					type: 'POST',
					async: false,
					data: {id:idss,isorder:isorder},
					success:function(datas){
						var obj = $.evalJSON(datas); 
						$("#banhangtt").html(obj.content);
						if(isorder == 0){
							goodsid();
							$('#line').hide();
						}
						else{
							$('#line').show();
						}
					}
				});
				search = getSearch();
				getList(cpage,csrfHash);	
			}
		});
		$('#isorder').multipleSelect({
			filter: true,
			placeholder:'Chọn hình thức bán hàng',
			single: true,
			onClick: function(view) {
				$('#idss').multipleSelect('uncheckAll');
				var isorder = parseInt(getCombo('isorder'));
				if(isorder == 0){
					$('#line').hide();
					$('#idss').multipleSelect('disable');
					var idss = getCombo('idss');
					$("#banghangdh").html('');
					$.ajax({
						url : controller + 'getFormOrder',
						type: 'POST',
						async: false,
						data: {id:idss,isorder:isorder},
						success:function(datas){
							var obj = $.evalJSON(datas); 
							$("#banhangtt").html(obj.content);
							goodsid();
						}
					});
				}
				else{
					$('#idss').multipleSelect('enable');
				}
				
			}
		});
		
	}
	function goodsid(){
		$('#goodsid').multipleSelect({
			filter: true,
			placeholder:'Chọn hàng hóa',
			single: true,
			onClick: function(view) {
				var goodsid = getCombo('goodsid');
				$.ajax({
					url : controller + 'getGoods',
					type: 'POST',
					async: false,
					data: {id:goodsid},
					success:function(datas){
						var obj = $.evalJSON(datas); 
						var quantity = $('#quantity').val();
						var sale_price = obj.sale_price;
						$('#priceone').val(sale_price);
						$('#price').val(quantity*sale_price);
						$('#unitid').val(obj.unit_name);
					}
				});
			}
		});
	}
	function print(){
		
	}
	function getCheckedId(){
		var strId = '';
		$('#tbbody').find('input:checked').each(function(){
			var id = $(this).attr('id');
			if(id != 'checkAll'){
				strId += ',' + $(this).attr('id') ;
			}
		});
		return strId.substring(1);
	}
    function funcList(obj){
		/*$('.edit').each(function(e){
			$(this).click(function(){ 
				 var quantity = $('.quantity').eq(e).html().trim();
				 var priceone = $('.priceone').eq(e).html().trim();
				 var price = $('.price').eq(e).html().trim();
				 var customer_phone = $('.customer_phone').eq(e).html().trim();
				 var description = $('.description').eq(e).html().trim();
				 
				 var customer_id = $(this).attr('customer_id');
				 var warehouseid = $(this).attr('warehouseid');
				 var goodsid = $(this).attr('goodsid');
				 var unitid = $(this).attr('unitid');
				 var customer_type = $(this).attr('customer_type');
				 var employeeid = $(this).attr('employeeid');
				 var payments = $(this).attr('payments');
				 
				 var id = $(this).attr('id');
				 $('#id').val(id);	
				 $('#quantity').val(quantity);
				 $('#priceone').val(priceone);		
				 $('#price').val(price);
				 
				 if(customer_type == '1' || customer_type == 1){
					$('.khdaily').show();
					$('.khle').hide();
				}
				else{
					$('.khdaily').hide();
					$('.khle').show();
					var customer_names = $('.customer_name').eq(e).html().trim();
					$('#customer_name').val(customer_names);
				}
				 
				 $('#customer_phone').val(customer_phone);
				 $('#description').val(description);
				 $('#customer_id').multipleSelect('setSelects', customer_id.split(','));
				 $('#customer_type').multipleSelect('setSelects', customer_type.split(','));
				 $('#unitid').multipleSelect('setSelects', unitid.split(','));
				 $('#warehouseid').multipleSelect('setSelects', warehouseid.split(','));
				 $('#goodsid').multipleSelect('setSelects', goodsid.split(','));
				 $('#payments').multipleSelect('setSelects', payments.split(','));
				 $('#employeeid').multipleSelect('setSelects', employeeid.split(','));
			});
			function getIDChecked(){
				return 1;	
			} 
		});*/
	}
	function refresh(){
		$('.loading').show();
		if(idselect == ''){
			$('.searchs').val('');		
			csrfHash = $('#token').val();
			$('select.combos').multipleSelect('uncheckAll');
			$('#customer_type').multipleSelect('setSelects',[1]);
			$('#isorder').multipleSelect('setSelects',[0]);
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
	function getSearch(){
		var str = '';
		$('input.searchs').each(function(){
			str += ',"'+ $(this).attr('id') +'":"'+ $(this).val().trim() +'"';
		});
		$('select.combos').each(function(){
			str += ',"'+ $(this).attr('id') +'":"'+ getCombo($(this).attr('id')) +'"';
		});
		return '{'+ str.substr(1) +'}';
	}	
	
</script>
<script src="<?=url_tmpl();?>assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
