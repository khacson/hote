

<div class="col-md-12 list-goods-pos">
	<?php $i=1; foreach($datas as $item){?>
	<div class="col-md-3">
		<div class="pos-img <?php if(!empty($item->checkin)){ echo 'pos-img-active';}?>" id="<?=$item->id;?>" goods_code = '<?=$item->goods_code;?>' price="<?=$item->sale_price;?>">
			<img src="<?=base_url();?>files/goods/<?=$item->img;?>">
			<div class="col-md-12 pos-goods-detail">
				<div class="row rowfix">
					<b><?=$item->goods_code;?></b> | Tồn: <?=fmNumber($item->quantity);?>
				</div>
				<div class="row rowfix">
					<?=$item->goods_name;?>
				</div>
				<div class="row rowfix">
					<?=fmNumber($item->sale_price);?>VNĐ
				</div>
			</div>
		</div>
		
	</div>
	<?php $i++;}?>
</div>