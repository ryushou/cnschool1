<?= Asset::js('jquery.tooltip.js');?>

<div class="container content">
	<div class="panel panel-default">
		<div class="panel-heading">
			<i class="fa fa-check-square-o"></i>&nbsp;会員設定
			<span class="jquery-tooltip-class">
				&nbsp;<i class="fa fa-question-circle"></i>
				<span class="jquery-tooltip-content-class" style="display:none;">
					<div class="jquery-tooltip-content-title">画面についての説明</div>
					<div class="jquery-tooltip-content-body">
						会員情報を設定する画面です。<br/>
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
			<form action="<?= Uri::create("admin/user/registered") ?>" method="POST" class="form-horizontal" role="form">
				<div class="form-group">
					<label class="control-label" for="name">会員様名：</label>
					<div class="form-control-box">
						<input type="text" name="name" class="form-control" id="name" placeholder="" maxlength="30" value="<?= $users->name ?>" autofocus />&nbsp;※
					</div>
				</div>
				<div class="form-group">
					<label class="control-label" for="zip1">郵便番号：</label>
					<div class="form-control-box">
						<input type="text" name="zip1" size="4" maxlength="3" class="form-control-75 form-control" id="zip1" placeholder="" value="<?= $zip1 ?>" />
						<label class="control-label control-label-30" for="zip2">－</label>
						<div class="form-control-box">
							<input type="text" name="zip2" size="5" maxlength="4" class="form-control-75 form-control" id="zip2" placeholder="" value="<?= $zip2 ?>" />&nbsp;※
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label" for="address1">住所1：</label>
					<div class="form-control-box">
						<input type="text" name="address1" class="form-control" id="address1" placeholder="" maxlength="100" value="<?= $profile_fields['address1'] ?>" />&nbsp;※
					</div>
				</div>
				<div class="form-group">
					<label class="control-label" for="address2">住所2：</label>
					<div class="form-control-box">
						<input type="text" name="address2" class="form-control" id="address2" placeholder="" maxlength="100" value="<?= $profile_fields['address2'] ?>" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label" for="phone">電話番号：</label>
					<div class="form-control-box">
						<input type="text" name="phone" class="form-control" id="phone" placeholder="電話番号（-ハイフンあり）" value="<?= $profile_fields['phone'] ?>" />&nbsp;※
					</div>
				</div>
				<div class="form-group">
					<label class="control-label" for="email">メールアドレス：</label>
					<div class="form-control-box">
						<input type="email" name="email" class="form-control" id="email" placeholder="" maxlength="35" value="<?= $users->email ?>" />&nbsp;※
					</div>
				</div>
				<div class="form-group">
					<label class="control-label" for="skype">スカイプID：</label>
					<div class="form-control-box">
						<input type="text" name="skype" class="form-control" id="skype" placeholder="" maxlength="32" value="<?= $users->skype_id ?>" />&nbsp;※
					</div>
				</div>
				<div class="form-group">
					<label class="control-label" for="chatwork">チャットワークID：</label>
					<div class="form-control-box">
						<input type="text" name="chatwork" class="form-control" id="chatwork" placeholder="" maxlength="50" value="<?= $users->chatwork_id ?>" />&nbsp;※
					</div>
				</div>
				<div class="form-group">
					<label class="control-label" for="form_member_rank">会員ランク：</label>
					<div class="form-control-box">
						<?= Form::select('member_rank', $users->member_rank, Utility::get_constant_name('member_rank'), array('class'=>'form-control')); ?>&nbsp;※
					</div>
				</div>
				<div class="form-group">
					<label class="control-label" for="form_order_detail_count">注文明細数：</label>
					<div class="form-control-box">
						<?= Form::input('order_detail_count', $users->order_detail_count, array('class'=>'form-control')); ?>&nbsp;※
					</div>
					<div class="form-control-box">
						<button type="submit" class="btn btn-primary">
							<i class="fa fa-check"></i>&nbsp;登録
						</button>
						<input type="hidden" name="user_id" value="<?= $users->id ?>" />
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
