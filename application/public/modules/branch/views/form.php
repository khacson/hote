<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('ten-khach-san');?> (<span class="red">*</span>)</label>
			<div class="col-md-8">
				<input type="text" name="input_branch_name"  id="input_branch_name" class="form-input form-control tab-event" 
				value="<?=$finds->branch_name;?>" placeholder=""
				/>
			</div>
		</div>
	</div>
	<div class="col-md-12 mtop10">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('dien-thoai');?></label>
			<div class="col-md-8">
				<input type="text" name="input_phone"  id="input_phone" class="form-input form-control tab-event" 
				value="<?=$finds->phone;?>" placeholder=""
				/>
			</div>
		</div>
	</div>
	<div class="col-md-12 mtop10">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('fax');?></label>
			<div class="col-md-8">
				<input type="text" name="input_fax"  id="input_fax" class="form-input form-control tab-event" 
				value="<?=$finds->fax;?>" placeholder=""
				/>
			</div>
		</div>
	</div>
	<div class="col-md-12 mtop10">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('email');?></label>
			<div class="col-md-8">
				<input type="text" name="input_email"  id="input_email" class="form-input form-control tab-event" 
				value="<?=$finds->email;?>" placeholder=""
				/>
			</div>
		</div>
	</div>
	<div class="col-md-12 mtop10">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('dia-chi');?></label>
			<div class="col-md-8">
				<input type="text" name="input_address"  id="input_address" class="form-input form-control tab-event" 
				value="<?=$finds->address;?>" placeholder=""
				/>
			</div>
		</div>
	</div>
	<div class="col-md-12 mtop10">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('nguoi-dai-dien');?></label>
			<div class="col-md-8">
				<input type="text" name="input_name_contact"  id="input_name_contact" class="form-input form-control tab-event" 
				value="<?=$finds->name_contact;?>" placeholder=""
				/>
			</div>
		</div>
	</div>
</div>
<script>
	$(function(){
		//handleSelect2();
		initForm();
	});
	function initForm(){
		$('#input_branch_name').select();
	}
</script>
