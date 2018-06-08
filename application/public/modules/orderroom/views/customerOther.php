<fieldset><!--Khach hang 2-->
	<legend class="f16"  style="color:#0090d9;"><?=getLanguage('khach-hang');?> 1</legend>
		 <!--E Row-->
		  <div class="row mtop10">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4 nowrap"><?=getLanguage('ten-khach-hang');?></label>
					<div class="col-md-8">
						<input type="text" name="input_customer_name1" id="input_customer_name1" maxlength="50" class="form-input-c1 form-control " />
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('cmnd');?> </label>
					<div class="col-md-8">
						<input type="text" name="input_customer_cmnd1" id="input_customer_cmnd1" maxlength="12" class="form-input-c1 form-control " />
					</div>
				</div>
			</div>
		 </div>
		 <!--E Row-->
		 <div class="row mtop10">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('ngay-cap');?></label>
					<div class="col-md-8 date date-picker form-input">
						<input type="text" id="input_identity_date1" placeholder="<?=cfdateHtml();?>" name="input_identity_date1" class="form-control form-input-c1" >
						<span class="input-group-btn ">
							<button class="btn default btn-picker" type="button"><i class="fa fa-calendar "></i></button>
						</span>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('noi-cap');?></label>
					<div class="col-md-8">
						<input type="text" name="input_identity_from1" id="input_identity_from1" maxlength="100" class="form-input-c1 form-control " />
					</div>
				</div>
			</div>
		 </div>
		 <!--E Row-->
		 <div class="row mtop10">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('dien-thoai');?></label>
					<div class="col-md-8">
						<input type="text" name="input_customer_phone1" id="input_customer_phone1" maxlength="12" class="form-input-c1 form-control " />
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('dia-chi');?></label>
					<div class="col-md-8">
						<input type="text" name="input_customer_address1" id="input_customer_address1" maxlength="100" class="form-input-c1 form-control " />
					</div>
				</div>
			</div>
		 </div>
		 <!--E Row-->
		<div class="row mtop10">
			<!--S Camera-->
			<div id="QR-Code" class="container" style="width:100%">
					<div class="panel panel-primary">
						<div class="panel-heading" style="display: inline-block;width: 100%;">
							<h4 style="width:50%;float:left;">Chụp hình</h4>
							<div style="width:50%;float:right;margin-top: 5px;margin-bottom: 5px;text-align: right;">
							<!--<select id="cameraId" class="form-control" style="display: inline-block;width: auto;"></select>-->
							<button id="savec1" data-toggle="tooltip" title="Image shoot" type="button" class="btn btn-info btn-sm disabled"><span class="glyphicon glyphicon-picture"></span></button>
							<button id="savec11" data-toggle="tooltip" title="Image shoot" type="button" class="btn btn-info btn-sm disabled"><span class="glyphicon glyphicon-picture"></span></button>
						</div>
					</div>
					<div class="panel-body">
						<div class="col-md-4" style="text-align: center;">
							<div class="well" style="position: relative;display: inline-block;">
								<canvas class="qr-canvas-c1"  width="210" height="150"></canvas>
								<div class="scanner-laser laser-rightBottom" style="opacity: 0.5;"></div>
								<div class="scanner-laser laser-rightTop" style="opacity: 0.5;"></div>
								<div class="scanner-laser laser-leftBottom" style="opacity: 0.5;"></div>
								<div class="scanner-laser laser-leftTop" style="opacity: 0.5;"></div>
							</div>
						   
						</div>
						<div class="col-md-4" style="text-align: center;">
							<div class="well" style="position: relative;display: inline-block;">
								<img id="scanned-img-c1" src=""  width="210" height="150">
							</div>
							<!--<div class="caption">
								<p id="scanned-QR"></p>
							</div>-->
						</div>
						 <div class="col-md-4" style="text-align: center;">
							<div class="well" style="position: relative;display: inline-block;">
								<img id="scanned-img-c11" src="" width="210" height="150">
							</div>
							<!--<div class="caption">
								<p id="scanned-QR"></p>
							</div>-->
						</div>
					</div>
					<div class="panel-footer">
					</div>
				</div>
			</div>
		<!--E Camera-->
		</div> 
