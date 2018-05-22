
<?php 	$i = $start;
$arr = array();
foreach ($datas as $key => $item) { 
	if(!empty($item->datecreate) && $item->datecreate != '1970-01-01' && $item->datecreate != '0000-00-00'){
		$datecreate = date(cfdate().' H:i:s',strtotime($item->datecreate));
	}
	else{
		$datecreate = "";
	}
	if($item->payment == 1){
		$payment = getLanguage('tien-mat');
	}
	else{
		$payment = getLanguage('chuyen-khoan');
	}
	?>
	<tr class="content edit" 
	supplierid="<?=$item->supplierid;?>" 
	receipts_code = "<?=$item->receipts_code;?>" 
	id="<?=$item->id;?>" 
	>
		<td style="text-align: center;">
			<input id="<?=$item->id;?>" class="noClick" type="checkbox" value="<?=$item->id; ?>" name="keys[]">
		</td>
		<td class="text-center"><?=$i;?></td>
		<td class="customer_name"><?=$item->customer_name;?></td>
		<td class="poid"><?=$item->poid;?></td>
		<td class="receipts_code"><?=$item->receipts_code;?></td>
		<td class="amount text-right"><?=fmNumber($item->amount);?></td>
		<td class="payment"><?=$payment;?></td>
		<td class="bank_name"><?=$item->bank_name;?></td>
		<td class="datecreate text-center"><?=$datecreate;?></td>
		<td class="bank_name"><?=$item->usercreate;?></td>
		<td></td>
	</tr>

<?php $i++;}?>
