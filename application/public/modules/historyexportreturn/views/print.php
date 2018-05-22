<table border="0" width="750">
	<tr height="50">
    	<td>Đơn vị: <b><?=$company;?></b></td>
    </tr>
</table>
<table border="0" width="750" >
	<tr >
    	<td colspan="2" align="center"><H2>ĐƠN ĐẶT HÀNG</H2></td>
    </tr>
	<tr>
    	<td>Người nhận hàng: <?=$result->customer_name;?></td>
        <td></td>
    </tr>
    <tr>
    	<td>Điện thoại: <?=$result->customer_phone;?></td>
        <td></td>
    </tr>
	<tr>
    	<td>Địa chỉ: <?=$result->customer_address;?></td>
        <td></td>
    </tr>
</table>
<table border="1" class="datas">
  <tr>
    <th width="40">STT</th>
    <th width="70">Đơn hàng</th>
    <th width="120">Mã hàng</th>
    <th width="320">Hàng hóa</th>
    <th width="70">Số lượng</th>
    <th width="70">DVT</th>
  </tr>
  <?php $i=1; foreach($detail[$result->uniqueid] as $item){
	 ?>
  <tr>
    <td align="center"><?=$i;?></td>
    <td>PO<?=$result->poid;?></td>
    <td><?=$item->goods_code;?></td>
    <td><?=$item->goods_name;?></td>
    <td><?=$item->quantity;?></td>
    <td><?=$item->unit_name;?></td>
  </tr>
  <?php $i++;}?>
</table>
<table border="0" width="750" style="margin-top:10px;" >
	<tr height="40">
    	<td colspan="4" align="right"><i>Xuất,ngày <?=gmdate("d", time() + 7 * 3600);?> tháng <?=gmdate("m", time() + 7 * 3600);?> năm <?=gmdate("Y", time() + 7 * 3600);?></i></td>
    </tr>
    <tr>
    	<td align="center"  width="25%">
        <b>Người lập phiếu</b><br />
        (<i>Ký, họ tên</i>)
        </td>
        <td align="center" width="25%">
         <b>Người nhận hàng</b><br />
        (<i>Ký, họ tên</i>)
        </td>
        <td align="center"  width="25%">
         <b>Thủ kho</b><br />
        (<i>Ký, họ tên</i>)
        </td>
        <td align="center"  width="25%">
         <b>Thủ trưởng</b><br />
        (<i>Ký, họ tên</i>)
        </td>
    </tr>
    
</table>
<style type="text/css">
	table{ 
		border-collapse:collapse;
	
	}
	.datas th{ text-align:center; border:1px solid #666; padding:5px; background:#fafafa;}
	.datas td{ border:1px solid #666; padding:5px; padding-left:10px;}
</style>
