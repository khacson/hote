<style title="" type="text/css">
	table col.c1 { width: 50px; }
	table col.c2 { width: 50px; }
	table col.c3 { width: 150px;}
	table col.c4 { width: 120px;}
	table col.c5 { width: 120px;}
	table col.c6 { width: 110px;}
	table col.c7 { width: 110px;}
	table col.c8 { width: 110px;}
	table col.c9 { width: 110px;}
	table col.c10 { width: 180px;}
	table col.c11 { width: 130px;}
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
			<div class="col-md-4 ">
				<div class="form-group">
					<label class="control-label col-md-4">Chi nhánh</label>
					<div class="col-md-8">
						<select id="branchid" name="branchid" class="combos tab-event" >
							<?php foreach($branchs as $item){?>
								<option value="<?=$item->id;?>"><?=$item->branch_name;?></option>
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
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4">Đơn hàng</label>
					<div class="col-md-8">
						<input type="text" id="poid" placeholder="Nhập đơn hàng" name="poid" class="form-control searchs tab-event" maxlength="20" >
					</div>
				</div>
			</div>
			<div class="col-md-4 mtop10">
				<div class="form-group">
					<label class="control-label col-md-4">Mã phiếu chi</label>
					<div class="col-md-8">
						<input type="text" id="pay_code" placeholder="Nhập mã phiếu chi" name="pay_code" class="form-control searchs tab-event" maxlength="20" >
					</div>
				</div>
			</div>
			<div class="col-md-4 mtop10">
				<div class="form-group">
					<label class="control-label col-md-4">Từ ngày</label>
					 <div class="col-md-8 input-group date date-picker" data-date-format="<?=cfdateHtml();?>">
						<input type="text" id="fromdate" placeholder="<?=cfdateHtml();?>" name="fromdate" class="form-control searchs tab-event" value="" >
                        <span class="input-group-btn ">
                            <button class="btn default btn-picker" type="button"><i class="fa fa-calendar "></i></button>
                        </span>
                    </div>
				</div>
			</div>
			<div class="col-md-4 mtop10">
				<div class="form-group">
					<label class="control-label col-md-4">Đến ngày</label>
					 <div class="col-md-8 input-group date date-picker" data-date-format="<?=cfdateHtml();?>">
						<input type="text" id="todate" placeholder="<?=cfdateHtml();?>" name="todate" class="form-control searchs tab-event" value="" >
                        <span class="input-group-btn ">
                            <button class="btn default btn-picker" type="button"><i class="fa fa-calendar "></i></button>
                        </span>
                    </div>
				</div>
			</div>
			<div class="col-md-4 mtop10">
				<div class="form-group">
					<label class="control-label col-md-4">Ghi chú</label>
					 <div class="col-md-8">
						<input type="text" id="description" placeholder="" name="description" class="form-control searchs tab-event" >
                    </div>
				</div>
			</div>
		</div>
		<div class="row"><!--Row 4-->
		</div><!--E Row 4-->
	</div>
</div>
<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption caption2">
			<i class="fa fa-bars"><i class="mleft5">Có <span class="viewtotal"></span> <span class='lowercase'>đơn hàng</span></i></i>			
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
				<li id="export">
					<button class="button">
						<i class="fa fa-file-excel-o"></i>
						Xuất excel
					</button>
				</li>
				<li id="printpc">
					<button class="button">
						<i class="fa fa-print"></i>
						In phiếu chi
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
								<th id="ord_sp.supplierid">Nhà cung cấp</th>		
								<th id="ord_sp.poid">Đơn hàng</th>
								<th id="ord_sp.pay_code">Mã phiếu chi</th>
								<th id="ord_sp.amount">Số tiền</th>
								<th id="ord_sp.payment">HT thanh toán</th>
								<th id="ord_sp.datepo">Ngày chi</th>
								<th id="ord_sp.pay_type">Loại phiếu chi</th>
								<th>Ghi chú</th>
								<th id="ord_sp.datecreate">Ngày tạo</th>
								<th id="ord_sp.usercreate">Người tạo</th>
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
 Chi tiết công nợ đơn hàng <span class="podetail"></span></h4>
		</div>
		<div class="modal-body">
			<!--Content-->
		</div>
	  </div>  
	</div>
</div>
<!--E My form-->
<input type="hidden" id="uniqueid" name="uniqueid" >
<script>
	var controller = '<?=base_url().$routes;?>/';
	var csrfHash = '<?=$csrfHash;?>';
	var cpage = 0;
	var search;
	$(function(){
		init();
		formatNumberKeyUp('fm-number');
		formatNumber('fm-number');
		//refresh(); 
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
		/*$('#price_prepays').keyup(function(){
			var price_prepay = $(this).val();
			price_prepay = parseInt(price_prepay.replace(/\,/g, ''));
			var conlais = parseInt($("#conlais").val());
			if(price_prepay > conlais){
				$(this).val(conlais);
				$("#conlai").val(0);
			}
			else{
				$("#conlai").val(conlais-price_prepay);
			}
			//formatNumberKeyUp('fm-number');
			formatNumber('fm-number');
		});*/
		$('#history').click(function(){
			var id = $('#id').val();	
			 showCongNo(id);
		});
		$('#printpc').click(function(){
			var uniqueid = $('#uniqueid').val();
			if(uniqueid == ""){
				warning('Chọn đơn hàng để in phiếu chi'); return false;	
				return false;
			}
			$.ajax({
				url : controller + 'getDataPrintPC/',
				type: 'POST',
				async: false,
				data: {uniqueid:uniqueid},
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
		
		$('#supplierid').multipleSelect({
			filter: true,
			placeholder:'Chọn nhà cung cấp',
			single: true
		});
		
		$('#branchid').multipleSelect({
			filter: true,
			placeholder:'Chọn chi nhánh',
			// single: true
		});
		$('#goods_type').multipleSelect({
			filter: true,
			placeholder:'Chọn chủng loại',
			single: false,
			onClick: function(view) {
				searchList();
			}
		});
		$('.searchs').val('');		
		$('select.combos').multipleSelect('uncheckAll');
	}
	function showCongNo(id){
		//var poid = getCombo('poid'); alert(poid);
		$('.podetail').html(' - ');
		$.ajax({
			url : controller + 'viewPOdetail',
			type: 'POST',
			async: false,
			data: {id:id},
			success:function(datas){
				var obj = $.evalJSON(datas); 
				$('.modal-body').html(obj.content);
			},
			error : function(){}
		});
	}
    function funcList(obj){
		$('.edit').each(function(e){
			$(this).click(function(){ 
				var uniqueid = $(this).attr('uniqueid');
				$('#uniqueid').val(uniqueid);	
			});
			function getIDChecked(){
				return 1;	
			} 
		});	
		$('.oderDetail').each(function(){
			$(this).click(function(){
				$('.modal-body').html('');
				var id = $(this).attr('id');
				showCongNo(id);
			});
		 });
	}
	function refresh(){
		$('.loading').show();
		$('.searchs').val('');		
		csrfHash = $('#token').val();
		$('select.combos').multipleSelect('uncheckAll');
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
