
<?php 	$i = $start;
$arr = array();
$arr[1] = 'KH đại lý';
$arr[0] = 'KH lẻ';
function encode($id) {
  $id_str = (string) $id;
  $offset = rand(0, 9);
  $encoded = chr(79 + $offset);
  for ($i = 0, $len = strlen($id_str); $i < $len; ++$i) {
    $encoded .= chr(65 + $id_str[$i] + $offset);
  }
  return $encoded;
}
foreach ($datas as $key => $item) { 
	if(isset($detail[$item->uniqueid])){
		$total = count($detail[$item->uniqueid]);
	}
	else{
		$total = 1;
	}
	$idencode = encode($item->id); 
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
	?>
	  <?php if($total == 1 && isset($detail[$item->uniqueid])){?>
			<?php 
				foreach($detail[$item->uniqueid] as $kk=>$obj){
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
					<td><a href="<?=base_url();?>salesgoods/formEdit/<?=$item->uniqueid;?>.html"><?=$item->poid;?></a></td>
					<td><?=$obj->goods_code;?> - <?=$obj->goods_name;?></td>
					<td class="text-right"><?=fmNumber($obj->quantity);?></td>
					<td class="text-right"><?=fmNumber($obj->priceone);?></td>
					<td class="text-right"><?=fmNumber($obj->priceone * $obj->quantity);?></td>
					<td><?=$obj->unit_name;?></td>
					<td><?=$customer_type;?></td>
					<td class="customer_name"><?=$cname;?></td>
					<td class="customer_phone"><?=$cphone;?></td>
					<td class="customer_address"><?=$caddress;?></td>
					<td class="employee_name"><?=$item->employee_name;?></td>
					
				</tr>
			<?php }?>
	  <?php }else{?>
			<?php 
			$j =1;
			if(!isset($detail[$item->uniqueid])){
				continue;
			}
			foreach($detail[$item->uniqueid] as $kk=>$obj){?>
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
				<?php if($j==1){?>
					<td class="text-center" rowspan="<?=$total;?>">
						<input id="<?=$item->id;?>" class="noClick" type="checkbox" value="<?=$item->id; ?>" name="keys[]"> 
					</td>
					<td class="text-center" rowspan="<?=$total;?>"><?=$i;?></td>
					<td rowspan="<?=$total;?>"><a href="<?=base_url();?>salesgoods/formEdit/<?=$item->uniqueid;?>.html"><?=$item->poid;?></a></td>
				<?php }?>
					<td><?=$obj->goods_code;?> - <?=$obj->goods_name;?></td>
					<td class="text-right"><?=fmNumber($obj->quantity);?></td>
					<td class="text-right"><?=fmNumber($obj->priceone);?></td>
					<td class="text-right"><?=fmNumber($obj->priceone * $obj->quantity);?></td>
					<td><?=$obj->unit_name;?></td>
				<?php if($j==1){?>
					<td rowspan="<?=$total;?>"><?=$customer_type;?></td>
					<td rowspan="<?=$total;?>" class="customer_name"><?=$cname;?></td>
					<td rowspan="<?=$total;?>" class="customer_phone"><?=$cphone;?></td>
					<td rowspan="<?=$total;?>" class="customer_address"><?=$caddress;?></td>
					<td class="employee_name" rowspan="<?=$total;?>"><?=$item->employee_name;?></td>
				<?php }?>
			  </tr>
			<?php $j++;}?>
			  
	  <?php }?>
	  

<?php $i++;}?>
