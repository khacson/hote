
<script src="<?=url_tmpl();?>assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<!--<script src="<?=url_tmpl();?>highcharts/highcharts.js"></script>
<script src="<?=url_tmpl();?>highcharts/modules/data.js"></script>
<script src="<?=url_tmpl();?>highcharts/modules/drilldown.js"></script>
<script type="text/javascript" src="<?=url_tmpl();?>js/moment.js"></script>
<script type="text/javascript" src="<?=url_tmpl();?>js/daterangepicker.js"></script>-->
<script src="<?=url_tmpl();?>js/jquery-ui.js" type="text/javascript"></script>
<link href="<?=url_tmpl();?>css/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?=url_tmpl();?>fancybox/source/jquery.fancybox.pack.js"></script>  
<link href="<?=url_tmpl();?>fancybox/source/jquery.fancybox.css" rel="stylesheet" />


<input type="hidden" name="vfloorid" id="vfloorid" />
<input type="hidden" name="vroomtypeid" id="vroomtypeid" />
<input type="hidden" name="visstatus" id="visstatus" />
<style type="text/css">
	#datetime{
		font-size:13px;	
	}
	.monthselect,.yearselect{
		border:1px solid #d1dde2;
	}
	.fa.fa-chevron-right.glyphicon.glyphicon-chevron-right {
		font-size: 10px;
	}
	.fa.fa-chevron-right.glyphicon.glyphicon-chevron-right {
		font-size: 10px;
	}
	.ms-choice{
		background:#fff !important;	
		width:100% !important;
	}
	.ms-drop{
		width:100%;	
	}
	.page-content .page-breadcrumb.breadcrumb{
		margin-left:-23px;	
	}
	.datepicker-inline {
		width: 100%;
	}
	.datepicker {
		padding: 4px;
		border-radius: 4px;
		direction: ltr;
	}
	.table-condensed {
		width: 100%;
		max-width: 100%;
		margin-bottom: 20px;
	}
	.table-condensed th{
		 background: none !important;
	}
	
	table {
		background-color: transparent;
		border-spacing: 0;
		border-collapse: collapse;
	}
	.datepicker thead tr:first-child th, .datepicker tfoot tr th {
		cursor: pointer;
	}
	.datepicker table tr td, .datepicker table tr th {
		text-align: center;
		width: 30px;
		height: 30px;
		border-radius: 4px;
		border: none;
			border-top-width: medium;
			border-top-style: none;
			border-top-color: currentcolor;
	}
	.datepicker table tr td.old, .datepicker table tr td.new{
		color:#333;
	}
	.box-header > .fa, .box-header > .glyphicon, .box-header > .ion, .box-header .box-title {
		display: inline-block;
		font-size: 18px;
		margin: 0;
		margin-right: 0px;
		line-height: 1;
	}
	.box-title{
		font-size:18px;
		padding-left:10px;
		color:#fff;
	}
	.fa-calendar{
		background:#fff !important;
	}
	.progress {
		height: 10px;
		margin-bottom: 20px;
		overflow: hidden;
		background-color: #eee;
		border-radius: 4px;
		-webkit-box-shadow: inset 0 1px 2px rgba(0,0,0,.1);
		box-shadow: inset 0 1px 2px rgba(0,0,0,.1);
	}
	.progress-bar-green, .progress-bar-success {
		background-color: #00a65a;
		background: -moz-linear-gradient(center bottom, #00a65a 0, #00ca6d 100%) !important;
	}
	.box-footer{
		background:#fff;
		border-top-left-radius: 0;
		border-top-right-radius: 0;
		border-bottom-right-radius: 3px;
		border-bottom-left-radius: 3px;
		border-top: 1px solid #f4f4f4;
		padding: 10px;
		background-color: #fff;
		color:#333;
	}
</style>
<!-- BEGIN PAGE HEADER-->
<!--S Modal -->
<div id="myModalFrom" class="modal fade" role="dialog">
  <div class="modal-dialog w900">
    <!-- Modal content-->
    <div class="modal-content ">
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
<div class="loading" style="display: none;">
	<div class="blockUI blockOverlay" style="width: 100%;height: 100%;top:0px;left:0px;position: absolute;background-color: rgb(0,0,0);opacity: 0.1;z-index: 9999000;">
	</div>
	<div class="blockUI blockMsg blockElement" style="width: 30%;position: absolute;top: 25%;left:35%;text-align: center; z-index: 9999000;">
		<img src="<?=url_tmpl()?>img/ajax_loader.gif" style="z-index: 2;position: absolute; z-index: 9999000;"/>
	</div>
</div> 
<div class="row" style="background:#eee;"> 
	<div class=" col-md-6" style="padding-top:2px; padding-bottom:2px;">
		<div class="row"><?=$this->load->inc('breadcrumb');?></div>
	</div>
	<div class=" col-md-6 mtop10 text-right">
    	<div class="row">
            <div class="col-md-12 colm3 col6  branchids" >
                <ul class="room_status">
					<li class="clickloaitrong" id="1"><div class="room1"></div><?=getLanguage('phong-trong');?> (<b>10</b>)</li>
					<li class="clickloaitrong" id="2"><div class="room2"></div><?=getLanguage('co-khach');?> (<b>10</b>)</li>
					<li class="clickloaitrong" id="3"><div class="room3"></div><?=getLanguage('chua-don');?> (<b>10</b>)</li>
					<li class="clickloaitrong" id="4"><div class="room4"></div><?=getLanguage('sua-chua');?> (<b>10</b>)</li>
				</ul>
	  		</div>
      </div>
	</div>
</div>
<div class="row orderroom" >
	<div class="col-md-1 dashboard-item">
		<div class="row">
		<div class="floors3" id="clickRefresh">&nbsp;
		<a href="#" ><i class="fa fa-refresh"></i></a>
		&nbsp;</div>
		<?php $i=1;foreach($floors as $item){
			$class= "floors";
			if($i%2==0){
				$class= 'floors2';
			}
			?>
			<div class="<?=$class;?> clicFloors" fid="<?=$item->id;?>">
				<?=$item->floor_name;?>
				<div class="row room_empty"><?=getLanguage('phong-trong');?> (2)</div>
			</div>
		<?php $i++;}?>
		</div>
	</div>
	<div class="col-md-11 dashboard-item">
		<div class="row">
			<div class="col-md-12">
				<div class="list-type">
					<?php foreach($roomTypes as $item){
						$total = 0;
						if(!empty($roomTotals[$item->id])){
							$total = $roomTotals[$item->id];
						}
						?>
						<div class="roomTypes" tid = "<?=$item->id;?>"><?=$item->roomtype_name;?> <span class="roomTypes_" id="roomTypes_<?=$item->id;?>"></span></div>
					<?php }?>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12" id="viewRoomList"></div>
		</div>
	</div>
</div>
<div class="row" style="margin-top:20px;"></div>
<script type="text/javascript">
$(function(){
	// Create the chart
	$('#vfloorid,#vroomtypeid,#visstatus').val('');
	$('#clickRefresh').click(function(){
		$('#vfloorid,#vroomtypeid,#visstatus').val('');
		$('.clicFloors').removeClass('bgactive');
		$('.clickloaitrong').removeClass('statusActive');
		$('.roomTypes').removeClass('roomTypesActive');
		getRoomList('','','');
	});
	$('.clickloaitrong').each(function(){
		$(this).click(function(){
			$('.clickloaitrong').removeClass('statusActive');
			$(this).addClass('statusActive');
			var id = $(this).attr('id'); 
			$('#visstatus').val(id);
			var visstatus = $('#visstatus').val();
			var vroomtypeid = $('#vroomtypeid').val();
			var vfloorid = $('#vfloorid').val();
			getRoomList(vfloorid,vroomtypeid,visstatus);
		});
	});
	$('.clicFloors').each(function(){
		$(this).click(function(){
			$('.clicFloors').removeClass('bgactive');
			$('.roomTypes_').html('');
			$(this).addClass('bgactive');
			var fid = $(this).attr('fid'); 
			$('#vfloorid').val(fid);
			var visstatus = $('#visstatus').val();
			var vroomtypeid = $('#vroomtypeid').val();
			var vfloorid = $('#vfloorid').val();
			getRoomList(vfloorid,vroomtypeid,visstatus);
		});
	});
	$('.roomTypes').each(function(){
		$(this).click(function(){
			$('.roomTypes').removeClass('roomTypesActive');
			$(this).addClass('roomTypesActive');
			var tid = $(this).attr('tid'); 
			$('#vroomtypeid').val(tid);
			var visstatus = $('#visstatus').val();
			var vroomtypeid = $('#vroomtypeid').val();
			var vfloorid = $('#vfloorid').val();
			getRoomList(vfloorid,vroomtypeid,visstatus);
		});
	});
	getRoomList('','','');
});	
function getRoomList(floorid,roomtypeid,isstatus){
	$('.loading').show();
	$.ajax({
		url : '<?=base_url()?>orderroom'+'/loadRoomList',
		type: 'POST',
		async: false,
		data:{floorid:floorid,roomtypeid:roomtypeid,isstatus:isstatus}, 
		success:function(datas){
			var obj = $.evalJSON(datas); 
			$('.loading').hide();
			$('#viewRoomList').html(obj.content);
			if(typeof(funcList)=='function'){
				funcList(obj);
			}
		}
	});
}
function funcList(obj){
	$('.dashboard-stats').each(function(){
		$(this).click(function(){
			var roomid = $(this).attr('roomid');
			$.ajax({
				url : '<?=base_url()?>orderroom'+'/roomDetail',
				type: 'POST',
				async: false,
				data:{roomid:roomid}, 
				success:function(datas){
					var obj = $.evalJSON(datas); 
					$('.loading').hide();
					//$('#modalTitleFrom').html('<b>'+obj.title+'</b>');
					$('#loadContentFrom').html(obj.content);
				}
			});
		});
	});
}

</script>