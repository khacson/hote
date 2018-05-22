<table border="0" width="750">
	<tr height="50">
    	<td width="70%">
			<table border="0" width="100%" valign="top">
                <tr>
                    <?php if(!empty($login->logo)){?>
                    <td width="115" rowspan="4">
                        <img width="60" src="<?=base_url();?>files/company/<?=$login->logo;?>" />
                    </td>
                    <?php }?>
                    <td width="413" style="font-size:20px!important; text-transform:uppercase !important;"><b ><?=$login->company_name;?></b></td>
                   
                </tr>
                <tr>
                    <td  style="">
                    <b>Địa chỉ: </b><?=$login->caddress;?>
                    <?php if(!empty($login->distric_name)){?>, <?=$login->distric_name;?> <?php }?> 
                    <?php if(!empty($login->province_name)){?>, <?=$login->province_name;?> <?php }?> 
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="">
                    <b>Điện thoại: </b><?=$login->cphone;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <?php if(!empty($login->cfax)){?>Fax: <?=$login->cfax;?><?php }?> 
                    </td>
                </tr>
				<tr>
                    <td colspan="2" style="">
                    <b>MST:</b><?=$login->mst;?></td>
                </tr>
            </table>
		</td>
		<td width="30%" style="text-align:right;" valign="top">
			<table border="0" width="100%">
				<?php
				if($datas->stt < 10){
					$stt = '00'.$datas->stt;
				}
				elseif($datas->stt < 100){
					$stt = '0'.$datas->stt;
				}
				else{
					$stt = $datas->stt;
				}
				$datepo = explode('-',$datas->datepo);
				if(!empty($datepo[1])){
					$soquyen = $datepo[1];
				}
				else{
					$soquyen = '';
				}
				?>
				<tr>
					<td style="text-align:right !important;">Số quyển: <?=$soquyen;?></td>
				</tr>
				<tr>
					<td  style="text-align:right !important;">Số: <?=$stt;?></td>
				</tr>
			</table>
		</td>
    </tr>
</table>
<table border="0" width="750" >
	<tr >
    	<td colspan="2" align="center"><H2>XUẤT TRẢ NHÀ CUNG CẤP</H2></td>
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
	<tr>
    	<td>Mã đơn hàng: <?=cfpn();?><?=$datas->poid;?></td>
        <td style="text-align:right;">
		<b>Ngày:</b> <?=date(cfdate(),strtotime($datas->datepo));?>
		</td>
    </tr>
</table>
<table border="1" class="datas" width="750" >
  <tr>
    <th width="40">STT</th>
    <th width="120">Mã hàng</th>
    <th>Tên hàng</th>
	 <th width="70">DVT</th>
    <th width="70">Số lượng</th>
	<th width="80">Đơn giá</th>
	<th width="100">Thành tiền</th>
   
  </tr>
  <?php $i=1; 
  $tprice = 0;
  foreach($detail as $item){
	  $tprice+= $item->price;
	 ?>
  <tr>
    <td align="center"><?=$i;?></td>
    <td><?=$item->goods_code;?></td>
    <td><?=$item->goods_name;?></td>
	<td><?=$item->unit_name;?></td>
    <td style="text-align:right;"><?=fmNumber($item->quantity);?></td>
    <td style="text-align:right;"><?=fmNumber($item->priceone);?></td>
	<td style="text-align:right;"><?=fmNumber($item->price);?></td>
	
  </tr>
  <?php $i++;}?>
  <tr>
	 <td colspan="6" style="text-align:right;"><b>Tổng cộng</b>:</td>
	 <td style="text-align:right;"><?=fmNumber($tprice);?></td>
  </tr>
</table>
<table border="0" width="750" style="margin-top:10px;" >
	<tr>
    	<td colspan="2">Tổng tiền: <?=fmNumber($datas->price);?>vnđ
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i style="text-transform:capitalize;">(Viết bằng chữ): <?=$fmPrice;?></i>
		</td>
    </tr>
</table>
<table border="0" width="750" style="margin-top:10px;" >
	<!--<tr height="40">
    	<td colspan="4" align="right"><i>Xuất,ngày <?=gmdate("d", time() + 7 * 3600);?> tháng <?=gmdate("m", time() + 7 * 3600);?> năm <?=gmdate("Y", time() + 7 * 3600);?></i></td>
    </tr>-->
    <tr>
    	<td class="text-left"  width="33%" valign="top" >
        <b>Người lập phiếu</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(<i style="font-size:12px;">Ký, họ tên</i>)<br />
		<img style="width:100px; height:60px;" src="<?=base_url();?>files/user/<?=$datas->signature;?>" /><br />
		<?=$datas->signature_name;?><br />
        &nbsp;&nbsp;&nbsp;&nbsp;
        </td>
        <td align="center" valign="top"  width="33%">
         <b>Người giao hàng</b><br />(<i style="font-size:12px;">Ký, họ tên</i>)<br />
        </td>
        <td align="center" valign="top"  width="33%">
         <b>Người nhận hàng</b><br />(<i style="font-size:12px;">Ký, họ tên</i>)<br />
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
