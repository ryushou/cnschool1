$(function() {
	function form_value_reset() {
		$('#order_id').val('');
	}

	$("#search_button").click(function(e){
		e.preventDefault();
		deposit_history_reference(false, 1);
	});

	$("#reset_button").click(function(e) {
		form_value_reset();
		e.preventDefault();
	});

	var get_search_param = function(paging_flg) {
		var param = {};
		return function(paging_flg, page_id) {
			if(!paging_flg) {
				param["user_id"]  = $("#user_id").val();
				param["order_id"] = $("#order_id").val();
			}
			param["page"] = page_id; // for pagination
			return param;
		};
	}();

	function deposit_history_reference(paging_flg, page_id) {
		var param = get_search_param(paging_flg, page_id);
		setCsrfToken(param);

		var loading = $("#loading").show();
		$('#search_button').button('loading');
		$('#reset_button').button('loading');
		$('#download_button').button('loading');

		$.ajax({
			url: BASE_URL + 'deposit/history/search',
			type: 'GET',
			dataType: 'json',
			data: param,
		})
		.done(function(data) {
			outputdata = [];
			$.each(data["detail"], function(i, val) {
				var d = {};
				d["id"]          = val["id"];
				d["order_id"]    = val["order_id"];
				d["deposit_order_id"] = val["deposit_order_id"];
				d["deposit_kbn"] = val["deposit_kbn"];
				d["reason"]      = val["reason"];
				d["amount"]      = get_number_format(val["amount"]);
				d["commission"]  = get_number_format(val["commission"]);
				d["deposit"]     = get_number_format(val["deposit"]);
				d["payer_name"]  = val["payer_name"];
				d["note"]        = val["note"];
				//変更額（元）を削除
				//d["amount_cny"]  = val["amount_cny"] != null ? get_number_format(val["amount_cny"]) : 0;
				d["created_at"]  = val["created_at"];
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
		});
	}

	$(document).on('click', '#pagination a', function (e) {
		e.preventDefault();
		var page_id = $(this).attr('value').replace('?page=', '');
		deposit_history_reference(true, page_id);
	});

	$("#download_button").click(function(e) {
		var loading = $("#loading").show();

		$('#search_button').button('loading');
		$('#reset_button').button('loading');
		$('#download_button').button('loading');

		var param = {};
		param["user_id"] = $("#user_id").val();
		setCsrfToken(param);

		$.ajax({
			type: "POST",
			url: BASE_URL + "deposit/history/get/download_data",
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
				param["title"] = '残高履歴';
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
			}
		});
	});

	deposit_history_reference(false, 1);
});
