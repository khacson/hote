
<?php 	
$i = $start;
$arrPay = array();
$arrPay[1] = getLanguage('tien-mat');
$arrPay[2] = getLanguage('chuyen-khoan');

foreach ($datas as $key => $item){
	if(isset($arrPay[$item->payment])){
		$payment = $arrPay[$item->payment];
	}
	else{
		$payment = "";
	} 	
	$pay_code = $item->pay_code;
	$id = $item->id;
	?>
	<tr class="content edit" 
	pay_code="<?=$item->pay_code;?>" 
	typeid="<?=$item->typeid;?>" 
	payment = "<?=$item->payment;?>" 
	branchid  = "<?=$item->branchid;?>" 
	id="<?=$item->id;?>" 
	>
		<td style="text-align: center;">
			<input id="<?=$item->id;?>" class="noClick" type="checkbox" value="<?=$item->id; ?>" name="keys[]">
		</td>
		<td style="text-align: center;"><?=$i;?></td>
		<td class="pay_code"><?=$pay_code;?></td>
		<td class="pay_type_name"><?=$item->pay_type_name;?></td>
		<td class="amount text-right"><?=number_format($item->amount);?></td>
		<td class="payment"><?=$payment;?></td>
		<td class="branch_name"><?=$item->bank_name;?></td>
		<td class="notes"><?=$item->notes;?></td>
		<td class="datepo text-center"><?=date(cfdate().' H:i:s',strtotime($item->datecreate));?></td>
		<td class="usercreate"><?=$item->usercreate;?></td>
		<td class="text-left">
			<?php if(isset($permission['edit'])){?>
				<a id="<?=$id;?>" class="btn btn-info edititem btn-icon2" href="#" data-toggle="modal" data-target="#myModalFrom">
				<i class="fa fa-pencil" aria-hidden="true"></i>
				</a>
			<?php }?>
			<?php if(isset($permission['delete'])){?>
				<a id="<?=$id;?>" class="btn btn-danger deleteitem btn-icon2" href="#" data-toggle="modal" data-target="#myModal">
				<i class="fa fa-times" aria-hidden="true"></i>
				</a>
			<?php }?>
		</td>
		<td></td>
	</tr>

<?php $i++;}?>
