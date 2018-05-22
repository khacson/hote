<table style="border:none; margin:20px;">
	<tr>
		<td style="border:none;"><b>Mã hàng</b>: <?=$find->goods_code;?></td>
	</td>
	<tr>
		<td style="border:none;"><b>Tên hàng</b>: <?=$find->goods_name;?></td>
	</td>
	<tr>
		<td style="border:none;"><b>Thành tiền</b>: <?=($price);?></td>
	</td>
	<tr>
		<td style="border:none;">
			<div class="row" style="margin-left:5px;">
				<div class="col-md-7" style="padding:0 !important;">
					<label class="control-label">
						<input  checked type="radio" id="prepay_3" name="prepay" value="1"  />
						Tiền mặt</label>
					<label class="control-label" style="margin-left:10px;">
						<input  type="radio" id="prepay_4" name="prepay" value="2"  />
						%</label>
				</div>
				<div class="col-md-5" style="padding:0 !important; ">
					<input style="font-size:12px;" type="text" name="price_discount" id="price_discount" placeholder="" class="searchs form-control text-right fm-number" value="<?=$find->discount;?>" />
				</div>
			</div>
		</td>
	</td>
</table>
<script>
	$(function(){
		var percent = 0;
		formatNumberKeyUp('fm-number');
		formatNumber('fm-number');
		$('#prepay_3').prop('checked', true);
		$('#price_discount').keyup(function(){
			if($('#prepay_4').is(':checked')){
				var pricePrepay = parseFloat($('#price_discount').val().replace(/[^0-9+\-Ee.]/g, ''));//parseFloat
				if(pricePrepay > 100){
					$('#price_discount').val(100);
				}
				percent = 1;
			}
			var goodid = '<?=$find->id;?>';
			var price = '<?=$price;?>';
			var price_discount = $(this).val();
			$.ajax({
				url : controller + 'updateDiscount',
				type: 'POST',
				async: false,
				data: {goodid:goodid,price:price,price_discount:price_discount,percent:percent},
				success:function(datas){}
			});
		});
		$('#prepay_3').click(function(){//Tien 
			var inputTotal = '<?=$price;?>';
			inputTotal = parseFloat(inputTotal.replace(/[^0-9+\-Ee.]/g, ''));
			var pricePrepay = $('#price_discount').val();
			pricePrepay = parseFloat(pricePrepay.replace(/[^0-9+\-Ee.]/g, ''));
			if(percent == 0){
				$('#price_discount').val(pricePrepay);
			}
			else{
				var perc = pricePrepay * inputTotal / 100;
				pricePrepay = formatOne(perc.toFixed(2));
				$('#price_discount').val(pricePrepay);
			}
			percent = 0;
		});
		$('#prepay_4').click(function(){//Phan tram
			var inputTotal = $('#input_total').val();
			inputTotal = parseFloat(inputTotal.replace(/[^0-9+\-Ee.]/g, ''));
			var pricePrepay = $('#price_discount').val();
			pricePrepay = parseFloat(pricePrepay.replace(/[^0-9+\-Ee.]/g, ''));
			if(percent == 1){
				$('#price_discount').val(pricePrepay);
			}
			else{
				var perc = pricePrepay * 100 / inputTotal;
				pricePrepay = formatOne(perc.toFixed(2));
				$('#price_discount').val(pricePrepay);
			}
			percent = 1;
		});
	});
</script>