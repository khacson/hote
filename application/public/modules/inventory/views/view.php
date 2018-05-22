<style title="" type="text/css">
	table col.c1 { width: 50px; }
	table col.c2 { width: 160px;}
	table col.c3 { width: 90px;}
	table col.c4 { width: 70px;}
	table col.c5 { width: 100px;}
	table col.c6 { width: 100px;}
	table col.c7 { width: 120px;}
	table col.c8 { width: 120px;}
	table col.c9 { width: 120px;}
	table col.c10 { width: 120px;}
	table col.c11 { width: 130px;}
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
					<label class="control-label col-md-4"><?=getLanguage('chi-nhanh');?></label>
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
					<label class="control-label col-md-4"><?=getLanguage('kho');?></label>
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
					<label class="control-label col-md-4"><?=getLanguage('vi-tri');?></label>
					<div class="col-md-8">
						<select id="locationid" name="locationid" class="combos" >
							<option value="-1"><?=getLanguage('chua-co-vi-tri');?></option>
							<?php foreach($locations as $item){?>
								<option value="<?=$item->id;?>"><?=$item->location_name;?></option>
							<?php }?>
						</select>
					</div>
				</div>
			</div>
			
		</div>
		<div class="row mtop10">
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('hang-hoa');?></label>
					<div class="col-md-8">
						<input type="text" id="goodsnamesearch" placeholder="Nhập tên hàng" name="goodsnamesearch" class="form-control searchs tab-event" maxlength="100" >
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('phan-loai');?></label>
					<div class="col-md-8">
						<select id="goods_type" name="goods_type" class="combos tab-event" >
							<?php
							foreach($goodsType as $item){?>
								<option value="<?=$item->id;?>"><?=$item->goods_tye_name;?></option>
							<?php }?>
						</select>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('ton-kho');?></label>
					<div class="col-md-8">
						<select id="tonkhoid" name="tonkhoid" class="combos tab-event" >
							<option value=""></option>
							<option value=""><?=getLanguage('chon-tat-ca');?></option>
							<option value="1"><?=getLanguage('ton-kho');?> > 0</option>
							<option value="2"><?=getLanguage('ton-kho');?> <= 0</option>
							<option value="3"><?=getLanguage('sap-het-hang');?></option>
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
			<i class="fa fa-bars"><i class="mleft5"><?=getLanguage('co');?> <span class="viewtotal"></span> <span class='lowercase'><?=getLanguage('hang-hoa');?></span></i></i>			
		</div>
		<div class="tools">
			<ul class="button-group pull-right" style="margin-top:-5px; margin-bottom:5px;">
						<li id="search">
							<button class="button">
								<i class="fa fa-search"></i>
								<?=getLanguage('tim-kiem')?>
							</button>
						</li>
						<li id="refresh" >
							<button class="button">
								<i class="fa fa-refresh"></i>
								<?=getLanguage('lam-moi')?>
							</button>
						</li>
						<li id="history" >
							<button class="button">
								<i class="fa fa-history"></i>
								<?=getLanguage('lich-su')?>
							</button>
						</li>
						<li id="export">
							<button class="button">
								<i class="fa fa-file-excel-o"></i>
								<?=getLanguage('export')?>
							</button>
						</li>
						<?php if(isset($permission['transfer'])){?>
							<li id="transfers" data-toggle="modal" data-target="#myModalTransfer"><button class="button">
								<i class="fa fa-paper-plane-o"></i>
								<?=getLanguage('chuyen-hang');?>
								</button>
							</li>
						<?php }?>
						<?php if(isset($permission['edit'])){?>
						<li id="edit" >
							<button class="button">
								<i class="fa fa-save"></i>
								<?=getLanguage('doi-vị-tri')?>
							</button>
						</li>
						<?php }?>
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
								<th><?=getLanguage('stt')?></th>
								<th><?=getLanguage('hang-hoa')?></th>
								<th><?=getLanguage('ton-kho')?></th>
								<th><?=getLanguage('dvt')?></th>
								<th><?=getLanguage('dv-qui-doi')?></th>
								<th><?=getLanguage('tk-toi-thieu')?></th>
								<th><?=getLanguage('kho')?></th>
								<th><?=getLanguage('chi-nhanh')?></th>
								<th><?=getLanguage('vi-tri')?></th>
								<th><?=getLanguage('hinh-anh')?></th>
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
<!-- view Img -->
<div id="viewImg-form" style="display:none;">
	<div class="">
		<div id="viewImg-form-gridview" ></div>
	</div>
