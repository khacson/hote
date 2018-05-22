
<?php 	$i = $start;
$arr = array();
$arr[1] = 'Khách hàng đại lý';
$arr[2] = 'Khách hàng lẽ';

$arrPay = array();
$arrPay[1] = 'Tiền mặt';
$arrPay[2] = 'Chuyển khoản';
$arrPay[3] = 'Cấn trừ tiền hàng';
$arrPay[-1] = 'Nợ khách hàng';

$arr_status = array();
$arr_status[0] = 'Chưa thanh toán';
$arr_status[1] = 'Đã thanh toán';
$arr_status[-1] = 'Nợ xấu';
foreach ($datas as $key => $item) { 

	if(isset($arrPay[$item->payments_status])){
		$payments = $arrPay[$item->payments_status];
	}
	else{
		$payments = "";
	}
	if(!empty($item->maturitydate)){
		$maturitydate = date('d-m-Y',strtotime($item->maturitydate));
	}
	else{
		$maturitydate = "";
	}
	
	if(isset($arr_status[$item->payments_status])){
		$payments_status = '';//$arr_status[$item->payments_status];
	}
	else{
		$payments_status = '';
	}
	?>
	<tr class="content edit" 
	supplierid="<?=$item->supplierid;?>" 
	warehouseid="<?=$item->warehouseid;?>"
	goodsid="<?=$item->goodsid;?>"
	unitid="<?=$item->unitid;?>"
	payments ="<?=$item->payments;?>"
	id="<?=$item->id;?>" 
	
	>
		
		<td style="text-align: center;">
			<input id="<?=$item->id;?>" class="noClick" type="checkbox" value="<?=$item->id; ?>" name="keys[]">
		</td>
		<td style="text-align: center;"><?=$i;?></td>
		<td class="goods_code"><?=$item->goods_code;?> - <?=$item->goods_name;?></td>
		<td class="supplier_name"><?=$item->supplier_name;?></td>
		<td class="warehouse_name"><?=$item->warehouse_name;?></td>
		<td class="quantity text-center"><?=number_format($item->quantity);?></td>
		<td class="priceone text-right"><?=number_format($item->priceone);?></td>
		<td class="price text-right"><?=number_format($item->price);?></td>
		<td class="unitid"><?=$item->unit_name;?></td>
		<td class="maturitydate text-center"><?=$maturitydate;?></td>
		<td class="payments_status"><?=$payments_status;?></td>
		<td class="description"><?=$item->description;?></td>
		<td class="usercreate"><?=$item->usercreate;?></td>
		<td class="datecreate"><?=date('d-m-Y H:i:s',strtotime($item->datecreate));?></td>
		<td></td>
	</tr>

<?php $i++;}?>
