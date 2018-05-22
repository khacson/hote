<?php
	$i = $start;
	$arrPay = array();
	$arrPay[1] = getLanguage('tien-mat');
	$arrPay[2] = getLanguage('chuyen-khoan');
	
	foreach($datas as $item){
		if(isset($arrPay[$item->payments])){
			$payments = $arrPay[$item->payments];
		}
		else{
			$payments = "";
		}
		$conlai = $item->price - $item->price_prepay;
		if(empty($item->price_prepay)){
			$conlai = 0;
		}
		$price_prepay_type = '';
		if($item->price_prepay_type == 2){
			$price_prepay_type = '%';
		}
		$id = $item->id;
?>
	<tr class="content edit" 
	payments = "<?=$item->payments;?>" 
	warehouseid = "<?=$item->warehouseid;?>" 
	supplierid = "<?=$item->supplierid;?>"  
	id="<?=$item->id;?>" 
	uniqueid="<?=$item->uniqueid;?>">
		<td class="text-center">
			<input id="<?=$item->id;?>" class="noClick" type="checkbox" value="<?=$item->id; ?>" name="keys[]">
		</td>
		<td class="text-center"><?=$i;?></td>
		<td class="text-left">
		<?php if(isset($permission['edit']) && $login->grouptype < 4){?> 
			<a title="Sửa" href='<?=base_url();?>export/formEdit/<?=$item->id;?>.html'>
				<?=$item->poid;?>
			</a>
		<?php }else{?>
			<?=$item->poid;?>
		<?php }?>
		
		</td>
		<td><?=$item->goods_code;?></td>
		<td class="text-right"><?=fmNumber($item->quantity);?></td>
		<td class="text-right"><?=fmNumber($item->price_total);?></td>
		<td class="text-right"><?=fmNumber($item->price_prepay);?><?=$price_prepay_type;?></td>
		<td class="text-right"><?=fmNumber($item->amount);?></td>
		<td class="text-right"><?=fmNumber($item->price_total - $item->amount);?></td>
		<td><?=$item->customer_name;?></td>
		<td><?=$payments;?></td>
		<td class="text-center"><?=date(cfdate(),strtotime($item->datepo));?></td>
		<td><?=$item->description;?></td>
		<td><?=$item->usercreate;?></td>
		<td class="text-center"><?=date(cfdate().' H:i:s',strtotime($item->datecreate));?></td>
		<td class="text-left">
			<?php if(isset($permission['edit'])){?>
				<a id="<?=$id;?>" class="btn btn-info edititem" href="<?=base_url();?>export/formEdit/<?=$item->id;?>.html">
				<i class="fa fa-pencil" aria-hidden="true"></i>
				</a>
			<?php }?>
			
		</td>
		<td></td>
	</tr>

<?php $i++;}?>