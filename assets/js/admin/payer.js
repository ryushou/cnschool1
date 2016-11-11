$(function() {
	function form_value_reset() {
		$('#payer_id').val('');
		$('#payer_name').val('');
		$('#payer_url').val('');
	}

	function payer_reference() {
		var param = {};
		setCsrfToken(param);

		var loading = $("#loading").show();

		$('#reset_button').button('loading');
		$('#register_btn').button('loading');

		$.ajax({
			url: BASE_URL + 'admin/payer/search',
			type: 'POST',
			dataType: 'json',
			data: param,
		})
		.done(function(data) {
			$('#output_result').empty();
			$('#output_template').tmpl({data : data["detail"]}).appendTo('#output_result');
		})
		.fail(function(req, status, thrown) {
			if(req.readyState == 0 || req.status == 0) {
				return;
			} else {
				alert('error:' + req.status);
			}
		})
		.always(function(req, status) {
			loading.fadeOut("normal");
			$('#reset_button').button('reset');
			$('#register_btn').button('reset');
		});
	}

	$("#reset_button").click(function(e) {
		form_value_reset();
		e.preventDefault();
	});

	$(document).on('click', 'button.update_btn', function (e) {
		var param = {};
		param['payer_id'] = $(this).attr('value');
		setCsrfToken(param);

		var loading = $("#loading").show();

		$('#reset_button').button('loading');
		$('#register_btn').button('loading');

		$.ajax({
			url: BASE_URL + 'admin/payer/get',
			type: 'POST',
			dataType: 'json',
			data: param,
			error: function(req, status, thrown) {
				if(req.readyState == 0 || req.status == 0) {
					return;
				} else {
					alert('error:' + req.status);
				}
			},
			success: function(returnValue) {
				var detail = returnValue["detail"];
				$('#payer_id').val(detail['id']);
				$('#payer_name').val(detail['payer_name']);
				$('#payer_url').val(detail['payer_url']);
				$('#payer_commission').val(detail['payer_commission']);
			},
			complete: function(req, status) {
				loading.fadeOut("normal");
				$('#reset_button').button('reset');
				$('#register_btn').button('reset');
			}
		});
		e.preventDefault();
	});

	$(document).on('click', 'button.delete_btn', function (e) {
		e.preventDefault();
		$('#payer_id_modal').val($(this).attr('value'));
		$('#info_delete_modal').modal('show');
	});

	$("#delete_button").click(function(e){
		var param = {};
		param['payer_id'] = $('#payer_id_modal').val();
		setCsrfToken(param);

		var loading = $("#loading").show();

		$('#reset_button').button('loading');
		$('#register_btn').button('loading');

		$('#info_delete_modal').modal('hide');

		$.ajax({
			url: BASE_URL + 'admin/payer/delete',
			type: 'POST',
			dataType: 'json',
			data: param,
			error: function(req, status, thrown) {
				if(req.readyState == 0 || req.status == 0) {
					return;
				} else {
					alert('error:' + req.status);
				}
			},
			success: function(returnValue) {
				if(returnValue.error != '') {
					display_error_message(returnValue.error);
				}

				if(returnValue.info != '') {
					display_info_message(returnValue.info);
				}
			},
			complete: function(req, status) {
				loading.fadeOut("normal");
				$('#reset_button').button('reset');
				$('#register_btn').button('reset');

				form_value_reset();
				payer_reference();
			}
		});
		e.preventDefault();
	});

	payer_reference();
});
