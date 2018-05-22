<style title="" type="text/css">
	table col.c1 { width: 45px; }
	table col.c2 { width: 45px; }
	table col.c3 { width: 100px;}
	table col.c4 { width: 250px; }
	table col.c5 { width: 450px; }
	table col.c6 {  width: auto;}
</style>
<div class="row">
	<?=$this->load->inc('breadcrumb');?>
</div>
<div class="portlet box blue mtop0">
	<div class="portlet-title">
		<div class="caption caption2" >
			<i class="fa fa-plus" style="margin-top:2px;"></i>
			<?=getLanguage('them-ngon-ngu');?>
		</div>
		<div class="tools">
			<a href="javascript:;" class="collapse">
			</a>
		</div>
	</div>
	<div class="portlet-body">
		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('ngon-ngu');?> (<span class="red">*</span>)</label>
					<div class="col-md-8">
						 <select id="langkey" name="langkey" class="combos tab-event">
							  <option></option>	
							  <?php foreach($languages as $item){?>
								  <option value="<?=$item->langkey;?>"><?=$item->langname;?></option>	
							  <?php }?>
						 </select>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('tu-khoa');?> (<span class="red">*</span>)</label>
					<div class="col-md-8">
						<input type="text" name="keyword" placeholder="" id="keyword" class="searchs form-control tab-event" />
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('dich');?> (<span class="red">*</span>)</label>
					<div class="col-md-8">
						<input type="text" name="translation" placeholder="" id="translation" class="searchs form-control tab-event" />
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption caption2" style="margin-bottom:5px;">
			 <div class="brc mtop3"><i class="fa fa-bars"></i> <?=getLanguage('tim-thay');?> <span class="semi-bold viewtotal">0</span> <?=getLanguage('ngon-ngu');?></div>	
		</div>
		<div class="tools">
			<ul class="button-group pull-right"  style="margin-top:-5px; margin-bottom:5px;">
				<li id="search">
					<button class="button">
						<i class="fa fa-search"></i>
						<?=getLanguage('tim-kiem');?>
					</button>
				</li>
				<li id="refresh" >
					<button class="button">
						<i class="fa fa-refresh"></i>
						<?=getLanguage('lam-moi');?>
					</button>
				</li>
				<?php if(isset($permission['add'])){?>
				<li id="save"><button class="button">
					<i class="fa fa-plus"></i>
					<?=getLanguage('them-moi');?>
					</button>
				</li>
				<?php }?>
				<?php if(isset($permission['edit'])){?>
				<li id="edit">
					<button class="button">
						<i class="fa fa-save"></i>
						<?=getLanguage('sua');?>
					</button>
				</li>
				<?php }?>
				<?php if(isset($permission['delete'])){?>
				<li id="delete">
					<button type="button" class="button">
						<i class="fa fa-times"></i>
						<?=getLanguage('xoa');?>
					</button>
				</li>
				<?php }?>
			</ul>
		</div>
	</div>
	<div class="portlet-body">
		<div class="portlet-body">
        	<div id="gridview" >
				<!--header-->
				<div id="cHeader">
					<div id="tHeader">    	
						<table id="tbheader" width="100%" cellspacing="0" border="1" >
							<?php for($i=1; $i< 7; $i++){?>
								<col class="c<?=$i;?>">
							<?php }?>
							<tr>							
								<th><input type="checkbox" id="checkAll" autocomplete="off" /></th>
								<th><?=getLanguage('stt');?></th>
								<th><?=getLanguage('ngon-ngu');?></th>
								<th><?=getLanguage('tu-khoa');?></th>
								<th><?=getLanguage('dich');?></th>
								<th></th>
							</tr>
						</table>
					</div>
				</div>
				<!--end header-->
				<!--body-->
				<div id="data">
					<div id="gridView">
						<table id="tbbody" width="100%" cellspacing="0" border="1">
							<?php for($i=1; $i < 7; $i++){?>
								<col class="c<?=$i;?>">
							<?php }?>
							<tr class="row-search">
							<tbody id="grid-rows"></tbody>
						</table>
					</div>
				</div>
				<!--end body-->				
			</div>
		</div>
		<div class="portlet-body">
			<div class="fleft" id="paging"></div>
        </div>
	</div>
</div>
<!-- END grid-->
<div class="loading" style="display: none;">
	<div class="blockUI blockOverlay" style="width: 100%;height: 100%;top:0px;left:0px;position: absolute;background-color: rgb(0,0,0);opacity: 0.1;z-index: 1000;">
	</div>
	<div class="blockUI blockMsg blockElement" style="width: 30%;position: absolute;top: 15%;left:35%;text-align: center;">
		<img src="<?=url_tmpl()?>img/preloader.gif" style="z-index: 2;position: absolute;"/>
	</div>
