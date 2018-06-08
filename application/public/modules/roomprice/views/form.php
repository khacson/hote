<style type="text/css">
	table col.cc1 { width: 40px; }
	table col.cc2 { width: 100px;}
	table col.cc3 { width: 100px;}
	table col.cc4 { width: 100px;}
	table col.cc5 { width: 100px;}
	table col.cc6 { width: 70px;}
	table col.cc7 { width: 70px;}
	table col.cc8 { width: 70px;}
	table col.cc9 { width: 70px;}
	table col.cc10 { width: 70px;}
	table col.cc11 { width: 70px;}
	table col.cc12 { width: 70px;}
	table col.cc13 { width: 70px;}
	table col.cc14 { width: 80px;}
	table col.cc115 {   width: auto;}
	.pding0{
		padding:0;
	}
	.pding0 input{
		padding:0;
		text-align:right;
	}
</style>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('ten-bang-gia');?> (<span class="red">*</span>)</label>
			<div class="col-md-8">
				<input type="text" name="input_roomprice_name"  id="input_roomprice_name" class="form-input form-control tab-event" 
				value="<?=$finds->roomprice_name;?>" placeholder=""
				/>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('ghi-chu');?></label>
			<div class="col-md-8">
				<input type="text" name="input_description"  id="input_description" class="form-input form-control tab-event" 
				value="<?=$finds->description;?>" placeholder=""
				/>
			</div>
		</div>
	</div>
