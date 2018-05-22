<style title="" type="text/css">
	table col.c1 { width: 50px; }
	table col.c2 { width: 50px; }
	table col.c3 { width: 80px;}
	table col.c4 { width: 180px; }
	table col.c5 { width: 80px;}
	table col.c6 { width: 100px; }
	table col.c7 { width: 120px; }
	table col.c8 { width: 150px;}
	table col.c9 { width: 100px; }
	table col.c10 { width: 150px; }
	table col.c11 {width: auto;}
	.col-md-4{ white-space: nowrap !important;}
</style>

<!-- BEGIN PORTLET-->
<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-search" style="margin-top:2px; margin-left:10px;"></i>
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
					<label class="control-label col-md-4">Mã nhân viên (<span class="red">*</span>)</label>
					<div class="col-md-8">
						<input type="text" name="employee_code" id="employee_code" placeholder=""  maxlength="10" class="searchs form-control tab-event"  />
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4">Họ tên (<span class="red">*</span>)</label>
					<div class="col-md-8">
						<input type="text" name="employee_name" id="employee_name" placeholder=""  maxlength="50" class="searchs form-control tab-event"  />
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4">Giới tính</label>
					<div class="col-md-8">
						<select id="sex" name="sex" class="combos tab-event" >
							<option value=""></option>
							<option value="1">Nam</option>
							<option value="2">Nữ</option>
							<option value="3">Giới tính khác</option>
						</select>
					</div>
				</div>
			</div>
		</div>
		<div class="row mtop10">
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4">CMND (<span class="red">*</span>)</label>
					<div class="col-md-8">
						<input type="text" name="identity" id="identity" placeholder="" class="searchs form-control tab-event"  maxlength="15"  />
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4">Ngày cấp</label>
					 <div class="col-md-8 input-group date date-picker" data-date-format="dd-mm-yyyy">
						<input type="text" id="identity_date" placeholder="dd-mm-yyyy" name="identity_date"  maxlength="12" class="form-control searchs tab-event" >
                        <span class="input-group-btn ">
                            <button class="btn default btn-picker" type="button"><i class="fa fa-calendar "></i></button>
                        </span>
                    </div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4">Nơi cấp</label>
					<div class="col-md-8">
						<input type="text" name="identity_from" id="identity_from" placeholder=""  maxlength="50" class="searchs form-control tab-event" />
					</div>
				</div>
			</div>
		</div>
		<div class="row mtop10">
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4">Sinh nhật</label>
					 <div class="col-md-8 input-group date date-picker" data-date-format="dd-mm-yyyy">
						<input type="text" id="birthday" placeholder="dd-mm-yyyy" name="birthday" class="form-control searchs tab-event"  maxlength="12">
                        <span class="input-group-btn ">
                            <button class="btn default btn-picker" type="button"><i class="fa fa-calendar "></i></button>
                        </span>
                    </div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4">Điên thoại</label>
					<div class="col-md-8">
						<input type="text" name="phone" id="phone" placeholder="" class="searchs form-control tab-event"  maxlength="50" />
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4">CN/cửa hàng</label>
					<div class="col-md-8">
						<select id="branchid" name="branchid" class="combos tab-event" >
							<option value=""></option>
							<?php foreach($branchs as $item){?>
								<option value="<?=$item->id;?>"><?=$item->branch_name;?></option>
							<?php }?>
						</select>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
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
		<div class="caption">
			<i class="fa fa-bars" style="margin-left:10px;"><i class="mleft5">Có <span class="viewtotal"></span> <span class='lowercase'
			>nhân viên bán hàng</span></i></i>			
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
							<?php for($i=1; $i< 12; $i++){?>
								<col class="c<?=$i;?>">
							<?php }?>
							<tr>							
								<th><input type="checkbox" name="checkAll" id="checkAll" /></th>
								<th><?=getLanguage('all','stt')?></th>								
								<th id="ord_c.employee_code">Mã NV</th>
								<th id="ord_c.employee_name">Họ tên</th>
								<th id="ord_c.sex">Giới tính</th>
								<th id="ord_c.identity">CMND</th>
								<th id="ord_c.identity_date">Ngày cấp</th>
								<th id="ord_c.identity_from">Nơi cấp</th>
								<th id="ord_c.birthday">Sinh nhật</th>
								<th  id="ord_c.branchid">CN/cửa hàng</th>
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
							<?php for($i=1; $i < 12; $i++){?>
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
		$('#delete').click(function(){ 
			 deleteItem('Bạn muốn xóa nhân viên bán hàng');
		});
	});
	function save(func,id){
		search = getSearch();
		var obj = $.evalJSON(search); 
		if(obj.employee_code == ''){
			error('Mã nhân viên <?=getLanguage('all','empty')?>'); return false;	
		}
		if(obj.employee_name == ''){
			error('Họ tên <?=getLanguage('all','empty')?>'); return false;	
		}
		if(obj.identity == ''){
			error('CMND <?=getLanguage('all','empty')?>'); return false;	
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
					error('Nhân viên <?=getLanguage('all','exist')?>'); return false;		
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
	function init(){
		$('#branchid').multipleSelect({
			filter: true,
			placeholder:'Chọn chi nhánh',
			single: true
		});
		$('#sex').multipleSelect({
			filter: true,
			placeholder:'Chọn giới tính',
			single: true
		});
	}
    function funcList(obj){
		$('.edit').each(function(e){
			$(this).click(function(){ 
				 var employee_code = $('.employee_code').eq(e).html().trim();
				 var employee_name = $('.employee_name').eq(e).html().trim();
				 var identity = $('.identity').eq(e).html().trim();
				 var identity_from = $('.identity_from').eq(e).html().trim();
				 var birthday = $('.birthday').eq(e).html().trim();
				 var identity_date = $('.identity_date').eq(e).html().trim();
				 
				 var id = $(this).attr('id');
				 var sex = $(this).attr('sex');
				 var branchid = $(this).attr('branchid');
				 $('#id').val(id);	
				 $('#employee_code').val(employee_code);
				 $('#employee_name').val(employee_name);
				 $('#identity').val(identity);
				 $('#identity_from').val(identity_from);
				 $('#birthday').val(birthday);
				 $('#identity_date').val(identity_date);
				 $('#sex').multipleSelect('setSelects', sex.split(','));
				 $('#branchid').multipleSelect('setSelects', branchid.split(','));
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
