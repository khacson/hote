
<?php 	$i = $start;
$arr = array();
$arr[1] = 'Nam';
$arr[2] = 'Nữ';
$arr[3] = 'Giới tính khác';

foreach ($datas as $key => $item) { 	
	if(!empty($item->identity_date) && $item->identity_date != '0000-00-00'){
		$identity_date = date('d-m-Y',strtotime($item->identity_date));
	}
	else{
		$identity_date = "";
	}
	if(!empty($item->birthday) && $item->birthday != '0000-00-00'){
		$birthday = date('d-m-Y',strtotime($item->birthday));
	}
	else{
		$birthday = "";
	}
	if(isset($arr[$item->sex])){
		$sex = $arr[$item->sex];
	}
	else{
		$sex = '';
	}
	?>
	<tr class="edit"  branchid="<?=$item->branchid;?>" id="<?=$item->id;?>" sex="<?=$item->sex;?>">
		
		<td style="text-align: center;">
			<input id="<?=$item->id;?>" class="noClick" type="checkbox" value="<?=$item->id; ?>" name="keys[]">
		</td>
		<td style="text-align: center;"><?=$i;?></td>
		<td class="employee_code"><?=$item->employee_code;?></td>
		<td class="employee_name"><?=$item->employee_name;?></td>
		<td class="sex"><?=$sex;?></td>
		<td class="identity"><?=$item->identity;?></td>
		<td class="identity_date text-center"><?=$identity_date;?></td>
		<td class="identity_from"><?=$item->identity_from;?></td>
		<td class="birthday text-center"><?=$birthday;?></td>
		<td><?=$item->branch_name;?></td>
	</tr>

<?php $i++;}?>
