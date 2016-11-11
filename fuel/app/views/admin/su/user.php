<?= Asset::js('jquery.tooltip.js');?>

<div class="container content">
	<div class="panel panel-default">
		<div class="panel-heading">
			<i class="fa fa-check-square-o"></i>&nbsp;管理ユーザ設定
			<span class="jquery-tooltip-class">
				&nbsp;<i class="fa fa-question-circle"></i>
				<span class="jquery-tooltip-content-class" style="display:none;">
					<div class="jquery-tooltip-content-title">画面についての説明</div>
					<div class="jquery-tooltip-content-body">
						管理ユーザを設定する画面です。<br/>
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
			<form action="<?= Uri::create("admin/su/user/registered") ?>" method="POST" class="form-horizontal" role="form">
				<div class="form-group">
					<label class="control-label" for="email">メールアドレス：</label>
					<div class="form-control-box">
						<input type="email" name="email" class="form-control" id="email" placeholder="" maxlength="35" value="<?= $user->email ?>" autofocus />&nbsp;※
					</div>
				</div>
				<div class="form-group">
					<label class="control-label" for="password">パスワード：</label>
					<div class="form-control-box">
						<input type="password" name="password" class="form-control" id="password" placeholder="" maxlength="20" value="" />&nbsp;※
					</div>
				</div>
				<div class="form-group">
					<label class="control-label" for="confirm_password">パスワード（確認）：</label>
					<div class="form-control-box">
						<input type="password" name="confirm_password" class="form-control" id="confirm_password" placeholder="" maxlength="20" value="" />&nbsp;※
					</div>
				</div>
				<div class="form-group">
					<label class="control-label" for="name">会員様名：</label>
					<div class="form-control-box">
						<input type="text" name="name" class="form-control" id="name" placeholder="" maxlength="30" value="<?= $user->name ?>" />&nbsp;※
					</div>
				</div>
				<div class="form-group">
					<label class="control-label" for="skype">スカイプID：</label>
					<div class="form-control-box">
						<input type="text" name="skype" class="form-control" id="skype" placeholder="" maxlength="32" value="<?= $user->skype_id ?>" />&nbsp;※
					</div>
				</div>
				<div class="form-group">
					<label class="control-label" for="chatwork">チャットワークID：</label>
					<div class="form-control-box">
						<input type="text" name="chatwork" class="form-control" id="chatwork" placeholder="" maxlength="50" value="<?= $user->chatwork_id ?>" />&nbsp;※
					</div>
				</div>
				<div class="form-group">
					<label class="control-label" for="form_group">管理者権限：</label>
					<div class="form-control-box">
						<?= Form::select('group', $user->group, Utility::get_constant_name('admin_group'), array('class'=>'form-control')); ?>&nbsp;※
					</div>
					<div class="form-control-box">
						<button type="submit" class="btn btn-primary">
							<i class="fa fa-check"></i>&nbsp;登録
						</button>
						<input type="hidden" name="user_id" value="<?= $user->id ?>" />
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
