<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('ma-ngan-hang');?> </label>
			<div class="col-md-8">
				<input type="text" name="input_bank_code"  id="input_bank_code" class="form-input form-control tab-event" 
				value="<?=$finds->bank_code;?>" placeholder=""
				/>
			</div>
		</div>
	</div>
	<div class="col-md-12 mtop10">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('ten-ngan-hang');?> (<span class="red">*</span>)</label>
			<div class="col-md-8">
				<input type="text" name="input_bank_name"  id="input_bank_name" class="form-input form-control tab-event" 
				value="<?=$finds->bank_name;?>" placeholder=""
				/>
			</div>
		</div>
	</div>
	<div class="col-md-12 mtop10">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('ghi-chu');?></label>
			<div class="col-md-8">
				<input type="text" name="input_description"  id="input_description" class="form-input form-control tab-event" 
				value="<?=$finds->description;?>" placeholder=""
				/>
			</div>
		</div>
	</div>
</div>
<script>
	$(function(){
		handleSelect2();
		initForm();
	});
	function initForm(){
		$('#input_bank_code').select();
	}
</script>
