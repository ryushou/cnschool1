<?= View::forge('template/grid') ?>

<?= Asset::js('jquery.tooltip.js');?>
<?= Asset::js('admin/user/list.js');?>

<div class="container content">
	<div class="panel panel-default">
		<div class="panel-heading">
			<i class="fa fa-check-square-o"></i>&nbsp;会員一覧
			<span class="jquery-tooltip-class">
				&nbsp;<i class="fa fa-question-circle"></i>
				<span class="jquery-tooltip-content-class" style="display:none;">
					<div class="jquery-tooltip-content-title">画面についての説明</div>
					<div class="jquery-tooltip-content-body">
						会員の一覧を表示する画面です。<br/>
					</div>
				</span>
			</span>
		</div>
		<div class="panel-body">
			<h5><i class="fa fa-download"></i>&nbsp;下記項目を入力して会員一覧を検索してください</h5>
			<form class="form-horizontal" role="form">
				<div class="form-group">
					<label class="control-label" for="user_id">ユーザID：</label>
					<div class="form-control-box">
						<input type="text" id="user_id" name="user_id" class="form-control" value="" placeholder="">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label" for="name">会員名：</label>
					<div class="form-control-box">
						<input type="text" id="name" name="name" class="form-control" value="" placeholder="">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label" for="form_member_rank">会員ランク：</label>
					<div class="form-control-box">
						<?= Form::select('member_rank', '', Utility::get_constant_name('member_rank'), array('class'=>'form-control')); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label" for="skype">スカイプID：</label>
					<div class="form-control-box">
						<input type="text" id="skype" name="skype" class="form-control" value="" placeholder="">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label" for="chatwork">チャットワークID：</label>
					<div class="form-control-box">
						<input type="text" id="chatwork" name="chatwork" class="form-control" value="" placeholder="">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label" for="form_untransact">未処理：</label>
					<div class="form-control-box">
						<?= Form::select('untransact', '', Utility::get_constant_name('transact_status'), array('class'=>'form-control')); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label" for="form_order">並び順：</label>
					<div class="form-control-box">
						<?= Form::select('order', '', Utility::get_constant_name('admin_user_list_order'), array('class'=>'form-control')); ?>
					</div>
					<div class="form-control-box">
						<?= Form::select('order_by', Config::get('constant.list_order_by.kbn.desc'), Utility::get_constant_name('list_order_by'), array('class'=>'form-control')); ?>
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
					<div class="form-control-box">
						<?= Form::select('deposit_history_day', Config::get('constant.deposit_history_day_status.kbn.10'), Utility::get_constant_name('deposit_history_day_status'), array('class'=>'form-control')); ?>&nbsp;
						<button type="button" class="btn btn-success" id="deposit_history_download_button" data-loading-text="Loading...">
							<i class="fa fa-download"></i>&nbsp;入出金履歴
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>

	<div id="loading">
		<?= Asset::img('loading.gif') ?>
	</div>

	<table class="table table-bordered table-hover common-list-table user-list-table">
		<thead class="user-list-thead">
			<tr>
				<td class="common-list-table-short">ユーザID</td>
				<td class="common-list-table-middle">会員ランク</td>
				<td class="common-list-table-short">お名前</td>
				<td class="common-list-table-short">メールアドレス</td>
				<td class="common-list-table-short">残高</td>
				<td class="common-list-table-short">スカイプID</td>
				<td class="common-list-table-short">チャットワークID</td>
				<td class="common-list-table-short"></td>
				<td class="common-list-table-short"></td>
				<td class="common-list-table-short"></td>
			</tr>
		</thead>
		<tbody id="output_result"></tbody>
		<script id="output_template" type="text/x-jquery-tmpl">
			{{each data}}
			<tr>
				<td>${id}</td>
				<td>${member_rank}</td>
				<td>${name}</td>
				<td>${email}</td>
				<td class="text-right">
					{{if deposit_raw >= 0 }}
						${deposit}
					{{else}}
						<span class="color-red user-list-bold">${deposit}</span>
					{{/if}}
				</td>
				<td>${skype}</td>
				<td>${chatwork}</td>
				<td>
					<a href="/admin/user?id=${id}">
						<button type="button" class="btn btn-success">
							<i class="fa fa-check"></i>&nbsp;設定
						</button>
					</a>
				</td>
				<td>
					<a href="/admin/deposit/input?id=${id}">
						<button type="button" class="btn btn-warning">
							<i class="fa fa-exchange"></i>&nbsp;入出金
						</button>
					</a>
				</td>
				<td>
					<a href="/deposit/history?id=${id}">
						<button type="button" class="btn btn-primary">
							<i class="fa fa-search"></i>&nbsp;残高履歴
						</button>
					</a>
				</td>
			</tr>
			{{/each}}
		</script>
	</table>
	<div id="pagination" class="table-pagination"></div>
</div>