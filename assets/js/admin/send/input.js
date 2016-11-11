$(function() {
	$("[name='delivery_date']").datepicker(get_datepicker_config());

	$("img.ui-datepicker-trigger").hover(
		function() {
			$(this).fadeTo(50, 0.8);
		}, function() {
			$(this).fadeTo(50, 1.0);
		}
	);

	function form_value_reset() {
		$("#form_delivery_date").val('');
		$("#form_total_box").val('');
		$("#form_weight").val('');
		$("#form_delivery_fee").val('');
		$("#form_delivery_fee_cny").val('');
		$("#form_delivery_name").val('');
		$("#form_send_no").val('');
	}

	$("#reset_button").click(function(e) {
		form_value_reset();
		e.preventDefault();
	});

	var $order_detail_id;
	var $send_detail_id;
	var $product_name;
	var $amount;
	var $unit_price;
	var $product_price;

	function get_name_values_all() {
		$order_detail_id = get_name_values('order_detail_id');
		$send_detail_id = get_name_values('send_detail_id');
		$product_name   = get_name_values('product_name');
		$amount         = get_name_values('amount');
		$unit_price     = get_name_values('unit_price');
		$product_price  = get_name_values('product_price');
	}

	$("#update_button").click(function(e) {
		var param_array = [];
		$send_detail_id.each(function(i, v) {
			var p = {
				'order_detail_id': $order_detail_id[i].value,
				'send_detail_id': $send_detail_id[i].value,
				'product_name': $product_name[i].value,
				'amount': $amount[i].value,
				'unit_price': $unit_price[i].value,
				'product_price': $product_price[i].value,
			};
			param_array.push(p);
		});

		var param = {};
		param['send_id']       = $("#form_send_id").val();
		param['order_id']      = $("#form_order_id").val();
		param['user_id']       = $("#form_user_id").val();
		param['delivery_date'] = $("#form_delivery_date").val();
		param['total_box']     = $("#form_total_box").val();
		param['weight']        = $("#form_weight").val();
		param['delivery_fee_cny']  = $("#form_delivery_fee_cny").val();
		param['delivery_name'] = $("#form_delivery_name").val();
		param['send_no']       = $("#form_send_no").val();
		param['total_price']   = $("#form_total_price").val();
		param['details']       = param_array;
		setCsrfToken(param);

		var loading = $("#loading").show();
		$('#update_button').button('loading');
		$('#reset_button').button('loading');
		$('#calc_delivery_fee_button').button('loading');
		$('#send_mail_button').button('loading');
		$('#download_button').button('loading');
		$('.delete_button').button('loading');

		$.ajax({
			url: BASE_URL + 'admin/send/input/update',
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
				var href = BASE_URL + 'admin/send/input/modify' + '?id=' + data.send_id;
				location_timeout(data.reload, href);
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
			$('#update_button').button('reset');
			$('#reset_button').button('reset');
			$('#calc_delivery_fee_button').button('reset');
			$('#send_mail_button').button('reset');
			$('#download_button').button('reset');
			$('.delete_button').button('reset');
		});
	});

	$(document).on('click', 'button.delete_button', function (e) {
		e.preventDefault();
		$('#form_send_detail_id_modal').val($(this).attr('value'));
		$('#info_delete_modal').modal('show');
	});

	$("#form_delivery_fee_cny").change(function(e) {
		calc_delivery_fee();
	});

	$("#calc_delivery_fee_button").click(function(e){
		var param = {};
		param['delivery_name'] = $('#form_delivery_name').val();
		param['weight'] = $('#form_weight').val();
		setCsrfToken(param);

		var loading = $("#loading").show();

		$('#update_button').button('loading');
		$('#reset_button').button('loading');
		$('#calc_delivery_fee_button').button('loading');
		$('#send_mail_button').button('loading');
		$('#download_button').button('loading');
		$('.delete_button').button('loading');
		$('#delete_button').button('loading');

		$('#info_delete_modal').modal('hide');

		$.ajax({
			url: BASE_URL + 'admin/send/input/calc/delivery_fee',
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
					$("#form_delivery_fee_cny").val(returnValue.delivery_fee_cny);
				}
			},
			complete: function(req, status) {
				loading.fadeOut("normal");

				$('#update_button').button('reset');
				$('#reset_button').button('reset');
				$('#calc_delivery_fee_button').button('reset');
				$('#send_mail_button').button('reset');
				$('#download_button').button('reset');
				$('.delete_button').button('reset');
				$('#delete_button').button('reset');

				calc_delivery_fee();
			}
		});
		e.preventDefault();
	});

	$("#delete_button").click(function(e){
		var param = {};
		param['send_detail_id'] = $('#form_send_detail_id_modal').val();
		setCsrfToken(param);

		var loading = $("#loading").show();

		$('#update_button').button('loading');
		$('#reset_button').button('loading');
		$('#calc_delivery_fee_button').button('loading');
		$('#send_mail_button').button('loading');
		$('#download_button').button('loading');
		$('.delete_button').button('loading');
		$('#delete_button').button('loading');

		$('#info_delete_modal').modal('hide');

		$.ajax({
			url: BASE_URL + 'admin/send/input/delete_detail',
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
					$('#send_input_' + $('#form_send_detail_id_modal').val()).remove();
					if(returnValue.reload) {
						var href = BASE_URL + 'admin/send/input/modify' + '?id=' + returnValue.send_id;
						location_timeout(returnValue.reload, href);
					}
				}
			},
			complete: function(req, status) {
				loading.fadeOut("normal");

				$('#update_button').button('reset');
				$('#reset_button').button('reset');
				$('#calc_delivery_fee_button').button('reset');
				$('#send_mail_button').button('reset');
				$('#download_button').button('reset');
				$('.delete_button').button('reset');
				$('#delete_button').button('reset');
			}
		});
		e.preventDefault();
	});

	$("#send_mail_button").click(function(e){
		var param = {};
		param['send_id'] = $('#form_send_id').val();
		param['order_id'] = $('#form_order_id').val();
		param['user_id'] = $('#form_user_id').val();
		setCsrfToken(param);

		var loading = $("#loading").show();

		$('#update_button').button('loading');
		$('#reset_button').button('loading');
		$('#calc_delivery_fee_button').button('loading');
		$('#send_mail_button').button('loading');
		$('#download_button').button('loading');
		$('.delete_button').button('loading');

		$.ajax({
			url: BASE_URL + 'admin/send/input/mail/send',
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
					if(returnValue.reload) {
						var href = BASE_URL + 'admin/send/input/modify' + '?id=' + returnValue.send_id;
						location_timeout(returnValue.reload, href);
					}
				}
			},
			complete: function(req, status) {
				loading.fadeOut("normal");

				$('#update_button').button('reset');
				$('#reset_button').button('reset');
				$('#calc_delivery_fee_button').button('reset');
				$('#send_mail_button').button('reset');
				$('#download_button').button('reset');
				$('.delete_button').button('reset');
			}
		});
		e.preventDefault();
	});

	$("#download_button").click(function(e) {
		var loading = $("#loading").show();

		$('#update_button').button('loading');
		$('#reset_button').button('loading');
		$('#calc_delivery_fee_button').button('loading');
		$('#send_mail_button').button('loading');
		$('#download_button').button('loading');
		$('.delete_button').button('loading');

		var param = {};
		param["send_id"] = $("#form_send_id").val();
		param["order_id"] = $("#form_order_id").val();
		setCsrfToken(param);

		$.ajax({
			type: "POST",
			url: BASE_URL + "admin/send/input/get/invoice_download_data",
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
				param["title"] = 'invoice';
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

				$('#update_button').button('reset');
				$('#reset_button').button('reset');
				$('#calc_delivery_fee_button').button('reset');
				$('#send_mail_button').button('reset');
				$('#download_button').button('reset');
				$('.delete_button').button('reset');
			}
		});
	});

	$("[name='amount[]'],[name='unit_price[]']").change(function(e) {
		var idx = $(this).attr('idx');
		recalc_all(idx);
	});

	function calc_delivery_fee() {
		var delivery_fee_cny = $("#form_delivery_fee_cny").val();
		var $delivery_fee = $("#form_delivery_fee");
		if($.isNumeric(delivery_fee_cny)) {
			$delivery_fee.val(BigNumber(delivery_fee_cny)
										.times(CURRENCY_RATE)
										.round().toFormat());
		} else {
			$delivery_fee.val('');
		}
	}

	function calc_total_price() {
		var total_price = BigNumber(0);
		$send_detail_id.each(function(idx, v) {
			if($.isNumeric($product_price[idx].value)) {
				total_price = total_price.plus($product_price[idx].value);
			}
		});
		$("#form_total_price").val(total_price);
	}

	function calc_product_price(idx) {
		if($.isNumeric($amount[idx].value)
			&& $.isNumeric($unit_price[idx].value)) {
			var amount = BigNumber($amount[idx].value);
			var unit_price = BigNumber($unit_price[idx].value);
			$product_price[idx].value = amount
											.times(unit_price)
											.round().toString();
		} else {
			$product_price[idx].value = '';
		}
	}

	function recalc_all(idx) {
		calc_product_price(idx);
		calc_total_price(idx);
	}

	function calc_detail_all() {
		$send_detail_id.each(function(idx, v) {
			recalc_all(idx);
		});
	}

	get_name_values_all();
	calc_detail_all();
});
