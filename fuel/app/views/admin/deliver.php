<?= View::forge('template/grid') ?>

<?= Asset::js('jquery.tooltip.js');?>
<?= Asset::js('admin/deliver.js');?>

<div class="container content">
	<div class="panel panel-default">
		<div class="panel-heading">
			<i class="fa fa-check-square-o"></i>&nbsp;配送元マスタ
			<span class="jquery-tooltip-class">
				&nbsp;<i class="fa fa-question-circle"></i>
				<span class="jquery-tooltip-content-class" style="display:none;">
					<div class="jquery-tooltip-content-title">画面についての説明</div>
					<div class="jquery-tooltip-content-body">
						配送元を設定する画面です。<br/>
						配送元を登録、更新、削除することができます。<br/>
						また登録された配送元の一覧を表示することができます。<br/>
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

			<form action="<?= Uri::create("admin/deliver/registered") ?>" method="POST" class="form-horizontal" role="form">
				<div class="form-group">
					<label class="control-label" for="deliver_id">No：</label>
					<div class="form-control-box">
						<input type="text" name="deliver_id" class="form-control" id="deliver_id" value="<?= $deliver->id ?>" readonly="readonly" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label" for="deliver_name">配送元名：</label>
					<div class="form-control-box">
						<input type="text" name="deliver_name" class="form-control" id="deliver_name" placeholder="" maxlength="50" value="<?= $deliver->name ?>" />&nbsp;※
					</div>
				</div>
				<div class="form-group">
					<label class="control-label" for="deliver_kbn">配送元区分：</label>
					<div class="form-control-box">
						<?= Form::select('deliver_kbn', $deliver->kbn, Utility::get_constant_name('deliver_kbn'), array('class'=>'form-control')); ?>
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
					<h5 class="modal-title"><i class="fa fa-exclamation-circle"></i>&nbsp;配送元削除の確認</h5>
				</div>
				<div class="modal-body">配送元を削除しますか？</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" id="delete_button" data-loading-text="Loading...">削除する</button>
					<button type="button" class="btn btn-primary" data-dismiss="modal">いいえ</button>
					<input type="hidden" id="deliver_id_modal" value="" />
				</div>
			</div>
		</div>
	</div>

	<table class="table table-bordered table-hover common-list-table deliver-list-table">
		<thead class="deliver-list-thead">
			<tr>
				<td class="common-list-table-short">No.</td>
				<td class="common-list-table-short">配送元名</td>
				<td class="common-list-table-short">配送元区分</td>
				<td class="common-list-table-short"></td>
				<td class="common-list-table-short"></td>
			</tr>
		</thead>
		<tbody id="output_result"></tbody>
		<script id="output_template" type="text/x-jquery-tmpl">
			{{each data}}
			<tr>
				<td>${$index+1}</td>
				<td>${name}</td>
				<td>${kbn_name}</td>
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
