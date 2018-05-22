
<?php 	
$i = $start;
$t1 = 0;
$t2 = 0;
foreach($querySum as $item){
	if(isset($tonDauKys[$item->branchid][$item->warehouseid][$item->goodsid])){
		$tondau = $tonDauKys[$item->branchid][$item->warehouseid][$item->goodsid];
	}
	else{
		$tondau = 0;
	}
	if(isset($nhaKhoTrongKys[$item->branchid][$item->warehouseid][$item->goodsid])){
		$nhapkho = $nhaKhoTrongKys[$item->branchid][$item->warehouseid][$item->goodsid];
	}
	else{
		$nhapkho = 0;
	}
	if(isset($nhapHangTralais[$item->branchid][$item->warehouseid][$item->goodsid])){
		$nhaphangtralai = $nhapHangTralais[$item->branchid][$item->warehouseid][$item->goodsid];
	}
	else{
		$nhaphangtralai = 0;
	}
	if(isset($xuatKhoTrongKys[$item->branchid][$item->warehouseid][$item->goodsid])){
		$xuatkho = $xuatKhoTrongKys[$item->branchid][$item->warehouseid][$item->goodsid];
	}
	else{
		$xuatkho = 0;
	}
	if(isset($xuatTraNCC[$item->branchid][$item->warehouseid][$item->goodsid])){
		$xuatkhotrancc = $xuatTraNCC[$item->branchid][$item->warehouseid][$item->goodsid];
	}
	else{
		$xuatkhotrancc = 0;
	}
	$toncuoi = ($tondau + $nhapkho + $nhaphangtralai) - ($xuatkho + $xuatkhotrancc);
	$priceEnd = $toncuoi * $item->buy_price;
	$t1 +=$toncuoi;
	$t2 +=$priceEnd;
}
foreach ($datas as $key => $item){
	if(isset($tonDauKys[$item->branchid][$item->warehouseid][$item->goodsid])){
		$tondau = $tonDauKys[$item->branchid][$item->warehouseid][$item->goodsid];
	}
	else{
		$tondau = 0;
	}
	if(isset($nhaKhoTrongKys[$item->branchid][$item->warehouseid][$item->goodsid])){
		$nhapkho = $nhaKhoTrongKys[$item->branchid][$item->warehouseid][$item->goodsid];
	}
	else{
		$nhapkho = 0;
	}
	if(isset($nhapHangTralais[$item->branchid][$item->warehouseid][$item->goodsid])){
		$nhaphangtralai = $nhapHangTralais[$item->branchid][$item->warehouseid][$item->goodsid];
	}
	else{
		$nhaphangtralai = 0;
	}
	if(isset($xuatKhoTrongKys[$item->branchid][$item->warehouseid][$item->goodsid])){
		$xuatkho = $xuatKhoTrongKys[$item->branchid][$item->warehouseid][$item->goodsid];
	}
	else{
		$xuatkho = 0;
	}
	if(isset($xuatTraNCC[$item->branchid][$item->warehouseid][$item->goodsid])){
		$xuatkhotrancc = $xuatTraNCC[$item->branchid][$item->warehouseid][$item->goodsid];
	}
	else{
		$xuatkhotrancc = 0;
	}
	$toncuoi = ($tondau + $nhapkho + $nhaphangtralai) - ($xuatkho + $xuatkhotrancc);
	?>
	<tr class="content edit" 
	id= "<?=$item->id;?>" 
	locationid = "<?=$item->locationid;?>" 
	goodsid = "<?=$item->goodsid;?>" 
	branchid = "<?=$item->branchid;?>" 
	warehouseid = "<?=$item->warehouseid;?>" 
	>
		<td style="text-align: center;"><?=$i;?></td>
		<td><?=$item->goods_code;?></td>
		<td><?=$item->goods_name;?></td>
		<td><?=$item->unit_name;?></td>
		<td class="text-right"><?=fmNumber($tondau);?></td>
		<td class="text-right"><?=fmNumber($nhapkho);?></td>
		<td class="text-right"><?=fmNumber($nhaphangtralai);?></td>
		<td class="text-right"><?=fmNumber($xuatkho);?></td>
		<td class="text-right"><?=fmNumber($xuatkhotrancc);?></td>
		<td class="text-right"><?=fmNumber($toncuoi);?></td>
		<td class="text-right"><?=fmNumber($toncuoi * $item->buy_price);?></td>
		<td></td>
	</tr>
<?php $i++;}?>
<tr>
	<td class="text-right" colspan="9"><b>Tổng cộng:<b></td>
	<td class="text-right"><?=fmNumber($t1);?></td>
	<td class="text-right"><?=fmNumber($t2);?></td>
	<td></td>
</tr>
