<style title="" type="text/css">
	table col.c1 { width: 70px; }
	table col.c2 { width: 50px; }
	table col.c3 { width: 50px; }
	table col.c4 { width: 130px; }
	table col.c5 { width: 150px; }
	table col.c6 { width: 150px; }
	table col.c7 { width: 110px; }
	table col.c8 { width: 180px; }
	table col.c9 { width: 80px; }
	table col.c10 { width: 80px; }
	table col.c11 { width: 150px; }
	table col.c12 { width: 150px; }
	table col.c13 { width: 200px; }
	table col.c14 { width: auto; }
</style>
<div class="row">
<?=$this->load->inc('breadcrumb');?>
</div>
<div class="portlet box blue mtop0">
	<div class="portlet-title">
        <div class="caption">
            <i class="fa fa-user-plus mtop5 f16 color1"></i> <i style="margin-left:10px;"><?=getLanguage('tim-thay');?> <span class='viewtotal'>0</span> <?=getLanguage('tai-khoan')?></i>
        </div>
        <div class="tools">
           <ul class="button-group pull-right" style="margin-top:-5px; margin-bottom:5px;">
						<li id="search">
							<button type="button" class="button">
								<i class="fa fa-search"></i>
								<?=getLanguage('tim-kiem')?>
							</button>
						</li>
						<li id="refresh">
							<button type="button" class="button">
								<i class="fa fa-refresh"></i>
								<?=getLanguage('lam-moi')?>
							</button>
						</li>
						<?php if(isset($permission['add'])){?>
						<li id="save">
							<button type="button" class="button" data-toggle="modal" data-target="#myModalFrom"> 
								<i class="fa fa-plus"></i>
								<?=getLanguage('them-moi')?>
							</button>
						</li>
						<?php }?>
						<?php if(isset($permission['edit'])){?>
						<li id="edit">
							<button type="button" class="button" data-toggle="modal" data-target="#myModalFrom">
								<i class="fa fa-save"></i>
								<?=getLanguage('sua')?>
							</button>
						</li>
						<?php }?>
						<?php if(isset($permission['delete'])){?>
						<li id="delete">
							<button type="button" class="button">
								<i class="fa fa-times"></i>
								<?=getLanguage('xoa')?>
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
							<?php for($i=1; $i< 15; $i++){?>
								<col class="c<?=$i;?>">
							<?php }?>
							<tr>
								<th></th>
								<th width="40px" class="text-center"><input type="checkbox" name="checkAll" id="checkAll" /></th>
								<th><?=getLanguage('stt')?></th>
								<th><?=getLanguage('tai-khoan')?></th>
								<th><?=getLanguage('ho-ten')?></th>
								<th><?=getLanguage('nhom-quyen')?></th>
								<th><?=getLanguage('dien-thoai')?></th>
								<th><?=getLanguage('email')?></th>
								<th><?=getLanguage('hinh-dai-dien')?></th>
								<th><?=getLanguage('chu-ky')?></th>
								<th><?=getLanguage('cong-ty')?></th>
								<th><?=getLanguage('chi-nhanh')?></th>
								<th><?=getLanguage('phong-ban')?></th>
								
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
							<?php for($i=1; $i< 15; $i++){?>
								<col class="c<?=$i;?>">
							<?php }?>
							<tr class="row-search">
								<td></td>
								<td></td>
								<td>
									<input type="text" name="username" id="username" class="searchs form-control" maxlength="50" />
								</td>
								<td>
									<input type="text" name="fullname" id="fullname" class="searchs form-control" maxlength="70" />
								</td>
								<td>
									<select name="groupid" id="groupid" class="combos" >
										<option value=""></option>
										<?php foreach ($groups as $item) { ?>
											<option value="<?=$item->id;?>"><?=$item->groupname;?></option>
										<?php } ?>
									</select>
								</td>
								<td>
									<input type="text" name="mobile" id="mobile" class="searchs form-control" maxlength="70" />
								</td>
								<td>
									<input type="text" name="email" id="email" class="searchs form-control" maxlength="70" />
								</td>
								<td></td>
								<td></td>
								<td></td>
								<td>
									<select name="branchid" id="branchid" class="combos" >
										<option value=""></option>
										<?php foreach ($branchs as $item) { ?>
											<option value="<?=$item->id;?>"><?=$item->branch_name;?></option>
										<?php } ?>
									</select>
								</td>
								<td>
									<select name="departmentid" id="departmentid" class="combos" >
										<option value=""></option>
										<?php foreach ($departments as $item) { ?>
											<option value="<?=$item->id;?>"><?=$item->departmanet_name;?></option>
										<?php } ?>
									</select>
								</td>
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
  <div class="modal-dialog w900">
    <!-- Modal content-->
    <div class="modal-content ">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="modalTitleFrom">Thêm mới</h4>
      </div>
      <div id="loadContentFrom" class="modal-body">
      </div>
      <div class="modal-footer">
		 <button id="actionSaves" type="button" class="btn btn-info" ><i class="fa fa-save" aria-hidden="true"></i>  <?=getLanguage('luu');?></button>
        <button id="close" type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> <?=getLanguage('dong');?></button>
      </div>
    </div>
  </div>
</div>
<input type="hidden" name="id" id="id" />
<!--E Modal -->
<script>
	var controller = '<?=base_url().$routes;?>/';
	var csrfHash = '<?=$csrfHash;?>';
	var cpage = 0;
	var search;
	var companyid = parseInt('<?=$companyid;?>');
	var iswarehouse = parseInt('<?=$iswarehouse;?>');
	var isbranh = parseInt('<?=$isbranh;?>');	
	var base = '<?=base_url();?>';
	$(function(){
		$('#id').val('');
		init();
		refresh();
		$('#refresh').click(function(){
			$(".loading").show();
			refresh();
		});
		$('#search').click(function(){
			$('.loading').show();
			searchList();	
		});
		$('#save').click(function(){
			$('#id').val('');
			loadForm();
		});
		$('#edit').click(function(){
			var id = $('#id').val();
			if(id == ''){
				warning("<?=getLanguage('chon-tai-khoan');?>");
				return false;
			} 
			loadForm();
		});
		$('#delete').click(function(){ 
			deleteItem("<?=getLanguage('ban-muon-xoa-tai-khoan');?>");
		});
	});
	$(document.body).on('click', '#actionSaves',function (){
		save();
	});
	function save(){  
		var id = $('#id').val();
		var func = 'save';
		if(id != ''){
			func = 'edit';
		}
		else{
			var password = $('#input_password').val();
			var cfpassword = $('#input_cfpassword').val();
			if(password != '' && password != cfpassword){
				warning('<?=getLanguage('xac-nhan-mat-khau-khong-dung');?>');
				return false;
			}
		}
		var search = getFormInput(); 
		var obj = $.evalJSON(search); 
		if(obj.username == ''){
			warning('<?=getLanguage('tai-khoan-khong-duong-trong');?>'); 
			$("#username").focus();
			return false;		
		}
		if(id == ''){
			if(obj.password == ''){
				warning('<?=getLanguage('mat-khau-khong-duoc-trong');?>');
				return false;
			}	
			if(obj.password != obj.cfpassword){
				warning('<?=getLanguage('xac-nhan-mat-khau-khong-dung');?>');
				return false;
			}	
		}
		else{
			if(obj.password != '' && (obj.password != obj.cfpassword)){
				warning('<?=getLanguage('xac-nhan-mat-khau-khong-dung');?>');
				return false;
			}	
		}
		if(obj.fullname==""){
			warning('<?=getLanguage('ho-ten-khong-duoc-trong');?>');
			return false;
		}	
		if(!validateEmail(obj.email) && obj.email != ""){
			warning('<?=getLanguage('email-khong-dung-dinh-dang');?>'); 
			$('#email').focus();
			return false;	
		}			
		if(obj.groupid == ''){
			warning('<?=getLanguage('nhom-quyen-khong-duong-trong');?>'); 
			$('#username').focus();
			return false;		
		}
		$('.loading').show();
		var data = new FormData();
		var objectfile = document.getElementById('imageEnable').files;
		data.append('avatarfile', objectfile[0]);
		var signatures = document.getElementById('imageEnable2').files;
		data.append('signatures', signatures[0]);
		data.append('search', search);
		data.append('id',id);
		$.ajax({
			url : controller + func,
			type: 'POST',
			async: false,
			data:data,
			enctype: 'multipart/form-data',
			processData: false,  
			contentType: false,   
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
					searchList();
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
		$('#groupid').multipleSelect({
        	filter: true,
			placeholder:"<?=getLanguage('chon-nhom-quyen')?>",
            single: true
        });
		$('#branchid').multipleSelect({
			filter: true,
			placeholder:"<?=getLanguage('chon-chi-nhanh')?>",
			single: true
		});
		$('#departmentid').multipleSelect({
			filter: true,
			placeholder:"<?=getLanguage('chon-phong-ban')?>",
			single: true
		});
	}
	function loadForm(){
		var id = $('#id').val(); 
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
    function funcList(obj){
		$('.edit').each(function(e){ 
			$(this).click(function(){ 
				var username = $('.uusername').eq(e).html().trim();
				var groupid = $(this).attr('groupid');
				
				var fullname = $('.ufullname').eq(e).html().trim();
				var email = $('.uemail').eq(e).html().trim();
				var mobile = $('.umobile').eq(e).html().trim();
				var avatar = base+'files/user/'+$(this).attr('avatar'); 
				var signature = base+'files/user/'+$(this).attr('signature'); 
				
				var id = $(this).attr('id');
				$('#id').val(id);	
				$('#username').val(username);	
				$('#fullname').val(fullname);	
				$('#email').val(email);
				$('#mobile').val(mobile);
				 
				$('#groupid').multipleSelect('setSelects', groupid.split(','));
				if(companyid == 0){
					var companyid = $(this).attr('companyid');
					$('#companyid').multipleSelect('setSelects', companyid.split(','));
				}
				if(iswarehouse > 1){
					var warehouseid = $(this).attr('warehouseid');
					$('#warehouseid').multipleSelect('setSelects', warehouseid.split(','));
				}
				if(isbranh > 1){
					var branchid = $(this).attr('branchid');
					$('#branchid').multipleSelect('setSelects', branchid.split(','));
				}
				$('#show').html('<img src="' + avatar + '" style="width:80px; height:50px" />');
				$('#shows').html('<img src="' + signature + '" style="width:80px; height:50px" />');
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
		$('#show').html('');
		$('#companyid,#groupid').multipleSelect('uncheckAll');
		
		csrfHash = $('#token').val();
		search = getSearch();
		getList(cpage,csrfHash);	
	}
	function searchList(){
		search = getSearch();
		csrfHash = $('#token').val();
		getList(0,csrfHash);	
	}
</script>

