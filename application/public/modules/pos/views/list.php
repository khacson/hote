
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
	if(isset($arr[$item->customer_type])){
		$customer_type = $arr[$item->customer_type];
	}
	else{
		$customer_type = '';
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
			goodslistid = '<?=$item->goodslistid;?>' 
			customer_id = "<?=$item->customer_id;?>" 
			employeeid = "<?=$item->employeeid;?>"
			customer_name = "<?=$cname;?>"
			customer_phone = "<?=$cphone;?>"
			customer_address = "<?=$caddress;?>"
			customer_type = "<?=$item->customer_type;?>"
			>
		<td class="text-center"><input id="<?=$item->id;?>" class="noClick" type="checkbox" value="<?=$item->id; ?>" name="keys[]"></td>
		<td class="text-center"><?=$i;?> </td>
		<td><a href="<?=base_url();?>export/formEdit/<?=$item->uniqueid;?>/<?=$socode;?>.html"><?=$item->poid;?></a></td>
		<td><?=$socode;?></td>
		<td class="text-right"><?=fmNumber($item->quantity);?></td>
		<td class="text-right"><?=fmNumber($item->price_total);?></td>
		<td class="text-right"><?=fmNumber($item->price_prepay);?></td>
		<td class="text-right"><?=fmNumber($conlai);?></td>
		<td class="text-right"><?=$item->vat;?></td>
		<td class="text-right"><?=fmNumber($item->discount);?></td>
		<td><?=$cname;?></td>
		<td><?=$item->usercreate;?></td>
		<td class="text-center"><?=date(cfdate().' H:i:s',strtotime($item->datecreate));?></td>
	</tr>
<?php $i++;}?>
