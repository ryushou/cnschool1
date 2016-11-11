<?= View::forge('template/grid') ?>

<?= Asset::css('uploadfile.css');?>

<?= Asset::js('jquery.uploadfile.min.js');?>
<?= Asset::js('jquery.tooltip.js');?>
<?= Asset::js('jquery.hoverpulse.js');?>
<?= Asset::js('admin/order/info/input.js');?>

<div class="container content">
	<div class="panel panel-default">
		<div class="panel-heading">
			<i class="fa fa-check-square-o"></i>&nbsp;注文情報入力
			<span class="jquery-tooltip-class">
				&nbsp;<i class="fa fa-question-circle"></i>
				<span class="jquery-tooltip-content-class" style="display:none;">
					<div class="jquery-tooltip-content-title">画面についての説明</div>
					<div class="jquery-tooltip-content-body">
						注文情報を入力する画面です。<br/>
					</div>
				</span>
			</span>
		</div>
	</div>

	<div id="loading">
		<?= Asset::img('loading.gif') ?>
	</div>

	<form class="form-horizontal" role="form">
		<table class="table table-bordered table-hover common-list-table">
			<thead class="order-sheet-thead">
				<tr>
					<td>ご依頼状況</td>
					<td>管理者メモ</td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<div class="order-sheet-form-div">
							<?= Form::input('request_state_date', $order_info_array[0]->target_at, array('class'=>'order-sheet-form-date-admin form-control')); ?>
						</div>
						<div class="order-sheet-form-div">
							<?= Form::textarea('request_state_note', $order_info_array[0]->content, array('class'=>'order-sheet-form-textarea form-control', 'placeholder'=>'ご依頼状況')); ?>
						</div>
					</td>
					<td class="common-list-table-order-info">
						<div class="order-sheet-form-div">
							<?= Form::input('request_state_date_admin', $order_info_array[1]->target_at, array('class'=>'order-sheet-form-date-admin form-control')); ?>
						</div>
						<div class="order-sheet-form-div">
							<?= Form::textarea('request_state_note_admin', $order_info_array[1]->content, array('class'=>'order-sheet-form-textarea form-control', 'placeholder'=>'管理者メモ')); ?>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
		<table class="table table-bordered table-hover common-list-table">
			<thead class="order-sheet-thead">
				<tr>
					<td>参考URL</td>
					<td>管理者メモ</td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<div class="order-sheet-form-div">
							<?= Form::input('reference_url', $order_info_array[2]->content, array('class'=>'order-info-form-url form-control', 'placeholder'=>'参考URL')); ?>
						</div>
						<div class="order-sheet-form-div">
							<?= Form::textarea('reference_url_note', $order_info_array[2]->note, array('class'=>'order-sheet-form-textarea form-control', 'placeholder'=>'備考')); ?>
						</div>
					</td>
					<td class="common-list-table-order-info">
						<div class="order-sheet-form-div">
							<?= Form::input('reference_url_date_admin', $order_info_array[3]->target_at, array('class'=>'order-sheet-form-date-admin form-control')); ?>
						</div>
						<div class="order-sheet-form-div">
							<?= Form::textarea('reference_url_note_admin', $order_info_array[3]->content, array('class'=>'order-sheet-form-textarea form-control', 'placeholder'=>'管理者メモ')); ?>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
		<table class="table table-bordered table-hover common-list-table">
			<thead class="order-sheet-thead">
				<tr>
					<td>制約条件：予算・原価の限度額</td>
					<td>管理者メモ</td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<div class="order-sheet-form-div">
							<?= Form::input('budget_date', $order_info_array[4]->target_at, array('class'=>'order-sheet-form-date-admin form-control')); ?>
						</div>
						<div class="order-sheet-form-div">
							<?= Form::textarea('budget_note', $order_info_array[4]->content, array('class'=>'order-sheet-form-textarea form-control', 'placeholder'=>'制約条件：予算・原価の限度額')); ?>
						</div>
					</td>
					<td class="common-list-table-order-info">
						<div class="order-sheet-form-div">
							<?= Form::input('budget_date_admin', $order_info_array[5]->target_at, array('class'=>'order-sheet-form-date-admin form-control')); ?>
						</div>
						<div class="order-sheet-form-div">
							<?= Form::textarea('budget_note_admin', $order_info_array[5]->content, array('class'=>'order-sheet-form-textarea form-control', 'placeholder'=>'管理者メモ')); ?>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
		<table class="table table-bordered table-hover common-list-table">
			<thead class="order-sheet-thead">
				<tr>
					<td>その他サービス（検品含む）のご希望</td>
					<td>管理者メモ</td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<div class="order-sheet-form-div">
							<?= Form::input('other_date', $order_info_array[6]->target_at, array('class'=>'order-sheet-form-date-admin form-control')); ?>
						</div>
						<div class="order-sheet-form-div">
							<?= Form::textarea('other_note', $order_info_array[6]->content, array('class'=>'order-sheet-form-textarea form-control', 'placeholder'=>'その他サービス（検品含む）のご希望')); ?>
						</div>
					</td>
					<td class="common-list-table-order-info">
						<div class="order-sheet-form-div">
							<?= Form::input('other_date_admin', $order_info_array[7]->target_at, array('class'=>'order-sheet-form-date-admin form-control')); ?>
						</div>
						<div class="order-sheet-form-div">
							<?= Form::textarea('other_note_admin', $order_info_array[7]->content, array('class'=>'order-sheet-form-textarea form-control', 'placeholder'=>'管理者メモ')); ?>
						</div>
					</td>
				</tr>
			</tbody>
		</table>

		<table class="table table-bordered table-hover common-list-table">
			<thead class="order-sheet-thead">
				<tr>
					<td>ロゴ・タグ／アップロード</td>
					<td>備考</td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<a class="thumbnail" style="height: 63px; width: 90px;">
							<div class="image-div">
								<?php
									$attach_id = $order_attach->id;
									if(!Utility::is_empty($attach_id)) {
								?>
										<img class="image-hover" name="thumbnail" src="/order/attach/download/<?= $attach_id ?>" />
								<?php } else { ?>
										<img name="thumbnail" />
								<?php } ?>
							</div>
						</a>
						<div class="order-sheet-form-div">
							<div class="fileuploader">画像</div>
							<?= Form::hidden('attach_id', $order_attach->id); ?>
						</div>
					</td>
					<td class="common-list-table-order-info">
						<div class="order-sheet-form-div">
							<?= Form::textarea('attach_note', $order_attach->note, array('class'=>'order-sheet-form-textarea form-control', 'placeholder'=>'備考')); ?>
						</div>
					</td>
				</tr>
			</tbody>
		</table>

		<?= Form::hidden('order_info_id', $order_info_id); ?>
		<?= Form::hidden('order_attach_id', $order_attach->id); ?>
		<?= Form::hidden('user_id', $user_id); ?>
		<?= Form::hidden('order_id', $order_id); ?>

		<button type="button" class="btn btn-primary" id="update_button" data-loading-text="Loading...">
			<i class="fa fa-check"></i>&nbsp;更新
		</button>
	</form>
</div>
