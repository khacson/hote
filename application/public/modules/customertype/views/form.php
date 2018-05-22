<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('phan-loai-khach-hang');?> (<span class="red">*</span>)</label>
			<div class="col-md-8">
				<input type="text" name="input_customertype_name"  id="input_customertype_name" class="form-input form-control tab-event" 
				value="<?=$finds->customertype_name;?>"
				/>
			</div>
		</div>
	</div>
</div>
<div class="row mtop10">
	<div class="col-md-12">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('vi-tri');?></label>
			<div class="col-md-8">
				<input type="text" name="input_ordering"  id="input_ordering" class="form-input form-control tab-event" 
				value="<?=$finds->ordering;?>" 
				/>
			</div>
		</div>
	</div>
</div>
<script>
	$(function(){
		initForm();
	});
	function initForm(){
		$('#input_customertype_name').select();
	}
</script>