</fieldset>
<fieldset class="mtop10"><!--Khach hang 3-->
	<legend class="f16" style="color:#0090d9;"><?=getLanguage('khach-hang');?> 2</legend>
		 <!--E Row-->
		  <div class="row mtop10">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4 nowrap"><?=getLanguage('ten-khach-hang');?></label>
					<div class="col-md-8">
						<input type="text" name="input_customer_name2" id="input_customer_name2" maxlength="50" class="form-input-c2 form-control " />
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('cmnd');?> </label>
					<div class="col-md-8">
						<input type="text" name="input_customer_cmnd2" id="input_customer_cmnd2" maxlength="13" class="form-input-c2 form-control " />
					</div>
				</div>
			</div>
		 </div>
		 <!--E Row-->
		 <div class="row mtop10">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('ngay-cap');?></label>
					<div class="col-md-8 date date-picker form-input">
						<input type="text" id="input_identity_date2" placeholder="<?=cfdateHtml();?>" name="input_identity_date2" class="form-control form-input-c2" >
						<span class="input-group-btn ">
							<button class="btn default btn-picker" type="button"><i class="fa fa-calendar "></i></button>
						</span>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('noi-cap');?></label>
					<div class="col-md-8">
						<input type="text" name="input_identity_from2" id="input_identity_from2" maxlength="100" class="form-input-c2 form-control " />
					</div>
				</div>
			</div>
		 </div>
		 <!--E Row-->
		 <div class="row mtop10">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('dien-thoai');?></label>
					<div class="col-md-8">
						<input type="text" name="input_customer_phone2" id="input_customer_phone2" maxlength="13" class="form-input-c2 form-control " />
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('dia-chi');?></label>
					<div class="col-md-8">
						<input type="text" name="input_customer_address2" id="input_customer_address2" maxlength="100" class="form-input-c2 form-control " />
					</div>
				</div>
			</div>
		 </div>
		 <!--E Row-->
</fieldset>
<fieldset class="mtop10"><!--Khach hang 2-->
	<legend class="f16"  style="color:#0090d9;"><?=getLanguage('khach-hang');?> 3</legend>
		 <!--E Row-->
		  <div class="row mtop10">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4 nowrap"><?=getLanguage('ten-khach-hang');?></label>
					<div class="col-md-8">
						<input type="text" name="input_customer_name3" id="input_customer_name3" maxlength="50" class="form-input-c3 form-control " />
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('cmnd');?> </label>
					<div class="col-md-8">
						<input type="text" name="input_customer_cmnd3" id="input_customer_cmnd3" maxlength="14" class="form-input-c3 form-control " />
					</div>
				</div>
			</div>
		 </div>
		 <!--E Row-->
		 <div class="row mtop10">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('ngay-cap');?></label>
					<div class="col-md-8 date date-picker form-input">
						<input type="text" id="input_identity_date3" placeholder="<?=cfdateHtml();?>" name="input_identity_date3" class="form-control form-input-c3" >
						<span class="input-group-btn ">
							<button class="btn default btn-picker" type="button"><i class="fa fa-calendar "></i></button>
						</span>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('noi-cap');?></label>
					<div class="col-md-8">
						<input type="text" name="input_identity_from3" id="input_identity_from3" maxlength="100" class="form-input-c3 form-control " />
					</div>
				</div>
			</div>
		 </div>
		 <!--E Row-->
		 <div class="row mtop10">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('dien-thoai');?></label>
					<div class="col-md-8">
						<input type="text" name="input_customer_phone3" id="input_customer_phone3" maxlength="14" class="form-input-c3 form-control " />
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('dia-chi');?></label>
					<div class="col-md-8">
						<input type="text" name="input_customer_address3" id="input_customer_address3" maxlength="100" class="form-input-c3 form-control " />
					</div>
				</div>
			</div>
		 </div>
		 <!--E Row-->
</fieldset>

