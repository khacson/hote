<table border="0" width="750">
	<tr>
    	<td width="50%" >
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
		<td width="40%" style="text-align:right;" valign="top">
			<div >
				<ul>
					<li style="padding-right:100px;"><b>Mẩu số: 01-T</b></li>
					<li>(Ban hành theo QĐ số 48/2006QĐ-BTC</li>
					<li style="padding-right:16px;">Ngày 14/09/2006 của bộ tài chính)</li>
					<!--<li style="padding-right:80px;">Quển số: </li>
					<li style="padding-right:80px;">Số:</li>
					<!--<li style="padding-right:35px;">Nợ 152: <?=number_format($datas->price);?>đ</li>
					<li style="padding-right:10px;">Có 111: <?=number_format($datas->price);?>đ</li>-->
				</ul>
			</div>
		</td>
    </tr>
</table>
<table border="0" width="750" >
	<tr >
    	<td colspan="2" align="center"><H2>PHIẾU CHI</H2></td>
    </tr>
	<tr>
    	<td>Khách hàng: <?=$datas->cname;?></td>
        <td></td>
    </tr>
    <tr>
    	<td>Điện thoại: <?=$datas->cphone;?></td>
        <td></td>
    </tr>
	<tr>
    	<td>Địa chỉ: <?=$datas->caddress;?></td>
        <td></td>
    </tr>
	<tr>
    	<td>Lý do chi: <?=$datas->description;?></td>
        <td></td>
    </tr>
	<tr>
    	<td>Số tiền: <?=number_format($datas->price);?>vnđ
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i style="text-transform:capitalize;">(Viết bằng chữ):  <?=$fmprice;?></i>
		</td>
        <td>
			
		</td>
    </tr>
</table>
<table border="0" width="750" style="margin-top:10px;" >
	<tr height="40">
		<?php
			$datepo = $datas->datepo;
			$arr = explode('-',$datepo);
		?>
    	<td colspan="4" align="right"><i>Ngày <?=$arr[2];?> tháng <?=$arr[1];;?> năm <?=$arr[0];;?></i></td>
    </tr>
    <tr>
    	<td class="text-left"  width="33%" valign="top" >
        <b>Người lập phiếu</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(<i style="font-size:12px;">Ký, họ tên</i>)<br />
		<img style="width:100px; height:60px;" src="<?=base_url();?>files/user/<?=$datas->signature;?>" /><br />
		<?=$datas->signature_name;?><br />
        &nbsp;&nbsp;&nbsp;&nbsp;
        </td>
        <td align="center" width="25%" valign="top">
         <b>Người nhận hàng</b><br />
        (<i>Ký, họ tên</i>)
        </td>
        <td align="center"  width="25%" valign="top">
         <b>Thủ kho</b><br />
        (<i>Ký, họ tên</i>)
        </td>
        <td align="center"  width="25%" valign="top">
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
