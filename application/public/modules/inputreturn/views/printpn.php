<table border="0" width="750">
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
    	<td colspan="2" align="center"><H2>PHIẾU NHẬP KHO</H2></td>
    </tr>
	<tr>
    	<td><b>Khách hàng:</b>
		<?php 
			if($datas->customer_type == 0){
				echo $datas->customer_name;
			}
			else{
				echo $datas->cname;
			}
		?>
		</td>
        <td></td>
    </tr>
    <tr>
    	<td><b>Điện thoại: </b>
		<?php 
			if($datas->customer_type == 0){
				echo $datas->customer_phone ;
			}
			else{
				echo $datas->cphone .' Fax: '.$datas->cfax;
			}
		?>
		</td>
        <td></td>
    </tr>
	<tr>
    	<td><b>Địa chỉ:</b>
		<?php 
			if($datas->customer_type == 0){
				echo $datas->customer_address;
			}
			else{
				echo $datas->caddress;
			}
		?>
		</td>
        <td></td>
    </tr>
	<?php 
		 if(!empty($datas->poid)){
			  $poid = $datas->poid;
		  }
		  else{
			  $poid = 'N/A';
		  }
		  if(!empty($datas->datepo)){
			  $datecreate = date(cfdate(),strtotime($datas->datepo));
		  }
		  else{
			  $datecreate = '';
		  }
	?>
	<tr>
    	<td><b></b><?=cfpx();?><?=$poid;?></td>
        <td style="text-align:right;"></td>
    </tr>
	<tr>
    	<td><b>For</b>: <?=$datas->place_of_delivery;?></td>
        <td style="text-align:right;"><b>Ngày</b>: <?=$datecreate;?></td>
    </tr>
</table>
<table border="1" class="datas" width="750">
  <tr>
    <th width="40">STT</th>
    <th width="90">Mã hàng</th>
    <th >Tên hàng</th>
	<th width="60">DVT</th>
    <th width="70">Số lượng</th>
	<th width="80">Đơn giá</th>
	<th width="70">Giảm giá</th>
	<th width="100">Thành tiền</th>
  </tr>
  <?php $i=1; $tsl =0; $tprice=0; $tdiscount=0;
  foreach($detail as $item){
	  $tsl+= $item->quantity; 
	  $price = ($item->quantity * $item->priceone) - $item->discount;
	  $tprice+= $price; 
	  $tdiscount+= $item->discount;
	 ?>
  <tr>
    <td align="center"><?=$i;?></td>
    <td>
		<?php if(!empty($datas->checkprint) && !empty($item->goods_code2)){?>
		<?=$item->goods_code2;?>
		<?php }else{?>
			<?=$item->goods_code;?>
		<?php }?>
	</td>
    <td><?=$item->goods_name;?></td>
	<td><?=$item->unit_name;?></td>
    <td style="text-align:right;"><?=fmNumber($item->quantity);?></td>
    <td style="text-align:right;"><?=fmNumber($item->priceone);?></td>
	<td style="text-align:right;"><?=fmNumber($item->discount);?></td>
	<td style="text-align:right;"><?=fmNumber($price);?></td>
	
  </tr>
  <?php $i++;}?>
  <tr>
	 <td colspan="6" style="text-align:right;"><b>Tổng cộng</b>:</td>
	 <td style="text-align:right;"><?=fmNumber($tdiscount);?></td> 
	 <td style="text-align:right;"><?=fmNumber($tprice);?></td>
  </tr>
  <?php $tongvat = 0;
  if(!empty($datas->vat)){
	  $tongvat = rNumber($datas->vat * $tprice /100);
	  $totalPrice = rNumber($tprice + $tongvat);
	  ?>
  <tr>
	 <td colspan="7" style="text-align:right;"><b>VAT(<?=$datas->vat;?>%)</b>:</td>
	 <td style="text-align:right;"><?=fmNumber($tongvat);?></td>
  </tr>
  <tr>
	 <td colspan="7" style="text-align:right;"><b>Thành tiền</b>:</td>
	 <td style="text-align:right;"><?=fmNumber($totalPrice);?></td>
  </tr>
  <?php }?>
</table>
<table border="0" style="margin-top:10px;">
	<tr>
    	<td colspan="2">Thành tiền <i style="text-transform:capitalize;">(Viết bằng chữ)</i>:  
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
		<img style="width:100px; height:60px;" src="<?=base_url();?>files/user/<?=$datas->signature_x;?>" /><br />
		<?=$datas->signature_name_x;?><br />
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
