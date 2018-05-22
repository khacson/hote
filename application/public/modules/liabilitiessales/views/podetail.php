<?php 
$arr = array();
$arr[1] = 'Tiền mặt';
$arr[2] = 'CK';
$arr[3] = 'Thẻ';
if(isset($datas[0]->price)){?>
<table style="width:100%; margin-top:10px;">
	<tr>
		<th width="40px;">STT</th>
		<th width="100px;">Đơn hàng</th>
		<th width="120px;">Phiếu thu</th>
		<th width="120px;">Thanh toán</th>
		<th width="100px;">Ngày trả</th>
		<th width="120px;">Thanh toán</th>
		<th >Ghi chú</th>
	</tr>
	<?php $i=1; foreach($datas as $item){
		if(isset($arr[$item->payment])){
			$payments = $arr[$item->payment];
		}
		else{
			$payments = '';
		}
		?>
	<tr>
		<td class="text-center"><?=$i;?></td>
		<td><?=$item->poid;?></td>
		<td class="text-center">PT<?=$item->receipts_code;?></td>
		<td  class="text-right"><?=fmNumber($item->amount);?></td>
		<td  class="text-center"><?=date('d-m-Y',strtotime($item->datecreate));?></td>
		<td><?=$payments;?></td>
		<td><?=$item->notes;?></td>
	</tr>
	<?php $i++;}?>
	<tr>
		<td colspan="3">Tổng tiền</td>
		<td class="text-right"><?=fmNumber($datas[0]->price);?></td>
		<td colspan="3"></td>
	</tr>
	<tr>
		<td colspan="3">Đã thanh toán</td>
		<td class="text-right"><?=fmNumber($datas[0]->price_prepay);?></td>
		<td colspan="3"></td>
	</tr>
	<tr>
		<td colspan="3">Còn lại</td>
		<td class="text-right"><?=fmNumber($datas[0]->price - $datas[0]->price_prepay);?></td>
		<td colspan="3"></td>
	</tr>
<table>
<?php }?>
<style>
	.modal-body th{
		border:1px solid #d1dde2;
	}
</style>