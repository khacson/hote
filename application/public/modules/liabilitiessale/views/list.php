
<?php 	$i = $start;
foreach ($datas as $key => $item){
	$id = $item->id;
	$expirationdate = '';
	if($item->expirationdate != '0000-00-00'){
		$expirationdate = date(cfdate(),strtotime($item->expirationdate));
	}
	?>
	<tr class="content edit" customerid="<?=$item->customerid;?>" id="<?=$item->id;?>" 
	
	>
		
		<td class="text-center">
			<input id="<?=$item->id;?>" class="noClick" type="checkbox" value="<?=$item->id; ?>" name="keys[]">
		</td>
		<td class="text-center"><?=$i;?></td>
		<td class="customer_name"><?=$item->customer_name;?></td>
		<td class="price text-right"><?=fmNumber($item->price);?></td>
		<td class="text-right"><?=fmNumber($item->da_thanh_toan);?></td>
		<td class="text-right"><?=fmNumber(($item->price) - ($item->da_thanh_toan));?></td>
		<td class="expirationdate text-center"><?=$expirationdate;?></td>
		<td class="description"><?=$item->description?></td>
		<td class="text-center">
			<?php if(isset($permission['edit'])){?>
				<!--<a id="<?=$id;?>" class="btn btn-info payitem" href="#" data-toggle="modal" data-target="#myModalFromPay">
				<i class="fa fa-usd" aria-hidden="true" style="padding:0 2px;"></i>
				</a>-->
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
