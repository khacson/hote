
<?php 	$i = $start;
$arr = array();

$arrPay = array();
$arrPay[1] = 'Tiền mặt';
$arrPay[2] = 'Chuyển khoản';
$arrPay[3] = 'Cấn trừ tiền hàng';
$arrPay[-1] = 'Nợ khách hàng';

$arr_status = array();
$arr_status[0] = 'Chưa thanh toán';
$arr_status[1] = 'Đã thanh toán';
$arr_status[-1] = 'Cập nhật nợ xấu';

foreach ($datas as $key => $item) { 

	?>
	<tr class="content edit" >
		<td style="text-align: center;"><?=$i;?></td>
		<td class="poid">PO<?=$item->poid;?></td>
		<td class="goods_name"><?=$item->goods_name;?></td>
		<td class="supplier_name"><?=$item->supplier_name;?></td>
		<td class="price text-right"><?=number_format($item->quantity);?></td>
		<td class="price text-right"><?=number_format($item->price);?></td>
		<td class="price text-right"><?=number_format($item->price_prepay);?></td>
		<td class="price text-right"><?=number_format($item->price - $item->price_prepay);?></td>
		<td></td>
	</tr>

<?php $i++;}?>
