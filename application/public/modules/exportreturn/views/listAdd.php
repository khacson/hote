<?php $i=1; $tt = 0; foreach($datas as $item){
	$buy_price = $item->buy_price;
	if(empty($item->shelflifeddate) || $item->shelflifeddate == '0000-00-00'){
		$shelflifeddate = '';
	}
	else{
		$shelflifeddate = date(cfdate(),strtotime($item->shelflifeddate));
	}
	?>
<tr class="tgrid">
	<td class="stt" class="text-center"><?=$i;?></td>
	<td align="left">
		<b><?=$item->goods_code;?></b>-<?=$item->goods_name;?>
		<?php if($item->stype == 0 && !empty($item->group_code)){?>
			<br><i style="font-size:12px;">(<?=$item->group_code;?>-<?=$item->group_name;?>)</i>
		<?php }?>
		<input  goodid="<?=$item->id;?>" class="goodscode" type="hidden" value="<?=$item->goods_code;?>" />
		<input  goodid="<?=$item->id;?>" class="goodstt" type="hidden" value="<?=$i;?>" />
	</td>
	<td ><?=$item->unit_name;?></td>
	<td ><input goodid="<?=$item->id;?>" type="number" name="quantity" id="<?=$item->goods_code;?>" placeholder="" class="search form-control quantity text-right fm-number" value="<?=fmNumber($item->quantity);?>" /></td>
	<td ><input goodid="<?=$item->id;?>" type="text" name="priceone" id="priceone" placeholder="" style="font-size:12px;" class="search form-control priceone text-right fm-number" value="<?=fmNumber($buy_price);?>" /></td>
	<td ><input goodid="<?=$item->id;?>" type="text" id="price" placeholder="" style="font-size:12px;" class="search form-control price buyprice text-right fm-number" value="<?=fmNumber($item->totalPrice);?>" /></td>
	<td >
		<a title="Xóa" class="deleteItem" id="<?=$item->id;?>" href="#">
			<i class="fa fa-times"></i>
		</a>
	</td>
</tr>
<?php $i++;}?>
<tr >
	<td colspan="4" style="text-align:right;">Tổng tiền:</td>
	<td class="ttprice" style="text-align:right; padding-right:10px !important; font-size:12px;"></td>
	<td></td>
	<td></td>
	
</tr>
<script>
	$(function(){
		$(".date-picker").datepicker('update');
		$('.date-picker').datepicker().on('changeDate', function (ev) {
			var goodid = $(this).attr('goodid');
			var shelflifes = $('#shelflifes_'+goodid).val();
			$.ajax({
				url : controller + 'updateShelflifes',
				type: 'POST',
				async: false,
				data: {goodid:goodid,shelflife:shelflifes},
				success:function(datas){}
			});
			$('.datepicker').hide();
		});
	});
</script>