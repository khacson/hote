<div class="row mtop10">
	<div class="col-md-4">
		<div class="form-group">
			<label class="control-label col-md-4">Hàng hóa (<span class="red">*</span>)</label>
			<div class="col-md-8">
				<select id="goodsid_<?=$uniqueid;?>" name="goodsid_<?=$uniqueid;?>" class="combos" >
					<option value=""></option>
					<?php foreach($goods as $item){?>
						<option  value="<?=$item->id;?>"><?=$item->goods_code;?> - <?=$item->goods_name;?></option>
					<?php }?>
				</select>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label class="control-label col-md-4">SL/ Đơn giá (<span class="red">*</span>)</label>
			<div class="col-md-8" style="padding-left:0 !important;">
				<div class="col-md-6">
					<input name="quantity_<?=$uniqueid;?>" id="quantity_<?=$uniqueid;?>" placeholder="" class="search form-control fm-number" />
				</div>
				<div class="col-md-6" style="padding-left:0 !important; padding-right:0 !important;"> 
					<input type="text" name="priceone_<?=$uniqueid;?>" id="priceone_<?=$uniqueid;?>" placeholder="" class="search form-control fm-number" required />
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label class="control-label col-md-4">Thành tiền (<span class="red">*</span>)</label>
			<div class="col-md-5" style="position:relative; z-index:1;">
				  <input type="text" name="price"_<?=$uniqueid;?> id="price_<?=$uniqueid;?>" placeholder="" class="search form-control fm-number" required  readonly />	
			</div>
			<div class="col-md-3 pleft0 text-right deleteGoodsList" >
				<a style="position:relative; z-index:2;" class="btn btn-sm btns2" href="#">
					<i class="fa fa-times"></i>
					Hũy
				</a>
			</div>
		</div>
		<!--<span style="position:relative; z-index:2;" class="deleteGoodsList"><i style="margin-left:-10px; margin-top:6px; cursor:pointer; width:20px; height:20px; color:#f47709;"  class="fa fa-times"></i></span>-->
	</div>
</div>