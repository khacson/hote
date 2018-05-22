<ul class="nav nav-tabs" style="margin-top:-10px;">
  <li class="active showsave"><a data-toggle="tab" href="#tabhome"><?=$title;?> - <?=$finds->room_name;?></a></li>
  <li id="tabserviceClick" class="showsave"><a data-toggle="tab" href="#tabservice"><?=getLanguage('dich-vu');?></a></li>
  <li class="showsave"><a data-toggle="tab" href="#tabcustomer"><?=getLanguage('them-khach-hang');?></a></li>
  <li class="showsave"><a data-toggle="tab" href="#tabhistory"><?=getLanguage('lich-dat-phong');?></a></li>
  <li style="float:right;">
	 <button type="button" style="margin-top:10px;" class="close" data-dismiss="modal">&times;</button>
  </li>
</ul>
<div class="tab-content">
    <div id="tabhome" class="tab-pane fade in active">
		 <div class="row mtop10">
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
									<select id="input_fromdateHours" name="input_todateHours" class="combos-input select2me form-control" >
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
									<select id="input_fromdateMinute" name="input_todateMinute" class="combos-input select2me form-control" >
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
						<input type="text" name="input_customer_phone" id="input_customer_phone" maxlength="12" class="form-input form-control " />
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
	</div>
	<!--E Home-->
	<div id="tabservice" class="tab-pane fade">
		<div class="row" style="margin-bottom:15px;">
			<div class="row mtop10">
				<div class="col-md-12">
					<div class="form-group">
						<label  class="control-label col-md-3" ><?=getLanguage('hang-hoa-dich-vu');?></label>
						<div class="col-md-9" >
							<input type="text" placeholder="Tìm theo tên hoạc mã" name="goodsid" id="goodsid" placeholder="" class="search form-control " />
						</div>
					</div>
				</div>
			</div>
			<div class="row mtop10">
				<div class="col-md-12">
					<table class="inputgoods">
						<thead>
							<tr class="thds">
								<td width="30" rowspan="2"><?=getLanguage('stt');?></td>
								<td rowspan="2" ><?=getLanguage('hang-hoa');?></td>
								<td width="75" rowspan="2"><?=getLanguage('dvt');?></td>
								<td width="85" rowspan="2"><?=getLanguage('so-luong');?></td>
								<td width="90" rowspan="2"><?=getLanguage('don-gia');?></td>
								<td width="150" colspan="2"><?=getLanguage('chiet-khau');?></td>
								<td width="100" rowspan="2"><?=getLanguage('thanh-tien');?></td>
								<td width="30" rowspan="2"></td>
							</tr>
							<tr class="thds">
							  <td ><?=configs()['currency'];?>/%</td>
							  <td ><?=getLanguage('san-pham');?></td>
							</tr>
						</thead>
						<tbody class="gridView"></tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<!--E Service-->
	<div id="tabcustomer" class="tab-pane fade">
		 <div class="row">
			<a href="#" style="float:right; margin-bottom:-25px; margin-right:10px;" class="btn"><i class="fa fa-plus"></i></a>
		 </div>
		 <fieldset><!--Khach hang 2-->
			<legend class="f16"  style="color:#0090d9;"><?=getLanguage('khach-hang');?> 1</legend>
				 <!--E Row-->
				  <div class="row mtop10">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label col-md-4 nowrap"><?=getLanguage('ten-khach-hang');?></label>
							<div class="col-md-8">
								<input type="text" name="input_customer_name1" id="input_customer_name1" maxlength="50" class="form-input-c1 form-control " />
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label col-md-4"><?=getLanguage('cmnd');?> </label>
							<div class="col-md-8">
								<input type="text" name="input_customer_cmnd1" id="input_customer_cmnd1" maxlength="12" class="form-input-c1 form-control " />
							</div>
						</div>
					</div>
				 </div>
				 <!--E Row-->
				 <div class="row mtop10">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label col-md-4"><?=getLanguage('ngay-cap');?></label>
							<div class="col-md-8 date date-picker form-input">
								<input type="text" id="input_identity_date1" placeholder="<?=cfdateHtml();?>" name="input_identity_date1" class="form-control form-input-c1" >
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
								<input type="text" name="input_identity_from1" id="input_identity_from1" maxlength="100" class="form-input-c1 form-control " />
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
								<input type="text" name="input_customer_phone1" id="input_customer_phone1" maxlength="12" class="form-input-c1 form-control " />
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label col-md-4"><?=getLanguage('dia-chi');?></label>
							<div class="col-md-8">
								<input type="text" name="input_customer_address1" id="input_customer_address1" maxlength="100" class="form-input-c1 form-control " />
							</div>
						</div>
					</div>
				 </div>
				 <!--E Row-->
		</fieldset>
		<fieldset class="mtop10"><!--Khach hang 3-->
			<legend class="f16" style="color:#0090d9;"><?=getLanguage('khach-hang');?> 2</legend>
				 <!--E Row-->
				  <div class="row mtop10">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label col-md-4 nowrap"><?=getLanguage('ten-khach-hang');?></label>
							<div class="col-md-8">
								<input type="text" name="input_customer_name2" id="input_customer_name2" maxlength="50" class="form-input-c2 form-control " />
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label col-md-4"><?=getLanguage('cmnd');?> </label>
							<div class="col-md-8">
								<input type="text" name="input_customer_cmnd2" id="input_customer_cmnd2" maxlength="13" class="form-input-c2 form-control " />
							</div>
						</div>
					</div>
				 </div>
				 <!--E Row-->
				 <div class="row mtop10">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label col-md-4"><?=getLanguage('ngay-cap');?></label>
							<div class="col-md-8 date date-picker form-input">
								<input type="text" id="input_identity_date2" placeholder="<?=cfdateHtml();?>" name="input_identity_date2" class="form-control form-input-c2" >
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
								<input type="text" name="input_identity_from2" id="input_identity_from2" maxlength="100" class="form-input-c2 form-control " />
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
								<input type="text" name="input_customer_phone2" id="input_customer_phone2" maxlength="13" class="form-input-c2 form-control " />
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label col-md-4"><?=getLanguage('dia-chi');?></label>
							<div class="col-md-8">
								<input type="text" name="input_customer_address2" id="input_customer_address2" maxlength="100" class="form-input-c2 form-control " />
							</div>
						</div>
					</div>
				 </div>
				 <!--E Row-->
		</fieldset>
		<fieldset class="mtop10"><!--Khach hang 2-->
			<legend class="f16"  style="color:#0090d9;"><?=getLanguage('khach-hang');?> 3</legend>
				 <!--E Row-->
				  <div class="row mtop10">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label col-md-4 nowrap"><?=getLanguage('ten-khach-hang');?></label>
							<div class="col-md-8">
								<input type="text" name="input_customer_name3" id="input_customer_name3" maxlength="50" class="form-input-c3 form-control " />
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label col-md-4"><?=getLanguage('cmnd');?> </label>
							<div class="col-md-8">
								<input type="text" name="input_customer_cmnd3" id="input_customer_cmnd3" maxlength="14" class="form-input-c3 form-control " />
							</div>
						</div>
					</div>
				 </div>
				 <!--E Row-->
				 <div class="row mtop10">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label col-md-4"><?=getLanguage('ngay-cap');?></label>
							<div class="col-md-8 date date-picker form-input">
								<input type="text" id="input_identity_date3" placeholder="<?=cfdateHtml();?>" name="input_identity_date3" class="form-control form-input-c3" >
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
								<input type="text" name="input_identity_from3" id="input_identity_from3" maxlength="100" class="form-input-c3 form-control " />
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
								<input type="text" name="input_customer_phone3" id="input_customer_phone3" maxlength="14" class="form-input-c3 form-control " />
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label col-md-4"><?=getLanguage('dia-chi');?></label>
							<div class="col-md-8">
								<input type="text" name="input_customer_address3" id="input_customer_address3" maxlength="100" class="form-input-c3 form-control " />
							</div>
						</div>
					</div>
				 </div>
				 <!--E Row-->
		</fieldset>
	</div>
	<div id="tabhistory" class="tab-pane fade">
		<div class="row mtop10"> 
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
<style>
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
	$(function(){
		handleSelect2();
		initForm();
		ComponentsPickers.init();
		formatNumberKeyUp('fm-number');
		formatNumber('fm-number');
		autocompleteSearchCMND();
		autocompleteSearchName();
		autocompleteService();
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
		gridView(0);
		autocompleteCustomerOther();
		$('#tabserviceClick').click(function(){
			gridView(0);
			actionTemp();
			setDefault();
			calInputTotal();
			formatNumberKeyUp('fm-number');
			formatNumber('fm-number');
			
		});
	}
	function getPrice(){
		var roomid = '<?=$finds->id;?>';
		var lease = $('#input_lease').val();
		var price_type = $('#input_price_type').val();
		$.ajax({
			url : '<?=base_url()?>orderroom'+'/getPrice',
			type: 'POST',
			async: false,
			data:{lease:lease,roomid:roomid,price_type:price_type}, 
			success:function(datas){
				$('#input_price').val(datas);
			}
		});
	}
	function autocompleteService(){
		$("#goodsid").autocomplete({
			//source: goodsList,
			source: function( request, response ) {
				$.ajax( {
					url: "<?=base_url();?>orderroom/getFindGoods",
					dataType: "json",
					type: 'POST',
					async: false,
					data: {
						goodscode: request.term
					},
					success: function( data ) {
						response( data.length === 1 && data[ 0 ].length === 0 ? [] : data );
						if (data.length === 0){
							return false;
						}
						temp_goodsid = data[0].goodsid;
						temp_goods_code = data[0].goods_code;
						temp_stype = data[0].stype;
						temp_exchangs = data[0].exchangs;											
					}
				} );
			},
			select: function( event, ui ){ 
				event.preventDefault();
				$( "#goodsid" ).val( ui.item.label); //ui.item is your object from the array
				var goodsid = ui.item.value;
				var goods_code = ui.item.goods_code;
				gooods(goodsid,goods_code,ui.item.stype,ui.item.exchangs,'');
				return false;
			},
			focus: function(event, ui) {
				event.preventDefault();
				$("#goodsid").val(ui.item.label);
			}
		});
	}
	function gooods(goodsid,code,stype,exchangs,deletes){ 
	    var vat = $('.valtotal').val();
		var xkm = 0;
		if($('#xuatkm').is(':checked')){
			xkm = 1;
		}
		var uniqueid = $('#uniqueidnew').val();
		var roomid = '<?=$finds->id;?>';
		$.ajax({
			url : controller + 'getGoods',
			type: 'POST',
			async: false,
			data: {roomid:roomid, vat:vat,xkm:xkm, id:goodsid,code:code,stype:stype,exchangs:exchangs,deletes:deletes,isnew:0,uniqueid:uniqueid},
			success:function(datas){
				var obj = $.evalJSON(datas); 
				if(obj.status == 0){
					error('Hàng hóa không tồn tại trong hệ thống'); return false;
				}
				$('.gridView').html(obj.content); //Add Grid view
				//$('.ttprice').html(obj.totalPrice);
				$('#uniqueid').val(obj.uniqueid);
				formatNumberKeyUp('fm-number');
				formatNumber('fm-number');
				$('#goodsid').val('');
				actionTemp();
				clickViewImg();
			}
		});
	}
	function gridView(isnew){
		var roomid = '<?=$finds->id;?>';
		$.ajax({
			url : controller + 'loadDataTempAdd',
			type: 'POST',
			async: false,
			data: {isnew:isnew, roomid:roomid},
			success:function(datas){
				var obj = $.evalJSON(datas);
				$('.gridView').html(obj.content);				
			}
		});
	}
	function clickViewImg(){
		$('.viewImg').each(function(){
			$(this).click(function(){
				 var url = $(this).attr('src');
				 viewImg(url); return false;
			});
		});
	}
	function actionTemp(){
		//Xóa
		$('.deleteItem').each(function(){ 
			$(this).on('click',function(){
				$(this).parent().parent().remove();
				var detailid = $(this).attr('detailid'); 
				$.ajax({
					url : controller + 'deleteTempData',
					type: 'POST',
					async: false,
					data: {detailid:detailid},
					success:function(datas){
						gooods(0,0,0,0,'delete');
					}
				}); 
				calInputTotal();
			});
		});
		//Update don gia 
		$('.priceone').each(function(idx){
			$(this).on('keyup',function(){
				var goodid = $(this).attr('goodid'); 
				setPrice(goodid);
				updateDataTemp(goodid);
			});
			$(this).on('change',function(){
				var goodid = $(this).attr('goodid'); 
				setPrice(goodid);
				updateDataTemp(goodid);
			});
			$(this).on('dblclick',function(){
				$(this).select();
			});
		});
		$('.quantity').each(function(idx){
			$(this).on('click',function(){
				var goodid = $(this).attr('goodid'); 
				setPrice(goodid);
				updateDataTemp(goodid);
			});
			$(this).on('keyup',function(){
				var goodid = $(this).attr('goodid'); 
				setPrice(goodid);
				updateDataTemp(goodid);
			});
			$(this).on('dblclick',function(){
				$(this).select();
			});
		});
		//Giam gia
		$('.discount').each(function(idx){
			$(this).on('keyup',function(){
				var goodid = $(this).attr('goodid'); 
				setPrice(goodid);
				updateDataTemp(goodid);
			});
			$(this).on('dblclick',function(){
				$(this).select();
			});
		});
		//Xuất khuyến mải
		$('.xuatkhuyenmai').each(function(idx){
			$(this).on('keyup',function(){
				var goodid = $(this).attr('goodid'); 
				setPrice(goodid);
				updateDataTemp(goodid);
			});
			$(this).on('dblclick',function(){
				$(this).select();
			});
		});
		//Đơn vị tính
		$('.unitid').each(function(idx){
			$(this).on('click',function(){
				var goodid = $(this).attr('goodid'); 
				updateDataTemp(goodid);
			});
		});
	}
	function setPrice(goodid){
		var priceone = $('#priceone_'+goodid).val();
		var quantity = $('#quantity_'+goodid).val();
		var discount = $('#discount_'+goodid).val();
		//var vat = $('#vat_'+goodid).val();
		var xkm = $('#xkm_'+goodid).val();
		if (xkm == '') {
			xkm = '0';
		}
		xkm = parseFloat(xkm.replace(/[^0-9+\-Ee.]/g, ''));
		//priceone
		if (priceone == '') {
			priceone = '0';
		}
		priceone = parseFloat(priceone.replace(/[^0-9+\-Ee.]/g, ''));
		//quantity
		if (quantity == '') {
			quantity = ',0';
		}
		quantity = parseFloat(quantity.replace(/[^0-9+\-Ee.]/g, ''));
		//Tinh Tong
		var quantityEnd = quantity - xkm; //Giam gia sản phẩm thì trừ sản phẩm trước
		var priceEnd = quantityEnd * priceone; 
		//Tinh giảm giá
		var k = discount.split('%');
		var tinhtheo = 0;
		if(k.length > 1){
			tinhtheo = 1;
		}
		//discount
		if(discount == ''){
			discount = '0';
		}
		discount = discount.replace(/[^0-9+\-Ee.]/g, '');
		//Tinh theo %
		var giamGia = 0;
		if(tinhtheo == 1){
			giamGia = (priceEnd * discount)/100;
		}
		else{//Giam tiền
			giamGia = discount;
		}
		var priceEnds = priceEnd - giamGia;
		//console.log(priceEnds);
		$('#price_'+goodid).val(formatOne(priceEnds));
		calInputTotal();
	}
	function calInputTotal(){
		var t_quantity = 0;
		$('.quantity').each(function(){
			var quantity = $(this).val();
			if (quantity == '') {
				quantity = '0';
			}
			quantity = parseFloat(quantity.replace(/[^0-9+\-Ee.]/g, ''));
			t_quantity+= quantity;
		});
		//console.log(t_quantity);
		$('#tong_so_luong').html(formatOne(t_quantity)); //tong_so_luong
		//Tong so luong giam tong_ck_soluong
		var t_xuatkhuyenmai  = 0;
		$('.xuatkhuyenmai').each(function(){
			var xuatkhuyenmai  = $(this).val();
			if (xuatkhuyenmai  == '') {
				xuatkhuyenmai  = '0';
			}
			xuatkhuyenmai  = parseFloat(xuatkhuyenmai.replace(/[^0-9+\-Ee.]/g, ''));
			t_xuatkhuyenmai += xuatkhuyenmai ;
		});
		$('#tong_ck_soluong').html(formatOne(t_xuatkhuyenmai));
		//Thanh tien  price_prepay tongtienhang
		var t_buyprice = 0;
		$('.buyprice').each(function(){
			var buyprice  = $(this).val();
			if (buyprice  == '') {
				buyprice  = '0';
			}
			buyprice  = parseFloat(buyprice.replace(/[^0-9+\-Ee.]/g, ''));
			t_buyprice += buyprice ;
		}); 
		$('#tongtienhang').html(formatOne(t_buyprice));
		/*$('#total-amount').val(formatOne(t_buyprice));
		//Giam giá total-amount
		var discount = $('#discount').val();
		if (discount == '') {
			discount = '0';
		}
		discount = parseFloat(discount.replace(/[^0-9+\-Ee.]/g, ''));
		var input_discount_type = parseFloat($('#input_discount_type').val());
		var giamGia = discount;
		if(input_discount_type == 2){
			giamGia = (t_buyprice * discount)/100;
		}
		$('#total-discount').val(formatOne(giamGia));
		//console.log('dieu chinh: '+giamGia);
		//Giam gia 
		var adjustment = $('#adjustment').val();
		if (adjustment == '') {
			adjustment = '0';
		}
		adjustment = parseFloat(adjustment.replace(/[^0-9+\-Ee.]/g, ''));
		$('#total-adjustment').val(formatOne(adjustment));
		//console.log('dieu chinh: '+adjustment);
		//VAT
		var vat = $('#vat').val();
		if (vat == '') {
			vat = '0';
		}
		vat = parseFloat(vat.replace(/[^0-9+\-Ee.]/g, ''));
		//Tong cong
		var tong_cong = t_buyprice - giamGia + (adjustment);
		//VAT
		var totalVat = (tong_cong * vat)/100;
		//console.log(tong_cong);
		//console.log(totalVat);
		$('#total-vat').val(formatOne(totalVat));
		
		var tong_congs = tong_cong + totalVat;
		$('#total-amount-end').val(formatOne(tong_congs));
		//Tam ung
		var price_prepay = $('#price_prepay').val();
		if (price_prepay == '') {
			price_prepay = '0';
		}
		price_prepay = parseFloat(price_prepay.replace(/[^0-9+\-Ee.]/g, ''));
		var price_prepay_type = parseFloat($('#price_prepay_type').val());
		var tamUng = price_prepay;
		if(price_prepay_type == 2){
			tamUng = (tong_congs * price_prepay)/100;
		}
		$('#total-tamung').val(formatOne(tamUng));
		//Con lai
		$('#total-amount-end_cl').val(formatOne(tong_congs-tamUng));
		*/
	}
	function viewImg(url) {
		$.fancybox({
			'width': 600,
			'height': 500,
			'autoSize' : false,
			'hideOnContentClick': true,
			'enableEscapeButton': true,
			'titleShow': true,
			'href': "#viewImg-form",
			'scrolling': 'no',
			'afterShow': function(){
				$('#viewImg-form-gridview').html('<img style="width:600px; height:500px;" src="'+url+'" />');
			}
		});
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
				$('#input_customer_mst').val(ui.item.address); 
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
	function setDefault(){
		
	}
	function autocompleteCustomerOther(){
		//1
		$('#input_customer_name1').autocomplete({ 
			source: function( request, response ){
				$('#addicon_iconsearch').html('<i id="farefresh" class="fa fa-refresh farefresh" aria-hidden="true"></i>');
				$.ajax({
					url: '<?=base_url();?>orderroom/autocompleteSearchName',
					dataType: "json",
					data: {
						name: request.term
					},
					success: function( data ) {
						//$('#addicon_iconsearch').html('');
						response( data.length === 1 && data[ 0 ].length === 0 ? [] : data );
					}
				});
			},
			minLength: 1,
			select: function( event, ui ) {
				event.preventDefault();
				$('#input_customer_name1').val(ui.item.label);
				$('#input_customer_cmnd1').val(ui.item.identity);
				$('#input_customer_phone1').val(ui.item.phone);
				if(ui.item.identity_date != '' && ui.item.identity_date != null){
					$('#input_identity_date1').val(ui.item.identity_date);
				}
				$('#input_identity_from1').val(ui.item.identity_from);
				$('#input_customer_address1').val(ui.item.address);
				$('#input_customer_comppany1').val(ui.item.company_name);
				$('#input_customer_mst1').val(ui.item.company_mst);
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
		//1 CMND
		$('#input_customer_cmnd1').autocomplete({ 
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
				$('#input_customer_name1').val(ui.item.label);
				$('#input_customer_cmnd1').val(ui.item.identity);
				$('#input_customer_phone1').val(ui.item.phone);
				if(ui.item.identity_date != '' && ui.item.identity_date != null){
					$('#input_identity_date1').val(ui.item.identity_date);
				}
				$('#input_identity_from1').val(ui.item.identity_from);
				$('#input_customer_address1').val(ui.item.address); 
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
		//2
		$('#input_customer_name2').autocomplete({ 
			source: function( request, response ){
				$('#addicon_iconsearch').html('<i id="farefresh" class="fa fa-refresh farefresh" aria-hidden="true"></i>');
				$.ajax({
					url: '<?=base_url();?>orderroom/autocompleteSearchName',
					dataType: "json",
					data: {
						name: request.term
					},
					success: function( data ) {
						//$('#addicon_iconsearch').html('');
						response( data.length === 1 && data[ 0 ].length === 0 ? [] : data );
					}
				});
			},
			minLength: 1,
			select: function( event, ui ) {
				event.preventDefault();
				$('#input_customer_name2').val(ui.item.label);
				$('#input_customer_cmnd2').val(ui.item.identity);
				$('#input_customer_phone2').val(ui.item.phone);
				if(ui.item.identity_date != '' && ui.item.identity_date != null){
					$('#input_identity_date2').val(ui.item.identity_date);
				}
				$('#input_identity_from2').val(ui.item.identity_from);
				$('#input_customer_address2').val(ui.item.address);
				$('#input_customer_comppany2').val(ui.item.company_name);
				$('#input_customer_mst2').val(ui.item.company_mst);
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
		//1 CMND
		$('#input_customer_cmnd2').autocomplete({ 
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
				$('#input_customer_name2').val(ui.item.label);
				$('#input_customer_cmnd2').val(ui.item.identity);
				$('#input_customer_phone2').val(ui.item.phone);
				if(ui.item.identity_date != '' && ui.item.identity_date != null){
					$('#input_identity_date2').val(ui.item.identity_date);
				}
				$('#input_identity_from2').val(ui.item.identity_from);
				$('#input_customer_address2').val(ui.item.address); 
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
		//3
		$('#input_customer_name3').autocomplete({ 
			source: function( request, response ){
				$('#addicon_iconsearch').html('<i id="farefresh" class="fa fa-refresh farefresh" aria-hidden="true"></i>');
				$.ajax({
					url: '<?=base_url();?>orderroom/autocompleteSearchName',
					dataType: "json",
					data: {
						name: request.term
					},
					success: function( data ) {
						//$('#addicon_iconsearch').html('');
						response( data.length === 1 && data[ 0 ].length === 0 ? [] : data );
					}
				});
			},
			minLength: 1,
			select: function( event, ui ) {
				event.preventDefault();
				$('#input_customer_name3').val(ui.item.label);
				$('#input_customer_cmnd3').val(ui.item.identity);
				$('#input_customer_phone3').val(ui.item.phone);
				if(ui.item.identity_date != '' && ui.item.identity_date != null){
					$('#input_identity_date3').val(ui.item.identity_date);
				}
				$('#input_identity_from3').val(ui.item.identity_from);
				$('#input_customer_address3').val(ui.item.address);
				$('#input_customer_comppany3').val(ui.item.company_name);
				$('#input_customer_mst3').val(ui.item.company_mst);
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
		//1 CMND
		$('#input_customer_cmnd3').autocomplete({ 
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
				$('#input_customer_name3').val(ui.item.label);
				$('#input_customer_cmnd3').val(ui.item.identity);
				$('#input_customer_phone3').val(ui.item.phone);
				if(ui.item.identity_date != '' && ui.item.identity_date != null){
					$('#input_identity_date3').val(ui.item.identity_date);
				}
				$('#input_identity_from3').val(ui.item.identity_from);
				$('#input_customer_address3').val(ui.item.address); 
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
		if(obj.fromdate == ''){
			warning("<?=getLanguage('thoi-gian-bat-dau-khong-duoc-trong');?>"); return false;	
		}
		if(obj.customer_name == ''){
			warning("<?=getLanguage('ten-khach-hang-khong-duoc-trong');?>"); return false;	
		}
		if(obj.customer_cmnd == ''){
			warning("<?=getLanguage('cmnd-khong-duoc-trong');?>"); return false;	
		}
		$.ajax({
			url : controller + "save",
			type: 'POST',
			async: false,
			data: {search:search, itemList:itemList, otherCus:otherCus, roomid:roomid,id:''},
			success:function(datas){
				var obj = $.evalJSON(datas); 
				$("#token").val(obj.csrfHash);
				$('.loading').hide();
				if(obj.status == 0){
					error("<?=getLanguage('dat-phong-khong-thanh-cong');?>"); return false;	
				}
				else if(obj.status == -1){
					
				}
				else{
					success("<?=getLanguage('dat-phong-thanh-cong');?>"); return false;	
				}
				$('.loading').hide();
			},
			error : function(){
				$('.loading').hide();
				error("<?=getLanguage('dat-phong-khong-thanh-cong');?>"); return false;	
			}
		});
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
		customer['c1'] = objReq;
		customer['c2'] = objReq2;
		customer['c3'] = objReq3;
		return JSON.stringify(customer);
	}
</script>