<table border="0" width="100%" class="border-none">
	<tr height="50">
    	<td width="70%" valign="top">
       		<table border="0" width="100%">
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
				<!--<tr>
                    <td colspan="2" style="">
                    <b>MST:</b><?=$login->mst;?></td>
                </tr>-->
            </table>
        
        </td>
		<td width="30%" style="text-align:right;" valign="top">
			<table border="0" width="100%">
				<?php
				if($finds->stt < 10){
					$stt = '00'.$finds->stt;
				}
				elseif($finds->stt < 100){
					$stt = '0'.$finds->stt;
				}
				else{
					$stt = $finds->stt;
				}
				$datepo = explode('-',$finds->datepo);
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
<?php 
	  if(!empty($finds->poid)){
		  $poid = $finds->poid;
	  }
	  else{
		  $poid = 'N/A';
	  }
	  if(!empty($finds->datepo)){
		  $datecreate = date(cfdate(),strtotime($finds->datepo));
	  }
	  else{
		  $datecreate = '';
	  }
?>
<table border="0" width="100%" class="border-none">
	<tr >
    	<td colspan="2" align="center">
			<H2>PHIẾU XUẤT HÀNG</H2>
			<div >(<?=$datecreate;?>)</div>
		</td>
    </tr>
	<tr>
    	<td><b>Khách hàng: </b><?=$finds->customer_name;?></td>
        <td></td>
    </tr>
    <tr>
    	<td><b>Điện thoại: </b>
		<?=$finds->phone;?>
		</td>
        <td></td>
    </tr>
	<tr>
    	<td><b>Địa chỉ:</b>
		<?=$finds->address;?> <?php if(!empty($finds->province_name)){ echo ' ,'.$finds->province_name;}?>
		</td>
        <td></td>
    </tr>
	<tr>
    	<td><b>Đơn hàng</b>: <?=$poid;?></td>
        <td style="text-align:right;"></td>
    </tr>
	<!--<tr>
    	<td><b>For</b>: <?=$finds->place_of_delivery;?></td>
        <td style="text-align:right;"><b>Ngày</b>: <?=$datecreate;?></td>
    </tr>-->
