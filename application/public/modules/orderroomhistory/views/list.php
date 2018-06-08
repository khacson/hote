
<?php 	$i = $start;
foreach ($datas as $key => $item) { 
	$id = $item->id;
	$pricetype = "";
	if(isset($priceType[$item->price_type])){
		$pricetype = $priceType[$item->price_type];
	}
	$timStart = $item->fromdate;
	$timEnd = $item->todate;
	if($item->isnew == 1){
		$timEnd = $timeNow;
		
	}
	$time = $this->base_model->timeStamp($timStart,$timEnd);
	
	?>
	<tr class="edit" id="<?=$item->id;?>" >
		
		<td style="text-align: center;">
			<input id="<?=$item->id;?>" class="noClick" type="checkbox" value="<?=$item->id; ?>" name="keys[]">
		</td>
		<td class="text-center"><?=$i;?></td>
		<td class="room_name"><?=$item->room_name;?></td>
		<td class="roomtype_name"><?=$item->roomtype_name;?></td>
		<td class="fromdate text-center"><?=date(cfdate().' H:i',strtotime($item->fromdate));?></td>
		<td class="todate text-center"><?=date(cfdate().' H:i',strtotime($timEnd));?></td>
		<td class="text-center" style="color:#2a6496;"><?=$time;?></td>
		<td class="branch_name" ><?=$pricetype;?></td>
		<td class="text-right"><?=number_format($item->price);?></td>
		<td class="text-center">
			<a id="<?=$id;?>" roomname="<?=$item->room_name;?>" class="btn btn-info edititem btn-icon2" href="#" data-toggle="modal" data-target="#myModalFrom">
				<?=$item->total;?>
			</a>
		</td>
		<td><?=$item->customer_name;?></td>
		<td><?=$item->customer_cmnd;?></td>
		<td><?=$item->customer_phone;?></td>
		<td><?=$item->description;?></td>
		<td><?=$item->branch_name;?></td>
		<td class="text-left">
			<?php if(isset($permission['delete'])){?>
				<a id="<?=$id;?>" class="btn btn-danger deleteitem btn-icon2" href="#" data-toggle="modal" data-target="#myModal">
				<i class="fa fa-times" aria-hidden="true"></i>
				</a>
			<?php }?>
		</td>
		<td></td>
	</tr>

<?php $i++;}?>
