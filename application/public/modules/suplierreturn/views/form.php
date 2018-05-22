<style title="" type="text/css">
	.col-md-4{ white-space: nowrap !important;}
	.col-md-3{ white-space: nowrap !important;}
</style>
<!-- BEGIN PORTLET-->
<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption mtop8">
			<b><i class="fa fa-pencil-square-o" style="margin-top:4px; font-size:15px;" aria-hidden="true"></i>
			Xuất bán hàng</b>
		</div>
		<div class="tools">
			<ul class="button-group pull-right mbottom10">
				<li id="refresh" >
					<button class="button">
						<i class="fa fa-refresh"></i>
						<?=getLanguage('all','refresh')?>
					</button>
				</li>
				<?php if(isset($permission['add'])){?>
				<li id="save">
					<button class="button save-input">
						<i class="fa fa-save"></i>
						Lưu
					</button>
				</li>
				<?php } ?>
				<li id="print">
					<button class="button">
						<i class="fa fa-print"></i>
						Lưu và in
					</button>
				</li>
				<li id="viewPrint">
					<button class="button">
						<i class="fa fa-print"></i>
						<input type="hidden" id="unit" value="<?php if(isset($findsPO->uniqueid)){ echo $findsPO->uniqueid;}?>" />
						Phiếu xuất
					</button>
				</li>
				<li id="viewPrintHDBH">
					<button class="button">
						<i class="fa fa-print"></i>
						<input type="hidden" id="unit" value="<?=$findsPO->uniqueid;?>" />
						HĐBL
					</button>
				</li>
				<li id="viewPrintHDBH3">
					<button class="button">
						<i class="fa fa-print"></i>
						<input type="hidden" id="unit" value="<?=$findsPO->uniqueid;?>" />
						HĐ VAT
					</button>
				</li>
				<li>
					<a href= "<?=$controller;?>">
						<button class="button">
							<i class="fa fa-chevron-circle-left"></i>
							Trở lại
						</button>
					</a>
				</li>
			</ul>
		</div>
	</div>
	<div class="portlet-body">
		<div class="row mtop20">
			  <div class="col-md-7" style="width:65%; padding-left:10px; padding-right:10px;">
					<div class="row">
							<div class="col-md-4">
								<label>
									<input value="0" type="radio" checked name="isorder" />
									Bán hàng trực tiếp
								</label>
							</div>
							<div class="col-md-8">
								&nbsp;&nbsp;<label>
									<input value="1" type="radio" <?php if(count($datasPO) > 0){?> checked <?php }?> name="isorder" />
									Bán hàng theo đơn hàng
								</label>
							</div>
					</div>
					<span id="isorderTT">
						<div class="row mtop20">
							<div class="row">
								<div class="form-group">
									<label  class="control-label col-md-3" style="padding-left:30px;">Chọn hàng hóa(<span class="red">*</span>)</label>
									<div class="col-md-7" style="padding-left:0; margin-left:-3px;">
										<input type="text" name="goodsid" id="goodsid" placeholder="" class="search form-control" />
									</div>
									<div style="margin-top:-63px;" class="col-md-2" id="viewImg" >
										<div style ="width:80px; height:90px; border: 1px solid #ddd;">
											<div style="margin-top:35px; margin-left:10px;">Hình ảnh</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</span>
					<span id="isorderDH">
						<div class="row mtop20">
							<div class="row">
								<div class="form-group">
									<label  class="control-label col-md-3" style="padding-left:30px;">Chọn đơn hàng(<span class="red">*</span>)</label>
									<div class="col-md-9" style="padding-left:0; margin-left:-3px;">
										 <input type="text" name="isorders" id="isorders" placeholder="" class="search form-control" />
									</div>
								</div>
							</div>
						</div>
					</span>
					<div class="row">
						<table class="inputgoods">
							<thead>
								<tr class="thd">
									<td width="40">STT</td>
									<td >Hàng hóa</td>
									<td width="60">ĐVT</td>
									<td width="70">Số lương</td>
									<td width="100">Đơn giá</td>
									<td width="100">Thành tiền</td>
									<td width="40"></td>
								</tr>
							</thead>
							<tbody class="gridView">
								<?php 
								if(count($datasPO) > 0){
								$i=1; foreach($datasPO as $item){?>
								<tr class="tgrid">
									<td class="stt" width="40" class="text-center"><?=$i;?></td>
									<td align="left">
										<b><?=$item->goods_code;?></b> <br> <?=$item->goods_name;?>
										<input  goodid="<?=$item->goodsid;?>" class="goodscode" type="hidden" value="<?=$item->goods_code;?>" />
									</td>
									<td width="60"><?=$item->unit_name;?></td>
									<td width="70"><input goodid="<?=$item->goodsid;?>" uniqueid="<?=$item->uniqueid;?>" type="text" name="quantity" id="quantity" placeholder="" class="search form-control quantity text-right fm-number" value="<?=$item->quantity;?>" /></td>
									
									<td width="100"><input goodid="<?=$item->goodsid;?>" type="text" name="priceone" id="priceone" placeholder="" class="search form-control priceone text-right fm-number" value="<?=$item->sale_price;?>" /></td>
									
									<td width="100"><input goodid="<?=$item->goodsid;?>" type="text" id="price" placeholder="" class="search form-control price buyprice text-right fm-number" value="<?=$item->price;?>" /></td>
									
									<td width="40">
										<a class="deleteItem" id="<?=$item->id;?>" href="#">
											<i class="fa fa-times"></i>
										</a>
									</td>
								</tr>
								<?php $i++;}}?>
								<tr >
									<td colspan="5" style="text-align:right;">Tổng tiền:</td>
									<td class="ttprice" style="text-align:right; padding-right:10px !important;"></td>
									<td>vnđ</td>
								</tr>
							</tbody>
						</table>
					</div>
			  </div>
			  <div class="col-md-4" style="margin-left:1%; width:33%; border-left:1px dashed #c3cfd7;  margin-bottom:10px; padding-left:5px;">
					<div class="row">
						 <div class="col-md-11 bdb mleft12 tcler">
							<i class="fa fa-question-circle-o" aria-hidden="true"></i>
							Thông tin hóa đơn
						 </div>
					</div>
					<div class="row mtop10">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4">Mã đơn hàng <?php if(!empty($setuppo)){?>(<span class="red">*</span>) <?php }?></label>
								<div class="col-md-8 pright5">
									<?php 
										$readonly = '';
										if(empty($setuppo)){
											$readonly = 'readonly';
										}
										else{
											if(!empty($poid)){
												$readonly = 'readonly';
											}
										}
									?>
									<input type="text" value="<?php if(isset($findsPO->poid)){ echo $findsPO->poid;}?>" name="poid" id="poid" <?=$readonly;?> class="form-control searchs"  />
								</div>
							</div>
						</div>
					</div>
					<div class="row mtop10">
						<div class="col-md-12">
							<div class="col-md-6">
								<label>
									<input value="0" id="customer_type_0" type="radio" checked name="customer_type" />
									Khách hàng lẻ
								</label>
							</div>
							<div class="col-md-6">
								&nbsp;&nbsp;<label>
									<input value="1" id="customer_type_1" type="radio" <?php if(count($datasPO) > 0){?> checked <?php }?> name="customer_type" />
									Khách đại lý
								</label>
							</div>
						</div>
					</div>
					<span id="khle">
					<div class="row mtop10">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4">Tên KH(<span class="red">*</span>)</label>
								<div class="col-md-8 pright5">
									<input type="text" name="customer_name" id="customer_name" placeholder="" value="<?php if(isset($findsPO->customer_name)){ echo $findsPO->customer_name;}?>" class="searchs form-control" />
								</div>
							</div>
						</div>
					</div>
					<div class="row mtop10">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4">Điện thoại</label>
								<div class="col-md-8 pright5">
									<input type="text" name="customer_phone" id="customer_phone" placeholder="" value="<?php if(isset($findsPO->customer_phone)){ echo $findsPO->customer_phone;}?>" class="searchs form-control" />
								</div>
							</div>
						</div>
					</div>
					<div class="row mtop10">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4">Địa chỉ</label>
								<div class="col-md-8 pright5">
									<input type="text" name="customer_address" id="customer_address" placeholder="" value="<?php if(isset($findsPO->customer_address)){ echo $findsPO->customer_address;}?>" class="searchs form-control" />
								</div>
							</div>
						</div>
					</div>
					<div class="row mtop10">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4">Email</label>
								<div class="col-md-8 pright5">
									<input type="text" name="customer_email" id="customer_email" placeholder="" value="<?php if(isset($findsPO->customer_email)){ echo $findsPO->customer_email;}?>" class="searchs form-control" />
								</div>
							</div>
						</div>
					</div>
					</span>
					<span id="khdl">
					<div class="row mtop10">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4">Khách hàng(<span class="red">*</span>)</label>
								<div class="col-md-7">
									<span id="loadCustomer">
										<select id="customerid" name="customerid" class="combos" >
											<option value=""></option>
											<?php foreach($customers as $item){?>
												<option <?php if($findsPO->customer_id == $item->id){?> selected <?php }?> value="<?=$item->id;?>"><?=$item->customer_name;?></option>
											<?php }?>
										</select>
									</span>
								</div>
								<div class="col-md-1" style="margin-left:-20px;">
									<a title="Thêm nhà cung cấp" class="btn btn-sm btns" id="addSuppliers" data-toggle="modal" data-target="#myFrom" href="#">
										<i class="fa fa-plus" aria-hidden="true"></i>
									</a>
								</div>
							</div>
						</div>
					</div><!--E Row-->
					</span>
					<!--<div class="row mtop10">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4">NV Bán hàng (<span class="red">*</span>)</label>
								<div class="col-md-8 pright5">
									<select id="employeeid" name="employeeid" class="combos" >
										<option value=""></option>
										<?php 
											if(isset($findsPO->employeeid)){
												$employeeid = $findsPO->employeeid;
											}
											else{
												$employeeid = '';
											}
											foreach($employeesale as $item){?>
											<option <?php if($employeeid == $item->id){?> selected <?php }?>
											value="<?=$item->id;?>"><?=$item->employee_code;?> - <?=$item->employee_name;?></option>
										<?php }?>
									</select>
								</div>
							</div>
						</div>
					</div>-->
					<div class="row mtop10">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4">Ngày nhập</label>
								 <div class="col-md-8 input-group date date-picker" data-date-format="<?=cfdateHtml();?>">
									<?php 
									if(!empty($findsPO->datecreate) && $findsPO->datecreate != '0000-00-00'){
										 $datecreate = date(cfdate(),strtotime($findsPO->datecreate));
									}
									else{
										$datecreate =  gmdate(cfdate(), time() + 7 * 3600);
									}
									?>
									<input value="<?=$datecreate;?>" type="text" id="datecreate" placeholder="<?=cfdateHtml();?>" name="datecreate" class="form-control searchs" >
									<span class="input-group-btn ">
										<button class="btn default btn-picker" type="button"><i class="fa fa-calendar "></i></button>
									</span>
								</div>
							</div>
						</div>
					</div><!--E Row-->
					<div class="row mtop10">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4">Ngày giao</label>
								 <div class="col-md-8 input-group date date-picker" data-date-format="<?=cfdateHtml();?>">
									<?php 
									if(!empty($findsPO->deliverydate) && $findsPO->deliverydate != '0000-00-00'){
										 $deliverydate = date(cfdate(),strtotime($findsPO->deliverydate));
									}
									else{
										$deliverydate =  gmdate(cfdate(), time() + 7 * 3600);
									}
									?>
									<input value="<?=$deliverydate;?>" type="text" id="deliverydate" placeholder="<?=cfdateHtml();?>" name="deliverydate" class="form-control searchs" >
									<span class="input-group-btn ">
										<button class="btn default btn-picker" type="button"><i class="fa fa-calendar "></i></button>
									</span>
								</div>
							</div>
						</div>
					</div><!--E Row-->
					<div class="row mtop10">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4">Địa điểm giao</label>
								<div class="col-md-8 pright5">
									<input type="text" name="place_of_delivery" id="place_of_delivery" placeholder="Địa điểm giao hàng" value="<?php if(isset($findsPO->place_of_delivery)){ echo $findsPO->place_of_delivery;}?>" class="searchs form-control" />
								</div>
							</div>
						</div>
					</div>
					<!--<div class="row mtop10">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4">Người nhập</label>
								<div class="col-md-8 pright5">
									<input type="text" name="usercreate" id="usercreate" placeholder="" value="<?=$users;?>" class="searchs form-control" />
								</div>
							</div>
						</div>
					</div><!--E Row-->
					<div class="row mtop10">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4">Ghi chú</label>
								<div class="col-md-8 pright5">
									<textarea placeholder="Ghi chú" class="searchs textarea" name="description" id="description"><?php if(isset($findsPO->description)){ echo $findsPO->description; }?></textarea>
								</div>
							</div>
						</div>
					</div><!--E Row-->
					
					<div class="row mtop10">
						 <div class="col-md-11 bdb mleft12 tcler">
							<i class="fa fa-question-circle-o" aria-hidden="true"></i>
							Thông tin xuất kho
						 </div>
					</div>
					<div class="row mtop10">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4">Kho xuất</label>
								<div class="col-md-8 pright5">
									<span id="loadWarehouse">
										<select id="warehouseid" name="warehouseid" class="combos" >
											<option value=""></option>
											<?php foreach($warehouses as $item){?>
												<option 
												<?php if($findsPO->warehouseid == $item->id){?> selected <?php }?>
												value="<?=$item->id;?>"><?=$item->warehouse_name;?></option>
											<?php }?>
										</select>
									</span>
								</div>
							</div>
						</div>
					</div><!--E Row-->
					<div class="row mtop10">
						 <div class="col-md-11 bdb mleft12 tcler">
							<i class="fa fa-usd" aria-hidden="true"></i>
								Thông tin thanh toán
						 </div>
					</div>
					<div class="row mtop10">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4">Thanh toán</label>
								<div class="col-md-8 pright5">
									<div class="col-md-4 pleft0">
										<label class="control-label">
										<input checked type="radio" id="payments_1" name="payments" value="1"  />
										Tiền mặt</label>
									</div>
									<div class="col-md-4">
										<label class="control-label">
										<input type="radio"  id="payments_2" name="payments" value="2"  />
										CK</label>
									</div>
									<div class="col-md-4">
										<label class="control-label">
										<input type="radio"  id="payments_3" name="payments" value="3"  />
										Thẻ</label>
									</div>
								</div>
							</div>
						</div>
					</div><!--E Row-->
					<div class="row mtop10">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4">VAT(%)</label>
								<div class="col-md-8 pright5">
									<input maxlength="3" type="text" name="vat" id="vat" placeholder="" class="searchs form-control text-right fm-number" />
								</div>
							</div>
						</div>
					</div><!--E Row-->
					<div class="row mtop10">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4">Thành tiền</label>
								<div class="col-md-8 pright5">
									<input type="text" name="input_total" id="input_total" readonly placeholder="" class="searchs form-control text-right fm-number" />
								</div>
							</div>
						</div>
					</div><!--E Row-->
					<div class="row mtop10">
						<div class="col-md-12">
							<div class="form-group">
								<div class="col-md-4">
									<label class="control-label">Trả trước</label>
									<!--<input type="checkbox" name="full_paid" id="full_paid" title="Trả đủ" checked="checked" />-->
								</div>
								<div class="col-md-8 pright5">
									<input  maxlength="12" type="text" name="price_prepay" id="price_prepay" placeholder="" class="searchs form-control text-right fm-number" />
								</div>
							</div>
						</div>
					</div><!--E Row-->
					<div class="row mtop10 mbottom10">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4">Còn nợ</label>
								<div class="col-md-8 pright5">
									<input type="text" name="price_indebtedness" id="price_indebtedness" readonly placeholder="" class="searchs form-control text-right fm-number" />
								</div>
							</div>
						</div>
					</div><!--E Row-->
				</div>
		</div>
	</div>
	<div class="portlet-title">
		<div class="caption mtop8"></div>
		<div class="tools">
			<ul class="button-group pull-right mbottom10">
				<li id="refresh" >
					<button class="button">
						<i class="fa fa-refresh"></i>
						<?=getLanguage('all','refresh')?>
					</button>
				</li>
				<?php if(isset($permission['add'])){?>
				<li id="save2">
					<button class="button save-input">
						<i class="fa fa-save"></i>
						Lưu
					</button>
				</li>
				<?php } ?>
				<li id="print2">
					<button class="button">
						<i class="fa fa-print"></i>
						Lưu và in
					</button>
				</li>
				<li id="viewPrint2">
					<button class="button">
						<i class="fa fa-print"></i>
						Phiếu xuất
					</button>
				</li>
				<li id="viewPrintHDBH2">
					<button class="button">
						<i class="fa fa-print"></i>
						<input type="hidden" id="unit" value="<?=$findsPO->uniqueid;?>" />
						Hóa đơn bán lẻ
					</button>
				</li>
				<li id="viewPrintHDBH3s">
					<button class="button">
						<i class="fa fa-print"></i>
						<input type="hidden" id="unit" value="<?=$findsPO->uniqueid;?>" />
						Hóa đơn VAT
					</button>
				</li>
				<li>
					<a href= "<?=$controller;?>">
						<button class="button">
							<i class="fa fa-chevron-circle-left"></i>
							Trở lại
						</button>
					</a>
				</li>
			</ul>
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
<!--S My form-->
 <!-- Modal -->
