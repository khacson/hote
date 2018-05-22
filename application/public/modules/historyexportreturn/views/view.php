<style title="" type="text/css">
	table col.c1 { width: 50px; }
	table col.c2 { width: 50px; }
	table col.c3 { width: 120px;}
	table col.c4 { width: 100px;}
	table col.c5 { width: 150px;}
	table col.c6 { width: 80px;}
	table col.c7 { width: 100px;}
	table col.c8 { width: 100px;}
	table col.c9 { width: 70px;}
	table col.c10 { width: 120px;}
	table col.c11 { width: 120px;}
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
					<label class="control-label col-md-4">Chi nhánh/CH </label>
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
		</div>
		<div class="row mtop10">
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4">Hàng hóa (<span class="red">*</span>)</label>
					<div class="col-md-8">
						<select id="goodsid" name="goodsid" class="combos" >
							<?php foreach($goods as $item){?>
								<option value="<?=$item->id;?>"><?=$item->goods_code;?> - <?=$item->goods_name;?></option>
							<?php }?>
						</select>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4">Đơn hàng</label>
					<div class="col-md-8">
						<span id="loaddonhang">
							<select id="idss" name="idss" class="combos" >
								<option value=""></option>
								<?php foreach($orders as $item){?>
									<option 
									<?php 
									if(!empty($find->id) && $find->id == $item->id){
										echo 'selected';
									}
									?> value="<?=$item->id;?>"><?=$item->poid;?></option>
								<?php }?>
							</select>
						</span>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4">Ghi chú</label>
					<div class="col-md-8">
						<input type="text" name="description" id="description" placeholder="" class="searchs form-control" required />
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
				<div class="mright10" >
					<input type="hidden" name="id" id="id" />
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
						<?php if(isset($permission['add'])){?>
						<li id="save">
							<button class="button">
								<i class="fa fa-plus"></i>
								<?=getLanguage('all','add')?>
							</button>
						</li>
						<?php } ?>
						<?php if(isset($permission['edit'])){?>
						<li id="edit">
							<button class="button">
								<i class="fa fa-save"></i>
								<?=getLanguage('all','edit')?>
							</button>
						</li>
						<?php } ?>
						<!--<li id="print">
							<button class="button">
								<i class="fa fa-print"></i>
								In
							</button>
						</li>-->
						<li id="export">
							<button class="button">
								<i class="fa fa-file-excel-o"></i>
								Xuất Excel
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
		</div>
	</div>
</div>
<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-bars" style="margin-left:10px; margin-top:5px; margin-bottom:10px;"><i class="mleft5">Có <span class="viewtotal"></span> <span class='lowercase'>hàng hóa</span></i></i>			
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
							<?php for($i=2; $i < 13; $i++){?>
								<col class="c<?=$i;?>">
							<?php }?>
							<tr>							
								<!--<th><input type="checkbox" name="checkAll" id="checkAll" /></th>-->
								<th><?=getLanguage('all','stt')?></th>
								<th id="ord_c.poid">Đơn hàng</th>
								<th id="ord_g.goods_code">Mã hàng</th>								
								<th id="ord_g.goods_name">Tên hàng</th>
								<th id="ord_so.quantity">Số lượng</th>
								<th id="ord_so.priceone">Đơn giá</th>
								<th id="ord_so.price">Thành tiền</th>
								<th id="ord_ut.unit_name">ĐVT</th>
								<th id="">Kho</th>
								<th>Nhà cung cấp</th>
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
							<?php for($i=2; $i < 13; $i++){?>
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
		$('#print').click(function(){
			print('');
		});
		$('#export').click(function(){
			var search = getSearch();
			window.location  = controller + 'export?search='+search;
		});
	});
	function print(id){
		if(id == ''){
			id = $('#id').val();
		}
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
	function init(){
		$('#goodsid').multipleSelect({
			filter: true,
			placeholder:'Chọn hàng hóa',
			single: false,
			input:true,
			placeholderinput:"SL",
			nameinput:"s1"
		});
		$('#supplierid').multipleSelect({
			filter: true,
			placeholder:'Chọn nhà cung cấp',
			single: false
		});
		$('#warehouseid').multipleSelect({
			filter: true,
			placeholder:'Chọn kho',
			single: false
		});
		$('#idss').multipleSelect({
			filter: true,
			placeholder:'Chọn đơn hàng',
			single: false
		});
		$('#employeeid').multipleSelect({
			filter: true,
			placeholder:'Chọn nhân viên',
			single: false
		}); 
		$('#branchid').multipleSelect({
			filter: true,
			placeholder:'Chọn chi nhánh/CH',
			single: false,
			onClick: function(view) {
				searchList();
			}
		});
		$('select.combos').multipleSelect('uncheckAll');
	}
    function funcList(obj){
		$('.edit').each(function(e){
			$(this).click(function(){ 
				 /*
				 var customer_address = $(this).attr('customer_address');
				 var customer_phone = $(this).attr('customer_phone');
				 var customer_name = $(this).attr('customer_name');
				 var customer_id = $(this).attr('customer_names');
				 
				 var customer_id = $(this).attr('customer_id');
				 var employeeid = $(this).attr('employeeid');
				 //var goodsid = $(this).attr('goodsid');
				 var goodslistid = $(this).attr('goodslistid');
				 
				 var customer_type = $(this).attr('customer_type');
				 var id = $(this).attr('id');
				 $('#id').val(id);	

				 
				 $('#customer_name').val(customer_name);
				 $('#customer_phone').val(customer_phone);
				 $('#customer_address').val(customer_address);
				 $('#customer_id').multipleSelect('setSelects', customer_id.split(','));
				 $('#customer_type').multipleSelect('setSelects', customer_type.split(','));
				 $('#employeeid').multipleSelect('setSelects', employeeid.split(','));
				 $('#goodsid').multipleSelect('setSelects', goodslistid.split(','));
				 */
			});
			function getIDChecked(){
				return 1;	
			} 
		});	
	}
	function refresh(){
		$('.loading').show();
		$('.searchs').val('');	
		$('.ms-search-sl').val('');			
		csrfHash = $('#token').val();
		$('select.combos').multipleSelect('uncheckAll');
		//$('#customer_type').multipleSelect('setSelects',[1]);
		$('#quantity').val(1);
		search = getSearch();
		getList(cpage,csrfHash);	
	}
	function searchList(){
		search = getSearch();
		csrfHash = $('#token').val();
		getList(0,csrfHash);	
	}
	/*function getSearch(){
		var str = '';
		$('input.searchs').each(function(){
			str += ',"'+ $(this).attr('id') +'":"'+ $(this).val().trim() +'"';
		});
		$('select.combos').each(function(){
			if($(this).attr('id') == 'goodsid'){
				str += ',"'+ $(this).attr('id') +'":{'+ getCombo($(this).attr('id')) +'}';
			}
			else{
				str += ',"'+ $(this).attr('id') +'":"'+ getCombo($(this).attr('id')) +'"';
			}
			
		});
		return '{'+ str.substr(1) +'}';
	}*/
	
</script>
<script src="<?=url_tmpl();?>assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
