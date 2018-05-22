<?php
	$i = $start;
	$arrPay = array();
	$arrPay[1] = 'Tiền mặt';
	$arrPay[2] = 'CK';
	$arrPay[3] = 'Thẻ';
	foreach($datas as $item){
		if(isset($arrPay[$item->payments])){
			$payments = $arrPay[$item->payments];
		}
		else{
			$payments = "";
		}
?>
	<tr class="content edit" 
	payments = "<?=$item->payments;?>" 
	warehouseid = "<?=$item->warehouseid;?>" 
	supplierid = "<?=$item->supplierid;?>"  
	id="<?=$item->id;?>" 
	uniqueid="<?=$item->uniqueid;?>">
		<td class="text-center">
			<input id="<?=$item->id;?>" class="noClick" type="checkbox" value="<?=$item->id; ?>" name="keys[]">
		</td>
		<td class="text-center"><?=$i;?></td>
		<td class="text-left"><?=$item->poid;?></td>
		<td class="text-left"><?=$item->soid;?></td>
		<td class="text-right"><?=fmNumber($item->quantity);?></td>
		<td class="text-right"><?=fmNumber($item->price);?></td>
		<td><?=$item->supplier_name;?></td>
		<td><?=$payments;?></td>
		<td><?=$item->description;?></td>
		<td><?=$item->usercreate;?></td>
		<td class="text-center"><?=date(cfdate().' H:i:s',strtotime($item->datecreate));?></td>
	</tr>

<?php $i++;}?>