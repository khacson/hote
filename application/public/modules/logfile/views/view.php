<style title="" type="text/css">
	table col.c1 { width: 50px; }
	table col.c2 { width: 50px; }
	table col.c3 { width: 150px;}
	table col.c4 { width: 250px;}
	table col.c5 { width: 100px;}
	table col.c6 { width: 100px;}
	table col.c7 { width: 130px;}
	table col.c8 { width: 145px;}
	table col.c9 { width: 120px;}
	table col.c10 { width: auto;}
	.col-md-4{ white-space: nowrap !important;}
</style>

<!-- BEGIN PORTLET-->
<div class="portlet box blue">
	<div class="portlet-title">
		<?=$this->load->inc('breadcrumb');?>
	</div>
	<div class="portlet-body">
		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4">Chức năng</label>
					<div class="col-md-8">
						<input type="text" name="ctrol" id="ctrol" placeholder="" class="searchs form-control" />
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4">Từ ngày</label>
					 <div class="col-md-8 input-group date date-picker" data-date-format="<?=cfdateHtml();?>">
						<input value="<?=$fromdate;?>" type="text" id="formdate" placeholder="<?=cfdateHtml();?>" name="formdate" class="form-control searchs" >
                        <span class="input-group-btn ">
                            <button class="btn default btn-picker" type="button"><i class="fa fa-calendar "></i></button>
                        </span>
                    </div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4">Đến ngày</label>
					 <div class="col-md-8 input-group date date-picker" data-date-format="<?=cfdateHtml();?>">
						<input type="text" id="todate" placeholder="<?=cfdateHtml();?>" name="todate" value= "<?=$todates;?>" class="form-control searchs" >
                        <span class="input-group-btn ">
                            <button class="btn default btn-picker" type="button"><i class="fa fa-calendar "></i></button>
                        </span>
                    </div>
				</div>
			</div>
		</div>
		<div class="row mtop10">
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
		<div class="caption caption2">
			<i class="fa fa-bars"><i class="mleft5">Có <span class="viewtotal"></span> <span class='lowercase'>lịch sử</span></i></i>			
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
							<?php for($i=1; $i< 11; $i++){?>
								<col class="c<?=$i;?>">
							<?php }?>
							<tr>							
								<th><input type="checkbox" name="checkAll" id="checkAll" /></th>
								<th><?=getLanguage('all','stt')?></th>					
								<th id="ord_c.ctrol">Chức năng</th>
								<th id="ord_c.description">Ghi chú</th>
								<th>Trước khi sửa</th>
								<th>Sau khi sửa</th>
								<th>Người thực hiện</th>
								<th>Ngày thực hiện</th>
								<th>IP</th>
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
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
      </div>
    </div>

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
			$('.searchs').val('');		
			refresh();
		});
		$('#save').click(function(){
			save('save','');
		});
		$('#delete').click(function(){ 
			deleteItems('Bạn muốn xóa lịch sử');
		});
	});
	function deleteItems(msg){
		var id = getCheckedId();
		var token = $('#token').val();
		var yess = 'Có';
		var nos = 'Không';
		var texts = msg+'?';
		$.msgBox({
			title:'Message',
			type:'confirm',
			content:texts,
			buttons:[{value:yess},{value:nos}],
			success: function(result) {
				if (result == yess) {
					var token = $('#token').val();			
					$.ajax({
						url : controller + 'deletes',
						type: 'POST',
						async: false,
						data: {csrf_stock_name:token,id:id},
						success:function(datas){
							var obj = $.evalJSON(datas); 
							$('#token').val(obj.csrfHash);
							if(obj.status == 0){
								 error('Xóa không thành công','Lỗi'); 
							}
							else{
								 success('Xóa thành công','Thông báo');
								refresh();	
							}
						},
						error : function(){
							
						}
					});

				}
				else{
					return false;
				}
			}
		});
	}
	function init(){
	}
    function funcList(obj){
		$('.acction_before').each(function(e){
			$(this).click(function(){ 
				var id = $(this).attr('id');	
				$('.modal-title').html('Trước khi sửa');
				$.ajax({
					url : controller + 'viewLogfile',
					type: 'POST',
					async: false,
					data: {id:id,type:2},
					success:function(datas){
						var obj = $.evalJSON(datas); 
						$('.modal-body').html(obj.content);
					}
				});
			});
		});	
		$('.action_after').each(function(e){
			$(this).click(function(){ 
				var id = $(this).attr('id');
				$('.modal-title').html('Sau khi sửa');
				$.ajax({
					url : controller + 'viewLogfile',
					type: 'POST',
					async: false,
					data: {id:id,type:1},
					success:function(datas){
						var obj = $.evalJSON(datas); 
						$('.modal-body').html(obj.content);
					}
				});				
			});
		});	
	}
	function refresh(){
		$('.loading').show();
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
