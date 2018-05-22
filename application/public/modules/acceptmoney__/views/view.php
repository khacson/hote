<style title="" type="text/css">
	table col.c1 { width: 45px; }
	table col.c2 { width: 45px; }
	table col.c3 { width: 150px; }
	table col.c4 { width: 150px; }
	table col.c5 { width: 100px; }
	table col.c6 { width: 150px; }
	table col.c7 { width: 150px; }
	table col.c8 { width: 180px; }
	table col.c9 { width: 100px; }
	table col.c10 { idth: auto;}
</style>
<link href="<?=url_tmpl();?>css/jquery-ui.css" rel="stylesheet" type="text/css"/>
<div class="box">
	<div class="box-header with-border">
	  <?=$this->load->inc('breadcrumb');?>
	  <div class="box-tools pull-right">
		<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Đóng">
		  <i class="fa fa-minus"></i></button>
	  </div>
	</div>
	<div class="box-body">
	    <div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('nguoi-nhan');?> </label>
					<div class="col-md-8" >
						<select name="useraceptid" id="useraceptid" class="combos tab-event" >
							<option value=""></option>
							<?php foreach ($userAccepts as $item) { ?>
								<option value="<?=$item->id;?>"><?=$item->fullname?></option>
							<?php } ?>
						</select>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('nguoi-giao');?></label>
					<div class="col-md-8" >
						<select name="personid" id="personid" class="combos tab-event" >
							<option value=""></option>
							<?php foreach ($userAccepts as $item) { ?>
								<option value="<?=$item->id;?>"><?=$item->fullname?></option>
							<?php } ?>
						</select>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('so-tien');?> </label>
					<div class="col-md-8">
						<input type="text" name="money" placeholder="<?=getLanguage('so-tien');?>" id="money" class="searchs form-control fm-number tab-event" />
					</div>
				</div>
			</div>
		</div>
		<div class="row mtop10">
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('tu-ngay');?>
					</label>
					<div class="col-md-8">
						<div class="input-group date" data-provide="datepicker">
							<input id="fromdate" value="<?=$dates;?>" name="fromdate" type="text" class="searchs form-control tab-event" placeholder="<?=getLanguage('chon-ngay');?>">
							<div class="input-group-addon">
								<i class="fa fa-calendar "></i>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('den-ngay');?>
					</label>
					<div class="col-md-8">
						<div class="input-group date" data-provide="datepicker">
							<input id="todate" value="<?=$dates;?>" name="todate" type="text" class="searchs form-control tab-event" placeholder="<?=getLanguage('chon-ngay');?>">
							<div class="input-group-addon">
								<i class="fa fa-calendar "></i>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('ghi-chu');?></label>
					<div class="col-md-8">
						<input type="text" name="description" placeholder="<?=getLanguage('nhap-ghi-chu');?>" id="description" class="searchs form-control tab-event" />
					</div>
				</div>
			</div>
		</div>
		<div class="row mtop10">
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('chi-nhanh');?></label>
					<div class="col-md-8" >
						<select name="branchid" id="branchid" class="combos tab-event" >
							<?php foreach ($branchs as $item) { ?>
								<option value="<?=$item->id;?>"><?=$item->branch_name?></option>
							<?php } ?>
						</select>
					</div>
				</div>
			</div>
		</div>
		<div class="row mtop10"></div>
	</div>
