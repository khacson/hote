<table border="0" width="100%">
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
<table border="0" width="100%" >
	<tr >
    	<td colspan="2" align="center"><h2 style="text-transform: uppercase; margin-top:20px;"><?=getLanguage('bang-bao-gia');?></h2>
		 <div style="margin-top:-20px;">(<?=$datecreate;?>)</div>
		</td>
    </tr>
	<tr>
    	<td><b><?=getLanguage('khach-hang');?>: </b><?=$finds->customer_name;?></td>
        <td></td>
    </tr>
    <tr>
    	<td><b><?=getLanguage('dien-thoai');?>: </b>
		<?=$finds->phone;?>
		</td>
        <td></td>
    </tr>
	<tr>
    	<td><b><?=getLanguage('dia-chi');?>:</b>
		<?=$finds->address;?> <?php if(!empty($finds->province_name)){ echo ' ,'.$finds->province_name;}?>
		</td>
        <td></td>
    </tr>
	
	<tr>
    	<td><b><?=getLanguage('ma-bao-gia');?></b>: <?=$finds->poid;?></td>
        <td ></td>
    </tr>
	<!--<tr>
    	<td><b>For</b>: <?=$finds->place_of_delivery;?></td>
        <td style="text-align:right;"><b>Ngày</b>:</td>
    </tr>-->
