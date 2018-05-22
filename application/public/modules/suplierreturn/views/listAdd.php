<?php $i=1; foreach($datas as $item){?>
<tr class="tgrid" url= '<?=base_url();?>files/goods/<?=$item->img;?>'>
	<td class="stt" width="40" class="text-center"><?=$i;?></td>
	<td align="left">
		<b><?=$item->goods_code;?></b> <br> <?=$item->goods_name;?>
		<input  goodid="<?=$item->goodsid;?>" class="goodscode" type="hidden" value="<?=$item->goods_code;?>" />
	</td>
	<td width="60"><?=$item->unit_name;?></td>
	<td width="70"><input goodid="<?=$item->goodsid;?>" uniqueid="<?=$item->uniqueid;?>" type="text" name="quantity" id="<?=$item->goods_code;?>" placeholder="" class="search form-control quantity text-right fm-number" value="<?=$item->quantity;?>" style="font-size:12px;"  /></td>
	
	<td width="100"><input goodid="<?=$item->goodsid;?>" type="text" name="priceone" id="priceone" placeholder="" class="search form-control priceone text-right fm-number" value="<?=$item->sale_price;?>" style="font-size:12px;"  /></td>
	
	<td width="100"><input goodid="<?=$item->goodsid;?>" type="text" id="price" placeholder="" class="search form-control price buyprice text-right fm-number" value="<?=$item->price;?>" style="font-size:12px;" /></td>
	
	<td width="40">
		<a class="deleteItem" id="<?=$item->id;?>" href="#">
			<i class="fa fa-times"></i>
		</a>
	</td>
</tr>
<?php $i++;}?>