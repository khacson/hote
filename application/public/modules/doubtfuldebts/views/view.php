<style title="" type="text/css">
	table col.c1 { width: 50px; }
	table col.c2 { width: 50px; }
	table col.c3 { width: 80px;}
	table col.c4 { width: 180px;}
	table col.c5 { width: 120px;}
	table col.c6 { width: 80px;}
	table col.c7 { width: 80px;}
	table col.c8 { width: 90px;}
	table col.c9 { width: 100px;}
	table col.c10 { width: 160px;}
	table col.c11 { width: 160px;}
	table col.c12 { width: 120px;}
	table col.c13 { width: 120px;}
	table col.c14 { width: 200px;}
	table col.c15 { width: 200px;}
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
					<label class="control-label col-md-4">Đơn hàng</label>
					<div class="col-md-8">
						<select id="idss" name="idss" class="combos" >
							<option value=""></option>
							<?php foreach($orders as $item){?>
								<option 
								<?php 
								if(!empty($find->id) && $find->id == $item->id){
									echo 'selected';
								}
								?>
								value="<?=$item->id;?>">PO<?=$item->id;?></option>
							<?php }?>
						</select>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4">Hàng hóa</label>
					<div class="col-md-8">
						<select id="goodsid" name="goodsid" class="combos" >
							<option value=""></option>
							<?php foreach($goods as $item){?>
								<option
								<?php 
								if(!empty($find->goodsid) && $find->goodsid == $item->id){
									echo 'selected';
								}
								?>
								value="<?=$item->id;?>"><?=$item->goods_code;?> - <?=$item->goods_name;?></option>
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
			
		</div>
		<div class="row mtop10">
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4">Loại khách hàng</label>
					<div class="col-md-8">
						<select id="customer_type" name="customer_type" class="combos" >
							<option value=""></option>
							<option
							<?php 
							if(!empty($find->customer_type) && $find->customer_type == 1){
								echo 'selected';
							}
							?>
							value="1">Khách hàng đại lý</option>
							<option
							<?php 
							if(!empty($find->customer_type) && $find->customer_type == 2){
								echo 'selected';
							}
							?>
							value="2">Khách hàng lẽ</option>
						</select>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4">Khách hàng</label>
					<div class="col-md-8">
						<span class="khdaily">
							<select id="customer_id" name="customer_id" class="combos" >
								<option value=""></option>
								<?php foreach($customers as $item){?>
									<option
									<?php 
									if(!empty($find->customer_type) && $find->customer_type == 1){
										echo 'selected';
									}
									?>
									value="<?=$item->id;?>"><?=$item->customer_name;?></option>
								<?php }?>
							</select>
						</span>
						<span class="khle" style="display:none;">
							<input type="text" name="customer_name" id="customer_name" placeholder="" class="searchs form-control" required />
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
							?>
						/>
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
								<option
								value="<?=$item->id;?>"><?=$item->employee_code;?> - <?=$item->employee_name;?></option>
							<?php }?>
						</select>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4">Ghi chú</label>
					<div class="col-md-8">
						<input type="text" name="description" id="description" placeholder="" class="searchs form-control" 
							<?php 
							if(!empty($find->description)){
								echo 'value="'.($find->description).'"';
							}
							?>
						/>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4">Hạn thanh toán</label>
					 <div class="col-md-8 input-group date date-picker" data-date-format="dd-mm-yyyy">
						<input type="text" id="maturitydate" placeholder="dd-mm-yyyy" name="maturitydate" class="form-control searchs" >
                        <span class="input-group-btn ">
                            <button class="btn default btn-picker" type="button"><i class="fa fa-calendar "></i></button>
                        </span>
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
								Export
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
			<i class="fa fa-bars"><i>Có <span class="viewtotal"></span> <span class='lowercase'>công nợ bán hàng</span></i></i>			
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
								<th id="ord_s.id">Đơn hàng</th>				
								<th id="ord_s.goods_name">Hàng hóa</th>
								<th id="ord_w.warehouse_name">Kho</th>
								<th id="ord_c.quantity">Số lượng</th>
								<th id="ord_c.priceone">Đơn giá</th>
								<th id="ord_c.price">Thành tiền</th>
								<th id="ord_ut.unit_name">ĐVT</th>
								<th id="ord_c.customer_type">Loại khách hàng</th>
								<th id="ord_cm.customer_name">Tên khách hàng</th>
								<th id="ord_c.customer_phone">Hạn thanh toán</th>
								<th id="ord_c.payments_status">Thanh toán</th>
								<th id="ord_c.employee_code">NV Bán hàng</th>
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
	$(function(){
		init();
		refresh();
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
		$('#export').click(function(){
			window.location = controller + 'export?search='+getSearch();
		});
	});
	function init(){
		$('#goodsid').multipleSelect({
			filter: true,
			placeholder:'Chọn hàng hóa',
			single: true
		});
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
			single: true
		});
		$('#warehouseid').multipleSelect({
			filter: true,
			placeholder:'Chọn kho',
			single: true
		});
		$('#unitid').multipleSelect({
			filter: true,
			placeholder:'Chọn đơn vị tính',
			single: true
		});
		$('#idss').multipleSelect({
			filter: true,
			placeholder:'Chọn đơn hàng',
			single: true
		});
		$('#payments_status').multipleSelect({
			filter: true,
			placeholder:'Chọn tình trạng thành toán',
			single: true
		});
	}
	function getCheckedId(){
		var strId = '';
		$('#'+routes).find('input:checked').each(function(){
			var id = $(this).attr('id');
			if(id != 'checkAll'){
				strId += ',' + $(this).attr('id') ;
			}
		});
		return strId.substring(1);
	}
    function funcList(obj){
		$('.edit').each(function(e){
			$(this).click(function(){ 
				 var quantity = $('.quantity').eq(e).html().trim();
				 var priceone = $('.priceone').eq(e).html().trim();
				 var price = $('.price').eq(e).html().trim();
				// var customer_phone = $('.customer_phone').eq(e).html().trim();
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
				 
				// $('#customer_phone').val(customer_phone);
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
		});	
	}
	function refresh(){
		$('.loading').show();
		if(idselect == ''){
			$('.searchs').val('');		
			csrfHash = $('#token').val();
			$('select.combos').multipleSelect('uncheckAll');
			$('#customer_type').multipleSelect('setSelects',[1]);
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
