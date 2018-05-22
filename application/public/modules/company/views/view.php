<style title="" type="text/css">
	table col.c1 { width: 50px; }
	table col.c2 { width: 50px; }
	table col.c3 { width: 180px;}
	table col.c4 { width: 120px;}
	table col.c5 { width: 120px;}
	table col.c6 { width: 120px;}
	table col.c7 { width: 200px;}
	table col.c8 { width: 70px;}
	table col.c9 { width: 200px;}
	table col.c10 { width: 120px;}
	table col.c11 { width: 120px;}
	table col.c12 { width: 70px;}
	table col.c13 { width: auto;}
	.col-md-4{ white-space: nowrap !important;}
</style>
<div class="row">
	<?=$this->load->inc('breadcrumb');?>
</div>
<div class="portlet box blue mtop0">
	<div class="portlet-title">
		<div class="caption">
			 <div class="brc mtop3"><i class="fa fa-bars"></i> <?=getLanguage('tim-thay');?> <span class="semi-bold viewtotal">0</span> <?=getLanguage('cong-ty');?></div>		
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
							<?php for($i=1; $i< 14; $i++){?>
								<col class="c<?=$i;?>">
							<?php }?>
							<tr>							
								<th><input type="checkbox" name="checkAll" id="checkAll" /></th>
								<th><?=getLanguage('stt')?></th>								
								<th id="ord_c.company_name"><?=getLanguage('cong-ty');?></th>
								<th id="ord_c.phone"><?=getLanguage('dien-thoai');?></th>
								<th id="ord_c.mst"><?=getLanguage('mst');?></th>
								<th id="ord_c.fax"><?=getLanguage('fax');?></th>
								<th id="ord_c.email"><?=getLanguage('email');?></th>
								<th><?=getLanguage('logo');?></th>
								<th id="ord_c.address"><?=getLanguage('dia-chi');?></th>
								<th id="ord_p.province_name"><?=getLanguage('tinh-thanh-pho');?></th>
								<th id="ord_d.distric_name"><?=getLanguage('quan-huyen');?></th>
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
							<?php for($i=1; $i < 14; $i++){?>
								<col class="c<?=$i;?>">
							<?php }?>
							<tr class="row-search">
								<td></td>
								<td></td>
								<td>
									<input type="text" name="company_name" id="company_name" placeholder="" class="searchs form-control"  maxlength="100"  />
								</td>
								<td>
									<input type="text" name="phone" id="phone" placeholder="" class="searchs form-control"  maxlength="20"  />
								</td>
								<td>
									<input type="text" name="mst" id="mst" placeholder="" class="searchs form-control"  maxlength="15"  />
								</td>
								<td>
									<input type="text" name="fax" id="fax" placeholder="" class="searchs form-control"  maxlength="15"  />
								</td>
								<td>
									<input type="text" name="email" id="email" placeholder="" class="searchs form-control"  maxlength="15"  />
								</td>
								<td></td>
								<td>
									<input type="text" name="address" id="address" placeholder="" class="searchs form-control"  maxlength="15"  />
								</td>
								<td>
									<select id="provinceid" name="provinceid" class="combos" >
										<?php foreach($provinces as $item){?>
											<option value="<?=$item->id;?>"><?=$item->province_name;?></option>
										<?php }?>
									</select>
								</td>
								<td>
									<span id="loadDistric">
										<select id="districid" name="districid" class="combos tab-event" >
											<option value=""></option>
										</select>
									</span>
								</td>
								<td><td>
								<td><td>
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
	<div class="blockUI blockOverlay" style="width: 100%;height: 100%;top:0px;left:0px;position: absolute;background-color: rgb(0,0,0);opacity: 0.1;z-index: 1000;">
	</div>
	<div class="blockUI blockMsg blockElement" style="width: 30%;position: absolute;top: 15%;left:35%;text-align: center;">
		<img src="<?=url_tmpl()?>img/ajax_loader.gif" style="z-index: 2;position: absolute;"/>
	</div>
</div> 
<!--S Modal -->
<div id="myModalFrom" class="modal fade" role="dialog">
  <div class="modal-dialog w900">
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
		$("#close").click(function(){
			$(".loading").show();
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
		$("#company_name,#phone,#mst,#fax,#email,#address").keyup(function() {
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
	function save(){
		var id = $('#id').val(); 
		var func = 'save';
		if(id != ''){
			func = 'edit';
		}
		var search = getFormInput();
		var obj = $.evalJSON(search); 
		if(obj.company_name == ''){
			warning("<?=getLanguage('cong-ty-khong-duoc-trong')?>"); return false;	
		}
		if(obj.phone == ''){
			warning("<?=getLanguage('dien-thoai-khong-duong-trong')?>"); return false;	
		}
		if(obj.branchid == ''){
			warning("<?=getLanguage('chi-nhanh-khong-duong-trong')?>"); return false;	
		}
		if(obj.warehouseid == ''){
			warning("<?=getLanguage('so-kho-khong-duoc-trong')?>"); return false;	
		}
		var token = $('#token').val();
		$('.loading').show();
		var data = new FormData();
		var objectfile = document.getElementById('imageEnable').files;
		data.append('userfile', objectfile[0]);
		data.append('search', search);
		data.append('id',id);
		$.ajax({
			url : controller + func,
			type: 'POST',
			async: false,
			data: data,
			enctype: 'multipart/form-data',
			processData: false,  
			contentType: false,   
			success:function(datas){
				var obj = $.evalJSON(datas); 
				$("#token").val(obj.csrfHash);
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
	function init(){
		$('#provinceid').multipleSelect({
			filter: true,
			single: false,
			placeholder: '<?=getLanguage('chon-tinh-thanh-pho')?>',
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
							single: true,
							onClick: function(view) {
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
			single: true,
			onClick: function(view) {
				 searchList();
			}
		});
	}
    function funcList(obj){
		$('.edit').each(function(e){
			$(this).click(function(){ 
				 var company_name = $('.company_name').eq(e).html().trim();
				 var phone = $('.phone').eq(e).html().trim();
				 var fax = $('.fax').eq(e).html().trim();
				 var email = $('.email').eq(e).html().trim();
				 var mst = $('.mst').eq(e).html().trim();
				 var address = $('.address').eq(e).html().trim();
				 var provinceid = $(this).attr('provinceid');
				 var districid = $(this).attr('districid');
				 var count_room = $(this).attr('count_room');
				 var count_branch = $(this).attr('count_branch');
				 var setuppo = $(this).attr('setuppo');
				
				 var id = $(this).attr('id');
				 $('#id').val(id);	
				 $('#company_name').val(company_name);
				 $('#phone').val(phone);		
				 $('#fax').val(fax);
				 $('#email').val(email);
				 $('#address').val(address);	
				 $('#count_room').val(count_room);
				 $('#count_branch').val(count_branch);		
				 $('#mst').val(mst);	
				 
				 $('#setuppo').multipleSelect('setSelects', setuppo.split(','));
				 $('#provinceid').multipleSelect('setSelects', provinceid.split(','));
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
								placeholder:'<?=getLanguage('select_distric')?>',
								single: true
							});
							$('#districid').multipleSelect('setSelects', districid.split(','));
						}
					});
				    //$('#warehouseid').multipleSelect('setSelects', warehouseid.split(','));
					//$('#branchid').multipleSelect('setSelects', branchid.split(','));
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
<script src="<?=url_tmpl();?>assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
