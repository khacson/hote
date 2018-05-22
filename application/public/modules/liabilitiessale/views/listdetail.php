<?php 
$i=1; 
$t = 0;
	print_r($details);
	foreach($details as $item){
	$t+= $item->amount;
	?>
	<tr>							
		<td class="text-center"><?=$i;?></td>								
		<td class="text-center"><?=$item->receipts_code;?></td>
		<td class="text-center"><?=$item->datepo;?></td>
		<td class="text-right"><?=fmNumber($item->amount);?></td>
		<td><?=$item->notes;?></td>
		<td><?=$item->usercreate;?></td>
		<td>
			<a id="<?=$item->id;?>" receipts_code="<?=$item->receipts_code;?>" class="btn btn-info itemPrintReceipt" href="#" >
				<i class="fa fa-print" aria-hidden="true" style="padding:0 2px;"></i>
			</a>
		</td>
	</tr>
<?php $i++;}?>
<tr>							
	<td colspan="3" class="text-center"><?=getLanguage('tong');?></td>								
	<td class="text-right"><?=fmNumber($t);?></td>
	<td></td>
	<td></td>
</tr>