<?= Security::js_fetch_token() ?>

<script>

var BASE_URL = "<?= Uri::base(false); ?>";
var DEBUG = <?= \Config::get('profiling') ? 'true' : 'false' ?>;

function insert_csrf() {
	$('form').each(function() {
		$(this).append('<input type="hidden" name="<?= \Config::get('security.csrf_token_key') ?>" value="<?= Security::fetch_token() ?>">');
		$(this).submit(function() {
			var token = fuel_csrf_token();
			$(this).find('[name=<?= \Config::get('security.csrf_token_key') ?>]').val(token);
		});
	});
}

function setCsrfToken(param) {
	param["<?= \Config::get('security.csrf_token_key') ?>"] = fuel_csrf_token();
}

</script>