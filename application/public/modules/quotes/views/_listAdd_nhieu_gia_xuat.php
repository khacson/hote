<?php $i=1; 
$tt = 0;
$tck = 0;
$vat = 0;
foreach($datas as $item){
	$vat = $item->vat;
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
	</td>
	<td>
	<?php if(empty($item->unit_exchange)){?>
		<select class="combo" id="unitid" name="unitid" style="height:28px;">
			<option value="<?=$item->unitid;?>"><?=$item->unit_name;?></option>
		</select>
	<?php }else{?>
		<select goodid="<?=$item->id;?>" class="combo unitid" id="unitid" name="unitid" style="height:28px;">
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
	<td width="70"><input satid = "<?=$item->satid;?>" goodid="<?=$item->id;?>" uniqueid="<?=$item->uniqueid;?>" type="number" name="quantity" id="quantity_<?=$item->id;?>"  class="search form-control quantity text-right fm-number tab-event" value="<?=$item->quantity;?>" style="font-size:12px;"  /></td>
	<td width="100">
		<?php 
		$arrPrice = explode(';',$item->sale_price);	
		$priceoneFirst = $item->sale_price;
		$discount = $item->discount;
		if($item->xkm == 1){//xuất khuyến mải sản phẩm
			$priceoneFirst = 0;
			$discount = 0;
		}
		$prices = $priceoneFirst * $item->quantity;
		
		/*if($item->discount_type == 1){ //Tinh %
			$discount = ($discount * $priceoneFirst)/100;
		}*/
		?>
		<?php if($item->xkm == 1){?>
			<input goodid="<?=$item->id;?>" type="text" name="priceone" id="priceone_<?=$item->id;?>" placeholder="" class="search form-control priceone text-right " value="0" style="font-size:12px;" />
		<?php }elseif(empty($item->sale_price) || count($arrPrice) <=1 ){?>
			<input goodid="<?=$item->id;?>" type="text" name="priceone" id="priceone_<?=$item->id;?>" placeholder="" class="search form-control priceone text-right fm-number tab-event" value="<?=fmNumber($priceoneFirst);?>" style="font-size:12px;"  />
		<?php }else{
		?>
		<select 
		discount = "<?=$item->discount;?>"  
		discount_type = "<?=$item->discount_type;?>"  
		style="font-size:12px; height:28px; text-align:right;" 
		goodid="<?=$item->id;?>" name="priceone" id="priceone_<?=$item->id;?>" placeholder="" class="combo priceone priceone_change">
			<?php 
			foreach($arrPrice as $kk=>$pce){
				if($priceoneFirst == $pce){
					$selected = 'selected';
					$priceoneFirsts = $arrPrice[$kk];
					$prices = $arrPrice[$kk] * $item->quantity;
				}
				else{
					$priceoneFirsts = $arrPrice[0];
					$selected = '';
					$prices = $priceoneFirst * $item->quantity;
				}
				?>
				<option <?=$selected;?> value="<?=$pce;?>"><?=fmNumber($pce);?></option>
			<?php }
			$priceoneFirst = $priceoneFirsts;
			if($item->discount_type == 1){ //Tinh %
				$discount = ($discount * $priceoneFirst)/100;
			}
			?>
		</select>
		<?php }?>
	</td>
	<td >
	<?php if($item->xkm == 1){?>
	<input goodid="<?=$item->id;?>" type="text" id="price_<?=$item->id;?>" placeholder="" class="search form-control price buyprice text-right " value="0" style="font-size:12px; float:left; width:100%;"  />
	<?php }else{?>
	<input goodid="<?=$item->id;?>" type="text" id="price_<?=$item->id;?>" placeholder="" class="search form-control price buyprice text-right fm-number tab-event" value="<?=fmNumber($prices);?>" style="font-size:12px; float:left; width:100%;"  />
	<?php }?>
	</td>
	<td >
	<?php if($item->xkm == 1){?>
	<input goodid="<?=$item->id;?>" discount_types="<?=$item->discount_types;?>" type="text" id="discount_<?=$item->id;?>" placeholder="" class="search form-control discount  text-right tab-event" value="0" style="font-size:12px; float:left; width:100%;"  />
	<?php }else{?>
	<input goodid="<?=$item->id;?>" discount_types="<?=$item->discount_types;?>" type="text" id="discount_<?=$item->id;?>" placeholder="" class="search form-control discount text-right tab-event" value="<?=fmNumber($discount);?><?=$item->satdiscount_type;?>" style="font-size:12px; float:left; width:100%;" 
	/>
	<?php }?>
	</td>
	<td>
		<input goodid="<?=$item->id;?>" type="text" id="xkm_<?=$item->id;?>" placeholder="" class="search form-control xuatkhuyenmai text-right tab-event" value="<?=fmNumber($item->xkm);?>" style="font-size:12px; float:left; width:100%;"/>
	</td>
	<?php 
		if(empty($item->guaranteedate) || $item->guaranteedate == '0000-00-00'){
			$guarantee = '';
		}
		else{
			$guarantee = date(cfdate(),strtotime($item->guaranteedate));
		}
	?>
	<?php if(isguarantee() == 1){?> <!--Co bao hanh-->
	<td title="Bảo hành" style="padding-left:5px !important; padding-right:5px !important;">
		<div  goodid="<?=$item->id;?>" style="padding-left:0 !important; padding-right:0 !important;" class="dateOneGuarantee  input-group date date-picker" data-date-format="<?=cfdateHtml();?>">
			<input style="font-size:12px;" goodid="<?=$item->id;?>" type="text" id="guarantee_<?=$item->id;?>" name="guarantee" class="guarantees search tab-event" value="<?=$guarantee;?>" >
			<span class="input-group-btn ">
				<button style="margin-left:-19px;" class="btn default btn-picker-detail btn-picker" type="button"><i class="fa fa-calendar "></i></button>
			</span>
		</div>
	</td>
	<?php }?>
	<?php if(isserial() == 1){?>
	<td style="padding:1px !important;">
		<input goodid="<?=$item->id;?>" id="serial_<?=$item->id;?>" value="<?=$item->serial_number;?>" type="<?php if($item->isserial == 1){ echo 'text';}else{echo 'hidden';}?>" name="serial_number" class="search form-control serial_number tab-event" style="font-size:12px; padding:0px !important;" />
	</td>
	<?php }?>
	
	<td width="40">
		<a class="deleteItem" id="<?=$item->id;?>" href="#">
			<i class="fa fa-times"></i>
		</a>
	</td>
</tr>
<?php 
$tck+= $item->discount_value;
$tt+= $prices;
$i++;
}
?>
<?php
	$tts = $tt-$tck;
	$ttVat = $tts * $vat / 100;
	$ttss = $tts+ $ttVat;
?>
<tr>
	<td colspan="5" style="text-align:right;">Tổng:<?=$ttVat;?></td>
	<td class="tongtienhang" style="text-align:right; padding-right:10px !important;"><?=fmNumber($tt);?></td>
	<td class="ttchietkhau" style="text-align:right; padding-right:10px !important;"><?=fmNumber($tck);?></td>
	<?php if(isguarantee() == 1){?>
	<td></td>
	<?php }?>
	<?php if(isserial() == 1){?>
	<td></td>
	<?php }?>
	<td></td>
	<td></td>
</tr>
<script>
	$(function(){
		var tt = '<?=fmNumber($ttss);?>';
		var vat = '<?=$vat;?>';
		$('#input_total').val(tt);
		$('#price_prepay').val(tt);
		$('#vat').val(vat);
		
		$(".date-picker").datepicker('update');
		$('.dateOneGuarantee').datepicker().on('changeDate', function (ev) {
			var goodid = $(this).attr('goodid');
			var guarantee = $('#guarantee_'+goodid).val();
			$.ajax({
				url : controller + 'updateGuarantee',
				type: 'POST',
				async: false,
				data: {goodid:goodid,guarantee:guarantee},
				success:function(datas){}
			});
			$('.datepicker').hide();
		});
	});
</script>