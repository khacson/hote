<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('don-hang');?> (<span class="red">*</span>)</label>
			<div class="col-md-8">
				<input type="text" name="input_ponumber"  id="input_ponumber" class="form-input form-control tab-event" 
				value="<?=$finds->ponumber;?>" placeholder=""
				/>
			</div>
		</div>
	</div>
	<div class="col-md-12 mtop10">
		<div class="form-group">
			<?php 
				$dateinput = gmdate(cfdate(), time() + 7 * 3600);;
				if(!empty($finds->dateinput) && $finds->dateinput != '0000-00-00'){
					$dateinput = date(cfdate(),strtotime($finds->dateinput));
				}
			?>
			<label class="control-label col-md-4"><?=getLanguage('ngay-nhap');?></label>
			<div id="input_dateinput" class="col-md-8 date date-picker" data-date-format="<?=cfdateHtml();?>" >
				<input type="text" id="dateinput" placeholder="<?=cfdateHtml();?>" name="dateinput" class="form-control form-input" value="<?=$dateinput;?>">
				<span class="input-group-btn ">
					<button class="btn default btn-picker" type="button"><i class="fa fa-calendar "></i></button>
				</span>
			</div>
		</div>
	</div>
	<div class="col-md-12 mtop10">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('so-luong');?></label>
			<div class="col-md-8">
				<input type="text" name="input_quantity"  id="input_quantity" class="form-input form-control tab-event" 
				value="<?=$finds->quantity;?>" placeholder=""
				/>
			</div>
		</div>
	</div>
	<div class="col-md-12 mtop10">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('nha-cung-cap');?> (<span class="red">*</span>)</label>
			<div class="col-md-8">
				<select id="input_supplierid" name="input_supplierid" class="combos-input select2me form-control" data-placeholder="<?=getLanguage('chon-nha-cung-cap')?>">
					<?php if(count($superliers)> 1){?>
						<option value=""></option>
					<?php }?>
					<?php foreach($superliers as $item){?>
						<option <?php if($item->id == $finds->supplierid){?> selected <?php }?> value="<?=$item->id;?>"><?=$item->supplier_name;?></option>
					<?php }?>
				</select>
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
		ComponentsPickers.init();
	});
	function initForm(){
		$('#input_ponumber').select();
	}
</script>
