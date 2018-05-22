<script src="<?=url_tmpl();?>assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?=url_tmpl();?>highcharts/highcharts.js"></script>
<!--<script src="<?=url_tmpl();?>highcharts/modules/data.js"></script>-->
<script type="text/javascript" src="<?=url_tmpl();?>js/moment.js"></script>
<script type="text/javascript" src="<?=url_tmpl();?>js/daterangepicker.js"></script>
<style title="" type="text/css">
	table col.c1 { width: 50px; }
	table col.c2 { width: 100px; }
	table col.c3 { width: 300px;}
	table col.c4 { width: 200px;}
	table col.c5 { width: 120px;}
	table col.c6 { width: 120px;}
	table col.c7 { width: 120px;}
	table col.c8 { width: 120px;}
	table col.c9 { width: auto;}
	.col-md-4{ white-space: nowrap !important;}
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
	.pleft0{ padding-left:0 !important;}
	.dashboard-stat .details .number{
		font-size:24px;
	}
	.dashboard-stat .visual i {
		color: #fff;
		font-size: 55px;
		line-height: 68px;
	}
</style>
<!-- BEGIN PORTLET-->
<div class="portlet box blue mtop20">
	
	<div class="portlet-title">
		<div class="tools col-md-12">
			<div class="row" style="margin-bottom:5px; margin-top:-2px;">
        	<div class="col-md-2" style="text-align:right;">
            	<a id="search" class="btn btn-sm blue" href="#" style="background:#5bc0de;">
               		<i class="fa fa-search" aria-hidden="true"></i>	Tìm kiếm
                </a>
            	<!--<button style="padding:4px 15px;" class="btn btn-info" type="button">Tìm kiếm</button>-->
            </div>
            <div class="col-md-2" data-date-format="dd/mm/yyyy" style="padding-left:0; padding-right:0; text-align:left;">
                <input style="width:160px; float:left; text-align:center;" type="text" id="datetime" placeholder="Chọn ngày" name="datetime" class="form-control search" value="<?=$fromdates;?> - <?=$todates;?>" >
                <span class="input-group-btn" style="width:20px; float:left;">
                    <button class="btn default btn-picker" type="button"><i class="fa fa-calendar "></i></button>
                </span>
            </div>
			<div class="col-md-2 pleft0">
				<div class="form-group">
					<select id="customerid" name="customerid" class="combos" >
						<option value="">Chọn khách hàng</option>
						<?php foreach($customers as $item){?>
							<option value="<?=$item->id;?>"><?=$item->customer_name;?></option>
						<?php }?>
					</select>
				</div>
			</div>
			<div class="col-md-2 ">
				<div class="form-group">
					<select id="goodsid" name="goodsid" class="combos" >
						<?php foreach($goods as $item){?>
							<option  value="<?=$item->id;?>"><?=$item->goods_code;?> - <?=$item->goods_name;?></option>
						<?php }?>
					</select>
				</div>
			</div>
            <div class="col-md-2 pleft0" >
                <select id="branchid" name="branchid" class="combos">
                	<?php foreach($branchs as $item){?>
                    	<option value="<?=$item->id;?>"><?=$item->branch_name;?></option>
                    <?php }?>
                </select>
	  		</div>
			<div class="col-md-2 pleft0">
                <select id="employeeid" name="employeeid" class="combos">
                	<?php foreach($employeesale as $item){?>
                    	<option value="<?=$item->id;?>"><?=$item->employee_code;?>- <?=$item->employee_name;?></option>
                    <?php }?>
                </select>
	  		</div>
      </div>
		</div>
	</div>
	<div class="portlet-body">
		<div class="row" style="margin-top:0px;">
			<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
				<div class="dashboard-stat" style="background:#0090d9;">
					<div class="visual">
					<i class="fa fa-line-chart"></i>
					</div>
					<div class="details">
					<div class="number" id="dtbh">0</div>
					<div class="desc">Doanh thu bán hàng</div>
					</div>
					<a class="more" href="<?=base_url();?>phieu-thu.html">
					Xem chi tết
					<i class="m-icon-swapright m-icon-white"></i>
					</a>
				</div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
				<div class="dashboard-stat" style="background:#0aa699;">
					<div class="visual">
					<i class="fa fa-usd"></i>
					</div>
					<div class="details">
					<div class="number" id="lnbh"></div>
					<div class="desc">Lợi nhuận bán hàng</div>
					</div>
					<a class="more" href="#">
					Xem chi tết
					<i class="m-icon-swapright m-icon-white"></i>
					</a>
				</div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
				<div class="dashboard-stat" style="background:#f35958;">
					<div class="visual">
					<i class="fa fa-money"></i>
					</div>
					<div class="details">
					<div class="number" id="tvbh"></div>
					<div class="desc"> Tiền vốn</div>
					</div>
					<a class="more" href="<?=base_url()?>goods.html">
					Xem chi tết
					<i class="m-icon-swapright m-icon-white"></i>
					</a>
				</div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
				<div class="dashboard-stat" style="background:#735f87;">
					<div class="visual">
					<i class="fa fa-pie-chart"></i>
					</div>
					<div class="details">
					<div id="hhbh" class="number"></div>
					<div class="desc">Hoa hồng bán hàng</div>
					</div>
					<a class="more" href="<?=base_url()?>branch.html">
					Xem chi tết
					<i class="m-icon-swapright m-icon-white"></i>
					</a>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
		</div>
		<div class="tools">
			<a href="javascript:;" class="collapse">
			</a>
		</div>
	</div>
	<div class="portlet-body">
		<div class="portlet-body">
			<span id="thuchi"></span>
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
<script>
	var controller = '<?=base_url().$routes;?>/';
	var csrfHash = '<?=$csrfHash;?>';
	var cpage = 0;
	var search;
	var idselect = '';
	$(function(){
		init();
		refresh();
		$('#search').click(function(){
			$(".loading").show();
			searchList();
			getDT();	
			chart();
		});
		$('#refresh').click(function(){
			$('.loading').show();
			refresh();
		});
		$('#export').click(function(){
			window.location = controller + 'export?search='+getSearch();
		});
		$('#print').click(function(){
			print('');
		});
		chart();
	});
	function chart(){
		var search = getSearch();
		$.ajax({
			url : controller + '/thuChi',
			type: 'POST',
			async: false,
			data: {search:search},
			success:function(datas){
				var obj = $.evalJSON(datas); 
				$('#thuchi').html(obj.content);
			}
		});
	}
	function getDT(){
		var search = getSearch();
		$('.loading').show();
		$.ajax({
			url : controller + 'getDT',
			type: 'POST',
			async: false,
			data: {search:search},
			success:function(datas){
				var obj = $.evalJSON(datas); 
				$('#dtbh').html(obj.dtbh);
				$('#lnbh').html(obj.lnbh);
				$('#tvbh').html(obj.tvbh);
				$('#hhbh').html(obj.hhbh);
				$('.loading').hide();
			}
		});
	}
	function init(){
		
		$('#goodsid').multipleSelect({
			filter: true,
			placeholder:'Chọn hàng hóa',
			single: false,
			onClick: function(view){
				/*var goodsid = getCombo('goodsid');
				$.ajax({
					url : controller + 'getGoods',
					type: 'POST',
					async: false,
					data: {id:goodsid},
					success:function(datas){
						var obj = $.evalJSON(datas); 
						var quantity = $('#quantity').val();
						var sale_price = obj.sale_price;
						$('#priceone').val(sale_price);
						$('#price').val(quantity*sale_price);
					}
				});*/
			}
		});
		$('#payments').multipleSelect({
			filter: true,
			placeholder:'Chọn hình thức thanh toán',
			single: true
		});
		$('#customerid').multipleSelect({
			filter: true,
			placeholder:'Chọn khách hàng',
			single: true
		});
		$('#payments_status').multipleSelect({
			filter: true,
			placeholder:'Chọn tình trạng thành toán',
			single: true
		});
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
			placeholder:'chọn chi nhánh/CH',
			single: false
		});
		$('#employeeid').multipleSelect({
			filter: true,
			placeholder:'Chọn nhân viên bán hàng',
			single: false
		});
		$('#branchid').multipleSelect('uncheckAll');
	}
	function print(id){
		if(id == ''){
			id = getCheckedId();
		}
		if(id == ''){ return false;}
		var token = $('#token').val();
		$.ajax({
			url : controller + 'getDataPrint',
			type: 'POST',
			async: false,
			data: {csrf_stock_name:token,id:id},
			success:function(datas){
				var object = $.evalJSON(datas); 
				var disp_setting = "toolbar=yes,location=yes,directories=yes,menubar=no,";
			disp_setting += "scrollbars=yes,width=1000, height=500, left=0.0, top=0.0";
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
	function refresh(){
		$('.loading').show();
		if(idselect == ''){
			$('.searchs').val('');		
			csrfHash = $('#token').val();
			$('select.combos').multipleSelect('uncheckAll');
			$('#customer_type').multipleSelect('setSelects',[1]);
			$('#quantity').val(1);
		}
		search = getSearch();
		getList(cpage,csrfHash);
		getDT();		
	}
	function searchList(){
		search = getSearch();
		csrfHash = $('#token').val();
		getList(0,csrfHash);	
	}
	function getSearch(){
		var str = '';
		var datetime = $('#datetime').val();
		$('input.searchs').each(function(){
			str += ',"'+ $(this).attr('id') +'":"'+ $(this).val().trim() +'"';
		});
		$('select.combos').each(function(){
			str += ',"'+ $(this).attr('id') +'":"'+ getCombo($(this).attr('id')) +'"';
		});
		return '{"datetime":"'+datetime+'",'+ str.substr(1) +'}';
	}	
	
</script>
<script src="<?=url_tmpl();?>assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
