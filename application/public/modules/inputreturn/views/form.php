<style title="" type="text/css">
	.col-md-4{ white-space: nowrap !important;}
	.col-md-3{ white-space: nowrap !important;}
</style>
<!-- BEGIN PORTLET-->
<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption mtop8">
			<b><i class="fa fa-pencil-square-o mleft10" style="margin-top:4px; font-size:15px;" aria-hidden="true"></i>
			Tạo phiếu xuất bán hàng</b>
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
						<input type="hidden" id="unit" value="" />
						Phiếu xuất
					</button>
				</li>
				<li id="viewPrintHDBH">
					<button class="button">
						<i class="fa fa-print"></i>
						<input type="hidden" id="unit" value="" />
						HĐBL
					</button>
				</li>
				<li id="viewPrintHDBH3">
					<button class="button">
						<i class="fa fa-print"></i>
						<input type="hidden" id="unit" value="" />
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
					
					<div class="row mtop20">
						<div class="row">
							<div class="form-group">
								<label  class="control-label col-md-3" style="padding-left:30px;">Chọn hàng hóa(<span class="red">*</span>)</label>
								<div class="col-md-7" style="padding-left:0; margin-left:-3px;">
									<input type="text" name="goodsid" id="goodsid" placeholder="" class="search form-control" />
								</div>
								<div  style="margin-top:-40px; width:110px; height:90px; border: 1px solid #ddd;" class="col-md-2" id="viewImg" >
									<div style ="width:80px; height:80px; padding:5px 0; ">
										<div style="margin-top:35px; margin-left:10px;">Hình ảnh</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<table class="inputgoods">
							<thead>
								<tr class="thd">
									<td width="40">STT</td>
									<td >Hàng hóa</td>
									<td width="60">ĐVT</td>
									<td width="70">Số lương</td>
									<td width="100">Đơn giá</td>
									<td width="120">Thành tiền</td>
									<td width="105">Hạn bảo hành</td>
									<td width="30"></td>
								</tr>
							</thead>
							<tbody class="gridView">
								<?php $i=1; 
									$tt = 0;
									foreach($datas as $item){
									?>
									<tr class="tgrid" url= '<?=base_url();?>files/goods/<?=$item->img;?>'>
										<td class="stt" width="40" class="text-center"><?=$i;?></td>
										<td align="left">
											<b><?=$item->goods_code;?></b>-<?=$item->goods_name;?>
											<?php if($item->stype == 0 && !empty($item->group_code)){?>
												<br><i style="font-size:12px;">(<?=$item->group_code;?>-<?=$item->group_name;?>)</i>
											<?php }?>
		
											<input  goodid="<?=$item->id;?>" class="goodscode" type="hidden" value="<?=$item->goods_code;?>" />
		<input  goodid="<?=$item->id;?>" class="sttview" type="hidden" value="<?=$i;?>" />
		<input  goodid="<?=$item->id;?>" class="discount" type="hidden" value="<?=$item->discount;?>" />
											
										</td>
										<td width="60"><?=$item->unit_name;?></td>
										<td width="70"><input goodid="<?=$item->id;?>" uniqueid="<?=$item->uniqueid;?>" type="number" name="quantity" id="<?=$item->goods_code;?>" placeholder="" max="<?=$item->quantity;?>" min="1" class="search form-control quantity text-right fm-number" value="<?=$item->quantity;?>" style="font-size:12px;"  /></td>
										
										<td width="100">
											<?php 
											$arrPrice = explode(';',$item->sale_price);	
											$priceoneFirst = $item->sale_price;
											if(!empty($item->satPrice)){
												$priceoneFirst = $item->satPrice;
											}
											if(empty($item->sale_price) || count($arrPrice) <=1 ){?>
												<input goodid="<?=$item->id;?>" type="text" name="priceone" id="priceone" placeholder="" class="search form-control priceone text-right fm-number" value="<?=fmNumber($item->sale_price);?>" style="font-size:12px;"  />
											<?php }else{
											?>
											<select style="font-size:12px; height:28px;" 
											goodid="<?=$item->id;?>" name="priceone" id="priceone" placeholder="" class="combo priceone">
												<?php 
												foreach($arrPrice as $kk=>$pce){
													$selected = '';
													if($priceoneFirst == $pce){
														$selected = 'selected';
														$priceoneFirsts = $arrPrice[$kk];
													}
													else{
														$priceoneFirsts = $arrPrice[0];
													}
													?>
													<option <?=$selected;?> value="<?=$pce;?>"><?=fmNumber($pce);?></option>
												<?php }
												$priceoneFirst = $priceoneFirsts;
												?>
											</select>
											<?php }?>
										</td>
										<?php 
											$prices = ($priceoneFirst * $item->quantity) - $item->discount;
											$tt+= $prices;
										?>
										<td width="100">
										<input goodid="<?=$item->id;?>" type="text" id="price" placeholder="" class="search form-control price buyprice text-right fm-number" value="<?=fmNumber($prices);?>" style="font-size:12px; float:left; width:83%;" />
										
										<a title="Giảm giá" goodid="<?=$item->id;?>" class="discountorder" data-toggle="modal" data-target="#viewdiscount-form"   href="#" style="float:left; margin-left:5px; margin-top:5px;" ><i class="fa fa-arrow-circle-down" aria-hidden="true"></i></a>
										
										</td>
										<td  title="Bảo hành" style="padding-left:5px !important; padding-right:5px !important;">
											<div goodid="<?=$item->id;?>" style="padding-left:0 !important; padding-right:0 !important;" class="dateOneGuarantee input-group date date-picker" data-date-format="<?=cfdateHtml();?>">
												<?php 
													if(empty($item->guaranteedate) || $item->guaranteedate == '0000-00-00'){
														$guarantee = '';
													}
													else{
														$guarantee = date(cfdate(),strtotime($item->guaranteedate));
													}
												?>
												<input style="font-size:12px;" goodid="<?=$item->id;?>" type="text" id="guarantee_<?=$item->id;?>" name="guarantee" value="<?=$guarantee;?>" class="guarantees search" >
												<span class="input-group-btn ">
													<button style="margin-left:-19px;" class="btn default btn-picker-detail btn-picker" type="button"><i class="fa fa-calendar "></i></button>
												</span>
											</div>
										</td>
										<td width="40">
											<a class="deleteItem" id="<?=$item->id;?>" href="#">
												<i class="fa fa-times"></i>
											</a>
										</td>
									</tr>
									<?php $i++;}
									$vat = 0;//$finds->vat;
									$ttvat = $vat * $tt /100;
									$tt = $ttvat + $tt;
									?>
								<tr >
									<td colspan="5" style="text-align:right;">Tổng tiền:</td>
									<td class="ttprice" style="text-align:right; padding-right:10px !important;"><?=fmNumber($tt);?></td>
									<td></td>
									<td></td>
								</tr>
							</tbody>
						</table>
					</div>
			  </div>
			  <div class="col-md-4" style="margin-left:1%; width:34%; border-left:1px dashed #c3cfd7;  margin-bottom:10px; padding-left:5px;">
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
								<div class="col-md-8 ">
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
									<input type="text" value="" name="poid" id="poid" <?=$readonly;?> class="form-control searchs"  />
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
									<input value="1" id="customer_type_1" type="radio" name="customer_type" />
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
								<div class="col-md-8 ">
									<input type="text" name="customer_name" id="customer_name" placeholder="" value="" class="searchs form-control" />
								</div>
							</div>
						</div>
					</div>
					<div class="row mtop10">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4">Điện thoại</label>
								<div class="col-md-8 ">
									<input type="text" name="customer_phone" id="customer_phone" placeholder="" value="" class="searchs form-control" />
								</div>
							</div>
						</div>
					</div>
					<div class="row mtop10">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4">Địa chỉ</label>
								<div class="col-md-8 ">
									<input type="text" name="customer_address" id="customer_address" placeholder="" value="" class="searchs form-control" />
								</div>
							</div>
						</div>
					</div>
					<div class="row mtop10">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4">Email</label>
								<div class="col-md-8 ">
									<input type="text" name="customer_email" id="customer_email" placeholder="" value="" class="searchs form-control" />
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
												<option value="<?=$item->id;?>"><?=$item->customer_name;?></option>
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
					<div class="row mtop10">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4">Ngày nhập</label>
								 <div class="col-md-8 input-group date date-picker" data-date-format="<?=cfdateHtml();?>">
									<?php 
									$datecreate =  gmdate(cfdate(), time() + 7 * 3600);
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
									<input value="<?=$datecreate;?>" type="text" id="deliverydate" placeholder="<?=cfdateHtml();?>" name="deliverydate" class="form-control searchs" >
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
								<label class="control-label col-md-4">Hạn bảo hành</label>
								 <div class="selectAllGuarantee col-md-8 input-group date date-picker" data-date-format="<?=cfdateHtml();?>">
									
									<input value="" type="text" id="guarantee" placeholder="<?=cfdateHtml();?>" name="guarantee" class="form-control searchs" >
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
								<div class="col-md-8 ">
									<input type="text" name="place_of_delivery" id="place_of_delivery" placeholder="Địa điểm giao hàng" value="" class="searchs form-control" />
								</div>
							</div>
						</div>
					</div>
					<div class="row mtop10">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4">Ghi chú</label>
								<div class="col-md-8 ">
									<input type="text" name="description" id="description" placeholder="" value="" class="searchs form-control" />
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
								<div class="col-md-8 ">
									<span id="loadWarehouse">
										<select id="warehouseid" name="warehouseid" class="combos" >
											<option value=""></option>
											<?php
											$selected = '';
											$warehouseDefault = 0;
											if(count($warehouses) == 1){
												$selected = 'selected';
												$warehouseDefault = $warehouses[0]->id;
											}
											foreach($warehouses as $item){?>
												<option <?=$selected;?>
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
								<div class="col-md-8 ">
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
								<div class="col-md-8 ">
									<input maxlength="3" type="text" name="vat" id="vat" placeholder="" class="searchs valtotal form-control text-right fm-number" />
								</div>
							</div>
						</div>
					</div><!--E Row-->
					<div class="row mtop10">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4">Thành tiền</label>
								<div class="col-md-8 ">
									<input value="<?=fmNumber($tt);?>" type="text" name="input_total" id="input_total" readonly placeholder="" class="searchs form-control text-right fm-number" />
								</div>
							</div>
						</div>
					</div><!--E Row-->
					<div class="row mtop10">
						<div class="col-md-12">
							<div class="form-group">
								<div class="col-md-4">
									<label class="control-label">Tạm ứng</label>
								</div>
								<div class="col-md-8 ">
									<div class="col-md-7" style="padding:0 !important;">
										<label class="control-label">
											<input  checked type="radio" id="prepay_1" name="prepay" value="1"  />
											Tiền mặt</label>
										<label class="control-label" style="margin-left:10px;">
											<input  type="radio" id="prepay_2" name="prepay" value="2"  />
											%</label>
									</div>
									<div class="col-md-5" style="padding:0 !important; ">
										<input style="font-size:12px;" type="text" name="price_prepay" id="price_prepay" placeholder="" class="searchs form-control text-right fm-number" value="<?=fmNumber($tt);?>" />
									</div>
								</div>
							</div>
						</div>
					</div><!--E Row-->
					<div class="row mtop10 mbottom10">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4">Còn nợ</label>
								<div class="col-md-8 ">
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
						<input type="hidden" id="unit" value="" />
						Hóa đơn bán lẻ
					</button>
				</li>
				<li id="viewPrintHDBH3s">
					<button class="button">
						<i class="fa fa-print"></i>
						<input type="hidden" id="unit" value="" />
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
<div class="modal fade" id="viewdiscount-form" style="display:none;" role="dialog">
	<div class="modal-dialog" style="width:400px;" > 
	  <!-- Modal content-->
	  <div class="modal-content">
		<div class="modal-header">
		 <button type="button" class="close closeTop" data-dismiss="modal">&times;</button>
		  <h4 class="modal-title"><i class="fa fa-plus" aria-hidden="true"></i> Giảm giá</h4>
		</div>
		<div class="viewdiscount-form-gridview">
			<!--Content-->
		</div>
		<div class="modal-footer">
		  <button type="button" data-dismiss="modal" class="btn btn-default closeModal">Đóng</button>
		</div>
	  </div>
	</div>
</div>
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
<input id="uniqueid" name="uniqueid" value="<?=$uniqueid;?>" type="hidden" />
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
		
		var isorder = 0;
		var type = 1;
		$('.dateOneGuarantee').datepicker().on('changeDate', function (ev) {
			var goodid = $(this).attr('goodid');
			var guarantee = $('#guarantee_'+goodid).val();
			$.ajax({
				url : controller + 'updateGuarantee',
				type: 'POST',
				async: false,
				data: {goodid:goodid,guarantee:guarantee},
				success:function(datas){}
			});
			$('.datepicker').hide();
		});
		$('.selectAllGuarantee').datepicker().on('changeDate', function (ev){
			var guarantee = $('#guarantee').val();
			$('.guarantees').val(guarantee);
			$.ajax({
				url : controller + 'updateAllGuarantee ',
				type: 'POST',
				async: false,
				data: {guarantee:guarantee},
				success:function(datas){}
			});
			$('.datepicker').hide();
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
			 calInputTotal();
		});
		$('.closeModal').click(function(){
			gooods(0,0,0,0,'refresh'); 
			//$('.close').click();
		});
		$('.closeTop').click(function(){
			gooods(0,0,0,0,'refresh'); 
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
		actionTemp();
		setDefault();
	});
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
		var quantity = {};
		$('.quantity').each(function(e){
			var goodid = $(this).attr('goodid');
			var val = $(this).val();
			quantity[goodid] = val;
		});
		if(JSON.stringify(quantity) == '{}'){
			warning('Hàng hóa <?=getLanguage('all','empty')?>'); return false;	
		}
		
		var setuppo = parseFloat('<?=$setuppo;?>');
		if(obj.poid == '' && setuppo == 1){
			$('#poid').focus();
			warning('Mã đơn hàng <?=getLanguage('all','empty')?>'); return false;
		}
		//E So luong
		//S Don gia
		var priceone = {};
		$('.priceone').each(function(e){
			var goodid = $(this).attr('goodid');
			var val = $(this).val();
			priceone[goodid] = val; 
		});
		//Bao hanh
		var guarantee = {};
		$("input[id^='guarantee_']").each(function(e){
			var goodid = $(this).attr('goodid');
			var val = $(this).val();
			guarantee[goodid] = val;
		});
		//Giam gia
		var discount = {};
		$(".discount").each(function(e){
			var goodid = $(this).attr('goodid');
			var val = $(this).val();
			discount[goodid] = val;
		});
		//So ttt
		var sttview = {};
		$(".sttview").each(function(e){
			var goodid = $(this).attr('goodid');
			var val = $(this).val();
			sttview[goodid] = val;
		});
		//E don gia
		var checkCus = $('input[name="customer_type"]:checked').val();
		var isorder = $('input[name="isorder"]:checked').val();
		var customer_name = $('#customer_name').val();
		if(obj.customerid == ''&& checkCus == 1){
			warning('Khách hàng <?=getLanguage('all','empty')?>'); return false;	
		}
		else if(customer_name == ''&& checkCus == 0){
			warning('Tên khách hàng <?=getLanguage('all','empty')?>'); return false;	
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
		var uniqueid = $('#uniqueid').val();
		// return false;
		$(".loading").show();
		var description = $('#description').val();
		//var place_of_delivery = $('#place_of_delivery').val();
		$.ajax({
			url : controller + func,
			type: 'POST',
			async: false,
			data: {csrf_stock_name:token,search:JSON.stringify(obj),id:id,description:description,customer_type:checkCus,quantity:JSON.stringify(quantity),priceone:JSON.stringify(priceone),isorder:isorder,uniqueid:uniqueid,payments:payments,guarantee:JSON.stringify(guarantee),discount:JSON.stringify(discount),sttview:JSON.stringify(sttview)},
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
	function gooods(goodsid,code,stype,exchangs,deletes){ 
	    var vat = $('.valtotal').val();
		$.ajax({
			url : controller + 'getGoods',
			type: 'POST',
			async: false,
			data: {vat:vat, id:goodsid,code:code,stype:stype,exchangs:exchangs,deletes:deletes,isnew:0},
			success:function(datas){
				var obj = $.evalJSON(datas); 
				$('.gridView').html(obj.content); //Add Grid view
				//$('.ttprice').html(obj.totalPrice);
				$('#uniqueid').val(obj.uniqueid);
				percent = 0; //gan gia tri tien = 0
				$('#prepay_1').prop('checked', true);
				$('#goodsid').val('');
				actionTemp();
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
		var warehouseDefault = '<?=$warehouseDefault;?>';
		customerType(1);
		$('#poid').val('');
		$('#customerid').multipleSelect('setSelects',[0]);
		$('#warehouseid').multipleSelect('setSelects',[warehouseDefault]);
		$('#description').val('');
		$('#customer_name').val('');
		$('#customer_phone').val('');
		$('#customer_address').val('');
		$('#customer_email').val('');
	}
	function actionTemp(){
		//Giam gia
		$('.discountorder').each(function(ext){
			$(this).on('click',function(){
				var goodid = $(this).attr('goodid'); 
				var price = $('.buyprice').eq(ext).val(); 
				$.ajax({
					url : controller + 'getDiscountorder',
					type: 'POST',
					async: false,
					data: {goodid:goodid, price:price,isnew:0},
					success:function(datas){
						var obj = $.evalJSON(datas); 
						$('.viewdiscount-form-gridview').html(obj.content);
					}
				}); 
			});
		});
		//Xóa
		$('.deleteItem').each(function(){
			$(this).on('click',function(){
				var goodid = $(this).attr('id'); 
				$.ajax({
					url : controller + 'deleteTempData',
					type: 'POST',
					async: false,
					data: {goodid:goodid},
					success:function(datas){
						gooods(0,0,0,0,'delete');
					}
				}); 
				calInputTotal();
			});
		});
		//Update don gia 
		$('.priceone').each(function(idx){
			$(this).on('keyup',function(){
				var goodid = $(this).attr('goodid'); 
				var priceone = $(this).val();
				setPrice(idx)
				updatePriceOne(goodid,priceone);
			});
		});
		$('.priceone').each(function(idx){
			$(this).on('change',function(){
				var goodid = $(this).attr('goodid'); 
				var priceone = $(this).val();
				setPrice(idx)
				updatePriceOne(goodid,priceone);
			});
		});
		//Update so luong
		$('.quantity').each(function(idx){
			$(this).on('click',function(){
				var goodid = $(this).attr('goodid'); 
				var quantity = $(this).val();
				//Tinh tien
				setPrice(idx)
				updateQuantity(goodid,quantity);
			});
			$(this).on('keyup',function(){
				var goodid = $(this).attr('goodid'); 
				var quantity = $(this).val();
				//Tinh tien
				setPrice(idx);
				updateQuantity(goodid,quantity);
			});
		});
		
	}
	function setPrice(idx){
		var priceone = $('.priceone').eq(idx).val();
		var quantity = $('.quantity').eq(idx).val();
		if (typeof priceone === "undefined") {
			priceone = ',0';
		}
		priceone = priceone.replace(/[^0-9+\-Ee.]/g, '');
		if (typeof quantity === "undefined") {
			quantity = ',0';
		}
		quantity = quantity.replace(/[^0-9+\-Ee.]/g, '');
		$('.price').eq(idx).val(formatOne(priceone*quantity));
	}
	function calInputTotal(){
		var total = 0; 
		$('.priceone').each(function(inx){
			var price = $(this).val();
			if(price == ''){
				price = '0';
			}
			var quantity = $('.quantity').eq(inx).val();
			if(quantity == ''){
				quantity = '0';
			}
			var discount = $('.discount').eq(inx).val();
			if(discount == ''){
				discount = 0;
			}
			else{
				discount = parseFloat(discount);
			}
			price = parseFloat(price.replace(/[^0-9+\-Ee.]/g, ''));
			quantity = parseFloat(quantity.replace(/[^0-9+\-Ee.]/g, ''));
			var tPrice = (quantity * price) - discount;
			total+= tPrice;
		});
		var vat = $('.valtotal').val();
		if(vat != ''){
			vat = parseFloat(vat.replace(/[^0-9+\-Ee.]/g, ''));
			if(vat > 100){ 
				val = 100; 
				$('.valtotal').val(val);
			}
		}
		else{
			vat = 0;
		}
		var cfnumber = parseFloat('<?=cfnumber()?>');
		var allTotal = (vat * total / 100) + total;
		allTotal = allTotal.toFixed(cfnumber);
		$("#input_total").val(formatOne(allTotal));
		$("#price_prepay").val(formatOne(allTotal));
		$(".ttprice").html(formatOne(allTotal));
	}
	function updatePriceOne(goodid,priceone){
		$.ajax({
			url : controller + 'updatePriceOne',
			type: 'POST',
			async: false,
			data: {goodid:goodid, priceone:priceone},
			success:function(datas){
				
			}
		}); 
		calInputTotal();
	}
	function updateQuantity(goodid,quantity){
		$.ajax({
			url : controller + 'updateQuantity',
			type: 'POST',
			async: false,
			data: {goodid:goodid,quantity:quantity},
			success:function(datas){
			}
		}); 
		calInputTotal();
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
		$('#prepay_1').prop('checked', true);
		$('#shelflife').change(function () {
			$('.shelflifes').val($('#shelflife').val());
		});
		if($('#prepay_2').is(':checked')){
			var pricePrepay = parseFloat($('#price_discount').val().replace(/[^0-9+\-Ee.]/g, ''));//parseFloat
			if(pricePrepay > 100){
				$('#price_discount').val(100);
			}
			percent = 1;
		}
		$('#prepay_1').click(function(){//Tien 
			var inputTotal = $('#input_total').val();
			inputTotal = parseFloat(inputTotal.replace(/[^0-9+\-Ee.]/g, ''));
			var pricePrepay = $('#price_prepay').val();
			pricePrepay = parseFloat(pricePrepay.replace(/[^0-9+\-Ee.]/g, ''));
			if(percent == 0){
				$('#price_prepay').val(pricePrepay);
			}
			else{
				var perc = pricePrepay * inputTotal / 100;
				pricePrepay = formatOne(perc.toFixed(2));
				$('#price_prepay').val(pricePrepay);
				pricePrepay = parseFloat(pricePrepay.replace(/[^0-9+\-Ee.]/g, ''));
				console.log(pricePrepay);
				$('#price_indebtedness').val(formatOne(inputTotal-pricePrepay));
			}
			percent = 0;
		});
		$('#prepay_2').click(function(){//Phan tram
			var inputTotal = $('#input_total').val();
			inputTotal = parseFloat(inputTotal.replace(/[^0-9+\-Ee.]/g, ''));
			var pricePrepay = $('#price_prepay').val();
			pricePrepay = parseFloat(pricePrepay.replace(/[^0-9+\-Ee.]/g, ''));
			if(percent == 1){
				$('#price_prepay').val(pricePrepay);
			}
			else{
				var perc = pricePrepay * 100 / inputTotal;
				pricePrepay = formatOne(perc.toFixed(2));
				$('#price_prepay').val(pricePrepay);
				var pricePrepay2 = pricePrepay * inputTotal / 100;
				pricePrepay = parseFloat(pricePrepay.replace(/[^0-9+\-Ee.]/g, ''));
				$('#price_indebtedness').val(formatOne(inputTotal-pricePrepay2));
			}
			percent = 1;
		});
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
			if(e.keyCode == 13){ //dung may Scan
				var goods_code = $.trim($(this).val());
				if(goods_code == ''){
					return false;
				}			
				gooods(temp_goodsid,temp_goods_code,temp_stype,temp_exchangs,'');
			}
		});
		$( "#goodsid" ).click(function(){
			$(this).focus();
		});
		$( "#goodsid" ).dblclick(function(){
			$(this).select();
		});
		$( "#goodsid" ).autocomplete({
			//source: goodsList,
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
						if (data.length === 0){
							return false;
						}
						temp_goodsid = data[0].goodsid;
						temp_goods_code = data[0].goods_code;
						temp_stype = data[0].stype;
						temp_exchangs = data[0].exchangs;											
					}
				} );
			},
			select: function( event, ui ){ 
				event.preventDefault();
				$( "#goodsid" ).val( ui.item.label); //ui.item is your object from the array
				var goodsid = ui.item.value;
				var goods_code = ui.item.goods_code;
				gooods(goodsid,goods_code,ui.item.stype,ui.item.exchangs,'');
				return false;
			},
			focus: function(event, ui) {
				event.preventDefault();
				$("#goodsid").val(ui.item.label);
			}
		});
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
		$('#customer_type').multipleSelect('setSelects',[1]);
		$('#quantity').val(1);
		$('#payments').multipleSelect('setSelects',[1]);	
		$('.loading').hide();
	}
</script>
<script src="<?=url_tmpl();?>assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
