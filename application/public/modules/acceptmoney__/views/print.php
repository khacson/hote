<table border="0" width="750">
	<tr height="50">
    	<td width="53%" valign="top">
        		<table border="0" width="100%">
                <tr>
                    <td width="68" rowspan="3">
                        <img width="60" src="<?=url_tmpl();?>img/logovtc.png" />
                    </td>
                    <td width="413" style="font-size:20px!important; text-transform:uppercase !important;"><b ><?=$info['branch']['branch_name'];?></b></td>
                    
                </tr>
                <tr>
                    <td  style="">
                    <b>Địa chỉ: </b><?=$info['branch']['address'];?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="">
                    <b>Điện thoại: </b><?=$info['branch']['phone'];?> 
                    </td>
                </tr>
            </table>
        </td>
	
    </tr>
</table>
<table border="0" width="750" >
	<tr >
    	<td colspan="2" align="center"><H2 style="margin-top:20px;">BIÊN NHẬN BÀN GIAO</H2></td>
    </tr>
	<tr>
    	<td><b>Người nhận</b>: 
			<?php if(!empty($finds[0]->nguoinhan)){?>
				<?=$finds[0]->nguoinhan;?>
			<?php }?>
        </td>
        <td></td>
    </tr>
    <tr>
    	<td><b>Điện thoại</b>: 
			<?php if(!empty($finds[0]->dtnguoinhan)){?>
				<?=$finds[0]->dtnguoinhan;?>
			<?php }?>
        </td>
        <td></td>
    </tr>
	<tr>
    	<td><b><?=getLanguage('ghi-chu');?></b>: 
			<?php if(!empty($finds[0]->description)){?>
				<?=$finds[0]->description;?>
			<?php }?></td>
        <td></td>
    </tr>
	<tr>
    	<td><b>Số tiền</b>: 
		<?php if(!empty($finds[0]->money)){?>
				<?=number_format($finds[0]->money);?>
			<?php }?>vnđ
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i >(Viết bằng chữ): <?=$docso;?> </i>
		</td>
        <td>
			
		</td>
    </tr>
</table>
<table border="0" width="750" style="margin-top:10px;" >
	<tr height="40">
		<td></td>
		<td></td>
		<td></td>
		<td ><i>Ngày <?=date('d',strtotime($finds[0]->datecreate));?> tháng <?=date('m',strtotime($finds[0]->datecreate));?> năm <?=date('Y',strtotime($finds[0]->datecreate));?></i></td>
    </tr>
    <tr>
    	<td align="center"  width="25%">
        <b>Người giao</b><br /><br /><br /><br />
			<?php if(!empty($finds[0]->nguoichi)){?>
				<?=$finds[0]->nguoichi;?>
			<?php }?>
        </td>
        <td align="center" width="25%">
         
        </td>
        <td align="center"  width="25%">
        </td>
        <td align="center"  width="25%">
			<table border="0" class="text-center" width="100%">
				<tr>
					<td align="center"><b>Người nhận</b></td>
				</tr>
				<tr>
					<td align="center">
						<img width="80" height="60" src="<?=base_url();?>files/user/<?=$login['signatures'];?>" />
					</td>
				</tr>
				<tr>
					<td align="center">
						<?php if(!empty($finds[0]->nguoinhan)){?>
							<?=$finds[0]->nguoinhan;?>
						<?php }?>
					</td>
				</tr>
			</table>
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
