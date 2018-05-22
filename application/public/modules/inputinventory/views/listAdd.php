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
	$_price+= $item->price_total;
	//satid
	?>
<tr class="tgrid" url= '<?=base_url();?>files/goods/<?=$item->img;?>'>
	<td class="stt" width="40" class="text-center"><?=$i;?></td>
	<td align="left">
		<b><?=$item->goods_code;?></b>-<?=$item->goods_name;?>
		(<?php if(!empty($item->tonkho)){echo $item->tonkho;}else{ echo 0;}?>)
		<?php if(!empty($item->img)){?>
		<img style="float:right; height:30px; cursor: pointer;" href="#" class="viewImg" src="<?=base_url();?>files/goods/<?=$item->img;?>"  />
		<?php }?>
		<input  goodid="<?=$item->id;?>" class="goodscode" type="hidden" value="<?=$item->goods_code;?>" />
		<input  goodid="<?=$item->id;?>" class="sttview" type="hidden" value="<?=$i;?>" />
		<input class="satids" type="hidden" value="<?=$item->satid;?>" />
	</td>
	<td>
	<?php if(empty($item->unit_exchange)){?>
		<select goodid="<?=$item->id;?>" class="combo" id="unitid_<?=$item->id;?>" name="unitid" style="height:28px;">
			<option value="<?=$item->unitid;?>"><?=$item->unit_name;?></option>
		</select>
	<?php }else{
		//Nếu có nhiều đơn vị thì hiển thị danh sách các đơn vị lên
		?>
		<select goodid="<?=$item->id;?>" class="combo unitid" id="unitid_<?=$item->id;?>" name="unitid" style="height:28px;">
			<option <?php if($item->satunitid == $item->unitid){?> selected <?php }?> value="<?=$item->unitid;?>"><?=$item->unit_name;?></option>
			<?php 
			$arrUnit = explode('___',$item->unit_exchange);
			foreach($arrUnit as $key=>$val){
				$arrVar = explode('::',$val);
				?>
				<option <?php if($item->satunitid == $arrVar[0]){?> selected <?php }?> value="<?=$arrVar[0];?>"><?=$arrVar[1];?></option>
			<?php }?>
		</select>
	<?php }?>
	</td>
	<td width="70"><input min="1" satid = "<?=$item->satid;?>" goodid="<?=$item->id;?>" uniqueid="<?=$item->uniqueid;?>" type="number" name="quantity" id="quantity_<?=$item->id;?>"  class="search form-control quantity text-right " value="<?=$item->quantity;?>" style="font-size:12px;"  /></td>
	<td width="100">
		<input goodid="<?=$item->id;?>" type="text" name="priceone" id="priceone_<?=$item->id;?>" placeholder="" class="search form-control priceone text-right fm-number " value="<?=fmNumber($item->price);?>" style="font-size:12px;"  />
	</td>
	<!--<td >
		<input goodid="<?=$item->id;?>" type="text" id="vat_<?=$item->id;?>" placeholder="" class="search form-control price vat text-right fm-number" value="<?=fmNumber($item->vat);?>" style="font-size:12px; float:left; width:100%;"/>
	</td>-->
	<td >
		<input goodid="<?=$item->id;?>" discount_types="<?=$item->discount_types;?>" type="text" id="discount_<?=$item->id;?>" placeholder="" class="search form-control discount text-right " value="<?=$item->discount;?>" style="font-size:12px; float:left; width:100%;"  data-toggle="tooltip"  data-container="body" title="Chiết khấu trên một đợn vị sản phẩm" 
	/>
	</td>
	<td>
		<input goodid="<?=$item->id;?>" type="text" id="xkm_<?=$item->id;?>" placeholder="" class="search form-control xuatkhuyenmai text-right " value="<?=fmNumber($item->xkm);?>" style="font-size:12px; float:left; width:100%;"/>
	</td>
	<td >
		<input goodid="<?=$item->id;?>" type="text" id="price_<?=$item->id;?>" placeholder="" class="search form-control price buyprice text-right fm-number " value="<?=fmNumber($item->price_total);?>" style="font-size:12px; float:left; width:100%;" readonly />
	</td>
	<td width="40">
		<a class="deleteItem" id="<?=$item->id;?>" detailid ="<?=$item->detailid;?>"  href="#">
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
	function getTemIDs(){
		var objReq = {};
		$(".satids").each(function(i){
			var val = $(this).val(); 
			objReq[val] = val;
		});
		return JSON.stringify(objReq);
	}
</script>