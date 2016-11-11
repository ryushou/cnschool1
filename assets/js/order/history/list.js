$(function() {
	var history_checkbox_array = [];

	$("#reset_button").click(function(e) {
		$("#form_order_id").val('');
		$("#form_valiation").val('');
		$("#form_sku").val('');
		e.preventDefault();
	});

	$("#search_button").click(function(e){
		e.preventDefault();
		order_reference(false, 1);
	});

	var get_search_param = function(paging_flg) {
		var param = {};
		return function(paging_flg, page_id) {
			if(!paging_flg) {
				param["order_id"]  = $("#form_order_id").val();
				param["valiation"] = $("#form_valiation").val();
				param["sku"]       = $("#form_sku").val();
			}
			param["page"] = page_id; // for pagination
			return param;
		};
	}();

	function order_reference(paging_flg, page_id) {
		var param = get_search_param(paging_flg, page_id);
		setCsrfToken(param);

		var loading = $("#loading").show();
		$('#search_button').button('loading');
		$('#reset_button').button('loading');
		$('#order_sheet_edit_button').button('loading');

		$.ajax({
			url: BASE_URL + 'order/history/list/search',
			type: 'GET',
			dataType: 'json',
			data: param,
		})
		.done(function(data) {
			outputdata = [];
			$.each(data["detail"], function(i, val) {
				var d = {};
				d['order_detail_id'] = val["order_detail_id"];
				d["order_id"]        = val["order_id"];
				d["detail_no"]       = val["detail_no"];
				d["image_src"]       = get_image_format(val["image_id"]);
				d["valiation"]       = val["valiation"];
				d["sku"]             = val["sku"];
				d["japan_price"]     = val["japan_price"];
				d["request_amount"]  = val["request_amount"];
				d["real_amount"]     = val["real_amount"];
				d["is_checked"]      = $.inArray(d['order_detail_id'], history_checkbox_array) != -1;
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
			$('#order_sheet_edit_button').button('reset');
		});
	}

	$(document).on('click', '.history_checkbox', function () {
		var order_detail_id = $(this).attr('value');
		if($(this).is(':checked')) {
			history_checkbox_array.push(order_detail_id);
		} else {
			history_checkbox_array.some(function(v, i){
				if(v == order_detail_id) {
					history_checkbox_array.splice(i,1);
				}
			});
		}
	});

	$(document).on('click', '#pagination a', function (e) {
		e.preventDefault();
		var page_id = $(this).attr('value').replace('?page=', '');
		order_reference(true, page_id);
	});

	$("#order_sheet_edit_button").click(function(e) {
		e.preventDefault();
		var order_id = $("#form_insert_order_id").val();

		var param = {};
		param['order_id'] = order_id;
		setCsrfToken(param);

		var loading = $("#loading").show();
		$('#search_button').button('loading');
		$('#reset_button').button('loading');
		$('#order_sheet_edit_button').button('loading');

		$.ajax({
			url: BASE_URL + 'order/history/list/is_draft',
			type: 'POST',
			dataType: 'json',
			data: param,
		})
		.done(function(data) {
			if(data.error != '') {
				display_error_message(data.error);
			} else {
				var detail_ids = '';
				var target_order_detail_count = parseInt(data.detail_count) + history_checkbox_array.length;
				$.each(history_checkbox_array, function(i, val) {
					if(detail_ids != '') {
						detail_ids += ',';
					}
					detail_ids += val;
				});

				if(target_order_detail_count > MAX_DETAIL_COUNT) {
					display_error_message('注文シートの入力可能明細数を超えています。');
				} else {
					window.open(BASE_URL + 'order/sheet?id=' + data.order_id + '&did=' + detail_ids);
				}
			}
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
			$('#order_sheet_edit_button').button('reset');
		});
	});

	order_reference(false, 1);
});
