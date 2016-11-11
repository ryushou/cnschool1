
<script>

$(function() {
	$(".dropdown-toggle").on('click', function() {
		if(!$(this).parent().hasClass('open')) {
			setTimeout(function() {
				$("#input_email").focus();
			}, 0);
		}
	});

	insert_csrf();
});

</script>

<div class="navbar navbar-inverse" role="navigation">
	<div class="container-fluid">
		 <div class="navbar-header">
		 	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-id">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
	        <a class="navbar-brand" href="<?= Uri::create("/") ?>">
		        <?= Asset::img(Config::get('constant.asset.logo'), array('id' => 'logo-header'));?>
	        </a>
	    </div>
		<?php if($login) { ?>
			<div class="collapse navbar-collapse navbar-responsive-collapse" id="navbar-collapse-id">
				<ul class="nav navbar-nav navbar-right">
					<?php if (Auth::has_access('web.menu')) { ?>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">残高 <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="<?= Uri::create("deposit/history") ?>"><i class="fa fa-sort-amount-asc"></i>&nbsp;&nbsp;残高履歴</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">注文 <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="<?= Uri::create("order/list") ?>"><i class="fa fa-list"></i>&nbsp;&nbsp;注文一覧</a></li>
								<li><a href="<?= Uri::create("order/sheet") ?>"><i class="fa fa-pencil-square-o"></i>&nbsp;&nbsp;注文シート</a></li>
								<li><a href="<?= Uri::create("order/sheet", array(), array('kbn' => Config::get('constant.order_kbn.kbn.oem'))) ?>"><i class="fa fa-pencil-square-o"></i>&nbsp;&nbsp;注文シート（OEM）</a></li>
								<li><a href="<?= Uri::create("order/history/list") ?>"><i class="fa fa-list"></i>&nbsp;&nbsp;注文履歴一覧</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">配送先 <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="<?= Uri::create("receiver/setting") ?>"><i class="fa fa-plane"></i>&nbsp;&nbsp;配送先設定</a></li>
							</ul>
						</li>
					<?php } ?>
					<?php if (Auth::has_access('admin.menu')) { ?>
						<?php if (Auth::has_access('order.list')) { ?>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">注文 <b class="caret"></b></a>
								<ul class="dropdown-menu">
									<li><a href="<?= Uri::create("admin/order/list") ?>"><i class="fa fa-list"></i>&nbsp;&nbsp;注文一覧</a></li>
								</ul>
							</li>
						<?php } ?>
						<?php if (Auth::has_access('admin_user.menu')) { ?>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">ユーザ <b class="caret"></b></a>
								<ul class="dropdown-menu">
									<?php if (Auth::has_access('user.list')) { ?>
										<li><a href="<?= Uri::create("admin/user/list") ?>"><i class="fa fa-user"></i>&nbsp;&nbsp;会員一覧</a></li>
									<?php } ?>
									<?php if (Auth::has_access('admin_user.list')) { ?>
										<li><a href="<?= Uri::create("admin/su/user/list") ?>"><i class="fa fa-user"></i>&nbsp;&nbsp;管理ユーザ一覧</a></li>
									<?php } ?>
								</ul>
							</li>
						<?php } ?>
						<?php if (Auth::has_access('master.update')) { ?>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">管理者 <b class="caret"></b></a>
								<ul class="dropdown-menu">
									<li><a href="<?= Uri::create("admin/payer") ?>"><i class="fa fa-share"></i>&nbsp;&nbsp;振込先マスタ</a></li>
									<li><a href="<?= Uri::create("admin/deliver") ?>"><i class="fa fa-plane"></i>&nbsp;&nbsp;配送元マスタ</a></li>
									<li><a href="<?= Uri::create("admin/site") ?>"><i class="fa fa-cog"></i>&nbsp;&nbsp;サイト設定</a></li>
								</ul>
							</li>
						<?php } ?>
					<?php } ?>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?= $user_name ?> <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<?php if (Auth::has_access('web.menu')) { ?>
								<li><a href="<?= Uri::create("account/modify") ?>"><i class="fa fa-user"></i>&nbsp;&nbsp;アカウント変更</a></li>
								<li><a href="<?= Uri::create("account/remove") ?>"><i class="fa fa-external-link"></i>&nbsp;&nbsp;退会処理</a></li>
							<?php } ?>
							<li><a href="<?= Uri::create("account/update") ?>"><i class="fa fa-wrench"></i>&nbsp;&nbsp;パスワード変更</a></li>
							<li><a href="<?= Uri::create("auth/logout") ?>"><i class="fa fa-sign-out"></i>&nbsp;&nbsp;ログアウト</a></li>
						</ul>
					</li>
				</ul>
			</div>
		<?php } else { ?>
			<div class="collapse navbar-collapse navbar-responsive-collapse" id="navbar-collapse-id">				
			</div>
		<?php } ?>
	</div>
</div>
