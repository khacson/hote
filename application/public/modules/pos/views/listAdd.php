<?php $i=1; 
$tt = 0;
foreach($datas as $item){?>
<tr class="tgrid" url= '<?=base_url();?>files/goods/<?=$item->img;?>'>
	<td class="stt" class="text-center"><?=$i;?></td>
	<td align="left">
		<b><?=$item->goods_code;?></b><br><?=$item->goods_name;?>
		<?php if($item->stype == 0 && !empty($item->group_code)){?>
			<br><i style="font-size:12px;">(<?=$item->group_code;?>-<?=$item->group_name;?>)</i>
		<?php }?>
		<input  goodid="<?=$item->id;?>" class="goodscode" type="hidden" value="<?=$item->goods_code;?>" />
		<input  goodid="<?=$item->id;?>" class="sttview" type="hidden" value="<?=$i;?>" />
		<input  goodid="<?=$item->id;?>" class="discount" type="hidden" value="<?=$item->discount;?>" />
	</td>
	<?php
		if(empty($item->serial_number)){
			$quantity = $item->quantity;
		}
		else{
			$quantity = 1;
		}
	?>
	<td style="padding:1px !important;"><?=$item->unit_name;?></td>
	<td style="padding:1px !important;"><input goodid="<?=$item->id;?>" uniqueid="<?=$item->uniqueid;?>" type="number" name="quantity" id="<?=$item->goods_code;?>" placeholder="" class="search form-control quantity text-right fm-number" <?php if(!empty($item->serial_number)){?> readonly <?php }?> value="<?=$quantity;?>" style="font-size:12px;"  /></td>
	<td  style="padding:1px !important;">
		<?php 
		$arrPrice = explode(';',$item->sale_price);	
		$priceoneFirst = $item->sale_price;
		if(!empty($item->satPrice)){
			$priceoneFirst = $item->satPrice;
		}
		if(empty($item->sale_price) || count($arrPrice) <=1 ){?>
			<input goodid="<?=$item->id;?>" type="text" name="priceone" id="priceone" placeholder="" class="search form-control priceone text-right fm-number" value="<?=fmNumber($priceoneFirst);?>" style="font-size:12px;"  />
		<?php }else{
		?>
		<select style="font-size:12px; height:28px;" 
		goodid="<?=$item->id;?>" name="priceone" id="priceone" placeholder="" class="combo priceone">
			<?php 
			foreach($arrPrice as $kk=>$pce){
				$selected = '';
				if($priceoneFirst == $pce){
					$selected = 'selected';
					$priceoneFirsts = $arrPrice[$kk];
				}
				else{
					$priceoneFirsts = $arrPrice[0];
				}
				?>
				<option <?=$selected;?> value="<?=$pce;?>"><?=fmNumber($pce);?></option>
			<?php }
			$priceoneFirst = $priceoneFirsts;
			?>
		</select>
		<?php }?>
	</td>
	<?php 
		$prices = ($priceoneFirst * $quantity) - $item->discount;
		$tt+= $prices;
	?>
	<td width="100">
	<input goodid="<?=$item->id;?>" type="text" id="price" placeholder="" class="search form-control price buyprice text-right fm-number" value="<?=fmNumber($prices);?>" style="padding:1px !important;font-size:12px; float:left; width:83%;" />
	<a title="Giảm giá" goodid="<?=$item->id;?>" class="discountorder" data-toggle="modal" data-target="#viewdiscount-form"   href="#" style="float:left; margin-left:5px; margin-top:5px;" ><i class="fa fa-arrow-circle-down" aria-hidden="true"></i></a>
	</td>
	<?php 
		if(empty($item->guaranteedate) || $item->guaranteedate == '0000-00-00'){
			$guarantee = '';
		}
		else{
			$guarantee = date(cfdate(),strtotime($item->guaranteedate));
		}
	?>
	<td title="Bảo hành" style="padding:1px !important;">
		<div  goodid="<?=$item->id;?>" style="padding-left:0 !important; padding-right:0 !important;" class="dateOneGuarantee  input-group date date-picker" data-date-format="<?=cfdateHtml();?>">
			<input style="font-size:12px;" goodid="<?=$item->id;?>" type="text" id="guarantee_<?=$item->id;?>" name="guarantee" class="guarantees search" value="<?=$guarantee;?>" >
			<span class="input-group-btn ">
				<button style="margin-left:-19px;" class="btn default btn-picker-detail btn-picker" type="button"><i class="fa fa-calendar "></i></button>
			</span>
		</div>
	</td>
	<td style="padding:1px !important;">
		<input goodid="<?=$item->id;?>" value="<?=$item->serial_number;?>" type="<?php if($item->isserial == 1){ echo 'text';}else{echo 'hidden';}?>" name="serial_number" class="search form-control serial_number" style="font-size:12px; padding:0px !important;" />
	</td>
	<td >
		<a class="deleteItem" id="<?=$item->id;?>" href="#">
			<i class="fa fa-times"></i>
		</a>
	</td>
</tr>
<?php $i++;}
$ttvat = $vat * $tt /100;
$tts = $ttvat + $tt;
?>
<tr >
	<td colspan="5" style="text-align:right;">Tổng tiền:</td>
	<td class="ttprice" style="text-align:right; padding-right:10px !important;"><?=fmNumber($tt);?></td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<script>
	$(function(){
		var tt = '<?=fmNumber($tts);?>';
		$('#input_total').val(tt);
		$('#price_prepay').val(tt);
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