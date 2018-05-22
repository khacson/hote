<style title="" type="text/css">
	table col.c1 { width: 50px; }
	table col.c2 { width: 50px; }
	table col.c3 { width: 150px;}
	table col.c4 { width: 200px;}
	table col.c5 { width: auto;}
	.control-label.col-md-5{ white-space: nowrap;}
	fieldset {
		border: 1px dashed #fff;
		margin: 0;
		min-width: 0;
		padding: 0;
		border-radius: 2px;
		border: 1px dotted #999 !important;
		margin: 0 2px !important;
		padding: 0.35em 0.625em 0.75em !important;
	}
	legend{
		font-size:18px !important; margin-bottom:0px !important; width: auto; border-bottom: 0px;
	}
</style>

<!-- BEGIN PORTLET-->
<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption caption2">
			<i class="fa fa-cogs" style="margin-top:2px;" aria-hidden="true"></i>
			Cấu hình
		</div>
		<div class="tools">
			<a href="javascript:;" class="collapse">
			</a>
		</div>
	</div>
	<div class="portlet-body" style="padding-left:20px; padding-right:20px;">
		<!--<div class="row mtop10">
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-5">Mã đơn hàng mua</label>
					<div class="col-md-7">
						<select id="cfso" name = "cfso" class="combos tab-event">
							<option value=""></option>
							<option value="0">Tự động phát sinh</option>
							<option value="1">Nhân viên nhập</option>
						</select>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-5">Mã đơn hàng bán</label>
					<div class="col-md-7">
						<select id="cfse" name = "cfse" class="combos tab-event">
							<option value=""></option>
							<option value="0">Tự động phát sinh</option>
							<option value="1">Nhân viên nhập</option>
						</select>
					</div>
				</div>
			</div>
		</div>-->
		<div class="row mtop10">
			<fieldset class="fieldset">
				<legend class="legend ">Phiếu nhập kho</legend>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label col-md-5">Ký tự bắt đầu</label>
							<div class="col-md-7">
								<input type="text" name="cfpn" id="cfpn" placeholder="" class="searchs form-control tab-event" />
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label col-md-5">Định dạng</label>
							<div class="col-md-7">
								<select id="cfpn_type" name = "cfpn_type" class="combos tab-event">
									<option value=""></option>
									<option value="0">Tăng theo năm tháng</option>
									<option value="1">Tăng theo số thứ tự</option>
								</select>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label col-md-5">Giá trị khởi tạo</label>
							<div class="col-md-7">
								<input type="text" maxlength="6" name="cfpn_default" id="cfpn_default" placeholder="" class="searchs form-control tab-event" />
							</div>
						</div>
					</div>
			</fieldset>
		</div>
		<div class="row mtop10">
			<fieldset class="fieldset">
				<legend class="legend">Phiếu xuất kho</legend>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label col-md-5">Ký tự bắt đầu</label>
							<div class="col-md-7">
								<input type="text" name="cfpx" id="cfpx" placeholder="" class="searchs form-control tab-event" />
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label col-md-5">Định dạng</label>
							<div class="col-md-7">
								<select id="cfpx_type" name = "cfpx_type" class="combos tab-event">
									<option value=""></option>
									<option value="0">Tăng theo năm tháng</option>
									<option value="1">Tăng theo số thứ tự</option>
								</select>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label col-md-5">Giá trị khởi tạo</label>
							<div class="col-md-7">
								<input type="text" maxlength="6" name="cfpx_default" id="cfpx_default" placeholder="" class="searchs form-control tab-event" />
							</div>
						</div>
					</div>
			</fieldset>
		</div>
		<div class="row mtop10" style="display:none;">
			<fieldset class="fieldset">
				<legend class="legend">Tạo đơn bán hàng</legend>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label col-md-5">Ký tự bắt đầu</label>
							<div class="col-md-7">
								<input type="text" name="cfdh" id="cfdh" placeholder="" class="searchs form-control tab-event" />
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label col-md-5">Định dạng</label>
							<div class="col-md-7">
								<select id="cfdh_type" name = "cfdh_type" class="combos tab-event">
									<option value=""></option>
									<option value="0">Tăng theo năm tháng</option>
									<option value="1">Tăng theo số thứ tự</option>
								</select>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label col-md-5">Giá trị khởi tạo</label>
							<div class="col-md-7">
								<input type="text" maxlength="6" name="cfdh_default" id="cfdh_default" placeholder="" class="searchs form-control tab-event" />
							</div>
						</div>
					</div>
			</fieldset>
		</div>
		<div class="row mtop10">
			<fieldset class="fieldset">
				<legend class="legend">Phiếu thu</legend>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label col-md-5">Ký tự bắt đầu</label>
							<div class="col-md-7">
								<input type="text" name="cfpt" id="cfpt" placeholder="" class="searchs form-control tab-event" />
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label col-md-5">Định dạng</label>
							<div class="col-md-7">
								<select id="cfpt_type" name = "cfpt_type" class="combos tab-event">
									<option value=""></option>
									<option value="0">Tăng theo năm tháng</option>
									<option value="1">Tăng theo số thứ tự</option>
								</select>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label col-md-5">Giá trị khởi tạo</label>
							<div class="col-md-7">
								<input type="text" maxlength="6" name="cfpt_default" id="cfpt_default" placeholder="" class="searchs form-control tab-event" />
							</div>
						</div>
					</div>
					
			</fieldset>
		</div>
		<div class="row mtop10">
			<fieldset class="fieldset">
				<legend class="legend">Phiếu chi</legend>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label col-md-5">Ký tự bắt đầu</label>
							<div class="col-md-7">
								<input type="text" name="cfpc" id="cfpc" placeholder="" class="searchs form-control tab-event" />
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label col-md-5">Định dạng</label>
							<div class="col-md-7">
								<select id="cfpc_type" name = "cfpc_type" class="combos tab-event">
									<option value=""></option>
									<option value="0">Tăng theo năm tháng</option>
									<option value="1">Tăng theo số thứ tự</option>
								</select>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label col-md-5">Giá trị khởi tạo</label>
							<div class="col-md-7">
								<input type="text" maxlength="6" name="cfpc_default" id="cfpc_default" placeholder="" class="searchs form-control tab-event" />
							</div>
						</div>
					</div>
			</fieldset>
		</div>
		<div class="row mtop10" style="display:none;">
			<fieldset class="fieldset">
				<legend class="legend">Công nợ & Thanh toán</legend>
				<div class="col-md-4">
					<div class="form-group">
						<label class="control-label col-md-5">Tự động trừ CN</label>
						<div class="col-md-7">
							<select id="iscn" name = "iscn" class="combos tab-event">
								<option value=""></option>
								<option value="0">Không trừ</option>
								<option value="1">Có trừ</option>
							</select>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="control-label col-md-5">Thanh toán thu</label>
						<div class="col-md-7">
							<select id="isreceipt" name = "isreceipt" class="combos tab-event">
								<option value=""></option>
								<option value="0">Nhân viên thanh toán</option>
								<option value="1">Tự động thanh toán</option>
							</select>
						</div>
					</div>
				</div>
				<div class="col-md-4">
						<div class="form-group">
							<label class="control-label col-md-5">Thanh toán chi</label>
							<div class="col-md-7">
								<select id="ispay" name = "ispay" class="combos tab-event">
									<option value=""></option>
									<option value="0">Nhân viên thanh toán</option>
									<option value="1">Tự động thanh toán</option>
								</select>
							</div>
						</div>
					</div>
			</fieldset>	
		</div>		
		<div class="row mtop10">
			<fieldset class="fieldset">
				<legend class="legend">Cấu hình khác</legend>
				<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-5">Định dạnh ngày</label>
					<div class="col-md-7">
						<select id="cfdate" name = "cfdate" class="combos tab-event">
							<option value=""></option>
							<option value="d-m-Y">dd-mm-YYYY (01-09-2016)</option>
							<option value="d/m/Y">dd/mm/YYYY (01/09/2016)</option>
							<option value="d M Y">dd MM YYYY (01 Sep 2016)</option>
							<option value="m-d-Y">mm-dd-YYYY (09-01-2016)</option>
							<option value="m/d/Y">mm/dd/YYYY (09/01/2016)</option>
						</select>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-5">Làm tròn số</label>
					<div class="col-md-7">
						<select id="cfnumber"  name = "cfnumber"  class="combos tab-event">
							<option value=""></option>
							<option value="0">Làm tròn</option>
							<option value="1">Làm tròn 1 chữ số</option>
							<option value="2">Làm tròn 2 chữ số</option>
							<option value="3">Làm tròn 3 chữ số</option>
							<option value="4">Làm tròn 4 chữ số</option>
						</select>
					</div>
				</div>
			</div>
			<div class="col-md-4" style="display:none;">
				<div class="form-group">
					<label class="control-label col-md-5">Có hạn bảo hành</label>
					<div class="col-md-7">
						<select id="isguarantee" name = "isguarantee" class="combos tab-event">
							<option value=""></option>
							<option value="0">Không sử dụng</option>
							<option value="1">Có sử dụng</option>
						</select>
					</div>
				</div>
			</div>
			<div class="col-md-4 mtop10" style="display:none;">
				<div class="form-group">
					<label class="control-label col-md-5">Sử dụng serial</label>
					<div class="col-md-7">
						<select id="isserial" name = "isserial" class="combos tab-event">
							<option value=""></option>
							<option value="0">Không sử dụng</option>
							<option value="1">Có sử dụng</option>
						</select>
					</div>
				</div>
			</div>
			<div class="col-md-4 mtop10" style="display:none;">
				<div class="form-group">
					<label class="control-label col-md-5">Xuất CK sản phẩm</label>
					<div class="col-md-7">
						<select id="cksp" name = "cksp" class="combos tab-event">
							<option value=""></option>
							<option value="0">Không sử dụng</option>
							<option value="1">Có sử dụng</option>
						</select>
					</div>
				</div>
			</div>
			<div class="col-md-4 mtop10">
				<div class="form-group">
					<label class="control-label col-md-5">Tiền tệ</label>
					<div class="col-md-7">
						<select id="currency" name = "currency" class="combos tab-event">
							<option value=""></option>
							<option value="VNĐ">VNĐ</option>
							<option value="USD">USD</option>
						</select>
					</div>
				</div>
			</div>
			</fieldset>	
		</div>			
		<div class="row mtop10">
			<div class="col-md-8"></div>
			<div class="col-md-4">
				<input type="hidden" name="id" id="id" />
				<input type="hidden" id="token" name="<?=$csrfName;?>" value="<?=$csrfHash;?>" />
				<ul class="button-group pull-right" style="padding-right:15px;">
					<?php if(isset($permission['edit'])){?>
					<li id="edit">
						<button class="button">
							<i class="fa fa-save"></i>
							<?=getLanguage('all','edit')?>
						</button>
					</li>
					<?php } ?>
				</ul>
			</div>
		</div>
	</div>
