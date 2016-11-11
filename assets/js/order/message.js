$(function() {
	$(document).on('click', 'a.message-delete', function (e) {
		e.preventDefault();
		$('#message_id_modal').val($(this).attr('value'));
		$('#info_delete_modal').modal('show');
	});

	$("#delete_button").click(function(e) {
		var param = {};
		param['message_id'] = $('#message_id_modal').val();
		setCsrfToken(param);

		var loading = $("#loading").show();
		$('#info_delete_modal').modal('hide');

		$.ajax({
			url: BASE_URL + 'order/message/delete_message',
			type: "POST",
			dataType: "json",
			data: param,
		})
		.done(function(data) {
			if(data.error != '') {
				display_error_message(data.error);
			}
			if(data.info != '') {
				display_info_message(data.info);
			}
			if(data.reload) {
				reload_timeout(data.reload);
			}
		})
		.fail(function(req, status, thrown) {
			if(req.readyState == 0 || req.status == 0) {
				return;
			} else {
				alert('error:' + req.status);
			}
		})
		.always(function() {
			loading.fadeOut("normal");
		});
		e.preventDefault();
	});
});