</div> 
<!-- ui-dialog -->
<input type="hidden" name="id" id="id" />
<script>
	var controller = '<?=base_url().$routes;?>/';
	var table;
	var cpage = 0;
	var search;
	var routes = '<?=$routes;?>';
	$(function(){	
		init();
		//refresh();
		searchList();	
		$("#search").click(function(){
			$(".loading").show();
			searchList();	
		});
		$("#refresh").click(function(){
			$(".loading").show();
			refresh();
		});
		$("#save").click(function(){
			save('','save');
		});
		$("#edit").click(function(){
			var id = $('#id').val();
			if(id == ''){
				warning(cldcs);
				return false;
			} 
			save(id,'edit');
		});
		$("#delete").click(function(){
			var id = getCheckedId();
			if(id == ''){ return false;}
			confirmDelete(id);
			return false
		});
	});
	$(document).keypress(function(e) {
		 var id = $("#id").val();
		 if (e.which == 13) {
			  if(id == ''){ 
				  save('','save');
			  }
			  else{
				  save(id,'edit');
			  }
		 }
	});
	function save(id,func){
		var search = getSearch();
			var obj = $.evalJSON(search); 
			if(obj.langkey == ""){
				warning('<?=getLanguage('chon-ngon-ngu');?>'); 
				return false;		
			}
			if(obj.keyword == ""){
				warning('<?=getLanguage('tu-khoa-khong-duoc-trong');?>'); 
				$('#keyword').select();
				return false;		
			}
			if(obj.translation == ""){
				warning(<?=getLanguage('noi-dung-dich-khong-duoc-trong');?>); 
				$('#translation').select();
				return false;		
			}
			$('.loading').show();
			var data = new FormData();
			//var objectfile2 = document.getElementById('profileAvatar').files;
			//data.append('avatarfile', objectfile2[0]);
			//data.append('csrf_stock_name', token);
			//data.append('search', search);
			//data.append('id',id);
			$.ajax({
				url : controller + func,
				type: 'POST',
				async: false,
				data:{search:search,id:id},
				//enctype: 'multipart/form-data',
				//processData: false,  
				//contentType: false,   
				success:function(datas){
					var obj = $.evalJSON(datas); 
					$("#token").val(obj.csrfHash);
					$('.loading').hide();
					if(obj.status == 0){
						if(id == ''){
							error(tmktc); return false;	
						}
						else{
							error(sktc); return false;	
						}
					}
					else if(obj.status == -1){
						error(dldtt); return false;		
					}
					else{
						$('#keyword').select();
						if(id == ''){
							success(tmtc);
							searchList();	
						}
						else{
							success(stc); 
							searchList();	
						}
						$("#translation").val("");
						//refresh();
					}
				},
				error : function(){
					$('.loading').hide();
					if(id == ''){
						error(tmktc); return false;	
					}
					else{
						error(sktc); return false;	
					}
				}
			});
	}
	function init(){
		$("#langkey").multipleSelect({
			filter: true,
			placeholder:'<?=getLanguage('chon-ngon-ngu');?>',
			single: true
		});
		var langkey = 'vn';
		$("#langkey").multipleSelect('setSelects', langkey.split(','));
	}
	function funcList(obj){
		$(".edit").each(function(e){
			$(this).click(function(){ 
				var translation = $(".translation").eq(e).text().trim();
				var keyword = $(".keyword").eq(e).text().trim();
				var langkey = $(".langkey").eq(e).text().trim();
				
				var id = $(this).attr('id');
				$("#id").val(id);	
				$("#translation").val(translation);	
				$("#keyword").val(keyword);	
				$("#langkey").multipleSelect('setSelects', langkey.split(','));
			});
		});	
	}
	function refresh(){
		$(".loading").show();
		$(".searchs").val("");
		//$('#langkey').multipleSelect('uncheckAll');
		var langkey = 'vn';
		$("#langkey").multipleSelect('setSelects', langkey.split(','));
		csrfHash = $('#token').val();
		search = getSearch();
		getList(cpage,csrfHash);	
	}
	function searchList(){
		$(".loading").show();
		search = getSearch();
		csrfHash = $('#token').val();
		getList(cpage,csrfHash);	
	}
</script>
<script src="<?=url_tmpl();?>js/right.js" type="text/javascript"></script>