<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('nguoi-nhan');?> (<span class="red">*</span>) </label>
			<div class="col-md-8" >
				<select name="input_useraceptid" id="input_useraceptid"  class="form-control combos-input select2me"  data-placeholder="<?=getLanguage('chon-nguoi-nhan')?>">
					<?php foreach ($userTransfer as $item) { 
						$name = $item->fullname;
						if(!empty($item->phone)){
							$name = $item->fullname .' - '. $item->phone;
						}
						$selected = '';
						if($item->id == $finds->useraceptid){
							$selected = 'selected';
						}
						else if($userid == $item->id){
							$selected = 'selected';
						}
						?>
						<option <?=$selected;?> value="<?=$item->id;?>"><?=$name;?></option>
					<?php } ?>
				</select>
			</div>
		</div>
	</div>
	<div class="col-md-12 mtop10">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('nguoi-giao');?> (<span class="red">*</span>)</label>
			<div class="col-md-8" >
				<select name="input_personid" id="input_personid" class="form-control combos-input select2me"  data-placeholder="<?=getLanguage('chon-nguoi-giao')?>">
					<option value=""></option>
					<?php 
						$total = count($userAccepts);
						foreach ($userAccepts as $item) {
						$selected = '';
						if($item->id == $finds->useraceptid){
							$selected = 'selected';
						}
						$name = $item->fullname;
						if(!empty($item->phone)){
							$name = $item->fullname .' - '. $item->phone;
						}
						?>
						<option <?=$selected;?> value="<?=$item->id;?>"><?=$name;?></option>
					<?php } ?>
				</select>
			</div>
		</div>
	</div>
	<div class="col-md-12 mtop10">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('so-tien');?> (<span class="red">*</span>)</label>
			<div class="col-md-8">
				<input type="text" name="input_money" placeholder="<?=getLanguage('so-tien');?>" id="input_money" class="form-input form-control fm-number tab-event" value="<?=$finds->money;?>" />
			</div>
		</div>
	</div>
	<div class="col-md-12 mtop10">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('ghi-chu');?></label>
			<div class="col-md-8">
				<input type="text" name="input_description" placeholder="<?=getLanguage('nhap-ghi-chu');?>" id="input_description" class="form-input form-control tab-event" value="<?=$finds->description;?>" />
			</div>
		</div>
	</div>
</div>
<script>
	$(function(){
		handleSelect2();
		init();
		formatNumber('fm-number');
		formatNumberKeyUp('fm-number');
	});
	function init(){
	}
</script>