<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('tang-lau');?> (<span class="red">*</span>)</label>
			<div class="col-md-8">
				<input type="text" name="input_floor_name"  id="input_floor_name" class="form-input form-control tab-event" 
				value="<?=$finds->floor_name;?>" placeholder=""
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
		$('#input_floor_name').select();
	}
</script>
