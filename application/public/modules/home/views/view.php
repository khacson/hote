
<script src="<?=url_tmpl();?>assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?=url_tmpl();?>highcharts/highcharts.js"></script>
<!--<script src="<?=url_tmpl();?>highcharts/modules/data.js"></script>-->
<script src="<?=url_tmpl();?>highcharts/modules/drilldown.js"></script>
<script type="text/javascript" src="<?=url_tmpl();?>js/moment.js"></script>
<script type="text/javascript" src="<?=url_tmpl();?>js/daterangepicker.js"></script>
<script type="text/javascript">
$(function(){
	// Create the chart
		$("#calendar").datepicker();
		$('#datetime').daterangepicker({
			 locale: {
			  format: 'DD/MM/YYYY'
			},
			startDate: '<?=$fromdates;?>',
			endDate: '<?=$todates;?>',
			timePicker: false,
        	timePickerIncrement: 8,
        	showDropdowns: true
			
		});
		$('.btn-picker').click(function(){
			$('#datetime').click();
		});
		$('#branchid').multipleSelect({
			filter: true,
			placeholder:'Chi nhánh',
			single: false
		});
		$('#branchid').multipleSelect('uncheckAll');
		$('#search').click(function(){
			 generalSearch();
			 searchBilling();
		});
		generalSearch();
		searchBilling();
});	
function generalSearch(){
	var datetime = $('#datetime').val();
	var branchid = getCombo('branchid'); 
	var post = new FormData();
	post.append('datetime',datetime);
	post.append('branchid',branchid);
	$.ajax({
		url : '<?=base_url()?>home'+'/getGeneralSearch',
		type: 'POST',
		async: false,
		data:post,
		enctype: 'multipart/form-data',
		processData: false,  
		contentType: false,   
		success:function(datas){
			var obj = $.evalJSON(datas); 
			$('#doanhthuTrongngay').html(obj.doanhthutrongngays);
			$('#sovoiHomqua').html(obj.sovoihomquas);
			$('#khachhang').html(obj.customers);
			$('#baogia').html(obj.oders);
			$('#nhacungcap').html(obj.oders);
			$('#nhacungcap').html(obj.suppliers);
		}
	});
}
function searchBilling(){
	var datetime = $('#datetime').val();
	var branchid = getCombo('branchid'); 
	var post = new FormData();
	post.append('datetime',datetime);
	post.append('branchid',branchid);
	$.ajax({
		url : '<?=base_url()?>home'+'/search',
		type: 'POST',
		async: false,
		data:post,
		enctype: 'multipart/form-data',
		processData: false,  
		contentType: false,   
		success:function(datas){
			var obj = $.evalJSON(datas); 
			$('#bill').html(obj.content);
			$('#bill2').html(obj.content2);
			$('#bill3').html(obj.content3);
			$('#bill4').html(obj.content4);
			$('#tongdoanhthu').html(obj.doanhthu);
		}
	});
}
</script>
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
<div class="row" style="background:#eee;"> 
	<div class=" col-md-6" style="padding-top:10px;">
		<?=$this->load->inc('breadcrumb');?>
	</div>
	<div class=" col-md-6 mtop10 text-right" style="margin-bottom:10px;">
    	<div class="row">
            <div class="col-md-4 colm3 col6 " data-date-format="dd/mm/yyyy" style="display:inline-flex;">
                <input style="float:left; text-align:center;" placeholder="Chọn ngày" type="text" id="datetime" placeholder="dd/mm/yyyy" name="datetime" class="form-control searchs" value="<?=$fromdates;?> - <?=$todates;?>" >
                <span class="input-group-btn" >
                    <button class="btn default btn-picker" type="button"><i class="fa fa-calendar "></i></button>
                </span>
            </div>
            <div class="col-md-5 colm3 col6  branchids" >
                <select id="branchid" name="branchid" class="combos">
                	<?php foreach($branchs as $item){?>
                    	<option value="<?=$item->id;?>"><?=$item->branch_name;?></option>
                    <?php }?>
                </select>
	  		</div>
			<div class="col-md-2 colm3 col12 mtop10mb">
            	<a id="search" class="btn btn-sm blue" href="#" style="background:#5bc0de;">
               		<i class="fa fa-search" aria-hidden="true"></i>	Tìm kiếm
                </a>
            </div>
      </div>
	</div>
