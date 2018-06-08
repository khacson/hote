<ul class="nav nav-tabs" style="margin-top:-10px;">
  <li class="active showsave"><a data-toggle="tab" href="#tabhome"><?=$title;?> - <?=$finds->room_name;?></a></li>
  <li id="tabserviceClick" class="showsave"><a data-toggle="tab" href="#tabservice"><?=getLanguage('dich-vu');?></a></li>
  <li id="tabcustomerClick" class="showsave"><a data-toggle="tab" href="#tabcustomer"><?=getLanguage('them-khach-hang');?></a></li>
  <li id="tabhistoryClick" class="showsave"><a data-toggle="tab" href="#tabhistory"><?=getLanguage('lich-dat-phong');?></a></li>
  
  <li style="float:right;">
	 <button type="button" style="margin-top:10px;" class="close" data-dismiss="modal">&times;</button>
  </li>
</ul>
<div class="tab-content">
    <div id="tabhome" class="tab-pane fade in active">
		 <div class="row mtop20">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('bat-dau');?></label>
					<div class="col-md-4 date date-picker form-input" data-date-format="<?=cfdateHtml();?>" style="padding-right:0;">
						<input type="text" id="fromdate" placeholder="<?=cfdateHtml();?>" name="fromdate" class="form-control form-input" value="<?=$fromdate;?>">
						<span class="input-group-btn ">
							<button class="btn default btn-picker" type="button"><i class="fa fa-calendar "></i></button>
						</span>
					</div>
					<div class="col-md-4">
						<div class="row">
							<div class="col-md-6">
								<div class="row">
									<select id="input_fromdateHours" name="input_fromdateHours" class="combos-input select2me form-control" >
										<?php for($i=1;$i<25;$i++){
											$jj = $i;
											if($i < 10){
												$jj = '0'.$i;
											}
											?>
										<option <?php if($jj == $hours){?> selected <?php }?> value="<?=$jj;?>"><?=$jj;?></option>
										<?php }?>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="row" style="padding-right:15px;">
									<select id="input_fromdateMinute" name="input_fromdateMinute" class="combos-input select2me form-control" >
										<?php for($i=1;$i<61;$i++){
											$kk = $i;
											if($i < 10){
												$kk = '0'.$i;
											}
											?>
											<option <?php if($kk == $minute){?> selected <?php }?> value="<?=$kk;?>"><?=$kk;?></option>
										<?php }?>
									</select>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('ket-thuc');?></label>
					<div class="col-md-4 date date-picker form-input" data-date-format="<?=cfdateHtml();?>" style="padding-right:0;">
						<input type="text" id="todate" placeholder="<?=cfdateHtml();?>" name="todate" class="form-control form-input" value="<?=$todate;?>">
						<span class="input-group-btn ">
							<button class="btn default btn-picker" type="button"><i class="fa fa-calendar "></i></button>
						</span>
					</div>
					<div class="col-md-4">
						<div class="row">
							<div class="col-md-6">
								<div class="row">
									<select id="input_todateHours" name="input_todateHours" class="combos-input select2me form-control" >
										<?php for($i=1;$i<25;$i++){
											$jj = $i;
											if($i < 10){
												$jj = '0'.$i;
											}
											?>
										<option <?php if($jj == $hours){?> selected <?php }?> value="<?=$jj;?>"><?=$jj;?></option>
										<?php }?>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="row"  style="padding-right:15px;">
									<select id="input_todateMinute" name="input_todateMinute" class="combos-input select2me form-control" >
										<?php for($i=1;$i<61;$i++){
											$kk = $i;
											if($i < 10){
												$kk = '0'.$i;
											}
											?>
											<option <?php if($kk == $minute){?> selected <?php }?> value="<?=$kk;?>"><?=$kk;?></option>
										<?php }?>
									</select>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		 </div>
		 <div class="row mtop10">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4 nowrap"><?=getLanguage('hinh-thuc-thue');?> (<span class="red">*</span>)</label>
					<div class="col-md-8">
						<select id="input_lease" name="input_lease" class="combos-input select2me form-control">
							<option value="1"><?=getLanguage('theo-ngay');?></option>
							<option value="5"><?=getLanguage('gia-qua-dem');?></option>
							<option value="2"><?=getLanguage('theo-gio');?></option>
							<option value="3"><?=getLanguage('theo-tuan');?></option>
							<option value="4"><?=getLanguage('theo-thang');?></option>
						</select>
					</div>
				</div>
			</div>
		 </div>
		 <!--E Row-->
		 <div class="row mtop10">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('gia-ap-dung');?> (<span class="red">*</span>)</label>
					<div class="col-md-8">
						<select id="input_price_type" name="input_price_type" class="combos-input select2me form-control">
							<option value="0"><?=getLanguage('gia-chuan');?></option>
							<option value="-1"><?=getLanguage('thuong-luong');?></option>
							<?php foreach($priceLists as $item){?>
								<option value="<?=$item->id;?>"><?=$item->roomprice_name;?></option>
							<?php }?>
						</select>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('gia-phong');?> (<span class="red">*</span>)</label>
					<div class="col-md-8">
						<input type="text" name="input_price" id="input_price" maxlength="10" class="form-input form-control fm-number" value="<?=number_format($finds->price);?>" />
					</div>
				</div>
			</div>
		 </div>
		 <!--E Row-->
		  <div class="row mtop10">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4 nowrap"><?=getLanguage('ten-khach-hang');?> (<span class="red">*</span>)</label>
					<div class="col-md-8">
						<input type="text" name="input_customer_name" id="input_customer_name" maxlength="50" class="form-input form-control " />
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('cmnd');?> (<span class="red">*</span>)</label>
					<div class="col-md-8">
						<input type="text" name="input_customer_cmnd" id="input_customer_cmnd" maxlength="12" class="form-input form-control " />
					</div>
				</div>
			</div>
		 </div>
		 <div class="row mtop10">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('ngay-cap');?></label>
					<div class="col-md-8 date date-picker form-input">
						<input type="text" id="input_identity_date" placeholder="<?=cfdateHtml();?>" name="input_identity_date" class="form-control form-input" >
						<span class="input-group-btn ">
							<button class="btn default btn-picker" type="button"><i class="fa fa-calendar "></i></button>
						</span>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('noi-cap');?></label>
					<div class="col-md-8">
						<input type="text" name="input_identity_from" id="input_identity_from" maxlength="100" class="form-input form-control " />
					</div>
				</div>
			</div>
		 </div>
		 <!--E Row-->
		  <div class="row mtop10">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('dien-thoai');?></label>
					<div class="col-md-8">
						<input type="text" name="input_customer_phone" id="input_customer_phone" maxlength="20" class="form-input form-control " />
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('dia-chi');?></label>
					<div class="col-md-8">
						<input type="text" name="input_customer_address" id="input_customer_address" maxlength="100" class="form-input form-control " />
					</div>
				</div>
			</div>
		 </div>
		 <!--E Row-->
		 <div class="row mtop10">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('cong-ty');?></label>
					<div class="col-md-8">
						<input type="text" name="input_customer_comppany" id="input_customer_comppany" maxlength="50" class="form-input form-control " />
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('mst');?></label>
					<div class="col-md-8">
						<input type="text" name="input_customer_mst" id="input_customer_mst" maxlength="20" class="form-input form-control " />
					</div>
				</div>
			</div>
		 </div>
		 <!--E Row-->
		 <!--E Row-->
		 <div class="row mtop10">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('ghi-chu');?></label>
					<div class="col-md-8">
						<input type="text" name="input_description" id="input_description" maxlength="250" class="form-input form-control " />
					</div>
				</div>
			</div>
		</div>
		<!--E Row-->
		<!--S Chup hình-->
		<div class="portlet box blue mtop10">
			<div class="portlet-title">
				<div class="caption caption2">
					<div class="brc mtop3"><i class="fa fa-camera" aria-hidden="true"></i> Chụp hình giấy tờ tùy thân</div>
				</div>
				<div class="tools">
					<button style="margin-top:-6px;" id="play" data-toggle="tooltip" title="Play" type="button" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-play"></span></button>
					<button style="margin-top:-6px;" id="stopAll" data-toggle="tooltip" title="Stop streams" type="button" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-stop"></span></button>
					<a href="javascript:;" class="expand"></a>
				</div>
			</div>
			<!--S content--> 
			<div class="portlet-body" style="display: none;">
				<div class="row">
					<div class="col-md-6" style="text-align: center;">
						<div class="well" style="position: relative;display: inline-block;">
							<canvas id="qr-canvas"  width="420" height="315"></canvas>
							<div class="scanner-laser laser-rightBottom" style="opacity: 0.5;"></div>
							<div class="scanner-laser laser-rightTop" style="opacity: 0.5;"></div>
							<div class="scanner-laser laser-leftBottom" style="opacity: 0.5;"></div>
							<div class="scanner-laser laser-leftTop" style="opacity: 0.5;"></div>
						</div>
						<!--QR-Code-->
						<div class="container" style="width:100%; margin-top:-10px;">
							<div class="panel panel-primary">
									<div class="panel-heading" style="display: inline-block;width: 100%; padding:2px 10px;">
										<h4 style="width:50%;float:left;"><?=getLanguage('khach-hang');?> 4</h4>
										<div style="width:50%;float:right;margin-top: 5px;margin-bottom: 5px;text-align: right;">
										<button title="Chụp mặt trước" id="savec3" data-toggle="tooltip" title="Image shoot" type="button" class="btn btn-info btn-sm disabled"><i class="fa fa-camera" aria-hidden="true"></i></button>
										<button  title="Chụp mặt sau"  id="savec33" data-toggle="tooltip" title="Image shoot" type="button" class="btn btn-info btn-sm disabled"><i class="fa fa-camera-retro" aria-hidden="true"></i></button>
									</div>
								</div>
								<div class="panel-body" style="padding:0;">
									<div class="col-md-6" style="text-align: center; padding:2px; height:115px;">
										<div class="well" style="position: relative;display: inline-block; padding:5px !important;">
											<img id="scanned-img-c3" src="" width="140" height="90">
										</div>
									</div>
									 <div class="col-md-6" style="text-align: center; padding:2px; height:115px;">
										<div class="well" style="position: relative;display: inline-block;  padding:5px !important;">
											<img id="scanned-img-c33" src="" width="140"height="90">
										</div>
									</div>
								</div>
							</div>
						</div>
						<!--E QR-Code-->
					</div>
					<div class="col-md-6">
						<!--QR-Code-->
						<div class="container" style="width:100%">
							<div class="panel panel-primary">
									<div class="panel-heading" style="display: inline-block;width: 100%; padding:2px 10px;">
										<h4 style="width:50%;float:left;"><?=getLanguage('khach-hang');?> 1</h4>
										<div style="width:50%;float:right;margin-top: 5px;margin-bottom: 5px;text-align: right;">
										<!--<select id="cameraId" class="form-control" style="display: inline-block;width: auto;"></select>-->
										<button title="Chụp mặt trước" id="save" data-toggle="tooltip" title="Image shoot" type="button" class="btn btn-info btn-sm disabled"><i class="fa fa-camera" aria-hidden="true"></i></button>
										<button  title="Chụp mặt sau"  id="save2" data-toggle="tooltip" title="Image shoot" type="button" class="btn btn-info btn-sm disabled"><i class="fa fa-camera-retro" aria-hidden="true"></i></button>
									</div>
								</div>
								<div class="panel-body" style="padding:0;">
									<div class="col-md-6" style="text-align: center; padding:2px; height:115px;">
										<div class="well" style="position: relative;display: inline-block; padding:5px !important;">
											<img id="scanned-img" src="" width="140" height="90">
										</div>
									</div>
									 <div class="col-md-6" style="text-align: center; padding:2px; height:115px;">
										<div class="well" style="position: relative;display: inline-block;  padding:5px !important;">
											<img id="scanned-img-2" src=""  width="140" height="90">
										</div>
									</div>
								</div>
							</div>
						</div>
						<!--E QR-Code-->
						<!--QR-Code-->
						<div class="container" style="width:100%; margin-top:-10px;">
							<div class="panel panel-primary">
									<div class="panel-heading" style="display: inline-block;width: 100%; padding:2px 10px;">
										<h4 style="width:50%;float:left;"><?=getLanguage('khach-hang');?> 2</h4>
										<div style="width:50%;float:right;margin-top: 5px;margin-bottom: 5px;text-align: right;">
										<button title="Chụp mặt trước" id="savec1" data-toggle="tooltip" title="Image shoot" type="button" class="btn btn-info btn-sm disabled"><i class="fa fa-camera" aria-hidden="true"></i></button>
										<button  title="Chụp mặt sau"  id="savec11" data-toggle="tooltip" title="Image shoot" type="button" class="btn btn-info btn-sm disabled"><i class="fa fa-camera-retro" aria-hidden="true"></i></button>
									</div>
								</div>
								<div class="panel-body" style="padding:0;">
									<div class="col-md-6" style="text-align: center; padding:2px; height:115px;">
										<div class="well" style="position: relative;display: inline-block; padding:5px !important;">
											<img id="scanned-img-c1" src=""  width="140" height="90">
										</div>
									</div>
									 <div class="col-md-6" style="text-align: center; padding:2px; height:115px;">
										<div class="well" style="position: relative;display: inline-block;  padding:5px !important;">
											<img id="scanned-img-c11" src=""  width="140" height="90">
										</div>
									</div>
								</div>
							</div>
						</div>
						<!--E QR-Code-->
						<!--QR-Code-->
						<div class="container" style="width:100%; margin-top:-10px;">
							<div class="panel panel-primary">
									<div class="panel-heading" style="display: inline-block;width: 100%; padding:2px 10px;">
										<h4 style="width:50%;float:left;"><?=getLanguage('khach-hang');?> 3</h4>
										<div style="width:50%;float:right;margin-top: 5px;margin-bottom: 5px;text-align: right;">
										<button title="Chụp mặt trước" id="savec2" data-toggle="tooltip" title="Image shoot" type="button" class="btn btn-info btn-sm disabled"><i class="fa fa-camera" aria-hidden="true"></i></button>
										<button  title="Chụp mặt sau"  id="savec22" data-toggle="tooltip" title="Image shoot" type="button" class="btn btn-info btn-sm disabled"><i class="fa fa-camera-retro" aria-hidden="true"></i></button>
									</div>
								</div>
								<div class="panel-body" style="padding:0;">
									<div class="col-md-6" style="text-align: center; padding:2px; height:115px;">
										<div class="well" style="position: relative;display: inline-block; padding:5px !important;">
											<img id="scanned-img-c2" src="" width="140" height="90">
										</div>
									</div>
									 <div class="col-md-6" style="text-align: center; padding:2px; height:115px;">
										<div class="well" style="position: relative;display: inline-block;  padding:5px !important;">
											<img id="scanned-img-c22" src="" width="140" height="90">
										</div>
									</div>
								</div>
							</div>
						</div>
						<!--E QR-Code-->
					</div>
				</div>
			</div>
			<!--E content-->
		</div>
		<div class="row mtop10"></div>
	</div>
	<!--E Home-->
	<div id="tabservice" class="tab-pane fade">
		<div id="tabserviceLoads"></div>
	</div>
	<!--E Service-->
	<div id="tabcustomer" class="tab-pane fade">
		 <div class="row ">
			<a href="#" style="float:right; margin-bottom:-25px; margin-right:10px;" class="btn"><i class="fa fa-plus"></i></a>
		 </div>
		 <div id="tabcustomerLoad"></div>
	</div>
	<div id="tabhistory" class="tab-pane fade" id="tabhistoryLoad">
		<div class="row mtop20"> 
			<div id="tHeader">    	
				<table width="100%" cellspacing="0" border="1" class="table ">
					<tr>
						<th width="40"><?=getLanguage('stt');?></th>
						<th width="180"><?=getLanguage('ten-khach-hang');?></th>
						<th width="100"><?=getLanguage('bat-dau');?></th>
						<th width="100"><?=getLanguage('ket-thuc');?></th>
						<th width="150"><?=getLanguage('ngay-dat');?></th>
						<th width="150"><?=getLanguage('nguoi-dat');?></th>
						<th></th>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>
