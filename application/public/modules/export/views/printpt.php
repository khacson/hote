<table border="0" width="750">
	<tr height="50">
    	<td width="53%" valign="top">
        		<table border="0" width="100%">
                <tr>
                    <?php if(!empty($login->logo)){?>
                    <td width="68" rowspan="3">
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
                    <?php if(!empty($login->cfax)){?>Fax: <?php }?> 
                    </td>
                </tr>
            </table>
        </td>
		<td width="47%" valign="top" style="text-align:right;">
			<!--<div style="margin-bottom:-100px;">
				<ul>
					<li style="padding-right:100px;"><b>Mẩu số: 01-T</b></li>
					<li>(Ban hành theo QĐ số 48/2006QĐ-BTC</li>
					<li style="padding-right:16px;">Ngày 14/09/2006 của bộ tài chính)</li>
					<li style="padding-right:80px;">Quển số:</li>
					<li style="padding-right:80px;">Số:</li>
					<li style="padding-right:35px;">Nợ 111: <?=number_format($finds->price);?>đ</li>
					<li style="padding-right:10px;">Có 131: <?=number_format($finds->price);?>đ</li>
				</ul>
			</div>-->
		</td>
    </tr>
</table>
<table border="0" width="750" >
	<tr >
    	<td colspan="2" align="center"><H2>PHIẾU THU</H2></td>
    </tr>
	<tr>
    	<td><b>Khách hàng</b>: 
			<?=$finds->customer_name;?>
        </td>
        <td></td>
    </tr>
    <tr>
    	<td><b>Điện thoại</b>: 
        <?=$finds->phone;?>
        </td>
        <td></td>
    </tr>
	<tr>
    	<td><b>Địa chỉ</b>: 
        <?=$finds->address;?> <?php if(!empty($finds->province_name)){ echo ' ,'.$finds->province_name;}?>
        </td>
        <td></td>
    </tr>
	<tr>
    	<td><b>Lý do nộp</b>: <?=$finds->description;?></td>
        <td></td>
    </tr>
	<tr>
    	<td><b>Số tiền</b>: <?=number_format($price);?>vnđ
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i >(Viết bằng chữ): <?=$docso;?> </i>
		</td>
        <td>
			
		</td>
    </tr>
</table>
<table border="0" width="750" style="margin-top:10px;" >
	<tr height="40">
    	<?php
			$datepo = $finds->datepo;
			$arr = explode('-',$datepo);
		?>
    	<td colspan="4" align="right"><i>Ngày <?=$arr[2];?> tháng <?=$arr[1];;?> năm <?=$arr[0];;?></i></td>
    </tr>
    <tr>
    	<td align="center"  width="25%">
        <b>Người lập phiếu</b><br />(<i style="font-size:12px;">Ký, họ tên</i>)<br />
        </td>
        <td align="center" width="25%">
         <b>Người nộp tiền</b><br />(<i style="font-size:12px;">Ký, họ tên</i>)<br />
        </td>
        <td align="center"  width="25%"><b>Kế toán</b><br />(<i style="font-size:12px;">Ký, họ tên</i>)<br />
        </td>
        <td align="center"  width="25%">
         <b>Thủ trưởng</b><br />(<i style="font-size:12px;">Ký, họ tên</i>)<br />
        </td>
    </tr>
    
</table>
<style type="text/css">
	table{ 
		border-collapse:collapse;
	
	}
	ul li{ list-style:none;}
	.finds th{ text-align:center; border:1px solid #666; padding:5px; background:#fafafa;}
	.finds td{ border:1px solid #666; padding:5px; padding-left:10px;}
</style>
