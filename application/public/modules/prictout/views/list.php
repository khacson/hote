<?php 	$i = $start;
foreach ($datas as $key => $item){ 	
	?>
	<tr class="edit" 
	id="<?=$item->id;?>" 
	goodsid ="<?=$item->goodsid;?>"
	>
		<td style="text-align: center;">
			<input id="<?=$item->id;?>" class="noClick" type="checkbox" value="<?=$item->id; ?>" name="keys[]">
		</td>
		<td style="text-align: center;"><?=$i;?></td>
		<td class="goods_code"><?=$item->goods_code;?></td>
		<td class="goods_code"><?=$item->goods_name;?></td>
		<td class="price text-right"><?=fmNumber($item->price);?></td>
		<td class="description"><?=$item->description;?></td>
		<td></td>
	</tr>

<?php $i++;}?>
