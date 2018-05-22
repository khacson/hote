
<?php 	$i = $start;
$arrGropType = array();
$arrGropType[1] = getLanguage('rot');
$arrGropType[2] = getLanguage('admin');
$arrGropType[3] = getLanguage('quan-ly');
$arrGropType[4] = getLanguage('nhan-vien');
$arrGropType[5] = getLanguage('nhan-vien-ban-hang');
foreach ($datas as $item) { 
	$id = $item->id;
	$grouptype = '';
	if(isset($arrGropType[$item->grouptype])){
		$grouptype = $arrGropType[$item->grouptype];
	}
	?>
	<tr class="content edit" id="<?=$item->id;?>" grouptype = "<?=$item->grouptype;?>" companyid = "<?=$item->companyid;?>" >
		
		<td style="text-align: center;">
			<input id="<?=$item->id;?>" class="check noClick" type="checkbox" value="<?=$id; ?>" name="keys[]">
		</td>
		<td style="text-align: center;"><?=$i;?></td>
		<td class="groupname"><?=$item->groupname;?></td>
		<td class="grouptype"><?=$grouptype;?></td>
		<td class="companyname"><?=$item->companyname;?></td>
			<td class="center permission" id="<?=$id;?>">
			<a id="<?=$id;?>" class="btn btn-info rights" href="#" data-toggle="modal" data-target="#myModalFromRight">
				<i class="fa fa-gears"></i>
			</a>
		</td>
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