</table>
<table border="1" class="finds" width="100%">
	<tr>
		<td width="30" rowspan="2" align="center" valign="middle"><strong><?=getLanguage('stt');?></strong></td>
		<td rowspan="2" align="center" valign="middle"><strong><?=getLanguage('hang-hoa');?></strong></td>
		<td width="50" rowspan="2" align="center" valign="middle"><strong><?=getLanguage('dvt');?></strong></td>
		<td width="70" rowspan="2" align="center" valign="middle"><strong><?=getLanguage('so-luong');?></strong></td>
		<td width="70" rowspan="2" align="center" valign="middle"><strong><?=getLanguage('don-gia');?></strong></td>
		<td colspan="2" align="center" valign="middle"><strong><?=getLanguage('chiet-khau');?></strong></td>
		<td width="80" rowspan="2" align="center" valign="middle"><strong><?=getLanguage('thanh-tien');?></strong></td>
    </tr>
    <tr>
		<td width="60" align="center" valign="middle"><strong><?=configs()['currency'];?>/%</strong></td>
		<td width="70" align="center" valign="middle"><strong><?=getLanguage('san-pham');?></strong></td>
    </tr>
  <?php $i=1; 
  $t1 = 0;
  $t2 = 0;
  $t3 = 0;
  $t4 = 0;
  foreach($groups as $goodsType => $names){
	  if(isset($detail[$goodsType])){
		   $tt1 = 0;
		   $tt2 = 0;
		   $tt3 = 0;
		   foreach($detail[$goodsType] as $key => $item){
			 $tongtiens = $item->quantity * $item->priceone;
			 $thanhtiens = ($item->quantity * $item->priceone ) - $item->discount;
			 $tt1+= $item->quantity;
			 $tt2+= $tongtiens;
			 $tt3+= $thanhtiens;
		   }
	  }
	  ?>
  <tr>
    <td align="center"><b><?=$i;?></b></td>
    <td ><b><?=$names;?></b></td>
	<td>&nbsp;</td>
    <td class="text-right"><b><?=fmNumber($tt1);?></b></td>
    <td class="text-right"><b></b></td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
    <td class="text-right"><b><?=fmNumber($tt3);?></b></td>
  </tr>
  <?php if(isset($detail[$goodsType])){?>
		<?php 
		$j=1; 
		foreach($detail[$goodsType] as $key => $item){
			 $thanhtien = $item->price;
			 $t1+= $item->quantity;
			 $t3+= $thanhtien;
			 $t4+= $item->discount_value;
			 
			 $name = $item->goods_name;
			 if(!empty($item->goods_code)){
				 $name = $item->goods_code .' - '.$item->goods_name;
			 }
		  ?>
		  <tr>
			<td align="center"><?=$j;?></td>
			<td><?=$name;?></td>
			<td><?=$item->unit_name;?></td> 
			<td class="text-right"><?=fmNumber($item->quantity)?></td>
			<td class="text-right"><?=fmNumber($item->priceone);?></td>
			<td style="text-align:right;"><?=fmNumber($item->discount_value);?></td>
			<td style="text-align:right;"><?=fmNumber($item->cksp);?></td>
			<td class="text-right"><?=fmNumber($thanhtien);?></td>
		  </tr>
		 <?php $j++;}//for?>
  <?php }//if?>
  <?php $i++;
		$vats = $finds->vat_value;
  }?>
  <tr>
    <td colspan="3" ><b><?=getLanguage('tong');?>:</b></td>
    <td class="text-right"><b><?=fmNumber($t1);?></b></td>
    <td>&nbsp;</td>
    <td class="text-right"><b><?=fmNumber($t4);?></b></td>
	 <td>&nbsp;</td>
    <td class="text-right"><b><?=fmNumber($t3);?></b></td>
  </tr>
  <?php 
  $discount_value = 0;
  if(!empty($finds->discount_value)){
	  $discount_value = $finds->discount_value;
	  $discount_type = '';
	  if($finds->discount_type == 2){
		  $discount_type = '('.$finds->discount .'%)';
	  }
	  ?>
  <tr>
    <td colspan="2" ><b><?=getLanguage('giam-gia');?><?=$discount_type;?>:</b></td>
    <td class="text-right"><b></b></td>
	<td class="text-right"><b></b></td>
    <td class="text-right"><b></b></td>
    <td class="text-right"><b></b></td>
	<td>&nbsp;</td>
    <td class="text-right"><b><?=fmNumber($discount_value);?></b></td>
  </tr>
  <?php }?>
  <?php 
  $adjustment = 0;
  if(!empty($finds->adjustment)){
	   $adjustment = $finds->adjustment;
	  ?>
   <tr>
    <td colspan="2" ><b><?=getLanguage('dieu-chinh');?>:</b></td>
    <td class="text-right"><b></b></td>
	<td class="text-right"><b></b></td>
    <td class="text-right"><b></b></td>
    <td class="text-right"><b></b></td>
	<td>&nbsp;</td>
    <td class="text-right"><b><?=fmNumber($adjustment);?></b></td>
  </tr>
  <?php }?>
   <tr>
    <td colspan="2" ><b><?=getLanguage('vat');?>(<?=$finds->vat;?>%):</b></td>
    <td class="text-right"><b></b></td>
	<td class="text-right"><b></b></td>
    <td class="text-right"><b></b></td>
    <td class="text-right"><b></b></td>
	<td>&nbsp;</td>
    <td class="text-right"><b><?=fmNumber($vats);?></b></td>
  </tr>
   <tr>
    <td colspan="2" ><b><?=getLanguage('thanh-toan');?>:</b></td>
    <td class="text-right"><b></b></td>
	<td class="text-right"><b></b></td>
    <td class="text-right"><b></b></td>
    <td class="text-right"><b></b></td>
	<td>&nbsp;</td>
    <td class="text-right"><b><?=fmNumber($t3 + $vats - $discount_value +($adjustment));?></b></td>
  </tr>
</table>

<table border="0" width="100%" style="margin-top:10px;" >
    <tr>
    	<td class="text-left"  width="33%" valign="top" >
        <b><?=getLanguage('ngoi-lap-phieu');?></b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(<i style="font-size:12px;"><?=getLanguage('chu-ky-ho-ten');?></i>)<br />
		<img style="width:100px; height:60px;" src="<?=base_url();?>files/user/<?=$finds->signature_x;?>" /><br />
		<?=$finds->signature_name_x;?><br />
        &nbsp;&nbsp;&nbsp;&nbsp;
        </td>
        <!--<td align="center" valign="top"  width="33%">
         <b>Người giao hàng</b><br />(<i style="font-size:12px;">Ký, họ tên</i>)<br />
        </td>
        <td align="center" valign="top"  width="33%">
         <b>Người nhận hàng</b><br />(<i style="font-size:12px;">Ký, họ tên</i>)<br />
        </td>-->
    </tr>
    
</table>
<style type="text/css">
	table{ 
		border-collapse:collapse;
	}
	.text-right{ text-align:right;}
	ul li{ list-style:none;}
	.finds th{ text-align:center; border:1px solid #666; padding:5px; background:#fafafa;}
	.finds td{ border:1px solid #666; padding:1px 3px; }
</style>
