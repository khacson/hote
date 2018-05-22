<style>
	.carousel-inner .active.left { left: -25%; }
	.carousel-inner .next        { left:  0%; }
	.carousel-inner .prev		 { left: -25%; }
	.carousel-control 			 { width:  4%; }
	.carousel-control.left,.carousel-control.right {margin-left:15px;background-image:none;}
</style>
<script>
	var urlSite = '<?=base_url();?>home/getProduct';
	$(function(){
		$('.vikingbj').each(function(){
			$(this).click(function(){
				  $('.vikingbj').removeClass('vi-active');
				  $(this).addClass('vi-active');
				  var id = $(this).attr('id');
				  //Load Data
				  $.ajax({
						url : urlSite,
						type: 'POST',
						async: false,
						data: {id:id},
						success:function(datas){
							var obj = $.evalJSON(datas); 
							$('#loadProduct').html(obj.content);
						},
						error : function(){
							
						}
				  });
			});
		});
	});
</script>
<?php if(empty($friendlyurl)){?>
<div class="row text-center mbtom40 mtop30">
	 <?php 
	 $i= 1;
	 foreach($categories as $item){
		if($i== 1){
			$active = 'vi-active';	
		}
		else{
			$active = '';		
		}
	?>
	 <span>
		<span id="<?=$item->id;?>" class="GretaSansStd1 vikingbj <?=$active;?>"><?=$item->categories_name;?></span>
	</span>
	 <?php $i++;}?>
</div>
<?php }else{?>
	<div class="row text-center mbtom40 mtop30"></div>
<?php }?>
<div class="col-md-12" id="loadProduct">
<div class="carousel slide" id="myCarousel">
  <div class="carousel-inner mbtom40">
	<?php $i=1; 
		foreach($products as $item){
		if($i==1){
			$active = 'active';	
		}
		else{
			$active = '';		
		}
	?>
    <div class="item <?=$active;?>">
      <div class="col-xs-3">
		  <a class="thumbnail" href='<?=base_url()?>product/<?=$item->friendlyurl;?>-<?=$item->id;?>.html'>
		  <div class="col-md-3 pleft0 pleft0">
			  <img src="<?=base_url()?>files/products/<?=$item->image;?>" />
		  </div>
		  <div class="col-md-9 pleft0 pleft0">
			  <div class="col-md-12 iLGretaTextPro f20"><?=$item->product_name;?></div>
			  <div class="line-top"></div>
			  <div class="col-md-12 pleft0 pleft0">
				  <?=$item->description_b;?>
			  </div>
			  <div class="col-md-12 text-center">
				  <b> <?=$item->percent;?> %</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			  </div>
			  <div class="line-bottom"></div>
		  </div>
		  </a>
	  </div>
    </div>
	<?php $i++;}?>
  </div>
  <a class="left carousel-control" href="#myCarousel" data-slide="prev">
	<img src="<?=url_tmpl();?>img/arrow-left.png" />
  </a>
  <a class="right carousel-control" href="#myCarousel" data-slide="next">
	<img src="<?=url_tmpl();?>img/arrow-right.png" />
  </a>
</div>
</div>

