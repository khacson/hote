
<?php 	$i = $start;
$arr = array();
$arr_status = array();
$arr_pay[1] = 'Tiền mặt';
$arr_pay[2] = 'CK';
$arr_pay[3] = 'Thẻ';
foreach ($datas as $key => $item) { 
	if(!empty($item->datepo) && $item->datepo != '1970-01-01' && $item->datepo != '0000-00-00'){
		$datepo = date(cfdate(),strtotime($item->datepo));
	}
	else{
		$datepo = "";
	}
	if($item->poid != -1){
		$poid = $item->poid;
	}
	else{
		$poid = 'N/A';
	}
	$payment = '';
	if(isset($arr_pay[$item->payment])){
		$payment = $arr_pay[$item->payment];
	}
	
	?>
	<tr class="content edit" 
	uniqueid =  "<?=$item->uniqueid;?>" 
	>
		<td style="text-align: center;">
			<input id="<?=$item->id;?>" class="noClick" type="checkbox" value="<?=$item->id; ?>" name="keys[]">
		</td>
		<td style="text-align: center;"><?=$i;?></td>
		<td class="supplier_name"><?=$item->supplier_name;?></td>
		<td class="poid"><?=$poid;?></td>
		<td class="pay_code"><?=$item->pay_code;?></td>
		<td class="amount text-right"><?=fmNumber($item->amount);?></td>
		<td class="payment "><?=$payment;?></td>
		<td class="datepo text-center"><?=$datepo;?></td>
		<td class="pay_type_name"><?=$item->pay_type_name;?></td>
		<td class="notes"><?=$item->notes;?></td>
		<td class="datecreate text-center"><?=date(cfdate(). ' H:i:s',strtotime($item->datecreate));?></td>
		<td class="liabilities"><?=$item->usercreate;?></td>
		<td></td>
		
	</tr>

<?php $i++;}?>
