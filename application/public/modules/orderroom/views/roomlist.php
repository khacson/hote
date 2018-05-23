<?php $j=1; foreach($roomLists as $item){
	$total = 0;
	$style= 'style="background:#f35958;"';
	if($item->isstatus == 1){
		$style= 'style="background:#0090d9;"';
	}
	elseif($item->isstatus == 2){
		$style= 'style="background:#f35958;"';
	}
	elseif($item->isstatus == 3){
		$style= 'style="background:#f5ae03;"';
	}
	elseif($item->isstatus == 4){
		$style= 'style="background:#658daf;"';
	}
	$persion = $item->tongkhac. ' Người';
	if($item->isstatus == 1){
		$persion = number_format($item->price).'đ';
	}
	$timestart = '';
	if(!empty($item->timestart)){
		$timestart = date(cfdate().' H:i',strtotime($item->timestart))."(20')";
	}
	?>
	<div class="col-md-2 dashboard-item dashboard-items" >
		<div title="-<?=getLanguage('theo-ngay');?>: <?=number_format($item->price);?>đ  -<?=getLanguage('theo-gio');?>: <?=number_format($item->price_hour);?>đ -<?=getLanguage('gia-them-gio');?>: <?=number_format($item->price_hour_next);?>đ -<?=getLanguage('theo-tuan');?>: <?=number_format($item->price_week);?>đ -<?=getLanguage('theo-thang');?>: <?=number_format($item->price_month);?>đ" class="dashboard-stat dashboard-stats" <?=$style;?> data-toggle="modal" data-target="#myModalFrom" 
		roomid="<?=$item->id;?>"
		>
			<div class="visual">
				<i class="fa fa-heartbeat"></i>
				<div class="row"><div class="col-md-12 persion"><?=$persion;?></div></div>
			</div>
			<div class="details">
				<div class="number" ><?=$item->room_name;?></div>
				<div class="desc f11"><?=$timestart;?></div>
			</div>
			<a class="more" href="#">
			Mở phòng 
			<i class="m-icon-swapright m-icon-white"></i>
			</a>
		</div>
	</div>
<?php $j++;}?>
<script>
	$(function(){
		<?php foreach($roomTotals as $key => $val){?>
			$('#roomTypes_<?=$key?>').html('('+<?=$val?>+')');
		<?php }?>
		<?php foreach($trinhtrangphong as $key => $val){?>
			$('#isstatus_<?=$key;?>').html(<?=$val;?>);
		<?php }?>
		<?php foreach($arrFloor as $key => $val){?>
			$('#floors_<?=$key;?>').html(<?=$val;?>);
		<?php }?>
	});
</script>