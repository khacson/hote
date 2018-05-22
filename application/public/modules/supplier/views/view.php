<style title="" type="text/css">
	table col.c1 { width: 50px; }
	table col.c2 { width: 50px; }
	table col.c3 { width: 150px;}
	table col.c4 { width: 180px;}
	table col.c5 { width: 120px;}
	table col.c6 { width: 120px;}
	table col.c7 { width: 200px;}
	table col.c8 { width: 200px;}
	table col.c9 { width: 120px;}
	table col.c10 { width: 120px;}
	table col.c11 { width: 120px;}
	table col.c12 { width: 120px;}
	table col.c13 { width: 120px;}
	table col.c14 { width: 120px;}
	table col.c15 { width: 150px;}
	table col.c16 { width: 150px;}
	table col.c17 { width: 150px;}
	table col.c18 { width: 100px;}
	table col.c19 { width: auto;}
	.col-md-4{ white-space: nowrap !important;}
</style>

<!-- BEGIN PORTLET-->
<div class="row">
	<?=$this->load->inc('breadcrumb');?>
</div>
<div class="portlet box blue mtop0">
	<div class="portlet-title">
		<div class="caption caption2">
			<div class="brc mtop3"><i class="fa fa-bars"></i> <?=getLanguage('tim-thay');?> <span class="semi-bold viewtotal">0</span> <?=getLanguage('nha-cung-cap');?></div>		
		</div>
		<div class="tools">
			<ul class="button-group pull-right"  style="margin-top:-5px; margin-bottom:5px;">
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
				<!--<li id="import">
					<a title="Nhập từ excel" class="" id="importgoods" data-toggle="modal" data-target="#myFrom" href="#">
						<button class="button">
							<i class="fa fa-arrow-up"></i>
							<?=getLanguage('import')?>
						</button>
					</a>
				</li>
				<li id="export">
					<button class="button">
						<i class="fa fa-file-excel-o"></i>
						<?=getLanguage('export')?>
					</button>
				</li>-->
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
							<?php for($i=1; $i< 20; $i++){?>
								<col class="c<?=$i;?>">
							<?php }?>
							<tr>							
								<th><input type="checkbox" name="checkAll" id="checkAll" /></th>
								<th><?=getLanguage('stt')?></th>	
								<th id="ord_c.supplier_code"><?=getLanguage('ma-nha-cung-cap')?></th>	
								<th id="ord_c.supplier_name"><?=getLanguage('ten-nha-cung-cap')?></th>
								<th id="ord_c.phone"><?=getLanguage('phone')?></th>
								<th id="ord_c.fax"><?=getLanguage('fax')?></th>
								<th id="ord_c.email"><?=getLanguage('email')?></th>
								<th id="ord_c.address"><?=getLanguage('dia-chi')?></th>
								<th id="ord_p.province_name"><?=getLanguage('tinh-thanh-pho')?></th>
								<th id="ord_c.taxcode"><?=getLanguage('mst')?></th>
								<th id="ord_c.bankcode"><?=getLanguage('tk-ngan-hang')?></th>
								<th id="ord_c.bankname"><?=getLanguage('ngan-hang')?></th>
								<th id="ord_c.birthday"><?=getLanguage('sinh-nhat')?></th>
								<th id="ord_c.contact_name"><?=getLanguage('nguoi-lien-he')?></th>
								<th id="ord_c.contact_phone"><?=getLanguage('dien-thoai')?></th>
								<th id="ord_c.contact_phone"><?=getLanguage('linh-vuc-hoat-dong')?></th>
								<th id="ord_c.contact_phone"><?=getLanguage('loai-hinh-so-huu')?></th>
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
							<?php for($i=1; $i < 20; $i++){?>
								<col class="c<?=$i;?>">
							<?php }?>
							<tr class="row-search">
								<td></td>
								<td></td>
								<td>
									<input type="text" name="supplier_code" id="supplier_code" class="searchs form-control " />
								</td>
								<td>
									<input type="text" name="supplier_name" id="supplier_name" class="searchs form-control " />
								</td>
								<td>
									<input type="text" name="phone" id="phone" class="searchs form-control " />
								</td>
								<td>
									<input type="text" name="fax" id="fax" class="searchs form-control " />
								</td>
								<td>
									<input type="text" name="email" id="email" class="searchs form-control " />
								</td>
								<td>
									<input type="text" name="address" id="address" class="searchs form-control " />
								</td>
								<td>
									<select id="provinceid" name="provinceid" class="combos" >
										<?php foreach($provinces as $item){?>
											<option value="<?=$item->id;?>"><?=$item->province_name;?></option>
										<?php }?>
									</select>
								</td>
								<td>
									<input type="text" name="taxcode" id="taxcode" class="searchs form-control " />
								</td>
								<td>
									<input type="text" name="bankcode" id="bankcode" class="searchs form-control " />
								</td>
								<td>
									<input type="text" name="bankname" id="bankname" class="searchs form-control " />
								</td>
								<td>
									<div id="click_birthday" class="input-group date date-picker" data-date-format="<?=cfdateHtml();?>" style="padding:0 !important;">
										<input type="text" id="birthday" placeholder="<?=cfdateHtml();?>" name="birthday" class="form-control form-input" style="height:30px;" >
										<span class="input-group-btn ">
											<button class="btn default btn-picker" type="button"><i class="fa fa-calendar "></i></button>
										</span>
									</div>
								</td>
								<td>
									<input type="text" name="contact_name" id="contact_name" class="searchs form-control " />
								</td>
								<td>
									<input type="text" name="contact_phone" id="contact_phone" class="searchs form-control " />
								</td>
								<td>
									<select id="activefieldsid" name="activefieldsid" class="combos" >
										<?php foreach($customerActiveFields as $item){?>
											<option value="<?=$item->id;?>"><?=$item->activefields_name;?></option>
										<?php }?>
									</select>
								</td>
								<td>
									<select id="ownertypeid" name="ownertypeid" class="combos" >
										<?php foreach($customerOwnerType as $item){?>
											<option value="<?=$item->id;?>"><?=$item->ownertype_name;?></option>
										<?php }?>
									</select>
								</td>
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
 <!-- Modal -->