</div>
<div class="box">
	<div class="box-header with-border">
	  <div class="brc"><?=getLanguage('tim-thay');?> <span class="semi-bold viewtotal">0</span> <?=getLanguage('ket-qua');?></div>

	  <div class="box-tools pull-right">
		   <ul class="button-group pull-right btnpermission">
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
				<li id="save" data-toggle="modal" data-target="#myModalFrom">
					<button class="button">
						<i class="fa fa-plus"></i>
						<?=getLanguage('them-moi');?>
					</button>
				</li>
				<li id="edit" data-toggle="modal" data-target="#myModalFrom">
					<button class="button">
						<i class="fa fa-save"></i>
						<?=getLanguage('sua');?>
					</button>
				</li>
				
				<li id="delete">
					<button type="button" class="button">
						<i class="fa fa-times"></i>
						<?=getLanguage('xoa');?>
					</button>
				</li>
				<li id="export">
					<button type="button" class="button">
						<i class="fa fa-file-excel-o"></i>
						<?=getLanguage('excel');?>
					</button>
				</li>
				
			</ul>	
	  </div>
	</div>
	<div class="box-body">
	     <div id="gridview" >
		 <!--header-->
		 <div id="cHeader">
			<div id="tHeader">    	
				<table width="100%" cellspacing="0" border="1" class="table ">
					<?php for($i=1; $i< 11; $i++){?>
						<col class="c<?=$i;?>">
					<?php }?>
					<tr>
						<th><input type="checkbox" id="checkAll" autocomplete="off" /></th>
						<th><?=getLanguage('stt');?></th>
						<th><?=getLanguage('nguoi-nhan');?></th>
						<th><?=getLanguage('nguoi-giao');?></th>
						<th><?=getLanguage('so-tien');?></th>
						<th><?=getLanguage('ngay-ban-giao');?></th>
						<th><?=getLanguage('ghi-chu');?></th>
						<th><?=getLanguage('chi-nhanh');?></th>
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
				<table id="group"  width="100%" cellspacing="0" border="1">
					<?php for($i=1; $i< 11; $i++){?>
						<col class="c<?=$i;?>">
					<?php }?>
					<tbody id="grid-rows"></tbody>
				</table>
			</div>
		</div>
		<!--end body-->
	 </div>
	 <div class="">
		<div class="fleft" id="paging"></div>
	 </div>
	</div>
</div>
<!-- END grid-->
<div class="loading" style="display: none;">
	<div class="blockUI blockOverlay" style="width: 100%;height: 100%;top:0px;left:0px;position: absolute;background-color: rgb(0,0,0);opacity: 0.1;z-index: 1000;">
	</div>
	<div class="blockUI blockMsg blockElement" style="width: 30%;position: absolute;top: 15%;left:35%;text-align: center;">
		<img src="<?=url_tmpl()?>img/preloader.gif" style="z-index: 2;position: absolute;"/>
	</div>
</div> 
<!-- ui-dialog -->

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
		  <button id="btnprint" type="button" class="btn btn-warning"><i class="fa fa-print"></i> <?=getLanguage('In');?></button>
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> <?=getLanguage('dong');?></button>
      </div>
    </div>
  </div>
