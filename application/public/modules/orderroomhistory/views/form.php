<div class="row"> 	
	<table style="margin-top:-10px;" id="tbheader" width="100%" cellspacing="0" border="1" >
		<tr>							
			<th style="width:40px;"><?=getLanguage('stt')?></th>
			<th style="width:130px;"><?=getLanguage('ho-ten')?></th>
			<th style="width:100px;"><?=getLanguage('cmnd')?></th>
			<th style="width:100px;"><?=getLanguage('ngay-cap')?></th>
			<th style="width:100px;"><?=getLanguage('noi-cap')?></th>
			<th style="width:100px;"><?=getLanguage('dien-thoai')?></th>
			<th ><?=getLanguage('dia-chi')?></th>
		</tr>
		<?php $i=1; foreach($datas as $item){
			if($item->identity_date != '0000-00-00' && !empty($item->identity_date)){
				$identity_date = date(cfdate(),strtotime($item->identity_date));
			}
			else{
				$identity_date = '';
			}
			?>
		<tr>
			<td style="text-align: center;"><?=$i;?></td>
			<td class="customer_name"><?=$item->customer_name;?></td>
			<td><?=$item->identity;?></td>
			<td><?=$identity_date;?></td>
			<td><?=$item->identity_from;?></td>
			<td><?=$item->phone;?></td>
			<td><?=$item->address;?></td>
		</tr>
		<?php $i++;}?>
	</table>					
</div>
