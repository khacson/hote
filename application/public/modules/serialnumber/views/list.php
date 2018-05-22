
<?php 	$i = $start;
foreach ($datas as $key => $item) { 	
	?>
	<tr class="edit" 
	id="<?=$item->id;?>" 
	goodsid ="<?=$item->goodsid;?>"
	>
		
		<td style="text-align: center;">
			<input id="<?=$item->id;?>" class="noClick" type="checkbox" value="<?=$item->id; ?>" name="keys[]">
		</td>
		<td style="text-align: center;"><?=$i;?></td>
		<td class="sn"><?=$item->sn;?></td>
		<td class="imei"><?=$item->imei;?></td>
		<td class="description"><?=$item->description;?></td>
		<td class="goods_code"><b><?=$item->goods_code;?></b><br><?=$item->goods_name;?></td>
		<td></td>
		<td></td>
	</tr>

<?php $i++;}?>