</table>
<table border="1" class="finds" width="100%">
  <tr>
	<td width="50" rowspan="2" align="center" valign="middle"><strong>STT</strong></td>
	<td width="80" rowspan="2" align="center" valign="middle"><strong>Mã hàng</strong></td>
	<td rowspan="2" align="center" valign="middle"><strong>Tên hàng</strong></td>
	<td width="70" rowspan="2" align="center" valign="middle"><strong>DVT</strong></td>
	<td width="70" rowspan="2" align="center" valign="middle"><strong>Số lượng</strong></td>
	<td width="80" rowspan="2" align="center" valign="middle"><strong>Đơn giá</strong></td>
	<td width="142" colspan="2" align="center" valign="middle"><strong>Chiết khấu</strong></td>
	<td width="90" rowspan="2" align="center" valign="middle"><strong>Thanh toán</strong></td>
  </tr>
  <tr>
	<td width="70" align="center" valign="middle"><strong>Tiền</strong></td>
	 <td width="70" align="center" valign="middle"><strong>Sản phẩm</strong></td>
  </tr>
  <?php $i=1; 
  $t1 = 0;
  $t2 = 0;
  $t3 = 0;
  $t4 = 0;
  $t5 = 0;
  foreach($groups as $goodsType => $names){
	  if(isset($detail[$goodsType])){
		   $tt1 = 0;
		   $tt2 = 0;
		   $tt3 = 0;
		   foreach($detail[$goodsType] as $key => $item){
			 $discount = $item->discount;
			 $discount_type = $item->discount_type;
			 $priceone = $item->priceone;
			 $quantity = $item->quantity;
			 if($discount_type == 1){
				$priceoneEnd = $priceone - ($discount * $priceone /100);
				$discount_value = ($discount * $priceone /100) * $quantity; 
			 }
			 else{
				 $priceoneEnd = $priceone - $discount;
				 $discount_value =  $discount * $quantity;
			 }
			 $tongtiens = $item->quantity * $priceoneEnd;
			 
			 $tt1+= $item->quantity;
			 $tt2+= $tongtiens;
			 $tt3+= $tongtiens;
		   }
	  }
	  ?>
  <tr>
    <td align="center"><b><?=$i;?></b></td>
    <td colspan="3"><b><?=$names;?></b></td>
    <td class="text-right"><b><?=fmNumber($tt1);?></b></td>
	<td>&nbsp;</td>
    <td class="text-right"><b><?=fmNumber($tt2);?></b></td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
    <td class="text-right"><b><?=fmNumber($tt3);?></b></td>
  </tr>
  <?php if(isset($detail[$goodsType])){?>
		<?php 
		$j=1; 
		foreach($detail[$goodsType] as $key => $item){
			 $discount = $item->discount;
			 $discount_type = $item->discount_type;
			 $priceone = $item->priceone;
			 $quantity = $item->quantity;
			 if($discount_type == 1){
				$priceoneEnd = $priceone - ($discount * $priceone /100);
				$discount_value = ($discount * $priceone /100) * $quantity; 
			 }
			 else{
				 $priceoneEnd = $priceone - $discount;
				 $discount_value =  $discount * $quantity;
			 }
			 $tongtien = $item->quantity * $priceoneEnd;
			 $t1+= $quantity;
			 $t2+= $tongtien;
			 $t3+= $tongtien;
			 $t4+= $discount_value;
			 $t5+= $item->cksp;
		  ?>
		  <tr>
			<td align="center"><?=$j;?></td>
			<td><?=$item->goods_code;?></td>
			<td><?=$item->goods_name;?></td>
			<td><?=$item->unit_name;?></td> 
			<td class="text-right"><?=fmNumber($item->quantity)?></td>
			<td class="text-right"><?=fmNumber($priceoneEnd);?></td>
			<td class="text-right"><?=fmNumber($tongtien);?></td>
			<td class="text-right"><?=fmNumber($discount_value);?></td>
			<td class="text-right"><?=fmNumber($item->cksp);?></td>
			<td class="text-right"><?=fmNumber($tongtien);?></td>
		  </tr>
		 <?php $j++;}//for?>
  <?php }//if?>
  <?php $i++;
		$vats = $finds->vat * $t3 / 100;
  }
  ?>
  <tr>
    <td colspan="4"><b>Tổng:</b></td>
    <td class="text-right"><b><?=fmNumber($t1);?></b></td>
    <td>&nbsp;</td>
    <td class="text-right"><b><?=fmNumber($t2);?></b></td>
    <td class="text-right"><b><?=fmNumber($t4);?></b></td>
	<td class="text-right"><b><?=fmNumber($t5);?></b></td>
    <td class="text-right"><b><?=fmNumber($t3);?></b></td>
  </tr>
   <tr>
    <td colspan="4"><b>VAT(<?=$finds->vat;?>%):</b></td>
    <td class="text-right"><b></b></td>
    <td>&nbsp;</td>
    <td class="text-right"><b></b></td>
    <td class="text-right"><b></b></td>
	<td>&nbsp;</td>
    <td class="text-right"><b><?=fmNumber($vats);?></b></td>
  </tr>
   <tr>
    <td colspan="4"><b>Thanh toán:</b></td>
    <td class="text-right"><b></b></td>
    <td>&nbsp;</td>
    <td class="text-right"><b></b></td>
    <td class="text-right"><b></b></td>
	<td>&nbsp;</td>
    <td class="text-right"><b><?=fmNumber($t3 + $vats);?></b></td>
  </tr>
</table>

<table border="0" width="100%" style="margin-top:10px;" class="border-none">
    <tr>
    	<td class="text-left"  width="33%" valign="top" >
        <b>Người lập phiếu</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(<i style="font-size:12px;">Ký, họ tên</i>)<br />
		<img style="width:100px; height:60px;" src="<?=base_url();?>files/user/<?=$finds->signature_x;?>" /><br />
		<?=$finds->signature_name_x;?><br />
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
	.border-none{
		border:0px solid #666;
	}
	.border-none td{
		border:0px solid #666;
	}
	.text-right{ text-align:right;}
	ul li{ list-style:none;}
	.finds th{ text-align:center; border:1px solid #666; padding:3px; background:#fafafa;}
	.finds td{ border:1px solid #666; padding:2px; font-size:14px;}
</style>
