<?php $i=1; foreach($datas as $item){?>
<tr class="tgrid" >
	<td class="stt" width="40" class="text-center"><?=$i;?></td>
	<td align="left">
		<?=$item->goods_code;?>
	</td>
	<td align="left">
		<?=$item->goods_name;?>
	</td>
	<td ><input goodid="<?=$item->id;?>" type="text" name="quantity" id="quantity" placeholder="" class="search form-control quantity text-right fm-number" value="1" /></td>
	<td width="40">
		<a class="btn red btn-xs tw deleteItem" id="<?=$item->id;?>" href="#">
			<i class="fa fa-times"></i>
		</a>
	</td>
</tr>
<?php $i++;}?>