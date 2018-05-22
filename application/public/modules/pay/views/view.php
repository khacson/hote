<style title="" type="text/css">
	table col.c1 { width: 50px; }
	table col.c2 { width: 50px; }
	table col.c3 { width: 130px;}
	table col.c4 { width: 110px;}
	table col.c5 { width: 110px;}
	table col.c6 { width: 100px;}
	table col.c7 { width: 110px;}
	table col.c8 { width: 130px;}
	table col.c9 { width: 150px;}
	table col.c10 { width: 150px;}
	table col.c11 {  width: auto;}
	.col-md-4{ white-space: nowrap !important;}
</style>

<!-- BEGIN PORTLET-->
<div class="row">
	<?=$this->load->inc('breadcrumb');?>
</div>
<div class="portlet box blue mtop0">
	<div class="portlet-title">
		<div class="caption caption2">
			 <div class="brc mtop3"><i class="fa fa-bars"></i> <?=getLanguage('tim-thay');?> <span class="semi-bold viewtotal">0</span> <?=getLanguage('phieu-chi');?></div>		
		</div>
		<div class="tools">
			<ul class="button-group pull-right" style="margin-top:-5px; margin-bottom:5px;">
				<li id="search">
					<button class="button">
						<i class="fa fa-search"></i>
						<?=getLanguage('tim-kiem')?>
					</button>
				</li>
				<li id="refresh" >
					<button class="button">
						<i class="fa fa-refresh"></i>
						<?=getLanguage('lam-moi')?>
					</button>
				</li>
				<li id="printpc">
					<button class="button">
						<i class="fa fa-print"></i>
						<?=getLanguage('in')?>
					</button>
				</li>
			</ul>
		</div>
	</div>
	<div class="portlet-body">
		<div class="portlet-body">
        	<div id="gridview" >
				<table class="resultset" id="grid"></table>
				<!--header-->
				<div id="cHeader">
					<div id="tHeader">    	
						<table id="tbheader" width="100%" cellspacing="0" border="1" >
							<?php for($i=1; $i < 12; $i++){?>
								<col class="c<?=$i;?>">
							<?php }?>
							<tr>							
								<th><input type="checkbox" name="checkAll" id="checkAll" /></th>
								<th><?=getLanguage('stt')?></th>
								<th id="ord_p.supplierid"><?=getLanguage('nha-cung-cap')?></th>		
								<th id="ord_p.poid"><?=getLanguage('don-hang')?></th>
								<th id="ord_p.pay_code"><?=getLanguage('phieu-chi')?></th>
								<th id="ord_p.amount"><?=getLanguage('so-tien')?></th>
								<th id="ord_p.payment"><?=getLanguage('thanh-toan')?></th>
								<th id="ord_p.expirationdate"><?=getLanguage('ngan-hang')?></th>
								<th id="ord_p.datecreate"><?=getLanguage('ngay-chi')?></th>
								<th id="ord_p.liabilities"><?=getLanguage('nguoi-chi')?></th>
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
							<tr class="row-search">
								<td></td>
								<td></td>
								<td>
									<select id="supplierid" name="supplierid" class="combos" >
										<option value=""></option>
										<?php foreach($suppliers as $item){?>
											<option value="<?=$item->id;?>"><?=$item->supplier_name;?></option>
										<?php }?>
									</select>
								</td>
								<td>
									<input type="text" name="poid" id="poid" class="searchs form-control " />
								</td>
								<td>
									<input type="text" name="pay_code" id="pay_code" class="searchs form-control " />
								</td>
								<td>
									<input type="text" name="amount" id="amount" class="searchs form-control " />
								</td> 
								<td>
									<select id="payment" name="payment" class="combos" >
										<option value=""></option>
										<option value="1"><?=getLanguage('tien-mat');?></option>
										<option value="2"><?=getLanguage('chuyen-khoan');?></option>
									</select>
								</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<?php for($i=1; $i < 12; $i++){?>
								<col class="c<?=$i;?>">
							<?php }?>
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
<!-- END PORTLET-->
<div class="loading" style="display: none;">
	<div class="blockUI blockOverlay" style="width: 100%;height: 100%;top:0px;left:0px;position: absolute;background-color: rgb(0,0,0);opacity: 0.1;z-index: 1000;">
	</div>
	<div class="blockUI blockMsg blockElement" style="width: 30%;position: absolute;top: 15%;left:35%;text-align: center;">
		<img src="<?=url_tmpl()?>img/ajax_loader.gif" style="z-index: 2;position: absolute;"/>
	</div>
</div> 

<!-- Modal -->
<div id="myModalGoods" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width:839px;">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-headers">
        <button style="
		position: relative;
    right: 15px;
    top: 15px;
    z-index: 99999;" type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body" id="modal-body-goods">
			
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?=getLanguage('dong')?></button>
      </div>
    </div>
  </div>
