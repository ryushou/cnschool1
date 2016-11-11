<div class="container content">	<?php if($errmsg != "") { ?>		<div class="alert alert-danger"><?= $errmsg ?></div>	<?php } ?>	<div class="panel panel-default">		<div class="panel-heading">			<i class="fa fa-check-square-o"></i>&nbsp;アカウント作成		</div>		<div class="panel-body">			<form action="<?= Uri::create("auth/created") ?>" method="POST" class="form-horizontal" role="form">				<div class="form-group">					<label class="control-label" for="inputName">会員様名：</label>					<div class="form-control-box">						<input type="text" name="name" class="form-control" id="inputName" placeholder="" maxlength="30" value="<?= $user->name ?>" autofocus />&nbsp;※					</div>				</div>				<div class="form-group">					<label class="control-label" for="inputPassword">パスワード：</label>					<div class="form-control-box">						<input type="password" name="password" class="form-control" id="inputPassword" placeholder="" maxlength="20" value="" />&nbsp;※					</div>				</div>				<div class="form-group">					<label class="control-label" for="inputPassword_re">パスワード再入力：</label>					<div class="form-control-box">						<input type="password" name="password_re" class="form-control" id="inputPassword_re" placeholder="" maxlength="20" value="" />&nbsp;※					</div>				</div>				<div class="form-group">					<label class="control-label" for="inputZip1">郵便番号：</label>					<div class="form-control-box">						<input type="text" name="zip1" size="4" maxlength="3" class="form-control-75 form-control" id="inputZip1" placeholder="" value="<?= $zip1 ?>" />						<label class="control-label control-label-30" for="inputZip2">－</label>						<div class="form-control-box">							<input type="text" name="zip2" size="5" maxlength="4" class="form-control-75 form-control" id="inputZip2" placeholder="" value="<?= $zip2 ?>" />&nbsp;※						</div>					</div>				</div>				<div class="form-group">					<label class="control-label" for="inputAddress1">住所1：</label>					<div class="form-control-box">						<input type="text" name="address1" class="form-control" id="inputAddress1" placeholder="" maxlength="100" value="<?= $profile_fields['address1'] ?>" />&nbsp;※					</div>				</div>				<div class="form-group">					<label class="control-label" for="inputAddress2">住所2：</label>					<div class="form-control-box">						<input type="text" name="address2" class="form-control" id="inputAddress2" placeholder="" maxlength="100" value="<?= $profile_fields['address2'] ?>" />					</div>				</div>				<div class="form-group">					<label class="control-label" for="inputPhone">電話番号：</label>					<div class="form-control-box">						<input type="text" name="phone" class="form-control" id="inputPhone" placeholder="電話番号（-ハイフンあり）" value="<?= $profile_fields['phone'] ?>" />&nbsp;※					</div>				</div>				<div class="form-group">					<label class="control-label" for="inputEmail">メールアドレス：</label>					<div class="form-control-box">						<input type="email" name="email" class="form-control" id="inputEmail" placeholder="" maxlength="35" value="<?= $user->email ?>" />&nbsp;※					</div>				</div>				<div class="form-group">					<label class="control-label" for="inputSkype">スカイプID：</label>					<div class="form-control-box">						<input type="text" name="skype_id" class="form-control" id="inputSkype" placeholder="" maxlength="32" value="<?= $user->skype_id ?>" />&nbsp;※お持ちでない場合は0000を入力して下さい。					</div>				</div>				<div class="form-group">					<label class="control-label" for="inputChatwork">チャットワークID：</label>					<div class="form-control-box">						<input type="text" name="chatwork_id" class="form-control" id="inputChatwork" placeholder="" maxlength="50" value="<?= $user->chatwork_id ?>" />&nbsp;※					</div>					<div class="form-control-box">						<button type="submit" class="btn btn-primary">							<i class="fa fa-user"></i>&nbsp;アカウント作成						</button>					</div>				</div>			</form>		</div>	</div></div>