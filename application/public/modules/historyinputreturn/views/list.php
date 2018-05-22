<?php
	$i = $start;
	$arrPay = array();
	$arrPay[1] = 'Tiền mặt';
	$arrPay[2] = 'CK';
	$arrPay[3] = 'Thẻ';
	
	foreach($datas as $item){
		if(isset($arrPay[$item->payments])){
			$payments = $arrPay[$item->payments];
		}
		else{
			$payments = "";
		}
		//$conlai = $item->price - $item->price_prepay;
		//if(empty($item->price_prepay)){
		//	$conlai = 0;
		//}
?>
	<tr class="content edit" 
	payments = "<?=$item->payments;?>" 
	customerid = "<?=$item->customerid;?>"  
	id="<?=$item->id;?>" 
	uniqueid="<?=$item->uniqueid;?>">
		<td class="text-center">
			<input id="<?=$item->id;?>" class="noClick" type="checkbox" value="<?=$item->id; ?>" name="keys[]">
		</td>
		<td class="text-center"><?=$i;?></td>
		<td class="text-left">
		<?php if(isset($permission['edit'])){?>
			<a title="Sửa" href='<?=base_url();?>inputinventory/editInput/<?=$item->id;?>.html'><?=$item->poid;?></a>
		<?php }else{?>
			<?=$item->poid;?>
		<?php }?>
		</td>
		<td><?=$item->goods_code;?></td>
		<td class="text-right"><?=fmNumber($item->quantity);?></td>
		<td class="text-right"><?=fmNumber($item->price);?></td>
		<td><?=$item->customer_name;?></td>
		<td><?=$payments;?></td>
		<td class="text-center"><?=date(cfdate(),strtotime($item->datepo));?></td>
		<td><?=$item->description;?></td>
		<td><?=$item->usercreate;?></td>
		<td class="text-center"><?=date(cfdate().' H:i:s',strtotime($item->datecreate));?></td>
	</tr>

<?php $i++;}?>