</div>
<div class="row mtop10">
	<div class="col-md-12">
		<!--S-->
		<div id="gridview" >
				<!--header-->
				<div id="cHeader">
					<div id="tHeader">    	
						<table id="tbheader" width="100%" cellspacing="0" border="1" >
							<?php for($i=1; $i< 16; $i++){?>
								<col class="cc<?=$i;?>">
							<?php }?>
							<tr>							
								<th><?=getLanguage('stt')?></th>								
								<th><?=getLanguage('ten-phong')?></th>
								<th><?=getLanguage('gia-theo-ngay')?></th>
								<th><?=getLanguage('gia-qua-dem')?></th>
								<th><?=getLanguage('gia-theo-gio')?></th>
								<th><?=getLanguage('gio-thu')?> 1</th>
								<th><?=getLanguage('gio-thu')?> 2</th>
								<th><?=getLanguage('gio-thu')?> 3</th>
								<th><?=getLanguage('gio-thu')?> 4</th>
								<th><?=getLanguage('gio-thu')?> 5</th>
								<th><?=getLanguage('gio-thu')?> 6</th>
								<th><?=getLanguage('gio-thu')?> 7</th>
								<th><?=getLanguage('gia-tuan')?></th>
								<th><?=getLanguage('gia-thang')?></th>
								<th></th>
							</tr>
						</table>
					</div>
				</div>
				<!--end header-->
				<!--body-->
				<div id="data">
					<div id="gridView" style="max-height:400px;">
						<table id="tbbody" width="100%" cellspacing="0" border="1">
							<?php for($i=1; $i < 16; $i++){?>
								<col class="cc<?=$i;?>">
							<?php }?>
							<tbody id="grid-rows">
								<?php $j=1; 
								//echo '<pre>';print_r($listDetails);
								foreach($roomLists as $item){
									
									$theongay = 0;
									if(isset($listDetails[$item->id]['price'])){
										$theongay = $listDetails[$item->id]['price'];
									}
									$quadem = 0;
									if(isset($listDetails[$item->id]['price_night'])){
										$quadem = $listDetails[$item->id]['price_night'];
									}
									$theogio = 0;
									if(isset($listDetails[$item->id]['price_hour'])){
										$theogio = $listDetails[$item->id]['price_hour'];
									}
									$giothu1 = 0;
									if(isset($listDetails[$item->id]['price_hour_1'])){
										$giothu1 = $listDetails[$item->id]['price_hour_1'];
									}
									$giothu2 = 0;
									if(isset($listDetails[$item->id]['price_hour_2'])){
										$giothu2 = $listDetails[$item->id]['price_hour_2'];
									}
									$giothu3 = 0;
									if(isset($listDetails[$item->id]['price_hour_3'])){
										$giothu3 = $listDetails[$item->id]['price_hour_3'];
									}
									$giothu4 = 0;
									if(isset($listDetails[$item->id]['price_hour_4'])){
										$giothu4 = $listDetails[$item->id]['price_hour_4'];
									}
									$giothu5 = 0;
									if(isset($listDetails[$item->id]['price_hour_5'])){
										$giothu5 = $listDetails[$item->id]['price_hour_5'];
									}
									$giothu6 = 0;
									if(isset($listDetails[$item->id]['price_hour_6'])){
										$giothu6 = $listDetails[$item->id]['price_hour_6'];
									}
									$giothu7 = 0;
									if(isset($listDetails[$item->id]['price_hour_7'])){
										$giothu7 = $listDetails[$item->id]['price_hour_7'];
									}
									$giothang = 0;
									if(isset($listDetails[$item->id]['price_month'])){
										$giothang = $listDetails[$item->id]['price_month'];
									}
									$giotuan = 0;
									if(isset($listDetails[$item->id]['price_week'])){
										$giotuan = $listDetails[$item->id]['price_week'];
									}
									?>
									<tr>
										<td class="text-center"><?=$j;?></td>
										<td><?=$item->room_name;?></td>								
										<td class="pding0">
											<input ids="<?=$item->id;?>" type="text" name="theongay_<?=$j;?>"  id="theongay_<?=$j;?>" class="form-control fm-number theongay" value="<?=$theongay;?>" />
										</td>
										<td class="pding0">
											<input ids="<?=$item->id;?>" type="text" name="quadem_<?=$j;?>"  id="quadem_<?=$j;?>" class="form-control fm-number quadem" value="<?=$quadem;?>" />
										</td>
										
										<td class="pding0">
											<input ids="<?=$item->id;?>" type="text" name="theogio_<?=$j;?>"  id="theogio_<?=$j;?>" class="form-control fm-number theogio" value="<?=$theogio;?>" />
										</td>
										<td class="pding0">
											<input ids="<?=$item->id;?>" type="text" name="giothu1_<?=$j;?>"  id="giothu1_<?=$j;?>" class="form-control fm-number giothu1" value="<?=$giothu1;?>" />
										</td>
										<td class="pding0">
											<input ids="<?=$item->id;?>" type="text" name="giothu2_<?=$j;?>"  id="giothu2_<?=$j;?>" class="form-control fm-number giothu2" value="<?=$giothu2;?>" />
										</td>								
										<td class="pding0">
											<input ids="<?=$item->id;?>" type="text" name="giothu3_<?=$j;?>"  id="giothu3_<?=$j;?>" class="form-control fm-number giothu3" value="<?=$giothu3;?>" />
										</td>
										<td class="pding0">
											<input ids="<?=$item->id;?>" type="text" name="giothu4_<?=$j;?>"  id="giothu4_<?=$j;?>" class="form-control fm-number giothu4" value="<?=$giothu4;?>" />
										</td>
										<td class="pding0">
											<input ids="<?=$item->id;?>" type="text" name="giothu5_<?=$j;?>"  id="giothu5_<?=$j;?>" class="form-control fm-number giothu5" value="<?=$giothu5;?>" />
										</td>
										<td class="pding0">
											<input ids="<?=$item->id;?>" type="text" name="giothu6_<?=$j;?>"  id="giothu6_<?=$j;?>" class="form-control fm-number giothu6" value="<?=$giothu6;?>" />
										</td>								
										<td class="pding0">
											<input ids="<?=$item->id;?>" type="text" name="giothu7_<?=$j;?>"  id="giothu7_<?=$j;?>" class="form-control fm-number giothu7" value="<?=$giothu7;?>" />
										</td>
										<td class="pding0">
											<input ids="<?=$item->id;?>" type="text" name="giotuan_<?=$j;?>"  id="giotuan_<?=$j;?>" class="form-control fm-number giotuan" value="<?=$giotuan;?>" />
										</td>
										<td class="pding0">
											<input ids="<?=$item->id;?>" type="text" name="giothang_<?=$j;?>"  id="giothang_<?=$j;?>" class="form-control fm-number giothang" value="<?=$giothang;?>" />
										</td>								
										<td></td>
									</tr>
								<?php $j++;}?>
							</tbody>
						</table>
					</div>
				</div>
				<!--end body-->				
			</div>
		<!--E-->
	</div>
