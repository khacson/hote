
<?php 	$i = $start;
foreach ($datas as $key => $item){
	$id = $item->id;
	if($item->birthday != '0000-00-00' && !empty($item->birthday)){
		$birthday = date(cfdate(),strtotime($item->birthday));
	}
	else{
		$birthday = '';
	}
	?>
	<tr class="content edit" 
	birthday = '<?=$birthday;?>'
	checkprint = "0" provinceid="<?=$item->provinceid;?>" id="<?=$item->id;?>" 
	
	>
		
		<td style="text-align: center;">
			<input id="<?=$item->id;?>" class="noClick" type="checkbox" value="<?=$item->id; ?>" name="keys[]">
		</td>
		<td style="text-align: center;"><?=$i;?></td>
		<td class="supplier_code"><?=$item->supplier_code;?></td>
		<td class="supplier_name"><?=$item->supplier_name;?></td>
		<td class="phone"><?=$item->phone;?></td>
		<td class="fax"><?=$item->fax;?></td>
		<td class="email"><?=$item->email;?></td>
		<td class="address"><?=$item->address;?></td>
		<td><?=$item->province_name;?></td>
		<td class="taxcode"><?=$item->taxcode;?></td>
		<td class="bankcode"><?=$item->bankcode;?></td>
		<td class="bankname"><?=$item->bankname;?></td>
		<td class="contact_name"><?=$item->contact_name;?></td>
		<td class="contact_phone"><?=$item->contact_phone;?></td>
		<td class="text-center"><?=$birthday;?></td>
		<td class="customertype_name"><?=$item->activefields_name;?></td>
		<td class="customertype_name"><?=$item->ownertype_name;?></td>
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
