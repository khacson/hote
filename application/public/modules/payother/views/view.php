<style title="" type="text/css">
	table col.c1 { width: 50px; }
	table col.c2 { width: 50px; }
	table col.c3 { width: 120px;}
	table col.c4 { width: 130px;}
	table col.c5 { width: 100px;}
	table col.c6 { width: 120px;}
	table col.c7 { width: 150px;}
	table col.c8 { width: 180px;}
	table col.c9 { width: 150px;}
	table col.c10 { width: 120px;}
	table col.c11 { width: 100px;}
	table col.c12 { width: auto;}
	.col-md-4{ white-space: nowrap !important;}
</style>
<div class="row">
	<?=$this->load->inc('breadcrumb');?>
</div>
<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption caption2">
			 <div class="brc mtop3"><i class="fa fa-bars"></i> <?=getLanguage('tim-thay');?> <span class="semi-bold viewtotal">0</span> <?=getLanguage('phieu-chi');?></div>					
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
							<?php for($i=1; $i< 13; $i++){?>
								<col class="c<?=$i;?>">
							<?php }?>
							<tr>							
								<th><input type="checkbox" name="checkAll" id="checkAll" /></th>
								<th><?=getLanguage('stt')?></th>								
								<th id="ord_p.pay_code"><?=getLanguage('phieu-chi')?></th>
								<th id="ord_p.typeid"><?=getLanguage('loai-phieu-chi')?></th>
								<th id="ord_p.amount"><?=getLanguage('so-tien')?></th>
								<th id="ord_p.payment"><?=getLanguage('thanh-toan')?></th>
								<th id="ord_p.bankid"><?=getLanguage('ngan-hang')?></th>
								<th id="ord_p.notes"><?=getLanguage('ghi-chu')?></th>
								<th id="ord_p.datecreate"><?=getLanguage('ngay-chi')?></th>
								<th id="ord_p.liabilities"><?=getLanguage('nguoi-chi')?></th>
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
									<input type="text" name="pay_code" id="pay_code" class="searchs form-control " />
								</td>
								<td>
									<select id="typeid" name="typeid" class="combos" >
										<?php foreach ($pays as $item) { ?>
											<option value="<?=$item->id;?>"><?=$item->pay_type_name;?></option>
										<?php } ?>
									</select>
								</td>
								<td>
									<input type="text" name="amount" id="amount" class="searchs form-control " />
								</td> 
								<td>
									<select id="payment" name="payment" class="combos" >
										<option value="1"><?=getLanguage('tien-mat');?></option>
										<option value="2"><?=getLanguage('chuyen-khoan');?></option>
									</select>
								</td>
								<td>
									<select id="bankid" name="bankid" class="combos">
										<?php foreach($banks as $item){?>
											<option value="<?=$item->id;?>"><?=$item->bank_name;?></option>
										<?php }?>
									</select>
								</td>
								<td>
									<input type="text" name="notes" id="notes" class="searchs form-control " />
								</td>
								<td></td>
								<td></td>
							</tr>
							<?php for($i=1; $i < 13; $i++){?>
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
		searchList();
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
		$('#export').click(function(){ 
			 search = getSearch();
			 window.location = controller+'export?search='+search;	
		});
		searchFunction();
	});
	$(document.body).on('click', '#actionSave',function (){
		save();
	});
	function searchFunction(){
		$("#pay_code,#notes,#amount").keyup(function() {
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
		search = getFormInput(); 
		var obj = $.evalJSON(search); 
		if(obj.typeid == ''){
			warning("<?=getLanguage('chon-loai-phieu-chi')?>"); return false;	
		}
		if(obj.amount == ''){
			warning("<?=getLanguage('so-tien-khong-duoc-trong')?>"); return false;	
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
		$('#bankid').multipleSelect({
			filter: true,
			placeholder:"<?=getLanguage('chon-ngan-hang')?>",
			single: false,
			onClick: function(view) {
				searchList();
			}
		});
		$('#typeid').multipleSelect({
			filter: true,
			placeholder:"<?=getLanguage('chon-loai-phieu-chi')?>",
			single: false,
			onClick: function(view) {
				searchList();
			}
		});
		$('#payment').multipleSelect({
			filter: true,
			placeholder:"<?=getLanguage('chon-hinh-thuc-thanh-toan')?>",
			single: false,
			onClick: function(view) {
				searchList();
			}
		});
		formatNumber('fm-number');
		formatNumberKeyUp('fm-number');
		$('#bankid,#typeid,#payment').multipleSelect('uncheckAll');
	}
	$('#printpc').click(function(){
			var id = getCheckedId();
			if(id == ""){
				return false;
			}
			$.ajax({
				url : controller + 'getDataPrintPC',
				type: 'POST',
				async: false,
				data: {id:id},
				success:function(datas){
					var object = $.evalJSON(datas); 
					var disp_setting = "toolbar=yes,location=yes,directories=yes,menubar=no,";
					disp_setting += "scrollbars=yes,width=900, height=auto, left=0.0, top=0.0";
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
		});
    function funcList(obj){
		$('.edit').each(function(e){
			$(this).click(function(){ 
				 var pay_code = $('.pay_code').eq(e).html().trim();
				 var amount = $('.amount').eq(e).html().trim();
				 var notes = $('.notes').eq(e).html().trim();
				 var datepo = $('.datepo').eq(e).html().trim();
				 var id = $(this).attr('id');
				 var branchid = $(this).attr('branchid');
				 var payment = parseInt($(this).attr('payment'));
				 var typeid =  $(this).attr('typeid');
				 var poid = $(this).attr('poids');
				 var id = $(this).attr('id');
				 $('#id').val(id);	
				 $('#pay_code').val(pay_code);
				 $('#amount').val(amount);		
				 $('#notes').val(notes);
				 $('#poid').val(poid);
				 $('#formdate').val(datepo);

				 $("#payments_1").prop('checked', false); 
				 $("#payments_2").prop('checked', false); 
				 $("#payments_3").prop('checked', false); 
				 if(payment == 3){
					 $("#payments_3").prop('checked', true); 
				 }
				 else if(payment == 2){
					  $("#payments_2").prop('checked', true); 
				 }
				 else{
					  $("#payments_1").prop('checked', true); 
				 }
				 $('#branchid').multipleSelect('setSelects', branchid.split(','));
				 $('#typeid').multipleSelect('setSelects', typeid.split(','));

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
		$('input[name=payments]:checked').prop('checked', false);
		search = getSearch();
		getList(cpage,csrfHash);	
	}
	function searchList(){
		search = getSearch();
		csrfHash = $('#token').val();
		getList(0,csrfHash);	
	}
	function getSearch(){
	var str = '';
	var payment = $('input[name=payments]:checked').val();
	if (typeof payment === "undefined") {
		payment = 0;
	}	
	$('input.searchs').each(function(){
		str += ',"'+ $(this).attr('id') +'":"'+ $(this).val().trim() +'"';
	});
	$('select.combos').each(function(){
		str += ',"'+ $(this).attr('id') +'":"'+ getCombo($(this).attr('id')) +'"';
	});
	return '{'+ str.substr(1) +',"payment":"'+payment+'"}';
}
</script>
<script src="<?=url_tmpl();?>assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
