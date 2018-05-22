
<?php 	$i = $start;
foreach ($datas as $key => $item) { 	
	$id = $item->id;
	?>
	<tr class="content edit" 
	provinceid="<?=$item->provinceid;?>" 
	districid="<?=$item->districid;?>" 
	count_room="<?=$item->count_room;?>" 
	count_branch="<?=$item->count_branch;?>" 
	id="<?=$item->id;?>" 
	setuppo = "<?=$item->setuppo;?>" 
	>
		
		<td style="text-align: center;">
			<input id="<?=$item->id;?>" class="noClick" type="checkbox" value="<?=$item->id; ?>" name="keys[]">
		</td>
		<td style="text-align: center;"><?=$i;?></td>
		<td class="company_name"><?=$item->company_name;?></td>
		<td class="phone"><?=$item->phone;?></td>
		<td class="mst"><?=$item->mst;?></td>
		<td class="fax"><?=$item->fax;?></td>
		<td class="email"><?=$item->email;?></td>
		<td ><img width="60" src="<?=base_url();?>files/company/<?=$item->logo;?>" /></td>
		<td class="address"><?=$item->address;?></td>
		<td><?=$item->province_name;?></td>
		<td><?=$item->distric_name;?></td>
		<td class="text-center">
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
