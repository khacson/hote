<div class="portlet-body">
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<label class="control-label col-md-4">Mã khách hàng (<span class="red">*</span>)</label>
				<div class="col-md-8">
					<input type="text" name="_a_customer_code" id="_a_customer_code" placeholder="" class="searchs form-control sup_txt"  required />
				</div>
			</div>
		</div>
	</div>
	<div class="row mtop10">
		<div class="col-md-12">
			<div class="form-group">
				<label class="control-label col-md-4">Tên khách hàng (<span class="red">*</span>)</label>
				<div class="col-md-8">
					<input type="text" name="_a_customer_name" id="_a_customer_name" placeholder="" class="searchs form-control sup_txt"  required />
				</div>
			</div>
		</div>
	</div>
	<div class="row mtop10">
		<div class="col-md-12">
			<div class="form-group">
				<label class="control-label col-md-4">Điện thoại</label>
				<div class="col-md-8">
					<input type="text" name="a_phone" id="_a_phone" placeholder="" class="searchs form-control sup_txt" required />
				</div>
			</div>
		</div>
	</div><!--E Row-->
	<div class="row mtop10">
		<div class="col-md-12">
			<div class="form-group">
					<label class="control-label col-md-4">Fax</label>
					<div class="col-md-8">
						<input type="text" name="_a_fax" id="_a_fax" placeholder="" class="searchs form-control sup_txt" required />
					</div>
				</div>
		</div>
	</div><!--E Row-->
	<div class="row mtop10">
		<div class="col-md-12">
			  <div class="form-group">
					<label class="control-label col-md-4">Email</label>
					<div class="col-md-8">
						<input type="text" name="_a_email" id="_a_email" placeholder="" class="searchs form-control sup_txt" required />
					</div>
				</div>
		</div>
	</div><!--E Row-->	
	<div class="row mtop10">
		<div class="col-md-12">
			<div class="form-group">
					<label class="control-label col-md-4">Địa chỉ</label>
					<div class="col-md-8">
						<input type="text" name="_a_address" id="_a_address" placeholder="" class="searchs form-control sup_txt" required />
					</div>
				</div>
		</div>
	</div><!--E Row-->	
	<div class="row mtop10">
		<div class="col-md-12">
			<div class="form-group">
					<label class="control-label col-md-4">Tỉnh/thành</label>
					<div class="col-md-8">
						<select id="provinceid" name="provinceid" class="combos sup_combo" >
							<option value=""></option>
							<?php foreach($provinces as $item){?>
								<option value="<?=$item->id;?>"><?=$item->province_name;?></option>
							<?php }?>
						</select>
					</div>
				</div>
		</div>
	</div><!--E Row-->	
	<div class="row mtop10">
		<div class="col-md-12">
			 <div class="form-group">
					<label class="control-label col-md-4">Quận/huyện</label>
					<div class="col-md-8">
						<span id="loadDistric">
							<select id="districid" name="districid" class="combos sup_combo" >
								<option value=""></option>
							</select>
						</span>
					</div>
				</div>
		</div>
	</div><!--E Row-->		
</div>
<script>
	$(function(){
		$('#_a_supplier_name').focus();
		init();
	});
	function init(){
		$('#provinceid').multipleSelect({
			filter: true,
			single: true,
			placeholder: '<?=getLanguage('all','select_province')?>',
			onClick: function(view) {
				var provinceid = getCombo('provinceid');
				var links = controller+'getDistric';
				var token = $('#token').val();
				$.ajax({					
					url: links,	
					type: 'POST',
					data: {csrf_token_gce:token,provinceid:provinceid},	
					success: function(data) {
						//var obj = $.evalJSON(data);
						$("#districid").html(data);
						$("#districid").multipleSelect({
							filter: true,
							placeholder:'<?=getLanguage('all','select_distric')?>',
							single: true
						});
					}
				});
			}
		});
		$('#districid').multipleSelect({
			filter: true,
			placeholder:'<?=getLanguage('all','select_distric')?>',
			single: true
		});
	}
</script>