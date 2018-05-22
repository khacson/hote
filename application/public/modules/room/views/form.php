<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('ten-phong');?> (<span class="red">*</span>)</label>
			<div class="col-md-8">
				<input type="text" name="input_room_name"  id="input_room_name" class="form-input form-control " 
				value="<?=$finds->room_name;?>" placeholder=""
				/>
			</div>
		</div>
	</div>
	<div class="col-md-12 mtop10">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('loai-phong');?>  (<span class="red">*</span>)</label>
			<div class="col-md-8">
					<select id="input_roomtypeid" name="input_roomtypeid" class="combos-input select2me form-control" data-placeholder="<?=getLanguage('chon-loai-phong');?>">
						<?php if(count($roomTypes) > 1){?>
						<option value=""></option>
						<?php }?>
						<?php foreach($roomTypes as $item){?>
							<option <?php if($finds->roomtypeid == $item->id){?> selected <?php }?> value="<?=$item->id;?>"><?=$item->roomtype_name;?></option>
						<?php }?>
					</select>
			</div>
		</div>
	</div>
	<div class="col-md-12 mtop10">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('gia-theo-ngay');?></label>
			<div class="col-md-8">
				<input type="text" name="input_price"  id="input_price" class="form-input form-control fm-number" 
				value="<?=$finds->price;?>" placeholder=""
				/>
			</div>
		</div>
	</div>
	<div class="col-md-12 mtop10">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('gia-theo-gio');?></label>
			<div class="col-md-8">
				<input type="text" name="input_price_hour"  id="input_price_hour" class="form-input form-control fm-number" 
				value="<?=$finds->price_hour;?>" placeholder=""
				/>
			</div>
		</div>
	</div>
	<div class="col-md-12 mtop10">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('gia-them-gio');?></label>
			<div class="col-md-8">
				<input type="text" name="input_price_hour_next"  id="input_price_hour_next" class="form-input form-control fm-number" 
				value="<?=$finds->price_hour_next;?>" placeholder=""
				/>
			</div>
		</div>
	</div>
	<div class="col-md-12 mtop10">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('gia-tuan');?></label>
			<div class="col-md-8">
				<input type="text" name="input_price_week"  id="input_price_week" class="form-input form-control fm-number" 
				value="<?=$finds->price_week;?>" placeholder=""
				/>
			</div>
		</div>
	</div>
	<div class="col-md-12 mtop10">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('gia-thang');?></label>
			<div class="col-md-8">
				<input type="text" name="input_price_month"  id="input_price_month" class="form-input form-control fm-number" 
				value="<?=$finds->price_month;?>" placeholder=""
				/>
			</div>
		</div>
	</div>
	<div class="col-md-12 mtop10">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('tang-lau');?>  (<span class="red">*</span>)</label>
			<div class="col-md-8">
					<select id="input_floorid" name="input_floorid" class="combos-input select2me form-control" data-placeholder="<?=getLanguage('chon-tang-lau');?>">
						<?php if(count($floors) > 1){?>
						<option value=""></option>
						<?php }?>
						<?php foreach($floors as $item){?>
							<option <?php if($finds->floorid == $item->id){?> selected <?php }?> value="<?=$item->id;?>"><?=$item->floor_name;?></option>
						<?php }?>
					</select>
			</div>
		</div>
	</div>
	<div class="col-md-12 mtop10">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('ghi-chu');?></label>
			<div class="col-md-8">
				<input type="text" name="input_description"  id="input_description" class="form-input form-control fm-number" 
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
		formatNumberKeyUp('fm-number');
		formatNumber('fm-number');
		
	});
	function initForm(){
		$('#input_room_name').select();
	}
</script>
