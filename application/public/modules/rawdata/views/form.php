<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('nguyen-phu-lieu');?> (<span class="red">*</span>)</label>
			<div class="col-md-8">
				<input type="text" name="input_rawdata_name"  id="input_rawdata_name" class="form-input form-control tab-event" 
				value="<?=$finds->rawdata_name;?>" placeholder="<?=getLanguage('nhap-nguyen-phu-lieu');?>"
				/>
			</div>
		</div>
	</div>
	<div class="col-md-12 mtop10">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('don-vi-tinh');?> </label>
			<div class="col-md-8">
				<select id="input_unitid" name="input_unitid" class="combos-input select2me form-control" data-placeholder="<?=getLanguage('chon-nguyen-phu-lieu')?>">
					<option value=""></option>
					<?php foreach($units as $item){?>
						<option <?php if($item->id == $finds->unitid){ echo 'selected';}?> value="<?=$item->id;?>"><?=$item->unit_name;?></option>
					<?php }?>
				</select>
			</div>
		</div>
	</div>
	<div class="col-md-12 mtop10">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('ghi-chu');?></label>
			<div class="col-md-8">
				<input type="text" name="input_description"  id="input_description" class="form-input form-control tab-event" 
				value="<?=$finds->description;?>" placeholder="<?=getLanguage('nhap-ghi-chu');?>"
				/>
			</div>
		</div>
	</div>
</div>
<?php
	//print_r($finds);
?>
<script>
	$(function(){
		handleSelect2();
		initForm();
	});
	function initForm(){
		$('#input_rawdata_name').select();
	}
</script>
