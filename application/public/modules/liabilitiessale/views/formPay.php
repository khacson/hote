<ul class="nav nav-tabs" style="margin-top:-10px;">
  <li id="menu1Click" class="active"><a data-toggle="tab" href="#menu1"><?=getLanguage('cap-nhat-cong-no');?></a></li>
  <li id="menu2Click" class="hiddensave"><a data-toggle="tab" href="#menu2"><?=getLanguage('lich-su-thanh-toan');?></a></li>
  <li style="float:right;">
	 <button type="button" style="margin-top:10px;" class="close" data-dismiss="modal">&times;</button>
  </li>
</ul>
<div class="tab-content">
	<div id="menu1"  class="tab-pane fade in active">
		<!--S Content-->
		<div class="row mtop10">
			<div class="col-md-12">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('khach-hang');?></label>
					<div class="col-md-8">
						<input type="text" value="<?=$customers->customer_name;?>" class="form-control " readonly />
					</div>
				</div>
			</div>
		</div>
		<div class="row mtop10">
			<div class="col-md-12">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('cong-no');?></label>
					<div class="col-md-8">
						<input type="text" value="<?=fmNumber($finds->price);?>" class="form-control " readonly />
					</div>
				</div>
			</div>
		</div>
		<div class="row mtop10">
			<div class="col-md-12">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('da-thanh-toan');?></label>
					<div class="col-md-8">
						<input type="text" value="<?=fmNumber($amount);?>" class="form-control " readonly />
					</div>
				</div>
			</div>
		</div>
		<div class="row mtop10">
			<div class="col-md-12">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('con-lai');?></label>
					<div class="col-md-8">
						<input type="text" value="<?=fmNumber(($finds->price) - $amount);?>" class="form-control " readonly />
					</div>
				</div>
			</div>
		</div>
		<div class="row mtop10">
			<div class="col-md-12">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('thanh-toan');?> (<span class="red">*</span>)</label>
					<div class="col-md-8">
						<input type="text" name="money" id="money" placeholder="" class="form-control fm-number" required />
					</div>
				</div>
			</div>
		</div>
		<div class="row mtop10">
			<div class="col-md-12">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('han-thanh-toan');?></label>
					<div class="col-md-8">
						<?php 
							$datecreate =  gmdate(cfdate(), time() + 7 * 3600);
							?>
						<div class="input-group date date-picker" data-date-format="<?=cfdateHtml();?>">
							<input type="text" id="input_datepo" placeholder="<?=cfdateHtml();?>" name="input_datepo" class="form-input form-control" value="<?=$datecreate;?>">
							<span class="input-group-btn ">
								<button class="btn default btn-picker" type="button"><i class="fa fa-calendar "></i></button>
							</span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row mtop10">
			<div class="col-md-12">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('hinh-thuc-thanh-toan');?></label>
					<div class="col-md-8">
						<select id="payment" name="payment" class="combos-input select2me form-control" data-placeholder="<?=getLanguage('chon-hinh-thuc-thanh-toan')?>">
							<option value="1"><?=getLanguage('tien-mat');?></option>
							<option value="2"><?=getLanguage('chuyen-khoan');?></option>
						</select>
					</div>
				</div>
			</div>
		</div>
		<div class="row mtop10" id="showBank">
			<div class="col-md-12">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('ngan-hang');?> (<span class="red">*</span>)</label>
					<div class="col-md-8">
						<select id="bankid" name="bankid" class="combos-input select2me form-control" data-placeholder="<?=getLanguage('chon-ngan-hang')?>">
							<option value=""></option>
							<?php foreach($banks as $item){?>
								<option value="<?=$item->id;?>"><?=$item->bank_name;?></option>
							<?php }?>
						</select>
					</div>
				</div>
			</div>
		</div>
		<div class="row mtop10">
			<div class="col-md-12">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('ghi-chu');?></label>
					<div class="col-md-8">
						<input type="text" name="description_detail" id="description_detail" placeholder="" class=" form-control " required />
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="menu2" class="tab-pane fade ">
		<!--S Content-->
		<div class="row mtop10">
			<div class="col-md-12">
				<table id="tbheader" width="100%" cellspacing="0" border="1" >
					<tr>							
						<th width="40px"><?=getLanguage('stt');?></th>	
						<th width="110px"><?=getLanguage('phieu-thu');?></th>		
						<th width="120px"><?=getLanguage('ngay-thanh-toan');?></th>
						<th width="100px"><?=getLanguage('thanh-toan');?></th>
						<th ><?=getLanguage('ghi-chu');?></th>
						<th width="120px"><?=getLanguage('nguoi-thanh-toan');?></th>
						<th width="50px"></th>
					</tr>
					<tbody id="showdetaillists"></tbody>
				</table>
			</div>
		</div>	
	</div>
</div>
<div class="row mtop10"></div>
<input type="hidden" name="ids" id="ids" value="<?=$finds->id;?>" />
<script>
	$(function(){
		console.log(1);
		handleSelect2();
		ComponentsPickers.init();
		initForm();
		getDetail();
	});
	function initForm(){
		$('#actionsaveRecept').show();
		$('#printRecept').show();
		formatNumberKeyUp('fm-number');
		$("#bankid").prop("disabled",true );
		$('#payment').change(function(){
			var payment = $(this).val();
			if(payment == '1'){
				$("#bankid").prop("disabled",true);
			}
			else{
				$("#bankid").prop("disabled",false);
			}
		});
		
		$('#menu1Click').click(function(){
			 $('#actionsaveRecept').show();
			 $('#printRecept').show();
		});
		$('#menu2Click').click(function(){ 
			 $('#actionsaveRecept').hide();
			 $('#printRecept').hide();
		});
		//ComponentsPickers.init();
	}
	function getDetail(){
		var id = $('#ids').val();
		$.ajax({
			url : controller + 'getDetail',
			type: 'POST',
			async: false,
			data:{id:id},  
			success:function(datas){
				var obj = $.evalJSON(datas);  
				$('#showdetaillists').html(obj.content);
				$('.itemPrintReceipt').each(function(){
					$(this).click(function(){
						var receipts_code = $(this).attr('receipts_code');
						printRecept(receipts_code);
					});
				});
			}
		});
	}
</script>
