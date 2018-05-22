
<?php 	$i = $start;
$arr = array();
$arr[1] = 'KH đại lý';
$arr[2] = 'KH lẽ';

$arrPay = array();
$arrPay[1] = 'Tiền mặt';
$arrPay[2] = 'Chuyển khoản';
$arrPay[3] = 'Cấn trừ tiền hàng';
$arrPay[-1] = 'Khách hàng nợ';
foreach ($datas as $key => $item) { 
	if(isset($arrPay[$item->payments])){
		$payments = $arrPay[$item->payments];
	}
	else{
		$payments = "";
	}
	if(isset($arr[$item->customer_type])){
		$customer_type = $arr[$item->customer_type];
	}
	else{
		$customer_type = '';
	}
	if(!empty($item->poid)){
		$poid = 'PO'.$item->poid;
	}
	else{
		$poid = 'N/A';
	}
	?>
	<tr class="content edit" 
	id="<?=$item->id;?>" 
	
	>
		
		<td style="text-align: center;">
			<input id="<?=$item->id;?>" class="noClick" type="checkbox" value="<?=$item->id; ?>" name="keys[]">
		</td>
		<td style="text-align: center;"><?=$i;?></td>
		<td class=""><?=$poid;?></td>
		<td class="goods_code"><?=$item->goods_code;?> - <?=$item->goods_name;?></td>
		<td class="warehouse_name"><?=$item->warehouse_name;?></td>
		<td class="quantity text-center"><?=number_format($item->quantity);?></td>
		<td class="priceone text-right"><?=number_format($item->priceone);?></td>
		<td class="price text-right"><?=number_format($item->price);?></td>
		<td class="unitid"><?=$item->unit_name;?></td>
		<td class="customer_type"><?=$customer_type;?></td>
		<td class="customer_name"><?=$item->customer_name;?></td>
		<td class="customer_phone"><?=$item->customer_phone;?></td>
		<td class="employee_code"><?=$item->employee_code;?> - <?=$item->employee_name;?></td>
		<td class="customer_phone"><?=$payments;?></td>
		<td class="description"><?=$item->description;?></td>
		<td></td>
	</tr>

<?php $i++;}?>
