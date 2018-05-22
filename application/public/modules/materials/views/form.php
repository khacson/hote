<style>
	.tab-content .col-md-8{
		padding-left:30px;
	}
	.tab-content .col-md-7{
		padding-left:30px;
	}
</style>
<ul class="nav nav-tabs" style="margin-top:-10px;">
  <li class="active showsave"><a data-toggle="tab" href="#home"><?=$title;?></a></li>
  <li style="float:right;">
	 <button type="button" style="margin-top:10px;" class="close" data-dismiss="modal">&times;</button>
  </li>
</ul>
<div class="tab-content">
    <div id="home" class="tab-pane fade in active">
		<!--S Content-->
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('ma-nguyen-phu-lieu')?></label>
					<div class="col-md-8">
						<input type="text" name="input_goods_code" id="input_goods_code" placeholder=""  maxlength="30" value="<?=$finds->goods_code;?>" class="form-input form-control " />
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('ten-nguyen-phu-lieu')?> (<span class="red">*</span>)</label>
					<div class="col-md-8">
						<input type="text" name="input_goods_name" id="input_goods_name" placeholder="" maxlength="70" class="form-input form-control " value="<?=$finds->goods_name;?>"   />
					</div>
				</div>
			</div>
		</div>
		<div class="row mtop10">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('loai-nguyen-phu-lieu')?>  (<span class="red">*</span>)</label>
					<div class="col-md-7">
							<select id="input_goods_type" name="input_goods_type" class="combos-input select2me form-control" data-placeholder="<?=getLanguage('chon-loai-nguyen-phu-lieu')?>">
								<?php if(count($goodstypes) > 1){?>
								<option value=""></option>
								<?php }?>
								<?php foreach($goodstypes as $item){?>
									<option <?php if($finds->goods_type == $item->id){?> selected <?php }?> value="<?=$item->id;?>"><?=$item->goods_tye_name;?></option>
								<?php }?>
							</select>
					</div>
					<div class="col-md-1" style="padding:0;">
						<a style="width:25px; height:25px; margin-top:6px; float:left;" id="clickAddGoodsType" data-toggle="modal" data-target="#myModalFromType" href="#">
							<i class="fa fa-plus" style="font-size:15px;" aria-hidden="true"></i>
						</a>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('don-vi-tinh')?> (<span class="red">*</span>)</label>
					<div class="col-md-7">
						<span id="loadunit">
							<select id="input_unitid" name="input_unitid" class="combos-input select2me form-control" data-placeholder="<?=getLanguage('chon-don-vi-tinh')?>">
								<?php if(count($units) > 1){?>
								<option value=""></option>
								<?php }?>
								<?php foreach($units as $item){?>
									<option  <?php if($finds->unitid == $item->id){?> selected <?php }?> value="<?=$item->id;?>"><?=$item->unit_name;?></option>
								<?php }?>
							</select>
						</span>
					 </div>
					 <div class="col-md-1" style="padding:0;">
						<a style="width:25px; height:25px; margin-top:6px; float:left;" id="clickAddUnit" class="" href="#">
							<i class="fa fa-plus" style="font-size:15px;" aria-hidden="true"></i>
						</a>
					</div>
				</div>
			</div>
		</div>
		<div class="row mtop10">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('don-vi-quy-doi')?></label>
					<div class="col-md-7" >
						<span id="loadunitChange">
							<select id="exchange_unit" name="exchange_unit" class="combos" >
								<?php foreach($units as $item){?>
									<option value="<?=$item->id;?>"><?=$item->unit_name;?></option>
								<?php }?>
							</select>
						</span>
					 </div>
					 <div class="col-md-1" style="padding:0;">
						<a style="width:25px; height:25px; margin-top:6px; float:left;" id="clickAddUnit" class="" href="#">
							<i class="fa fa-plus" style="font-size:15px;" aria-hidden="true"></i>
						</a>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('han-su-dung')?></label>
					<div class="col-md-8">
						<select id="input_shelflife" name="input_shelflife" class="combos-input select2me form-control" >
							<option <?php if(0 == $finds->shelflife){?> selected <?php }?> value="0"><?=getLanguage('khong-co-han-su-dung')?></option>
							<option <?php if(1 == $finds->shelflife){?> selected <?php }?> value="1"><?=getLanguage('co-han-su-dung')?></option>
						</select>
					 </div>
				</div>
			</div>
		</div>
		<div class="row mtop10">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('gia-nhap')?></label>
					<div class="col-md-8">
						<input type="text" name="input_buy_price" id="input_buy_price" placeholder="" maxlength="12"  value="<?=$finds->buy_price;?>" class="form-input form-control fm-number " />
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('gia-xuat')?></label>
					<div class="col-md-8">
						<input type="text" name="input_sale_price" id="input_sale_price" placeholder="" maxlength="12" value="<?=$finds->sale_price;?>" class="form-input form-control fm-number " />
					</div>
				</div>
			</div>
		</div>
		<div class="row mtop10">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('hoa-hong')?></label>
					<div class="col-md-8" style="padding-left:0 !important;">
						<div class="col-md-7">
							<input type="text" name="input_discountsales" id="input_discountsales" placeholder="" maxlength="12" class="form-input form-control " value="<?=$finds->discountsales;?>" />
						</div>
						<div class="col-md-5" style="padding-left:0 !important; padding-right:0 !important;">
							<select id="input_discounthotel_type" name="input_discounthotel_type" class="combos-input select2me form-control" data-placeholder="<?=getLanguage('chon-loai')?>">
								<option <?php if(1 == $finds->discounthotel_type){?> selected <?php }?> value="1">%</option>
								<option <?php if(2 == $finds->discounthotel_type){?> selected <?php }?> value="2"><?=configs()['currency'];?></option>
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('chiet-khau')?></label>
					<div class="col-md-8" style="padding-left:0 !important;">
						<div class="col-md-7">
							<input type="text" name="input_discounthotel_dly" id="input_discounthotel_dly" placeholder="" maxlength="12" class="form-input form-control text-right " value="<?=$finds->discounthotel_dly;?>" />
						</div>
						<div class="col-md-5" style="padding-left:0 !important; padding-right:0 !important;">
							<select id="input_discounthotel_type_dly" name="input_discounthotel_type_dly" class="combos-input select2me form-control" data-placeholder="<?=getLanguage('chon-loai')?>">
								<option <?php if(1 == $finds->discounthotel_type_dly){?> selected <?php }?> value="1">%</option>
								<option <?php if(2 == $finds->discounthotel_type_dly){?> selected <?php }?> value="2"><?=configs()['currency'];?></option>
							</select>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row mtop10">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('xuat-xu')?></label>
					<div class="col-md-8">
						<input maxlength="70" type="text" name="input_madein" id="input_madein" placeholder="" class="form-input form-control " value="<?=$finds->madein;?>"/>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('ton-kho-toi-thieu')?></label>
					<div class="col-md-8">
						<input type="text" name="input_quantitymin" id="input_quantitymin" placeholder="" maxlength="10" class="form-input form-control " value="<?=$finds->quantitymin;?>" />
					</div>
				</div>
			</div>
		</div>
		<div class="row mtop10">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('ghi-chu')?></label>
					<div class="col-md-8">
						<input type="text" name="input_description" id="input_description" placeholder="" maxlength="100" class="form-input form-control " value="<?=$finds->description;?>" />
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('cho-xuat-am')?></label>
					<div class="col-md-8">
						<select id="input_isnegative" name="input_isnegative" class="combos-input select2me form-control" >
							<option <?php if(0 == $finds->isnegative){?> selected <?php }?> value="0"><?=getLanguage('khong-cho-xuat-am')?></option>
							<option <?php if(1 == $finds->isnegative){?> selected <?php }?> value="1"><?=getLanguage('cho-xuat-am')?></option>
						</select>
					 </div>
				</div>
			</div>
		</div>
		<div class="row mtop10">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('hinh-anh')?></label>
					<div class="col-md-8">
						<div class="col-md-6" style="padding:0px !important;" >
							<ul style="margin:0px;" class="button-group">
								<li class="" onclick ="javascript:document.getElementById('imageEnable').click();"><button type="button" class="btnone"><?=getLanguage('chon-hinh')?></button></li>
							</ul>
							<input style='display:none;' accept="image/*" id ="imageEnable" type="file" name="userfile">
						</div>
						<div class="col-md-6" >
							 <span id="show">
								 <img height="50" src="<?=base_url();?>files/goods/<?=$finds->img;?>" />
							 </span> 
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--E Content-->
	</div>
