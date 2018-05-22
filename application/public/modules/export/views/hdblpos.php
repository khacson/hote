<table border="0" width="100%">
	<tr height="auto">
    	<td width="100%" valign="top">
       		<table border="0" width="100%">
                <tr>
                    <?php if(!empty($login->logo)){?>
                    <td width="60" rowspan="4">
                        <img width="60" src="<?=base_url();?>files/company/<?=$login->logo;?>" />
                    </td>
                    <?php }?>
                    <td width="auto" style="font-size:20px!important; text-transform:uppercase !important;"><b ><?=$login->company_name;?></b></td>
                </tr>
                <tr>
                    <td  style="">
                    <b>ĐC: </b><?=$login->caddress;?>
                    <?php if(!empty($login->distric_name)){?>, <?=$login->distric_name;?> <?php }?> 
                    <?php if(!empty($login->province_name)){?>, <?=$login->province_name;?> <?php }?> 
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="">
                    <b>ĐT: </b><?=$login->cphone;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <?php if(!empty($login->cfax)){?>Fax: <?=$login->cfax;?><?php }?> 
                    </td>
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
<table border="0" width="300" style="margin-top:20px;" >
	<tr >
    	<td colspan="2" align="center">
			<H2>HÓA ĐƠN BÁN LẺ</H2>
			<div style="margin-top:-20px;">(<?=$datecreate;?>)</div>
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
    <td align="center" valign="middle"><strong>Tên hàng</strong></td>
    <td align="center" valign="middle"><strong>SL</strong></td>
    <td align="center" valign="middle"><strong>Đơn giá</strong></td>
    <td align="center"  valign="middle"><strong>Thành tiền</strong></td>
  </tr>
		<?php 
		$j=1; $t1 = 0; $t2 = 0; $t3 = 0; $t4 = 0;
		foreach($detail as $item){
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
			 //$t5+= $item->cksp;
		  ?>
		  <tr>
			<td><?=$j;?>. <?=$item->goods_code;?> <br><?=$item->goods_name;?></td>
			<td class="text-center"><?=fmNumber($item->quantity)?> (<?=$item->unit_name;?>)</td>
			<td class="text-right"><?=fmNumber($priceoneEnd);?>
			<?php if($priceone > $priceoneEnd){?>
			<br><span style="font-size:12px; text-decoration: line-through;"><?=fmNumber($priceone);?></span>
			<?php }?>
			</td>
			<td class="text-right"><?=fmNumber($tongtien);?></td>
		  </tr>
	<?php $j++;}//for?>
  <tr>
    <td ><b>Tổng</b></td>
    <td class="text-right"><b><?=fmNumber($t1);?></b></td>
    <td>&nbsp;</td>
    <td class="text-right"><b><?=fmNumber($t2);?></b></td>
  </tr>
</table>

<table border="0" width="100%" style="margin-top:10px;" >
    <tr>
    	<td class="text-left"  width="50%" valign="top" >
        <b>Người giao</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(<i style="font-size:12px;">Ký, họ tên</i>)<br />
		<img style="width:100px; height:60px;" src="<?=base_url();?>files/user/<?=$finds->signature_x;?>" /><br />
		<?=$finds->signature_name_x;?><br />
        &nbsp;&nbsp;&nbsp;&nbsp;
        </td>
        <td align="center" valign="top"  width="50%">
         <b>Người nhận</b><br />(<i style="font-size:12px;">Ký, họ tên</i>)<br />
        </td>
    </tr>
    
</table>
<style type="text/css">
	table{ 
		border-collapse:collapse;
	}
	.text-right{ text-align:right;}
	ul li{ list-style:none;}
	.finds th{ text-align:center; border:1px solid #666; padding:5px; background:#fafafa;}
	.finds td{ border:1px solid #666; padding:3px; font-size:14px;}
</style>
