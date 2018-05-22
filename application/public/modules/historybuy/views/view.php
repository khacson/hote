<style title="" type="text/css">
	table col.c1 { width: 50px; }
	table col.c2 { width: 50px; }
	table col.c3 { width: 80px;}
	table col.c4 { width: 180px;}
	table col.c5 { width: 150px;}
	table col.c6 { width: 120px;}
	table col.c7 { width: 80px;}
	table col.c8 { width: 90px;}
	table col.c9 { width: 105px;}
	table col.c10 { width: 70px;}
	table col.c11 { width: 160px;}
	table col.c12 { width: 120px;}
	table col.c13 { width: 120px;}
	table col.c14 { width: 150px;}
	table col.c15 { width: auto;}
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
						<select id="poid" name="poid" class="combos tab-event" >
							<?php foreach($pos as $item){?>
								<option value="<?=$item->poid;?>"><?=$item->poid;?></option>
							<?php }?>
						</select>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4">Hàng hóa</label>
					<div class="col-md-8">
						<select id="goodsid" name="goodsid" class="combos tab-event" >
							<option value=""></option>
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
						<select id="supplierid" name="supplierid" class="combos tab-event" >
							<option value=""></option>
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
					<label class="control-label col-md-4">Kho </label>
					<div class="col-md-8">
						<span id="loadDistric">
							<select id="warehouseid" name="warehouseid" class="combos tab-event" >
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
					<label class="control-label col-md-4">HT thanh toán</label>
					<div class="col-md-8">
						<select id="payments" name="payments" class="combos tab-event" >
							<option value=""></option>
							<option value="1">Tiền mặt</option>
							<option value="2">Chuyển khoản</option>
							<option value="3">Thẻ</option>
						</select>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4">Ghi chú</label>
					<div class="col-md-8">
						<input type="text" name="description" id="description" placeholder="" class="searchs form-control tab-event" />
					</div>
				</div>
			</div>
		</div>
		<div class="row mtop10">
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4">Từ ngày bán</label>
					 <div class="col-md-8 input-group date date-picker" data-date-format="dd-mm-yyyy">
						<input type="text" id="formdate" placeholder="dd-mm-yyyy" name="formdate" class="form-control searchs tab-event" >
                        <span class="input-group-btn ">
                            <button class="btn default btn-picker" type="button"><i class="fa fa-calendar "></i></button>
                        </span>
                    </div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4">Đến ngày bán</label>
					 <div class="col-md-8 input-group date date-picker" data-date-format="dd-mm-yyyy">
						<input type="text" id="todate" placeholder="dd-mm-yyyy" name="todate" class="form-control searchs tab-event" >
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
			<i class="fa fa-bars"><i class="mleft8">Có <span class="viewtotal"></span> <span class='lowercase'>đơn hàng đã mua</span></i></i>			
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
							<?php for($i=1; $i < 16; $i++){?>
								<col class="c<?=$i;?>">
							<?php }?>
							<tr>							
								<th><input type="checkbox" name="checkAll" id="checkAll" /></th>
								<th><?=getLanguage('all','stt')?></th>	
								<th id="ord_s.poid">Đơn hàng</th>	
								<th id="ord_s.goods_name">Hàng hóa</th>
								<th id="ord_sp.supplier_name">Nhà cung cấp</th>
								<th id="ord_w.warehouse_name">Kho</th>
								<th id="ord_c.quantity">Số lượng</th>
								<th id="ord_c.priceone">Đơn giá</th>
								<th id="ord_c.price">Thành tiền</th>
								<th id="ord_ut.unit_name">ĐVT</th>
								<th id="ord_c.payments">Thanh toán</th>
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
							<?php for($i=1; $i < 16; $i++){?>
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
		$('#print').click(function(){
			print('');
		});
		$('#delete').click(function(){ 
			var id = getCheckedId();//$('#id').val();
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
	function init(){
		$('#poid').multipleSelect({
			filter: true,
			placeholder:'Chọn đơn hàng',
			single: false
		});
		$('#goodsid').multipleSelect({
			filter: true,
			placeholder:'Chọn hàng hóa',
			single: true,
			onClick: function(view){
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
					}
				});
			}
		});
		$('#payments').multipleSelect({
			filter: true,
			placeholder:'Chọn hình thức thanh toán',
			single: true
		});
		$('#supplierid').multipleSelect({
			filter: true,
			placeholder:'Chọn nhà cung cấp',
			single: true
			/*,
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
			}*/
		});
		$('#warehouseid').multipleSelect({
			filter: true,
			placeholder:'Chọn kho',
			single: true
		});
		/*$('#unitid').multipleSelect({
			filter: true,
			placeholder:'Chọn đơn vị tính',
			single: true
		});*/
	}
	function print(id){
		if(id == ''){
			id = getCheckedId();
		}
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
		$('.edit').each(function(e){
			$(this).click(function(){ 
				 //var quantity = $('.quantity').eq(e).html().trim();
				 //var priceone = $('.priceone').eq(e).html().trim();
				 //var price = $('.price').eq(e).html().trim();
				 var description = $('.description').eq(e).html().trim();
				 
				 var supplierid = $(this).attr('supplierid');
				 var warehouseid = $(this).attr('warehouseid');
				 var goodsid = $(this).attr('goodsid');
				 var unitid = $(this).attr('unitid');
				 var payments = $(this).attr('payments');
				 
				 var id = $(this).attr('id');
				 $('#id').val(id);	
				 //$('#quantity').val(quantity);
				 //$('#priceone').val(priceone);		
				 //$('#price').val(price);
				 $('#description').val(description);
				 
				 $('#supplierid').multipleSelect('setSelects', supplierid.split(','));
				 $('#unitid').multipleSelect('setSelects', unitid.split(','));
				 $('#warehouseid').multipleSelect('setSelects', warehouseid.split(','));
				 $('#goodsid').multipleSelect('setSelects', goodsid.split(','));
				 $('#payments').multipleSelect('setSelects', payments.split(','));
				 //$('#employeeid').multipleSelect('setSelects', employeeid.split(','));
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
