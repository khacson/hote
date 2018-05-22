<style title="" type="text/css">
	table col.c1 { width: 50px; }
	table col.c2 { width: 90px;}
	table col.c3 { width: 170px;}
	table col.c4 { width: 70px;}
	table col.c5 { width: 80px;}
	table col.c6 { width: 80px;}
	table col.c7 { width: 115px;}
	table col.c8 { width: 80px;}
	table col.c9 { width: 100px;}
	table col.c10 { width: 90px;}
	table col.c11 { width: 110px;}
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
								<option value="<?=$item->id;?>"><?=$item->branch_name;?></option>
							<?php }?>
						</select>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4">Kho</label>
					<div class="col-md-8">
						<select id="warehouseid" name="warehouseid" class="combos" >
							<?php foreach($warehouses as $item){?>
								<option value="<?=$item->id;?>"><?=$item->warehouse_name;?></option>
							<?php }?>
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
			<div class="col-md-8">
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
			<i class="fa fa-bars"><i class="mleft5">Có <span class="viewtotal"></span> <span class='lowercase'>hàng hóa</span></i></i>			
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
						<li id="history" >
							<button class="button">
								<i class="fa fa-history"></i>
								Lịch sử
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
	<div class="portlet-body">
		<div class="portlet-body">
        	<div id="gridview" >
				<table class="resultset" id="grid"></table>
				<!--header-->
				<div id="cHeader">
					<div id="tHeader">    	
						<table id="tbheader" width="100%" cellspacing="0" border="1" >
							<?php for($i=1; $i< 13; $i++){?>
								<col class="c<?=$i;?>">
							<?php }?>
							<tr>
								<th><?=getLanguage('all','stt')?></th>
								<th>Mã hàng</th>
								<th>Hàng hóa</th>
								<th>ĐVT</th>
								<th>Tồ đầu kỳ</th>
								<th>Nhập kho</th>
								<th>Nhập hàng trả lại</th>
								<th>Xuất kho</th>
								<th>Xuất trả NCC</th>
								<th>Tồn cuối kỳ</th>
								<th>Giá tồn</th>
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
	$(function(){
		init();
		searchList();
		$('#unitid').parent().find('.ms-parent').attr('style','width:30% !important; margin-top:-3px');
		$('#unitid').multipleSelect('setSelects', [1]);
		
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
				error('Vui lòng chọn mã hàng cần đổi vị trí.'); return false;	
			}
			changeLoation();
		});
		$('#export').click(function(){
			window.location = controller + 'export?search='+getSearch();
		});
	});
	function init(){
		$('#warehouseid').multipleSelect({
			filter: true,
			placeholder:'Chọn kho',
			// single: true
		});
		$('#branchid').multipleSelect({
			filter: true,
			placeholder:'Chọn chi nhánh',
			// single: true
		});
		$('#locationid').multipleSelect({
			filter: true,
			placeholder:'Chọn vị trí',
			// single: true
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
		$('select.combos').multipleSelect('uncheckAll');
	}
	function refresh(){
		$('.loading').show();
		//$('.searchs').val('');		
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
	function funcList(obj){
		$('.edit').each(function(e){
			$(this).click(function(){ 
				 //var location_name = $('.location_name').eq(e).html().trim();
				 var goodsid = $(this).attr('goodsid');
				 var locationid = $(this).attr('locationid');
				 var branchid = $(this).attr('branchid');
				 var warehouseid = $(this).attr('warehouseid');
				 var id = $(this).attr('id');
				 
				 $('#goodsid').multipleSelect('setSelects',[goodsid]);
				 $('#locationid').multipleSelect('setSelects',[locationid]);
				 $('#branchid').multipleSelect('setSelects',[branchid]);
				 $('#warehouseid').multipleSelect('setSelects',[warehouseid]);
				 $('#id').val(id);	
				 //$('#location_name').val(location_name);
			});
			function getIDChecked(){
				return 1;	
			} 
		});	
	}
	function getSearch(){
		var search = {};
		$('input.searchs').each(function(){
			search[$(this).attr('id')] = $(this).val().trim();
		});
		$('select.combos').each(function(){
			search[$(this).attr('id')] = getCombo($(this).attr('id'));
		});
		return JSON.stringify(search);
	}	
	
</script>
<script src="<?=url_tmpl();?>assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
