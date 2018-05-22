<?php $i=1; foreach($goods as $item){?>
<div class="row mtop10">
	<div class="col-md-4">
		<div class="form-group">
			<label class="control-label col-md-4">Hàng hóa(<span class="red">*</span>)</label>
			<div class="col-md-8">
				<input title="<?=$item->goods_name;?>" class="search form-control" value="<?=$item->goods_code;?> - <?=$item->goods_name;?>" />
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label class="control-label col-md-4">SL/ Đơn giá (<span class="red">*</span>)</label>
			<div class="col-md-8" style="padding-left:0 !important;">
				<div class="col-md-6">
					<input goodsid="<?=$item->goodsid;?>" name="quantity_<?=$item->uniqueid;?>" id="quantity_<?=$item->uniqueid;?>" placeholder="" class="search form-control fm-number" value="<?=number_format($item->quantity);?>" />
				</div>
				<div class="col-md-6" style="padding-left:0 !important; padding-right:0 !important;"> 
					<input type="text" name="priceone_<?=$item->uniqueid;?>" id="priceone_<?=$item->uniqueid;?>" placeholder="" goodsid="<?=$item->goodsid;?>" value="<?=number_format($item->priceone);?>" class="search form-control fm-number" required />
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label class="control-label col-md-4">Thành tiền (<span class="red">*</span>)</label>
			<div class="col-md-8" style="position:relative; z-index:1;">
				  <input type="text" name="price"_<?=$item->uniqueid;?> id="price_<?=$item->uniqueid;?>" placeholder="" value="<?=number_format($item->price);?>" class="search form-control fm-number" required  readonly />	
			</div>
		</div>
		<?php if($i==1){?>
			<span style="position:relative; z-index:2;" id="addGoodsList"><i style="margin-left:-10px; margin-top:6px; cursor:pointer; width:20px; height:20px;"  class="fa fa-plus"></i></span>
		<?php }else{?>
			<span style="position:relative; z-index:2;" class="deleteGoodsList"><i style="margin-left:-10px; margin-top:6px; cursor:pointer; width:20px; height:20px; color:#f47709;"  class="fa fa-times"></i></span>
		<?php }?>
	</div>
</div>
<?php $i++; }?>