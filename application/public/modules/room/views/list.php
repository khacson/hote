
<?php 	$i = $start;
foreach ($datas as $key => $item) { 
	$id = $item->id;
	
	?>
	<tr class="edit" id="<?=$item->id;?>" >
		
		<td style="text-align: center;">
			<input id="<?=$item->id;?>" class="noClick" type="checkbox" value="<?=$item->id; ?>" name="keys[]">
		</td>
		<td class="text-center"><?=$i;?></td>
		<td class="bank_code"><?=$item->room_name;?></td>
		<td class="roomtype_name"><?=$item->roomtype_name;?></td>
		<td class="count_person text-right"><?=number_format($item->price);?></td>
		<td class="price_hour text-right"><?=number_format($item->price_hour);?></td>
		<td class="price_hour_next text-right"><?=number_format($item->price_hour_next);?></td>
		<td class="price_week text-right"><?=number_format($item->price_week);?></td>
		<td class="price_month text-right"><?=number_format($item->price_month);?></td>
		<td class="description "><?=$item->description;?></td>
		<td class="floor_name "><?=$item->floor_name;?></td>
		<td class="branch_name "><?=$item->branch_name;?></td>
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
