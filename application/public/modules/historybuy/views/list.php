
<?php 	$i = $start;
$arr = array();
$arr[1] = 'KH đại lý';
$arr[2] = 'KH lẽ';

$arrPay = array();
$arrPay[1] = 'Tiền mặt';
$arrPay[2] = 'Chuyển khoản';
$arrPay[3] = 'Cấn trừ tiền hàng';
$arrPay[-1] = 'Nợ khách hàng';
foreach ($datas as $key => $item) { 

	$payments = "";
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
			<input id="<?=$item->id;?>" class="check" type="checkbox" value="<?=$item->id; ?>" name="keys[]">
		</td>
		<td style="text-align: center;"><?=$i;?></td>
		<td class="poid">PO<?=$item->poid;?></td>
		<td class="goods_code"><?=$item->goods_code;?> - <?=$item->goods_name;?></td>
		<td class="supplier_name"><?=$item->supplier_name;?></td>
		<td class="warehouse_name"><?=$item->warehouse_name;?></td>
		<td class="quantity text-center"><?=number_format($item->quantity);?></td>
		<td class="priceone text-right"><?=number_format($item->priceone);?></td>
		<td class="price text-right"><?=number_format($item->price);?></td>
		<td class="unitid"><?=$item->unit_name;?></td>
		<td class="customer_phone"><?=$payments;?></td>
		<td class="description"></td>
		<td class="usercreate"><?=$item->usercreate;?></td>
		<td class="datecreate text-center"><?=date('d-m-Y H:i:s',strtotime($item->datecreate));?></td>
		<td></td>
	</tr>

<?php $i++;}?>