</div>
<script>
	$(function(){
		//handleSelect2();
		initForm();
		formatNumberKeyUp('fm-number');
		formatNumber('fm-number');
	});
	function getValueItem(){
		//0
		var theongay = {};
		$('.theongay').each(function(e){
			 var ids = $(this).attr('ids');
			 theongay[ids] = $('#theongay_'+ids).val();
		});
		var quadem = {};
		$('.quadem').each(function(e){
			 var ids = $(this).attr('ids');
			 quadem[ids] = $('#quadem_'+ids).val();
		});
		//1
		var theogio = {};
		$('.theogio').each(function(e){
			 var ids = $(this).attr('ids');
			 theogio[ids] = $('#theogio_'+ids).val();
		});
		//th1
		var giothu1 = {};
		$('.giothu1').each(function(e){
			 var ids = $(this).attr('ids');
			 giothu1[ids] = $('#giothu1_'+ids).val();
		});
		//th2
		var giothu2 = {};
		$('.giothu2').each(function(e){
			 var ids = $(this).attr('ids');
			 giothu2[ids] = $('#giothu2_'+ids).val();
		});
		//th3
		var giothu3 = {};
		$('.giothu3').each(function(e){
			 var ids = $(this).attr('ids');
			 giothu3[ids] = $('#giothu3_'+ids).val();
		});
		//th4
		var giothu4 = {};
		$('.giothu4').each(function(e){
			 var ids = $(this).attr('ids');
			 giothu4[ids] = $('#giothu4_'+ids).val();
		});
		//th5
		var giothu5 = {};
		$('.giothu5').each(function(e){
			 var ids = $(this).attr('ids');
			 giothu5[ids] = $('#giothu5_'+ids).val();
		});
		//th6
		var giothu6 = {};
		$('.giothu6').each(function(e){
			 var ids = $(this).attr('ids');
			 giothu6[ids] = $('#giothu6_'+ids).val();
		});
		//th7
		var giothu7 = {};
		$('.giothu7').each(function(e){
			 var ids = $(this).attr('ids');
			 giothu7[ids] = $('#giothu7_'+ids).val();
		});
		//giotuan
		var giotuan = {};
		$('.giotuan').each(function(e){
			 var ids = $(this).attr('ids');
			 giotuan[ids] = $('#giotuan_'+ids).val();
		});
		//giothang
		var giothang = {};
		$('.giothang').each(function(e){
			 var ids = $(this).attr('ids');
			 giothang[ids] = $('#giothang_'+ids).val();
		});		
		var objReq = {};
		objReq.theongay = theongay;
		objReq.quadem = quadem;
		objReq.theogio = theogio;
		objReq.giothu1 = giothu1;
		objReq.giothu2 = giothu2;
		objReq.giothu3 = giothu3;
		objReq.giothu4 = giothu4;
		objReq.giothu5 = giothu5;
		objReq.giothu6 = giothu6;
		objReq.giothu7 = giothu7;
		objReq.giotuan = giotuan;
		objReq.giothang = giothang;
		return JSON.stringify(objReq);
	}
	function initForm(){
	
	}
</script>
