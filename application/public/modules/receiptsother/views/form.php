<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('loai-phieu-thu')?> (<span class="red">*</span>)</label>
			<div class="col-md-8" >
				<select name="typeid" id="typeid" class="combos-input select2me form-control" data-placeholder="<?=getLanguage('chon-loai-phieu-thu')?>">
					<option value=""></option>
					<?php foreach ($pays as $item) { ?>
						<option <?php if($item->id == $finds->typeid){?> selected <?php }?> value="<?=$item->id;?>"><?=$item->receipts_type_name;?></option>
					<?php } ?>
				</select>
			</div>
		</div>
	</div>
</div>
<div class="row mtop10">
	<div class="col-md-12">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('so-tien');?> (<span class="red">*</span>)</label>
			<div class="col-md-8">
				<input type="text" maxlength="10"  name="input_amount" id="input_amount" class="form-input fm-number form-control" value="<?=$finds->amount;?>" />
			</div>
		</div>
	</div>
</div>
<div class="row mtop10">
	<div class="col-md-12">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('hinh-thuc-thanh-toan');?></label>
			<div class="col-md-8">
				<select id="payment" name="payment" class="combos-input select2me form-control" data-placeholder="<?=getLanguage('chon-hinh-thuc-thanh-toan')?>">
					<option <?php if(1 == $finds->payment){?> selected <?php }?> value="1"><?=getLanguage('tien-mat');?></option>
					<option <?php if(2 == $finds->payment){?> selected <?php }?> value="2"><?=getLanguage('chuyen-khoan');?></option>
				</select>
			</div>
		</div>
	</div>
</div>
<div class="row mtop10" id="showBank">
	<div class="col-md-12">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('ngan-hang');?></label>
			<div class="col-md-8">
				<select id="input_bankid" name="input_bankid" class="combos-input select2me form-control" data-placeholder="<?=getLanguage('chon-ngan-hang')?>">
					<option value=""></option>
					<?php foreach($banks as $item){?>
						<option <?php if($item->id == $finds->bankid){?> selected <?php }?> value="<?=$item->id;?>"><?=$item->bank_name;?></option>
					<?php }?>
				</select>
			</div>
		</div>
	</div>
</div>
<div class="row mtop10">
	<div class="col-md-12">
		<div class="form-group">
			<?php 
				$datecreate = date(cfdate(),strtotime(gmdate("Y-m-d", time() + 7 * 3600)));
				if(!empty($finds->datecreate) && $finds->datecreate != '0000-00-00 00:00:00'){
					$datecreate = date(cfdate(),strtotime($finds->datecreate));
				}
			?>
			<label class="control-label col-md-4"><?=getLanguage('ngay-chi');?> (<span class="red">*</span>)</label>
			 <div class="col-md-8 date date-picker" data-date-format="<?=cfdateHtml();?>">
				<input type="text" id="input_datecreate" placeholder="<?=cfdateHtml();?>" name="input_datecreate" class="form-control form-input" value="<?=$datecreate;?>" >
				<span class="input-group-btn ">
					<button class="btn default btn-picker" type="button"><i class="fa fa-calendar "></i></button>
				</span>
			</div>
		</div>
	</div>
</div>
<div class="row mtop10">
	<div class="col-md-12">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('ghi-chu');?></label>
			<div class="col-md-8">
				<input type="text" maxlength="250"  name="input_notes" id="input_notes" class="form-input form-control" value="<?=$finds->notes;?>" />
			</div>
		</div>
	</div>
</div>
<div class="row mtop10"></div>
<script>
	$(function(){
		handleSelect2();
		initForm();
		ComponentsPickers.init();
	});
	function initForm(){
		formatNumberKeyUp('fm-number');
		$("#input_bankid").prop("disabled",true );
		$('#payment').change(function(){
			var payment = $(this).val();
			if(payment == '1'){
				$("#input_bankid").prop("disabled",true);
			}
			else{
				$("#input_bankid").prop("disabled",false);
			}
		});
	}
</script>
