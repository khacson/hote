
<?php 	$i = $start;
foreach ($datas as $key => $item) { 
	$id = $item->id;
	$dateinput = '';
	if(!empty($finds->dateinput) && $finds->dateinput != '0000-00-00'){
		$dateinput = date(cfdate(),strtotime($finds->dateinput));
	}
	
	?>
	<tr class="edit" id="<?=$item->id;?>" supplierid = '<?=$item->supplierid;?>'>
		<td style="text-align: center;">
			<input id="<?=$item->id;?>" class="click noClick" type="checkbox" value="<?=$item->id; ?>" name="keys[]">
		</td>
		<td style="text-align: center;"><?=$i;?></td>
		<td class="ponumber"><?=$item->ponumber?></td>
		<td><?=$dateinput;?></td>
		<td class="quantity"><?=$item->quantity?></td>
		<td class="supplier_name"><?=$item->supplier_name?></td>
		<td class="description"><?=$item->description?></td>
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
