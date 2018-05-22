
<?php 	$i = $start;
foreach ($datas as $key => $item) { 
	
	if($item->config_key == 'bhxh' || $item->config_key == 'bhyt' || $item->config_key == 'bhtn'){
		$config_val = $item->config_val .'%'; 
	}
	else if($item->config_key == 'kpcd'){
		$config_val = number_format($item->config_val);
	}
	else{
		$config_val = $item->config_val;
	}
	?>
	<tr class="edit" id="<?=$item->id;?>" >
		
		<td style="text-align: center;">
			<input id="<?=$item->id;?>" class="check" type="checkbox" value="<?=$item->id; ?>" name="keys[]">
		</td>
		<td class="text-center;"><?=$i;?></td>
		<td class="description"><?=$item->description;?></td>
		<td class="config_val" id="<?=$item->config_val;?>"><?=$config_val;?></td>
		<td></td>
	</tr>

<?php $i++;}?>
