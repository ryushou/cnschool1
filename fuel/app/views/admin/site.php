<?= Asset::js('jquery.tooltip.js');?>

<div class="container content">
	<div class="panel panel-default">
		<div class="panel-heading">
			<i class="fa fa-check-square-o"></i>&nbsp;サイト設定
			<span class="jquery-tooltip-class">
				&nbsp;<i class="fa fa-question-circle"></i>
				<span class="jquery-tooltip-content-class" style="display:none;">
					<div class="jquery-tooltip-content-title">画面についての説明</div>
					<div class="jquery-tooltip-content-body">
						為替レートを設定する画面です。<br/>
						為替レートを登録、更新することができます。<br/>
					</div>
				</span>
			</span>
		</div>
		<div class="panel-body">
			<?php if($infomsg != "") { ?>
				<div class="alert alert-success"><?= $infomsg ?></div>
			<?php } ?>
			<?php if($errmsg != "") { ?>
				<div class="alert alert-danger"><?= $errmsg ?></div>
			<?php } ?>
			<form action="<?= Uri::create("admin/site/registered") ?>" method="POST" class="form-horizontal" role="form">
				<div class="form-group">
					<label class="control-label" for="rate">為替レート：</label>
					<div class="form-control-box">
						<input type="text" name="rate" class="form-control" id="rate" placeholder="" maxlength="13" value="<?= $currency->rate ?>" />&nbsp;※
					</div>
				</div>
				<div class="form-group">
					<label class="control-label" for="updated_at">更新時間：</label>
					<div class="form-control-box">
						<input type="text" name="updated_at" class="form-control" id="updated_at" value="<?= $currency->updated_at ?>" disabled="disabled" />&nbsp;
					</div>
					<div class="form-control-box">
						<button type="submit" id="register_btn" class="btn btn-primary" data-loading-text="Loading...">
							<i class="fa fa-check"></i>&nbsp;登録
						</button>
					</div>
				</div>
			</form>
		</div>	
	</div>
</div>
