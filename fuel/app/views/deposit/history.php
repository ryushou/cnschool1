<?= View::forge('template/grid') ?>

<?= Asset::js('jquery.tooltip.js');?>
<?= Asset::js('deposit/history.js');?>

<div class="container content">
	<div class="panel panel-default">
		<div class="panel-heading">
			<i class="fa fa-check-square-o"></i>&nbsp;残高履歴
			<span class="jquery-tooltip-class">
				&nbsp;<i class="fa fa-question-circle"></i>
				<span class="jquery-tooltip-content-class" style="display:none;">
					<div class="jquery-tooltip-content-title">画面についての説明</div>
					<div class="jquery-tooltip-content-body">
						残高履歴を確認する画面です。<br/>
					</div>
				</span>
			</span>
		</div>
		<div class="panel-body">
			<h5><i class="fa fa-download"></i>&nbsp;下記項目を入力して残高履歴を検索してください</h5>
			<form class="form-horizontal" role="form">
				<div class="form-group">
					<label class="control-label" for="name">お名前：</label>
					<div class="form-control-box">
						<input type="text" id="name" name="name" class="form-control" value="<?= $name ?>" disabled />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label" for="order_id">注文No：</label>
					<div class="form-control-box">
						<input type="text" id="order_id" name="order_id" class="form-control" value="" />
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
						<button type="button" class="btn btn-success" id="download_button" data-loading-text="Loading...">
							<i class="fa fa-download"></i>&nbsp;ダウンロード
						</button>
					</div>
				</div>
			</form>
			<input type="hidden" id="user_id" name="user_id" value="<?= $user_id ?>" />
		</div>
	</div>

	<div id="loading">
		<?= Asset::img('loading.gif') ?>
	</div>

	<table class="table table-bordered table-hover common-list-table deposit-history-list-table">
		<thead class="deposit-history-list-thead">
			<tr>
				<td class="common-list-table-short">No.</td>
				<td class="common-list-table-middle">注文No</td>
				<td class="common-list-table-middle">注文履歴</td>
				<td class="common-list-table-middle">入出金区分</td>
				<td class="common-list-table-long">入出金理由</td>
				<td class="common-list-table-middle">変動額</td>
				<!--
			          変更額（元）を削除	
				-->
				<!--
				<?php if(Auth::has_access('deposit.history')) { ?>
					<td class="common-list-table-middle">変動額（元）</td>
				<?php } ?>
				-->
				<td class="common-list-table-middle">残高</td>
				<td class="common-list-table-middle">振込先</td>
				<td class="common-list-table-middle">備考</td>
				<td class="common-list-table-long">作成日時</td>
				<td style="display:none;">操作</td>
			</tr>
		</thead>
		<tbody id="output_result"></tbody>
		<script id="output_template" type="text/x-jquery-tmpl">
			{{each data}}
			<tr>
				<td>${$index+1}</td>
				<td>
					<?php if(Auth::has_access('web.menu')) { ?>
						<a href="/order/sheet?id=${order_id}" target="_blank">
							${order_id}
						</a>
					<?php } else { ?>
						${order_id}
					<?php } ?>
				</td>
				<td>
					<a href="/order/history?id=${deposit_order_id}" target="_blank">
						${deposit_order_id}
					</a>
				</td>
				<td>${deposit_kbn}</td>
				<td>
					{{if reason == "<?= Config::get('constant.balance_adjust.reason') ?>" }}
						<a href="/report/balance?id=${id}" target="_blank">
							${reason}
						</a>
					{{else}}
						${reason}
					{{/if}}
				</td>
				<td class="text-right">${amount}</td>
                
				<td class="text-right">${deposit}</td>
				<td>${payer_name}</td>
				<td>${note}</td>
				<td>${created_at}</td>
				<td style="display:none;">
					<a href="/deposit/history/input?id=${id}">
						<button type="button" class="btn btn-success">
							<i class="fa fa-check"></i>&nbsp;変更
						</button>
					</a>
				</td>
			</tr>
			{{/each}}
		</script>
	</table>
	<div id="pagination" class="table-pagination"></div>
</div>
