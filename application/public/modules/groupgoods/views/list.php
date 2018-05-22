
<?php 	$i = $start;
foreach ($datas as $key => $item) { 	
	?>
	<tr class="edit" 
	idgroup = "<?=$item->id;?>" 
	unitidgroup = "<?=$item->unitidgroup;?>" 
	iddetail="<?=$item->detailid;?>" 	
	goods_code = "<?=$item->goods_code;?>" 	
	goods_name = "<?=$item->goods_name;?>" 
	groupid = "<?=$item->groupid;?>" 
	unitid = "<?=$item->unitid;?>" 
	exchang = "<?=$item->exchang;?>" 
	>
		<td style="text-align: center;">
			<input id="<?=$item->id;?>" class="noClick" type="checkbox" value="<?=$item->id; ?>" name="keys[]">
		</td>
		<td class="text-center"><?=$i;?></td>
		<td class="group_code"><?=$item->group_code;?></td>
		<td class="group_name"><?=$item->group_name;?></td>
		<td class="unit_name_group"><?=$item->unit_name_group;?></td>
		<td class="goods_code"><b><?=$item->goods_code;?></b><br><?=$item->goods_name;?></td>
		<td><?=$item->unit_name;?></td>
		<td class="exchang text-center"><?=$item->exchang;?></td>
		
		<td></td>
	</tr>

<?php $i++;}?>
