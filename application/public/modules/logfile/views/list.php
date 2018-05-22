
<?php 	$i = $start;
foreach ($datas as $key => $item) { 	
	?>
	<tr class="edit" id="<?=$item->id;?>" >
		
		<td style="text-align: center;">
			<input id="<?=$item->id;?>" class="noClick" type="checkbox" value="<?=$item->id; ?>" name="keys[]">
		</td>
		<td style="text-align: center;"><?=$i;?></td>
		<td><?=$item->ctrol;?></td>
		<td><?=$item->description;?></td> 
		<td class="text-center">
			<?php if(!empty($item->acction_before)){?>
			<a data-toggle="modal" data-target="#myModal" class="acction_before" id="<?=$item->id;?>" href="#"><i class="fa fa-folder-open-o" aria-hidden="true"></i></a>
			<?php }?>
		</td>
		<td class="text-center">
			<?php if(!empty($item->action_after)){?>
			<a data-toggle="modal" data-target="#myModal" class="action_after" id="<?=$item->id;?>" href="#"><i class="fa fa-folder-open-o" aria-hidden="true"></i></a>
			<?php }?>
		</td>
		<td><?=$item->usercreate;?></td>
		<td><?=date('d/m/Y H:i:s',strtotime($item->datecreate));?></td>
		<td><?=$item->ipcreate;?></td>
		<td></td>
	</tr>

<?php $i++;}?>
