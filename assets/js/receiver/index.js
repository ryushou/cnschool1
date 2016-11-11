$(function() {
	function form_value_reset() {
		$('#receiver_id').val('');
		$('#receiver').val('');
		$('#zip1').val('');
		$('#zip2').val('');
		$('#address1').val('');
		$('#address2').val('');
		$('#phone').val('');
		$('#name').val('');
		$('#form_fba_flg').val(0);
	}

	function receiver_reference() {
		var param = {};
		setCsrfToken(param);

		var loading = $("#loading").show();
		$('#reset_button').button('loading');

		$.ajax({
			url: BASE_URL + 'receiver/setting/search',
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
		});
	}

	$("#reset_button").click(function(e) {
		form_value_reset();
		e.preventDefault();
	});

	$(document).on('click', 'button.update_btn', function (e) {
		var param = {};
		param['receiver_id'] = $(this).attr('value');
		setCsrfToken(param);

		var loading = $("#loading").show();
		$('#reset_button').button('loading');

		$.ajax({
			url: BASE_URL + 'receiver/setting/get',
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
				$('#receiver_id').val(detail['id']);
				$('#receiver').val(detail['receiver']);
				$('#zip1').val(detail['zip1']);
				$('#zip2').val(detail['zip2']);
				$('#address1').val(detail['address1']);
				$('#address2').val(detail['address2']);
				$('#phone').val(detail['phone']);
				$('#name').val(detail['name']);
				$('#form_fba_flg').val(detail['fba_flg']);
			},
			complete: function(req, status) {
				loading.fadeOut("normal");
				$('#reset_button').button('reset');
			}
		});
		e.preventDefault();
	});

	$(document).on('click', 'button.delete_btn', function (e) {
		e.preventDefault();
		$('#receiver_id_modal').val($(this).attr('value'));
		$('#info_delete_modal').modal('show');
	});

	$("#delete_button").click(function(e){
		var param = {};
		param['receiver_id'] = $('#receiver_id_modal').val();
		setCsrfToken(param);

		var loading = $("#loading").show();

		$('#reset_button').button('loading');
		$('#info_delete_modal').modal('hide');

		$.ajax({
			url: BASE_URL + 'receiver/setting/delete',
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

				form_value_reset();
				receiver_reference();
			}
		});
		e.preventDefault();
	});

	receiver_reference();
});
