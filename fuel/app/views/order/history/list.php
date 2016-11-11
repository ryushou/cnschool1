<?= View::forge('template/grid') ?>

<?= Asset::js('jquery.tooltip.js');?>
<?= Asset::js('order/history/list.js');?>

<script>

var MAX_DETAIL_COUNT = <?= Utility::get_order_sheet_detail_count(Utility::get_user_id()) ?>;

</script>

<div class="container content">
	<div class="panel panel-default">
		<div class="panel-heading">
			<i class="fa fa-check-square-o"></i>&nbsp;注文履歴一覧
			<span class="jquery-tooltip-class">
				&nbsp;<i class="fa fa-question-circle"></i>
				<span class="jquery-tooltip-content-class" style="display:none;">
					<div class="jquery-tooltip-content-title">画面についての説明</div>
					<div class="jquery-tooltip-content-body">
						これまで注文した商品の一覧を表示します。<br/>
						注文のステータスが『作成中』の場合に限り、明細を追加することができます。<br/>
					</div>
				</span>
			</span>
		</div>
		<div class="panel-body">
			<h5><i class="fa fa-download"></i>&nbsp;下記項目を入力して注文一覧を検索してください</h5>
			<form class="form-horizontal" role="form">
				<div class="form-group">
					<label class="control-label" for="form_order_id">注文No：</label>
					<div class="form-control-box">
						<?= Form::input('order_id', '', array('class'=>'form-control')); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label" for="form_valiation">バリエーション：</label>
					<div class="form-control-box">
						<?= Form::input('valiation', '', array('class'=>'form-control')); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label" for="form_sku">SKU：</label>
					<div class="form-control-box">
						<?= Form::input('sku', '', array('class'=>'form-control')); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label"></label>
					<div class="form-control-box">
						<button type="button" class="btn btn-primary" id="search_button" data-loading-text="Loading...">
							<i class="fa fa-search"></i>&nbsp;検索
						</button>
						<button type="button" class="btn btn-primary" id="reset_button" data-loading-text="Loading...">
							<i class="fa fa-minus"></i>&nbsp;リセット
						</button>
					</div>
					<div class="form-control-box">
						<button type="button" class="btn btn-success" id="order_sheet_edit_button" data-loading-text="Loading...">
							<i class="fa fa-pencil-square-o"></i>&nbsp;注文シートで入力する
						</button>
					</div>
					<label class="control-label control-label-30" for="form_insert_order_id">注文No：</label>
					<div class="form-control-box">
						<?= Form::input('insert_order_id', '', array('class'=>'form-control')); ?>
					</div>
				</div>
			</form>
		</div>
	</div>

	<div id="loading">
		<?= Asset::img('loading.gif') ?>
	</div>

	<table class="table table-bordered table-hover common-list-table order-list-table">
		<thead class="order-list-thead">
			<tr>
				<td class="common-list-table-short"></td>
				<td class="common-list-table-short">注文No</td>
				<td class="common-list-table-short">明細No</td>
				<td class="common-list-table-middle">商品画像</td>
				<td class="common-list-table-middle">バリエーション</td>
				<td class="common-list-table-short">SKU</td>
				<td class="common-list-table-short">単価（円）</td>
				<td class="common-list-table-short">希望数量</td>
				<td class="common-list-table-short">実数量</td>
			</tr>
		</thead>
		<tbody id="output_result"></tbody>
		<script id="output_template" type="text/x-jquery-tmpl">
			{{each data}}
			<tr>
				<td>
					{{if is_checked }}
						<input type="checkbox" class="history_checkbox" name="history_checkbox_${order_detail_id}" value="${order_detail_id}" checked="checked">
					{{else}}
						<input type="checkbox" class="history_checkbox" name="history_checkbox_${order_detail_id}" value="${order_detail_id}">
					{{/if}}
				</td>
				<td>${order_id}</td>
				<td>${detail_no}</td>
				<td>
					<a class="thumbnail">
						<img src="${image_src}" class="img-content" />
					</a>
				</td>
				<td>${valiation}</td>
				<td>${sku}</td>
				<td class="text-right">${japan_price}</td>
				<td class="text-right">${request_amount}</td>
				<td class="text-right">${real_amount}</td>
			{{/each}}
		</script>
	</table>
	<div id="pagination" class="table-pagination"></div>
</div>
