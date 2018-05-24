<div class="row" style="margin-bottom:15px;">
	<div class="row mtop10">
		<div class="col-md-12">
			<div class="form-group">
				<label  class="control-label col-md-3" ><?=getLanguage('hang-hoa-dich-vu');?></label>
				<div class="col-md-9" >
					<input type="text" placeholder="Tìm theo tên hoạc mã" name="goodsid" id="goodsid" placeholder="" class="search form-control " />
				</div>
			</div>
		</div>
	</div>
	<div class="row mtop10">
		<div class="col-md-12">
			<table class="inputgoods">
				<thead>
					<tr class="thds">
						<td width="30" rowspan="2"><?=getLanguage('stt');?></td>
						<td rowspan="2" ><?=getLanguage('hang-hoa');?></td>
						<td width="75" rowspan="2"><?=getLanguage('dvt');?></td>
						<td width="85" rowspan="2"><?=getLanguage('so-luong');?></td>
						<td width="90" rowspan="2"><?=getLanguage('don-gia');?></td>
						<td width="150" colspan="2"><?=getLanguage('chiet-khau');?></td>
						<td width="100" rowspan="2"><?=getLanguage('thanh-tien');?></td>
						<td width="30" rowspan="2"></td>
					</tr>
					<tr class="thds">
					  <td ><?=configs()['currency'];?>/%</td>
					  <td ><?=getLanguage('san-pham');?></td>
					</tr>
				</thead>
				<tbody class="gridView"></tbody>
			</table>
		</div>
	</div>
