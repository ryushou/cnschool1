<?= View::forge('template/grid') ?>

<?= Asset::css('uploadfile.css');?>

<?= Asset::js('jquery.uploadfile.min.js');?>
<?= Asset::js('jquery.tooltip.js');?>
<?= Asset::js('jquery.hoverpulse.js');?>
<?= Asset::js('bignumber.min.js');?>
<?= Asset::js('order/sheet.js');?>

<script>
	<?php
		if($order->cny_jpy_rate != 0) {
			$cny_jpy_rate = $order->cny_jpy_rate;
		} else {
			$cny_jpy_rate = $currency->rate;
		}
		if($order->payer_name != ''
			&& $order->order_status != Config::get('constant.order_status.kbn.draft')) {
			$payer->payer_name = $order->payer_name;
			$payer->payer_commission = $order->payer_commission;
		}
		if($order->order_status == Config::get('constant.order_status.kbn.draft')
			|| $order->order_status == Config::get('constant.order_status.kbn.cancel')
			|| $order->order_status == Config::get('constant.order_status.kbn.finish')) {
			$form_disable = 'true';
		} else {
			if ($order->order_kbn == Config::get('constant.order_kbn.kbn.oem')) {
				if (!Auth::has_access('order.oem')) {
					$form_disable = 'true';
				} else {
					$form_disable = 'false';
				}
			} else {
				if (!Auth::has_access('order.normal')) {
					$form_disable = 'true';
				} else {
					$form_disable = 'false';
				}
			}
		}
		if($order->send_fba_flg == Config::get('constant.address_kind.kbn.fba') 
			|| $order->send_fba_flg == Config::get('constant.address_kind.kbn.fba_ship')) {
			$send_fba_flg = true;
		} else {
			$send_fba_flg = false;
		}
		$member_group = Config::get('constant.member_group.kbn');
		$is_orderer = Auth::member($member_group['orderer']);
		$is_shipper = Auth::member($member_group['shipper']);
		$is_oem_orderer = Auth::member($member_group['oem_orderer']);
		$is_oem_shipper = Auth::member($member_group['oem_shipper']);
		if($is_orderer) {
			$order_status_update_enable = Config::get('constant.order_status_update_enable.orderer');
		} else if($is_shipper) {
			$order_status_update_enable = Config::get('constant.order_status_update_enable.shipper');
		} else if($is_oem_orderer) {
			$order_status_update_enable = Config::get('constant.order_status_update_enable.oem_orderer');
		} else if($is_oem_shipper) {
			$order_status_update_enable = Config::get('constant.order_status_update_enable.oem_shipper');
		} else {
			$order_status_update_enable = array();
		}
		$special_inspection_flg = $order->special_inspection_flg == Config::get('constant.special_inspection.kbn.yes');
	?>

	var USER_ID = "<?= $order->user_id ?>";
   	var CURRENCY_RATE = BigNumber(<?= $cny_jpy_rate ?>);
   	var PAYER_COMMISSION = BigNumber(<?= $payer->payer_commission ?>).times(0.01);
   	var COMMISSION = BigNumber(<?= $commission->commission ?>).times(0.01);
   	var MINIMUM_COMMISSION = BigNumber(<?= $commission->minimum_commission ?>);
   	var NATIONAL_DELIVERY_FEE = BigNumber(<?= Config::get('constant.national_delivery_fee') ?>);
   	var UNIT_ONE_BOX = <?= Config::get('constant.unit_one_box') ?>;
	var UNIT_INTERNATIONAL_DELIVERY_RANK_A_MIN = <?= Config::get('constant.unit_international_delivery_rank_a_min') ?>;
	var UNIT_INTERNATIONAL_DELIVERY_RANK_B_MIN = <?= Config::get('constant.unit_international_delivery_rank_b_min') ?>;
	var UNIT_INTERNATIONAL_DELIVERY_RANK_C_MIN = <?= Config::get('constant.unit_international_delivery_rank_c_min') ?>;
	var UNIT_INTERNATIONAL_DELIVERY_RANK_A_FEE = <?= Config::get('constant.unit_international_delivery_rank_a_fee') ?>;
	var UNIT_INTERNATIONAL_DELIVERY_RANK_B_FEE = <?= Config::get('constant.unit_international_delivery_rank_b_fee') ?>;
	var UNIT_INTERNATIONAL_DELIVERY_RANK_C_FEE = <?= Config::get('constant.unit_international_delivery_rank_c_fee') ?>;
   	var UNIT_INTERNATIONAL_DELIVERY_FEE_MAX = BigNumber(<?= Utility::get_constant_get2('constant.unit_international_delivery_fee_max', $order->order_kbn); ?>);
   	var CONSUMPTION_TAX = BigNumber(<?= Config::get('constant.consumption_tax') ?>).times(0.01);
   	var RECEIVER_STATUS = <?= json_encode(Config::get('constant.address_kind.kbn')) ?>;
   	var DETAIL_STATUS_LIST = <?= json_encode(Config::get('constant.order_status.kbn')) ?>;
   	var ORDER_STATUS_UPDATE_ENABLE = <?= json_encode($order_status_update_enable) ?>;
   	var IS_ORDER_AMOUNT = <?= Auth::has_access('order.amount') ? 'true' : 'false' ?>;
   	var IS_ORDER_SEND = <?= Auth::has_access('order.send') ? 'true' : 'false' ?>;
   	var IS_ORDER_NEW = <?= Auth::has_access('order.new') ? 'true' : 'false' ?>;
   	var IS_ORDER_EDIT = <?= Auth::has_access('order.edit') ? 'true' : 'false' ?>;
   	var TOTAL_DELIVERY_FEE = <?= $total_delivery_fee ?>;
   	var FORM_DISABLED = <?= $form_disable ?>;
   	var iS_READONLY = false;
   	var UNIT_SEND_DIRECTLY_PRICE = <?= Config::get('constant.unit_send_directly_price') ?>;
   	var UNIT_SPECIAL_INSPECTION_PRICE = <?= Config::get('constant.unit_special_inspection_price') ?>;
   	var UNIT_FBA_BARCODE_PRICE = <?= Config::get('constant.unit_fba_barcode_price') ?>;
   	var UNIT_OPP_PACKING_PRICE = <?= Config::get('constant.unit_opp_packing_price') ?>;
   	var OPTION_LIST = <?= json_encode(Config::get('constant.option_list')) ?>;
