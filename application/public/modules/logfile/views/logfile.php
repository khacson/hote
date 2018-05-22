<ul>
	<?php if(is_array($finds)){ 
		unset($finds['id']);
		unset($finds['isdelete']);
		foreach($finds as $key=>$val){
		?>
		<li><?=$key;?>: <?=$val;?></li>
    <?php }}?>
</ul>