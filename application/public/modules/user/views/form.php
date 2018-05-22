<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('tai-khoan')?> (<span class="red">*</span>)</label>
			<div class="col-md-8">
				<input type="text" value="<?=$finds->username;?>" name="input_username" id="input_username" class="form-input form-control" maxlength="50" />
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('ho-ten')?> (<span class="red">*</span>)</label>
			<div class="col-md-8">
				<input type="text" value="<?=$finds->fullname;?>" name="input_fullname" id="input_fullname" class="form-input form-control "maxlength="70" />
			</div>
		</div>
	</div>
</div>
<div class="row mtop10">
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('ma-khau')?> (<span class="red">*</span>)</label>
			<div class="col-md-8">
				<input type="password"  name="input_password" id="input_password" class="form-input  form-control" maxlength="50"/>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('xn-mat-khau')?> (<span class="red">*</span>)</label>
			<div class="col-md-8">
				<input type="password" name="input_cfpassword" id="input_cfpassword" class="form-input  form-control" maxlength="50"/>
			</div>
		</div>
	</div>
</div>
<div class="row mtop10">
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('email')?></label>
			<div class="col-md-8">
				<input type="text" value="<?=$finds->email;?>" name="input_email" id="input_email" class="form-input form-control" maxlength="70"/>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('dien-thoai')?></label>
			<div class="col-md-8">
				<input type="text" value="<?=$finds->mobile;?>" name="input_mobile" id="input_mobile" class="form-input form-control" maxlength="50"/>
			</div>
		</div>
	</div>
</div>
<div class="row mtop10">
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('nhom-quyen')?> (<span class="red">*</span>)</label>
			<div class="col-md-8" >
				<select name="_inputgroupid" id="input_groupid" class="combos-input select2me form-control" data-placeholder="<?=getLanguage('chon-nhom-quyen');?>">
					<option value=""></option>
					<?php foreach ($groups as $item) { ?>
						<option  <?php if($finds->groupid == $item->id){?>  selected <?php }?> value="<?=$item->id;?>"><?=$item->groupname?></option>
					<?php } ?>
				</select>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('chi-nhanh')?></label>
			<div class="col-md-8" >
				<select name="input_branchid" id="input_branchid" class="combos-input select2me form-control" data-placeholder="<?=getLanguage('chon-chi-nhanh');?>">
					<option value=""></option>
					<?php foreach ($branchs as $item) { ?>
						<option  <?php if($finds->branchid == $item->id){?>  selected <?php }?> value="<?=$item->id;?>"><?=$item->branch_name;?></option>
					<?php } ?>
				</select>
			</div>
		</div>
	</div>
</div>
<div class="row mtop10">
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('phong-ban')?></label>
			<div class="col-md-8">
				<select id="input_departmentid" name="input_departmentid" class="form-input select2me form-control " data-placeholder="<?=getLanguage('chon-phong-ban')?>">
					<option value=""></option>
					<?php foreach($departments as $item){?>
					<option <?php if($finds->departmentid == $item->id){?>  selected <?php }?> value="<?=$item->id;?>"><?=$item->departmanet_name;?></option>
					<?php }?>
				</select>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('trang-thai');?> (<span class="red">*</span>)</label>
			<div class="col-md-8" >
				<select name="input_activate" id="input_activate" class="form-input select2me form-control " data-placeholder="<?=getLanguage('chon-trang-thai')?>">
					<option <?php if($finds->activate == 1){?>  selected <?php }?> value="1"><?=getLanguage('kich-hoat');?></option>
					<option <?php if($finds->activate == 0){?>  selected <?php }?> value="0"><?=getLanguage('vo-hieu');?></option>
				</select>
			</div>
		</div>
	</div>
</div>
<div class="row mtop10">
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('hinh-dai-dien')?></label>
			<div class="col-md-8">
				<div class="col-md-6" style="padding:0px !important;" >
					<ul style="margin:0px;" class="button-group">
						<li class="" onclick ="javascript:document.getElementById('imageEnable').click();"><button type="button" class="btnone"><?=getLanguage('chon-file')?></button></li>
					</ul>
					<input class="tab-event" style='display:none;' accept="image/*" id ="imageEnable" type="file" name="userfile">
				</div>
				<div class="col-md-6" >
					 <span id="show">
						<img height="50" src="<?=base_url();?>files/user/<?=$finds->image;?>" >
					 </span> 
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('chu-ky')?></label>
			<div class="col-md-8">
				<div class="col-md-6" style="padding:0px !important;" >
					<ul style="margin:0px;" class="button-group">
						<li class="" onclick ="javascript:document.getElementById('imageEnable2').click();"><button type="button" class="btnone"><?=getLanguage('chon-file')?></button></li>
					</ul>
					<input class="tab-event"  style='display:none;' accept="image/*" id ="imageEnable2" type="file" name="userfiles">
				</div>
				<div class="col-md-6" >
					 <span id="shows">
						  <img height="50" src="<?=base_url();?>files/user/<?=$finds->signature;?>" >
					 </span> 
				</div>
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
		$('#imageEnable').change(function(evt) {
            var files = evt.target.files;
            for (var i = 0, f; f = files[i]; i++){
                var size = f.size;
                if (size < 2048000){
                    if (!f.type.match('image.*')){
                        continue;
                    }
                    var reader = new FileReader();
                    reader.onload = (function(theFile) {
                        return function(e) { //size e = e.tatal
                            $('#show').html('<img src="'+e.target.result+'" style="width:80px; height:50px" />');
                            //$("#img1").val(e.target.result);
                        };
                    })(f);
                    reader.readAsDataURL(f);
                }
                else{
                    error('Dung lượng tối đa 2MB');
                }
            }
        });
		$('#imageEnable2').change(function(evt) {
            var files = evt.target.files;
            for (var i = 0, f; f = files[i]; i++){
                var size = f.size;
                if (size < 2048000){
                    if (!f.type.match('image.*')){
                        continue;
                    }
                    var reader = new FileReader();
                    reader.onload = (function(theFile) {
                        return function(e) { //size e = e.tatal
                            $('#shows').html('<img src="'+e.target.result+'" style="width:80px; height:50px" />');
                        };
                    })(f);
                    reader.readAsDataURL(f);
                }
                else{
					error('Dung lượng tối đa 2MB');
                }
            }
        });
	}
</script>