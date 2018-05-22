<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('don-vi-tinh');?> (<span class="red">*</span>)</label>
			<div class="col-md-8">
				<input type="text" name="input_unit_name"  id="input_unit_name" class="form-input form-control tab-event" 
				value="<?=$finds->unit_name;?>" placeholder=""
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
		initForm();
	});
	function initForm(){
		$('#input_unit_name').select();
	}
</script>