</div>
<div class="row mtop10"></div>
<style>
	.modal-content2{
		   box-shadow: 0 !important;
		border-radius:0;
	}
	.modal-content2 .modal-header{
		border-top: 1px solid #e5e5e5;
	}
</style>
<script>
    var npl = 10;
	$(function(){
		handleSelect2();
		initForm();
		$('#addrow').click(function(){
			addItem();
		});
		$('#clickAddGoodsType').click(function(){
			addGoodsType();
		});	
	});
	function addGoodsType(id){
		$.ajax({
			url : controller + 'addGoodsType',
			type: 'POST',
			async: false,
			data:{id:id},  
			success:function(datas){
				var obj = $.evalJSON(datas); 
				$('#loadContentFromType').html(obj.content);
			}
		});
	}
	/*function addItem(){
		npl+=1;
		var td_stt = '<td width="50" class="text-center">'+npl+'</td>';
		var td_np = '';
		var td_np+= '<select id="rawdata_'+npl+'" name="rawdata_'+npl+'" class="rawdata select2me form-control" data-placeholder="<?=getLanguage('chon-nguyen-phu-lieu')?>">';
		var td_np+= '<option value=""></option>';
		var td_np+= '<?php foreach($materials  as $item){?>';
		var td_np+= '<option value="<?=$item->id;?>"><?=$item->goods_name;?></option>';
		var td_np+= '<?php }?>';
		var td_np+= '</select>';
		//DVT
		var td_dvt = '';
		var td_dvt+= '<select id="rawdata_unitid_'+npl+'" name="rawdata_unitid_'+npl+'" class="rawdata_unitid select2me form-control" data-placeholder="<?=getLanguage('chon-don-vi-tinh')?>">';
		var td_dvt+= '<option value=""></option>';
		var td_dvt+= '<?php foreach($units as $item){?>';
		var td_dvt+= '<option  value="<?=$item->id;?>"><?=$item->unit_name;?></option>';
		var td_dvt+= '<?php }?>';
		var td_dvt+= '</select>';
		//Quantity
		var td_quantity = '	<input type="text" name="rawdata_quntity_'+npl+'" id="rawdata_quntity_'+npl+'" placeholder="" maxlength="100" class="form-input form-control " value="" />';	
		var tr = "<tr>";
		tr+= td_stt;
		tr+= td_np;
		tr+= td_dvt;
		tr+= td_quantity;
		tr+= "<tr>";
		$('#viewRawdata').append(tr);
	}*/
	function initForm(){
		$('#imageEnable').change(function(evt) {
            var files = evt.target.files;
            for (var i = 0, f; f = files[i]; i++){
                var size = f.size;
                //if (size < 2048000){
                    if (!f.type.match('image.*'))
                    {
                        continue;
                    }
                    var reader = new FileReader();
                    reader.onload = (function(theFile) {
                        return function(e) { //size e = e.tatal
                            $('#show').html('<img src="' + e.target.result + '" style="width:60px; height:40px" />');
                            $("#img1").val(e.target.result);
                        };
                    })(f);
                    reader.readAsDataURL(f);
            }
        });
		$('#input_goods_code').select();
		$("#exchange_unit").multipleSelect({
			filter: true,
			placeholder:'Chọn đơn vị',
			single: false,
			idtxt:'txtTime',
			textbox:1,
			textboxpln:'Giá trị',
			textboxtitle:'Quy đổi đơn vị',
			textboxwidth:60,
			textboxid:'exchange_unit_',
			onClick: function(view){
			
			}
		});
		$('#loadrawdata').click(function(){
			$.ajax({
				url : controller + 'loadRawdata',
				type: 'POST',
				async: false,
				data: {},
				success:function(datas){
					var obj = $.evalJSON(datas); 
					$('#viewRawdata').html(obj.content);
				}
			});
		});
	}
	function getValueItem(){
		//0
		var objReq0 = {};
		$('.rawdata').each(function(e){
			 var ids = $(this).attr('ids');
			 objReq0[ids] = $('#rawdata_'+ids).val();
		});
		//1
		var objReq1 = {};
		$('.rawdata_unitid').each(function(e){
			 var ids = $(this).attr('ids');
			 objReq1[ids] = $('#rawdata_unitid_'+ids).val();
		});
		//2
		var objReq2 = {};
		$('.rawdata_quntity').each(function(e){
			 var ids = $(this).attr('ids');
			 objReq2[ids] = $('#rawdata_quntity_'+ids).val();
		});
		
		var objReq = {};
		objReq.rawdata = objReq0;
		objReq.rawdata_unitid = objReq1;
		objReq.rawdata_quntity = objReq2;
		return JSON.stringify(objReq);
	}
</script>
<style>
	.tbother td{
		padding:1px;
	}
</style>
