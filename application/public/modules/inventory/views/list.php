
<?php 	$i = $start;
foreach ($datas as $key => $item){
	
	?>
	<tr class="content edit" 
	id= "<?=$item->id;?>" 
	locationid = "<?=$item->locationid;?>" 
	goodsid = "<?=$item->goodsid;?>" 
	branchid = "<?=$item->branchid;?>" 
	warehouseid = "<?=$item->warehouseid;?>" 
	>
		<td style="text-align: center;"><?=$i;?></td>
		<td><?=$item->goods_code;?> <?=$item->goods_name;?></td>
		<td class="text-right"><?=fmNumber($item->quantity);?></td>
		<td><?=$item->unit_name;?></td>
		<td class="text-right">--</td>
		<td><?=fmNumber($item->quantitymin);?></td>
		<td><?=$item->warehouse_name;?></td>
		<td><?=$item->branch_name;?></td>
		<td class="text-left"><?=$item->location_name;?></td>
		<td>
			<?php if(!empty($item->img)){?>
				<img width="80" height="50" class="viewImg" src="<?=base_url();?>files/goods/<?=$item->img;?>" />
			<?php }?>
		</td>
		
		<td></td>
	</tr>

<?php $i++;}?>