</script>
<div id="loading">
	<?= Asset::img('loading.gif') ?>
</div>
<div class="container content order-sheet-container">
	<form role="form">
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-check-square-o"></i>&nbsp;<?= Utility::get_constant_name2('order_sheet_label', $order->order_kbn, 'title') ?>
				<span class="jquery-tooltip-class">
					&nbsp;<i class="fa fa-question-circle"></i>
					<span class="jquery-tooltip-content-class" style="display:none;">
						<div class="jquery-tooltip-content-title">画面についての説明</div>
						<div class="jquery-tooltip-content-body">
							注文シートを入力する画面です。<br/>
						</div>
					</span>
				</span>
			</div>
		</div>

		<div class="order-sheet-header">
			<div class="order-sheet-header-left">
				注文No：<?= $order->id ?><br/>
				注文日：<?= Utility::get_form_date_value($order->ordered_at) ?><br/>
				振込先：<?= Utility::get_payers_label($payer) ?><br/>
				配送先：<br/>
				<div id="receive_info"></div>
				<script id="receive_info_template" type="text/x-jquery-tmpl">
					${data.receiver}&nbsp;〒${data.zip1}-${data.zip2}<br/>
					${data.address1}<br/>
					${data.address2}<br/>
					${data.phone}<br/>
					<td>${data.name}</td>
				</script>

				<?= Form::hidden('send_fba_flg', $order->send_fba_flg); ?>
				<?= Form::hidden('send_receiver', $order->send_receiver); ?>
				<?= Form::hidden('send_zip1', $order->send_zip1); ?>
				<?= Form::hidden('send_zip2', $order->send_zip2); ?>
				<?= Form::hidden('send_address1', $order->send_address1); ?>
				<?= Form::hidden('send_address2', $order->send_address2); ?>
				<?= Form::hidden('send_phone', $order->send_phone); ?>
				<?= Form::hidden('send_name', $order->send_name); ?>
			</div>

			<div class="order-sheet-header-middle">
				<div class="order-sheet-header-middle-container">
					<?php
						$order_status_select = Config::get('constant.order_header_status_select.' . $order->order_kbn . '.' . $order->order_status);
						if($order->order_status == Config::get('constant.order_status.kbn.buy')
							|| $order->order_status == Config::get('constant.order_status.kbn.temporary')) {
							$order_status_buy_enable = Config::get('constant.order_status_buy_enable.' . $order->order_status);
							if($is_orderer) {
								$order_status_buy_enable = $order_status_buy_enable['orderer'];
							} else if($is_shipper) {
								$order_status_buy_enable = $order_status_buy_enable['shipper'];
							} else if($is_oem_orderer) {
								$order_status_buy_enable = $order_status_buy_enable['oem_orderer'];
							} else if($is_oem_shipper) {
								$order_status_buy_enable = $order_status_buy_enable['oem_shipper'];
							} else {
								$order_status_buy_enable = $order_status_buy_enable['default'];
							}
							if(!empty($order_status_buy_enable)) {
								$order_status_select = Arr::filter_keys($order_status_select, $order_status_buy_enable);
							}
						}
					?>
					<?= Form::select('order_status', $order->order_status, $order_status_select, array('class'=>'form-control order-sheet-order-status')); ?>
					<button type="button" class="btn btn-primary" id="update_button" data-loading-text="Loading...">
						<i class="fa fa-check"></i>&nbsp;更新
					</button>
				</div>
			</div>

			<div class="order-sheet-header-right">
				<?php if(!empty($send_jnl_list)) { ?>
					<div class="order-sheet-form-div">
						<table class="table table-bordered table-hover common-list-table order-sheet-send-table">
							<thead class="order-sheet-thead">
								<tr>
									<td class="common-list-table-short3">No.</td>
									<td class="common-list-table-short">配送予定日</td>
									<td class="common-list-table-short2">業者</td>
									<td class="common-list-table-short">追跡番号</td>
									<td class="common-list-table-short3">箱数</td>
									<td class="common-list-table-short2">重さ</td>
									<td class="common-list-table-short2">送料</td>
									<?php if(Auth::has_access('send.input')) { ?>
										<td class="common-list-table-short2"></td>
									<?php } ?>
									<td class="common-list-table-short"></td>
								</tr>
							</thead>
							<tbody>
								<?php
									$idx = 0;
									foreach ($send_jnl_list as $send_jnl) {
								?>
								<tr>
									<td><?= $idx+1 ?></td>
									<td><?= $send_jnl->delivery_date ?></td>
									<td><?= $send_jnl->delivery_name ?></td>
									<td><?= $send_jnl->send_no ?></td>
									<td class="text-right"><?= $send_jnl->total_box ?></td>
									<td class="text-right"><?= $send_jnl->weight ?>&nbsp;kg</td>
									<td class="text-right"><?= number_format($send_jnl->delivery_fee_cny) ?></td>
									<?php if(Auth::has_access('send.input')) { ?>
										<td>
											<a href="<?= Uri::create("admin/send/input/modify", array(), array('id' => $send_jnl->id)) ?>">
												<button type="button" class="btn btn-success send-edit-button order-sheet-send-table-button">
													修正
												</button>
											</a>
											<button type="button" class="btn btn-success send-edit-button send_detail_add_button order-sheet-send-table-button" value="<?=  $send_jnl->id ?>">
												追加
											</button>
											<button type="button" class="btn btn-danger send-edit-button send_delete_button order-sheet-send-table-button" value="<?=  $send_jnl->id ?>">
												削除
											</button>
										</td>
									<?php } ?>
									<td>
										<a href="<?= Uri::create("report/invoice", array(), array('id' => $send_jnl->id)) ?>" target="_blank">
											<button type="button" class="btn btn-success order-sheet-send-table-button">
												invoice
											</button>
										</a>
									</td>
								</tr>
								<?php
									$idx ++;
									}
								?>
							</tbody>
						</table>

						<div id="info_delete_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
							<div class="modal-dialog modal-sm">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
										<h5 class="modal-title"><i class="fa fa-exclamation-circle"></i>&nbsp;発送伝票削除の確認</h5>
									</div>
									<div class="modal-body">発送伝票を削除しますか？</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-danger" id="send_delete_button" data-loading-text="Loading...">削除する</button>
										<button type="button" class="btn btn-primary" data-dismiss="modal">いいえ</button>
										<input type="hidden" id="send_id_modal" value="" />
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
				<div>
					<?php if(Auth::has_access('send.input')) { ?>
							<button type="button" class="btn btn-primary" id="send_jnl_button" data-loading-text="Loading...">
								<i class="fa fa-plus"></i>&nbsp;発送伝票入力
							</button>
					<?php } ?>
					<?php if ($order->order_kbn == Config::get('constant.order_kbn.kbn.oem')) { ?>
						<a href="/admin/order/info/input?oid=<?= $order->id ?>" target="_blank">
							<button type="button" class="btn btn-primary" id="order_info_button" data-loading-text="Loading...">
								<i class="fa fa-plus"></i>&nbsp;注文情報
							</button>
						</a>
					<?php } ?>
					<?php if($order->id != '') { ?>
						<a href="/report/order/sheet?id=<?= $order->id ?>" target="_blank">
							<button type="button" class="btn btn-success" id="order_sheet_print_button" data-loading-text="Loading...">
								<i class="fa fa-print"></i>&nbsp;印刷
							</button>
						</a>
					<?php } ?>
					<?php if($order->order_status == Config::get('constant.order_status.kbn.temporary')) { ?>
						<button type="button" class="btn btn-warning" id="settle_button" data-loading-text="Loading...">
							<?php if($order->temp_settle_flg == Config::get('constant.temp_settle_flg.kbn.no')) { ?>
								<i class="fa fa-check"></i>&nbsp;仮確定
							<?php } else { ?>
								<i class="fa fa-check"></i>&nbsp;仮確定解除
							<?php } ?>
						</button>
					<?php } ?>
				</div>
			</div>

			<?php if(!empty($order_info_format)) { ?>
				<div class="order-sheet-form-div pull-left">
					<?php foreach ($order_info_format as $order_info_detail) { ?>
						<table class="table table-bordered table-hover common-list-table order-sheet-info-table">
						<thead class="order-sheet-thead">
							<tr>
								<td class="common-list-table-short"><?= Utility::get_constant_name('order_info_status', $order_info_detail['info_kbn']) ?></td>
								<td class="common-list-table-short">管理者メモ</td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<?php for ($idx = 0; $idx <= 1; $idx++) { ?>
									<td>
										<?php foreach ($order_info_detail['list'][$idx] as $order_info) { ?>
											<div class="row">
												<div class="col-md-3"><?= $order_info->target_at ?>&nbsp;</div>
												<div class="col-md-6">
													<?= $order_info->content ?><br/>
													<?php if(!Utility::is_empty($order_info->note)) { ?>
														(<?= $order_info->note ?>)
													<?php } ?>
												</div>
												<div class="col-md-3">
													<a href="<?= Uri::create("/admin/order/info/input", array(), array('oid' => $order_info->order_id, 'iid' => $order_info->id)) ?>">
														<button type="button" class="btn btn-success order-info-edit-button order-sheet-info-table-button">
															更
														</button>
													</a>
													<button type="button" class="btn btn-danger order-info-edit-button order-info-delete-button order-sheet-info-table-button" value="<?= $order_info->id ?>" kbn="content">
														削
													</button>
												</div>
											</div>
										<?php } ?>
									</td>
								<?php } ?>
							</tr>
						</tbody>
						</table>
					<?php } ?>
				</div>
			<?php } ?>

			<?php if(!empty($order_attachs)) { ?>
				<div class="order-sheet-form-div pull-left">
					<table class="table table-bordered table-hover common-list-table order-sheet-attach-table">
						<thead class="order-sheet-thead">
							<tr>
								<td class="common-list-table-short">ロゴ・タグ情報</td>
								<td class="common-list-table-short">備考</td>
								<td class="common-list-table-short"></td>
							</tr>
						</thead>
						<tbody>
						<?php foreach ($order_attachs as $order_attach) { ?>
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
								</td>
								<td>
									<?= $order_attach->note ?>
								</td>
								<td>
									<a href="<?= Uri::create("/admin/order/info/input", array(), array('oid' => $order_attach->order_id, 'aid' => $order_attach->id)) ?>">
										<button type="button" class="btn btn-success order-info-edit-button order-sheet-info-table-button">
											更新
										</button>
									</a>
									<button type="button" class="btn btn-danger order-info-edit-button order-info-delete-button order-sheet-info-table-button" value="<?= $order_attach->id ?>" kbn="attach">
										削除
									</button>
									<?php if(in_array($order_attach->file_type, Config::get('constant.order_info_attach.mimetype.download'), true)) { ?>
										<br/>
										<a href="<?= Uri::create("/order/attach/file/" . $order_attach->id) ?>" target="_blank">
											<button type="button" class="btn btn-primary order-sheet-info-table-button">
												ダウンロード
											</button>
										</a>
										(<?= Num::quantity(strlen($order_attach->file_data)) ?>B)
									<?php } ?>
								</td>
							</tr>
						<?php } ?>
						</tbody>
					</table>
				</div>
			<?php } ?>

			<div id="order_info_delete_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-sm">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h5 class="modal-title"><i class="fa fa-exclamation-circle"></i>&nbsp;注文情報削除の確認</h5>
						</div>
						<div class="modal-body">注文情報を削除しますか？</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger" id="order_info_delete_button" data-loading-text="Loading...">削除する</button>
							<button type="button" class="btn btn-primary" data-dismiss="modal">いいえ</button>
							<input type="hidden" id="order_info_id_modal" value="" />
							<input type="hidden" id="order_info_kbn_modal" value="" />
						</div>
					</div>
				</div>
			</div>

			<div class="clearfix"></div>
		</div>

		<div class="order-sheet-header2">
			<div class="order-sheet-head-table-container">
				<table class="table table-bordered table-hover common-list-table order-sheet-head-table">
					<thead class="order-sheet-thead">
						<tr>
							<td>元円レート</td>
							<td>手数料（%）</td>
							<td>基準手数料</td>
							<td>預り金額</td>
							<td>直送金額</td>
							<td>合計金額</td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td class="text-right"><?= $cny_jpy_rate ?></td>
							<td class="text-right"><?= $commission->commission ?></td>
							<td class="text-right"><?= number_format($commission->minimum_commission) ?></td>
							<td class="text-right"><?= number_format($user->deposit) ?></td>
							<td class="text-right" id="sum_send_directly_price"><?= number_format($order->sum_send_directly_price) ?></td>
							<td class="text-right" id="sum_price"><?= number_format($order->sum_price) ?></td>
						</tr>
					</tbody>
				</table>

				<table class="table table-bordered table-hover common-list-table order-sheet-head-table2">
					<thead class="order-sheet-thead">
						<tr>
							<td>商品代金</td>
							<td>手数料</td>
							<td>内送料</td>
							<td>国際送料</td>
							<td>オプション</td>
							<td>消費税</td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td class="text-right" id="product_price"><?= number_format($order->product_price) ?></td>
							<td class="text-right" id="commission"><?= number_format($order->commission) ?></td>
							<td class="text-right" id="national_delivery_fee"><?= number_format($order->national_delivery_fee) ?></td>
							<td class="text-right" id="international_delivery_fee"><?= number_format($order->international_delivery_fee) ?></td>
							<td class="text-right" id="option_price"><?= number_format($order->option_price) ?></td>
							<td class="text-right" id="sum_tax"><?= number_format($order->sum_tax) ?></td>
						</tr>
					</tbody>
				</table>
			</div>

			<?php if(Auth::has_access('order.message')) { ?>
				<div class="order-sheet-form-div order-sheet-contact order-sheet-contact-admin">
					お問い合わせメモ：<br/>
					<?= Form::textarea('contact_note', '', array('class'=>'form-control order-sheet-header-textarea', 'placeholder'=>'お問い合わせメモ')); ?>
				</div>

				<div class="order-sheet-form-div order-sheet-send-message">
					<div class="badge-block margin-bottom-10">
						<a href="<?= Uri::create("order/message", array(), array('id' => $order->id)) ?>" target="_blank">
							<button type="button" class="btn btn-success">
								<i class="fa fa-search"></i>&nbsp;メッセージ履歴
							</button>
						</a>
						<?php if($message_unread_count > 0) { ?>
							<span class="badge rounded-x"><?= $message_unread_count ?></span>
						<?php } ?>
					</div>

					<button type="button" class="btn btn-primary" id="order_send_message">
						<i class="fa fa-comment"></i>&nbsp;メッセージ送信
					</button>
				</div>
			<?php } ?>

			<div class="order-sheet-form-div order-sheet-option">
				注文オプション：<br/>
				<div class="form-control-box">
					<div>
						<label>
							<?= Form::checkbox('special_inspection', '1', $special_inspection_flg, array('disabled'=> '')); ?>&nbsp;特別検品をする
						</label>
					</div>
				</div>
				<br/>
				<div class="form-control-box" style="padding-left:0">
					<label for="delivery_option_standard">&nbsp;
						<span id="delivery_option">
							<?php if($send_fba_flg && $order->order_kbn != Config::get('constant.order_kbn.kbn.oem')) { ?>
								<?= Utility::get_constant_name2('delivery_option', $order->order_kbn, Config::get('constant.delivery_option.kbn.fba')) ?>
							<?php } else { ?>
								<?= Utility::get_constant_name2('delivery_option', $order->order_kbn, Config::get('constant.delivery_option.kbn.standard')) ?>
							<?php } ?>
						</span>
						<div class="form-control-box">
							<?= Form::radio('delivery_option', Config::get('constant.delivery_option.kbn.standard'), $order->delivery_option == Config::get('constant.delivery_option.kbn.standard'), array('id' => 'delivery_option_standard', 'disabled'=> '')) ?>
						</div>
					</label>
					<label for="delivery_option_together">&nbsp;<?= Utility::get_constant_name2('delivery_option', $order->order_kbn, Config::get('constant.delivery_option.kbn.together')) ?>
						<div class="form-control-box">
							<?= Form::radio('delivery_option', Config::get('constant.delivery_option.kbn.together'), $order->delivery_option == Config::get('constant.delivery_option.kbn.together'), array('id' => 'delivery_option_together', 'disabled'=> '')) ?>
						</div>
					</label>
				</div>
			</div>

			<div class="clearfix"></div>
		</div>

		<?= Form::hidden('screen_id', 'admin'); ?>
		<?= Form::hidden('order_id', $order->id); ?>
		<?= Form::hidden('order_kbn', $order->order_kbn); ?>
		<?= Form::hidden('user_updated_at', $user->updated_at); ?>
		<?= Form::hidden('order_updated_at', $order->updated_at); ?>

		<table class="table table-bordered table-hover common-list-table order-sheet-table" id="orderTable">
			<thead class="order-sheet-thead">
				<tr>
					<td class="order-sheet-table-head-no" rowspan="2">No.</td>
					<?php if($order->order_kbn == Config::get('constant.order_kbn.kbn.normal')) { ?>
						<td class="order-sheet-table-head-url" rowspan="2"><?= Utility::get_constant_name2('order_sheet_label', $order->order_kbn, 'url') ?></td>
					<?php } ?>
					<td class="order-sheet-table-head-image" rowspan="2">商品画像<br/>（アップロード）</td>
					<td class="order-sheet-table-head-image" rowspan="2">商品画像(補足)<br/>（アップロード）</td>
					<td class="order-sheet-table-head-textarea" rowspan="2">バリエーション<br/>（サイズ・カラー）</td>
					<td class="order-sheet-table-head-textarea" rowspan="2">要望<br/>（検品・梱包）</td>
					<td class="order-sheet-table-head-number">希望数量</td>
					<td class="order-sheet-table-head-number">単価（元）</td>
					<td class="order-sheet-table-head-number">手数料（円）</td>
					<td class="order-sheet-table-head-sku">小計（円）</td>
					<td class="order-sheet-table-head-number" rowspan="2">直送箱数</td>
					<td class="order-sheet-table-head-date-admin"><?= Utility::get_constant_name2('order_sheet_label', $order->order_kbn, 'order_date') ?></td>
					<td class="order-sheet-table-head-status">商品ステータス</td>
					<td class="order-sheet-table-head-textarea" rowspan="2">管理者メッセージ</td>
					<td class="order-sheet-table-head-textarea" rowspan="2">管理者メッセージ２</td>
					<td class="order-sheet-table-head-option" rowspan="2">オプション1-3<br/>（項目・数量・単価）<input type="button" value="一括入力" id="add_button" style="background-color:green"></td>
					<td class="order-sheet-table-head-option" rowspan="2">オプション4-6<br/>（項目・数量・単価）</td>
					<td class="order-sheet-table-head-option" rowspan="2">オプション7<br/>（項目・数量・単価）</td>
					<td class="order-sheet-table-head-option" rowspan="2">特別オプション1-3<br/>（項目・数量・単価）</td>
				</tr>
				<tr>
					<td>実数量</td>
					<td>単価（円）</td>
					<td>内送料（元）</td>
					<td>SKU</td>
					<td><?= Utility::get_constant_name2('order_sheet_label', $order->order_kbn, 'receive_date') ?></td>
					<td>国内配送</td>
				</tr>
			</thead>
			<tbody>
				<?php
					$deliver_select = Utility::get_deliver_select(Config::get('constant.deliver_kbn.kbn.national'));

					$idx = 0;
					foreach ($order_detail as $dtl) {
						$detail_status_select = Config::get('constant.order_detail_status_select.' . $order->order_kbn . '.' . $dtl->detail_status);
						if($dtl->detail_status == Config::get('constant.order_status.kbn.backordering')) {
							if($is_orderer) {
								$order_status_backordering_enable = Config::get('constant.order_status_backordering_enable.orderer');
							} else if($is_shipper) {
								$order_status_backordering_enable = Config::get('constant.order_status_backordering_enable.shipper');
							} else if($is_oem_orderer) {
								$order_status_backordering_enable = Config::get('constant.order_status_backordering_enable.oem_orderer');
							} else if($is_oem_shipper) {
								$order_status_backordering_enable = Config::get('constant.order_status_backordering_enable.oem_shipper');
							} else {
								$order_status_backordering_enable = array();
							}
							if(!empty($order_status_backordering_enable)) {
								$detail_status_select = Arr::filter_keys($detail_status_select, $order_status_backordering_enable);
							}
						}
				?>
				<tr class="orderTableTr">
					<td>
						<div class="order-sheet-form-div">
							<?= $idx+1 ?>
						</div>
						<div class="order-sheet-form-div">
							<?= Form::checkbox('delete_check[]', '1', false, array('class'=>'delete_check', 'idx'=>$idx)); ?>
						</div>
						<div class="order-sheet-form-div">
							<?= Form::button('up_list_button[]', '↑', array('class'=>'up-list-button', 'idx'=>$idx)); ?>
						</div>
						<div class="order-sheet-form-div">
							<?= Form::button('down_list_button[]', '↓', array('class'=>'down-list-button', 'idx'=>$idx)); ?>
						</div>
						<?= Form::hidden('detail_id[]', $dtl->id); ?>
					</td>
					<?php if($order->order_kbn == Config::get('constant.order_kbn.kbn.normal')) { ?>
						<td>
							<div class="order-sheet-form-div">
								<?= Form::checkbox('url1_checked_flg[]', $dtl->url1_checked_flg, array('class'=>'checked_check', 'idx'=>$idx)); ?>							
								<?= Form::input('url1[]', $dtl->supplier_url1, array('class'=>'order-sheet-form-url form-control', 'idx'=>$idx)); ?>
								<button type="button" class="btn btn-primary order-sheet-table-button">
									<i class="fa fa-external-link"></i>
								</button>
							</div>
							<div class="order-sheet-form-div">
								<?= Form::checkbox('url2_checked_flg[]', $dtl->url2_checked_flg, array('class'=>'checked_check', 'idx'=>$idx)); ?>
								<?= Form::input('url2[]', $dtl->supplier_url2, array('class'=>'order-sheet-form-url form-control')); ?>
								<button type="button" class="btn btn-primary order-sheet-table-button">
									<i class="fa fa-external-link"></i>
								</button>
							</div>
							<div class="order-sheet-form-div">
								<?= Form::checkbox('url3_checked_flg[]', $dtl->url3_checked_flg, array('class'=>'checked_check', 'idx'=>$idx)); ?>
								<?= Form::input('url3[]', $dtl->supplier_url3, array('class'=>'order-sheet-form-url form-control')); ?>
								<button type="button" class="btn btn-primary order-sheet-table-button">
									<i class="fa fa-external-link"></i>
								</button>
							</div>
						</td>
					<?php } else { ?>
						<?= Form::hidden('url1[]', $dtl->supplier_url1); ?>
						<?= Form::hidden('url2[]', $dtl->supplier_url2); ?>
						<?= Form::hidden('url3[]', $dtl->supplier_url3); ?>
					<?php } ?>
					<td>
						<a class="thumbnail" style="height: 63px; width: 90px;">
							<div class="image-div">
								<?php
									$image_id = $dtl->image_id;
									if(!Utility::is_empty($image_id)) {
								?>
										<img class="image-hover" name="thumbnail[]" src="/image/download/<?= $image_id ?>" />
								<?php } else { ?>
										<img name="thumbnail[]" />
								<?php } ?>
							</div>
						</a>
						<div class="order-sheet-form-div">
							<div class="fileuploader">画像</div>
							<?= Form::hidden('image_id[]', $dtl->image_id); ?>
						</div>
					</td>
					<td>
						<a class="thumbnail" style="height: 63px; width: 90px;">
							<div class="image-div">
								<?php
									$image_id2 = $dtl->image_id2;
									if(!Utility::is_empty($image_id2) && $image_id2 != 0) {
								?>

										<img class="image-hover" name="thumbnail2[]" src="/image/download/<?= $image_id2 ?>" />
								<?php } else { ?>
										<img name="thumbnail2[]" />
								<?php } ?>
							</div>
						</a>
						<div class="order-sheet-form-div">
							<div class="fileuploader2">画像</div>
								<?php 
									if(Utility::is_empty($dtl->image_id2)) {
										$dtl->image_id2 = 0;
									}
								?>
							<?= Form::hidden('image_id2[]', $dtl->image_id2); ?>
						</div>
					</td>
					<td>
						<div class="order-sheet-form-div">
							<?= Form::textarea('valiation[]', $dtl->valiation, array('class'=>'order-sheet-form-textarea form-control', 'placeholder'=>'バリエーション')); ?>
						</div>
					</td>
					<td>
						<div class="order-sheet-form-div">
							<?= Form::textarea('demand[]', $dtl->demand, array('class'=>'order-sheet-form-textarea form-control', 'placeholder'=>'要望')); ?>
						</div>
					</td>
					<td>
						<div class="order-sheet-form-div">
							<?= Form::input('request_amount[]', $dtl->request_amount, array('class'=>'order-sheet-form-number form-control', 'idx'=>$idx)); ?>
						</div>
						<div class="order-sheet-form-div">
							<?= Form::input('real_amount[]', $dtl->real_amount, array('class'=>'order-sheet-form-number form-control', 'idx'=>$idx)); ?>
						</div>
					</td>
					<td>
						<div class="order-sheet-form-div">
							<?= Form::input('china_price[]', $dtl->china_price, array('class'=>'order-sheet-form-number form-control', 'idx'=>$idx)); ?>
						</div>
						<div class="order-sheet-form-div">
							<?= Form::input('japan_price[]', $dtl->japan_price, array('class'=>'order-sheet-form-number form-control', 'disabled'=>'')); ?>
						</div>
					</td>
					<td>
						<div class="order-sheet-form-div">
							<?= Form::input('commission[]', $dtl->commission, array('class'=>'order-sheet-form-number form-control', 'disabled'=>'')); ?>
						</div>
						<div class="order-sheet-form-div">
							<?= Form::input('national_delivery_fee[]', $dtl->national_delivery_fee, array('class'=>'order-sheet-form-number form-control', 'idx'=>$idx)); ?>
							<?= Form::hidden('national_delivery_fee_yen[]', $dtl->national_delivery_fee_yen); ?>
						</div>
					</td>
					<td>
						<div class="order-sheet-form-div">
							<?= Form::hidden('product_price[]', $dtl->product_price); ?>
							<?= Form::input('subtotal_price[]', $dtl->subtotal_price, array('class'=>'order-sheet-form-number form-control', 'disabled'=>'')); ?>
						</div>
						<div class="order-sheet-form-div">
							<?= Form::input('sku[]', $dtl->sku, array('class'=>'order-sheet-form-input form-control', 'disabled'=>'', 'idx'=>$idx)); ?>
						</div>
					</td>
					<td>
						<div class="order-sheet-form-div">
							<?php if($send_fba_flg) { ?>
								<?= Form::input('send_directly_box[]', $dtl->send_directly_box, array('class'=>'order-sheet-form-number form-control', 'idx'=>$idx)); ?>
							<?php } else { ?>
								<?= Form::input('send_directly_box[]', $dtl->send_directly_box, array('class'=>'order-sheet-form-number form-control', 'idx'=>$idx, 'disabled'=>'')); ?>
							<?php } ?>
						</div>

						<div class="order-sheet-form-div">
							<?php
								$fba_barcode_checked = $dtl->fba_barcode_flg == Config::get('constant.fba_barcode_flg.kbn.yes');
								if($fba_barcode_checked) {
									$fba_barcode_class = 'order-sheet-form-checkbox-label-checked';
								} else {
									$fba_barcode_class = '';
								}
							?>
							<label class="<?= $fba_barcode_class ?>">
								<?= Form::checkbox('fba_barcode_flg[]', '1', $fba_barcode_checked, array('idx'=>$idx)); ?> FBAﾊﾞｰｺｰﾄﾞ
							</label>
						</div>

						<div class="order-sheet-form-div">
							<?php
								$opp_packing_checked = $dtl->opp_packing_flg == Config::get('constant.opp_packing_flg.kbn.yes');
								if($opp_packing_checked) {
									$opp_packing_class = 'order-sheet-form-checkbox-label-checked';
								} else {
									$opp_packing_class = '';
								}
							?>
							<label class="<?= $opp_packing_class ?>">
								<?= Form::checkbox('opp_packing_flg[]', '1', $opp_packing_checked, array('idx'=>$idx)); ?> OPP袋詰
							</label>
						</div>
					</td>
					<td>
						<div class="order-sheet-form-div">
							<?= Form::input('order_date[' . $idx . ']', Utility::get_form_date_value($dtl->order_date), array('class'=>'order-sheet-form-date-admin form-control', 'idx'=>$idx)); ?>
						</div>
						<div class="order-sheet-form-div">
							<?= Form::input('receive_date[' . $idx . ']', Utility::get_form_date_value($dtl->receive_date), array('class'=>'order-sheet-form-date-admin form-control', 'idx'=>$idx)); ?>
						</div>
						<div class="order-sheet-form-div">
							<?= Form::select('send_company[]', $dtl->send_company, $deliver_select, array('class'=>'order-sheet-form-date form-control', 'idx'=>$idx)); ?>
						</div>
					</td>
					<td>
						<div class="order-sheet-form-div">
							<?= Form::select('detail_status[]', $dtl->detail_status, $detail_status_select, array('class'=>'order-sheet-form-status form-control', 'idx'=>$idx)); ?>
						</div>
						<div class="order-sheet-form-div">
							<?= Form::select('send_status[]', $dtl->send_status, Utility::get_constant_name('send_status'), array('class'=>'order-sheet-form-status form-control', 'idx'=>$idx)); ?>
						</div>
						<div class="order-sheet-form-div">
							<?= Form::input('send_no[]', $dtl->send_no, array('class'=>'order-sheet-form-status form-control', 'idx'=>$idx)); ?>
						</div>
					</td>
					<td>
						<div class="order-sheet-form-div">
							<?= Form::textarea('admin_message[]', $dtl->admin_message, array('class'=>'order-sheet-form-textarea form-control', 'idx'=>$idx, 'placeholder'=>'管理者メッセージ')); ?>
						</div>
					</td>
					
					<td>
						<div class="order-sheet-form-div">
							<?= Form::textarea('admin_message2[]', $dtl->admin_message2, array('class'=>'order-sheet-form-textarea form-control', 'idx'=>$idx, 'placeholder'=>'管理者メッセージ２')); ?>
						</div>
					</td>
					
					<td>
						<div class="order-sheet-form-div">
							<?php 
								if(Utility::is_empty($dtl->other_option1_label)) {
									$dtl->other_option1_amount = '';
									$dtl->other_option1_unit_price = '';
								}
							?>
							<?= Form::input('other_option1_label[]', $dtl->other_option1_label, array('class'=>'order-sheet-form-option-label form-control', 'idx'=>$idx, 'list'=>'option_list', 'type'=>'search')); ?>
							<?= Form::input('other_option1_amount[]', $dtl->other_option1_amount, array('class'=>'order-sheet-form-option-number form-control', 'idx'=>$idx)); ?>
							<?= Form::input('other_option1_unit_price[]', $dtl->other_option1_unit_price, array('class'=>'order-sheet-form-option-number form-control', 'idx'=>$idx)); ?>

							<datalist id="option_list">
								<?php foreach (Config::get('constant.option_list') as $option) { ?>
									<option value="<?= $option['name'] ?>">
								<?php } ?>
							</datalist>
						</div>
						<div class="order-sheet-form-div">
							<?php 
								if(Utility::is_empty($dtl->other_option2_label)) {
									$dtl->other_option2_amount = '';
									$dtl->other_option2_unit_price = '';
								}
							?>
							<?= Form::input('other_option2_label[]', $dtl->other_option2_label, array('class'=>'order-sheet-form-option-label form-control', 'idx'=>$idx, 'list'=>'option_list', 'type'=>'search')); ?>
							<?= Form::input('other_option2_amount[]', $dtl->other_option2_amount, array('class'=>'order-sheet-form-option-number form-control', 'idx'=>$idx)); ?>
							<?= Form::input('other_option2_unit_price[]', $dtl->other_option2_unit_price, array('class'=>'order-sheet-form-option-number form-control', 'idx'=>$idx)); ?>
						</div>
						<div class="order-sheet-form-div">
							<?php 
								if(Utility::is_empty($dtl->other_option3_label)) {
									$dtl->other_option3_amount = '';
									$dtl->other_option3_unit_price = '';
								}
							?>
							<?= Form::input('other_option3_label[]', $dtl->other_option3_label, array('class'=>'order-sheet-form-option-label form-control', 'idx'=>$idx, 'list'=>'option_list', 'type'=>'search')); ?>
							<?= Form::input('other_option3_amount[]', $dtl->other_option3_amount, array('class'=>'order-sheet-form-option-number form-control', 'idx'=>$idx)); ?>
							<?= Form::input('other_option3_unit_price[]', $dtl->other_option3_unit_price, array('class'=>'order-sheet-form-option-number form-control', 'idx'=>$idx)); ?>
						</div>
					</td>
					<td>
						<div class="order-sheet-form-div">
							<?php 
								if(Utility::is_empty($dtl->other_option4_label)) {
									$dtl->other_option4_amount = '';
									$dtl->other_option4_unit_price = '';
								}
							?>
							<?= Form::input('other_option4_label[]', $dtl->other_option4_label, array('class'=>'order-sheet-form-option-label form-control', 'idx'=>$idx, 'list'=>'option_list', 'type'=>'search')); ?>
							<?= Form::input('other_option4_amount[]', $dtl->other_option4_amount, array('class'=>'order-sheet-form-option-number form-control', 'idx'=>$idx)); ?>
							<?= Form::input('other_option4_unit_price[]', $dtl->other_option4_unit_price, array('class'=>'order-sheet-form-option-number form-control', 'idx'=>$idx)); ?>
						</div>
						<div class="order-sheet-form-div">
							<?php 
								if(Utility::is_empty($dtl->other_option5_label)) {
									$dtl->other_option5_amount = '';
									$dtl->other_option5_unit_price = '';
								}
							?>
							<?= Form::input('other_option5_label[]', $dtl->other_option5_label, array('class'=>'order-sheet-form-option-label form-control', 'idx'=>$idx, 'list'=>'option_list', 'type'=>'search')); ?>
							<?= Form::input('other_option5_amount[]', $dtl->other_option5_amount, array('class'=>'order-sheet-form-option-number form-control', 'idx'=>$idx)); ?>
							<?= Form::input('other_option5_unit_price[]', $dtl->other_option5_unit_price, array('class'=>'order-sheet-form-option-number form-control', 'idx'=>$idx)); ?>
						</div>
						<div class="order-sheet-form-div">
							<?php 
								if(Utility::is_empty($dtl->other_option6_label)) {
									$dtl->other_option6_amount = '';
									$dtl->other_option6_unit_price = '';
								}
							?>
							<?= Form::input('other_option6_label[]', $dtl->other_option6_label, array('class'=>'order-sheet-form-option-label form-control', 'idx'=>$idx, 'list'=>'option_list', 'type'=>'search')); ?>
							<?= Form::input('other_option6_amount[]', $dtl->other_option6_amount, array('class'=>'order-sheet-form-option-number form-control', 'idx'=>$idx)); ?>
							<?= Form::input('other_option6_unit_price[]', $dtl->other_option6_unit_price, array('class'=>'order-sheet-form-option-number form-control', 'idx'=>$idx)); ?>
						</div>
					</td>
					<td>
						<div class="order-sheet-form-div">
							<?php
								if(Utility::is_empty($dtl->other_option7_label)) {
									$dtl->other_option7_amount = '';
									$dtl->other_option7_unit_price = '';
								}
							?>
							<?= Form::input('other_option7_label[]', $dtl->other_option7_label, array('class'=>'order-sheet-form-option-label form-control', 'idx'=>$idx, 'list'=>'option_list', 'type'=>'search')); ?>
							<?= Form::input('other_option7_amount[]', $dtl->other_option7_amount, array('class'=>'order-sheet-form-option-number form-control', 'idx'=>$idx)); ?>
							<?= Form::input('other_option7_unit_price[]', $dtl->other_option7_unit_price, array('class'=>'order-sheet-form-option-number form-control', 'idx'=>$idx)); ?>
						</div>
					</td>
					<td>
						<div class="order-sheet-form-div">
							<?= Form::input('special_option1_label[]', '', array('class'=>'order-sheet-form-option-label form-control', 'idx'=>$idx, 'disabled'=> '')); ?>
							<?= Form::input('special_option1_amount[]', '', array('class'=>'order-sheet-form-option-number form-control', 'idx'=>$idx, 'disabled'=> '')); ?>
							<?= Form::input('special_option1_unit_price[]', '', array('class'=>'order-sheet-form-option-number form-control', 'idx'=>$idx, 'disabled'=> '')); ?>
						</div>

						<div class="order-sheet-form-div">
							<?= Form::input('special_option2_label[]', '', array('class'=>'order-sheet-form-option-label form-control', 'idx'=>$idx, 'disabled'=> '')); ?>
							<?= Form::input('special_option2_amount[]', '', array('class'=>'order-sheet-form-option-number form-control', 'idx'=>$idx, 'disabled'=> '')); ?>
							<?= Form::input('special_option2_unit_price[]', '', array('class'=>'order-sheet-form-option-number form-control', 'idx'=>$idx, 'disabled'=> '')); ?>
						</div>

						<div class="order-sheet-form-div">
							<?= Form::input('special_option3_label[]', '', array('class'=>'order-sheet-form-option-label form-control', 'idx'=>$idx, 'disabled'=> '')); ?>
							<?= Form::input('special_option3_amount[]', '', array('class'=>'order-sheet-form-option-number form-control', 'idx'=>$idx, 'disabled'=> '')); ?>
							<?= Form::input('special_option3_unit_price[]', '', array('class'=>'order-sheet-form-option-number form-control', 'idx'=>$idx, 'disabled'=> '')); ?>
						</div>
					</td>
				</tr>
				<?php
					$idx ++;
					}
				?>
			</tbody>
		</table>
	</form>
</div>