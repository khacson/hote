
<?php 	$i = $start;
foreach ($datas as $key => $item) { 	
	$id = $item->id;
	?>
	<tr class="content edit" provinceid="<?=$item->provinceid;?>" districid="<?=$item->districid;?>" id="<?=$item->id;?>" 
	
	>
		
		<td style="text-align: center;">
			<input id="<?=$item->id;?>" class="noClick" type="checkbox" value="<?=$item->id; ?>" name="keys[]">
		</td>
		<td style="text-align: center;"><?=$i;?></td>
		<td class="branch_name"><?=$item->branch_name?></td>
		<td class="phone"><?=$item->phone?></td>
		<td class="fax"><?=$item->fax?></td>
		<td class="email"><?=$item->email?></td>
		<td class="address"><?=$item->address?></td>
		<td class="name_contact"><?=$item->name_contact?></td>
		<td class="text-left">
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
