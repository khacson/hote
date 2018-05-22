
<?php 	$i = $start;
foreach ($datas as $key => $item) { 
	$price = $item->price - $item->discount;
	?>
			<tr class="content edit" 
			id="<?=$item->id;?>" 
			customer_id = "<?=$item->customer_id;?>" 
			>
		<td class="text-center"><?=$i;?> </td>
		<td><?=$item->poid;?></td>
		<td><?=$item->goods_code;?> - <?=$item->goods_name;?></td>
		<td class="text-right"><?=fmNumber($item->quantity + $item->cksp);?></td>
		<td class="text-right"><?=fmNumber($item->discount);?></td>
		<td class="text-right"><?=fmNumber($price);?></td>
		<td class="text-right"><?=fmNumber($item->discountsales);?></td>
		<td><?=$item->employee_code;?> - <?=$item->employee_name;?></td>
		<td><?=$item->cname;?></td>
		<td><?=$item->usercreate;?></td>
		<td class="text-center"><?=date(cfdate().' H:i:s',strtotime($item->datecreate));?></td>
	</tr>
<?php $i++;}?>