<div class="modal fade" id="myFrom" role="dialog">
	<div class="modal-dialog">
	  <!-- Modal content-->
	  <div class="modal-content">
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
		  <h4 class="modal-title"><i class="fa fa-plus" aria-hidden="true"></i> Thêm mới khách hàng</h4>
		</div>
		<div class="modal-body">
			<!--Content-->
		</div>
		<div class="modal-footer">
		  <button type="button" id="addSups" class="btn btn-default">Lưu</button>
		</div>
	  </div>
	  
	</div>
</div>
<!--E My form-->
<!-- view Img -->
<div id="viewImg-form" style="display:none;">
	<div class="">
		<div id="viewImg-form-gridview" ></div>
	</div>
</div>
<!-- view Img -->
<!--E My form-->
<style type="text/css">
	.inputgoods{
		width:98%;	
		margin-left:15px;
		margin-top:15px;
	}
	.thd{
		text-align:center;
	}
</style>
<script type="text/javascript" src="<?=url_tmpl();?>fancybox/source/jquery.fancybox.pack.js"></script>  
<link href="<?=url_tmpl();?>fancybox/source/jquery.fancybox.css" rel="stylesheet" />
<script>
	var controller = '<?=base_url().$routes;?>/';
	var csrfHash = '<?=$csrfHash;?>';
	var goodsList = '';
	var orderList = JSON.parse('<?=json_encode($odersList);?>');;
	var inputList = {};
	var cpage = 0;
	var search;
	$(function(){
		init();
		refresh();
		
		formatNumberKeyUp('fm-number');
		formatNumber('fm-number');
		calInputTotal();
		callTotalPrice();
		deleteItem();
		callPrice('quantity');
		callPrice('priceone');
		stt();
		var isorder = 0;
		var type = 1;
		<?php if(count($datasPO) > 0){?>
		isorder = 1; 
		type = parseFloat('<?=$findsPO->customer_type;?>');
		<?php }else{?>
		//isorder = 0; 
		<?php }?>
		isorderType(isorder);
		$("input[name='isorder']" ).click(function(){
			isorder = $(this).val();
			isorderType(isorder);
			$('.gridView').html('');
			setDefault();
		});
		customerType(type);
		$("input[name='customer_type']" ).click(function(){
			type = $(this).val();
			customerType(type);
		});
		$('#refresh').click(function(){
			$('.loading').show();
			refresh();
		});
		$('#vat').keyup(function(e){
			 callTotalPrice();
		});
		//S Them nha cung cap
		$('#addSuppliers').click(function(){
			$.ajax({
				url : controller + 'addCustomer',
				type: 'POST',
				async: false,
				data: {id:''},
				success:function(datas){
					var obj = $.evalJSON(datas); 
					$('.modal-body').html(obj.content);
					
				}
			});
		});
		$('#addSups').click(function(){
			var _a_supplier_name = $('#_a_supplier_name').val();
			if(_a_supplier_name == ''){
				error('Tên khách hàng.'); return false;
			}
			 var sups = getAddSupplier();
			 $.ajax({
				url : controller + 'saveCustomer',
				type: 'POST',
				async: false,
				data: {search:sups},
				success:function(datas){
					var obj = $.evalJSON(datas);
					if(obj.status == -1){
						error('Khách hàng đã tồn tại.'); return false;
					}
					else{
						$('#loadCustomer').html(obj.customer);
						$('#customerid').multipleSelect({
							filter: true,
							placeholder:'Chọn khách hàng',
							single: true
						});
						$('.close').click();
					}
				},
				error : function(){
					error('Thêm khách hàng không thành công.'); return false;
				}
			});
		});
		$('#print').click(function(){
			var id = getCheckedId();//$('#id').val();
			print(id);
		});
		$('#addGoodsList').click(function(){ 
			return false;
		});
		$('#save').click(function(){
			save('save','');
		});
		$('#save2').click(function(){
			save('save',0);
		});
		$('#print').click(function(){
			save('save','print');
		});
		$('#print2').click(function(){
			save('save','print');
		});
		$('#viewPrint').click(function(){
			var unit = $('#unit').val();
			printSave(0,unit);
		});
		$('#viewPrint2').click(function(){
			var unit = $('#unit').val();
			printSave(0,unit);
		});
		$("input[name='isorder']" ).click(function(){
			var type = $(this).val();
			inputList = {};
			isorderType(type);
		});
		$('#viewPrintHDBH2,#viewPrintHDBH').click(function(){
			viewPrintHDBH();
		});
		$('#viewPrintHDBH3,#viewPrintHDBH3s').click(function(){
			viewPrintHDBHVAT();
		});
		clickViewImg();
	});
	function stt(){
		$('.stt').each(function(idx){
			 $(this).html(idx+1);
		});
	}
	function isorderType(type){
		if(type == 0){
			$("#isorderTT").show();
			$("#isorderDH").hide();
		}
		else{
			$("#isorderTT").hide();
			$("#isorderDH").show();
		}
	}
	function customerType(type){
		if(type == 0){
			$("#khle").show();
			$("#khdl").hide();
			$("#customer_type_0").prop( "checked", true );
			$("#customer_type_1").prop( "checked", false );
		}
		else{
			$("#khle").hide();
			$("#khdl").show();
			$("#customer_type_1").prop( "checked", true );
			$("#customer_type_0").prop( "checked", false );
		}
	}
	function getAddSupplier(){
		var str = '';
		$('input.sup_txt').each(function(){
			str += ',"'+ $(this).attr('id') +'":"'+ $(this).val().trim() +'"';
		});
		$('select.sup_combo').each(function(){
			str += ',"'+ $(this).attr('id') +'":"'+ getCombo($(this).attr('id')) +'"';
		});
		return '{'+ str.substr(1) +'}';
	}	
	function getAddWarehouse(){
		var str = '';
		$('input.sup_txt2').each(function(){
			str += ',"'+ $(this).attr('id') +'":"'+ $(this).val().trim() +'"';
		});
		$('select.sup_combo2').each(function(){
			str += ',"'+ $(this).attr('id') +'":"'+ getCombo($(this).attr('id')) +'"';
		});
		return '{'+ str.substr(1) +'}';
	}
	function save(func,id){ 
		search = getSearch();
		var obj = $.evalJSON(search);
		//S So luong
		var quantity = '';
		$('.quantity').each(function(e){
			var goodid = $(this).attr('goodid');
			var val = $(this).val();
			quantity+= ',"'+goodid+'":"'+val+'"';
		});
		if(quantity != ''){
			quantity =  "{"+quantity.substring(1)+"}";
		}
		
		if(quantity == ''){
			error('Hàng hóa <?=getLanguage('all','empty')?>'); return false;	
		}
		var setuppo = parseFloat('<?=$setuppo;?>');
		if(obj.poid == '' && setuppo == 1){
			$('#poid').focus();
			error('Mã đơn hàng <?=getLanguage('all','empty')?>'); return false;
		}
		//E So luong
		//S Don gia
		var priceone = '';
		$('.priceone').each(function(e){
			var goodid = $(this).attr('goodid');
			var val = $(this).val();
			priceone+= ',"'+goodid+'":"'+val+'"';
		});
		if(priceone != ''){
			priceone =  "{"+priceone.substring(1)+"}";
		}
		if(priceone == ''){
			error('Đơn giá <?=getLanguage('all','empty')?>'); return false;	
		}
		//E don gia
		var checkCus = $('input[name="customer_type"]:checked').val();
		var isorder = $('input[name="isorder"]:checked').val();
		var customer_name = $('#customer_name').val();
		if(obj.customerid == ''&& checkCus == 1){
			error('Khách hàng <?=getLanguage('all','empty')?>'); return false;	
		}
		else if(customer_name == ''&& checkCus == 0){
			error('Tên khách hàng <?=getLanguage('all','empty')?>'); return false;	
		}
		if(obj.employeeid == ''){
			//error('Nhân viên bán hàng <?=getLanguage('all','empty')?>'); return false;	
		}
		var input_total = $('#input_total').val();
		var price_prepay = $('#price_prepay').val();
		var token = $('#token').val();
		var idselect = $('#idselect').val();
		var payments = $('input[name=payments]:checked').val();
		obj.input_list = inputList;
		var uniqueid = $('#unit').val();
		// return false;
		$(".loading").show();
		var description = $('#description').val();
		//var place_of_delivery = $('#place_of_delivery').val();
		$.ajax({
			url : controller + func,
			type: 'POST',
			async: false,
			data: {csrf_stock_name:token,search:JSON.stringify(obj),id:id,description:description,customer_type:checkCus,quantity:quantity,priceone:priceone,isorder:isorder,uniqueid:uniqueid,payments:payments},
			success:function(datas){
				var obj = $.evalJSON(datas);  //return false;
				$("#token").val(obj.csrfHash);
				$(".loading").hide();
				$('#input_total,#price_prepay,#price_indebtedness').val('');
				if(obj.status == 0){
					error(obj.msg); return false;	
				}
				else{
					if(id == 0){
						$('#unit').val(obj.status);
						$('#poid').val(obj.poid);
						$('.gridView').html('');
						inputList = {};
						success('Xuất hàng thành công.');
					}
					else{
						$('#unit').val(obj.status);
						$('#poid').val(obj.poid);
						$('.gridView').html('');
						success('Xuất hàng thành công.');
						inputList = {};
						printSave(0,obj.status);
						
					}
				}
			},
			error : function(){
				$(".loading").hide();
				error('Xuất hàng không thành công.'); return false;
			}
		});
	}
	function printSave(id,unit){
		var token = $('#token').val();
		$.ajax({
			url : controller + 'getDataPrintPX?unit='+unit,
			type: 'POST',
			async: false,
			data: {csrf_stock_name:token,id:id},
			success:function(datas){
				var object = $.evalJSON(datas); 
				var disp_setting = "toolbar=yes,location=yes,directories=yes,menubar=no,";
			disp_setting += "scrollbars=yes,width=800, height=500, left=0.0, top=0.0";
				var docprint = window.open("certificate", "certificate", disp_setting);
				docprint.document.open();
				docprint.document.write('<html>');
				//docprint.document.write(css);
				docprint.document.write('<body onLoad="self.print()">');
				docprint.document.write(object.content);
				docprint.document.write('</body></html>');
				docprint.document.close();
				docprint.focus();
			}
		});
		return false;
	}
	function viewPrintHDBH(){
		var unit = $('#unit').val();
		var token = $('#token').val();
		$.ajax({
			url : controller + 'getDataPrintHDBH?unit='+unit,
			type: 'POST',
			async: false,
			data: {},
			success:function(datas){
				var object = $.evalJSON(datas); 
				var disp_setting = "toolbar=yes,location=yes,directories=yes,menubar=no,";
			disp_setting += "scrollbars=yes,width=800, height=500, left=0.0, top=0.0";
				var docprint = window.open("certificate", "certificate", disp_setting);
				docprint.document.open();
				docprint.document.write('<html>');
				//docprint.document.write(css);
				docprint.document.write('<body onLoad="self.print()">');
				docprint.document.write(object.content);
				docprint.document.write('</body></html>');
				docprint.document.close();
				docprint.focus();
			}
		});
		return false;
	}
	function viewPrintHDBHVAT(){
		var unit = $('#unit').val();
		var token = $('#token').val();
		$.ajax({
			url : controller + 'getDataPrintHDBHVAT?unit='+unit,
			type: 'POST',
			async: false,
			data: {},
			success:function(datas){
				var object = $.evalJSON(datas); 
				var disp_setting = "toolbar=yes,location=yes,directories=yes,menubar=no,";
			disp_setting += "scrollbars=yes,width=800, height=500, left=0.0, top=0.0";
				var docprint = window.open("certificate", "certificate", disp_setting);
				docprint.document.open();
				docprint.document.write('<html>');
				//docprint.document.write(css);
				docprint.document.write('<body onLoad="self.print()">');
				docprint.document.write(object.content);
				docprint.document.write('</body></html>');
				docprint.document.close();
				docprint.focus();
			}
		});
		return false;
	}
	function gooods(goodsid,poid,code){ 
		$.ajax({
			url : controller + 'getGoods',
			type: 'POST',
			async: false,
			data: {id:goodsid,poid:poid,code:code},
			success:function(datas){
				var obj = $.evalJSON(datas);
				var finds = obj.finds;
				if(poid != ''){
					$('.gridView').html('');
					//set value
					customerType(finds.customer_type);
					$('#customer_type_'+finds.customer_type).attr('checked',true);
					$('#poid').val(finds.poid);
					$('#employeeid').multipleSelect('setSelects',[finds.employeeid]);
					
					$('#poid').val(finds.poid);
					$('#datecreate').val(finds.datecreate);
					$('#description').val(finds.description);
					$('#unit').val(finds.uniqueid);
					if(parseFloat(finds.customer_type) == 0){
						$('#customer_name').val(finds.customer_name);
						$('#customer_phone').val(finds.customer_phone);
						$('#customer_address').val(finds.customer_address);
						$('#customer_email').val(finds.customer_email);
					}
					else{
						$('#customerid').multipleSelect('setSelects',[finds.customer_id]);
					}
				}
				else{
					//customerType(0);
				}
				$('.gridView').prepend(obj.content);
				formatNumberKeyUp('fm-number');
				formatNumber('fm-number');
				calInputTotal();
				callTotalPrice();
				//Edit
				deleteItem();
				callPrice('quantity');
				callPrice('priceone');
				stt();
				clickViewImg();
			}
		});
	}
	function clickViewImg(){
		$('#clickViewImg').click(function(){
			 var url = $(this).attr('src');
			 viewImg(url);
		});
		$('.tgrid').each(function(){
			$(this).click(function(){ 
				 var url = $(this).attr('url');
				 //viewImg(url);
				var htmlImg = '<img id="clickViewImg" alt="Hình ảnh" style ="width:80px; height:90px;" src= '+url+' />';
				$('#viewImg').html(htmlImg);
				$('#goodsid').val('');
				//$('#goodsid').focus();
				$('#clickViewImg').click(function(){
					 var url = $(this).attr('src');
					 viewImg(url);
				});
			});
		});
	}
	function setDefault(){
		//$('#customer_type_1').attr('checked',true);
		customerType(1);
		$('#poid').val('');
		$('#customerid').multipleSelect('setSelects',[0]);
		$('#employeeid').multipleSelect('setSelects',[0]);
		
		$('#datecreate').val('');
		$('#description').val('');
		$('#customer_name').val('');
		$('#customer_phone').val('');
		$('#customer_address').val('');
		$('#customer_email').val('');
	}
	function deleteItem(){
		$('.deleteItem').each(function(){
			$(this).click(function(){
				var ids = $(this).attr('id');
				if(typeof inputList[ids] !== 'undefined'){
					delete inputList[ids];
				}
				$(this).parent().parent().remove();
				var listCheck = '';
				$('.deleteItem').each(function(e){
					var ids = $(this).attr('id');
					$('.stt').eq(e).html(e+1);
					listCheck+= ','+ids;
				});
				// $('#goodsid').multipleSelect('setSelects', listCheck.split(','));
				calInputTotal();
			});
		});
	}
	function callPrice(cls){
		var total = 0;
		$('.'+cls).each(function(idx){
			$(this).keyup(function(e){
				if ((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode == 8 || e.keyCode == 46) {
					var priceone = $('.priceone').eq(idx).val();
					var quantity = $('.quantity').eq(idx).val();
					priceone = priceone.replace(/[^0-9+\-Ee.]/g, '');
					quantity = quantity.replace(/[^0-9+\-Ee.]/g, '');
					 $('.price').eq(idx).val(formatOne(priceone*quantity));
					calInputTotal(); 
				}
				else{
					return false;
				}
			});
		});
	}
	function callTotalPrice(){
		var total = 0;
		$('.priceone').each(function(e){
			var vals = $(this).val();
			vals = vals.replace(/,/g, '');
			var quantity = $('.quantity').eq(e).val();
			quantity = quantity.replace(/,/g, '');
			total+= (parseFloat(vals) * parseFloat(quantity));
		}); 
		var vat = parseFloat($('#vat').val());
		if($('#vat').val() != ''){
			var ttvat = (vat * total/100).toFixed(2);
			var totals = parseFloat(total) + parseFloat(ttvat);
			$("#input_total").val(formatOne(totals));
			$("#price_prepay").val(formatOne(totals));
			$(".ttprice").html(formatOne(total));
		}
		else{
			$("#input_total").val(formatOne(total));
			$("#price_prepay").val(formatOne(total));
			$(".ttprice").html(total);
		}
	}
	function calInputTotal(){
		var total = 0;
		$('.buyprice').each(function(){
			var price = $(this).val();
			price = price.replace(/[^0-9+\-Ee.]/g, '');
			total+= parseFloat(price);
		});
		callTotalPrice();
		/*
		$("#input_total").val(formatOne(total));
		$("#price_prepay").val(formatOne(total));
		$(".ttprice").html(formatOne(total));*/
	}
	function getInputList(){
		var goodsid = '';
		for(var key in inputList){
			if(inputList.hasOwnProperty(key)){
				goodsid += (goodsid == '' ? '' : ',') + key;
			}
		}
		return goodsid;
	}
	function init(){
		$( "#price_prepay" ).keyup(function(e){
			if ((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode == 8 || e.keyCode == 46) { //0-9 only, backspace, delete
				var inputTotal = $('#input_total').val();
				inputTotal = parseFloat(inputTotal.replace(/[^0-9+\-Ee.]/g, ''));
				var pricePrepay = $('#price_prepay').val();
				pricePrepay = parseFloat(pricePrepay.replace(/[^0-9+\-Ee.]/g, ''));
				if((inputTotal-pricePrepay) < 0){
					$('#price_indebtedness').val(0);
					$('#price_prepay').val(formatOne(inputTotal));
				}
				else{
					$('#price_indebtedness').val(formatOne(inputTotal-pricePrepay));
				}
			}
			else{
				e.preventDefault();
			}
			return false;
		});
		$( "#goodsid" ).keypress(function(e){
			if(e.keyCode == 13){ //Scan
				var goods_code = $.trim($(this).val());
				if(goods_code == ''){
					return false;
				}
				addQuatity('',goods_code);
				calInputTotal();
			}
		});
		$( "#goodsid" ).click(function(){
			$(this).focus();
		});
		$( "#goodsid" ).dblclick(function(){
			$(this).select();
		});
		$( "#goodsid" ).autocomplete({
			source: function( request, response ) {
				$.ajax( {
					url: controller+"getFindGoods",
					dataType: "json",
					type: 'POST',
					async: false,
					data: {
						goodscode: request.term
					},
					success: function( data ) {
						response( data.length === 1 && data[ 0 ].length === 0 ? [] : data );
						var img = '';
						if (data.length > 0){
							img = '<?=base_url();?>files/goods/'+ data[0].img;
						}
						//console.log(img);
						var htmlImg = '<img id="clickViewImg" alt="Hình ảnh" style ="width:80px; height:90px;" src= '+img+' />';
						$('#viewImg').html(htmlImg);
					}
				} );
			},
			select: function( event, ui ){ 
				event.preventDefault();
				$( "#goodsid" ).val( ui.item.label); //ui.item is your object from the array
				var goodsid = ui.item.value;
				var goods_code = ui.item.goods_code;
				var img = '<?=base_url();?>files/goods/'+ ui.item.img;
				var htmlImg = '<img id="clickViewImg" alt="Hình ảnh" style ="width:80px; height:90px;" src= '+img+' />';
				$('#viewImg').html(htmlImg);
				//console.log(inputList[goodsid]);
				addQuatity(goodsid,goods_code);
				calInputTotal();
				return false;
			},
			focus: function(event, ui) {
				event.preventDefault();
				$("#goodsid").val(ui.item.label);
			}
		});
		$( "#isorders" ).keypress(function(e){
			if(e.keyCode == 13){
				var liObj = $('.ui-autocomplete').find('li');
				if(liObj.length == 1){
					liObj.click();
				}
			}
		});
		$( "#isorders" ).autocomplete({
			source: orderList,
			select: function( event, ui ) {
				event.preventDefault();
				$( "#isorders" ).val( ui.item.label); //ui.item is your object from the array
				var isorders = ui.item.value;
				if(typeof inputList[isorders] === 'undefined'){
					inputList[isorders] = 1;
					gooods(isorders,ui.item.label);
					$('#isorders').val('');
				}
				else{
					var thisQuantity = $('#'+isorders).parent().parent().find('.quantity');
					thisQuantity.focus();
				}
				return false;
			},
			focus: function(event, ui) {
				event.preventDefault();
				$("#isorders").val(ui.item.label);
			}
		});
		//
		//$('.fm-number').number(true,0);
		$('#customerid').multipleSelect({
			filter: true,
			placeholder:'Chọn khách hàng',
			single: true
		});
		$('#warehouseid').multipleSelect({
			filter: true,
			placeholder:'Chọn kho',
			single: true
		});
		$('#employeeid').multipleSelect({
			filter: true,
			placeholder:'Chọn nhân viên',
			single: true
		}); 
	}
	function addQuatity(goodsid,goods_code){
		if(typeof inputList[goods_code] === 'undefined'){
			inputList[goods_code] = 1;
			// var goodsid = getInputList();
			gooods(goodsid,'',goods_code);
			$('#goodsid').val('');
		}
		else{
			var thisQuantity = $('#'+goods_code).parent().parent().find('.quantity');
			var quantity = thisQuantity.val(); console.log(quantity);
			if(quantity != ''){
				quantity = quantity.replace(/[^0-9+\-Ee.]/g, '');
			}
			quantity = parseFloat(quantity);
			$('#'+goods_code).parent().parent().find('.quantity').val(quantity+1);
			//Gia
			var priceone = $('#'+goods_code).parent().parent().find('.priceone').val();
			if(priceone != ''){
				priceone = priceone.replace(/[^0-9+\-Ee.]/g, '');
			}
			priceone = parseFloat(priceone);
			var priceTotal = priceone * (quantity+1);
			$('#'+goods_code).parent().parent().find('.buyprice').val(formatOne(priceTotal));
			$('#goodsid').val('');
		}
	}
	function print(id){
		if(id == ''){ return false;}
		var token = $('#token').val();
		$.ajax({
			url : controller + 'getDataPrint',
			type: 'POST',
			async: false,
			data: {csrf_stock_name:token,id:id},
			success:function(datas){
				var object = $.evalJSON(datas); 
				var disp_setting = "toolbar=yes,location=yes,directories=yes,menubar=no,";
			disp_setting += "scrollbars=yes,width=1000, height=500, left=0.0, top=0.0";
				var docprint = window.open("certificate", "certificate", disp_setting);
				docprint.document.open();
				docprint.document.write('<html>');
				//docprint.document.write(css);
				docprint.document.write('<body onLoad="self.print()">');
				docprint.document.write(object.content);
				docprint.document.write('</body></html>');
				docprint.document.close();
				docprint.focus();
			}
		});
		return false;
	}
	function viewImg(url) {
		$.fancybox({
			'width': 600,
			'height': 500,
			'autoSize' : false,
			'hideOnContentClick': true,
			'enableEscapeButton': true,
			'titleShow': true,
			'href': "#viewImg-form",
			'scrolling': 'no',
			'afterShow': function(){
				$('#viewImg-form-gridview').html('<img style="width:600px; height:500px;" src="'+url+'" />');
			}
		});
    }
    function refresh(){
		$('.loading').show();
		//$('.searchs').val('');		
		csrfHash = $('#token').val();
		<?php if(empty($findsPO->poid)){?>
		$('select.combos').multipleSelect('uncheckAll');
		<?php }?>
		$('#customer_type').multipleSelect('setSelects',[1]);
		$('#quantity').val(1);
		$('#payments').multipleSelect('setSelects',[1]);	
		$('.loading').hide();
	}
</script>
<script src="<?=url_tmpl();?>assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
