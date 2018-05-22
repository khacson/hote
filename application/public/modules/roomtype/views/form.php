<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('loai-phong');?> (<span class="red">*</span>)</label>
			<div class="col-md-8">
				<input type="text" name="input_roomtype_name"  id="input_roomtype_name" class="form-input form-control tab-event" 
				value="<?=$finds->roomtype_name;?>" placeholder=""
				/>
			</div>
		</div>
	</div>
	<div class="col-md-12 mtop10">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('so-giuong');?></label>
			<div class="col-md-8">
				<input type="text" name="input_count_beds"  id="input_count_beds" class="form-input form-control tab-event" 
				value="<?=$finds->count_beds;?>" placeholder=""
				/>
			</div>
		</div>
	</div>
	<div class="col-md-12 mtop10">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('so-nguoi');?></label>
			<div class="col-md-8">
				<input type="text" name="input_count_person"  id="input_count_person" class="form-input form-control tab-event" 
				value="<?=$finds->count_person;?>" placeholder=""
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
		$('#input_roomtype_name').select();
	}
</script>
