<?php if($isorder == 1){?>
<?php foreach($ordersDetail as $items){?>
		<div class="row mtop10">
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4">Hàng hóa (<span class="red">*</span>)</label>
					<div class="col-md-8">
						<input title="<?=$items->goods_code;?> - <?=$items->goods_name;?>" ids="<?=$items->id;?>" type="text" name="price" id="price" placeholder="Thành tiền" class="searchs form-control text-left" value = "<?=$items->goods_code;?> - <?=$items->goods_name;?>"  readonly />
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4">SL/ Đơn giá (<span class="red">*</span>)</label>
					<div class="col-md-8" style="padding-left:0 !important;">
						<div class="col-md-6">
							<input ids="<?=$items->id;?>" type="text" name="<?=$items->goodsid;?>_quantity_<?=$items->id;?>" id="<?=$items->goodsid;?>_quantity_<?=$items->id;?>" placeholder="Số lượng" class="search form-control text-right fm-number" value = "<?=number_format($items->quantity);?>" style="padding-right:10px !important" />
						</div>
						<div class="col-md-6" style="padding-left:0 !important; padding-right:0 !important;">
							<input ids="<?=$items->id;?>" type="text" name="<?=$items->goodsid;?>_priceone_<?=$items->id;?>" id="<?=$items->goodsid;?>_priceone_<?=$items->id;?>" placeholder="Đơn giá" class="search form-control text-right fm-number" value = "<?=number_format($items->sale_price);?>" style="padding-right:10px !important" />
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4">Thành tiền</label>
					<div class="col-md-8" style="padding-left:0 !important;">
						<div class="col-md-8">
							<input ids="<?=$items->id;?>" type="text" name="<?=$items->goodsid;?>_price_<?=$items->id;?>" id="<?=$items->goodsid;?>_price_<?=$items->id;?>" placeholder="Thành tiền" class="search form-control text-right fm-number" value = "<?=number_format($items->price);?>" style="padding-right:10px !important" readonly />
						</div>
						<div class="col-md-4" style="padding-left:0 !important; padding-right:0 !important;">
							<input ids="<?=$items->id;?>" type="text" name="<?=$items->goodsid;?>_unitid_<?=$items->id;?>" id="<?=$items->goodsid;?>_unitid_<?=$items->id;?>" placeholder="ĐVT" class="search form-control text-right" value = "<?=$items->unit_name;?>" readonly style="padding-right:10px !important" />
						</div>
					</div>
				</div>
			</div>
		</div>
<?php }?>
<?php }else{?>
	<div class="row mtop10">
			<div class="col-md-4 khles" style="display:nones;">
				<div class="form-group">
					<label class="control-label col-md-4">Hàng hóa (<span class="red">*</span>)</label>
					<div class="col-md-8">
						<select id="goodsid" name="goodsid" class="combos" >
							<option value=""></option>
							<?php foreach($goods as $item){?>
								<option value="<?=$item->id;?>"><?=$item->goods_code;?> - <?=$item->goods_name;?></option>
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
							<input type="text"  name="quantity" id="quantity" placeholder="Số lượng" class="searchs form-control text-right fm-number" value = "1" style="padding-right:10px !important" />
						</div>
						<div class="col-md-6" style="padding-left:0 !important; padding-right:0 !important;">
							<input type="text"  name="priceone" id="priceone" placeholder="Đơn giá" class="searchs form-control text-right fm-number"  style="padding-right:10px !important" />
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4">Thành tiền</label>
					<div class="col-md-8" style="padding-left:0 !important;">
						<div class="col-md-8">
							<input type="text"  name="price" id="price" placeholder="Thành tiền" class="searchs form-control text-right fm-number" value = "" style="padding-right:10px !important" readonly />
						</div>
						<div class="col-md-4" style="padding-left:0 !important; padding-right:0 !important;">
							<input type="text"  name="unitid" id="unitid" placeholder="ĐVT" class="searchs form-control text-right" value = "" style="padding-right:10px !important" readonly />
						</div>
					</div>
				</div>
			</div>
		</div>
<?php }?>
<script>
	$(function(){
		<?php foreach($ordersDetail as $items){?>
		$('#<?=$items->goodsid;?>_priceone_<?=$items->id;?>').keyup(function(){
			var priceone = $('#<?=$items->goodsid;?>_priceone_<?=$items->id;?>').val();
			priceone = priceone.replace(/\,/g, '');
			var quantity = $('#<?=$items->goodsid;?>_quantity_<?=$items->id;?>').val();
			quantity = quantity.replace(/\,/g, '');
			$('#<?=$items->goodsid;?>_price_<?=$items->id;?>').val(priceone*quantity);
			$('#<?=$items->goodsid;?>_price_<?=$items->id;?>').number(true,0);
			$('#<?=$items->goodsid;?>_priceone_<?=$items->id;?>').number(true,0);
		});
		$('#<?=$items->goodsid;?>_quantity_<?=$items->id;?>').keyup(function(){
			var priceone = $('#<?=$items->goodsid;?>_priceone_<?=$items->id;?>').val();
			priceone = priceone.replace(/\,/g, '');
			var quantity = $('#<?=$items->goodsid;?>_quantity_<?=$items->id;?>').val();
			quantity = quantity.replace(/\,/g, '');
			$('#<?=$items->goodsid;?>_price_<?=$items->id;?>').val(priceone*quantity);
			$('#<?=$items->goodsid;?>_price_<?=$items->id;?>').number(true,0);
			$('#<?=$items->goodsid;?>_quantity_<?=$items->id;?>').number(true,0);
		});
		$('#<?=$items->goodsid;?>_quantity_<?=$items->id;?>').click(function(){
			var priceone = $('#<?=$items->goodsid;?>_priceone_<?=$items->id;?>').val();
			priceone = priceone.replace(/\,/g, '');
			var quantity = $('#<?=$items->goodsid;?>_quantity_<?=$items->id;?>').val();
			quantity = quantity.replace(/\,/g, '');
			$('#<?=$items->goodsid;?>_price_<?=$items->id;?>').val(priceone*quantity);
			$('#<?=$items->goodsid;?>_price_<?=$items->id;?>').number(true,0);
			$('#<?=$items->goodsid;?>_quantity_<?=$items->id;?>').number(true,0);
		});
		<?php }?>
	});
</script>