<div class="modal fade" id="myFrom" role="dialog">
	<div class="modal-dialog">
	  <!-- Modal content-->
	  <div class="modal-content">
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
		  <h4 class="modal-title"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Nhập khách hàng từ excel</h4>
		</div>
		<div class="modal-body">
			<!--Content-->
			<input style="display:none;"  name="myfileImmport" id="myfileImmport" type="file"/>
			<ul class="button-group" style="margin:0px;">
				<li class="" onclick="javascript:document.getElementById('myfileImmport').click();">
				<button class="btnone" type="button">
				Chọn file</button>
				</li>
			</ul><br>
			<span class="red">*</span> Lưu ý: <br>
			- File mẩu xuất excel từ chương trình <br>
		</div>
		<div class="modal-footer">
		  <button type="button" id="addCustomer" class="btn btn-default">
		  <i class="fa fa-save" aria-hidden="true"></i>
		  Lưu</button>
		</div>
	  </div>
	  
	</div>
</div>
<!--E My form--> 
<!--S Modal -->
<div id="myModalFrom" class="modal fade" role="dialog">
  <div class="modal-dialog w900">
    <!-- Modal content-->
    <div class="modal-content ">
      <!--<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="modalTitleFrom"></h4>
      </div>-->
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
		$('#export').click(function(){
			window.location = controller + 'export?search='+getSearch();
		});
		$('#addCustomer').click(function(){
			importExcel();
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
		$("#supplier_code,#supplier_name,#phone,#fax,#email,#taxcode,#bankcode,#bankname,#contact_name,#contact_phone").keyup(function() {
			searchList();	
		});
		$('#click_birthday').datepicker().on('changeDate', function (ev) {
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
	function importExcel(){
		var data = new FormData();
		var objectfile = document.getElementById('myfileImmport').files;
		if(typeof(objectfile[0])  === "undefined") {
			error("Vui lòng chọn file"); return false;	
		}
		data.append('userfile', objectfile[0]);
		$.ajax({
			url : controller + 'import',
			type: 'POST',
			async: false,
			data: data,
			enctype: 'multipart/form-data',
			processData: false,  
			contentType: false,   
			success:function(datas){
				var obj = $.evalJSON(datas); 
				if(obj.status == 0){
					error(obj.content); return false;	
				}
				else{
					toastr.success(obj.content,'Thông báo', {closeButton:true, timeOut:3000});
					$('.close').click();
					refresh();
					return false;	
				}
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
		if(obj.supplier_name == ''){
			warning("<?=getLanguage('ten-nha-cung-cap-khong-duoc-trong')?>"); 
			$('#supplier_name').focus();
			return false;	
		}
		var token = $('#token').val();
		var checkprint = 0;
		if($( "#checkprint" ).prop( "checked", true )){
			checkprint = 1;
		}
		$('.loading').show();
		$.ajax({
			url : controller + func,
			type: 'POST',
			async: false,
			data: {csrf_stock_name:token,search:search , id:id, checkprint:checkprint},
			success:function(datas){
				$('.loading').hide();
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
					error("<?=getLanguage('nha-cung-cap-da-ton-tai')?>"); return false;		
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
			single: true,
			placeholder: '<?=getLanguage('chon-tinh-thanh-pho')?>',
			onClick: function(view){
				searchList();
			}
		});
		$('#activefieldsid').multipleSelect({
			filter: true,
			placeholder:'<?=getLanguage('chon-linh-vuc-hoat-dong')?>',
			single: false,
			onClick: function(view){
				searchList();
			}
		});
		$('#ownertypeid').multipleSelect({
			filter: true,
			placeholder:'<?=getLanguage('chon-loai-hinh-so-huu')?>',
			single: false,
			onClick: function(view){
				searchList();
			}
		});
		/*$('#districid').multipleSelect({
			filter: true,
			placeholder:'<?=getLanguage('select_distric')?>',
			single: true
		});*/
	}
    function funcList(obj){
		$('.edit').each(function(e){
			$(this).click(function(){ 
				 var supplier_code = $('.supplier_code').eq(e).html().trim();
				 var supplier_name = $('.supplier_name').eq(e).html().trim();
				 var phone = $('.phone').eq(e).html().trim();
				 var fax = $('.fax').eq(e).html().trim();
				 var email = $('.email').eq(e).html().trim();
				 var address = $('.address').eq(e).html().trim();
				 var provinceid = $(this).attr('provinceid');
				 var checkprint = parseFloat($(this).attr('checkprint'));
				 var birthday = ($(this).attr('birthday'));
				 if(checkprint == 1){
					$( "#checkprint" ).prop( "checked", true )
				 }
				 else{
					 $( "#checkprint" ).prop( "checked", false )
				 }
				 //var districid = $(this).attr('districid');
				 var usecontact = $('.usecontact').eq(e).html().trim();
				 var phoneusecontact = $('.phoneusecontact').eq(e).html().trim();
				 
				 var taxcode = $('.taxcode').eq(e).html().trim();
				 var bankcode = $('.bankcode').eq(e).html().trim();
				 var bankname = $('.bankname').eq(e).html().trim();
				
				 var id = $(this).attr('id');
				 $('#id').val(id);	
				 $('#supplier_code').val(supplier_code);
				 $('#supplier_name').val(supplier_name);
				 $('#phone').val(phone);		
				 $('#fax').val(fax);
				 $('#email').val(email);
				 $('#address').val(address);	
				 $('#usecontact').val(usecontact);	
				 $('#phoneusecontact').val(phoneusecontact);
				 $('#birthday').val(birthday);
				 
				 $('#bankcode').val(bankcode);	
				 $('#bankname').val(bankname);	
				 $('#taxcode').val(taxcode);	
				 $('#provinceid').multipleSelect('setSelects', provinceid.split(','));
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
