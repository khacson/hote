<style title="" type="text/css">
	table col.c1 { width: 50px; }
	table col.c2 { width: 50px; }
	table col.c3 { width: 100px;}
	table col.c4 { width: 130px;}
	table col.c5 { width: 125px;}
	table col.c6 { width: 125px;}
	table col.c7 { width: 110px;}
	table col.c8 { width: 130px;}
	table col.c9 { width: 100px;}
	table col.c10 { width: 80px; }
	table col.c11 { width: 150px;}
	table col.c12 { width: 120px;}
	table col.c13 { width: 120px;}
	table col.c14 { width: 200px;}
	table col.c15 { width: 150px;}
	table col.c16 { width: 50px;}
	table col.c17 { width: auto;}
	.col-md-4{ white-space: nowrap !important;}
</style>

<!-- BEGIN PORTLET-->
<div class="row">
	<?=$this->load->inc('breadcrumb');?>
</div>
<div class="portlet box blue mtop0">
	<div class="portlet-title">
		<div class="caption">
			 <div class="brc mtop3"><i class="fa fa-bars"></i> <?=getLanguage('tim-thay');?> <span class="semi-bold viewtotal">0</span> <?=getLanguage('lich-su-dat-phong');?></div>		
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
				<li id="export">
					<button class="button">
						<i class="fa fa-file-excel-o"></i>
						<?=getLanguage('export')?>
					</button>
				</li>
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
				<!--header-->
				<div id="cHeader">
					<div id="tHeader">    	
						<table id="tbheader" width="100%" cellspacing="0" border="1" >
							<?php for($i=1; $i< 18; $i++){?>
								<col class="c<?=$i;?>">
							<?php }?>
							<tr>							
								<th><input type="checkbox" name="checkAll" id="checkAll" /></th>
								<th><?=getLanguage('stt')?></th>
								<th id="ord_r.room_name"><?=getLanguage('ten-phong')?></th>		
								<th id="ord_rt.roomtype_name"><?=getLanguage('loai-phong')?></th>
								<th id="ord_odh.fromdate"><?=getLanguage('bat-dau')?></th>
								<th id="ord_odh.todate"><?=getLanguage('ket-thuc')?></th>
								<th><?=getLanguage('thoi-gian')?></th>
								<th id="ord_odh.price_type"><?=getLanguage('gia-ap-dung')?></th>
								<th id="ord_odh.price"><?=getLanguage('tien-phong')?></th>
								<th><?=getLanguage('so-khach')?></th>
								<th id="ord_odh.customer_name"><?=getLanguage('khach-hang')?></th>
								<th id="ord_odh.customer_cmnd"><?=getLanguage('cmnd')?></th>
								<th id="ord_odh.customer_phone"><?=getLanguage('dien-thoai')?></th>
								<th id="ord_odh.description"><?=getLanguage('ghi-chu')?></th>
								<th id="ord_odh.branchid"><?=getLanguage('chi-nhanh')?></th>
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
							<?php for($i=1; $i < 18; $i++){?>
								<col class="c<?=$i;?>">
							<?php }?>
							<tr class="row-search">
								<td></td>
								<td></td>
								<td>
									<input type="text" name="room_name" id="room_name" class="searchs form-control " />
								</td>
								<td>
									<select id="roomtypeid" name="roomtypeid" class="combos">
										<?php foreach($roomTypes as $item){?>
											<option value="<?=$item->id;?>"><?=$item->roomtype_name;?></option>
										<?php }?>
									</select>
								</td>
								<td>
									<div id="click_formdate" class="input-group date date-picker" data-date-format="<?=cfdateHtml();?>">
										<input value="" type="text" id="formdate" placeholder="<?=cfdateHtml();?>" name="formdate" class="form-control searchs" >
										<span class="input-group-btn ">
											<button class="btn default btn-picker" type="button"><i class="fa fa-calendar "></i></button>
										</span>
									</div>
								</td>
								<td>
									<div id="click_todate" class="input-group date date-picker" data-date-format="<?=cfdateHtml();?>">
										<input value="" type="text" id="todate" placeholder="<?=cfdateHtml();?>" name="todate" class="form-control searchs" >
										<span class="input-group-btn ">
											<button class="btn default btn-picker" type="button"><i class="fa fa-calendar "></i></button>
										</span>
									</div>
								</td>
								<td></td>
								<td>
									<select id="price_type" name="price_type" class="combos">
										<option value="0"><?=getLanguage('gia-chuan');?></option>
										<option value="-1"><?=getLanguage('thuong-luong');?></option>
										<?php foreach($priceLists as $item){?>
											<option value="<?=$item->id;?>"><?=$item->roomprice_name;?></option>
										<?php }?>
									</select>
								</td>
								<td><input type="text" name="price" id="price" class="searchs form-control " /></td>
								<td></td>
								<td><input type="text" name="customer_name" id="customer_name" class="searchs form-control " /></td>
								<td><input type="text" name="customer_cmnd" id="customer_cmnd" class="searchs form-control " /></td>
								<td><input type="text" name="customer_phone" id="customer_phone" class="searchs form-control " /></td>
								<td><input type="text" name="description" id="description" class="searchs form-control " /></td>
								<td>
									<select id="branchid" name="branchid" class="combos">
										<?php foreach($branchs as $item){?>
											<option value="<?=$item->id;?>"><?=$item->branch_name;?></option>
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
	<div class="blockUI blockMsg blockElement" style="width: 30%;position: absolute;top: 0%;left:35%;text-align: center; z-index: 9999000;">
		<img src="<?=url_tmpl()?>img/ajax_loader.gif" style="z-index: 2;position: absolute; z-index: 9999000;"/>
	</div>
</div> 
<!--S Modal -->
<div id="myModalFrom" class="modal fade" role="dialog">
  <div class="modal-dialog w800">
    <!-- Modal content-->
    <div class="modal-content ">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="formTitle"></h4>
      </div>
      <div id="loadContentFrom" class="modal-body">
      </div>
      <div class="modal-footer">
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
		$("#room_name,#price,#customer_phone,#customer_name,#customer_phone,#description").keyup(function() {
			searchList();	
		});
		$('#click_formdate').datepicker().on('changeDate', function (ev) {
			 $(this).datepicker('hide');
			searchList();
		});
		$('#click_todate').datepicker().on('changeDate', function (ev) {
			 $(this).datepicker('hide');
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
		$('#roomtypeid').multipleSelect({
			filter: true,
			single: false,
			placeholder: "<?=getLanguage('chon-loai-phong')?>",
			onClick: function(view){
				searchList();
			}
		});
		$('#price_type').multipleSelect({
			filter: true,
			single: false,
			placeholder: "<?=getLanguage('chon-gia-ap-dung')?>",
			onClick: function(view){
				searchList();
			}
		});
	}
	/*function save(){
		var id = $('#id').val(); 
		var func = 'save';
		if(id != ''){
			func = 'edit';
		}
		var search = getFormInput();
		var obj = $.evalJSON(search); 
		if(obj.roomtype_name == ''){
			warning('<?=getLanguage('ten-ten-lich-su-dat-phong-khong-duoc-trong');?>'); return false;	
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
	}*/
    function funcList(obj){
		$('.edit').each(function(e){
			$(this).click(function(){ 
				 /*var roomtype_name = $('.roomtype_name').eq(e).html().trim();
				 var bank_name = $('.bank_name').eq(e).html().trim();
				 var description = $('.description').eq(e).html().trim();
				 var id = $(this).attr('id');
				 $('#id').val(id);	
				 $('#roomtype_name').val(roomtype_name);
				 $('#bank_name').val(bank_name);
				 $('#description').val(description);*/
			});
		});	
		$('.edititem').each(function(e){
			$(this).click(function(){
				var id = $(this).attr('id');
				var roomname = $(this).attr('roomname');
				$('#formTitle').html("<?=getLanguage('danh-sach-khac-hang');?>: "+roomname);
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

