
<?= Asset::js('jquery.tooltip.js');?>
<?= Asset::js('order/message.js');?>

<div class="container content">
	<div class="panel panel-default">
		<div class="panel-heading">
			<i class="fa fa-check-square-o"></i>&nbsp;注文メッセージ履歴
			<span class="jquery-tooltip-class">
				&nbsp;<i class="fa fa-question-circle"></i>
				<span class="jquery-tooltip-content-class" style="display:none;">
					<div class="jquery-tooltip-content-title">画面についての説明</div>
					<div class="jquery-tooltip-content-body">
						注文でやり取りしたメッセージの履歴を表示します。<br/>
					</div>
				</span>
			</span>
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
					<h5 class="modal-title"><i class="fa fa-exclamation-circle"></i>&nbsp;メッセージ削除の確認</h5>
				</div>
				<div class="modal-body">メッセージを削除しますか？</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" id="delete_button" data-loading-text="Loading...">削除する</button>
					<button type="button" class="btn btn-primary" data-dismiss="modal">いいえ</button>
					<input type="hidden" id="message_id_modal" value="" />
				</div>
			</div>
		</div>
	</div>

	<div class="order-message-history">
		<div class="row">
			<?php $user_id = Utility::get_user_id(); ?>
			<?php foreach ($messages as $idx => $message) { ?>
				<?php $is_user = $message->users->group == Config::get('constant.user_group.kbn.user'); ?>
				<div class="col-md-8">
					<div class="media">
						<a class="pull-left" href="#">
							<?php $user_icon = $is_user ? 'user.png' : 'user2.png'; ?>
			                <?= Asset::img($user_icon, array('class' => 'media-object'));?>
		                </a>
						<div class="media-body">
							<h4 class="media-heading">
								<?= $message->users->name ?>
								<span class="meta1">
									<?= Utility::get_human_timing($message->created_at) ?> (<?= $message->created_at ?>)&nbsp;/&nbsp;
									<?php if($user_id == $message->user_id) { ?>
										<a href="#" class="message-delete" value="<?= $message->id ?>">削除</a>
									<?php } else { ?>
										送信
									<?php } ?>
								</span>
								<span class="meta2">
									<?php if($message->readed_flg == Config::get('constant.order_message.kbn.unread')) { ?>
										<a href="#" class="unread">未読</a>
									<?php } else { ?>
										<?= Utility::get_human_timing($message->readed_at) ?> / <a href="#" class="readed">開封</a>
									<?php } ?>
								</span>
							</h4>
							<pre><?= $message->message ?></pre>
						</div>
					</div>
				</div>
				<div class="clearfix"></div>
				<hr>
			<?php } ?>
		</div>
	</div>
</div>