</div>
<script>
	gridView(0);
	actionTemp();
	setDefault();
	calInputTotal();
	formatNumberKeyUp('fm-number');
	formatNumber('fm-number');
	autocompleteService();
	function getPrice(){
		var roomid = '<?=$roomid;?>';
		var lease = $('#input_lease').val();
		var price_type = $('#input_price_type').val();
		$.ajax({
			url : '<?=base_url()?>orderroom'+'/getPrice',
			type: 'POST',
			async: false,
			data:{lease:lease,roomid:roomid,price_type:price_type}, 
			success:function(datas){
				$('#input_price').val(datas);
			}
		});
	}
	function autocompleteService(){
		$("#goodsid").autocomplete({
			//source: goodsList,
			source: function( request, response ) {
				$.ajax( {
					url: "<?=base_url();?>orderroom/getFindGoods",
					dataType: "json",
					type: 'POST',
					async: false,
					data: {
						goodscode: request.term
					},
					success: function( data ) {
						response( data.length === 1 && data[ 0 ].length === 0 ? [] : data );
						if (data.length === 0){
							return false;
						}
						temp_goodsid = data[0].goodsid;
						temp_goods_code = data[0].goods_code;
						temp_stype = data[0].stype;
						temp_exchangs = data[0].exchangs;											
					}
				} );
			},
			select: function( event, ui ){ 
				event.preventDefault();
				$( "#goodsid" ).val( ui.item.label); //ui.item is your object from the array
				var goodsid = ui.item.value;
				var goods_code = ui.item.goods_code;
				gooods(goodsid,goods_code,ui.item.stype,ui.item.exchangs,'');
				return false;
			},
			focus: function(event, ui) {
				event.preventDefault();
				$("#goodsid").val(ui.item.label);
			}
		});
	}
	function gooods(goodsid,code,stype,exchangs,deletes){ 
	    var vat = $('.valtotal').val();
		var xkm = 0;
		if($('#xuatkm').is(':checked')){
			xkm = 1;
		}
		var uniqueid = $('#uniqueidnew').val();
		var roomid = '<?=$roomid;?>';
		$.ajax({
			url : controller + 'getGoods',
			type: 'POST',
			async: false,
			data: {roomid:roomid, vat:vat,xkm:xkm, id:goodsid,code:code,stype:stype,exchangs:exchangs,deletes:deletes,isnew:0,uniqueid:uniqueid},
			success:function(datas){
				var obj = $.evalJSON(datas); 
				if(obj.status == 0){
					error('Hàng hóa không tồn tại trong hệ thống'); return false;
				}
				$('.gridView').html(obj.content); //Add Grid view
				//$('.ttprice').html(obj.totalPrice);
				$('#uniqueid').val(obj.uniqueid);
				formatNumberKeyUp('fm-number');
				formatNumber('fm-number');
				$('#goodsid').val('');
				actionTemp();
				clickViewImg();
			}
		});
	}
	function gridView(isnew){
		var roomid = '<?=$roomid;?>';
		$.ajax({
			url : controller + 'loadDataTempAdd',
			type: 'POST',
			async: false,
			data: {isnew:isnew, roomid:roomid},
			success:function(datas){
				var obj = $.evalJSON(datas);
				$('.gridView').html(obj.content);				
			}
		});
	}
	function clickViewImg(){
		$('.viewImg').each(function(){
			$(this).click(function(){
				 var url = $(this).attr('src');
				 viewImg(url); return false;
			});
		});
	}
	function actionTemp(){
		//Xóa
		$('.deleteItem').each(function(){ 
			$(this).on('click',function(){
				$(this).parent().parent().remove();
				var detailid = $(this).attr('detailid'); 
				$.ajax({
					url : controller + 'deleteTempData',
					type: 'POST',
					async: false,
					data: {detailid:detailid},
					success:function(datas){
						gooods(0,0,0,0,'delete');
					}
				}); 
				calInputTotal();
			});
		});
		//Update don gia 
		$('.priceone').each(function(idx){
			$(this).on('keyup',function(){
				var goodid = $(this).attr('goodid'); 
				setPrice(goodid);
				updateDataTemp(goodid);
			});
			$(this).on('change',function(){
				var goodid = $(this).attr('goodid'); 
				setPrice(goodid);
				updateDataTemp(goodid);
			});
			$(this).on('dblclick',function(){
				$(this).select();
			});
		});
		$('.quantity').each(function(idx){
			$(this).on('click',function(){
				var goodid = $(this).attr('goodid'); 
				setPrice(goodid);
				updateDataTemp(goodid);
			});
			$(this).on('keyup',function(){
				var goodid = $(this).attr('goodid'); 
				setPrice(goodid);
				updateDataTemp(goodid);
			});
			$(this).on('dblclick',function(){
				$(this).select();
			});
		});
		//Giam gia
		$('.discount').each(function(idx){
			$(this).on('keyup',function(){
				var goodid = $(this).attr('goodid'); 
				setPrice(goodid);
				updateDataTemp(goodid);
			});
			$(this).on('dblclick',function(){
				$(this).select();
			});
		});
		//Xuất khuyến mải
		$('.xuatkhuyenmai').each(function(idx){
			$(this).on('keyup',function(){
				var goodid = $(this).attr('goodid'); 
				setPrice(goodid);
				updateDataTemp(goodid);
			});
			$(this).on('dblclick',function(){
				$(this).select();
			});
		});
		//Đơn vị tính
		$('.unitid').each(function(idx){
			$(this).on('click',function(){
				var goodid = $(this).attr('goodid'); 
				updateDataTemp(goodid);
			});
		});
	}
	function setPrice(goodid){
		var priceone = $('#priceone_'+goodid).val();
		var quantity = $('#quantity_'+goodid).val();
		var discount = $('#discount_'+goodid).val();
		//var vat = $('#vat_'+goodid).val();
		var xkm = $('#xkm_'+goodid).val();
		if (xkm == '') {
			xkm = '0';
		}
		xkm = parseFloat(xkm.replace(/[^0-9+\-Ee.]/g, ''));
		//priceone
		if (priceone == '') {
			priceone = '0';
		}
		priceone = parseFloat(priceone.replace(/[^0-9+\-Ee.]/g, ''));
		//quantity
		if (quantity == '') {
			quantity = ',0';
		}
		quantity = parseFloat(quantity.replace(/[^0-9+\-Ee.]/g, ''));
		//Tinh Tong
		var quantityEnd = quantity - xkm; //Giam gia sản phẩm thì trừ sản phẩm trước
		var priceEnd = quantityEnd * priceone; 
		//Tinh giảm giá
		var k = discount.split('%');
		var tinhtheo = 0;
		if(k.length > 1){
			tinhtheo = 1;
		}
		//discount
		if(discount == ''){
			discount = '0';
		}
		discount = discount.replace(/[^0-9+\-Ee.]/g, '');
		//Tinh theo %
		var giamGia = 0;
		if(tinhtheo == 1){
			giamGia = (priceEnd * discount)/100;
		}
		else{//Giam tiền
			giamGia = discount;
		}
		var priceEnds = priceEnd - giamGia;
		//console.log(priceEnds);
		$('#price_'+goodid).val(formatOne(priceEnds));
		calInputTotal();
	}
	function calInputTotal(){
		var t_quantity = 0;
		$('.quantity').each(function(){
			var quantity = $(this).val();
			if (quantity == '') {
				quantity = '0';
			}
			quantity = parseFloat(quantity.replace(/[^0-9+\-Ee.]/g, ''));
			t_quantity+= quantity;
		});
		//console.log(t_quantity);
		$('#tong_so_luong').html(formatOne(t_quantity)); //tong_so_luong
		//Tong so luong giam tong_ck_soluong
		var t_xuatkhuyenmai  = 0;
		$('.xuatkhuyenmai').each(function(){
			var xuatkhuyenmai  = $(this).val();
			if (xuatkhuyenmai  == '') {
				xuatkhuyenmai  = '0';
			}
			xuatkhuyenmai  = parseFloat(xuatkhuyenmai.replace(/[^0-9+\-Ee.]/g, ''));
			t_xuatkhuyenmai += xuatkhuyenmai ;
		});
		$('#tong_ck_soluong').html(formatOne(t_xuatkhuyenmai));
		//Thanh tien  price_prepay tongtienhang
		var t_buyprice = 0;
		$('.buyprice').each(function(){
			var buyprice  = $(this).val();
			if (buyprice  == '') {
				buyprice  = '0';
			}
			buyprice  = parseFloat(buyprice.replace(/[^0-9+\-Ee.]/g, ''));
			t_buyprice += buyprice ;
		}); 
		$('#tongtienhang').html(formatOne(t_buyprice));
	}
	function viewImg(url) {
		$.fancybox({
			'width': 600,
			'height': 500,
			'autoSize' : false,
			'hideOnContentClick': true,
			'enableEscapeButton': true,
			'titleShow': true,
			'href': "#viewImg-form",
			'scrolling': 'no',
			'afterShow': function(){
				$('#viewImg-form-gridview').html('<img style="width:600px; height:500px;" src="'+url+'" />');
			}
		});
    }
	function updateDataTemp(goodid){
		var priceone = $('#priceone_'+goodid).val();
		var quantity = $('#quantity_'+goodid).val();
		var discount = $('#discount_'+goodid).val();
		var xkm = $('#xkm_'+goodid).val();
		var unitid = $('#unitid_'+goodid).val();
		//var discount_types = $('#discount_'+goodid).attr('discount_types');
		$.ajax({
			url : controller + 'updatePriceOne',
			type: 'POST',
			//async: false,
			data: {goodid:goodid, priceone:priceone,quantity:quantity,discount:discount,xkm:xkm,isnew:0,unitid:unitid},
			success:function(datas){
				var object = $.evalJSON(datas); 
			}
		}); 
	}
</script>