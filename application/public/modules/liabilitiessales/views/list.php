
<?php 	
$i = $start;
$arr = array();
$arr[1] = 'Khách hàng đại lý';
$arr[0] = 'Khách hàng lẻ';
$arrPay = array();
foreach ($datas as $key => $item) { 
	if(!empty($item->maturitydate)){
		$maturitydate = date(cfdate(),strtotime($item->maturitydate));
	}
	else{
		$maturitydate = "";
	}
	if(isset($arr_status[$item->payments_status])){
		$payments_status = $arr_status[$item->payments_status];
	}
	else{
		$payments_status = '';
	}
	if(!empty($item->poid)){
		$poid = $item->poid;
	}
	else{
		$poid = 'N/A';
	}
	if(isset($arr[$item->customer_type])){
		$customer_type = $arr[$item->customer_type];
	}
	else{
		$customer_type = "";
	}
	if($item->customer_type == 0){
		$cname = $item->customer_name;
		$caddress = $item->customer_address;
		$cphone = $item->customer_phone;
		$cemail = $item->customer_email;
	}
	else{
		$cname = $item->cmname;
		$caddress = $item->cmaddress;
		$cphone = $item->cmphone;
		$cemail = $item->cmemail;
	}
	?>
	<tr class="content edit" 
	customer_id="<?=$item->customer_id;?>" 
	customer_type ="<?=$item->customer_type;?>"
	payments_status ="<?=$item->payments_status;?>"
	payments ="<?=$item->payments;?>"
	poid ="<?=$item->poid;?>"
	price_cl ="<?=($item->price_total - $item->price_prepay);?>"
	id="<?=$item->id;?>" 
	
	>
		
		<td style="text-align: center;">
			<input id="<?=$item->id;?>" class="noClick" type="checkbox" value="<?=$item->id; ?>" name="keys[]">
		</td>
		<td style="text-align: center;"><?=$i;?></td>
		<td class="">
		<a title="Xem chi tiết đơn hàng" id="<?=$item->id;?>" class="oderDetail" data-toggle="modal" data-target="#myFrom" href="#">
			<?=$poid;?>
		</a>
		</td>
		<td class="goods_code"><?=$item->goods_name;?></td>
		<td class="quantity text-right"><?=fmNumber($item->quantity);?></td>
		<td class="price text-right"><?=fmNumber($item->price_total);?></td>
		<td class="price_prepay text-right"><?=fmNumber($item->price_prepay);?></td>
		<td class="text-right"><?=fmNumber($item->price_total - $item->price_prepay);?></td>
		<td class="customer_type"><?=$customer_type;?></td>
		<td class="customer_name"><?=$cname;?></td>
		<td class="maturitydate text-center"><?=$maturitydate;?></td>
		<td class="payments_status"><?=$payments_status;?></td>
		<td></td>
	</tr>

<?php $i++;}?>
