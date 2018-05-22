<!--<link href="<?=url_tmpl();?>css/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src="<?=url_tmpl();?>js/jquery-ui.js" type="text/javascript"></script>-->
<style title="" type="text/css">
	table col.c1 { width: 50px; }
	table col.c2 { width: 50px; }
	table col.c3 { width: 180px; }
	table col.c4 { width: 150px; }
	table col.c5 { width: 300px; }
	table col.c6 { width: 90px; }
	table col.c7 { width: 70px; }
	table col.c8 { width: auto;}
</style>
<!-- BEGIN PORTLET-->
<div class="row">
<?=$this->load->inc('breadcrumb');?>
</div>
<div class="portlet box blue mtop0">
	<div class="portlet-title">
        <div class="caption">
            <i style="margin-left:10px;"><?=getLanguage('tim-thay');?> <span class='viewtotal'>0</span> <?=getLanguage('nhom-quyen')?></i>
        </div>
        <div class="tools">
            <ul class="button-group pull-right" style="margin-top:-5px; margin-bottom:5px;">
							<li id="search">
								<button class="button">
									<i class="fa fa-search"></i>
									<?=getLanguage('tim-kiem');?>
								</button>
							</li>
							<li id="refresh" >
								<button class="button">
									<i class="fa fa-refresh"></i>
									<?=getLanguage('lam-moi');?>
								</button>
							</li>
							<?php if(isset($permission['add'])){?>
							<li id="save" data-toggle="modal" data-target="#myModalFrom">
								<button class="button">
								<i class="fa fa-plus"></i>
								<?=getLanguage('them-moi');?>
								</button>
							</li>
							<?php }?>
							<?php if(isset($permission['edit'])){?>
							<li id="edit" data-toggle="modal" data-target="#myModalFrom">
								<button class="button">
									<i class="fa fa-save"></i>
									<?=getLanguage('sua');?>
								</button>
							</li>
							<?php }?>
							<?php if(isset($permission['delete'])){?>
							<li id="deletes">
								<button type="button" class="button">
									<i class="fa fa-times"></i>
									<?=getLanguage('xoa');?>
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
						<table width="100%" cellspacing="0" border="1" >
							<?php for($i=1; $i< 9; $i++){?>
								<col class="c<?=$i;?>">
							<?php }?>
							<tr>
								
								<th><input type="checkbox" id="checkAll" autocomplete="off" /></th>
								<th><?=getLanguage('stt')?></th>
								<th id="ord_g.groupname"><?=getLanguage('nhom-quyen');?></th>
								<th id="ord_g.grouptype"><?=getLanguage('loai-nhom');?></th>
								<th id="ord_g.companyname"><?=getLanguage('cong-ty');?></th>
								<th><?=getLanguage('phan-quyen')?></th>
								<th></th><th></th>
							</tr>
						</table>
					</div>
				</div>
				<!--end header-->
				<!--body-->
				<div id="data">
					<div id="gridView">
						<table id="tbbody" width="100%" cellspacing="0" border="1">
							<?php for($i=1; $i< 9; $i++){?>
								<col class="c<?=$i;?>">
							<?php }?>
							<tr class="row-search">
								<td></td>
								<td></td>
								<td>
									<input type="text" name="product_name" id="product_name" class="searchs form-control tab-event" />
								</td>
								<td>
									<select name="grouptype"  class="combos" id="grouptype">
										<option value=""></option>
										<?php if(empty($login->companyid)){?>
										<option value="1"><?=getLanguage('rot');?></option>
										<option value="2"><?=getLanguage('admin');?></option>
										<?php }?>
										<option value="3"><?=getLanguage('quan-ly');?></option>
										<option value="4"><?=getLanguage('nhan-vien');?></option>
									</select>
								</td>
								<td>
									<input type="text" name="companyname" id="companyname" class="searchs form-control tab-event" />
								</td>
								</td><td>
								</td><td>
							</tr>
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
	<div class="blockUI blockMsg blockElement" style="width: 30%;position: absolute;top: 15%;left:35%;text-align: center;">
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
		 <button id="actionSave" type="button" class="btn btn-info" ><i class="fa fa-save" aria-hidden="true"></i>  <?=getLanguage('save');?></button>
        <button id="close" type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> <?=getLanguage('close');?></button>
      </div>
    </div>
  </div>
</div>
<!--E Modal -->
<!--S Modal -->
<div id="myModalFromRight" class="modal fade" role="dialog">
  <div class="modal-dialog w500">
    <!-- Modal content-->
    <div class="modal-content ">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="modalTitleFromRight"><?=getLanguage('phan-quyen')?></h4>
      </div>
      <div id="loadContentFromRight" class="modal-body">
      </div>
      <div class="modal-footer">
		 <button id="saverights" type="button" class="btn btn-info" ><i class="fa fa-save" aria-hidden="true"></i>  <?=getLanguage('save');?></button>
        <button id="close" type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> <?=getLanguage('close');?></button>
      </div>
    </div>
  </div>
</div>
<!--E Modal -->
<!-- ui-dialog -->
<input type="hidden" name="id" id="id" />
<script>
	var controller = '<?=$controller;?>/';
	var csrfHash = '<?=$csrfHash;?>';
	var table;
	var cpage = 0;
	var search;
	var routes = '<?=$routes;?>';
	$(function(){	
		$('#id').val('');
		$("#grouptype").multipleSelect({
			filter: true,
			placeholder:"<?=getLanguage('chon-nhom-quyen');?>",
			single: true,
			onClick: function(view){
				searchList();
			}
		});
		$("#companyid").multipleSelect({
			filter: true,
			placeholder:"<?=getLanguage('chon-cong-ty');?>",
			single: true,
			onClick: function(view){
				searchList();
			}
		});
		refresh();
		$("#search").click(function(){
			$(".loading").show();
			searchList();	
		});
		$("#refresh").click(function(){
			$(".loading").show();
			refresh();
		});
		$("#deletes").click(function(){ 
			deleteItem('Bạn muốn xóa nhóm quyền');
		});
		/*$( "#dialog" ).dialog({
			autoOpen: false,
			width: 400,
			height:460,
			modal:false
		});*/
		$('#save').click(function(){
			$('#id').val('');
			loadForm();
		});
		$('#edit').click(function(){
			var id = $('#id').val();
			loadForm(id);
		});
		$('#actionSave').click(function(){
			save();
		});
		$('#saverights').click(function(){
			saveRight();
		});
		searchFunction();
	});
	function searchFunction(){
		$("#groupname").keyup(function() {
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
				$('#id').html(obj.id);
			}
		});
	}
	function loadFormRight(id){
		$.ajax({
			url : controller + 'getRight',
			type: 'POST',
			async: false,
			data:{id:id},  
			success:function(datas){
				var obj = $.evalJSON(datas); 
				$('#loadContentFromRight').html(obj.content);
				$('#id').html(obj.id);
			}
		});
	}
	function saveRight(){
		var right = getRight();
		var id = $("#id").val(); 
		$.ajax({
			url : controller + 'setRight',
			type: 'POST',
			async: false,
			data: {id:id, right:right},
			success:function(datas){
				var obj2 = $.evalJSON(datas);
				success("<?=getLanguage('phan-quyen-thanh-cong')?>");
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
		if(obj.groupname == ""){
			warning("<?=getLanguage('nhom-quyen-khong-duoc-trong');?>");
			$("#groupname").focus();
			return false;		
		}
		var id = $("#id").val();
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
				if(func == 'edit'){
					if(obj.status == 0){
						warning("<?=getLanguage('sua-khong-thanh-cong')?>"); return false;		
					}
					else if(obj.status == -1){
						warning("<?=getLanguage('nhom-quyen-da-ton-tai')?>"); return false;		
					}
					else{
						success("<?=getLanguage('sua-thanh-cong')?>");
						searchList();
					}
				}
				else if(func == 'save'){
					if(obj.status == 0){
						warning("<?=getLanguage('them-moi-khong-thanh-cong')?>"); return false;		
					}
					else if(obj.status == -1){
						warning("<?=getLanguage('nhom-quyen-da-ton-tai')?>"); return false;		
					}
					else{
						success("<?=getLanguage('them-moi-thanh-cong')?>");
						searchList();
					}
				}
			},
			error : function(){
				$('.loading').hide();
				if(id == ''){
					error("<?=getLanguage('sua-khong-thanh-cong')?>"); return false;
				}
				else{
					error("<?=getLanguage('them-moi-khong-thanh-cong')?>"); return false;
				}
			}
		});
	}
    function funcList(obj){
		$(".edit").each(function(e){
			$(this).click(function(){ 
				 var groupname = $(".groupname").eq(e).html().trim();
				 var grouptype = $(this).attr('grouptype');
				 var companyid = $(this).attr('companyid');
				 var id = $(this).attr('id');
				 $("#id").val(id);	
				 $("#groupname").val(groupname);	
				 $("#grouptype").multipleSelect('setSelects', grouptype.split(','));
				 $("#companyid").multipleSelect('setSelects', companyid.split(','));
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
		$('.rights').each(function(e){
			$(this).click(function(){
				var id = $(this).attr('id');
				loadFormRight(id);
			});
		});
	}
	function refresh(){
		$(".loading").show();
		$(".searchs").val("");
		$('#grouptype,#schoolid').multipleSelect('uncheckAll');
		csrfHash = $('#token').val();
		search = getSearch();
		getList(cpage,csrfHash);	
	}
	function searchList(){
		search = getSearch();
		getList(cpage,csrfHash);	
	}
</script>
<script src="<?=url_tmpl();?>js/right.js" type="text/javascript"></script>
