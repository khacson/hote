<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('khach-hang');?> (<span class="red">*</span>)</label>
			<div class="col-md-8">
				<select id="input_supplierid" name="input_supplierid" class="combos-input select2me form-control" data-placeholder="<?=getLanguage('chon-khach-hang')?>">
					<option value=""></option>
					<?php foreach($suppliers as $item){?>
						<option <?php if($finds->customerid == $item->id){?> selected <?php }?> value="<?=$item->id;?>"><?=$item->customer_name;?></option>
					<?php }?>
				</select>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('don-hang');?></label>
			<div class="col-md-8">
				<input type="text" value="<?=$finds->poid;?>" id="poid" placeholder="" name="poid" class="form-control searchs tab-event" maxlength="20" >
			</div>
		</div>
	</div>
</div>
<div class="row mtop10">
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('so-tien');?></label>
			<div class="col-md-8">
				<input type="text" name="input_amount"  id="input_amount" class="form-input form-control" 
				value="<?=$finds->input_amount;?>" placeholder=""
				/>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('hinh-thuc-thanh-toan');?></label>
			<div class="col-md-8">
				<select id="input_payments" name="input_payments" class="combos-input select2me form-control" data-placeholder="<?=getLanguage('chon-hinh-thuc-thanh-toan')?>">
					<option <?php if(1 == $finds->payments){?> selected <?php }?> value="1"><?=getLanguage('tien-mat');?></option>
					<option <?php if(2 == $finds->payments){?> selected <?php }?> value="2"><?=getLanguage('chuyen-khoan');?></option>
					<!--<option <?php if(3 == $finds->payments){?> selected <?php }?> value="3"><?=getLanguage('the');?></option>-->
				</select>
			</div>
		</div>
	</div>
	<div class="col-md-6 ">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('ngay-chi');?> (<span class="red">*</span>)</label>
			 <div class="col-md-8 input-group date date-picker" data-date-format="<?=cfdateHtml();?>">
				<?php 
					if(!empty($finds->datepo)){
						$timeNow = date(configs('cfdate'),strtotime($finds->datepo));
					}
				?>
				<input type="text" id="input_datepo" placeholder="<?=cfdateHtml();?>" name="input_datepo" class="form-control form-input" value="<?=$timeNow;?>" >
				<span class="input-group-btn ">
					<button class="btn default btn-picker" type="button"><i class="fa fa-calendar "></i></button>
				</span>
			</div>
		</div>
	</div>
<div>
<div class="row mtop10">
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('loai-phieu-thu');?></label>
			<div class="col-md-8">
				<select id="input_liabilities" name="input_liabilities" class="combos-input select2me form-control" data-placeholder="<?=getLanguage('chon-loai-phieu-thu')?>">
					<option <?php if(2 == $finds->payments){?> selected <?php }?> value="2"><?=getLanguage('chi-ban-hang');?></option>
					<option <?php if(1 == $finds->payments){?> selected <?php }?> value="1"><?=getLanguage('cong-no-dau-ky');?></option>
				</select>
			</div>
		</div>
	</div>
<div>
<div class="row mtop10">
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('ghi-chu');?></label>
			 <div class="col-md-8">
				<input type="text" value="<?=$finds->description;?>" id="input_description" placeholder="" name="input_description" class="form-control searchs" >
			</div>
		</div>
	</div>
<div>

<?php
	//print_r($finds);
?>
<script>
	$(function(){
		handleSelect2();
		initForm();
	});
	function initForm(){
		$('#input_distric_name').select();
	}
</script>
