<style title="" type="text/css">
	table col.c1 { width: 50px; }
	table col.c2 { width: 50px; }
	table col.c3 { width: 150px;}
	table col.c4 { width: 200px;}
	table col.c5 { width: 200px;}
	table col.c6 { width: 100px;}
	table col.c7 { width: 100px;}
	table col.c8 { width: auto;}
	.col-md-4{ white-space: nowrap !important;}
</style>

<!-- BEGIN PORTLET-->
<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-plus" style="margin-top:2px;"></i>
			Thêm nhóm hàng
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
					<label class="control-label col-md-4">Mã nhóm (<span class="red">*</span>)</label>
					<div class="col-md-8">
						<input type="text" name="group_code" id="group_code" placeholder="" class="searchs form-control" required />
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4">Tên nhóm (<span class="red">*</span>)</label>
					<div class="col-md-8">
						<input type="text" name="group_name" id="group_name" placeholder="" class="searchs form-control" required />
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4">Đơn vị tính (<span class="red">*</span>)</label>
					<div class="col-md-8">
						<span id="loadunit">
							<select id="unitid" name="unitid" class="combos" >
								<option value=""></option>
								<?php foreach($units as $item){?>
									<option value="<?=$item->id;?>"><?=$item->unit_name;?></option>
								<?php }?>
							</select>
						</span>
					 </div>
				</div>
			</div>
		</div>
		<div class="row mtop10">
			<div class="col-md-12">
				<div class="mright10" >
					<input type="hidden" name="idgroup" id="idgroup" />
					<ul class="button-group pull-right">
						<?php if(isset($permission['add'])){?>
						<li id="save">
							<button type="button" class="button">
								<i class="fa fa-plus"></i>
								<?=getLanguage('all','add')?>
							</button>
						</li>
						<?php }?>
						<li id="refresh" >
							<button class="button">
								<i class="fa fa-refresh"></i>
								<?=getLanguage('all','refresh')?>
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
			<i class="fa fa-plus" style="margin-top:2px;"></i>
			Thêm hàng hóa vào nhóm hàng		
		</div>
	</div>
	<div class="portlet-body">
		<div class="portlet-body">
			<div class="row" >
				<div class="col-md-4">
					<div class="form-group">
						<label class="control-label col-md-4">Hàng hóa (<span class="red">*</span>)</label>
						<div class="col-md-8">
							<select id="goodsid" name="goodsid" class="combos" >
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
						<label class="control-label col-md-4">Đơn vị tính (<span class="red">*</span>)</label>
						<div class="col-md-8">
							<span id="loadunits">
								<select id="unitids" name="unitids" class="combos" >
									<option value=""></option>
									<?php foreach($units as $item){?>
										<option value="<?=$item->id;?>"><?=$item->unit_name;?></option>
									<?php }?>
								</select>
							</span>
						 </div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="control-label col-md-4">Quy đổi</label>
						<div class="col-md-8">
							<input type="text" name="change" value="1" id="change" placeholder="" class="searchs form-control" required />
						</div>
					</div>
				</div>
			</div>
			<div class="row mtop10">
			<div class="col-md-12">
				<div class="mright10" >
					<input type="hidden" name="iddetail" id="iddetail" />
					<ul class="button-group pull-right">
						<li id="search">
							<button type="button" class="button">
								<i class="fa fa-search"></i>
								<?=getLanguage('all','search')?>
							</button>
						</li>
						<?php if(isset($permission['add'])){?>
						<li id="saveDetail">
							<button type="button" class="button">
								<i class="fa fa-plus"></i>
								<?=getLanguage('all','add')?>
							</button>
						</li>
						<?php }?>
						<?php if(isset($permission['edit'])){?>
						<li id="edit">
							<button type="button" class="button">
								<i class="fa fa-save"></i>
								<?=getLanguage('all','edit')?>
							</button>
						</li>
						<?php }?>
						<?php if(isset($permission['delete'])){?>
						<li id="delete">
							<button type="button" class="button">
								<i class="fa fa-times"></i>
								<?=getLanguage('all','delete')?>
							</button>
						</li>
						<?php }?>
					</ul>
				</div>		
			</div>
		</div>
        	<div id="gridview" class="mtop10" >
				<table class="resultset " id="grid"></table>
				<!--header-->
				<div id="cHeader">
					<div id="tHeader">    	
						<table id="tbheader" width="100%" cellspacing="0" border="1" >
							<?php for($i=1; $i < 9; $i++){?>
								<col class="c<?=$i;?>">
							<?php }?>
							<tr>							
								<th><input type="checkbox" name="checkAll" id="checkAll" /></th>
								<th><?=getLanguage('all','stt')?></th>
								<th >Mã nhóm</th>
								<th >Tên nhóm</th>										
								<th >Hàng hóa</th>
								<th >Đơn vị</th>
								<th >Tỉ lệ quy đổi</th>
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
							<?php for($i=1; $i < 9; $i++){?>
								<col class="c<?=$i;?>">
							<?php }?>
							<tbody id="grid-rows"></tbody>
						</table>
					</div>
				</div>
				<!--end body-->				
			</div>
		</div>
	</div>		
