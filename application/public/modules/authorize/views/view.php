
	<h3 class="form-title font-roboto" style="color:#0596c0 !important; font-width:bold">
	 QUẢN LÝ KHÁCH SẠN
	</h3>
        <div class="alert alert-danger display-hide">
            <button class="close" data-close="alert"></button>
            <span id="error" class="red">
                 Nhập tài khoản và mật khẩu.
            </span>
        </div>
        <?php if (isset($message) && !empty($message)) { ?>
            <div class="alert alert-danger display-hide" style="display: block;">
                <button class="close" data-close="alert"></button>
                <span id="message">
                     <?=$message?>
                </span>
            </div>
        <?php } ?>
        <div class="form-group" >
            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
            <label class="control-label visible-ie8 visible-ie9">Tài khoản</label>
            <div class="input-icon">
                <i class="fa fa-user"></i>
                <input  style="height:36px !important;" class="form-control placeholder-no-fix tab-event" type="text" autocomplete="off" placeholder="Tài khoản" id="username" name="username" value="<?=$username;?>"/>
            </div>
        </div>
        <div class="form-group clearfix" style="margin-top
		:10px;">
            <label class="control-label visible-ie8 visible-ie9">Mật khẩu</label>
            <div class="input-icon">
                <i class="fa fa-lock"></i>
                <input style="height:36px !important;" class="form-control placeholder-no-fix tab-event" type="password" autocomplete="off" placeholder="Mật khẩu" id="password" name="password" onkeypress="keypressed(event);" value="<?=$password;?>"/>
            </div>
        </div>
		<div class="form-group clearfix" style="margin-top
		:10px;">
			<div class="col-md-6" style="padding-left:0px;">
				<div class="input-icon">
					<i class="fa fa-qrcode"></i>
					<input style="height:36px !important;" class="form-control placeholder-no-fix tab-event" type="text" autocomplete="off" placeholder="Mã xác nhận" id="verification" name="verification" onkeypress="keypressed(event);"/>
				</div>
			</div>
			<div class="col-md-4">
				 <img  title="Tạo mã khác"  src="<?=base_url()?>authorize/captcha/543534.html" id="icaptcha">
			</div>
			<div class="col-md-2" style="text-align:right;">
				 <img id="reload" title="Create another code" style="cursor:pointer; margin-left:5px; margin-top:5px;" align="absmiddle" src="<?=url_tmpl();?>images/reload.png" />
			</div>
        </div>
        <div class="form-group clearfix" >
           <div class="col-md-12" style="margin-top:0px; padding-left:0px;  padding-right:0px; ">
            <label class="checkbox" style="margin-left:-5px;">
			<input <?php if(!empty($username)){?> checked <?php }?> type="checkbox" id="remember" name="remember" value="1" /> Nhớ đăng nhập </label>
			<button id="login" type="submit" class="btn blue pull-right" style="padding:5px 15px;">
            Đăng nhập <i class="m-icon-swapright m-icon-white"></i>
            </button>
			<input id="token" value="<?=$token;?>" type="hidden" />
			</div>
        </div>
			<!-- END PORTLET-->
	<div class="loading" style="display: none;">
		<div class="blockUI blockOverlay" style="width: 100%;height: 100%;top:0px;left:0px;position: absolute;background-color: rgb(0,0,0);opacity: 0.1;z-index: 1000;">
		</div>
		<div class="blockUI blockMsg blockElement" style="width: 30%;position: absolute;top: 33%;left:35%;text-align: center;">
			<img src="<?=url_tmpl()?>img/ajax_loader.gif" style="z-index: 2;position: absolute;"/>
		</div>
	</div> 
	<div style="color:#999; font-site:12px; margin-top:10px;"></div>
	<script type="text/javascript">
		var controller = '<?=base_url().$routes;?>/';
		$(function(){
			$("#reload").click(function(){
				var id = randomNumberFromRange(100,1000);
				$("#icaptcha").attr("src","<?=base_url()?>authorize/captcha/"+id+".html");
			});
			$("#login").click(function(){
				login();
			});	
		});
		function randomNumberFromRange(min,max){
			return Math.floor(Math.random()*(max-min+1)+min);
		}
		function keypressed(event){
			if(event.keyCode=='13'){
				login();
			}
		}
		function login(){
			$(".loading").show();
				var password = $("#password").val();
				var username = $("#username").val();
				var verification = $("#verification").val();
				var remember = $('#remember').is(':checked');
				if(remember){
					remember = 1;
				}
				else{
					remember = 0;
				}
				if(username == ''){
					error("Tài khoản không được trống.");
					$(".loading").hide(); return false;	
				}
				if(password == ''){
					error("Mật khẩu không được trống.");
					$(".loading").hide(); return false;	
				}
				if(verification == ''){
					error("Mã xác nhận không được trống.");
					$(".loading").hide(); return false;	
				}
				var token = $("#token").val();
				$.ajax({
					url : controller + 'login',
					type: 'POST',
					async: false,
					data: {csrf_stock_name:token,password:password , username:username,
					remember:remember,captcha:verification},
					success:function(datas){
						var obj = $.evalJSON(datas); 
						$("#token").val(obj.token); 
						if(obj.status == 1){
							window.location = "<?=base_url()?>orderroom.html";
							$(".loading").hide();	
						}
						else{
							var id = randomNumberFromRange(100,1000);
							$("#icaptcha").attr("src","<?=base_url()?>authorize/captcha/"+id+".html");
							error("Tài khoản, mật khẩu hoạc mã xác nhận không đúng.");
							$(".loading").hide();	
						}
					},
					error : function(){
						var id = randomNumberFromRange(100,1000);
						$("#icaptcha").attr("src","<?=base_url()?>authorize/captcha/"+id+".html");
					}
				});
		}
	</script>