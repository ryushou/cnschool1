<?= Asset::js('jquery.tooltip.js');?>
<?= Asset::js('bignumber.min.js');?>
<?= Asset::js('admin/deposit/input.js');?>

<script>
   	var DEPOSIT_STATUS_RECEIPT = "<?= Config::get('constant.deposit_status.kbn.receipt') ?>";
</script>

<div class="container content">
	<div class="panel panel-default">
		<div class="panel-heading">
			<i class="fa fa-check-square-o"></i>&nbsp;入出金入力
			<span class="jquery-tooltip-class">
				&nbsp;<i class="fa fa-question-circle"></i>
				<span class="jquery-tooltip-content-class" style="display:none;">
					<div class="jquery-tooltip-content-title">画面についての説明</div>
					<div class="jquery-tooltip-content-body">
						入出金入力する画面です。<br/>
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

			<form action="<?= Uri::create("admin/deposit/input/registered") ?>" method="POST" class="form-horizontal" role="form">
				<div class="form-group">
					<label class="control-label" for="name">会員様名：</label>
					<div class="form-control-box">
						<input type="text" name="name" class="form-control" id="name" maxlength="30" value="<?= $user->name ?>" disabled />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label" for="form_deposit_kbn">区分：</label>
					<div class="form-control-box">
						<?= Form::select('deposit_kbn', $deposit->deposit_kbn, Utility::get_constant_name('deposit_status'), array('class'=>'form-control')); ?>&nbsp;※
					</div>
				</div>
				<div class="form-group">
					<label class="control-label" for="amount">金額：</label>
					<div class="form-control-box">
						<input type="text" name="amount" class="form-control" id="amount" maxlength="7" value="" />&nbsp;<span id="deposit_mark">円加算</span>&nbsp;※
					</div>
				</div>
				<div class="form-group payer_input_area">
					<label class="control-label" for="form_payers_id">振込先：</label>
					<div class="form-control-box">
						<?= Form::select('payers_id', '', Utility::get_deposit_input_payer_select(), array('class'=>'form-control')); ?>&nbsp;※
					</div>
				</div>
				<div class="form-group">
					<label class="control-label" for="deposit">残高：</label>
					<div class="form-control-box">
						<input type="text" name="deposit" class="form-control" id="deposit" maxlength="7" value="<?= $user->deposit ?>" disabled />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label" for="reason">入出金理由：</label>
					<div class="form-control-box">
						<input type="text" name="reason" class="form-control" id="reason" maxlength="15" value="<?= $deposit->reason ?>" />&nbsp;※
					</div>
				</div>
				<div class="form-group">
					<label class="control-label" for="note">備考：</label>
					<div class="form-control-box">
						<input type="text" name="note" class="form-control" id="note" maxlength="15" value="<?= $deposit->note ?>" />
					</div>
					<div class="form-control-box">
						<button type="submit" class="btn btn-primary">
							<i class="fa fa-check"></i>&nbsp;登録
						</button>
						<input type="hidden" name="user_id" value="<?= $user->id ?>" />
						<input type="hidden" name="updated_at" value="<?= $user->updated_at ?>" />
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
