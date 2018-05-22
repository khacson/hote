
<?php 	$i = $start;
$arr = array();
$arr[1] = 'KH đại lý';
$arr[2] = 'KH lẽ';
foreach ($datas as $key => $item) { 
	if(isset($arr[$item->customer_type])){
		$customer_type = $arr[$item->customer_type];
	}
	else{
		$customer_type = '';
	}
	?>
	<tr class="content edit" >
		<td style="text-align: center;"><?=$i;?></td>
		<td class="goods_code"><?=$item->goods_code;?></td>
		<td class="goods_name"><?=$item->goods_name;?></td>
		<td class="customer_type"><?=$customer_type;?></td>
		<td class="customer_name"><?=$item->customer_name;?></td>
		<td class="price text-right"><?=number_format($item->quantity);?></td>
		<td class="price text-right"><?=number_format($item->price);?></td>
		<td></td>
	</tr>

<?php $i++;}?>
