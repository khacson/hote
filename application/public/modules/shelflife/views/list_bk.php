
<?php 	$i = $start;
$arr = array();
$arr[1] = 'KH đại lý';
$arr[2] = 'KH lẽ';
foreach ($datas as $key => $item) { 
	if(isset($detail[$item->uniqueid])){
		$total = count($detail[$item->uniqueid]);
	}
	else{
		$total = 1;
	}
	?>
	  <?php if($total == 1){?>
			<?php 
				foreach($detail[$item->uniqueid] as $kk=>$obj){
				?>
			<tr class="content edit" 
			id="<?=$item->id;?>" 
			goodslistid = '<?=$item->goodslistid;?>' 
			customer_id = "<?=$item->customer_id;?>" 
			employeeid = "<?=$item->employeeid;?>"
			customer_name = "<?=$item->customer_name;?>"
			customer_phone = "<?=$item->customer_phone;?>"
			customer_address = "<?=$item->customer_address;?>"
			customer_type = "<?=$item->customer_type;?>"
			>
					<td class="text-center"><input id="<?=$item->id;?>" class="check" type="checkbox" value="<?=$item->id; ?>" name="keys[]"></td>
					<td class="text-center"><?=$i;?> </td>
					<td>PO<?=$item->poid;?></td>
					<td><?=$obj->goods_code;?> - <?=$obj->goods_name;?></td>
					<td class="text-right"><?=$obj->quantity;?></td>
					<td><?=$obj->unit_name;?></td>
					<td><?=$arr[$item->customer_type];?></td>
					<td class="customer_name"><?=$item->customer_name;?></td>
					<td class="customer_phone"><?=$item->customer_phone;?></td>
					<td class="customer_address"><?=$item->customer_address;?></td>
					<td class="employee_name"><?=$item->employee_name;?></td>
					<td>
						<a class="btn btn-xs blue" onClick="print(<?=$item->id;?>)" href="#">
							<i class="fa fa-print"></i>
						</a>
					</td>
					<td>
						<a class="btn btn-xs yellow" href="<?=base_url()?>salesgoods/<?=$item->id;?>.html">
							<i class="fa fa-shopping-cart"></i>
						</a>
					</td>
				</tr>
			<?php }?>
	  <?php }else{?>
			<?php 
			$j =1;
			foreach($detail[$item->uniqueid] as $kk=>$obj){?>
			<tr class="content edit" 
			id="<?=$item->id;?>"
			goodslistid = '<?=$item->goodslistid;?>' 
			customer_id = "<?=$item->customer_id;?>" 
			employeeid = "<?=$item->employeeid;?>"
			customer_name = "<?=$item->customer_name;?>"
			customer_phone = "<?=$item->customer_phone;?>"
			customer_address = "<?=$item->customer_address;?>"
			customer_type = "<?=$item->customer_type;?>"
			>
				<?php if($j==1){?>
					<td class="text-center" rowspan="<?=$total;?>">
						<input id="<?=$item->id;?>" class="check" type="checkbox" value="<?=$item->id; ?>" name="keys[]"> 
					</td>
					<td class="text-center" rowspan="<?=$total;?>"><?=$i;?></td>
					<td rowspan="<?=$total;?>">PO<?=$item->poid;?></td>
				<?php }?>
					<td><?=$obj->goods_code;?> - <?=$obj->goods_name;?></td>
					<td class="text-right"><?=$obj->quantity;?></td>
					<td><?=$obj->unit_name;?></td>
				<?php if($j==1){?>
					<td rowspan="<?=$total;?>"><?=$arr[$item->customer_type];?></td>
					<td class="customer_name" rowspan="<?=$total;?>"><?=$item->customer_name;?></td>
					<td class="customer_phone" rowspan="<?=$total;?>"><?=$item->customer_phone;?></td>
					<td class="customer_address" rowspan="<?=$total;?>"><?=$item->customer_address;?></td>
					<td class="employee_name" rowspan="<?=$total;?>"><?=$item->employee_name;?></td>
					<td rowspan="<?=$total;?>">
						<a class="btn btn-xs blue" onClick="print(<?=$item->id;?>)" href="#">
							<i class="fa fa-print"></i>
						</a>
					</td>
					<td rowspan="<?=$total;?>">
						<a class="btn btn-xs yellow" href="<?=base_url()?>salesgoods/<?=$item->id;?>.html">
							<i class="fa fa-shopping-cart"></i>
						</a>
					</td>
				<?php }?>
			  </tr>
			<?php $j++;}?>
			  
	  <?php }?>
	  

<?php $i++;}?>
