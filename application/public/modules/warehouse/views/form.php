<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('ten-kho');?> (<span class="red">*</span>)</label>
			<div class="col-md-8">
				<input type="text" name="input_warehouse_name"  id="input_warehouse_name" class="form-input form-control tab-event" 
				value="<?=$finds->warehouse_name;?>" placeholder=""
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
			<label class="control-label col-md-4"><?=getLanguage('nguoi-lien-he');?></label>
			<div class="col-md-8">
				<input type="text" name="input_name_contact"  id="input_name_contact" class="form-input form-control tab-event" 
				value="<?=$finds->name_contact;?>" placeholder=""
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
			<label class="control-label col-md-4"><?=getLanguage('chi-nhanh');?> </label>
			<div class="col-md-8">
				<select id="input_branchid" name="input_branchid" class="combos-input select2me form-control" data-placeholder="<?=getLanguage('chon-chi-nhanh')?>">
					<option value=""></option>
					<?php foreach($branchs as $item){?>
						<option <?php if($item->id == $finds->branchid){ echo 'selected';}?> value="<?=$item->id;?>"><?=$item->branch_name;?></option>
					<?php }?>
				</select>
			</div>
		</div>
	</div>
	<div class="col-md-12 mtop10">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('mac-dinh');?> </label>
			<div class="col-md-8">
				<select id="input_isdedault" name="input_isdedault" class="combos-input select2me form-control" data-placeholder="">
					<option value="0"><?=getLanguage('khong');?></option>
					<option value="1"><?=getLanguage('co');?></option>
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
		$('#input_warehouse_name').select();
	}
</script>
