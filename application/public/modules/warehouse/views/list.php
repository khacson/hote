
<?php 	$i = $start;
foreach ($datas as $key => $item) { 	
	$id = $item->id;
	$isdedault = '';
	if(!empty($item->isdedault)){
		$isdedault = '<i style="color:#0090d9;" class="fa fa-check" aria-hidden="true"></i>';
	}
	?>
	<tr class="content edit" id="<?=$item->id;?>" 
	branchid = "<?=$item->branchid;?>"
	>
		
		<td style="text-align: center;">
			<input id="<?=$item->id;?>" class="noClick" type="checkbox" value="<?=$item->id; ?>" name="keys[]">
		</td>
		<td style="text-align: center;"><?=$i;?></td>
		<td class="warehouse_name"><?=$item->warehouse_name;?></td>
		<td class="phone"><?=$item->phone;?></td>
		<td class="name_contact"><?=$item->name_contact;?></td>
		<td class="address"><?=$item->address?></td>
		<td class="branch_name"><?=$item->branch_name;?></td>
		<td class="text-center"><?=$isdedault;?></td>
		<td class="text-center">
			<?php if(isset($permission['edit'])){?>
				<a id="<?=$id;?>" class="btn btn-info edititem" href="#" data-toggle="modal" data-target="#myModalFrom">
				<i class="fa fa-pencil" aria-hidden="true"></i>
				</a>
			<?php }?>
			<?php if(isset($permission['delete'])){?>
				<a id="<?=$id;?>" class="btn btn-danger deleteitem" href="#" data-toggle="modal" data-target="#myModal">
				<i class="fa fa-times" aria-hidden="true"></i>
				</a>
			<?php }?>
		</td>
		<td></td>
	</tr>

<?php $i++;}?>
