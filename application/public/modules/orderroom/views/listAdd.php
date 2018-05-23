<?php $i=1; 
$tt = 0;
$tck = 0;
$vat = 0;
$t_quantyty = 0;
$t_chietkhau = 0;
$t_giamsl = 0;
$_price = 0;
foreach($datas as $item){
	$vat = $item->vat;
	$t_quantyty+= $item->quantity;
	$t_chietkhau+= $item->discount_value;
	$t_giamsl+= $item->xkm;
	
	
	
	?>
<tr class="tgrid">
	<td class="stt" width="40" class="text-center"><?=$i;?></td>
	<td align="left">
		<b><?=$item->goods_code;?></b>-<?=$item->goods_name;?>
		<?php if($item->stype == 0 && !empty($item->group_code)){?>
			<br><i style="font-size:12px;">(<?=$item->group_code;?>-<?=$item->group_name;?>)</i>
		<?php }?> (<?=$item->unit_name;?>) 
		<?php if(!empty($item->img)){?>
		<img style="float:right; height:30px; cursor: pointer;" href="#" class="viewImg" src="<?=base_url();?>files/goods/<?=$item->img;?>"  />
		<?php }?>
		<input  goodid="<?=$item->id;?>" class="goodscode" type="hidden" value="<?=$item->goods_code;?>" />
		<input  goodid="<?=$item->id;?>" class="sttview" type="hidden" value="<?=$i;?>" />
		<input class="satids" type="hidden" value="<?=$item->satid;?>" />
	</td>
	<td>
	<?php if(empty($item->unit_exchange)){?>
		<select goodid="<?=$item->id;?>"  class="combo unitid" id="unitid_<?=$item->id;?>" name="unitid" style="height:28px;">
			<option value="<?=$item->unitid;?>"><?=$item->unit_name;?></option>
		</select>
	<?php }else{?>
		<select goodid="<?=$item->id;?>" class="combo unitid" id="unitid_<?=$item->id;?>" name="unitid" style="height:28px;">
			<option <?php if($item->satunitid == $item->unitid){?> selected <?php }?> value="<?=$item->unitid;?>"><?=$item->unit_name;?></option>
			<?php 
			$arrUnit = explode('___',$item->unit_exchange);
			foreach($arrUnit as $key=>$val){
				$arrVar = explode('::',$val);
				?>
				<option value="<?=$arrVar[0];?>"><?=$arrVar[1];?></option>
			<?php }?>
		</select>
	<?php }?>
	</td>
	<td width="70"><input satid = "<?=$item->satid;?>" goodid="<?=$item->id;?>" uniqueid="<?=$item->uniqueid;?>" type="number" name="quantity_<?=$item->id;?>" id="quantity_<?=$item->id;?>"  class="search form-control quantity text-right fm-number " value="<?=$item->quantity;?>" style="font-size:12px;"  /></td>
	<td width="100">
		<?php 
		$arrPrice = explode(';',$item->sale_price);	
		$priceoneFirst = $item->sale_price;
		//$discount = $item->discount;
		//$prices = $priceoneFirst * $item->quantity;
		?>
		<?php if(empty($item->sale_price) || count($arrPrice) <=1 ){?>
			<input goodid="<?=$item->id;?>" type="text" name="priceone_<?=$item->id;?>" id="priceone_<?=$item->id;?>" placeholder="" class="search form-control priceone text-right fm-number " value="<?=fmNumber($priceoneFirst);?>" style="font-size:12px;"  />
		<?php }else{
		?>
		<select 
		discount = "<?=$item->discount;?>"  
		discount_type = "<?=$item->discount_type;?>"  
		style="font-size:12px; height:28px; text-align:right;" 
		goodid="<?=$item->id;?>" name="priceone_<?=$item->id;?>" id="priceone_<?=$item->id;?>" placeholder="" class="combo priceone priceone_change">
			<?php 
			foreach($arrPrice as $kk=>$pce){
				if($priceoneFirst == $pce){
					$selected = 'selected';
					$priceoneFirsts = $arrPrice[$kk];
					//$prices = $arrPrice[$kk] * $item->quantity;
				}
				else{
					$priceoneFirsts = $arrPrice[0];
					$selected = '';
					//$prices = $priceoneFirst * $item->quantity;
				}
				?>
				<option <?=$selected;?> value="<?=$pce;?>"><?=fmNumber($pce);?></option>
			<?php }
			/*$priceoneFirst = $priceoneFirsts;
			if($item->discount_type == 1){ //Tinh %
				$discount = ($discount * $priceoneFirst)/100;
			}*/
			?>
		</select>
		<?php }?>
	</td>
	<td >
		<input goodid="<?=$item->id;?>" type="text" id="discount_<?=$item->id;?>" placeholder="" class="search form-control discount text-right fm-number" value="<?=$item->discount;?>" style="font-size:12px; float:left; width:100%;" 
	/>
	</td>
	<td>
		<input goodid="<?=$item->id;?>" type="text" id="xkm_<?=$item->id;?>" placeholder="" class="search form-control xuatkhuyenmai text-right fm-number" value="<?=fmNumber($item->xkm);?>" style="font-size:12px; float:left; width:100%;"/>
	</td>
	<td >
		<?php 
			$priceValue = 0;
			$quantity = $item->quantity;
			$xkm = 0;
			if(!empty($item->xkm)){
				$xkm = $item->xkm;
			}
			$quantityEnd = $quantity - $xkm;
			$price_total = $item->price_total;
			if(empty($item->price_total)){
				$price_total =  $quantityEnd * $priceoneFirst;
			}
			$_price+= $price_total;
		?>
		<input goodid="<?=$item->id;?>" type="text" name="price_<?=$item->id;?>" id="price_<?=$item->id;?>" class="search buyprice form-control price text-right fm-number " value="<?=fmNumber($price_total);?>" style="font-size:12px; float:left; width:100%;"  /> 
	</td>
	<td width="40">
		<a class="deleteItem" id="<?=$item->id;?>" detailid="<?=$item->satid;?>" href="#">
			<i class="fa fa-times"></i>
		</a>
	</td>
</tr>
<?php 
$i++;
}
?>
<tr>
	<td colspan="3" style="text-align:right;"><?=getLanguage('tong');?>:</td>
	<td id="tong_so_luong" style="text-align:right; padding-right:10px !important;"><?=fmNumber($t_quantyty);?></td>
	<td ></td>
	<td id="tong_ck_tien" style="text-align:right; padding-right:10px !important;"></td>
	<td id="tong_ck_soluong" style="text-align:right; padding-right:10px !important;"><?=fmNumber($t_giamsl);?></td>
	<td id="tongtienhang" style="text-align:right; padding-right:10px !important;"><?=fmNumber($_price);?></td>
	<td></td>
</tr>
<script>
	
</script>