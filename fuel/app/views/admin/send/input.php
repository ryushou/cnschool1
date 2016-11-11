<?= View::forge('template/grid') ?>

<?= Asset::js('jquery.tooltip.js');?>
<?= Asset::js('bignumber.min.js');?>
<?= Asset::js('admin/send/input.js');?>

<script>
	<?php
		$order = Model_Order_Jnl::select_primary_admin($send_jnl->order_id);
	?>
   	var CURRENCY_RATE = BigNumber(<?= $order->cny_jpy_rate ?>);
</script>

<div class="container content">
	<form class="form-horizontal" role="form">
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-check-square-o"></i>&nbsp;発送伝票入力
				<span class="jquery-tooltip-class">
					&nbsp;<i class="fa fa-question-circle"></i>
					<span class="jquery-tooltip-content-class" style="display:none;">
						<div class="jquery-tooltip-content-title">画面についての説明</div>
						<div class="jquery-tooltip-content-body">
							発送伝票を設定する画面です。<br/>
							発送伝票を登録、更新、削除することができます。<br/>
							また登録されている発送伝票の一覧を表示することができます。<br/>
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
				<div class="form-group">
					<label class="control-label" for="form_delivery_date">配送日付：</label>
					<div class="form-control-box">
						<?= Form::input('delivery_date', $send_jnl->delivery_date, array('class'=>'form-control')); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label" for="form_total_box">箱数：</label>
					<div class="form-control-box">
						<?= Form::input('total_box', $send_jnl->total_box, array('class'=>'form-control')); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label" for="form_weight">重量（kg）：</label>
					<div class="form-control-box">
						<?= Form::input('weight', $send_jnl->weight, array('class'=>'form-control')); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label" for="form_delivery_fee_cny">送料（元）：</label>
					<div class="form-control-box">
						<?= Form::input('delivery_fee_cny', $send_jnl->delivery_fee_cny, array('class'=>'form-control')); ?>
					</div>
					<div class="form-control-box">
						<button type="button" id="calc_delivery_fee_button" class="btn btn-success" data-loading-text="Loading...">
							<i class="fa fa-calculator"></i>&nbsp;自動計算
						</button>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label" for="form_delivery_fee">送料（円）：</label>
					<div class="form-control-box">
						<?= Form::input('delivery_fee', number_format($send_jnl->delivery_fee), array('class'=>'form-control', 'disabled' => '')); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label" for="form_delivery_name">配送業者：</label>
					<div class="form-control-box">
						<?= Form::select('delivery_name', $send_jnl->delivery_name, Utility::get_deliver_select(Config::get('constant.deliver_kbn.kbn.foreign')), array('class'=>'form-control')); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label" for="form_send_no">追跡番号：</label>
					<div class="form-control-box">
						<?= Form::input('send_no', $send_jnl->send_no, array('class'=>'form-control')); ?>
					</div>
					<div class="form-control-box">
						<button type="button" id="update_button" class="btn btn-primary" data-loading-text="Loading...">
							<i class="fa fa-check"></i>&nbsp;登録
						</button>
						<button type="button" class="btn btn-primary" id="reset_button" data-loading-text="Loading...">
							<i class="fa fa-minus"></i>&nbsp;リセット
						</button>
						<?php if($send_jnl->id != '') { ?>
							<?php if($send_jnl->send_mail_flg == Config::get('constant.send_mail_flg.kbn.unsend')) { ?>
								<button type="button" id="send_mail_button" class="btn btn-success" data-loading-text="Loading...">
									<i class="fa fa-envelope"></i>&nbsp;メール送信
								</button>
							<?php } else { ?>
								<button type="button" id="send_mail_button" class="btn btn-warning" data-loading-text="Loading...">
									<i class="fa fa-envelope"></i>&nbsp;メール再送する
								</button>
							<?php } ?>
						<?php } ?>
						<?php if($send_jnl->id) { ?>
							<button type="button" class="btn btn-success" id="download_button" data-loading-text="Loading...">
								<i class="fa fa-download"></i>&nbsp;ダウンロード
							</button>
						<?php } else { ?>
							<button type="button" class="btn btn-success" id="download_button" data-loading-text="Loading..." disabled>
								<i class="fa fa-download"></i>&nbsp;ダウンロード
							</button>
						<?php } ?>
					</div>
				</div>
				<?= Form::hidden('send_id', $send_jnl->id); ?>
				<?= Form::hidden('order_id', $send_jnl->order_id); ?>
				<?= Form::hidden('user_id', $send_jnl->user_id); ?>
			</div>
		</div>
	</form>

	<div id="loading">
		<?= Asset::img('loading.gif') ?>
	</div>

	<div id="info_delete_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h5 class="modal-title"><i class="fa fa-exclamation-circle"></i>&nbsp;発送伝票明細削除の確認</h5>
				</div>
				<div class="modal-body">発送伝票明細を削除しますか？</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" id="delete_button" data-loading-text="Loading...">削除する</button>
					<button type="button" class="btn btn-primary" data-dismiss="modal">いいえ</button>
					<?= Form::hidden('send_detail_id_modal', ''); ?>
				</div>
			</div>
		</div>
	</div>

	<form role="form">
		<table class="table table-bordered table-hover common-list-table send-input-list-table">
			<thead class="send-input-list-thead">
				<tr>
					<td class="common-list-table-short">明細行番号</td>
					<td class="common-list-table-long">品名</td>
					<td class="common-list-table-short">数量</td>
					<td class="common-list-table-short">実数量</td>
					<td class="common-list-table-short">入力数量</td>
					<td class="common-list-table-short">単価（円）</td>
					<td class="common-list-table-short">金額（円）</td>
					<td class="common-list-table-short"></td>
				</tr>
			</thead>
			<tbody>
			<?php
				$idx = 0;
				foreach ($send_details as $send_detail) {
			?>
				<tr id="send_input_<?= $send_detail->id ?>">
					<td>
						<?= Form::input('detail_no[]', $order_details[$idx]->detail_no + 1, array('class'=>'order-sheet-form-number form-control', 'disabled'=>'')); ?>
					</td>
					<td>
						<?= Form::input('product_name[]', $send_detail->product_name, array('class'=>'order-sheet-form-number form-control')); ?>
					</td>
					<td>
						<?= Form::input('amount[]', $send_detail->amount, array('class'=>'order-sheet-form-number form-control', 'idx'=>$idx)); ?>
					</td>
					<td>
						<?= Form::input('real_amount[]', $send_detail_amounts[$idx]['real_amount'], array('class'=>'order-sheet-form-number form-control', 'disabled'=>'')); ?>
					</td>
					<td>
						<?= Form::input('input_amount[]', $send_detail_amounts[$idx]['input_amount'], array('class'=>'order-sheet-form-number form-control', 'disabled'=>'')); ?>
					</td>
					<td>
						<?= Form::input('unit_price[]', $send_detail->unit_price, array('class'=>'order-sheet-form-number form-control', 'idx'=>$idx)); ?>
					</td>
					<td>
						<?= Form::input('product_price[]', $send_detail->product_price, array('class'=>'order-sheet-form-number form-control', 'disabled'=>'')); ?>
					</td>
					<td>
					<?php if($send_detail->id) { ?>
						<button type="button" class="btn btn-danger delete_button" value="<?= $send_detail->id ?>" data-loading-text="Loading...">
							<i class="fa fa-minus"></i>&nbsp;削除
						</button>
					<?php } ?>
					</td>
					<?= Form::hidden('order_detail_id[]', $send_detail->order_detail_id); ?>
					<?= Form::hidden('send_detail_id[]', $send_detail->id); ?>
				</tr>
			<?php
				$idx ++;
				}
			?>
			<?= Form::hidden('total_price', ''); ?>
			</tbody>
		</table>
	</form>
</div>
