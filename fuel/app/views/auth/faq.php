<?php Asset::add_path('assets/plugins/', 'js');  ?>

<!-- CSS Global Compulsory -->
<?= Asset::css('theme/top.css');?>

<!-- CSS Page Style -->
<?= Asset::css('theme/pages/page_faq1.css');?>

<!-- CSS Theme -->
<?= Asset::css('theme/themes/orange.css');?>

<!--=== Breadcrumbs ===-->
<div class="breadcrumbs">
    <div class="container">
        <h1 class="pull-left">よくある質問</h1>
        <ul class="pull-right breadcrumb">
            <li><a href="<?= Uri::create("/") ?>">トップページ</a></li>
            <li class="active">よくある質問</li>
        </ul>
    </div>
</div><!--/breadcrumbs-->
<!--=== End Breadcrumbs ===-->

<!-- JS Implementing Plugins -->
<?= Asset::js('back-to-top.js');?>