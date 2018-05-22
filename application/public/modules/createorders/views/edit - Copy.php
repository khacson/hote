<style title="" type="text/css">
	.col-md-4{ white-space: nowrap !important;}
	.col-md-3{ white-space: nowrap !important;}
</style>
<!-- BEGIN PORTLET-->
<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption mtop8">
			<b><i class="fa fa-pencil-square-o mleft10" style="margin-top:4px; font-size:15px;" aria-hidden="true"></i>
			<?=getLanguage('sua-bao-gia');?></b>
		</div>
		<div class="tools">
			<ul class="button-group pull-right mbottom10">
				<?php if(isset($permission['add'])){?>
				<li id="save">
					<button class="button save-input">
						<i class="fa fa-save"></i>
						<?=getLanguage('luu');?>
					</button>
				</li>
				<?php } ?>
				<li id="viewPrint">
					<button class="button">
						<i class="fa fa-print"></i>
						<input type="hidden" id="unit" value="<?=$finds->uniqueid;?>" />
						<?=getLanguage('in');?>
					</button>
				</li>
				<li>
					<a href= "<?=base_url();?>historyorder.html">
						<button class="button">
							<i class="fa fa-history"></i>
							<?=getLanguage('lich-su');?>
						</button>
					</a>
				</li>
			</ul>
		</div>
	</div>
	<div class="portlet-body">
		<div class="row ">
			  <div class="col-md-7" style="width:70%; padding-left:10px; padding-right:10px;">
					<div class="row" style="margin-bottom:15px;">
						<div class="row">
							<div class="form-group col-md-12">
								<label  class="control-label col-md-2" style=";"><?=getLanguage('hang-hoa');?>(<span class="red">*</span>)</label>
								<div class="col-md-10">
									<input type="text" name="goodsid" id="goodsid" placeholder="" class="search form-control " />
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<table class="inputgoods">
							<thead>
								<tr class="thds">
									<td width="30" rowspan="2"><?=getLanguage('stt');?></td>
									<td rowspan="2" ><?=getLanguage('hang-hoa');?></td>
									<td width="75" rowspan="2"><?=getLanguage('dvt');?></td>
									<td width="85" rowspan="2"><?=getLanguage('so-luong');?></td>
									<td width="90" rowspan="2"><?=getLanguage('don-gia');?></td>
									<td width="150" colspan="2"><?=getLanguage('chiet-khau');?></td>
									<td width="100" rowspan="2"><?=getLanguage('thanh-tien');?></td>
									<td width="30" rowspan="2"></td>
								</tr>
								<tr class="thds">
								  <td ><?=configs()['currency'];?>/%</td>
								  <td ><?=getLanguage('san-pham');?></td>
								</tr>
							</thead>
							<tbody class="gridView"></tbody>
						</table>
					</div>
			  </div>
			  <div class="col-md-4" style="margin-left:1%; width:29%; border-left:1px dashed #c3cfd7;  margin-bottom:10px; padding-left:5px;">
					<div class="row">
						 <div class="col-md-11 bdb mleft12 tcler">
							<i class="fa fa-question-circle-o" aria-hidden="true"></i>
							<?=getLanguage('thong-tin-hoa-don');?>
						 </div>
					</div>
					<div class="row mtop10">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4"><?=getLanguage('ma-bao-gia');?> <?php if(!empty($setuppo)){?>(<span class="red">*</span>) <?php }?></label>
								<div class="col-md-8 ">
									<input type="text" value="<?=$finds->poid;?>" name="poid" id="poid" readonly class="form-control searchs"  />
								</div>
							</div>
						</div>
					</div>
					<div class="row mtop10">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4"><?=getLanguage('khach-hang');?> (<span class="red">*</span>)</label>
								<div class="col-md-7">
									<span id="loadCustomer">
										<select id="customerid" name="customerid" class="searchs select2me form-control" data-placeholder="<?=getLanguage('chon-khach-hang')?>">
											<option value=""></option>
											<?php foreach($customers as $item){?>
												<option <?php if($item->id == $finds->customerid){?> selected <?php }?> value="<?=$item->id;?>"><?=$item->customer_name;?></option>
											<?php }?>
										</select>
									</span>
								</div>
								<div class="col-md-1" style="margin-left:-20px;">
									<a title="Thêm khách hàng" class="btn btn-sm btns" id="addSuppliers" data-toggle="modal" data-target="#myFrom" href="#">
										<i class="fa fa-plus" aria-hidden="true"></i>
									</a>
								</div>
							</div>
						</div>
					</div><!--E Row-->
					<div class="row mtop10">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4"><?=getLanguage('ngay-xuat');?></label>
								 <div class="col-md-8 date date-picker" data-date-format="<?=cfdateHtml();?>">
									<?php 
									if(!empty($finds->datecreate) && $finds->datecreate != '0000-00-00'){
										$datecreate =  gmdate(cfdate(), time() + 7 * 3600);
									}
									else{
										$datecreate =  '';
									}
									?>
									<input value="<?=$datecreate;?>" type="text" id="datecreate" placeholder="<?=cfdateHtml();?>" name="datecreate" class="form-control searchs " >
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
								<label class="control-label col-md-4"><?=getLanguage('ngay-giao');?></label>
								 <div class="col-md-8 date date-picker" data-date-format="<?=cfdateHtml();?>">
									<?php 
									if(!empty($finds->deliverydate) && $finds->deliverydate != '0000-00-00'){
										$deliverydate =  gmdate(cfdate(), time() + 7 * 3600);
									}
									else{
										$deliverydate =  '';
									}
									?>
									<input value="<?=$deliverydate;?>" type="text" id="deliverydate" placeholder="<?=cfdateHtml();?>" name="deliverydate" class="form-control searchs " >
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
								<label class="control-label col-md-4"><?=getLanguage('dia-diem-giao');?></label>
								<div class="col-md-8 ">
									<input type="text" name="place_of_delivery" id="place_of_delivery" placeholder="Địa điểm giao hàng" value="<?=$finds->place_of_delivery;?>" class="searchs form-control " maxlength="100" />
								</div>
							</div>
						</div>
					</div>
					<div class="row mtop10">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4"><?=getLanguage('ghi-chu');?></label>
								<div class="col-md-8 ">
									<input maxlength="250" type="text" name="description" id="description" placeholder="" value="<?=$finds->description;?>" class="searchs form-control " />
								</div>
							</div>
						</div>
					</div><!--E Row-->
					<div class="row mtop10">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4"><?=getLanguage('nv-ban-hang');?></label>
								<div class="col-md-8 ">
										<select id="employeeid" name="employeeid" class="searchs select2me form-control" data-placeholder="<?=getLanguage('chon-nhan-vien')?>">
											<option value=""></option>
											<?php
											foreach($employeesale as $item){?>
												<option <?php if($item->id == $finds->employeeid){?> selected <?php }?>
												value="<?=$item->id;?>"><?=$item->employee_code;?> - <?=$item->employee_name;?></option>
											<?php }?>
										</select>
								</div>
							</div>
						</div>
					</div><!--E Row-->
					<div class="row mtop10">
						 <div class="col-md-11 bdb mleft12 tcler">
							<i class="fa fa-usd" aria-hidden="true"></i>
								<?=getLanguage('thong-tin-thanh-toan');?>
						 </div>
					</div>
					<div class="row mtop10">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4"><?=getLanguage('tong');?></label>
								<div class="col-md-8 ">
									<input type="text" name="total-amount" id="total-amount" readonly placeholder="" class="searchs form-control text-right fm-number" />
								</div>
							</div>
						</div>
					</div><!--E Row-->
					<div class="row mtop10">
						<div class="col-md-12">
							<div class="form-group">
								<div class="col-md-4">
									<label class="control-label"><?=getLanguage('giam-gia');?></label>
								</div>
								<div class="col-md-8 ">
									<div class="col-md-6" style="padding:0 !important; ">
										<input style="font-size:12px;" type="text" name="discount" id="discount" placeholder="" class="searchs form-control text-right fm-number" value="<?=$finds->discount;?>" />
									</div>
									<div class="col-md-6" style="padding:0 !important;">
										<select class="form-control select2me" id="input_discount_type" name="input_discount_type" >
											<option <?php if(1 == $finds->discount_type){?> selected <?php }?> value="1"><?=configs()['currency'];?></option>
											<option <?php if(2 == $finds->discount_type){?> selected <?php }?> value="2">%</option>
										</select>
										<input type="hidden" value="<?=$finds->discount_value;?>" name="total-discount" id="total-discount"/>
									</div>
								</div>
							</div>
						</div>
					</div><!--E Row-->
					<div class="row mtop10">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4"><?=getLanguage('dieu-chinh');?></label>
								<div class="col-md-8 ">
									<input type="text" name="adjustment" id="adjustment" class="searchs form-control text-right" value="<?=$finds->adjustment;?>" />
									<input type="hidden" name="total-adjustment" id="total-adjustment" value="<?=$finds->adjustment;?>"   />
								</div>
							</div>
						</div>
					</div><!--E Row-->
					<div class="row mtop10">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4"><?=getLanguage('vat');?>(%)</label>
								<div class="col-md-8 ">
									<div class="col-md-6" style="padding:0 !important; ">
										<input maxlength="3" type="text" name="vat" id="vat" value="<?=$finds->vat;?>" class="searchs form-control text-right fm-number " />
									</div>
									<div class="col-md-6" style="padding:0 !important;">
										<input type="text" name="total-vat" id="total-vat" value="<?=$finds->vat_value;?>" readonly class="searchs form-control text-right fm-number " />
									</div>
								</div>
							</div>
						</div>
					</div><!--E Row-->
					<div class="row mtop10" style="display:none;">
						<div class="col-md-12">
							<div class="form-group">
								<div class="col-md-4">
									<label class="control-label"><?=getLanguage('thanh-toan');?></label>
								</div>
								<div class="col-md-8 ">
									<div class="col-md-6" style="padding:0 !important; ">
										<input style="font-size:12px;" type="text" name="price_prepay" id="price_prepay" placeholder="" class="searchs form-control text-right fm-number" value="" />
									</div>
									<div class="col-md-6" style="padding:0 !important;">
										<select class="form-control select2me" id="price_prepay_type" name="price_prepay_type" >
											<option value="1"><?=configs()['currency'];?></option>
											<option value="2">%</option>
										</select>
										<input type="hidden" name="total-tamung" id="total-tamung" />
									</div> 
								</div>
							</div>
						</div>
					</div><!--E Row total-tamung-->
					<div class="row mtop10" style="display:none;">
						<div class="col-md-12">
							<div class="form-group">
								<label title="<?=getLanguage('ht-thanh-toan');?>" class="control-label col-md-4"><?=getLanguage('ht-thanh-toan');?></label>
								<div class="col-md-8 ">
									<select id="payments" name="payments" class="searchs select2me form-control" >
										<option  value="1"><?=getLanguage('tien-mat');?></option>
										<option  value="2"><?=getLanguage('chuyen-khoan');?></option>
									</select>
								</div>
							</div>
						</div>
					</div><!--E Row-->
					<!--S Ngan hang-->
					<div class="row mtop10" style="display:none;">
						<div class="col-md-12">
							<div class="form-group">
								<label title="<?=getLanguage('ngan-hang');?>" class="control-label col-md-4"><?=getLanguage('ngan-hang');?></label>
								<div class="col-md-8 ">
									<select id="bankid" name="bankid" class="select2me form-control" data-placeholder="<?=getLanguage('chon-ngan-hang')?>">
										<?php if(count($banks) > 1){?>
										<option value=""></option>
										<?php }?>
										<?php foreach($banks as $item){?>
											<option value="<?=$item->id;?>"><?=$item->bank_name;?></option>
										<?php }?>
									</select>
								</div>
							</div>
						</div>
					</div>
					<!--E ngan hang-->
					<div class="row mtop10 mbottom10">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4"><?=getLanguage('tong-cong');?></label>
								<div class="col-md-8 ">
									<input type="text" name="total-amount-end" id="total-amount-end" readonly placeholder="" class="searchs form-control text-right fm-number" readonly />
								</div>
							</div>
						</div>
					</div><!--E Row-->
					<div class="row mtop10 mbottom10" style="display:none;">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4"><?=getLanguage('con-no');?></label>
								<div class="col-md-8 ">
									<input type="text" name="total-amount-end_cl" id="total-amount-end_cl" readonly placeholder="" class="searchs form-control text-right fm-number" />
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
				<!--<li id="refresh" >
					<button class="button">
						<i class="fa fa-refresh"></i>
						<?=getLanguage('all','refresh')?>
					</button>
				</li>-->
				<?php if(isset($permission['add'])){?>
				<li id="save2">
					<button class="button save-input">
						<i class="fa fa-save"></i>
						<?=getLanguage('luu');?>
					</button>
				</li>
				<?php } ?>
				<!--<li id="print2">
					<button class="button">
						<i class="fa fa-print"></i>
						Lưu và in
					</button>
				</li>-->
				<li id="viewPrint2">
					<button class="button">
						<i class="fa fa-print"></i>
						<?=getLanguage('in');?>
					</button>
				</li>
				<li>
					<a href= "<?=base_url();?>historyorder.html">
						<button class="button">
							<i class="fa fa-history"></i>
							<?=getLanguage('lich-su');?>
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

 <!-- Modal -->
