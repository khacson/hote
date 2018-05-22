<table border="0" width="750">
	<tr>
    	<?php if(!empty($login->logo)){?>
    	<td width="68" rowspan="3">
        	<img width="60" src="<?=base_url();?>files/company/<?=$login->logo;?>" />
        </td>
        <?php }?>
    	<td width="413" style="font-size:20px!important; text-transform:uppercase !important;"><b ><?=$login->company_name;?></b></td>
		<td width="255" rowspan="2"></td>
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
		<?php if(!empty($login->cfax)){?>Fax: <?php }?> 
        </td>
	</tr>
</table>
<table border="0" width="750" >
	<tr height="40">
    	<td colspan="2" align="center"><H2>HÓA ĐƠN BÁN HÀNG</H2></td>
    </tr>
	<tr>
    	<td><b>Tên khách hàng:</b>
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
    <tr>
    	<td><b>Điện thoại:</b> 
		<?php 
			if($datas->customer_type == 0){
				echo $datas->customer_phone;
			}
			else{
				echo $datas->cphone;
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
			  $datecreate = date('d/m/Y',strtotime($datas->datepo));
		  }
		  else{
			  $datecreate = '';
		  }
	?>
	<tr>
    	<td><b>PO</b>: <?=$poid;?></td>
        <td style="text-align:right;"><b>Ngày</b>: <?=$datecreate;?></td>
    </tr>
</table>
<table border="1" class="datas"  width="750">
   <tr>
    <th width="50">STT</th>
    <th width="100">Mã hàng</th>
	<th >Tên hàng</th>
	<th width="60">DVT</th>
    <th width="70">Số lượng</th>
	<th width="100">Đơn giá</th>
	<th width="100">Thành tiền</th>
  </tr>
  <?php $i=1; $tsl =0; $tprice=0;foreach($detail as $item){
	  if(!empty($item->poid)){
		  $poid = 'PO'.$item->poid;
	  }
	  else{
		  $poid = 'N/A';
	  }
	  $tsl+= $item->quantity; 
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
  <?php $tongvat = 0;
	  $tongvat = $datas->vat * $tprice /100;
	  ?>
  <tr>
	 <td colspan="6" style="text-align:right;"><b>Thuế VAT(<?=$datas->vat;?>%)</b>:</td>
	 <td style="text-align:right;"><?=fmNumber($tongvat);?></td>
  </tr>
  <tr>
	 <td colspan="6" style="text-align:right;"><b>Thành tiền</b>:</td>
	 <td style="text-align:right;"><?=fmNumber($tprice + $tongvat);?></td>
  </tr>
</table>

<table border="0" style="margin-top:10px;">
	<tr>
    	<td colspan="2">Thành tiền <i style="text-transform:capitalize;">(Viết bằng chữ)</i>:  <?=$this->base_model->docso(rNumber($tprice + $tongvat));?>
		</td>
    </tr>
</table>
<table border="0" width="750" style="margin-top:10px;" >
	<!--<tr height="40">
    	<td colspan="2" align="right"><i>Xuất,ngày <?=gmdate("d", time() + 7 * 3600);?> tháng <?=gmdate("m", time() + 7 * 3600);?> năm <?=gmdate("Y", time() + 7 * 3600);?></i></td>
    </tr>-->
    <tr>
    	<td width="348" align="left" valign="top" >
        <b>Khách hàng</b><br />
       &nbsp;&nbsp;&nbsp;(<i style="font-size:12px;">Ký, họ tên</i>)
        </td>
        <td width="392" align="right" >
        <div style="text-align:left; padding-left:200px;" valign="top" >
				<b>Người lập phiếu</b>
				<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(<i style="font-size:12px;">Ký, họ tên</i>)<br />
				<img style="width:100px; height:60px;" src="<?=base_url();?>files/user/<?=$datas->signature_x;?>" /><br />
				<?=$datas->signature_name_x;?><br />
				&nbsp;
		 </div>
         <div style="padding-right:100px;"></div>
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
