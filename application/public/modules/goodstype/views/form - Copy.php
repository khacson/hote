<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('loai-hang-hoa');?> (<span class="red">*</span>)</label>
			<div class="col-md-8">
				<input type="text" name="input_goods_tye_name"  id="input_goods_tye_name" class="form-input form-control tab-event" 
				value="<?=$finds->goods_tye_name;?>" placeholder=""
				/>
			</div>
		</div>
	</div>
	<div class="col-md-12 mtop10">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('phan-loai');?></label>
			<div class="col-md-8">
				<select id="input_goods_type_group" name="input_goods_type_group" class="combos-input select2me form-control" data-placeholder="<?=getLanguage('chon-phan-loai')?>">
					<option <?php if(1 == $finds->goods_type_group){ echo 'selected';}?> value="1"><?=getLanguage('hang-hoa');?></option>
					<option <?php if(2 == $finds->goods_type_group){ echo 'selected';}?> value="2"><?=getLanguage('nguyen-phu-lieu');?></option>
				</select>
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
		$('#input_goods_tye_name').select();
	}
</script>
