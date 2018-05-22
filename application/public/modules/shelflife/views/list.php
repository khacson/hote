
<?php $i = $start;
$arr = array();
$arr[1] = 'KH đại lý';
$arr[2] = 'KH lẻ';
foreach ($datas as $key => $item){ 
	$cname = $item->supplier_name;
	$phones = $item->phone;
	$caddress = $item->address;
	
	$shelflife = '';
	if(!empty($item->shelflife) && $item->shelflife != '0000-00-00' && $item->shelflife != '1970-01-01'){
		$shelflife = date(cfdate(),strtotime($item->shelflife));
	}
	?>
		<tr class="content edit" 
		id="<?=$item->id;?>" 
		goodslistid = '<?=$item->goodslistid;?>' 
		supplierid = "<?=$item->supplierid;?>" 
		supplier_name = "<?=$item->supplier_name;?>"
		>
		<td class="text-center"><input id="<?=$item->id;?>" class="check" type="checkbox" value="<?=$item->id; ?>" name="keys[]"></td>
		<td class="text-center"><?=$i;?> </td>
		<td><?=cfpn();?><?=$item->poid;?></td>
		<td><?=$item->goods_code;?></td>
		<td><?=$item->goods_name;?></td>
		<td class="text-right"><?=number_format($item->quantity);?></td>
		<td class="text-right"><?=number_format($item->priceone);?></td>
		<td class="text-right"><?=number_format($item->quantity * $item->priceone);?></td>
		<td><?=$item->unit_name;?></td>
		<td class="text-center"><?=$shelflife;?></td>
		<td class="customer_name"><?=$cname;?></td>
		<td class="customer_phone"><?=$phones;?></td>
		<td class="customer_address"><?=$caddress;?></td>
		<td></td>
	</tr>
<?php $i++;}?>