</div>
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
		$('#idgroup,#iddetail').val('');
		$('#goodsid').multipleSelect({
			filter: true,
			placeholder:'Chọn hàng hóa',
			single: true
		});
		$('#unitid').multipleSelect({
			filter: true,
			placeholder:'Chọn đơn vị tính',
			single: true,
			plus:true,
			idplus:'addUnit',
			idtxt:'txtUnit',
			src:'<?=url_tmpl();?>img/plus.png'
		});
		$('#addUnit').live('click',function(){
			var txtUnit = $('#txtUnit').val();
			if(txtUnit == ''){
				 error("Đơn vị tính không được trống"); return false;
			}
			$.ajax({
				url : controller + 'addUnit',
				type: 'POST',
				async: false,
				data: {txtUnit:txtUnit},
				success:function(datas){
					var obj = $.evalJSON(datas); 
					if(obj.status == 0){
						 error("Đơn vị tính đã tồn tại"); 
					}
					else{
						$('#loadunit').html(obj.content);
						$('#unitid').multipleSelect({
							filter: true,
							placeholder:'Chọn đơn vị tính',
							single: true,
							plus:true,
							idplus:'addUnit',
							idtxt:'txtUnit',
							src:'<?=url_tmpl();?>img/plus.png'
						});
						$("#unitid").multipleSelect("setSelects", [obj.idadd]);
					}
				}
			});
		});
		$('#unitids').multipleSelect({
			filter: true,
			placeholder:'Chọn đơn vị tính',
			single: true,
			plus:true,
			idplus:'addUnits',
			idtxt:'txtUnits',
			src:'<?=url_tmpl();?>img/plus.png'
		});
		$('#addUnits').live('click',function(){
			var txtUnit = $('#txtUnits').val();
			if(txtUnit == ''){
				 error("Đơn vị tính không được trống"); return false;
			}
			$.ajax({
				url : controller + 'addUnits',
				type: 'POST',
				async: false,
				data: {txtUnit:txtUnit},
				success:function(datas){
					var obj = $.evalJSON(datas); 
					if(obj.status == 0){
						 error("Đơn vị tính đã tồn tại"); 
					}
					else{
						$('#loadunits').html(obj.content);
						$('#unitids').multipleSelect({
							filter: true,
							placeholder:'Chọn đơn vị tính',
							single: true,
							plus:true,
							idplus:'addUnits',
							idtxt:'txtUnits',
							src:'<?=url_tmpl();?>img/plus.png'
						});
						$("#unitids").multipleSelect("setSelects", [obj.idadd]);
					}
				}
			});
		});
		$('#goods_tye_name').focus();
		$('#search').click(function(){
			$(".loading").show();
			searchList();	
		});
		$('#refresh').click(function(){
			$('.loading').show();
			refresh();
		});
		$('#save').click(function(){
			 save('save',id);
		});
		$('#edit').click(function(){
			var id = $("#id").val();
			if(id == ''){
				 toastr.error('Vui lòng chọn dữ liệu cần sửa.','Lỗi', {closeButton:true, timeOut:5000}); return false;
				 return false;
			}
			save('edit',id);
		});
		$('#delete').click(function(){ 
			 deleteItems('Bạn muốn xóa loại sản phẩm này');
		});	
		refresh();
	});
	function deleteItems(msg){
		var id = getCheckedId();
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
						url : controller + 'deletes',
						type: 'POST',
						async: false,
						data: {csrf_stock_name:token,id:id},
						success:function(datas){
							var obj = $.evalJSON(datas); 
							$('#token').val(obj.csrfHash);
							if(obj.status == 0){
								 error('Xóa không thành công','Lỗi'); 
							}
							else if(obj.status == -1){
								 error('Danh mục đã được thêm hàng hóa, bạn không đượng xóa.','Lỗi'); 
							}
							else{
								 success('Xóa thành công','Thông báo');
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
	}
	function save(func,id){
		search = getSearch();
		var obj = $.evalJSON(search); 
		if(obj.group_code == ''){
			error('Mã nhóm không được trống'); 
			$('#group_code').focus();
			return false;	
		}
		if(obj.group_name == ''){
			error('Tên nhóm không được trống'); 
			$('#group_code').focus();
			return false;	
		}
		if(obj.unitid == ''){
			error('Vui lòng chọn đơn vị tính'); return false;	
		}
		var token = $('#token').val();
		$('.loading').show();
		$.ajax({
			url : controller + func,
			type: 'POST',
			async: false,
			data: {csrf_stock_name:token,search:search , id:id},
			success:function(datas){
				$('.loading').hide();
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
					error('Loại hàng <?=getLanguage('all','exist')?>'); return false;		
				}
				else{
					refresh();
					if(func == 'save'){
						addSuccess();
					}
					else{
						editSuccess();
					}
				}
			},
			error : function(){
				$('.loading').hide();
				if(func == 'save'){
					error('<?=getLanguage('all','add_failed')?>'); return false;	
				}
				else{
					error('<?=getLanguage('all','edit_failed')?>'); return false;	
				}
			}
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
