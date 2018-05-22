
<?php 	$i = $start;
$arr = array();
$arr[1] = 'KH đại lý';
$arr[0] = 'KH lẻ';

foreach ($datas as $key => $item) { 
	if(isset($detail[$item->uniqueid])){
		$total = count($detail[$item->uniqueid]);
	}
	else{
		$total = 1;
	}
	
	$socode = '';
	if(!empty($item->socode)){
		$socode = $item->socode;;
	}
	$conlai = $item->price_total - $item->price_prepay;
	if(empty($item->price_prepay)){
		$conlai = 0;
	}
	?>
			<tr class="content edit" 
			id="<?=$item->id;?>" 
			customer_id = "<?=$item->customer_id;?>" 
			>
		<td class="text-center"><?=$i;?> </td>
		<td><?=$item->goods_code;?></td>
		<td><?=$item->goods_name;?></td>
		<td class="text-right"><?=fmNumber($item->quantity);?></td>
		<td class="text-right"><?=fmNumber($item->discount);?></td>
		<td class="text-right"><?=fmNumber($item->vat + $item->price);?></td>
		<td><?=$item->cname;?></td>
		<td><?=$item->usercreate;?></td>
		<td class="text-center"><?=date(cfdate().' H:i:s',strtotime($item->datecreate));?></td>
	</tr>
<?php $i++;}?>
