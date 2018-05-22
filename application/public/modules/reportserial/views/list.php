
<?php $i = $start;
$arr = array();
$arr[1] = 'KH đại lý';
$arr[2] = 'KH lẻ';
foreach ($datas as $key => $item){ 
	$guarantee = '';
	if(!empty($item->guarantee) && $item->guarantee != '0000-00-00' && $item->guarantee != '1970-01-01'){
		$guarantee = date(cfdate(),strtotime($item->guarantee));
	}
	?>
		<tr class="content edit" 
		id="<?=$item->id;?>" 
		customer_id = "<?=$item->customer_id;?>" 
		employeeid = ""
		goodslistid = ""
		customer_name = "<?=$item->customer_name;?>"
		>
		<td class="text-center"><input id="<?=$item->id;?>" class="check" type="checkbox" value="<?=$item->id; ?>" name="keys[]"></td>
		<td class="text-center"><?=$i;?> </td>
		<td><?=$item->poid;?></td>
		<td><?=$item->goods_code;?></td>
		<td><?=$item->goods_name;?></td>
		<td class="text-right"><?=number_format($item->quantity);?></td>
		<td class="text-right"><?=number_format($item->priceone);?></td>
		<td class="text-right"><?=number_format($item->quantity * $item->priceone);?></td>
		<td><?=$item->unit_name;?></td>
		<td class="text-center"><?=$guarantee;?></td>
		<td><?=$item->serial_number;?></td>
		<td class="customer_name"><?=$item->customer_name;?></td>
		<td class="customer_phone"><?=$item->phones;?></td>
		<td class="customer_address"><?=$item->caddress;?></td>
		<td class="employee_code"><?=$item->employee_code;?></td>
		<td class="employee_name"><?=$item->employee_name;?></td>
		<td></td>
	</tr>
<?php $i++;}?>
