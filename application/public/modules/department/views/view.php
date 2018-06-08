<style title="" type="text/css">
	table col.c1 { width: 45px; }
	table col.c2 { width: 45px; }
	table col.c3 { width: 180px; }
	table col.c4 { width: 150px; }
	table col.c5 { width: 150px; }
	table col.c6 { width: 150px; }
	table col.c7 { width: 90px; }	
	table col.c8 { width: auto;}
</style>

<!-- BEGIN PORTLET-->
<div class="row">
	<?=$this->load->inc('breadcrumb');?>
</div>
<div class="portlet box blue mtop0">
	<div class="portlet-title">
		<div class="caption">
			 <div class="brc mtop3"><i class="fa fa-bars"></i> <?=getLanguage('tim-thay');?> <span class="semi-bold viewtotal">0</span> <?=getLanguage('tang-lau');?></div>		
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
				<?php if(isset($permission['add'])){?>
				<li id="save" data-toggle="modal" data-target="#myModalFrom">
					<button class="button">
						<i class="fa fa-plus"></i>
						<?=getLanguage('them-moi')?>
					</button>
				</li>
				<?php } ?>
				<?php if(isset($permission['edit'])){?>
				<li id="edit" data-toggle="modal" data-target="#myModalFrom">
					<button class="button">
						<i class="fa fa-save"></i>
						<?=getLanguage('sua')?>
					</button>
				</li>
				<?php } ?>
				<?php if(isset($permission['delete'])){?>
				<li id="delete">
					<button class="button">
						<i class="fa fa-times"></i>
						<?=getLanguage('xoa')?>
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
							<?php for($i=1; $i< 9; $i++){?>
								<col class="c<?=$i;?>">
							<?php }?>
							<tr>
								<th><input type="checkbox" id="checkAll" autocomplete="off" /></th>
								<th><?=getLanguage('stt');?></th>
								<th id="ord_d.departmanet_name"><?=getLanguage('phong-ban');?></th>
								<th id="ord_d.phone"><?=getLanguage('dien-thoai');?></th>
								<th id="ord_d.fax"><?=getLanguage('fax');?></th>
								<th id="ord_d.heads"><?=getLanguage('thu-truong');?></th>
								<th></th>
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
							<tr class="row-search">
								<td></td>
								<td></td>
								<td>
									<input type="text" name="departmanet_name" id="departmanet_name" class="searchs form-control tab-event" />
								</td>
								<td>
									<input type="text" name="phone" id="phone" class="searchs form-control tab-event" />
								</td>
								<td>
									<input type="text" name="fax" id="fax" class="searchs form-control tab-event" />
								</td>
								<td>
									<input type="text" name="heads" id="heads" class="searchs form-control tab-event" />
								</td>
								
								<td><td>
							</tr>
							<?php for($i=1; $i< 9; $i++){?>
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
	<div class="blockUI blockOverlay" style="width: 100%;height: 100%;top:0px;left:0px;position: absolute;background-color: rgb(0,0,0);opacity: 0.1;z-index: 9999000;">
	</div>
	<div class="blockUI blockMsg blockElement" style="width: 30%;position: absolute;top: 0%;left:35%;text-align: center; z-index: 9999000;">
		<img src="<?=url_tmpl()?>img/ajax_loader.gif" style="z-index: 2;position: absolute; z-index: 9999000;"/>
	</div>
</div> 
<!--S Modal -->
<div id="myModalFrom" class="modal fade" role="dialog">
  <div class="modal-dialog w500">
    <!-- Modal content-->
    <div class="modal-content ">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="modalTitleFrom"></h4>
      </div>
      <div id="loadContentFrom" class="modal-body">
      </div>
      <div class="modal-footer">
		 <button id="actionSave" type="button" class="btn btn-info" ><i class="fa fa-save" aria-hidden="true"></i>  <?=getLanguage('luu');?></button>
        <button id="close" type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> <?=getLanguage('dong');?></button>
      </div>
    </div>
  </div>
</div>
<!--E Modal -->
<input type="hidden" name="id" id="id" />
<script>
	var controller = '<?=base_url().$routes;?>/';
	var csrfHash = '';
	var cpage = 0;
	var search;
	$(function(){
		init();
		refresh();
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
			$('#id').val('');
			loadForm();
		});
		$('#edit').click(function(){
			var id = $('#id').val();
			if(id == ''){
				warning(cldcs);
				return false;
			} 
			loadForm(id);
		});
		$("#delete").click(function(){
			var id = getCheckedId();
			if(id == ''){ return false;}
			confirmDelete(id);
			return false
		});
		$(document).keypress(function(e) {
			 var id = $("#id").val();
			 if (e.which == 13) {
				$(".loading").show();
				searchList();
			 }
		});
		$('#actionSave').click(function(){
			save();
		});	
		
		searchFunction();
	});
	function searchFunction(){
		$("#departmanet_name,#phone,#fax,#heads").keyup(function() {
			searchList();	
		});
	}
	function loadForm(id){
		$.ajax({
			url : controller + 'form',
			type: 'POST',
			async: false,
			data:{id:id},  
			success:function(datas){
				var obj = $.evalJSON(datas); 
				$('#loadContentFrom').html(obj.content);
				$('#modalTitleFrom').html(obj.title);
				$('#input_distric_name').select();
				$('#id').html(obj.id);
			}
		});
	}
	function init(){
		$('#branchid').multipleSelect({
			filter: true,
			single: false,
			placeholder: "<?=getLanguage('chon-chi-nhanh')?>",
			onClick: function(view){
				searchList();
			}
		});
	}
	function save(){
		var id = $('#id').val(); 
		var func = 'save';
		if(id != ''){
			func = 'edit';
		}
		var search = getFormInput();
		var obj = $.evalJSON(search); 
		if(obj.floor_name == ''){
			warning('<?=getLanguage('tang-lau-khong-duoc-trong');?>'); return false;	
		}
		var token = $('#token').val();
		$('.loading').show();
		$.ajax({
			url : controller + func,
			type: 'POST',
			async: false,
			data: {search:search , id:id},
			success:function(datas){
				var obj = $.evalJSON(datas); 
				$("#token").val(obj.csrfHash);
				$('.loading').hide();
				if(obj.status == 0){
					if(id == ''){
						error(tmktc); return false;	
					}
					else{
						error(sktc); return false;	
					}
				}
				else if(obj.status == -1){
					error(dldtt); return false;		
				}
				else{
					if(id == ''){
						success(tmtc); 
					}
					else{
						success(stc); 
					}
					refresh();
				}
				$('.loading').hide();
			},
			error : function(){
				$('.loading').hide();
				if(id == ''){
					error(tmktc); return false;	
				}
				else{
					error(sktc); return false;	
				}
			}
		});
	}
    function funcList(obj){
		$('.edit').each(function(e){
			$(this).click(function(){ 
				 /*var floor_name = $('.floor_name').eq(e).html().trim();
				 var bank_name = $('.bank_name').eq(e).html().trim();
				 var description = $('.description').eq(e).html().trim();
				 var id = $(this).attr('id');
				 $('#id').val(id);	
				 $('#floor_name').val(floor_name);
				 $('#bank_name').val(bank_name);
				 $('#description').val(description);*/
			});
		});	
		$('.edititem').each(function(e){
			$(this).click(function(){
				var id = $(this).attr('id');
				loadForm(id);
			});
		});
		$('.deleteitem').each(function(e){
			$(this).click(function(){
				var id = $(this).attr('id');
				confirmDelete(id);
				return false
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

