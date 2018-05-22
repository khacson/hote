<!-- BEGIN TOP NAVIGATION MENU -->
		<ul class="nav navbar-nav pull-right">
			<!-- BEGIN NOTIFICATION DROPDOWN -->
			<li class="dropdown" id="header_notification_bar">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
					<i class="fa fa-warning"></i>
					<span class="badge">
						1
					</span>
				</a>
				<ul class="dropdown-menu extended notification">
					<li>
						<p>
							 Đơn hàng
						</p>
					</li>
					<li>
						<ul class="dropdown-menu-list scroller" style="max-height: 250px; height:200px;">
							<?php foreach($orders as $item){?>
							<li>
								<a href="#">
									 PO
								</a>
							</li>
							<?php }?>
						</ul>
					</li>
					<li class="external">
						<a href="<?=base_url();?>createorders.html">
							Xem thêm <i class="m-icon-swapright"></i>
						</a>
					</li>
				</ul>
			</li>
			<!-- END NOTIFICATION DROPDOWN -->
			<!-- BEGIN INBOX DROPDOWN -->
			<li class="dropdown" id="header_inbox_bar">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
					<i class="fa fa-envelope"></i>
					<span class="badge">
						 5
					</span>
				</a>
				<ul class="dropdown-menu extended inbox">
					<li>
						<p>
							Công nợ bán hàng
						</p>
					</li>
					<li>
						<a href="#">
							 Khánh hàng A - 150 triệu
						</a>
					</li>
					<li>
						<a href="#">
							 Khánh hàng B - 100 triệu
						</a>
					</li>
					<li>
						<a href="#">
							 Khánh hàng C - 250 triệu
						</a>
					</li>
					<li>
						<a href="#">
							 Khánh hàng D - 550 triệu
						</a>
					</li>
					<li>
						<a href="#">
							 Khánh hàng E - 350 triệu
						</a>
					</li>
					<li class="external">
						<a href="#" >
							 Xem thêm <i class="m-icon-swapright"></i>
						</a>
					</li>
				</ul>
			</li>
			<!-- END INBOX DROPDOWN -->
			<!-- BEGIN TODO DROPDOWN -->
			<!-- BEGIN USER LOGIN DROPDOWN -->
			<li class="dropdown user">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
					<!--<img alt="" src="<?=url_tmpl();?>assets/img/avatar1_small.jpg" />-->
					<span class="username">
						 <?=$logins->fullname;?>
					</span>
					<i class="fa fa-angle-down"></i>
				</a>
				<ul class="dropdown-menu">
					<li>
						<a href="#">
							<i class="fa fa-user"></i> <?=getLanguage('my-profile');?>
						</a>
					</li>
					<li>
						<a href="javascript:;" id="trigger_fullscreen">
							<i class="fa fa-arrows"></i> <?=getLanguage('full-screen');?>
						</a>
					</li>
					<li>
						<a href="<?=base_url();?>authorize/logout.html">
							<i class="fa fa-key"></i> <?=getLanguage('thoat');?>
						</a>
					</li>
				</ul>
			</li>
			<!-- END USER LOGIN DROPDOWN -->
		</ul>
		<!-- END TOP NAVIGATION MENU -->