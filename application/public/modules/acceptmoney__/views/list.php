
<?php 	$i = $start;
foreach ($datas as $item){ 
	$id = $item->id;	
	?>
	<tr class="content edit" 
	id="<?=$id;?>" 
	catalogid="<?=$item->catalogid;?>" 
	useraceptid="<?=$item->useraceptid;?>" 
	branchid="<?=$item->branchid;?>" 
	>
		<td class="text-center">
			<input id="<?=$id;?>" class="check noClick" type="checkbox" value="<?=$id; ?>" name="keys[]">
		</td>
		<td class="text-center"><?=$i;?></td>
		<td class="fullname"><?=$item->fullname;?></td>
		<td class="pfullname"><?=$item->pfullname;?></td>
		<td class="money text-right"><?=number_format($item->money);?></td>
		<td class="datepay text-center"><?=date(configs('cfdate').' H:i',strtotime($item->datecreate));?></td>
		<td class="description"><?=$item->description;?></td>
		<td><?=$item->branch_name;?></td>
		<td class="text-center">
			<?php
			if(isset($permission['edit'])){?>
				<a id="<?=$id;?>" class="btn btn-info edititem" href="#" data-toggle="modal" data-target="#myModalFrom">
				<i class="fa fa-pencil" aria-hidden="true"></i>
				</a>
			<?php }?>
			<?php if(isset($permission['delete'])){?>
				<a id="<?=$id;?>" class="btn btn-danger deleteitem mleft10" href="#" data-toggle="modal" data-target="#myModal">
				<i class="fa fa-times" aria-hidden="true"></i>
				</a>
			<?php }?>
		</td>
		<td></td>
	</tr>

<?php $i++;}?>
