<!--S Content-->
<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('khach-hang');?> (<span class="red">*</span>)</label>
			<div class="col-md-8" >
				<select name="input_customerid" id="input_customerid" class="combos-input select2me form-control" data-placeholder="<?=getLanguage('chon-khach-hang')?>">
					<option value=""></option>
					<?php foreach ($customers as $item) { ?>
						<option <?php if($finds->customerid == $item->id){?> selected <?php }?> value="<?=$item->id;?>"><?=$item->customer_name;?></option>
					<?php } ?>
				</select>
			</div>
		</div>
	</div>
</div>
<div class="row mtop10">
	<div class="col-md-12">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('cong-no');?> (<span class="red">*</span>)</label>
			<div class="col-md-8">
				<input type="text" value="<?=number_format($finds->price);?>" name="input_price" id="input_price" placeholder="" class="form-input form-control fm-number" required />
			</div>
		</div>
	</div>
</div>
<div class="row mtop10">
	<div class="col-md-12">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('han-thanh-toan');?></label>
			<div class="col-md-8">
				<?php
					$expirationdate = '';
					if(!empty($finds->expirationdate) && $finds->expirationdate != '0000-00-00'){
						$expirationdate = date(cfdate(),strtotime($finds->expirationdate));
					}
				?>
				<div class="input-group date date-picker" data-date-format="<?=cfdateHtml();?>">
					<input type="text" id="input_expirationdate" placeholder="<?=cfdateHtml();?>" name="input_expirationdate" class="form-input form-control" value="<?=$expirationdate;?>">
					<span class="input-group-btn ">
						<button class="btn default btn-picker" type="button"><i class="fa fa-calendar "></i></button>
					</span>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row mtop10">
	<div class="col-md-12">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('ghi-chu');?></label>
			<div class="col-md-8">
				<input type="text" name="input_description" id="input_description" placeholder="" class="form-input form-control" value="<?=$finds->description;?>" required />
			</div>
		</div>
	</div>
</div>
</div>
<div class="row mtop10"></div>
<script>
$(function(){
handleSelect2();
initForm();
});
function initForm(){
formatNumberKeyUp('fm-number');
ComponentsPickers.init();
}
</script>