</div>
<div class="row" style="margin-top:10px;">
	<div class="col-md-12 dashboard-item">
		<!--Left-->
		<div class="col-md-6 dashboard-item">
			<div class="row">
				<div class="col-md-12" id="bill3"></div>
			</div>
		</div>
		<!--E Left-->
		<!--Right-->
		<div class="col-md-6 dashboard-item">
			<div class="row">
				<!--S Item-->
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 dashboard-item">
					<div class="dashboard-stat" style="background:#0090d9;">
						<div class="visual">
						<i class="fa fa-usd"></i>
						</div>
						<div class="details">
						<div id="doanhthuTrongngay" class="number">0đ</div>
						<div class="desc">Doanh thu trong ngày</div>
						</div>
						<a class="more" href="<?=base_url()?>#.html">
						Xem chi tết
						<i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>
				<!--S Item-->
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 dashboard-item">
					<div class="dashboard-stat" style="background:#0aa699;">
						<div class="visual">
						<i class="fa fa-line-chart"></i>
						</div>
						<div class="details">
						<div id="sovoiHomqua" class="number">0đ</div>
						<div class="desc"> So với hôm qua</div>
						</div>
						<a class="more" href="<?=base_url()?>supplier.html">
						Xem chi tết
						<i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>
				<!--S Item-->
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 dashboard-item">
					<div class="dashboard-stat" style="background:#f35958;">
						<div class="visual">
						<i class="fa fa-signal"></i>
						</div>
						<div class="details">
						<div class="number" id="tongdoanhthu">0đ</div>
						<div class="desc"> Doanh thu</div>
						</div>
						<a class="more" href="#">
						Xem chi tết
						<i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>
				<!--S Item-->
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 dashboard-item">
					<div class="dashboard-stat" style="background:#735f87;">
						<div class="visual">
						<i class="fa fa-barcode"></i>
						</div>
						<div class="details">
						<div class="number" id="khachhang">0</div>
						<div class="desc">Khách hàng</div>
						</div>
						<a class="more" href="<?=base_url()?>customer.html">
						Xem chi tết
						<i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>
				<!--S Item-->
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 dashboard-item">
					<div class="dashboard-stat" style="background:#0aa699;">
						<div class="visual">
						<i class="fa fa-line-chart"></i>
						</div>
						<div class="details">
						<div class="number" id="baogia"></div>
						<div class="desc"> Báo giá</div>
						</div>
						<a class="more" href="<?=base_url()?>supplier.html">
						Xem chi tết
						<i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>
				<!--S Item-->
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 dashboard-item">
					<div class="dashboard-stat" style="background:#0090d9;">
						<div class="visual">
						<i class="fa fa-usd"></i>
						</div>
						<div class="details">
						<div class="number" id="nhacungcap"></div>
						<div class="desc">Nhà cung cấp</div>
						</div>
						<a class="more" href="<?=base_url()?>supplier.html">
						Xem chi tết
						<i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>
			</div>
		</div>
		<!--E Right-->
	</div>
</div>
<div class="row" style="margin-top:0px;">
	<div class="col-md-12">
		<div class="col-md-4 text-left" id="bill4">
			</div>	
		<div class="col-md-4" id="bill" style="padding-right:0px;">
		</div>
		<div class="col-md-4"  id="bill2" style="padding-right:0px;">
		</div>
	</div>
</div>
<div class="row" style="margin-top:20px;">
	<div class="col-md-12">
		<div class="col-md-6" >
		<!-- Calendar -->
          <div class="box box-solid bg-green-gradient">
            <div class="box-header">
              <i class="fa fa-calendar"></i>
              <h3 class="box-title">Lịch làm việc</h3>
              <!-- tools box -->
              <div class="pull-right box-tools">
                <!-- button with a dropdown -->
                <div class="btn-group">
                  <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-bars"></i></button>
                  <ul class="dropdown-menu pull-right" role="menu">
                    <li><a href="#">Thêm công việc</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Xem lịch làm việc</a></li>
                  </ul>
                </div>
                <button type="button" class="btn btn-success btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-success btn-sm" data-widget="remove"><i class="fa fa-times"></i>
                </button>
              </div>
              <!-- /. tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <!--The calendar -->
              <div id="calendar" style="width: 100%"></div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer text-black">
              <div class="row">
				<div class="col-md-12 mtop20" >
                <div class="col-sm-6">
                  <!-- Progress bars -->
                  <div class="clearfix">
                    <span class="pull-left">Task #1</span>
                    <small class="pull-right">90%</small>
                  </div>
                  <div class="progress xs">
                    <div class="progress-bar progress-bar-green" style="width: 90%;"></div>
                  </div>

                  <div class="clearfix">
                    <span class="pull-left">Task #2</span>
                    <small class="pull-right">70%</small>
                  </div>
                  <div class="progress xs">
                    <div class="progress-bar progress-bar-green" style="width: 70%;"></div>
                  </div>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                  <div class="clearfix">
                    <span class="pull-left">Task #3</span>
                    <small class="pull-right">60%</small>
                  </div>
                  <div class="progress xs">
                    <div class="progress-bar progress-bar-green" style="width: 60%;"></div>
                  </div>

                  <div class="clearfix">
                    <span class="pull-left">Task #4</span>
                    <small class="pull-right">40%</small>
                  </div>
                  <div class="progress xs">
                    <div class="progress-bar progress-bar-green" style="width: 40%;"></div>
                  </div>
                </div>
                <!-- /.col -->
				</div>
              </div>
              <!-- /.row -->
            </div>
          </div>
          <!-- /.box -->
		  </div>
	 </div>
</div>
<div class="row" style="margin-top:20px;"></div>
