<?php 
$i= $start;
foreach ($datas as $item) { 
	$id = $item->id;
?>

	<tr class="content edit" 
	branchid = "<?=$item->branchid;?>"
	warehouseid = "<?=$item->warehouseid;?>"
	avatar = "<?=$item->image;?>" 
	signature = "<?=$item->signature;?>" 
	companyid="<?=$item->companyid;?>"
	groupid = "<?=$item->groupid;?>"	
	id="<?=$item->id; ?>" >
		<td class="text-center">
			<?php if(isset($permission['edit'])){?>
				<a id="<?=$id;?>" class="btn btn-info edititem btn-icon btn-icon2" href="#" data-toggle="modal" data-target="#myModalFrom">
				<i class="fa fa-pencil" aria-hidden="true"></i>
				</a>
			<?php }?>
			<?php if(isset($permission['delete'])){?>
				<a id="<?=$id;?>" class="btn btn-danger deleteitem btn-icon btn-icon2" href="#" data-toggle="modal" data-target="#myModal">
				<i class="fa fa-times" aria-hidden="true"></i>
				</a>
			<?php }?>
		</td>
		<td style="text-align: center;">
		<input class="noClick" type="checkbox" name="keys[]" id="<?=$item->id; ?>"></td>
		<td class="center"><?=$i;?></td>
		<td class="uusername"><?=$item->username;?></td>
		<td class="ufullname"><?=$item->fullname;?></td>
		<td class="groupid"  ><?=$item->groupname;?></td>
		<td class="umobile"><?=$item->mobile;?></td>
		<td class="uemail"><?=$item->email;?></td>
		<td class="text-center">
			<img style="width:70px; height:45px;" src="<?=base_url();?>files/user/<?=$item->image;?>" />
		</td>
		<td class="text-center">
			<img style="width:70px; height:45px;" src="<?=base_url();?>files/user/<?=$item->signature;?>" />
		</td>
		<td><?=$item->company_name;?></td>
		<td><?=$item->branch_name;?></td>
		<td></td>
		
		<td></td>
	</tr>
<?php	
$i++;
}
?>