<div class="modal fade" id="myFrom" role="dialog">
	<div class="modal-dialog">
	  <!-- Modal content-->
	  <div class="modal-content">
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
		  <h4 class="modal-title"><i class="fa fa-plus" aria-hidden="true"></i> <?=getLanguage('them-khach-hang');?></h4>
		</div>
		<div class="modal-body">
			<!--Content-->
		</div>
		<div class="modal-footer">
		  <button type="button" id="addSups" class="btn btn-default"><?=getLanguage('luu');?></button>
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
<link href="<?=url_tmpl();?>css/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src="<?=url_tmpl();?>js/jquery-ui.js" type="text/javascript"></script>
<style type="text/css">
	.inputgoods{
		width:98%;	
		margin-left:15px;
		margin-top:0px;
	}
	.thd{
		text-align:center;
	}
	.thds td{
		background:#f7f7f7;
	}
</style>
<input id="uniqueid" name="uniqueid" type="hidden" />
<input id="uniqueidnew" name="uniqueidnew" value="<?=$uniqueid;?>" type="hidden" />
<script type="text/javascript" src="<?=url_tmpl();?>fancybox/source/jquery.fancybox.pack.js"></script>  
<link href="<?=url_tmpl();?>fancybox/source/jquery.fancybox.css" rel="stylesheet" />
<script>
	alert(123);
	var controller = '<?=base_url().$routes;?>/';
	var csrfHash = '<?=$csrfHash;?>';
	var goodsList = '';
	var orderList = JSON.parse('<?=json_encode($odersList);?>');;
	var inputList = {};
	var cpage = 0;
	var search;
	var percent = 0;
	var isnew = 1;
	$(function(){ 
		gridView(); 
		
		
		
		//S Them nha cung cap
		
		
		//Set tinh tong
	});
	
	
</script>

