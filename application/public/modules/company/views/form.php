<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('cong-ty');?> (<span class="red">*</span>)</label>
			<div class="col-md-8">
				<input type="text" name="input_company_name" id="input_company_name" placeholder="" class="form-input form-control"  maxlength="100" value="<?=$finds->company_name;?>" />
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('dien-thoai');?> (<span class="red">*</span>)</label>
			<div class="col-md-8">
				<input type="text" value="<?=$finds->phone;?>"  maxlength="50" name="input_phone" id="input_phone" placeholder="" class="form-input form-control"  />
			</div>
		</div>
	</div>
</div>
<div class="row mtop10">
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('fax');?></label>
			<div class="col-md-8">
				<input type="text" value="<?=$finds->fax;?>"  maxlength="50" name="input_fax" id="input_fax" placeholder="" class="form-input form-control"  />
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('email');?></label>
			<div class="col-md-8">
				<input type="text" value="<?=$finds->email;?>"  maxlength="70" name="input_email" id="input_email" placeholder="" class="form-input form-control"  />
			</div>
		</div>
	</div>
</div>
<div class="row mtop10">
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('dia-chi');?></label>
			<div class="col-md-8">
				<input type="text" value="<?=$finds->address;?>" maxlength="250" name="input_address" id="input_address" placeholder="" class="form-input form-control"  />
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('tinh-thanh-pho');?></label>
			<div class="col-md-8">
				<select id="input_provinceid" name="input_provinceid" class="combos-input form-control select2me" data-placeholder="<?=getLanguage('chon-tinh-thanh-pho')?>" >
					<?php foreach($provinces as $item){?>
						<option <?php if($item->id == $finds->provinceid){?> selected <?php }?> value="<?=$item->id;?>"><?=$item->province_name;?></option>
					<?php }?>
				</select>
			</div>
		</div>
	</div>
</div>
<div class="row mtop10">
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('quan-huyen');?></label>
			<div class="col-md-8">
				<span id="loadDistricForm">
					<select id="input_districid" name="input_districid" class="combos-input form-control select2me" data-placeholder="<?=getLanguage('chon-quan-huyen')?>">
						<option value=""></option>
						<?php foreach($districs as $item){?>
						<option <?php if($item->id == $finds->districid){?> selected <?php }?> value="<?=$item->id;?>"><?=$item->distric_name;?></option>
						<?php }?>
					</select>
				</span>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('so-phong');?></label>
			<div class="col-md-8">
				<input type="text" maxlength="5" value="<?=$finds->count_room;?>" name="input_count_room" id="input_count_room" placeholder="" class="form-input form-control" />
			</div>
		</div>
	</div>
</div>
<div class="row mtop10">
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('chi-nhanh');?></label>
			<div class="col-md-8">
				<input type="text" name="input_count_branch" value="<?=$finds->count_branch;?>" id="input_count_branch" placeholder="" class="form-input form-control" maxlength="5"  />
			</div>
		</div>
	</div>
</div>
<div class="row mtop10">
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('mst');?></label>
			<div class="col-md-8">
				<input type="text" name="input_mst" value="<?=$finds->mst;?>" id="input_mst" placeholder="" class="form-input form-control" maxlength="15"  />
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('logo');?></label>
			<div class="col-md-8">
				<div class="col-md-6" style="padding:0px !important;" >
					<ul style="margin:0px;" class="button-group">
						<li class="" onclick ="javascript:document.getElementById('imageEnable').click();"><button type="button" class="btnone"><?=getLanguage('chon-file');?></button></li>
					</ul>
					<input style='display:none;' accept="image/*" id ="imageEnable" type="file" name="userfile" class="tab-event">
				</div>
				<div class="col-md-6" >
					 <span id="show">
						<?php if(!empty($finds->logo)){?>
							<img src="<?=base_url();?>files/company/<?=$finds->logo;?>" height="50" />
						<?php }?>
					</span> 
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row mtop10"></div>
<?php
	//print_r($finds); form-input combos-input-input
?>
<script>
	$(function(){
		handleSelect2();
		initForm();
	});
	function initForm(){
		$('#input_distric_name').select();
		$('#imageEnable').change(function(evt) {
            var files = evt.target.files;
            for (var i = 0, f; f = files[i]; i++){
                var size = f.size;
                //if (size < 2048000){
                    if (!f.type.match('image.*'))
                    {
                        continue;
                    }
                    var reader = new FileReader();
                    reader.onload = (function(theFile) {
                        return function(e) { //size e = e.tatal
                            $('#show').html('<img src="' + e.target.result + '" style="width:60px; height:40px" />');
                            $("#img1").val(e.target.result);
                        };
                    })(f);
                    reader.readAsDataURL(f);
            }
        });
		$('#provinceid').change(function(){
			var provinceid = $(this).val();
			var links = controller+'getDistricForm';
			$.ajax({					
				url: links,	
				type: 'POST',
				data: {provinceid:provinceid},	
				success: function(data) {
					
				}
			});
		});
	}
</script>
