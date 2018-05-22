<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('ten-nhom')?> (<span class="red">*</span>)</label>
			<div class="col-md-8">
				<input type="text" name="groupname" id="groupname" class="form-input form-control " maxlength="100" />
			</div>
		</div>
	</div>
	<div class="col-md-12 mtop10">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('loai-nhom')?> (<span class="red">*</span>)</label>
			<div class="col-md-8">
				<select name="input_grouptype"  class="combos-input select2me form-control" id="input_grouptype" data-placeholder="<?=getLanguage('chon-nhom-quyen')?>">
					<option value=""></option>
					<?php if(empty($login->companyid)){?>
					<option  <?php if($finds->grouptype == 1){?>  selected <?php }?> value="1"><?=getLanguage('rot');?></option>
					<option <?php if($finds->grouptype == 2){?>  selected <?php }?> value="2"><?=getLanguage('admin');?></option>
					<?php }?>
					<option <?php if($finds->grouptype == 3){?>  selected <?php }?> value="3"><?=getLanguage('quan-ly');?></option>
					<option <?php if($finds->grouptype == 4){?>  selected <?php }?> value="4"><?=getLanguage('nhan-vien');?></option>
					<option <?php if($finds->grouptype == 5){?>  selected <?php }?> value="5"><?=getLanguage('nhan-vien-ban-hang');?></option>
				</select>
			</div>
		</div>
	</div>
	<div class="col-md-12 mtop10">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('cong-ty')?></label>
			<div class="col-md-8">
				<select name="input_companyid" class="combos-input select2me form-control" id="input_companyid" data-placeholder="<?=getLanguage('chon-cong-ty')?>">
					<?php if(count($companys) > 1){?>
					<option value=""></option>
					<?php }?>
					<?php foreach($companys as $item){
						?>
					<option <?php if($finds->companyid == $item->id){?>  selected <?php }?> value="<?=$item->id;?>"><?=$item->company_name;?></option>
					<?php }?>
				</select>
			</div>
		</div>
	</div>
</div>	
<script type="text/javascript">
	$(function(){	
		handleSelect2();
		initForm();
	});
	function initForm(){
		
	}
</script>