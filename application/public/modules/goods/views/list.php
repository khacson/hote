
<?php 	$i = $start;
$array = array();
$array[1] = '%';
$array[2] = configs()['currency'];

foreach ($datas as $key => $item) { 	
	
	$shelflife = 'Không';
	if($item->shelflife == 1){
		$shelflife = 'Có';
	}
	$arr_s = explode(';',$item->sale_price);
	if(count($arr_s) <= 1){
		$sale_price = fmNumber($item->sale_price);
	}
	else{
		$sale_price = '';
		foreach($arr_s as $kk=>$vv){
			$sale_price.= fmNumber($vv).'<br>';
		}
		//$sale_price = substr($sale_price,1);
	}
	$id = $item->id;
	?>
	<tr class="edit" id="<?=$item->id;?>" 
	goods_type="<?=$item->goods_type;?>" 
	
	discountsales="<?=$item->discountsales;?>"
	
	
	unitid="<?=$item->unitid;?>"
	isserial="<?=$item->isserial;?>"
	shelflife  = "<?=$item->shelflife;?>"
	sale_price = "<?=$item->sale_price;?>"
	isnegative = "<?=$item->isnegative;?>" 
	exchange_unit = "<?=$item->exchange_unit;?>" 
	>
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
		<td style="text-align: center;">
			<input id="<?=$item->id;?>" class="noClick" type="checkbox" value="<?=$item->id; ?>" name="keys[]">
		</td>
		<td class="text-center"><?=$i;?></td>
		<td class="goods_code"><?=$item->goods_code;?></td>
		<td class="goods_name"><?=$item->goods_name;?></td>
		<td class="goods_tye_name"><?=$item->goods_tye_name;?></td>
		<td class="unit_name"><?=$item->unit_name;?></td>
		<td class="unit_name"><?=$item->unit_name_active;?></td>
		<td class="text-center">
			<img id="<?=$item->img;?>"  class="viewImg"  alt="N/A" width="60" height="50" src="<?=base_url();?>files/goods/<?=$item->img;?>">
		</td>
		<td class="buy_price text-right"><?=fmNumber($item->buy_price);?></td>
		<td class="sale_price text-right"><?=$sale_price;?></td>
		<td class="madein"><?=$item->madein;?></td>
		<td class="description"><?=$item->description;?></td>
		<td class="text-right quantitymin" ><?=$item->quantitymin;?></td>
		<td class="exchange_unit"><?=$item->exchanges;?></td>
		<td></td>
	</tr>

<?php $i++;}?>
