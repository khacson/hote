<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('linh-vuc-hoat-dong');?> (<span class="red">*</span>)</label>
			<div class="col-md-8">
				<input type="text" name="input_activefields_name"  id="input_activefields_name" class="form-input form-control tab-event" 
				value="<?=$finds->activefields_name;?>"
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
		$('#input_activefields_name').select();
	}
</script>