</div>
<!--E Modal -->
<input type="hidden" name="id" id="id" />
<script>
	var controller = '<?=base_url().$routes;?>/';
	var table;
	var cpage = 0;
	var search;
	var routes = '<?=$routes;?>';
	$(function(){	
		formatNumber('fm-number');
		formatNumberKeyUp('fm-number');
		init();
		//refresh();
		searchList();	
		$("#search").click(function(){
			$(".loading").show();
			searchList();	
		});
		$("#refresh").click(function(){
			$(".loading").show();
			refresh();
		});
		$("#btnprint").click(function(){
			viewPrint();
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
				warning('<?=getLanguage('chon-nhom-quyen');?>');
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
				 searchList();	
			 }
		});
		$('#actionSave').click(function(){
			save();
		});
		$('#export').click(function(){
			window.location = controller+'export?search='+getSearch();
		});
	});
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
	function viewPrint(){
		var id = $('#id').val();
		$.ajax({
			url : controller + 'getDataPrint?id='+id,
			type: 'POST',
			async: false,
			data: {},
			success:function(datas){
				var object = $.evalJSON(datas); 
				var disp_setting = "toolbar=yes,location=yes,directories=yes,menubar=no,";
			disp_setting += "scrollbars=yes,width=900, height=500, left=0.0, top=0.0";
				var docprint = window.open("certificate", "certificate", disp_setting);
				docprint.document.open();
				docprint.document.write('<html>');
				//docprint.document.write(css);
				docprint.document.write('<body onLoad="self.print()">');
				docprint.document.write(object.content);
				docprint.document.write('</body></html>');
				docprint.document.close();
				docprint.focus();
			}
		});
		return false;
	}
	function save(){
		var id = $('#id').val();
		var func = 'save';
		if(id != ''){
			func = 'edit';
		}
		var search = getFormInput();
		var obj = $.evalJSON(search); 
		if(obj.catalog_pay_name == ""){
			warning('<?=getLanguage('ten-danh-muc-khong-duoc-trong');?>'); 
			$("#catalog_pay_name").focus();
			return false;		
		}
		$('.loading').show();
		//var data = new FormData();
		//var objectfile2 = document.getElementById('profileAvatar').files;
		//data.append('avatarfile', objectfile2[0]);
		//data.append('csrf_stock_name', token);
		//data.append('search', search);
		//data.append('id',id);
		$.ajax({
			url : controller + func,
			type: 'POST',
			async: false,
			data:{search:search,id:id},
			//enctype: 'multipart/form-data',
			//processData: false,  
			//contentType: false,   
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
				else{
					if(id == ''){
						$('#id').val(obj.id);
						success(tmtc); 
					}
					else{
						$('#id').val(obj.id);
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
		$('#catalogid').multipleSelect({
			filter: true,
			placeholder:'<?=getLanguage('chon-loai-chi');?>',
			single: true
		});
		$('#useraceptid').multipleSelect({
			filter: true,
			placeholder:'<?=getLanguage('chon-nguoi-nhan');?>',
			single: true
		});
		$('#personid').multipleSelect({
			filter: true,
			placeholder:'Chọn người giao',
			single: true
		});
		$('#branchid').multipleSelect({
			filter: true,
			placeholder:'<?=getLanguage('chon-chi-nhanh');?>',
			single: false
		});
		var branchid = '<?=$branchid;?>';
		$('#branchid').multipleSelect('setSelects', branchid.split(','));
		var userid = '<?=$userid;?>';
		$('#add_personid').multipleSelect('setSelects', userid.split(','));
	}
	function funcList(obj){
		$(".edit").each(function(e){
			$(this).click(function(){ 
				var money = $(".money").eq(e).text().trim();
				var description = $(".description").eq(e).text().trim();
				var datepay = $(".datepay").eq(e).text().trim();
				var id = $(this).attr('id');
				
				var catalogid = $(this).attr('catalogid');
				var useraceptid = $(this).attr('useraceptid');
				var branchid = $(this).attr('branchid');
				
				$("#id").val(id);	
				$("#money").val(money);	
				$("#description").val(description);	
				$("#datepay").val(datepay);	
				$('#catalogid').multipleSelect('setSelects', catalogid.split(','));
				$('#useraceptid').multipleSelect('setSelects', useraceptid.split(','));
				$('#branchid').multipleSelect('setSelects', branchid.split(','));
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
		$(".loading").show();
		$(".searchs").val("");
		$('#useraceptid,#personid,#branchid').multipleSelect('uncheckAll');
		var branchid = '<?=$branchid;?>';
		$('#branchid').multipleSelect('setSelects', branchid.split(','));
		var userid = '<?=$userid;?>';
		$('#add_personid').multipleSelect('setSelects', userid.split(','));
		var dates = '<?=$dates;?>';
		$("#fromdate").val(dates);
		$("#todate").val(dates);
		search = getSearch();
		getList(cpage,csrfHash);	
	}
	function searchList(){
		$(".loading").show();
		search = getSearch();
		csrfHash = $('#token').val();
		getList(cpage,csrfHash);	
	}
</script>
<script src="<?=url_tmpl();?>js/right.js" type="text/javascript"></script>