$(function() {
	function admin_user_reference(page_id) {
		var param = {};
		param["page"] = page_id;
		setCsrfToken(param);

		var loading = $("#loading").show();

		$.ajax({
			url: BASE_URL + 'admin/su/user/list/search',
			type: 'GET',
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
		});
	}

	$(document).on('click', 'button.delete_button', function (e) {
		e.preventDefault();
		$('#user_id_modal').val($(this).attr('value'));
		$('#info_delete_modal').modal('show');
	});

	$("#delete_button").click(function(e) {
		var param = {};
		param['user_id'] = $('#user_id_modal').val();
		setCsrfToken(param);

		var loading = $("#loading").show();
		$('#info_delete_modal').modal('hide');

		$.ajax({
			url: BASE_URL + 'admin/su/user/list/delete',
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
				admin_user_reference(1);
			}
		});
		e.preventDefault();
	});

	admin_user_reference(1);
});