</div>
<!-- view Img -->
<script type="text/javascript" src="<?=url_tmpl();?>fancybox/source/jquery.fancybox.pack.js"></script>  
<link href="<?=url_tmpl();?>fancybox/source/jquery.fancybox.css" rel="stylesheet" /> 
<script type="text/javascript">
	var controller = '<?=base_url().$routes;?>/';
	var csrfHash = '<?=$csrfHash;?>';
	var cpage = 0;
	var search;
	$(function(){
		init();
		refresh();
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
	function changeLoation(){
		var msg = 'Bạn có muốn đổi vị trí của mã hàng này.';
		var id = $("#id").val();
		var locationid = getCombo('locationid');
		if(locationid  == ''){
			error('Chọn một vị trí'); return false;
		}
		if(locationid  == '-1'){
			 error('Vị trí không phù hợp'); return false;
		}
		var arrlocationid = locationid.split(',');
		if(arrlocationid.length  > 1){
			 error('Chọn tối đa một vị trí'); return false;
		}
		var token = $('#token').val();
		var yess = 'Có';
		var nos = 'Không';
		var texts = msg+'?';
		$.msgBox({
			title:'Message',
			type:'confirm',
			content:texts,
			buttons:[{value:yess},{value:nos}],
			success: function(result) {
				if (result == yess) {
					var token = $('#token').val();			
					$.ajax({
						url : controller + 'changeLoation',
						type: 'POST',
						async: false,
						data: {csrf_stock_name:token,id:id,locationid:locationid},
						success:function(datas){
							var obj = $.evalJSON(datas); 
							$('#token').val(obj.csrfHash);
							if(obj.status == 0){
								 error('Đổi vị trí không thành công'); return false;
							}
							else{
								 success('Đổi vị trí thành công');
								refresh();	
							}
						},
						error : function(){
							 error('Đổi vị trí không thành công'); return false;
						}
					});

				}
				else{
					return false;
				}
			}
		});
	}
	function init(){
		$('#warehouseid').multipleSelect({
			filter: true,
			placeholder:"<?=getLanguage('chon-kho')?>",
			// single: true
		});
		$('#branchid').multipleSelect({
			filter: true,
			placeholder:"<?=getLanguage('chon-chi-nhanh')?>",
			// single: true
		});
		$('#locationid').multipleSelect({
			filter: true,
			placeholder:"<?=getLanguage('chon-vi-tri')?>",
			// single: true
		});
		$('#tonkhoid').multipleSelect({
			filter: true,
			placeholder:"<?=getLanguage('chon-ton-kho')?>",
		    single: true
		});
		$('#goods_type').multipleSelect({
			filter: true,
			placeholder:"<?=getLanguage('chon-chung-loai')?>",
			single: false,
			onClick: function(view) {
				searchList();
			}
		});
		$('#warehouseid,#branchid,#locationid,#tonkhoid,#goods_type').multipleSelect('uncheckAll');
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
		clickViewImg();	
	}
	function clickViewImg(){
		$('.viewImg').each(function(){
			$(this).click(function(){
				 var url = $(this).attr('src');
				 viewImg(url); return false;
			});
		});
	}
	function viewImg(url) {
		$.fancybox({
			'width': 600,
			'height': 500,
			'autoSize' : false,
			'hideOnContentClick': true,
			'enableEscapeButton': true,
			'titleShow': true,
			'href': "#viewImg-form",
			'scrolling': 'no',
			'afterShow': function(){
				$('#viewImg-form-gridview').html('<img style="width:600px; height:500px;" src="'+url+'" />');
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
