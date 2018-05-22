<style title="" type="text/css">
	table col.c1 { width: 50px; }
	table col.c2 { width: 50px; }
	table col.c3 { width: 110px;}
	table col.c4 { width: 100px;}
	table col.c5 { width: 150px;}
	table col.c6 { width: 80px;}
	table col.c7 { width: 100px;}
	table col.c8 { width: 100px;}
	table col.c9 { width: 80px;}
	table col.c10 { width: 90px;}
	table col.c11 { width: 120px;}
	table col.c12 { width: 100px;}
	table col.c13 { width: 150px;}
	table col.c14 { width: 160px;}
	table col.c15 { width: 80px;}
	table col.c16 { width: 150px;}
	table col.c17 { width: auto;}

	.col-md-4{ white-space: nowrap !important;}
</style>

<!-- BEGIN PORTLET-->
<div class="portlet box blue">
	<div class="portlet-title">
		<?=$this->load->inc('breadcrumb');?>
	</div>
	<div class="portlet-body">
		<div class="row">
			<div class="col-md-4" >
				<div class="form-group">
					<label class="control-label col-md-4">Serial</label>
					<div class="col-md-8">
						<input type="text" name="serial_number" id="serial_number" placeholder="" class="searchs form-control" />
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
									<option value="<?=$item->id;?>"><?=$item->customer_name;?></option>
								<?php }?>
							</select>
						</span>
						<span class="khle" style="display:none;">
							<input type="text" name="customer_name" id="customer_name" placeholder="" class="searchs form-control" required />
						</span>
					</div>
				</div>
			</div>
			<div class="col-md-4" >
				<div class="form-group">
					<label class="control-label col-md-4">Điện thoại</label>
					<div class="col-md-8">
						<input type="text" name="customer_phone" id="customer_phone" placeholder="" class="searchs form-control" required />
					</div>
				</div>
			</div>
		</div>
		<div class="row mtop10">
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4">Từ ngày</label>
					 <div class="col-md-8 input-group date date-picker" data-date-format="dd-mm-yyyy">
						<input type="text" id="formdate" placeholder="dd-mm-yyyy" name="formdate" class="form-control searchs" >
                        <span class="input-group-btn ">
                            <button class="btn default btn-picker" type="button"><i class="fa fa-calendar "></i></button>
                        </span>
                    </div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4">Đến ngày</label>
					 <div class="col-md-8 input-group date date-picker" data-date-format="dd-mm-yyyy">
						<input type="text" id="todate" placeholder="dd-mm-yyyy" name="todate" class="form-control searchs" >
                        <span class="input-group-btn ">
                            <button class="btn default btn-picker" type="button"><i class="fa fa-calendar "></i></button>
                        </span>
                    </div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4">Tình trạng</label>
					<div class="col-md-8">
						<select id="statusguarantee" name="statusguarantee" class="combos">
							<option value=""></option>
							<option value="1">Trong hạn</option>
							<option value="2">Hết hạn</option>
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
			
			<div class="col-md-12">
				<div class="mright10" >
					<input type="hidden" name="id" id="id" />
					<input type="hidden" id="token" name="<?=$csrfName;?>" value="<?=$csrfHash;?>" />
					
				</div>		
			</div>
		</div>
	</div>
</div>
<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption caption2">
			<i class="fa fa-bars"><i class="mleft5">Có <span class="viewtotal"></span> <span class='lowercase'>hàng hóa có hạn bảo hành</span></i></i>			
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
								<th><input type="checkbox" name="checkAll" id="checkAll" /></th>
								<th><?=getLanguage('all','stt')?></th>
								<th id="ord_c.poid">Đơn hàng</th>
								<th id="ord_g.goods_code">Mã hàng</th>								
								<th id="ord_g.goods_name">Tên hàng</th>
								<th id="ord_so.quantity">Số lượng</th>
								<th id="ord_so.priceone">Đơn giá</th>
								<th id="ord_so.price">Thành tiền</th>
								<th id="ord_ut.unit_name">ĐVT</th>
								<th id="ord_so.guarantee">Hạn bảo hành</th>
								<th id="ord_so.serial_number">Serial</th>
								<th>Khách hàng</th>
								<th>Điện thoại</th>
								<th>Địa chỉ</th>
								<th>Mã NV</th>
								<th>Tên nhân viên</th>
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
							<?php for($i=1; $i < 18; $i++){?>
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
		$('#delete').click(function(){ 
			var id = getCheckedId();
			var token = $('#token').val();
			var yess = 'Có';
			var nos = 'Không';
			var texts = 'Bạn có muốn xóa dòng này';
			$.msgBox({
				title:'Message',
				type:'confirm',
				content:texts,
				buttons:[{value:yess},{value:nos}],
				success: function(result) {
					if (result == yess) {
						var idparent = $('#ids').val();
						var token = $('#token').val();			
						$.ajax({
							url : controller + 'deletes',
							type: 'POST',
							async: false,
							data: {csrf_stock_name:token,id:id},
							success:function(datas){
								var obj = $.evalJSON(datas); 
								$('#token').val(obj.csrfHash);
								if(obj.status == 0){
									$.msgBox({
											title: 'Message',
											type:'info',
											content: '<?=getLanguage('all', 'delete-failed')?>',
											buttons: [{value: 'OK'}],
									 });
								}
								else{
									
									refresh();	
								}
								
							},
							error : function(){
								
							}
						});
		
					}
					else{
						return false;
					}
				}
			});
			
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
	function save(func,id){
		search = getSearch();
		var obj = $.evalJSON(search); 
		var goodsid = getCombo('goodsid');
		if(goodsid == ''){
			warning('Hàng hóa <?=getLanguage('all','empty')?>'); return false;	
		}
		if(obj.customer_type == ''){
			warning('Loại khách hàng <?=getLanguage('all','empty')?>'); return false;	
		}
		if(obj.employeeid == ''){
			warning('Nhân viên <?=getLanguage('all','empty')?>'); return false;	
		}
		var token = $('#token').val();
		$.ajax({
			url : controller + func,
			type: 'POST',
			async: false,
			data: {csrf_stock_name:token,search:search , id:id},
			success:function(datas){
				var obj = $.evalJSON(datas); 
				$("#token").val(obj.csrfHash);
				if(obj.status == 0){
					if(func == 'save'){
						error('<?=getLanguage('all','add_failed')?>'); return false;	
					}
					else{
						error('<?=getLanguage('all','edit_failed')?>'); return false;	
					}
				}
				else if(obj.status == -1){
					error('Khách hàng <?=getLanguage('all','exist')?>'); return false;		
				}
				else{
					refresh();
				}
			},
			error : function(){
				
			}
		});
	}
	function init(){
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
		$('#statusguarantee').multipleSelect({
			filter: true,
			placeholder:'Chọn tình trạng bảo hành',
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
	}
    function funcList(obj){
		$('.edit').each(function(e){
			$(this).click(function(){ 
				 //var quantity = $('.quantity').eq(e).html().trim();
				 //var priceone = $('.priceone').eq(e).html().trim();
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
