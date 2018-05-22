<style title="" type="text/css">
	table col.c1 { width: 50px; }
	table col.c2 { width: 50px; }
	table col.c3 { width: 150px;}
	table col.c4 { width: 150px; }
	table col.c5 { width: 250px;}
	table col.c6 { width: 250px; }
	table col.c7 { width: auto;}
	.col-md-4{ white-space: nowrap !important;}
</style>

<!-- BEGIN PORTLET-->
<div class="portlet box blue">
	<div class="portlet-title">
		<?=$this->load->inc('breadcrumb');?>
	</div>
	<div class="portlet-body">
		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4">Serial number(<span class="red">*</span>)</label>
					<div class="col-md-8">
						<input type="text" name="sn" id="sn" placeholder="" class="searchs form-control" required />
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4">IMEI</label>
					<div class="col-md-8">
						<input type="text" name="imei" id="imei" placeholder="" class="searchs form-control" required />
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4">Mô tả</label>
					<div class="col-md-8">
						<input type="text" name="description" id="description" placeholder="" class="searchs form-control" required />
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
								<option value=""></option>
								<?php foreach($goods as $item){?>
									<option  value="<?=$item->id;?>"><?=$item->goods_code;?> - <?=$item->goods_name;?></option>
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
			<i class="fa fa-bars"><i class="mleft5">Có <span class="viewtotal"></span> <span class='lowercase'>serial</span></i></i>			
		</div>
		<div class="tools">
			<ul class="button-group pull-right"  style="margin-top:-5px; margin-bottom:5px;">
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
							<?php for($i=1; $i< 8; $i++){?>
								<col class="c<?=$i;?>">
							<?php }?>
							<tr>							
								<th><input type="checkbox" name="checkAll" id="checkAll" /></th>
								<th><?=getLanguage('all','stt')?></th>
								<th id="ord_c.sn">Serial Number</th>
								<th id="ord_c.imei">IMEI</th>
								<th id="ord_c.description">Mô tả</th>
								<th id="ord_c.goods_code">Hàng hóa</th>
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
							<?php for($i=1; $i < 8; $i++){?>
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
			save('save','');
		});
		$('#goodsid').multipleSelect({
			filter: true,
			placeholder:'Chọn hàng hóa',
			single: true,
			onClick(view){
				searchList();
			}
		});
		$('#edit').click(function(){
			var id = $("#id").val();
			if(id == ''){
				 error('Vui lòng chọn dữ liệu cần sửa.','Lỗi'); return false;
				 return false;
			}
			save('edit',id);
		});
		$('#delete').click(function(){ 
			 deleteItems('Bạn muốn xóa serial này');
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
		if(obj.goods_tye_name == ''){
			error('Tên loại hàng hóa <?=getLanguage('all','empty')?>'); return false;	
		}
		var token = $('#token').val();
		$('.loading').show();
		$.ajax({
			url : controller + func,
			type: 'POST',
			async: false,
			data: {csrf_stock_name:token,search:search , id:id},
			success:function(datas){
				var obj = $.evalJSON(datas); 
				$("#token").val(obj.csrfHash);
				$('.loading').hide();
				if(obj.status == 0){
					if(func == 'save'){
						error('<?=getLanguage('all','add_failed')?>'); return false;	
					}
					else{
						error('<?=getLanguage('all','edit_failed')?>'); return false;	
					}
				}
				else if(obj.status == -1){
					error('Serial đã tồn tại <?=getLanguage('all','exist')?>'); return false;		
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
    function funcList(obj){
		$('.edit').each(function(e){
			$(this).click(function(){ 
				 var sn = $('.sn').eq(e).html().trim();
				 var imei = $('.imei').eq(e).html().trim();
				 var description = $('.description').eq(e).html().trim();
				 var id = $(this).attr('id');
				 var goodsid = $(this).attr('goodsid');
				 $('#id').val(id);	
				 $('#sn').val(sn);
				 $('#imei').val(imei);
				 $('#description').val(description);
				 $("#goodsid").multipleSelect("setSelects", [goodsid]);
			});
			function getIDChecked(){
				return 1;	
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
