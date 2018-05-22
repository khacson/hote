<table border="0" width="750">
	<tr height="50">
    	<td width="50%">Đơn vị: <b><?=$company;?></b></td>
		<td width="50%" style="text-align:right;">
			<div style="margin-bottom:-100px;">
				<ul>
					<li style="padding-right:100px;"><b>Mẩu số: 01-T</b></li>
					<li>(Ban hành theo QĐ số 48/2006QĐ-BTC</li>
					<li style="padding-right:16px;">Ngày 14/09/2006 của bộ tài chính)</li>
					<li style="padding-right:80px;">Quển số:</li>
					<li style="padding-right:80px;">Số:</li>
					<li style="padding-right:85px;">Nợ 111:</li>
					<li style="padding-right:60px;">Có 156: </li>
				</ul>
			</div>
		</td>
    </tr>
</table>
<table border="0" width="750" >
	<tr >
    	<td colspan="2" align="center"><H2>PHIẾU NHẬP KHO</H2></td>
    </tr>
	<tr>
    	<td>Người giao: <?=$datas->supplier_name;?></td>
        <td></td>
    </tr>
    <tr>
    	<td>Điện thoại: <?=$datas->phone;?></td>
        <td></td>
    </tr>
	<tr>
    	<td>Địa chỉ: <?=$datas->address;?></td>
        <td></td>
    </tr>
</table>
<table border="1" class="datas">
  <tr>
    <th width="40">STT</th>
    <th width="120">Mã hàng</th>
    <th width="250">Hàng hóa</th>
    <th width="70">Số lượng</th>
	<th width="70">Đơn giá</th>
	<th width="80">Thành tiền</th>
    <th>DVT</th>
  </tr>
  <?php $i=1; foreach($detail as $item){
	 ?>
  <tr>
    <td align="center"><?=$i;?></td>
    <td><?=$item->goods_code;?></td>
    <td><?=$item->goods_name;?></td>
    <td><?=number_format($item->quantity);?></td>
    <td><?=number_format($item->priceone);?></td>
	<td><?=number_format($item->price);?></td>
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
	ul li{ list-style:none;}
	.datas th{ text-align:center; border:1px solid #666; padding:5px; background:#fafafa;}
	.datas td{ border:1px solid #666; padding:5px; padding-left:10px;}
</style>
