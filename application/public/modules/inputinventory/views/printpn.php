<table border="0" width="100%">
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
                    <b>Địa chỉ: </b>
					<?php if(!empty($login->infoBranch->address)){?>
					<?=$login->infoBranch->address;?>
					<?php }else{?>
					<?=$login->caddress;?>
					<?php }?>
					
					<?php if(!empty($login->infoBranch->distric_name)){?>
					<?=$login->infoBranch->distric_name;?>
					<?php }else{?>
						<?php if(!empty($login->distric_name)){?>, <?=$login->distric_name;?> <?php }?> 
					<?php }?>
					
					<?php if(!empty($login->infoBranch->province_name)){?>
					<?=$login->infoBranch->province_name;?>
					<?php }else{?>
						<?php if(!empty($login->province_name)){?>, <?=$login->province_name;?> <?php }?> 
					<?php }?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="">
                    <b>Điện thoại: </b>
					<?php if(!empty($login->infoBranch->phone)){?>
					<?=$login->infoBranch->phone;?>
					<?php }else{?>
						<?php if(!empty($login->cphone)){?>, <?=$login->cphone;?> <?php }?> 
					<?php }?>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?php if(!empty($login->infoBranch->fax)){?>
					<?=$login->infoBranch->fax;?>
					<?php }else{?>
						 <?php if(!empty($login->cfax)){?>Fax: <?=$login->cfax;?><?php }?> 
					<?php }?>
                    </td>
                </tr>
				<?php if(!empty($login->mst)){?>
				<tr>
                    <td colspan="2" style="">
                    <b>MST:</b><?=$login->mst;?></td>
                </tr>
				<?php }?>
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
<table border="0" width="100%" >
	<tr >
    	<td colspan="2" align="center"><H2>PHIẾU NHẬP KHO</H2>
		</td>
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
    	<td>Mã phiếu nhập: <?=$datas->poid;?></td>
        <td style="text-align:right;">
		<b>Ngày:</b> <?=date(cfdate(),strtotime($datas->datepo));?>
		</td>
    </tr>
</table>
<table border="1" class="datas" width="100%" >
  <tr>
	<td width="30" rowspan="2" align="center" valign="middle"><strong>STT</strong></td>
	<td width="80" rowspan="2" align="center" valign="middle"><strong>Mã hàng</strong></td>
	<td rowspan="2" align="center" valign="middle"><strong>Tên hàng</strong></td>
	<td width="50" rowspan="2" align="center" valign="middle"><strong>ĐVT</strong></td>
	<td width="50" rowspan="2" align="center" valign="middle"><strong>Số lượng</strong></td>
	<td width="60" rowspan="2" align="center" valign="middle"><strong>Đơn giá</strong></td>
	<td colspan="2" align="center" valign="middle"><strong>Chiết khấu</strong></td>
	<td width="80" rowspan="2" align="center" valign="middle"><strong>Thanh toán</strong></td>
  </tr>
  <tr>
	<td width="50" align="center" valign="middle"><strong>Tiền</strong></td>
	 <td width="50" align="center" valign="middle"><strong>Sản phẩm</strong></td>
  </tr>
  <?php $i=1; 
  $tprice = 0;
  $t_discount_value = 0;
  $t_discount = '';
  $adjustment = '';
  $price_prepay_value = 0;
  $price_prepay = '';
  $price_total = 0;
  $vat = 0;
  $vat_value = 0;
  foreach($detail as $item){
	  $thanhtien = $item->price;
	  $tprice+= $thanhtien;
	  $discount_type = '';
	  if($item->discount_type == 2 && !empty($item->discount)){
		  $discount_type = '%';
	  }
	  $t_discount_value = $item->t_discount_value;
	  if($item->t_discount_type == 2 && !empty($item->t_discount)){
		  $t_discount = '('.$item->t_discount .'%)';
	  }
	  $adjustment = $item->adjustment;
	  $price_prepay_value = $item->price_prepay_value;
	  if($item->price_prepay_type == 2 && !empty($item->price_prepay)){
		  $price_prepay = '('.$item->price_prepay .'%)';
	  }
	  $price_total = $item->price_total;//($item->price_total) -  $t_discount_value + ($adjustment); t_discount
	  $vat = $item->vat;
	  $vat_value = $item->vat_value;
	  $toTalVat = ($price_total * $vat)/100;
	 ?>
  <tr>
    <td align="center"><?=$i;?></td>
    <td><?=$item->goods_code;?></td>
    <td><?=$item->goods_name;?></td>
	<td><?=$item->unit_name;?></td>
    <td style="text-align:right;"><?=fmNumber($item->quantity + $item->cksp);?></td>
    <td style="text-align:right;"><?=fmNumber($item->priceone);?></td>
	<td style="text-align:right;"><?=fmNumber($item->discount);?><?=$discount_type;?></td>
	<td style="text-align:right;"><?=fmNumber($item->cksp);?></td>
	<td style="text-align:right;"><?=fmNumber($thanhtien);?></td>
  </tr>
  <?php $i++;}?>
  <tr>
	 <td colspan="8" style="text-align:right;"><b>Tổng</b>:</td>
	 <td style="text-align:right;"><?=fmNumber($tprice);?></td>
  </tr>
  <tr>
	 <td colspan="8" style="text-align:right;"><b><?=getLanguage('giam-gia');?><?= $t_discount;?></b>:</td>
	 <td style="text-align:right;"><?=fmNumber($t_discount_value);?></td>
  </tr>
  <tr>
	 <td colspan="8" style="text-align:right;"><b><?=getLanguage('dieu-chinh');?></b>:</td>
	 <td style="text-align:right;"><?=fmNumber($adjustment);?></td>
  </tr>
  <tr>
	 <td colspan="8" style="text-align:right;"><b><?=getLanguage('vat');?>(<?=$vat;?>%)</b>:</td>
	 <td style="text-align:right;"><?=fmNumber($vat_value);?></td>
  </tr>
  <tr>
	 <td colspan="8" style="text-align:right;"><b><?=getLanguage('thanh-toan');?><?=$price_prepay;?></b>:</td>
	 <td style="text-align:right;"><?=fmNumber($price_prepay_value);?></td>
  </tr>
   <tr>
	 <td colspan="8" style="text-align:right;"><b><?=getLanguage('tong-cong');?></b>:</td>
	 <td style="text-align:right;"><?=fmNumber($price_total);?></td>
  </tr>

</table>
<table border="0" width="100%" style="margin-top:10px;" >
	<tr>
    	<td colspan="2">Tổng tiền: <?=fmNumber($datas->price);?>vnđ
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i style="text-transform:capitalize;">(Viết bằng chữ): <?=$this->base_model->docso($price_total);?></i>
		</td>
    </tr>
</table>
<table border="0" width="100%" style="margin-top:10px;" >
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
	.datas td{ border:1px solid #666; padding:0 3px;}
</style>
