<?php 
$i= $start;
foreach ($datas as $item) { 
?>

	<tr class="content edit" id="<?=$item->id; ?>" >
		<td style="text-align: center;">
		<input class="noClick" type="checkbox" name="keys[]" id="<?=$item->id; ?>"></td>
		<td class="center"><?=$i;?></td>
		<td class="datecreate text-center"><a href="<?=base_url()?>backup/<?=$item->dbname;?>.zip"><?=date('d-M-Y H:i:s',strtotime($item->datecreate));?></a></td>
		<td class="usercreate"><?=$item->usercreate;?></td>
		<td></td>
	</tr>
<?php	
$i++;
}
?>