<script>
	autocompleteCustomerOther();
	function autocompleteCustomerOther(){
		//1
		$('#input_customer_name1').autocomplete({ 
			source: function( request, response ){
				$('#addicon_iconsearch').html('<i id="farefresh" class="fa fa-refresh farefresh" aria-hidden="true"></i>');
				$.ajax({
					url: '<?=base_url();?>orderroom/autocompleteSearchName',
					dataType: "json",
					data: {
						name: request.term
					},
					success: function( data ) {
						//$('#addicon_iconsearch').html('');
						response( data.length === 1 && data[ 0 ].length === 0 ? [] : data );
					}
				});
			},
			minLength: 1,
			select: function( event, ui ) {
				event.preventDefault();
				$('#input_customer_name1').val(ui.item.label);
				$('#input_customer_cmnd1').val(ui.item.identity);
				$('#input_customer_phone1').val(ui.item.phone);
				if(ui.item.identity_date != '' && ui.item.identity_date != null){
					$('#input_identity_date1').val(ui.item.identity_date);
				}
				$('#input_identity_from1').val(ui.item.identity_from);
				$('#input_customer_address1').val(ui.item.address);
				$('#input_customer_comppany1').val(ui.item.company_name);
				$('#input_customer_mst1').val(ui.item.company_mst);
			},
			create: function(){
				$(this).data('ui-autocomplete')._renderItem  = function (ul, item) {
				  var imei = '';
				  if(item.imei != ''){
					  imei = 'IMEI: '+item.imei;
				  }
				  ul.addClass('ccustomClass'); 
				  return $("<li>")
					//.addClass("w600")
					.attr("data-value", item.stt)
					.append("<div class='ccstt'>"+item.stt+"</div><div class='customer_name'><b>"+item.customer_name+"</b></div><div class='identity'><b>"+item.identity+"</b></div><div class='phone'>"+item.phone+"</div>")
					.appendTo(ul);
				};
			},
			response: function(event, ui){
				
			}
		});
		//1 CMND
		$('#input_customer_cmnd1').autocomplete({ 
			source: function( request, response ){
				$('#addicon_iconsearch').html('<i id="farefresh" class="fa fa-refresh farefresh" aria-hidden="true"></i>');
				$.ajax({
					url: '<?=base_url();?>orderroom/autocompleteSearchCMND',
					dataType: "json",
					data: {
						cmnd: request.term
					},
					success: function( data ) {
						$('#addicon_iconsearch').html('');
						response( data.length === 1 && data[ 0 ].length === 0 ? [] : data );
					}
				});
			},
			minLength: 1,
			select: function( event, ui ) {
				event.preventDefault();
				$('#input_customer_name1').val(ui.item.label);
				$('#input_customer_cmnd1').val(ui.item.identity);
				$('#input_customer_phone1').val(ui.item.phone);
				if(ui.item.identity_date != '' && ui.item.identity_date != null){
					$('#input_identity_date1').val(ui.item.identity_date);
				}
				$('#input_identity_from1').val(ui.item.identity_from);
				$('#input_customer_address1').val(ui.item.address); 
			},
			create: function(){
				$(this).data('ui-autocomplete')._renderItem  = function (ul, item) {
				  var imei = '';
				  if(item.imei != ''){
					  imei = 'IMEI: '+item.imei;
				  }
				  ul.addClass('ccustomClass'); 
				  return $("<li>")
						.attr("data-value", item.stt)
						.append("<div class='ccstt'>"+item.stt+"</div><div class='customer_name'><b>"+item.customer_name+"</b></div><div class='identity'><b>"+item.identity+"</b></div><div class='phone'>"+item.phone+"</div>")
						.appendTo(ul);
				};
			},
			response: function(event, ui){
				
			}
		});
		//2
		$('#input_customer_name2').autocomplete({ 
			source: function( request, response ){
				$('#addicon_iconsearch').html('<i id="farefresh" class="fa fa-refresh farefresh" aria-hidden="true"></i>');
				$.ajax({
					url: '<?=base_url();?>orderroom/autocompleteSearchName',
					dataType: "json",
					data: {
						name: request.term
					},
					success: function( data ) {
						//$('#addicon_iconsearch').html('');
						response( data.length === 1 && data[ 0 ].length === 0 ? [] : data );
					}
				});
			},
			minLength: 1,
			select: function( event, ui ) {
				event.preventDefault();
				$('#input_customer_name2').val(ui.item.label);
				$('#input_customer_cmnd2').val(ui.item.identity);
				$('#input_customer_phone2').val(ui.item.phone);
				if(ui.item.identity_date != '' && ui.item.identity_date != null){
					$('#input_identity_date2').val(ui.item.identity_date);
				}
				$('#input_identity_from2').val(ui.item.identity_from);
				$('#input_customer_address2').val(ui.item.address);
				$('#input_customer_comppany2').val(ui.item.company_name);
				$('#input_customer_mst2').val(ui.item.company_mst);
			},
			create: function(){
				$(this).data('ui-autocomplete')._renderItem  = function (ul, item) {
				  var imei = '';
				  if(item.imei != ''){
					  imei = 'IMEI: '+item.imei;
				  }
				  ul.addClass('ccustomClass'); 
				  return $("<li>")
					//.addClass("w600")
					.attr("data-value", item.stt)
					.append("<div class='ccstt'>"+item.stt+"</div><div class='customer_name'><b>"+item.customer_name+"</b></div><div class='identity'><b>"+item.identity+"</b></div><div class='phone'>"+item.phone+"</div>")
					.appendTo(ul);
				};
			},
			response: function(event, ui){
				
			}
		});
		//1 CMND
		$('#input_customer_cmnd2').autocomplete({ 
			source: function( request, response ){
				$('#addicon_iconsearch').html('<i id="farefresh" class="fa fa-refresh farefresh" aria-hidden="true"></i>');
				$.ajax({
					url: '<?=base_url();?>orderroom/autocompleteSearchCMND',
					dataType: "json",
					data: {
						cmnd: request.term
					},
					success: function( data ) {
						$('#addicon_iconsearch').html('');
						response( data.length === 1 && data[ 0 ].length === 0 ? [] : data );
					}
				});
			},
			minLength: 1,
			select: function( event, ui ) {
				event.preventDefault();
				$('#input_customer_name2').val(ui.item.label);
				$('#input_customer_cmnd2').val(ui.item.identity);
				$('#input_customer_phone2').val(ui.item.phone);
				if(ui.item.identity_date != '' && ui.item.identity_date != null){
					$('#input_identity_date2').val(ui.item.identity_date);
				}
				$('#input_identity_from2').val(ui.item.identity_from);
				$('#input_customer_address2').val(ui.item.address); 
			},
			create: function(){
				$(this).data('ui-autocomplete')._renderItem  = function (ul, item) {
				  var imei = '';
				  if(item.imei != ''){
					  imei = 'IMEI: '+item.imei;
				  }
				  ul.addClass('ccustomClass'); 
				  return $("<li>")
						.attr("data-value", item.stt)
						.append("<div class='ccstt'>"+item.stt+"</div><div class='customer_name'><b>"+item.customer_name+"</b></div><div class='identity'><b>"+item.identity+"</b></div><div class='phone'>"+item.phone+"</div>")
						.appendTo(ul);
				};
			},
			response: function(event, ui){
				
			}
		});
		//3
		$('#input_customer_name3').autocomplete({ 
			source: function( request, response ){
				$('#addicon_iconsearch').html('<i id="farefresh" class="fa fa-refresh farefresh" aria-hidden="true"></i>');
				$.ajax({
					url: '<?=base_url();?>orderroom/autocompleteSearchName',
					dataType: "json",
					data: {
						name: request.term
					},
					success: function( data ) {
						//$('#addicon_iconsearch').html('');
						response( data.length === 1 && data[ 0 ].length === 0 ? [] : data );
					}
				});
			},
			minLength: 1,
			select: function( event, ui ) {
				event.preventDefault();
				$('#input_customer_name3').val(ui.item.label);
				$('#input_customer_cmnd3').val(ui.item.identity);
				$('#input_customer_phone3').val(ui.item.phone);
				if(ui.item.identity_date != '' && ui.item.identity_date != null){
					$('#input_identity_date3').val(ui.item.identity_date);
				}
				$('#input_identity_from3').val(ui.item.identity_from);
				$('#input_customer_address3').val(ui.item.address);
				$('#input_customer_comppany3').val(ui.item.company_name);
				$('#input_customer_mst3').val(ui.item.company_mst);
			},
			create: function(){
				$(this).data('ui-autocomplete')._renderItem  = function (ul, item) {
				  var imei = '';
				  if(item.imei != ''){
					  imei = 'IMEI: '+item.imei;
				  }
				  ul.addClass('ccustomClass'); 
				  return $("<li>")
					//.addClass("w600")
					.attr("data-value", item.stt)
					.append("<div class='ccstt'>"+item.stt+"</div><div class='customer_name'><b>"+item.customer_name+"</b></div><div class='identity'><b>"+item.identity+"</b></div><div class='phone'>"+item.phone+"</div>")
					.appendTo(ul);
				};
			},
			response: function(event, ui){
				
			}
		});
		//1 CMND
		$('#input_customer_cmnd3').autocomplete({ 
			source: function( request, response ){
				$('#addicon_iconsearch').html('<i id="farefresh" class="fa fa-refresh farefresh" aria-hidden="true"></i>');
				$.ajax({
					url: '<?=base_url();?>orderroom/autocompleteSearchCMND',
					dataType: "json",
					data: {
						cmnd: request.term
					},
					success: function( data ) {
						$('#addicon_iconsearch').html('');
						response( data.length === 1 && data[ 0 ].length === 0 ? [] : data );
					}
				});
			},
			minLength: 1,
			select: function( event, ui ) {
				event.preventDefault();
				$('#input_customer_name3').val(ui.item.label);
				$('#input_customer_cmnd3').val(ui.item.identity);
				$('#input_customer_phone3').val(ui.item.phone);
				if(ui.item.identity_date != '' && ui.item.identity_date != null){
					$('#input_identity_date3').val(ui.item.identity_date);
				}
				$('#input_identity_from3').val(ui.item.identity_from);
				$('#input_customer_address3').val(ui.item.address); 
			},
			create: function(){
				$(this).data('ui-autocomplete')._renderItem  = function (ul, item) {
				  var imei = '';
				  if(item.imei != ''){
					  imei = 'IMEI: '+item.imei;
				  }
				  ul.addClass('ccustomClass'); 
				  return $("<li>")
						.attr("data-value", item.stt)
						.append("<div class='ccstt'>"+item.stt+"</div><div class='customer_name'><b>"+item.customer_name+"</b></div><div class='identity'><b>"+item.identity+"</b></div><div class='phone'>"+item.phone+"</div>")
						.appendTo(ul);
				};
			},
			response: function(event, ui){
				
			}
		});
	}
</script>