<input type="hidden" name="roomid" id="roomid" value="<?=$finds->id;?>"/>
<style>
	.scanner-laser{
		position: absolute;
		margin: 20px;
		height: 30px;
		width: 30px;
	}
	.laser-leftTop{
		top: 0;
		left: 0;
		border-top: solid red 5px;
		border-left: solid red 5px;
	}
	.well{
		padding:10px !important;
	}
	.laser-leftBottom{
		bottom: 0;
		left: 0;
		border-bottom: solid red 5px;
		border-left: solid red 5px;
	}
	.laser-rightTop{
		top: 0;
		right: 0;
		border-top: solid red 5px;
		border-right: solid red 5px;
	}
	.laser-rightBottom{
		bottom: 0;
		right: 0;
		border-bottom: solid red 5px;
		border-right: solid red 5px;
	}
	.datepicker-dropdown{
		width:250px !important;
	}
	.inputgoods{
		width:100%;	
		margin-top:0px;
	}
	.thd{
		text-align:center;
	}
	.thds td{
		background:#f7f7f7;
	}
	#ui-id-1 {
		border: 1px solid #d0d6de;
		background: #eff3f8;
		position: absolute !important;
		z-index: 9999999;
		padding: 0;
	}
	.ccustomClass {
		width: 500px !important;
	}
	.ccustomClass li {
		display: inline-flex;
		border-bottom: 1px #888 dashed;
		width: 100%;
	}
	.ccustomClass li:first-child{
		background:#c9dce2;
		padding:5px 0;
	}
	.cchead{
		font-weight:600;
		white-space:nowrap;
		text-align:center;
		padding:0 !important;
	}
	.ccstt{
		float:left;
		width:35px;
		text-align:center;
		font-size:12px;
		padding:8px 0 5px 0;
	}
	.customer_name{
		float:left;
		width:180px;
		text-align:left;
		font-size:12px;
		padding:8px 0 5px 0;
	}
	.identity{
		float:left;
		width:150px;
		text-align:left;
		font-size:12px;
		padding:8px 0 5px 0;
	}
	.phone{
		float:left;
		width:120px;
		text-align:left;
		font-size:12px;
		padding:8px 0 5px 0;
	}
	.ui-autocomplete{
		width: 500px !important;
	}
