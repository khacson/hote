<style title="" type="text/css">
	table col.c1 { width: 50px; }
	table col.c2 { width: 50px; }
	table col.c3 { width: 150px;}
	table col.c4 { width: 120px;}
	table col.c5 { width: 120px;}
	table col.c6 { width: 180px;}
	table col.c7 { width: 150px;}
	table col.c8 { width: 80px;}
	table col.c9 { width: 70px;}
	table col.c10 {width: auto;}
	.col-md-4{ white-space: nowrap !important;}
</style>

<!-- BEGIN PORTLET-->
<div class="row">
	<?=$this->load->inc('breadcrumb');?>
</div>
<div class="portlet box blue mtop0">
	<div class="portlet-title">
		<div class="caption">
			<div class="brc mtop3"><i class="fa fa-bars"></i> <?=getLanguage('tim-thay');?> <span class="semi-bold viewtotal">0</span> <?=getLanguage('kho-hang');?></div>
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
							<?php for($i=1; $i< 11; $i++){?>
								<col class="c<?=$i;?>">
							<?php }?>
							<tr>							
								<th><input type="checkbox" name="checkAll" id="checkAll" /></th>
								<th><?=getLanguage('stt')?></th>						
								<th id="ord_c.warehouse_name"><?=getLanguage('ten-kho')?></th>
								<th id="ord_c.phone"><?=getLanguage('dien-thoai')?></th>
								<th id="ord_c.name_contact"><?=getLanguage('nguoi-lien-he')?></th>
								<th id="ord_c.address"><?=getLanguage('dia-chi')?></th>
								<th id="ord_c.branchid"><?=getLanguage('chi-nhanh')?></th>
								<th id="ord_c.isdedault"><?=getLanguage('mac-dinh')?></th>
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
							<?php for($i=1; $i < 11; $i++){?>
								<col class="c<?=$i;?>">
							<?php }?>
							<tr class="row-search">
								<td></td>
								<td></td>
								<td>
									<input type="text" name="warehouse_name" id="warehouse_name" class="searchs form-control " />
								</td>
								<td>
									<input type="text" name="phone" id="phone" class="searchs form-control " />
								</td>
								<td>
									<input type="text" name="name_contact" id="name_contact" class="searchs form-control " />
								</td>
								<td>
									<input type="text" name="address" id="address" class="searchs form-control " />
								</td>
								<td>
									<select name="branchid" id="branchid" class="combos tab-event" >
										<?php foreach ($branchs as $item) { ?>
											<option value="<?=$item->id;?>"><?=$item->branch_name;?></option>
										<?php } ?>
									</select>
								</td>
								<td></td>
								<td></td>
								<td></td>
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
	<div class="blockUI blockMsg blockElement" style="width: 30%;position: absolute;top: 15%;left:35%;text-align: center; z-index: 9999000;">
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
		$("#warehouse_name,#phone,#name_contact,#address").keyup(function() {
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
	function save(func,id){
		var id = $('#id').val(); 
		var func = 'save';
		if(id != ''){
			func = 'edit';
		}
		var search = getFormInput();
		var obj = $.evalJSON(search); 
		if(obj.warehouse_name == ''){
			warning("<?=getLanguage('ten-kho-khong-duoc-trong')?>"); return false;	
		}
		$('.loading').show();
		var token = $('#token').val();
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
				else if(obj.status == -2){
					warning("<?=getLanguage('them-toi-da')?> "+obj.count_warehouse+ " <?=getLanguage('kho hang')?>"); return false;		
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
	function init(){
		$('#provinceid').multipleSelect({
			filter: true,
			single: false,
			placeholder: "<?=getLanguage('chon-tinh-thanh-pho')?>",
			onClick: function(view) {
				var provinceid = getCombo('provinceid');
				var links = controller+'getDistric';
				var token = $('#token').val();
				$.ajax({					
					url: links,	
					type: 'POST',
					data: {csrf_token_gce:token,provinceid:provinceid},	
					success: function(data) {
						//var obj = $.evalJSON(data);
						$("#districid").html(data);
						$("#districid").multipleSelect({
							filter: true,
							placeholder:'<?=getLanguage('chon-quan-huyen')?>',
							single: false,
							onClick: function(view){
								searchList();
							}
						});
					}
				});
				searchList();
			}
		});
		$('#districid').multipleSelect({
			filter: true,
			placeholder:'<?=getLanguage('chon-quan-huyen')?>',
			single: false,
			onClick: function(view){
				searchList();
			}
		});
		$('#branchid').multipleSelect({
				filter: true,
				placeholder:"<?=getLanguage('chon-chi-nhanh')?>",
				single: false,
				onClick: function(view){
					searchList();
				}
		});
	}
    function funcList(obj){
		$('.edit').each(function(e){
			$(this).click(function(){ 
				 var warehouse_name = $('.warehouse_name').eq(e).html().trim();
				 //var warehouse_code = $('.warehouse_code').eq(e).html().trim();
				 var address = $('.address').eq(e).html().trim();
				 var name_contact = $('.name_contact').eq(e).html().trim();
				 var phone = $('.phone').eq(e).html().trim();
				 //var provinceid = $(this).attr('provinceid');
				 //var districid = $(this).attr('districid');
				 var branchid = $(this).attr('branchid');
				 var id = $(this).attr('id');
				 $('#id').val(id);	
				 $('#warehouse_name').val(warehouse_name);
				 $('#phone').val(phone);
				 //$('#warehouse_code').val(warehouse_code);
				 $('#address').val(address);		
				 $('#name_contact').val(name_contact);		
				 $('#branchid').multipleSelect('setSelects', branchid.split(','));
				 //$('#provinceid').multipleSelect('setSelects', provinceid.split(','));
					var links = controller+'getDistric';
					var token = $('#token').val();
					/*$.ajax({					
						url: links,	
						type: 'POST',
						data: {csrf_token_gce:token,provinceid:provinceid},	
						success: function(data) {
							//var obj = $.evalJSON(data);
							$("#districid").html(data);
							$("#districid").multipleSelect({
								filter: true,
								placeholder:'<?=getLanguage('chon-quan-huyen')?>',
								single: true
							});
							$('#districid').multipleSelect('setSelects', districid.split(','));
						}
					});
					*/

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