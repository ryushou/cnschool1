$(function() {
	function form_value_reset() {
		$('#name').val('');
		$('#form_member_rank').val('');
		$('#skype').val('');
		$('#chatwork').val('');
	}

	$("#search_button").click(function(e){
		e.preventDefault();
		user_reference(false, 1);
	});

	$("#reset_button").click(function(e) {
		form_value_reset();
		e.preventDefault();
	});

	var get_search_param = function(paging_flg) {
		var param = {};
		return function(paging_flg, page_id) {
			if(!paging_flg) {
				param["user_id"]     = $("#user_id").val();
				param["name"]        = $("#name").val();
				param["member_rank"] = $("#form_member_rank").val();
				param["skype"]       = $("#skype").val();
				param["chatwork"]    = $("#chatwork").val();
				param["untransact"]  = $("#form_untransact").val();
				param["order"]       = $("#form_order").val();
				param["order_by"]    = $("#form_order_by").val();
			}
			param["page"] = page_id; // for pagination
			return param;
		};
	}();

	function user_reference(paging_flg, page_id) {
		var param = get_search_param(paging_flg, page_id);
		setCsrfToken(param);

		var loading = $("#loading").show();
		$('#search_button').button('loading');
		$('#reset_button').button('loading');
		$('#download_button').button('loading');
		$('#deposit_history_download_button').button('loading');

		$.ajax({
			url: BASE_URL + 'admin/user/list/search',
			type: 'GET',
			dataType: 'json',
			data: param,
		})
		.done(function(data) {
			outputdata = [];
			$.each(data["detail"], function(i, val) {
				var d = {};
				d["id"]          = val["id"];
				d["member_rank"] = val["member_rank"];
				d["name"]        = val["name"];
				d["zip"]         = val["zip"];
				d["address"]     = val["address"];
				d["phone"]       = val["phone"];
				d["email"]       = val["email"];
				d["deposit_raw"] = val["deposit"];
				d["deposit"]     = get_number_format(val["deposit"]);
				d["skype"]       = val["skype"];
				d["chatwork"]    = val["chatwork"];
				outputdata.push(d);
			});
			$('#output_result').empty();
			$('#output_template').tmpl({data : outputdata}).appendTo('#output_result');
			$('#pagination').html(data["pagination"]);
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
			$('#search_button').button('reset');
			$('#reset_button').button('reset');
			$('#download_button').button('reset');
			$('#deposit_history_download_button').button('reset');
		});
	}

	$(document).on('click', '#pagination a', function (e) {
		e.preventDefault();
		var page_id = $(this).attr('value').replace('?page=', '');
		user_reference(true, page_id);
	});

	$("#download_button").click(function(e) {
		var loading = $("#loading").show();

		$('#search_button').button('loading');
		$('#reset_button').button('loading');
		$('#download_button').button('loading');
		$('#deposit_history_download_button').button('loading');

		var param = {};
		setCsrfToken(param);

		$.ajax({
			type: "POST",
			url: BASE_URL + "admin/user/get/download_data",
			data: param,
			dataType: "json",
			error: function(req, status, thrown) {
				if(req.readyState == 0 || req.status == 0) {
					return;
				} else {
					alert('error:' + req.status);
				}
			},
			success: function(returnValue) {
				var param = {};
				param["data"]  = returnValue["detail"];
				param["mode"]  = 'csv';
				param["title"] = '会員一覧';
				setCsrfToken(param);

				$.ajax({
					type: "POST",
					url: BASE_URL + "file/export",
					data: param,
					dataType: "json",
					error: function(req, status, thrown) {
						if(req.readyState == 0 || req.status == 0) {
							return;
						} else {
							alert('error:' + req.status);
						}
					},
					success: function(returnValue) {
						if(returnValue.info != '') {
							display_info_message(returnValue.info);
							location.href = BASE_URL + "file/download";
						}
					}
				});
			},
			complete: function(req, status) {
				loading.fadeOut();

				$('#search_button').button('reset');
				$('#reset_button').button('reset');
				$('#download_button').button('reset');
				$('#deposit_history_download_button').button('reset');
			}
		});
	});

	$("#deposit_history_download_button").click(function(e) {
		var loading = $("#loading").show();

		$('#search_button').button('loading');
		$('#reset_button').button('loading');
		$('#download_button').button('loading');
		$('#deposit_history_download_button').button('loading');

		var param = {};
		param["deposit_history_day"] = $("#form_deposit_history_day").val();
		setCsrfToken(param);

		$.ajax({
			type: "POST",
			url: BASE_URL + "admin/user/get/deposit_history_download_data",
			data: param,
			dataType: "json",
			error: function(req, status, thrown) {
				if(req.readyState == 0 || req.status == 0) {
					return;
				} else {
					alert('error:' + req.status);
				}
			},
			success: function(returnValue) {
				var param = {};
				param["data"]  = returnValue["detail"];
				param["mode"]  = 'csv';
				param["title"] = '入出金履歴';
				setCsrfToken(param);

				$.ajax({
					type: "POST",
					url: BASE_URL + "file/export",
					data: param,
					dataType: "json",
					error: function(req, status, thrown) {
						if(req.readyState == 0 || req.status == 0) {
							return;
						} else {
							alert('error:' + req.status);
						}
					},
					success: function(returnValue) {
						if(returnValue.info != '') {
							display_info_message(returnValue.info);
							location.href = BASE_URL + "file/download";
						}
					}
				});
			},
			complete: function(req, status) {
				loading.fadeOut();

				$('#search_button').button('reset');
				$('#reset_button').button('reset');
				$('#download_button').button('reset');
				$('#deposit_history_download_button').button('reset');
			}
		});
	});

	user_reference(false, 1);
});
