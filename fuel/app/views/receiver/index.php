<?= View::forge('template/grid') ?>

<?= Asset::js('jquery.tooltip.js');?>
<?= Asset::js('receiver/index.js');?>

<div class="container content">
	<div class="panel panel-default">
		<div class="panel-heading">
			<i class="fa fa-check-square-o"></i>&nbsp;配送先設定
			<span class="jquery-tooltip-class">
				&nbsp;<i class="fa fa-question-circle"></i>
				<span class="jquery-tooltip-content-class" style="display:none;">
					<div class="jquery-tooltip-content-title">画面についての説明</div>
					<div class="jquery-tooltip-content-body">
						配送先を設定する画面です。<br/>
						配送先を登録、更新、削除することができます。<br/>
						また登録された配送先の一覧を表示することができます。<br/>
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

			<form action="<?= Uri::create("receiver/setting/registered") ?>" method="POST" class="form-horizontal" role="form">
				<div class="form-group">
					<label class="control-label" for="receiver_id">No：</label>
					<div class="form-control-box">
						<input type="text" name="receiver_id" class="form-control" id="receiver_id" value="<?= $receiver->id ?>" readonly="readonly" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label" for="receiver">配送先名：</label>
					<div class="form-control-box">
						<input type="text" name="receiver" class="form-control" id="receiver" placeholder="" maxlength="50" value="<?= $receiver->receiver ?>" />&nbsp;※
					</div>
				</div>
				<div class="form-group">
					<label class="control-label" for="zip1">郵便番号：</label>
					<div class="form-control-box">
						<input type="text" name="zip1" size="4" maxlength="3" class="form-control-75 form-control" id="zip1" placeholder="" value="<?= $receiver->zip1 ?>" />
						<label class="control-label control-label-30" for="zip2">－</label>
						<div class="form-control-box">
							<input type="text" name="zip2" size="5" maxlength="4" class="form-control-75 form-control" id="zip2" placeholder="" value="<?= $receiver->zip2 ?>" />&nbsp;※
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label" for="address1">住所1：</label>
					<div class="form-control-box">
						<input type="text" name="address1" class="form-control" id="address1" placeholder="" maxlength="100" value="<?= $receiver->address1 ?>" />&nbsp;※
					</div>
				</div>
				<div class="form-group">
					<label class="control-label" for="address2">住所2：</label>
					<div class="form-control-box">
						<input type="text" name="address2" class="form-control" id="address2" placeholder="" maxlength="100" value="<?= $receiver->address2 ?>" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label" for="phone">電話番号：</label>
					<div class="form-control-box">
						<input type="text" name="phone" class="form-control" id="phone" placeholder="" maxlength="15" value="<?= $receiver->phone ?>" />&nbsp;※
					</div>
				</div>
				<div class="form-group">
					<label class="control-label" for="name">宛名：</label>
					<div class="form-control-box">
						<input type="text" name="name" class="form-control" id="name" placeholder="" maxlength="50" value="<?= $receiver->name ?>" />&nbsp;※
					</div>
				</div>
				<div class="form-group">
					<label class="control-label" for="form_fba_flg">配送先区分：</label>
					<div class="form-control-box">
						<?= Form::select('fba_flg', $receiver->fba_flg, Utility::get_constant_name('address_kind'), array('class'=>'form-control')); ?>&nbsp;※
					</div>
					<div class="form-control-box">
						<button type="submit" id="register_btn" class="btn btn-primary" data-loading-text="Loading...">
							<i class="fa fa-check"></i>&nbsp;登録
						</button>
						<button type="button" class="btn btn-primary" id="reset_button" data-loading-text="Loading...">
							<i class="fa fa-minus"></i>&nbsp;リセット
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>

	<div id="loading">
		<?= Asset::img('loading.gif') ?>
	</div>

	<div id="info_delete_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h5 class="modal-title"><i class="fa fa-exclamation-circle"></i>&nbsp;配送先削除の確認</h5>
				</div>
				<div class="modal-body">配送先を削除しますか？</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" id="delete_button" data-loading-text="Loading...">削除する</button>
					<button type="button" class="btn btn-primary" data-dismiss="modal">いいえ</button>
					<input type="hidden" id="receiver_id_modal" value="" />
				</div>
			</div>
		</div>
	</div>

	<table class="table table-bordered table-hover common-list-table receiver-list-table">
		<thead class="receiver-list-thead">
			<tr>
				<td class="common-list-table-short">No.</td>
				<td class="common-list-table-short">配送先名</td>
				<td class="common-list-table-short">郵便番号</td>
				<td class="common-list-table-middle">住所1</td>
				<td class="common-list-table-middle">住所2</td>
				<td class="common-list-table-short">電話番号</td>
				<td class="common-list-table-short">宛名</td>
				<td class="common-list-table-short">配送先区分</td>
				<td class="common-list-table-short"></td>
				<td class="common-list-table-short"></td>
			</tr>
		</thead>
		<tbody id="output_result"></tbody>
		<script id="output_template" type="text/x-jquery-tmpl">
			{{each data}}
			<tr>
				<td>${$index+1}</td>
				<td>${receiver}</td>
				<td>${zip1}-${zip2}</td>
				<td>${address1}</td>
				<td>${address2}</td>
				<td>${phone}</td>
				<td>${name}</td>
				<td>${fba_flg}</td>
				<td>
					<button type="button" class="btn btn-success update_btn" value="${id}" data-loading-text="Loading...">
						<i class="fa fa-check"></i>&nbsp;変更
					</button>
				</td>
				<td>
					<button type="button" class="btn btn-danger delete_btn" value="${id}" data-loading-text="Loading...">
						<i class="fa fa-minus"></i>&nbsp;削除
					</button>
				</td>
			</tr>
			{{/each}}
		</script>
	</table>
</div>
