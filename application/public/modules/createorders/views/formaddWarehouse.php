<div class="portlet-body">
	<div class="row mtop10">
		<div class="col-md-12">
			<div class="form-group" style="margin-left:-10px;">
				<label class="control-label col-md-4">Tên kho hàng (<span class="red">*</span>)</label>
				<div class="col-md-8" >
					<input type="text" name="warehouse_name" id="warehouse_name" placeholder="" class="searchs form-control sup_txt2" required />
				</div>
			</div>
		</div>
	</div>
	<div class="row mtop10">
		<div class="col-md-12">
			<div class="form-group" style="margin-left:-10px;">
				<label class="control-label col-md-4">Địa chỉ</label>
				<div class="col-md-8" >
					<input type="text" name="address" id="address" placeholder="" class="searchs form-control sup_txt2" required />
				</div>
			</div>
		</div>
	</div>
	<div class="row mtop10">
		<div class="col-md-12">
			<div class="form-group" style="margin-left:-10px;">
				<label class="control-label col-md-4">Tỉnh/thành</label>
				<div class="col-md-8" >
					<select id="_a_provinceid" name="_a_provinceid" class="combos sup_combo2" >
						<option value=""></option>
						<?php foreach($provinces as $item){?>
							<option value="<?=$item->id;?>"><?=$item->province_name;?></option>
						<?php }?>
					</select>
				</div>
			</div>
		</div>
	</div>
	<div class="row mtop10">
		<div class="col-md-12">
			<div class="form-group"  style="margin-left:-10px;">
				<label class="control-label col-md-4">Quận/huyện</label>
				<div class="col-md-8">
					<span id="loadDistric2">
						<select id="_a_districid" name="_a_districid" class="combos sup_combo2" >
							<option value=""></option>
						</select>
					</span>
				</div>
			</div>
		</div>
	</div>	
</div>
<script>
	$(function(){
		$('#_a_supplier_name').focus();
		init();
	});
	function init(){
		$('#_a_provinceid').multipleSelect({
			filter: true,
			single: true,
			placeholder: '<?=getLanguage('all','select_province')?>',
			onClick: function(view) {
				var provinceid = getCombo('_a_provinceid');
				var links = controller+'getDistrics';
				var token = $('#token').val();
				$.ajax({					
					url: links,	
					type: 'POST',
					data: {csrf_token_gce:token,provinceid:provinceid},	
					success: function(data) {
						//var obj = $.evalJSON(data);
						$("#loadDistric2").html(data);
						$("#_a_districid").multipleSelect({
							filter: true,
							placeholder:'<?=getLanguage('all','select_distric')?>',
							single: true
						});
					}
				});
			}
		});
		$('#_a_districid').multipleSelect({
			filter: true,
			placeholder:'<?=getLanguage('all','select_distric')?>',
			single: true
		});
	}
	
</script>