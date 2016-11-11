<!DOCTYPE html>
<!--[if IE 8]> <html lang="ja" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="ja" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="ja"> <!--<![endif]-->
<head>
	<title><?= $title ?> - グローバル・トレード・サービス｜GTS - </title>

	<meta charset="UTF-8">
	<meta content="width=device-width, initial-scale=1.0" name="viewport">
	<meta name="google-site-verification" content="mm58GbhItm6JjoNUIo5sWryE7V8yYQxiud_zL7gvhA8" />

	<?= html_tag('link', array( 'rel' => 'shortcut icon', 'type' => 'image/vnd.microsoft.icon', 'href' => Asset::get_file('favicon.ico', 'img'), ) ); ?>
	<?= html_tag('link', array( 'rel' => 'icon', 'type' => 'image/vnd.microsoft.icon', 'href' => Asset::get_file('favicon.ico', 'img'), ) ); ?>

	<?= Asset::css('bootstrap.min.css');?>
	<?= Asset::css('bootstrap-theme.min.css');?>
	<?= Asset::css('font-awesome/css/font-awesome.min.css');?>

	<?= Asset::css('style.css');?>

	<?= Asset::js('jquery-1.11.0.min.js');?>
	<?= Asset::js('bootstrap.min.js');?>
	<?= Asset::js('common.js');?>

	<?= View::forge('template/common') ?>
</head>
<body>
	<div class="wrapper">
		<div class="content-wrapper">
			<div class="header">
				<?= View::forge('template/header') ?>
			</div>
			<?= $content ?>
		</div>
		<div class="footer">
			<div class="container">
				<p>
					<a href="<?= Uri::create("/") ?>">
						
                    </a>
                </p>
			</div>
		</div>
		<div class="copyright">
			<div class="container">
				<div class="row">
	                <div class="col-md-12">
	                    <p>
	                        2015 &copy; GTS. All Rights Reserved. 
	                        <a href="<?= Uri::create("auth/faq") ?>">よくある質問</a> | <a href="<?= Uri::create("auth/manual") ?>">マニュアル</a> | <a href="<?= Uri::create("auth/privacy") ?>">プライバシーポリシー</a> | <a href="<?= Uri::create("auth/terms") ?>">サービス利用規約</a> | <a href="<?= Uri::create("auth/scta") ?>">特定商取引法</a>
	                    </p>
	                </div>
	            </div>
            </div>
		</div>
	</div>
</body>
</html>