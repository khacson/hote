<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('loai-hang-hoa');?> (<span class="red">*</span>)</label>
			<div class="col-md-8">
				<input type="text" name="goods_tye_names"  id="goods_tye_names" class="form-control tab-event" 
				/>
			</div>
		</div>
	</div>
	<div class="col-md-12 mtop10">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('phan-loai');?></label>
			<div class="col-md-8">
				<select id="goods_type_groups" name="goods_type_groups" class="select2me form-control" data-placeholder="<?=getLanguage('chon-phan-loai')?>">
					<option value="1"><?=getLanguage('hang-hoa');?></option>
					<option value="2"><?=getLanguage('nguyen-phu-lieu');?></option>
				</select>
			</div>
		</div>
	</div>
</div>
<script>
	$(function(){
		initForms();
	});
	function initForms(){
		$('#input_goods_tye_name').select();
		$('#goods_type_groups').select2({
			placeholder: "Select",
			allowClear: true
		});
	}
</script>