</div>
<!--E My form-->
<input type="hidden" id="print_pay_code" name="print_pay_code" >
<input type="hidden" id="conlai" name="conlai" >
<script>
	var controller = '<?=base_url().$routes;?>/';
	var csrfHash = '<?=$csrfHash;?>';
	var cpage = 0;
	var search;
	$(function(){
		init();
		formatNumberKeyUp('fm-number');
		formatNumber('fm-number');
		//refresh(); 
		searchList();	
		$('#search').click(function(){
			$(".loading").show();
			searchList();	
		});
		$('#refresh').click(function(){
			$('.loading').show();
			refresh();
		});
		$('#save').click(function(){
			save('save','');
		});
		$('#edit').click(function(){
			var id = $("#id").val();
			if(id == ''){
				error('Vui lòng chọn dữ liệu cần cập nhật công nợ.'); return false;	
			}
			save('edit',id);
		});
		$('#export').click(function(){
			window.location = controller + 'export?search='+getSearch();
		});
		$('#history').click(function(){
			window.location = '<?=base_url();?>historypay';
		});
		$('#printpc').click(function(){
			var pay_code = $('#print_pay_code').val();
			if(pay_code == ''){
				warning("<?=getLanguage('chon-phieu-chi');?>");
			}
			inPhieuchi(pay_code);
		});
		searchFunction();
	});
	function searchFunction(){
		$("#poid,#amount,#pay_code").keyup(function() {
			searchList();	
		});
		/*$("#click_date").on("changeDate", function(e) {
			searchList();
		});*/
	}
	function inPhieuchi(pay_code){
			$.ajax({
				url :  '<?=base_url();?>congnomuahang/getDataPrintPC',
				type: 'POST',
				async: false,
				data: {ptid:pay_code},
				success:function(datas){
					var object = $.evalJSON(datas); 
					var disp_setting = "toolbar=yes,location=yes,directories=yes,menubar=no,";
					disp_setting += "scrollbars=yes,width=900, height=auto, left=0.0, top=0.0";
					var docprint = window.open("certificate", "certificate", disp_setting);
					docprint.document.open();
					docprint.document.write('<html>');
					//docprint.document.write(css);
					docprint.document.write('<body onLoad="self.print()">');
					docprint.document.write(object.content);
					docprint.document.write('</body></html>');
					docprint.document.close();
					docprint.focus();
				}
			});
			return false;	
	}
	function save(func,id){
		search = getSearch();
		var obj = $.evalJSON(search); 
		var uniqueid = $('#uniqueid').val();
		if(obj.amount == ''){
			warning('Số tiền <?=getLanguage('empty')?>'); $('#amount').focus(); return false;	
		}
		if(obj.uniqueid == ''){
			warning('Chọn đơn hàng cần thanh toán'); return false;	
		}
		var idCheck = getCheckedId();
		if(idCheck == ''){
			warning('Chọn đơn hàng cần thanh toán'); return false;	
		}
		if(obj.datepo == ''){
			warning('Ngày chi không được trống'); 
			$('#datepo').focus();
			return false;	
		}
		var payments = $('input[name=payments]:checked').val();
		var conlai = $('#conlai').val();
		$('.loading').show();
		$.ajax({
			url : controller + func,
			type: 'POST',
			async: false,
			data: {search:search,payments:payments,uniqueid:uniqueid,conlai:conlai},
			success:function(datas){
				var obj = $.evalJSON(datas); 
				$("#token").val(obj.csrfHash);
				if(obj.status == 0){
					error('Thanh toán không thành công.');	
				}
				else{
					success('Thanh toán thành công.');
					refresh();
				}
				$('.loading').hide();
			},
			error : function(){
				$('.loading').hide();
				error('Thanh toán không thành công.');	 return false;
			}
		});
	}
	function init(){
		$('#supplierid').multipleSelect({
			filter: true,
			placeholder:"<?=getLanguage('chon-nha-cung-cap')?>",
			single: true,
			onClick: function(view) {
				searchList();
			}
		});
		$('#payment').multipleSelect({
			filter: true,
			placeholder:"<?=getLanguage('chon-hinh-thuc-thanh-toan')?>",
			single: true,
			onClick: function(view) {
				searchList();
			}
		});
		
		/*$('#goodsid').multipleSelect({
			filter: true,
			placeholder:'Chọn hàng hóa',
			single: false,
			input:true,
			placeholderinput:"SL",
			nameinput:"s1"
		});*/
		$('#branchid').multipleSelect({
			filter: true,
			placeholder:'Chọn chi nhánh',
			// single: true
		});
		var iscn = '<?=iscn();?>'; 
		$('.searchs').val('');		
		$('select.combos').multipleSelect('uncheckAll');
		$('#datepo').val('<?=$timeNow;?>');
		$('#iscn').multipleSelect('setSelects', iscn.split(','));
	}
	function showCongNo(id){
		//var poid = getCombo('poid'); alert(poid);
		$('.podetail').html(' - ');
		$.ajax({
			url : controller + 'viewPOdetail',
			type: 'POST',
			async: false,
			data: {id:id},
			success:function(datas){
				var obj = $.evalJSON(datas); 
				$('#modal-body-goods').html(obj.content);
			},
			error : function(){}
		});
	}
    function funcList(obj){
		$('.edit').each(function(e){
			$(this).click(function(){ 
				 var supplierid = $(this).attr('supplierid');
				 var pay_code = $(this).attr('pay_code');
				 $('#print_pay_code').val(pay_code);	
				 $('#supplierid').multipleSelect('setSelects', supplierid.split(','));
			});
			function getIDChecked(){
				return 1;	
			} 
		});	
	}
	function refresh(){
		$('.loading').show();
		$('.searchs').val('');		
		csrfHash = $('#token').val();
		$('select.combos').multipleSelect('uncheckAll');
		var iscn = '<?=iscn();?>'; 
		$('#iscn').multipleSelect('setSelects', iscn.split(','));
		search = getSearch();
		getList(cpage,csrfHash);	
	}
	function searchList(){
		search = getSearch();
		csrfHash = $('#token').val();
		getList(0,csrfHash);	
	}
	
</script>