</style>
<script>
	var controller  = '<?=base_url()?>orderroom/';
	var temp_goodsid = 0;
	var temp_goods_code = 0; 
	var temp_stype = 0;
	var temp_exchangs = 0;
	var findService = '<?=$findService;?>';
	var vbeep = '<?=url_tmpl();?>scan/js/beep.mp3';
	$(function(){
		handleSelect2();
		initForm();
		ComponentsPickers.init();
		formatNumberKeyUp('fm-number');
		formatNumber('fm-number');
		autocompleteSearchCMND();
		autocompleteSearchName();
		/*if(findService != '0' && findService != 0){
			
		}*/
		serviceOther();
		customerOther();
	});
	function initForm(){
		$('#input_lease').change(function(){
			getPrice();
		});
		$('#input_price_type').change(function(){
			getPrice();
		});
		$( "#goodsid" ).keypress(function(e){
			if(e.keyCode == 13){ //dung may Scan
				var goods_code = $.trim($(this).val());
				if(goods_code == ''){
					return false;
				}			
				gooods(temp_goodsid,temp_goods_code,temp_stype,temp_exchangs,'');
			}
		});
		//autocompleteCustomerOther();
		/*$('#tabserviceClick').click(function(){
			 serviceOther();
		});
		$('#tabcustomerClick').click(function(){
			customerOther();
			//autocompleteCustomerOther();
		});*/
	}
	function serviceOther(){
		var roomid = '<?=$finds->id;?>';
		 $.ajax({
			url : '<?=base_url()?>orderroom'+'/tabserviceLoad',
			type: 'POST',
			async: false,
			data:{roomid:roomid}, 
			success:function(datas){
				var obj = $.evalJSON(datas); 
				$('#tabserviceLoads').html(obj.content);
			}
		});  	
	}
	function customerOther(){
		 var roomid = '<?=$finds->id;?>';
		 $.ajax({
			url : '<?=base_url()?>orderroom'+'/tabcustomerLoad',
			type: 'POST',
			async: false,
			data:{roomid:roomid}, 
			success:function(datas){
				var obj = $.evalJSON(datas); 
				$('#tabcustomerLoad').html(obj.content);
			}
		});  	
	}
	function setDefault(){
		
	}
	function autocompleteSearchName(){
		$('#input_customer_name').autocomplete({ 
			source: function( request, response ){
				$('#addicon_iconsearch').html('<i id="farefresh" class="fa fa-refresh farefresh" aria-hidden="true"></i>');
				$.ajax({
					url: '<?=base_url();?>orderroom/autocompleteSearchName',
					dataType: "json",
					data: {
						name: request.term
					},
					success: function( data ) {
						$('#addicon_iconsearch').html('');
						response( data.length === 1 && data[ 0 ].length === 0 ? [] : data );
					}
				});
			},
			minLength: 1,
			select: function( event, ui ) {
				event.preventDefault();
				$('#input_customer_name').val(ui.item.label);
				$('#input_customer_cmnd').val(ui.item.identity);
				$('#input_customer_phone').val(ui.item.phone);
				if(ui.item.identity_date != '' && ui.item.identity_date != null){
					$('#input_identity_date').val(ui.item.identity_date);
				}
				$('#input_identity_from').val(ui.item.identity_from);
				$('#input_customer_address').val(ui.item.address);
				$('#input_customer_comppany').val(ui.item.company_name);
				$('#input_customer_mst').val(ui.item.company_mst); 
			},
			create: function(){
				$(this).data('ui-autocomplete')._renderItem  = function (ul, item) {
				  var imei = '';
				  if(item.imei != ''){
					  imei = 'IMEI: '+item.imei;
				  }
				  ul.addClass('ccustomClass'); 
				  return $("<li>")
					//.addClass("w600")
					.attr("data-value", item.stt)
					.append("<div class='ccstt'>"+item.stt+"</div><div class='customer_name'><b>"+item.customer_name+"</b></div><div class='identity'><b>"+item.identity+"</b></div><div class='phone'>"+item.phone+"</div>")
					.appendTo(ul);
				};
			},
			response: function(event, ui){
				
			}
		});
	}
	function autocompleteSearchCMND(){
		$('#input_customer_cmnd').autocomplete({ 
			source: function( request, response ){
				$('#addicon_iconsearch').html('<i id="farefresh" class="fa fa-refresh farefresh" aria-hidden="true"></i>');
				$.ajax({
					url: '<?=base_url();?>orderroom/autocompleteSearchCMND',
					dataType: "json",
					data: {
						cmnd: request.term
					},
					success: function( data ) {
						$('#addicon_iconsearch').html('');
						response( data.length === 1 && data[ 0 ].length === 0 ? [] : data );
					}
				});
			},
			minLength: 1,
			select: function( event, ui ) {
				event.preventDefault();
				$('#input_customer_name').val(ui.item.label);
				$('#input_customer_cmnd').val(ui.item.identity);
				$('#input_customer_phone').val(ui.item.phone);
				if(ui.item.identity_date != '' && ui.item.identity_date != null){
					$('#input_identity_date').val(ui.item.identity_date);
				}
				$('#input_identity_from').val(ui.item.identity_from);
				$('#input_customer_address').val(ui.item.address);
				$('#input_customer_comppany').val(ui.item.company_name);
				$('#input_customer_mst').val(ui.item.company_mst); 
			},
			create: function(){
				$(this).data('ui-autocomplete')._renderItem  = function (ul, item) {
				  var imei = '';
				  if(item.imei != ''){
					  imei = 'IMEI: '+item.imei;
				  }
				  ul.addClass('ccustomClass'); 
				  return $("<li>")
						.attr("data-value", item.stt)
						.append("<div class='ccstt'>"+item.stt+"</div><div class='customer_name'><b>"+item.customer_name+"</b></div><div class='identity'><b>"+item.identity+"</b></div><div class='phone'>"+item.phone+"</div>")
						.appendTo(ul);
				};
			},
			response: function(event, ui){
				
			}
		});
	}
	$(document.body).on('click', '#actionSave',function (){
		save();
	});
	function save(){
		var itemList = getTemIDs(); 
		var search = getFormInput();
		var otherCus = getCustomerOther();
		var roomid = $('#roomid').val();
		var obj = $.evalJSON(search); 
		var id = $('#id').val();
		if(obj.fromdate == ''){
			warning("<?=getLanguage('thoi-gian-bat-dau-khong-duoc-trong');?>"); return false;	
		}
		if(obj.customer_name == ''){
			warning("<?=getLanguage('ten-khach-hang-khong-duoc-trong');?>"); return false;	
		}
		if(obj.customer_cmnd == ''){
			warning("<?=getLanguage('cmnd-khong-duoc-trong');?>"); return false;	
		}
		var scanned_img_font1 = $('#scanned-img').attr('src'); 
		var scanned_img_back1 = $('#scanned-img-2').attr('src'); 
		var data = new FormData();
		data.append('search', search);
		data.append('itemList', itemList);
		data.append('otherCus', otherCus);
		data.append('roomid', roomid);
		data.append('scanned_img_font1', scanned_img_font1);
		data.append('scanned_img_back1', scanned_img_back1);
		data.append('id',id);
		$.ajax({
			url : controller + "save",
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
					warning(obj.msg); return false;	
				}
				else{
					success("<?=getLanguage('dat-phong-thanh-cong');?>"); 
					getRoomList('','','');
					return false;	
				}
				$('.loading').hide();
			},
			error : function(){
				$('.loading').hide();
				error("<?=getLanguage('dat-phong-khong-thanh-cong');?>"); return false;	
			}
		});
	}
	function getTemIDs(){
		var objReq = {};
		$(".satids").each(function(i){
			var val = $(this).val(); 
			objReq[val] = val;
		});
		return JSON.stringify(objReq);
	}
	function getCustomerOther(){
		//C1
		var objReq = {};
		$(".form-input-c1").each(function(i) {
			var id = $(this).attr('id');
			var val = $(this).val();
			val = val.replace(/['"]/g, '');
			if(id != undefined){ // neu co dinh nghia id la gi
				var ids = id.replace('input_','');
				var res = id.substring(0, 4); 
				if(res != 's2id'){
					objReq[ids] = $.trim(val);
				}
			}
		});
		//C2
		var objReq2 = {};
		$(".form-input-c2").each(function(i) {
			var id = $(this).attr('id');
			var val = $(this).val();
			val = val.replace(/['"]/g, '');
			if(id != undefined){ // neu co dinh nghia id la gi
				var ids = id.replace('input_','');
				var res = id.substring(0, 4); 
				if(res != 's2id'){
					objReq2[ids] = $.trim(val);
				}
			}
		});
		//C3
		var objReq3 = {};
		$(".form-input-c2").each(function(i) {
			var id = $(this).attr('id');
			var val = $(this).val();
			val = val.replace(/['"]/g, '');
			if(id != undefined){ // neu co dinh nghia id la gi
				var ids = id.replace('input_','');
				var res = id.substring(0, 4); 
				if(res != 's2id'){
					objReq3[ids] = $.trim(val);
				}
			}
		});
		var customer = {};
		customer.c1 = objReq;
		customer.c2 = objReq2;
		customer.c3 = objReq3;
		return JSON.stringify(customer);
	}
</script>
<script type="text/javascript" src="<?=url_tmpl();?>scan/js/qrcodelib.js"></script>
<script type="text/javascript" src="<?=url_tmpl();?>scan/js/WebCodeCam.js"></script>
<script type="text/javascript" src="<?=url_tmpl();?>scan/js/main.js"></script>