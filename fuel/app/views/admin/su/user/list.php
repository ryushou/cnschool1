<?= View::forge('template/grid') ?>

<?= Asset::js('jquery.tooltip.js');?>
<?= Asset::js('admin/su/user/list.js');?>

<div class="container content">
	<div class="panel panel-default">
		<div class="panel-heading">
			<i class="fa fa-check-square-o"></i>&nbsp;管理ユーザ一覧
			<span class="jquery-tooltip-class">
				&nbsp;<i class="fa fa-question-circle"></i>
				<span class="jquery-tooltip-content-class" style="display:none;">
					<div class="jquery-tooltip-content-title">画面についての説明</div>
					<div class="jquery-tooltip-content-body">
						管理ユーザの一覧を表示する画面です。<br/>
						管理ユーザを追加、編集、削除ができます。<br/>
						権限の変更もできます。<br/>
					</div>
				</span>
			</span>
		</div>
		<div class="panel-body">
			<a href="/admin/su/user">
				<button type="button" class="btn btn-primary" id="add_button" data-loading-text="Loading...">
					<i class="fa fa-plus"></i>&nbsp;追加
				</button>
			</a>
		</div>
	</div>
	<table class="table table-bordered table-hover common-list-table user-list-table">
		<thead class="user-list-thead">
			<tr>
				<td class="common-list-table-short">ユーザID</td>
				<td class="common-list-table-short">権限</td>
				<td class="common-list-table-short">お名前</td>
				<td class="common-list-table-short">メールアドレス</td>
				<td class="common-list-table-short">スカイプID</td>
				<td class="common-list-table-short">チャットワークID</td>
				<td class="common-list-table-short"></td>
				<td class="common-list-table-short"></td>
			</tr>
		</thead>
		<tbody id="output_result"></tbody>
		<script id="output_template" type="text/x-jquery-tmpl">
			{{each data}}
			<tr>
				<td>${id}</td>
				<td>${group}</td>
				<td>${name}</td>
				<td>${email}</td>
				<td>${skype}</td>
				<td>${chatwork}</td>
				<td>
					<a href="/admin/su/user?id=${id}">
						<button type="button" class="btn btn-success">
							<i class="fa fa-check"></i>&nbsp;設定
						</button>
					</a>
				</td>
				<td>
					<button type="button" class="btn btn-danger delete_button" value="${id}" data-loading-text="Loading...">
						<i class="fa fa-minus"></i>&nbsp;削除
					</button>
				</td>
			</tr>
			{{/each}}
		</script>
	</table>
</div>

<div id="loading">
	<?= Asset::img('loading.gif') ?>
</div>

<div id="info_delete_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h5 class="modal-title"><i class="fa fa-exclamation-circle"></i>&nbsp;管理者削除の確認</h5>
			</div>
			<div class="modal-body">管理者を削除しますか？</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" id="delete_button" data-loading-text="Loading...">削除する</button>
				<button type="button" class="btn btn-primary" data-dismiss="modal">いいえ</button>
				<input type="hidden" id="user_id_modal" value="" />
			</div>
		</div>
	</div>
</div>
