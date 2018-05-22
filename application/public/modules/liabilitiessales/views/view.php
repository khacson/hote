<style title="" type="text/css">
	table col.c1 { width: 50px; }
	table col.c2 { width: 50px; }
	table col.c3 { width: 120px;}
	table col.c4 { width: 250px;}
	table col.c5 { width: 75px;}
	table col.c6 { width: 100px;}
	table col.c7 { width: 100px;}
	table col.c8 { width: 100px;}
	table col.c9 { width: 140px;}
	table col.c10 { width: 140px;}
	table col.c11 { width: 140px;}
	table col.c12 { width: 120px;}
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
					<label class="control-label col-md-4">Đơn hàng (<span class="red">*</span>)</label>
					<div class="col-md-8">
						<select id="idss" name="idss" class="combos tab-event" >
							<option value=""></option>
							<?php foreach($orders as $item){?>
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
							<?php foreach($goods as $item){?>
								<option value="<?=$item->id;?>"><?=$item->goods_code;?> - <?=$item->goods_name;?></option>
							<?php }?>
						</select>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4">Loại khách hàng</label>
					<div class="col-md-8">
						<select id="customer_type" name="customer_type" class="combos tab-event" >
							<option value=""></option>
							<option 
							value="1">Khách hàng đại lý</option>
							<option
							value="2">Khách hàng lẻ</option>
						</select>
					</div>
				</div>
			</div>
			
		</div>
		<div class="row mtop10">
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4">Khách hàng (<span class="red">*</span>)</label>
					<div class="col-md-8">
						<span class="khdaily">
							<select id="customer_id" name="customer_id" class="combos tab-event" >
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
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4">NV Bán hàng</label>
					<div class="col-md-8">
						<select id="employeeid" name="employeeid" class="combos tab-event" >
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
					<label class="control-label col-md-4">Hạn thanh toán </label>
					 <div class="col-md-8 input-group date date-picker" data-date-format="<?=cfdateHtml();?>">
						<input type="text" id="maturitydate" placeholder="<?=cfdateHtml();?>" name="maturitydate" class="form-control searchs tab-event" >
                        <span class="input-group-btn ">
                            <button class="btn default btn-picker" type="button"><i class="fa fa-calendar "></i></button>
                        </span>
                    </div>
				</div>
			</div>
		</div>
		<div class="row mtop10">
			<div class="col-md-4 khles" style="display:nones;">
				<div class="form-group">
					<label class="control-label col-md-4">Số tiền (<span class="red">*</span>)</label>
					<div class="col-md-8">
						<input type="text" name="add_price" id="add_price" placeholder="" class="searchs form-control fm-number text-right tab-event" maxlength="12"
						/>
					</div>
				</div>
			</div>
			<div class="col-md-4 khles" style="display:nones;">
				<div class="form-group">
					<label class="control-label col-md-4">Còn lại</label>
					<div class="col-md-8">
						<input type="text" name="price_cl" id="price_cl" placeholder="" class="searchs form-control fm-number text-right tab-event" readonly
						/>
						<input type="hidden" name="price_cls" id="price_cls" readonly
						/>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4">Thanh toán (<span class="red">*</span>)</label>
					<div class="col-md-8 pright5">
						<div class="col-md-4 pleft0">
							<label class="control-label">
							<input checked type="radio" id="payments_1" name="payments" value="1"  />
							Tiền mặt</label>
						</div>
						<div class="col-md-4">
							<label class="control-label">
							<input type="radio"  id="payments_2" name="payments" value="2"  />
							CK</label>
						</div>
						<div class="col-md-4">
							<label class="control-label">
							<input type="radio"  id="payments_3" name="payments" value="3"  />
							Thẻ</label>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row mtop10">
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4">Ghi chú</label>
					 <div class="col-md-8">
						<input type="text" id="note" placeholder="" name="note" class="form-control searchs tab-event" maxlength="250" />
                    </div>
				</div>
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
						<?php if(isset($permission['edit'])){?>
						<li id="edit">
							<button class="button">
								<i class="fa fa-save"></i>
								Cập nhật công nợ
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
		<div class="caption caption2">
			<i class="fa fa-bars"><i class="mleft5">Có <span class="viewtotal"></span> <span class='lowercase'>công nợ bán hàng</span></i></i>			
		</div>
		<div class="tools">
			<ul class="button-group pull-right" style="margin-top:-5px; margin-bottom:5px;">
				<li id="print">
					<button class="button">
						<i class="fa fa-print"></i>
						In phiếu thu
					</button>
				</li>
				<li id="export">
					<button class="button">
						<i class="fa fa-file-excel-o"></i>
						Xuất excel
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
							<?php for($i=1; $i < 14; $i++){?>
								<col class="c<?=$i;?>">
							<?php }?>
							<tr>							
								<th><input type="checkbox" name="checkAll" id="checkAll" /></th>
								<th><?=getLanguage('all','stt')?></th>	
								<th id="ord_c.poid">Đơn hàng</th>				
								<th >Hàng hóa</th>
								<th id="ord_c.quantity">Số lượng</th>
								<th id="ord_c.price">Thành tiền</th>
								<th id="ord_c.price_prepay">Đã trả</th>
								<th>Còn lại</th>
								<th id="ord_c.customer_type">Loại khách hàng</th>
								<th id="ord_cm.id">Khách hàng</th>
								<th id="ord_c.customer_phone">Hạn thanh toán</th>
								<th id="ord_c.payments_status">Thanh toán</th>
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
	  <div class="modal-content" style="width:800px;"> 
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
		  <h4 class="modal-title"><i class="fa fa-tasks" aria-hidden="true"></i>
 Chi tiết công nợ đơn hàng <span class="podetail"></span</h4>
		</div>
		<div class="modal-body">
			<!--Content-->
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
				error('Vui lòng chọn dữ liệu cần cập nhật công nợ.'); return false;	
			}
			save('edit',id);
		});
		$('#export').click(function(){
			window.location = controller + 'export?search='+getSearch();
		});
		$('#add_price').keyup(function(){
			var add_price = $('#add_price').val();
			add_price = add_price.replace(/\,/g, '');
			var price_cls = $('#price_cls').val();
			price_cls = price_cls.replace(/\,/g, '');
			var tt = price_cls - add_price;
			if(tt < 0){
				$("#add_price").val(price_cls);
				$("#price_cl").val(0);
				return false;
			}
			$("#price_cl").val(price_cls - add_price);
			//formatNumberKeyUp('fm-number');
			formatNumber('fm-number');
		});
	});
	function save(func,id){
		search = getSearch();
		var obj = $.evalJSON(search); 
		
		if(obj.idss == ''){
			error('Đơn hàng <?=getLanguage('all','empty')?>'); return false;	
		}
		if(obj.payments_status == ''){
			error('Thanh toán <?=getLanguage('all','empty')?>'); return false;	
		}
		var token = $('#token').val();
		var idselect = $('#idselect').val();
		var payments = $('input[name=payments]:checked').val();
		$('.loading').show();
		$.ajax({
			url : controller + func,
			type: 'POST',
			async: false,
			data: {csrf_stock_name:token,search:search , id:id,idselect:idselect,payments:payments},
			success:function(datas){
				var obj = $.evalJSON(datas); 
				$("#token").val(obj.csrfHash);
				$('.loading').hide();
				if(obj.status == 0){
					success('Cập nhật công nợ thành công.'); return false;
				}
				else{
					success('Cập nhật công nợ thành công.');
					refresh(); return false;
				}
			},
			error : function(){
				$('.loading').hide();
				error('Cập nhật công nợ không thành công.'); return false;
			}
		});
	}
	function init(){
		formatNumberKeyUp('fm-number');
		formatNumber('fm-number');
		$('#goodsid').multipleSelect({
			filter: true,
			placeholder:'Chọn hàng hóa',
			single: false,
			input:true,
			placeholderinput:"SL",
			nameinput:"s1"
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
		$('#idss').multipleSelect({
			filter: true,
			placeholder:'Chọn đơn hàng',
			single: true
		});
		$('#payments_status').multipleSelect({
			filter: true,
			placeholder:'Chọn tình trạng thành toán',
			single: true,
			onClick: function(view) {
				var payments_status = getCombo('payments_status');
				var price_cl = $("#price_cl").val();
				var price_cls = $("#price_cls").val();
				if(payments_status == 1){
					$("#add_price").val(price_cl);
					$("#add_price").prop( "readonly", true );
					$("#price_cl").val(0);
				}
				else{
					$("#add_price").val(0);
					$("#add_price").prop( "readonly", false );
					$("#price_cl").val(price_cls);
				}
			}
		});
	}
    function funcList(obj){
		$('.edit').each(function(e){
			$(this).click(function(){ 
				 var quantity = $('.quantity').eq(e).html().trim();
				 //var priceone = $('.priceone').eq(e).html().trim();
				 var price = $('.price').eq(e).html().trim();
				 //var description = $('.description').eq(e).html().trim();
				 
				 var customer_id = $(this).attr('customer_id');
				// var warehouseid = $(this).attr('warehouseid');
				 var poid = $(this).attr('poid');
				 var price_cl = $(this).attr('price_cl');
				 var customer_type = $(this).attr('customer_type');
				 var payments_status = $(this).attr('payments_status');
				 var payments = $(this).attr('payments');
				 var maturitydate = $('.maturitydate').eq(e).html().trim();
				 //console.log(maturitydate); 
				 
				 var id = $(this).attr('id');
				 $('#id').val(id);	
				 $('#quantity').val(quantity);
				 $('#add_price').val(0);
				 $('#add_price').val(price_cl);	 	
				 $('#price_cls').val(price_cl);
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
				 
				 $('#maturitydate').val(maturitydate);
				 //$('#description').val(description);
				 $('#customer_id').multipleSelect('setSelects', customer_id.split(','));
				 $('#customer_type').multipleSelect('setSelects', customer_type.split(','));
				 //$('#unitid').multipleSelect('setSelects', unitid.split(','));
				// $('#warehouseid').multipleSelect('setSelects', warehouseid.split(','));
				// $('#goodsid').multipleSelect('setSelects', goodsid.split(','));
				 $('#idss').multipleSelect('setSelects', poid.split(','));
				 //$('#payments_status').multipleSelect('setSelects', payments_status.split(','));
				 //formatNumberKeyUp('fm-number');
				 formatNumber('fm-number');
				 //Chi tiet don hang
			});
			function getIDChecked(){
				return 1;	
			} 
		});	
		 $('.oderDetail').each(function(){
			$(this).click(function(){
				$('.modal-body').html('');
				var id = $(this).attr('id');
				$('.podetail').html(' - '+$(this).html());
				 $.ajax({
					url : controller + 'viewPOdetail',
					type: 'POST',
					async: false,
					data: {id:id},
					success:function(datas){
						var obj = $.evalJSON(datas); 
						$('.modal-body').html(obj.content);
					},
					error : function(){
						
					}
				});
			});
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