</div>

<div class="loading" style="display: none;">
	<div class="blockUI blockOverlay" style="width: 100%;height: 100%;top:0px;left:0px;position: absolute;background-color: rgb(0,0,0);opacity: 0.1;z-index: 1000;">
	</div>
	<div class="blockUI blockMsg blockElement" style="width: 30%;position: absolute;top: 15%;left:35%;text-align: center;">
		<img src="<?=url_tmpl()?>img/ajax_loader.gif" style="z-index: 2;position: absolute;"/>
	</div>
</div> 
<script>
	var controller = '<?=base_url().$routes;?>/';
	var csrfHash = '<?=$csrfHash;?>';
	var cpage = 0;
	var search;
	$(function(){
		init();
		$('#search').click(function(){
			$(".loading").show();
			searchList();	
		});
		$('#refresh').click(function(){
			$('.loading').show();
			refresh();
		});
		$('#edit').click(function(){
			var id = $("#id").val();
			save('edit',id);
		});
	});
	function save(func,id){
		search = getSearch();
		var obj = $.evalJSON(search); 
		var token = $('#token').val();
		$.ajax({
			url : controller + func,
			type: 'POST',
			async: false,
			data: {csrf_stock_name:token,search:search , id:id},
			success:function(datas){
				var obj = $.evalJSON(datas); 
				$("#token").val(obj.csrfHash);
				if(obj.status == 0){
					error('<?=getLanguage('all','edit_failed')?>'); return false;	
				}
				else if(obj.status == -1){
					error('<?=getLanguage('religion','description')?> <?=getLanguage('all','exist')?>'); return false;		
				}
				else{
					success('<?=getLanguage('all','edit_success')?>'); return false;
				}
			},
			error : function(){
				error('<?=getLanguage('all','edit_failed')?>'); return false;	
			}
		});
	}
	function init(){
		$('#cfdate').multipleSelect({
			filter: true,
			single: true,
			placeholder: 'Chọn định dạng'
		});
		$('#cfnumber').multipleSelect({
			filter: true,
			single: true,
			placeholder: 'Chọn làm tròn số'
		});
		$('#cfso').multipleSelect({
			filter: true,
			single: true,
			placeholder: 'Chọn mã đơn hàng'
		});
		$('#cfse').multipleSelect({
			filter: true,
			single: true,
			placeholder: 'Chọn mã đơn hàng'
		});
		$('#isguarantee').multipleSelect({
			filter: true,
			single: true,
			placeholder: 'Chọn trạng thái'
		});
		$('#isserial').multipleSelect({
			filter: true,
			single: true,
			placeholder: 'Chọn trạng thái'
		});
		$('#cksp').multipleSelect({
			filter: true,
			single: true,
			placeholder: 'Chọn trạng thái'
		});
		$('#isreceipt').multipleSelect({
			filter: true,
			single: true,
			placeholder: 'Chọn trạng thái'
		});
		$('#ispay').multipleSelect({
			filter: true,
			single: true,
			placeholder: 'Chọn trạng thái'
		});
		$('#iscn').multipleSelect({
			filter: true,
			single: true,
			placeholder: 'Chọn trạng thái'
		});
		$('#cfpn_type').multipleSelect({
			filter: true,
			single: true,
			placeholder: 'Chọn định dạng'
		});
		$('#cfpx_type').multipleSelect({
			filter: true,
			single: true,
			placeholder: 'Chọn định dạng'
		});
		$('#cfdh_type').multipleSelect({
			filter: true,
			single: true,
			placeholder: 'Chọn định dạng'
		});
		$('#cfpc_type').multipleSelect({
			filter: true,
			single: true,
			placeholder: 'Chọn định dạng'
		});
		$('#cfpt_type').multipleSelect({
			filter: true,
			single: true,
			placeholder: 'Chọn định dạng'
		});
		$('#currency').multipleSelect({
			filter: true,
			single: true,
			placeholder: 'Chọn tiền tệ'
		});
		setData();
	}
	function setData(){
		$('#cfpn').val('<?=$find->cfpn;?>');
		$('#cfpn_type').multipleSelect('setSelects',['<?=$find->cfpn_type;?>']);
		$('#cfpn_default').val('<?=$find->cfpn_default;?>');
		
		$('#cfpx').val('<?=$find->cfpx;?>');
		$('#cfpx_type').multipleSelect('setSelects',['<?=$find->cfpx_type;?>']);
		$('#cfpx_default').val('<?=$find->cfpx_default;?>');
		
		$('#cfdh').val('<?=$find->cfdh;?>');
		$('#cfdh_type').multipleSelect('setSelects',['<?=$find->cfdh_type;?>']);
		$('#cfdh_default').val('<?=$find->cfdh_default;?>');
		
		$('#cfpt').val('<?=$find->cfpt;?>');
		$('#cfpt_type').multipleSelect('setSelects',['<?=$find->cfpt_type;?>']);
		$('#cfpt_default').val('<?=$find->cfpt_default;?>');
		
		$('#cfpc').val('<?=$find->cfpc;?>');
		$('#cfpc_type').multipleSelect('setSelects',['<?=$find->cfpc_type;?>']);
		$('#cfpc_default').val('<?=$find->cfpc_default;?>');
		
		
		$('#cfdate').multipleSelect('setSelects',['<?=$find->cfdate;?>']);
		$('#cfnumber').multipleSelect('setSelects',['<?=$find->cfnumber;?>']);
		$('#ispay').multipleSelect('setSelects',['<?=$find->ispay;?>']);
		$('#isreceipt').multipleSelect('setSelects',['<?=$find->isreceipt;?>']);
		$('#iscn').multipleSelect('setSelects',['<?=$find->iscn;?>']);
		$('#isserial').multipleSelect('setSelects',['<?=$find->isserial;?>']);
		$('#isguarantee').multipleSelect('setSelects',['<?=$find->isguarantee;?>']);
		$('#cksp').multipleSelect('setSelects',['<?=$find->cksp;?>']);
		$('#currency').multipleSelect('setSelects',['<?=$find->currency;?>']);
	}
	function refresh(){
		$('.loading').show();
		$('.searchs').val('');		
		csrfHash = $('#token').val();
		//$('select.combos').multipleSelect('uncheckAll');
		search = getSearch();
		getList(cpage,csrfHash);	
	}
</script>
<script src="<?=url_tmpl();?>assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
