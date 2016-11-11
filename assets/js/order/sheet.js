$(function() {
	var $detail_id;
	var $delete_check;
	var $url1;
	var $url1_checked_flg;
	var $url2;
	var $url2_checked_flg;
	var $url3;
	var $url3_checked_flg;
	var $image_id;
	var $image_id2;
	var $thumbnail;
	var $thumbnail2;
	var $valiation;
	var $demand;
	var $request_amount;
	var $real_amount;
	var $china_price;
	var $japan_price;
	var $commission;
	var $national_delivery_fee;
	var $national_delivery_fee_yen;
	var $product_price;
	var $subtotal_price;
	var $detail_status;
	var $order_date;
	var $receive_date;
	var $send_company;
	var $send_status;
	var $send_no;
	var $admin_message;
	var $admin_message2;
	var $sku;
	var $send_directly_box;
	var $fba_barcode_flg;
	var $opp_packing_flg;
	var $other_option1_label;
	var $other_option1_amount;
	var $other_option1_unit_price;
	var $other_option2_label;
	var $other_option2_amount;
	var $other_option2_unit_price;
	var $other_option3_label;
	var $other_option3_amount;
	var $other_option3_unit_price;
	var $other_option4_label;
	var $other_option4_amount;
	var $other_option4_unit_price;
	var $other_option5_label;
	var $other_option5_amount;
	var $other_option5_unit_price;
	var $other_option6_label;
	var $other_option6_amount;
	var $other_option6_unit_price;
	var $other_option7_label;
	var $other_option7_amount;
	var $other_option7_unit_price;
	var $special_option1_label;
	var $special_option1_amount;
	var $special_option1_unit_price;
	var $special_option2_label;
	var $special_option2_amount;
	var $special_option2_unit_price;
	var $special_option3_label;
	var $special_option3_amount;
	var $special_option3_unit_price;

	var hover_size = 80;
	var animate_speed = 200;

	var loading = $("#loading");

	function is_screen_admin() {
		return $('#form_screen_id').val() == 'admin';
		
	}

	function get_name_values_all() {
		$detail_id = get_name_values('detail_id');
		$delete_check = get_name_values('delete_check');
		$url1 = get_name_values('url1');
		$url1_checked_flg = get_name_values('url1_checked_flg');
		$url2 = get_name_values('url2');
		$url2_checked_flg = get_name_values('url2_checked_flg');
		$url3 = get_name_values('url3');
		$url3_checked_flg = get_name_values('url3_checked_flg');
		$image_id = get_name_values('image_id');
		$image_id2 = get_name_values('image_id2');
		$thumbnail = get_name_values('thumbnail');
		$thumbnail2 = get_name_values('thumbnail2');
		$valiation = get_name_values('valiation');
		$demand = get_name_values('demand');
		$request_amount = get_name_values('request_amount');
		$real_amount = get_name_values('real_amount');
		$china_price = get_name_values('china_price');
		$japan_price = get_name_values('japan_price');
		$commission = get_name_values('commission');
		$national_delivery_fee = get_name_values('national_delivery_fee');
		$national_delivery_fee_yen = get_name_values('national_delivery_fee_yen');
		$product_price = get_name_values('product_price');
		$subtotal_price = get_name_values('subtotal_price');
		$detail_status = get_name_values('detail_status');
		$order_date = get_name_match_values('order_date');
		$receive_date = get_name_match_values('receive_date');
		$send_company = get_name_values('send_company');
		$send_status = get_name_values('send_status');
		$send_no = get_name_values('send_no');
		$admin_message = get_name_values('admin_message');
		$admin_message2 = get_name_values('admin_message2');
		$sku = get_name_values('sku');
		$send_directly_box = get_name_values('send_directly_box');
		$fba_barcode_flg = get_name_values('fba_barcode_flg');
		$opp_packing_flg = get_name_values('opp_packing_flg');
		$other_option1_label = get_name_values('other_option1_label');
		$other_option1_amount = get_name_values('other_option1_amount');
		$other_option1_unit_price = get_name_values('other_option1_unit_price');
		$other_option2_label = get_name_values('other_option2_label');
		$other_option2_amount = get_name_values('other_option2_amount');
		$other_option2_unit_price = get_name_values('other_option2_unit_price');
		$other_option3_label = get_name_values('other_option3_label');
		$other_option3_amount = get_name_values('other_option3_amount');
		$other_option3_unit_price = get_name_values('other_option3_unit_price');
		$other_option4_label = get_name_values('other_option4_label');
		$other_option4_amount = get_name_values('other_option4_amount');
		$other_option4_unit_price = get_name_values('other_option4_unit_price');
		$other_option5_label = get_name_values('other_option5_label');
		$other_option5_amount = get_name_values('other_option5_amount');
		$other_option5_unit_price = get_name_values('other_option5_unit_price');
		$other_option6_label = get_name_values('other_option6_label');
		$other_option6_amount = get_name_values('other_option6_amount');
		$other_option6_unit_price = get_name_values('other_option6_unit_price');
		$other_option7_label = get_name_values('other_option7_label');
		$other_option7_amount = get_name_values('other_option7_amount');
		$other_option7_unit_price = get_name_values('other_option7_unit_price');
		$special_option1_label = get_name_values('special_option1_label');
		$special_option1_amount = get_name_values('special_option1_amount');
		$special_option1_unit_price = get_name_values('special_option1_unit_price');
		$special_option2_label = get_name_values('special_option2_label');
		$special_option2_amount = get_name_values('special_option2_amount');
		$special_option2_unit_price = get_name_values('special_option2_unit_price');
		$special_option3_label = get_name_values('special_option3_label');
		$special_option3_amount = get_name_values('special_option3_amount');
		$special_option3_unit_price = get_name_values('special_option3_unit_price');
	}

	get_name_values_all();
	

	
	function set_receiver_info() {
		$('#receive_info').empty();

		var send_receiver = $('#form_send_receiver').val();
		if(send_receiver != '') {
			var data = {
				'fba_flg': $('#form_send_fba_flg').val(),
				'receiver': send_receiver,
				'zip1': $('#form_send_zip1').val(),
				'zip2': $('#form_send_zip2').val(),
				'address1': $('#form_send_address1').val(),
				'address2': $('#form_send_address2').val(),
				'phone': $('#form_send_phone').val(),
				'name': $('#form_send_name').val()
			}
			$('#receive_info_template').tmpl({data: data}).appendTo('#receive_info');
		}
	}

	$("#form_receiver_id").change(function(e) {
		var receiver_id = $(this).val();
		if(receiver_id == '') {
			$('#form_send_fba_flg').val('');
			$('#form_send_receiver').val('');
			$('#form_send_zip1').val('');
			$('#form_send_zip2').val('');
			$('#form_send_address1').val('');
			$('#form_send_address2').val('');
			$('#form_send_phone').val('');
			$('#form_send_name').val('');
			$('#receive_info').empty();
		} else {
			var param = {};
			param['receiver_id'] = receiver_id;
			setCsrfToken(param);

			var loading = $("#loading").show();

			$.ajax({
				url: BASE_URL + 'order/sheet/receiver',
				type: "POST",
				dataType: "json",
				data: param,
			})
			.done(function(data) {
				$('#form_send_fba_flg').val(data.receiver.fba_flg);
				$('#form_send_receiver').val(data.receiver.receiver);
				$('#form_send_zip1').val(data.receiver.zip1);
				$('#form_send_zip2').val(data.receiver.zip2);
				$('#form_send_address1').val(data.receiver.address1);
				$('#form_send_address2').val(data.receiver.address2);
				$('#form_send_phone').val(data.receiver.phone);
				$('#form_send_name').val(data.receiver.name);
				set_receiver_info();

				var send_fba_flg = is_receiver_fba_status();
				$detail_id.each(function(idx, v) {
					var $elm = $($fba_barcode_flg[idx]);
					$elm.prop("disabled", send_fba_flg);
					if(send_fba_flg) {
						$elm.prop("checked", true);
						change_checkbox_label_class($elm);
						display_special_options(idx);
					}
				});

				var delivery_option;
				if($("#form_order_kbn").val() != ORDER_KBN_OEM) {
					if(send_fba_flg) {
						delivery_option = DELIVERY_OPTION_ARRAY['fba'];
					} else {
						delivery_option = DELIVERY_OPTION_ARRAY['standard'];
					}	
				} else {
					delivery_option = DELIVERY_OPTION_ARRAY['together'];
				}
				$('#delivery_option').text(delivery_option);

				calc_total();
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
		}
	});

	function get_send_check_detail_id() {
		var detail_ids = [];
		$detail_id.each(function(i, v) {
			if(is_detail_delete(i)
				&& $detail_id[i].value != '') {
				detail_ids.push($detail_id[i].value);
			}
		});
		return detail_ids;
	}

	function get_check_detail_id() {
		var detail_ids = [];
		$detail_id.each(function(i, v) {
			if(is_detail_delete(i)) {
				detail_ids.push(i);
			}
		});
		return detail_ids;
	}

	function get_empty_detail_id(exclude_ids) {
		var detail_ids = [];
		$detail_id.each(function(i, v) {
			if($detail_id[i].value == ''
				&& $request_amount[i].value == ''
				&& $.inArray(i, exclude_ids) == -1) {
				detail_ids.push(i);
			}
		});
		return detail_ids;
	}

	function get_empty_column(exclude_cells, upload_option) {
		var idxs = [];
		var $empty_column;
		if(upload_option == 0) {
			$empty_column = $request_amount;
		} else {
			$empty_column = $detail_id;
		}
		$empty_column.each(function(i, v) {
			if($empty_column[i].value == ''
				&& $.inArray(i, exclude_cells) == -1) {
				idxs.push(i);
			}
		});
		return idxs;
	}

	$("#send_jnl_button").click(function(e) {
		var detail_ids = get_send_check_detail_id();
		if(detail_ids.length == 0) {
			display_error_message('明細にチェックが入っていません。');
		} else {
			var order_id = $("#form_order_id").val();
			window.location.href = BASE_URL + 'admin/send/input/new?id=' + order_id + '&dtl=' + detail_ids.join();
		}
	});

	$(".send_detail_add_button").click(function(e) {
		var detail_ids = get_send_check_detail_id();
		if(detail_ids.length == 0) {
			display_error_message('明細にチェックが入っていません。');
		} else {
			var send_id = $(this).val();
			window.location.href = BASE_URL + 'admin/send/input/modify?id=' + send_id + '&dtl=' + detail_ids.join();
		}
	});

	$(".send_delete_button").click(function(e) {
		e.preventDefault();
		$('#send_id_modal').val($(this).attr('value'));
		$('#info_delete_modal').modal('show');
	});

	$("#send_delete_button").click(function(e){
		var param = {};
		param['send_id'] = $('#send_id_modal').val();
		setCsrfToken(param);

		var loading = $("#loading").show();
		$('#info_delete_modal').modal('hide');

		$.ajax({
			url: BASE_URL + 'admin/send/input/delete_jnl',
			type: 'POST',
			dataType: 'json',
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
				var order_id = $("#form_order_id").val();
				var href = BASE_URL + 'admin/order/sheet?id=' + order_id;
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
		.always(function(req, status) {
			loading.fadeOut("normal");
		});
		e.preventDefault();
	});

	$("#order_send_message").click(function(e) {
		var param = {};
		param['order_id'] = $("#form_order_id").val();
		param['contact_note'] = $("#form_contact_note").val();
		setCsrfToken(param);

		var loading = $("#loading").show();
		$('#order_send_message').button('loading');

		$.ajax({
			url: BASE_URL + 'order/message/send_message',
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
				$("#form_contact_note").val('');
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
			$('#order_send_message').button('reset');
		});
	});

	$(".order-info-delete-button").click(function(e) {
		e.preventDefault();
		$('#order_info_id_modal').val($(this).attr('value'));
		$('#order_info_kbn_modal').val($(this).attr('kbn'));
		$('#order_info_delete_modal').modal('show');
	});

	$("#order_info_delete_button").click(function(e){
		var param = {};
		param['order_info_kbn'] = $('#order_info_kbn_modal').val();
		param['id'] = $('#order_info_id_modal').val();
		setCsrfToken(param);

		var loading = $("#loading").show();
		$('#order_info_delete_modal').modal('hide');

		$.ajax({
			url: BASE_URL + 'admin/order/info/input/delete',
			type: 'POST',
			dataType: 'json',
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
				var order_id = $("#form_order_id").val();
				var href = BASE_URL + 'admin/order/sheet?id=' + order_id;
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
		.always(function(req, status) {
			loading.fadeOut("normal");
		});
		e.preventDefault();
	});

	$("#detail_copy_button").click(function(e) {
		var detail_ids = get_check_detail_id();
		if(detail_ids.length == 0) {
			display_error_message('明細にチェックが入っていません。');
			return;
		}
		var empty_detail_ids = get_empty_detail_id(detail_ids);
		if(detail_ids.length > empty_detail_ids.length) {
			display_error_message('明細にコピーする空きがありません。');
			return;
		}
		$.each(detail_ids, function(i, v) {
			var pre_idx = v;
			var aft_idx = empty_detail_ids.shift();

			$delete_check[pre_idx].checked = false;
			$url1[aft_idx].value = $url1[pre_idx].value;
			$url2[aft_idx].value = $url2[pre_idx].value;
			$url3[aft_idx].value = $url3[pre_idx].value;
			$url1_checked_flg[aft_idx].value = $url1_checked_flg[pre_idx].value;
			$url2_checked_flg[aft_idx].value = $url2_checked_flg[pre_idx].value;
			$url3_checked_flg[aft_idx].value = $url3_checked_flg[pre_idx].value;
			$image_id[aft_idx].value = $image_id[pre_idx].value;
			if($image_id[pre_idx].value != '') {
				$($thumbnail[aft_idx]).attr('src', "/image/download/" + $image_id[pre_idx].value)
									  .addClass("image-hover")
									  .hoverpulse({size: hover_size,speed : animate_speed});
			} else {
				$($thumbnail[aft_idx]).attr('src', '');
			}
			$image_id2[aft_idx].value = $image_id2[pre_idx].value;
			if($image_id2[pre_idx].value != '' && $image_id2[pre_idx].value != 0) {
				$($thumbnail2[aft_idx]).attr('src', "/image/download/" + $image_id2[pre_idx].value)
									   .addClass("image-hover")
									   .hoverpulse({size: hover_size,speed : animate_speed});
			} else {
				$($thumbnail2[aft_idx]).attr('src', '');
			}
			$valiation[aft_idx].value = $valiation[pre_idx].value;
			$demand[aft_idx].value = $demand[pre_idx].value;
			$request_amount[aft_idx].value = $request_amount[pre_idx].value;
			$china_price[aft_idx].value = $china_price[pre_idx].value;
			$sku[aft_idx].value = $sku[pre_idx].value;

			recalc_all(pre_idx);
			recalc_all(aft_idx);

			display_info_message('明細をコピーしました。');
		});
	});

	$("#form_special_inspection").click(function(e) {
		calc_total();
		display_special_options_all();
	});

	function update_button() {
		get_name_values_all();

		var $admin_message = get_name_values('admin_message');
		
		var $admin_message2 = get_name_values('admin_message2');

		var param_array = [];
		$detail_id.each(function(i, v) {
			var p = {
				'detail_id': $detail_id[i].value,
				'delete_check': is_detail_delete(i) ? '1' : '',	
				'url1': $url1[i].value,
				'url2': $url2[i].value,
				'url3': $url3[i].value,				
				'url1_checked_flg' : typeof( $url1_checked_flg[i]) == "undefined" ? '': $url1_checked_flg[i].value,
				'url2_checked_flg' : typeof( $url2_checked_flg[i]) == "undefined" ? '': $url2_checked_flg[i].value,
				'url3_checked_flg' : typeof( $url3_checked_flg[i]) == "undefined" ? '': $url3_checked_flg[i].value,	
				'image_id': $image_id[i].value,
				'image_id2': $image_id2[i].value,
				'valiation': $valiation[i].value,
				'demand': $demand[i].value,
				'request_amount': $request_amount[i].value,
				'china_price': $china_price[i].value,
				'fba_barcode_flg': $($fba_barcode_flg[i]).is(':checked') ? '1' : '',
				'opp_packing_flg': $($opp_packing_flg[i]).is(':checked') ? '1' : '',
				'other_option1_label': $other_option1_label[i].value,
				'other_option1_amount': $other_option1_amount[i].value,
				'other_option1_unit_price': $other_option1_unit_price[i].value,
				'other_option2_label': $other_option2_label[i].value,
				'other_option2_amount': $other_option2_amount[i].value,
				'other_option2_unit_price': $other_option2_unit_price[i].value,
				'other_option3_label': $other_option3_label[i].value,
				'other_option3_amount': $other_option3_amount[i].value,
				'other_option3_unit_price': $other_option3_unit_price[i].value,
				'other_option4_label': $other_option4_label[i].value,
				'other_option4_amount': $other_option4_amount[i].value,
				'other_option4_unit_price': $other_option4_unit_price[i].value,
				'other_option5_label': $other_option5_label[i].value,
				'other_option5_amount': $other_option5_amount[i].value,
				'other_option5_unit_price': $other_option5_unit_price[i].value,
				'other_option6_label': $other_option6_label[i].value,
				'other_option6_amount': $other_option6_amount[i].value,
				'other_option6_unit_price': $other_option6_unit_price[i].value,
				'other_option7_label': $other_option7_label[i].value,
				'other_option7_amount': $other_option7_amount[i].value,
				'other_option7_unit_price': $other_option7_unit_price[i].value,
			};
			if(is_screen_admin()) {
				p['real_amount'] = $real_amount[i].value;
				p['national_delivery_fee'] = $national_delivery_fee[i].value;
				p['order_date'] = $order_date[i].value;
				p['receive_date'] = $receive_date[i].value;
				p['send_company'] = $send_company[i].value;
				p['send_status'] = $send_status[i].value;
				p['send_no'] = $send_no[i].value;
				p['detail_status'] = $detail_status[i].value;
				p['admin_message'] = $admin_message[i].value;
				p['admin_message2'] = $admin_message2[i].value;
				p['send_directly_box'] = $send_directly_box[i].value;
			} else {
				p['sku'] = $sku[i].value;
			}
			param_array.push(p);
		});

		var param = {};
		param['order_id'] = $("#form_order_id").val();
		param['order_kbn'] = $("#form_order_kbn").val();
		param['international_delivery_fee_val'] = $("#form_international_delivery_fee_val").val();
		param['user_updated_at'] = $("#form_user_updated_at").val();
		param['order_updated_at'] = $("#form_order_updated_at").val();
		param['order_status'] = $("#form_order_status").val();

		if(!is_screen_admin()) {
			if(!FORM_DISABLED) {
				param['send_fba_flg'] = $("#form_send_fba_flg").val();
				param['send_receiver'] = $("#form_send_receiver").val();
				param['send_zip1'] = $("#form_send_zip1").val();
				param['send_zip2'] = $("#form_send_zip2").val();
				param['send_address1'] = $("#form_send_address1").val();
				param['send_address2'] = $("#form_send_address2").val();
				param['send_phone'] = $("#form_send_phone").val();
				param['send_name'] = $("#form_send_name").val();
				param['special_inspection'] = $("#form_special_inspection").is(':checked') ? '1' : '';
				param['delivery_option'] = $("input[name='delivery_option']:checked").val();
			}
			param['user_note'] = $("#form_user_note").val();
		}
		if(is_screen_admin() || !FORM_DISABLED) {
			param['details'] = param_array;
		}
		setCsrfToken(param);

		var loading = $("#loading").show();
		$('#update_button').button('loading');

		var post_url;
		if(is_screen_admin()) {
			post_url = 'admin/order/sheet/update';
		} else {
			if(FORM_DISABLED) {
				post_url = 'order/sheet/update_header';
			} else {
				post_url = 'order/sheet/update';
			}
		}

		$.ajax({
			url: BASE_URL + post_url,
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
			if(data.order_updated_at) {
				$('#form_order_updated_at').val(data.order_updated_at);
			}
			if(data.reload) {
				var screen_url;
				if(is_screen_admin()) {
					screen_url = 'admin/order/sheet';
				} else {
					screen_url = 'order/sheet';
				}
				var href = BASE_URL + screen_url + '?id=' + data.order_id;
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
		});
	}

	$("#update_button").click(function(e) {
		update_button();
	});

	$("#user_settle_button").click(function(e) {
		$("#form_order_status").val(DETAIL_STATUS_LIST['buy']);
		FORM_DISABLED = false;
		update_button();
	});

	$("#user_remand_button").click(function(e) {
		$("#form_order_status").val(DETAIL_STATUS_LIST['draft']);
		FORM_DISABLED = false;
		update_button();
	});

	$("#settle_button").click(function(e) {
		var param = {};
		param['order_id'] = $("#form_order_id").val();
		param['order_updated_at'] = $("#form_order_updated_at").val();
		setCsrfToken(param);

		var loading = $("#loading").show();
		$(this).button('loading');

		$.ajax({
			url: BASE_URL + 'admin/order/sheet/settle',
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
				var screen_url = 'admin/order/sheet';
				var href = BASE_URL + screen_url + '?id=' + data.order_id;
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
			$('#settle_button').button('reset');
		});
	});

	function is_detail_status_search(idx) {
		var status = $detail_status[idx].value;
		return status == DETAIL_STATUS_LIST['search']
			|| status == DETAIL_STATUS_LIST['exchange']
			|| status == DETAIL_STATUS_LIST['backordering']
			|| status == DETAIL_STATUS_LIST['arrival']
			|| status == DETAIL_STATUS_LIST['preparation']
			|| status == DETAIL_STATUS_LIST['finish'];
	}

	function is_detail_status_search_oem(idx) {
		var status = $detail_status[idx].value;
		return status == DETAIL_STATUS_LIST['temporary']
			|| is_detail_status_search(idx);
	}

	function is_detail_status_order(idx) {
		var status = $detail_status[idx].value;
		return status == DETAIL_STATUS_LIST['buy']
			|| status == DETAIL_STATUS_LIST['search']
			|| status == DETAIL_STATUS_LIST['exchange']
			|| status == DETAIL_STATUS_LIST['backordering']
			|| status == DETAIL_STATUS_LIST['arrival'];
	}

	function is_receiver_fba_status() {
		var send_fba_flg = $('#form_send_fba_flg').val();
		return send_fba_flg == RECEIVER_STATUS['fba']
			|| send_fba_flg == RECEIVER_STATUS['fba_ship'];
	}

	function get_detail_amount(idx) {
		if(is_detail_status_search(idx)) {
			return $real_amount[idx].value;
		} else {
			return $request_amount[idx].value;
		}
	}

	function calc_japan_price(idx) {
		if(is_exist_detail(idx)
			&& $.isNumeric($china_price[idx].value)) {
			var china_price = BigNumber($china_price[idx].value);
			$japan_price[idx].value = china_price
										.times(CURRENCY_RATE)
										.round(3).toString();
		} else {
			$japan_price[idx].value = '';
		}
	}

	function calc_product_price(idx) {
		var amount = get_detail_amount(idx);
		if(is_exist_detail(idx)
			&& $.isNumeric(amount)
			&& $.isNumeric($japan_price[idx].value)) {
			var japan_price = BigNumber($japan_price[idx].value);
			$product_price[idx].value = BigNumber(amount)
										.times(japan_price)
										.round().toString();
		} else {
			$product_price[idx].value = '';
		}
	}

	function calc_commission(idx) {
		if(is_exist_detail(idx)
			&& $.isNumeric($product_price[idx].value)) {
			var product_price = BigNumber($product_price[idx].value);
			$commission[idx].value = product_price
										.times(COMMISSION)
										.round().toString();
		} else {
			$commission[idx].value = '';
		}
	}

	function calc_national_delivery_fee(idx) {
		if(is_exist_detail(idx)
			&& $national_delivery_fee[idx].value == '') {
			$national_delivery_fee[idx].value = NATIONAL_DELIVERY_FEE;
		}
		if(is_exist_detail(idx)
			&& $.isNumeric($national_delivery_fee[idx].value)) {
			$national_delivery_fee_yen[idx].value = BigNumber($national_delivery_fee[idx].value)
														.times(CURRENCY_RATE)
														.round().toString();
		} else {
			$national_delivery_fee_yen[idx].value = '';
		}
	}

	function get_unit_international_delivery_fee_rate(detail_amount) {
		if(detail_amount >= UNIT_INTERNATIONAL_DELIVERY_RANK_A_MIN && detail_amount < UNIT_INTERNATIONAL_DELIVERY_RANK_B_MIN) {
			return UNIT_INTERNATIONAL_DELIVERY_RANK_A_FEE;
		} else if(detail_amount >= UNIT_INTERNATIONAL_DELIVERY_RANK_B_MIN && detail_amount < UNIT_INTERNATIONAL_DELIVERY_RANK_C_MIN) {
			return UNIT_INTERNATIONAL_DELIVERY_RANK_B_FEE;
		} else if(detail_amount >= UNIT_INTERNATIONAL_DELIVERY_RANK_C_MIN) {
			return UNIT_INTERNATIONAL_DELIVERY_RANK_C_FEE;
		} else {
			return 0;
		}
	}

	function calc_subtotal(idx) {
		if(is_exist_detail(idx)
			&& $.isNumeric($product_price[idx].value)
			&& $.isNumeric($commission[idx].value)
			&& $.isNumeric($national_delivery_fee_yen[idx].value)) {
			var product_price = BigNumber($product_price[idx].value);
			var commission = BigNumber($commission[idx].value);
			var national_delivery_fee_yen = BigNumber($national_delivery_fee_yen[idx].value);

			$subtotal_price[idx].value = product_price
											.plus(commission)
											.plus(national_delivery_fee_yen)
											.round().toString();
		} else {
			$subtotal_price[idx].value = '';
		}
	}

	function calc_times(value1, value2) {
		if($.isNumeric(value1) && $.isNumeric(value2)) {
			return BigNumber(value1).times(BigNumber(value2));
		} else {
			return BigNumber(0);
		}
	}

	function calc_total() {
		var product_price = BigNumber(0);
		var international_delivery_fee = BigNumber(0);
		var national_delivery_fee = BigNumber(0);
		var sum_send_directly_price = BigNumber(0);
		var sum_detail_amount = BigNumber(0);
		var sum_fba_barcode_price = BigNumber(0);
		var sum_opp_packing_price = BigNumber(0);
		var sum_other_option_price = BigNumber(0);

		$detail_id.each(function(idx, v) {
			if(is_exist_detail(idx)) {
				var detail_amount = get_detail_amount(idx);
				if($.isNumeric(detail_amount)) {
					var amount_tmp = BigNumber(detail_amount);

					sum_detail_amount = sum_detail_amount.plus(amount_tmp);

					if($.isNumeric($japan_price[idx].value)) {
						var japan_price = BigNumber($japan_price[idx].value);
						product_price = product_price.plus(amount_tmp
															.times(japan_price));
					}

					if($($fba_barcode_flg[idx]).is(':checked')) {
						sum_fba_barcode_price = sum_fba_barcode_price.plus(amount_tmp
															.times(UNIT_FBA_BARCODE_PRICE));
					}
					if($($opp_packing_flg[idx]).is(':checked')) {
						sum_opp_packing_price = sum_opp_packing_price.plus(amount_tmp
															.times(UNIT_OPP_PACKING_PRICE));
					}
					sum_other_option_price = sum_other_option_price.plus( calc_times($other_option1_amount[idx].value, $other_option1_unit_price[idx].value).round() );
					sum_other_option_price = sum_other_option_price.plus( calc_times($other_option2_amount[idx].value, $other_option2_unit_price[idx].value).round() );
					sum_other_option_price = sum_other_option_price.plus( calc_times($other_option3_amount[idx].value, $other_option3_unit_price[idx].value).round() );
					sum_other_option_price = sum_other_option_price.plus( calc_times($other_option4_amount[idx].value, $other_option4_unit_price[idx].value).round() );
					sum_other_option_price = sum_other_option_price.plus( calc_times($other_option5_amount[idx].value, $other_option5_unit_price[idx].value).round() );
					sum_other_option_price = sum_other_option_price.plus( calc_times($other_option6_amount[idx].value, $other_option6_unit_price[idx].value).round() );
					sum_other_option_price = sum_other_option_price.plus( calc_times($other_option7_amount[idx].value, $other_option7_unit_price[idx].value).round() );

					var unit_international_delivery_fee = amount_tmp
														.dividedBy(UNIT_ONE_BOX)
														.ceil()
														.times(get_unit_international_delivery_fee_rate(amount_tmp))
														.round();
					international_delivery_fee = international_delivery_fee
														.plus(unit_international_delivery_fee);
				}
				if($.isNumeric($national_delivery_fee_yen[idx].value)) {
					national_delivery_fee = national_delivery_fee
												.plus(BigNumber($national_delivery_fee_yen[idx].value));
				}
				if(is_receiver_fba_status()) {
					if(is_screen_admin()) {
						if($.isNumeric($send_directly_box[idx].value)) {
							sum_send_directly_price = sum_send_directly_price
														.plus(BigNumber($send_directly_box[idx].value).times(UNIT_SEND_DIRECTLY_PRICE));
						}
					} else {
						if($detail_status[idx].value == ''
							|| $detail_status[idx].value == DETAIL_STATUS_LIST['draft']) {
							if($.isNumeric($request_amount[idx].value)) {
								sum_send_directly_price = sum_send_directly_price
															.plus(BigNumber($request_amount[idx].value)
																	.dividedBy(UNIT_SEND_DIRECTLY_ONE_BOX).ceil()
																	.times(UNIT_SEND_DIRECTLY_PRICE));
							}
						} else {
							if($.isNumeric($send_directly_box[idx].value)) {
								sum_send_directly_price = sum_send_directly_price
															.plus(BigNumber($send_directly_box[idx].value).times(UNIT_SEND_DIRECTLY_PRICE));
							}
						}
					}
				}
			}
		});

		product_price = product_price.round();
		sum_fba_barcode_price = sum_fba_barcode_price.round();
		sum_opp_packing_price = sum_opp_packing_price.round();

		var commission = product_price
							.times(COMMISSION)
							.round();

		if(commission.comparedTo(MINIMUM_COMMISSION) == -1) {
			commission = MINIMUM_COMMISSION;
		}

		if(TOTAL_DELIVERY_FEE == 0) {
			if(international_delivery_fee.comparedTo(UNIT_INTERNATIONAL_DELIVERY_FEE_MAX) == 1) {
				international_delivery_fee = UNIT_INTERNATIONAL_DELIVERY_FEE_MAX;
			}
		} else {
			international_delivery_fee = BigNumber(TOTAL_DELIVERY_FEE);
		}

		if($("#form_special_inspection").is(':checked')) {
			var special_inspection_price = sum_detail_amount
											.times(UNIT_SPECIAL_INSPECTION_PRICE)
											.round();
		} else {
			var special_inspection_price = BigNumber(0);
		}

		var sum_option = special_inspection_price
							.plus(sum_fba_barcode_price)
							.plus(sum_opp_packing_price)
							.plus(sum_other_option_price);

		var sum_tax = commission
						.times(CONSUMPTION_TAX)
						.round();

	
		$("#product_price").html(product_price.toFormat());
		$("#commission").html(commission.toFormat());
		$("#national_delivery_fee").html(national_delivery_fee.toFormat());
		$("#international_delivery_fee").html(international_delivery_fee.toFormat());
		$("#form_international_delivery_fee_val").val(international_delivery_fee);
		$("#sum_tax").html(sum_tax.toFormat());
		$("#sum_send_directly_price").html(sum_send_directly_price.toFormat());
		$("#option_price").html(sum_option.toFormat());

		var sum_price = product_price
								.plus(commission)
								.plus(national_delivery_fee)
								.plus(international_delivery_fee)
								.plus(sum_tax)
								.plus(sum_send_directly_price)
								.plus(sum_option);
		if(PAYER_COMMISSION > 0) {
			sum_price = sum_price.plus(
				sum_price.times(PAYER_COMMISSION)
			);
		}

		$("#sum_price").html(sum_price
								.round()
								.toFormat());
	}

	function recalc_all(idx) {
		calc_japan_price(idx);
		calc_product_price(idx);
		calc_commission(idx);
		calc_national_delivery_fee(idx);
		calc_subtotal(idx);
		calc_total();
	}

	function is_detail_delete(idx) {
		return $($delete_check[idx]).is(':checked');
	}
	
	function is_url1_check (idx) {
		
		return $($url1_checked_flg[idx]).is(':checked');
	}
	
	function is_url2_check (idx) {
		
		return $($url2_checked_flg[idx]).is(':checked');
	}
	
	function is_url3_check (idx) {
		
		return $($url3_checked_flg[idx]).is(':checked');
	}
	
	function is_exist_detail(idx) {
		return !$($delete_check[idx]).is(':checked')
				&& $detail_status[idx].value != DETAIL_STATUS_LIST['cancel']
				&& $request_amount[idx].value != '';
	}

	function display_special_options_all() {
		$detail_id.each(function(idx, v) {
			display_special_options(idx);
		});
	}

	function display_special_options(idx) {
		var special_options = [];
		if(is_exist_detail(idx)) {
			if($("#form_special_inspection").is(':checked')) {
				special_options.push({
					label: '特別検品',
					amount: get_detail_amount(idx),
					unit_price: UNIT_SPECIAL_INSPECTION_PRICE,
				});
			}
			if($($fba_barcode_flg[idx]).is(':checked')) {
				special_options.push({
					label: 'FBAバーコード',
					amount: get_detail_amount(idx),
					unit_price: UNIT_FBA_BARCODE_PRICE,
				});
			}
			if($($opp_packing_flg[idx]).is(':checked')) {
				special_options.push({
					label: 'OPP袋詰',
					amount: get_detail_amount(idx),
					unit_price: UNIT_OPP_PACKING_PRICE,
				});
			}
		}
		var special_options_limit = 3;
		for(i = special_options.length; i < special_options_limit; i++) {
			special_options.push({
				label: '',
				amount: '',
				unit_price: '',
			});
		}
		$($special_option1_label[idx]).val(special_options[0]['label']);
		$($special_option1_amount[idx]).val(special_options[0]['amount']);
		$($special_option1_unit_price[idx]).val(special_options[0]['unit_price']);
		$($special_option2_label[idx]).val(special_options[1]['label']);
		$($special_option2_amount[idx]).val(special_options[1]['amount']);
		$($special_option2_unit_price[idx]).val(special_options[1]['unit_price']);
		$($special_option3_label[idx]).val(special_options[2]['label']);
		$($special_option3_amount[idx]).val(special_options[2]['amount']);
		$($special_option3_unit_price[idx]).val(special_options[2]['unit_price']);
	}

	function set_detail_disable(idx) {
		var is_admin = is_screen_admin();
		var is_search = is_detail_status_search(idx) && is_admin && IS_ORDER_SEND;
		$($real_amount[idx]).prop("disabled", !is_search);

		var is_search_oem = is_detail_status_search_oem(idx) && is_admin && IS_ORDER_SEND;
		$($national_delivery_fee[idx]).prop("disabled", !is_search_oem);
		$($national_delivery_fee_yen[idx]).prop("disabled", !is_search_oem);

		var send_fba_flg = is_receiver_fba_status();
		if(send_fba_flg) {
			$($send_directly_box[idx]).prop("disabled", !is_search);
		}
		if(!is_admin) {
			$($fba_barcode_flg[idx]).prop("disabled", send_fba_flg);
		}

		$order_date_elm = $($order_date[idx]);
		$receive_date_elm = $($receive_date[idx]);

		var is_order = is_detail_status_order(idx) && is_admin && IS_ORDER_SEND;
		$order_date_elm.prop("disabled", !is_order);
		$receive_date_elm.prop("disabled", !is_order);
		$($send_company[idx]).prop("disabled", !is_order);
		$($send_status[idx]).prop("disabled", !is_order);
		$($send_no[idx]).prop("disabled", !is_order);

		if(!is_order) {
			$order_date_elm.datepicker("destroy");
			$receive_date_elm.datepicker("destroy");
		} else {
			$order_date_elm.datepicker(get_datepicker_config());
			$receive_date_elm.datepicker(get_datepicker_config());
		}

		var status = $detail_status[idx].value;
		var is_request_amount = $detail_id[idx].value != ''
									&& ( is_admin && status != DETAIL_STATUS_LIST['temporary'] );
		$($request_amount[idx]).prop("disabled", is_request_amount);
		$($admin_message[idx]).prop("disabled", !is_admin);
		$($admin_message2[idx]).prop("disabled", !is_admin);
		$($detail_status[idx]).prop("disabled", !is_admin);
	}

	$("[name='request_amount[]'],[name='real_amount[]'],[name='china_price[]'],[name='send_directly_box[]']," +
		"[name='national_delivery_fee[]'],[name='url1[]'],[name='url1_checked_flg[]']," +
		"[name='detail_status[]'],[name='delete_check[]']," +
		"[name='other_option1_amount[]'],[name='other_option1_unit_price[]']," +
		"[name='other_option2_amount[]'],[name='other_option2_unit_price[]']," +
		"[name='other_option3_amount[]'],[name='other_option3_unit_price[]']," +
		"[name='other_option4_amount[]'],[name='other_option4_unit_price[]']," +
		"[name='other_option5_amount[]'],[name='other_option5_unit_price[]']," +
		"[name='other_option6_amount[]'],[name='other_option6_unit_price[]']," +
		"[name='other_option7_amount[]'],[name='other_option7_unit_price[]']," +
		"[name='fba_barcode_flg[]'],[name='opp_packing_flg[]']").change(function(e) {
		var idx = $(this).attr('idx');
		recalc_all(idx);
	});

	$("[name='request_amount[]'],[name='real_amount[]']," +
		"[name='fba_barcode_flg[]'],[name='opp_packing_flg[]']").change(function(e) {
		var idx = $(this).attr('idx');
		display_special_options(idx);
	});

	$("[name='detail_status[]'],[name='delete_check[]']").change(function(e) {
		var idx = $(this).attr('idx');
		if($detail_status[idx].value == DETAIL_STATUS_LIST['cancel']) {
			$real_amount[idx].value = '0';
			$send_directly_box[idx].value = '0';
		}
		set_detail_disable(idx);
	});
	
	$("[name='url1_checked_flg[]']").change(function(e) {
		var idx = $(this).attr('idx');
		if($url1_checked_flg[idx].value == '') {
			$url1_checked_flg[idx].value = '1';
		} else if($url1_checked_flg[idx].value == '0'){
			$url1_checked_flg[idx].value = '1';
		} else {
			$url1_checked_flg[idx].value = '0';
		}
	});
	$("[name='url2_checked_flg[]']").change(function(e) {
		var idx = $(this).attr('idx');
		if($url2_checked_flg[idx].value == '') {
			$url2_checked_flg[idx].value = '1';
		} else if($url2_checked_flg[idx].value == '0'){
			$url2_checked_flg[idx].value = '1';
		} else {
			$url2_checked_flg[idx].value = '0';
		}
	});
	$("[name='url3_checked_flg[]']").change(function(e) {
		var idx = $(this).attr('idx');
		if($url3_checked_flg[idx].value == '') {
			$url3_checked_flg[idx].value = '1';
		} else if($url3_checked_flg[idx].value == '0'){
			$url3_checked_flg[idx].value = '1';
		} else {
			$url3_checked_flg[idx].value = '0';
		}
	});
	

	url_checked();
	function url_checked()
	{
		var num = $('.orderTableTr');
		for (idx = 0; idx < num.size(); idx++) 
		{	if(typeof($url1_checked_flg[idx]) == "undefined" || typeof($url2_checked_flg[idx]) == "undefined" || typeof($url3_checked_flg[idx]) == "undefined" ){
			   break;
		}
			if($url1_checked_flg[idx].value == '1') {
				$url1_checked_flg[idx].checked = true;
			}
			if($url2_checked_flg[idx].value == '1') {
				$url2_checked_flg[idx].checked = true;
			}
			if($url3_checked_flg[idx].value == '1') {
				$url3_checked_flg[idx].checked = true;
			}
		}
	}

	$("[name='detail_status[]']").change(function(e) {
		var idx = $(this).attr('idx');
		if($detail_id[idx].value == '') {
			$send_directly_box[idx].value = '0';
		}
	});

	$("[name='up_list_button[]']").click(function(e) {
		var $base = $(this).closest('tr');
		var $target = $base.prev('tr');
		if($target) {
			$target.before($base);
		}
		e.preventDefault();
	});

	$("[name='down_list_button[]']").click(function(e) {
		var $base = $(this).closest('tr');
		var $target = $base.next('tr');
		if($target) {
			$target.after($base);
		}
		e.preventDefault();
	});

	$("[name='fba_barcode_flg[]'],[name='opp_packing_flg[]']").click(function() {
		change_checkbox_label_class($(this));
    });

    function change_checkbox_label_class($checkbox) {
        var $label = $checkbox.closest('label');
        var class_name = "order-sheet-form-checkbox-label-checked";
        if($checkbox.is(':checked')) {
            $label.addClass(class_name);
        } else {
            $label.removeClass(class_name);
        }
    }

	$("[name='other_option1_label[]'],[name='other_option2_label[]'],[name='other_option3_label[]'],[name='other_option4_label[]']," +
		"[name='other_option5_label[]'],[name='other_option6_label[]'],[name='other_option7_label[]']").on('input', function(e) {
		var idx = $(this).attr('idx');
		var val = $(this).val();
		var id_num = $(this).attr('id').match(/\d/g).join("");
		if(val == '') {
			$(eval('$other_option' + id_num + '_unit_price[' + idx + ']')).val('');
			$(eval('$other_option' + id_num + '_amount[' + idx + ']')).val('');
		} else {
			$.each(OPTION_LIST, function(index, value) {
				if(value['name'] == val) {
					$elm = $(eval('$other_option' + id_num + '_unit_price[' + idx + ']'));
					$elm.val(value['unitprice']);

					$elm = $(eval('$other_option' + id_num + '_amount[' + idx + ']'));
					var amount;
					if(value['amount'] == '') {
						amount = get_detail_amount(idx);
					} else {
						amount = value['amount'];
					}
					$elm.val(amount);

					return false;
				}
			});
		}
		recalc_all(idx);
	});

	$(".order-sheet-table-button").click(function (e) {
		var url = $(this).prev("input").val();
		if(url == '') {
			display_error_message('URLがありません。');
		} else {
			window.open(url);
		}
	});
	
	// upload image
	$('.order-sheet-form-url.form-control').each(function(index, ele) {
		$(ele).blur(function (e) {
			if ($(this).val() == null || $(this).val() == '') {
				return false;
			}
			var url = $(this).val();
			if ($(this).val().indexOf('http') == -1) {
				url = 'http://' + $(this).val();
			}
			var param = {};
			param['pageurl'] = url;
			var target = $(this);
			var loading = $("#loading").show();
			var requrl = is_screen_admin()?BASE_URL + 'admin/order/sheet/fetchpage':BASE_URL + '/order/sheet/fetchpage';
			$.ajax({
				url:requrl,
				type: "GET",
				dataType: "json",
				data: param,
				error: function(a, b, c) {
//					alert(b);
				},
				success: function(data) {
					var i = Math.floor(index / 3); 
					$($thumbnail[i]).attr('src', "/image/download/" + data.imgid);
					$($thumbnail[i]).addClass("image-hover");
					$($image_id[i]).val(data.imgid);
					$($thumbnail[i]).hoverpulse({size: hover_size,speed : animate_speed});
				}
			})
			.always(function(req, status) {
				loading.fadeOut("normal");
			});
		});
	});

	$(".fileuploader").each(function(i, v) {
		$(this).uploadFile({
			url: BASE_URL + "image/upload",
			returnType: 'json',
			showStatusAfterSuccess: false,
			showAbort: false,
			showDone: false,
			uploadButtonClass: "ajax-file-upload-green",
			maxFileSize: 1024 * 500,
			statusBarWidth: 90,
			dragdropWidth: 90,
			dragDropStr: '',
			sizeErrorStr: "画像の最大サイズを超えています。最大:",
			multiDragErrorStr: "画像は1つずつドラッグ＆ドロップしてください。",
			uploadErrorStr: "アップロードに失敗しました。",
			cancelStr: "キャンセル",
			multiple: false,
			dynamicFormData: function() {
				var param = {};
				param['user_id'] = USER_ID;
				setCsrfToken(param);
				return param;
			},
			onSuccess: function(files, data, xhr) {
				if(data.error === '') {
					$($thumbnail[i]).attr('src', "/image/download/" + data.ids[0]);
					$($thumbnail[i]).addClass("image-hover");
					$($image_id[i]).val(data.ids[0]);
					$($thumbnail[i]).hoverpulse({size: hover_size,speed : animate_speed});
				}
	        },
	        onLoad: function() {
	        	$(document).unbind('dragenter');
	       	 	$(document).unbind('dragover');
	       		$(document).unbind('drop');
	        }
	    });
	});

	$(".fileuploader2").each(function(i, v) {
		$(this).uploadFile({
			url: BASE_URL + "image/upload",
			returnType: 'json',
			showStatusAfterSuccess: false,
			showAbort: false,
			showDone: false,
			uploadButtonClass: "ajax-file-upload-green",
			maxFileSize: 1024 * 500,
			statusBarWidth: 90,
			dragdropWidth: 90,
			dragDropStr: '',
			sizeErrorStr: "画像の最大サイズを超えています。最大:",
			multiDragErrorStr: "画像は1つずつドラッグ＆ドロップしてください。",
			uploadErrorStr: "アップロードに失敗しました。",
			cancelStr: "キャンセル",
			multiple: false,
			dynamicFormData: function() {
				var param = {};
				param['user_id'] = USER_ID;
				setCsrfToken(param);
				return param;
			},
			onSuccess: function(files, data, xhr) {
				if(data.error === '') {
					$($thumbnail2[i]).attr('src', "/image/download/" + data.ids[0]);
					$($thumbnail2[i]).addClass("image-hover");
					$($image_id2[i]).val(data.ids[0]);
					$($thumbnail2[i]).hoverpulse({size: hover_size,speed : animate_speed});
				}
	        },
	        onLoad: function() {
	        	$(document).unbind('dragenter');
	       	 	$(document).unbind('dragover');
	       		$(document).unbind('drop');
	        }
	    });
	});

	$("#excel_fileuploader").each(function(i, v) {
		$(this).uploadFile({
			url: BASE_URL + "file/excel_upload",
			returnType: 'json',
			showStatusAfterSuccess: false,
			showAbort: false,
			showDone: false,
			uploadButtonClass: "ajax-file-upload-green",
			maxFileSize: 1024 * 1024 * 32,
			statusBarWidth: 180,
			dragdropWidth: 180,
			dragDropStr: '',
			sizeErrorStr: "最大サイズを超えています。最大:",
			multiDragErrorStr: "ファイルは1つずつドラッグ＆ドロップしてください。",
			uploadErrorStr: "アップロードに失敗しました。",
			cancelStr: "キャンセル",
			multiple: false,
			dynamicFormData: function() {
				loading.show();
				$("#excel_fileuploader_range input[type='file']").prop("disabled", true);

				var param = {};
				param['upload_option'] = $("input[name='upload_option']:checked").val();
				setCsrfToken(param);
				return param;
			},
			onSuccess: function(files, data, xhr) {
				if(data.error === '') {
					order_sheet_reflect(data.cells, data.upload_option);
				} else {
					$("#excel_fileuploader_range input[type='file']").prop("disabled", false);
					loading.fadeOut("normal");
					display_error_message(data.error);
				}
			},
			onLoad: function() {
	        	$(document).unbind('dragenter');
	       	 	$(document).unbind('dragover');
	       		$(document).unbind('drop');
	        }
		});
	});

	$(document).on('mouseenter', 'img.ui-datepicker-trigger', function (e) {
		$(this).fadeTo(50, 0.8);
	});
	$(document).on('mouseleave', 'img.ui-datepicker-trigger', function (e) {
		$(this).fadeTo(50, 1.0);
	});

	function order_sheet_reflect(cells, upload_option) {
		var empty_idxs = get_empty_column(cells, upload_option);
		if(cells.length > empty_idxs.length) {
			$("#excel_fileuploader_range input[type='file']").prop("disabled", false);
			loading.fadeOut("normal");
			display_error_message('入力可能明細数を超えています。');
		} else {
			var param = {};
			param['sheet_data'] = cells;
			setCsrfToken(param);

			$.ajax({
				url: BASE_URL + 'file/validate_excel_files',
				type: "POST",
				dataType: "json",
				data: param,
			})
			.done(function(data) {
				if(data.error != '') {
					display_error_message(data.error);
				} else {
					$.each(cells, function(idx, v) {
						var aft_idx = empty_idxs.shift();
						set_order_sheet_reflect_result(aft_idx, v);
					});
					calc_detail_all();
					display_info_message('明細を反映しました。');
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
				$("#excel_fileuploader_range input[type='file']").prop("disabled", false);
				loading.fadeOut("normal");
			});
		}
	}

	function set_order_sheet_reflect_result(idx, v) {
		$sku[idx].value = v[0];
		$request_amount[idx].value = v[1];
		if(v[2] != '') {
			$($thumbnail[idx]).attr('src', "/image/download/" + v[2])
							  .addClass("image-hover")
							  .hoverpulse({size: hover_size,speed : animate_speed});
			$image_id[idx].value = v[2];
		} else {
			$($thumbnail[idx]).attr('src', "")
							  .removeClass("image-hover")
							  .hoverpulse({size: 0,speed : 0});
			$image_id[idx].value = "";
		}
		if(v[3] != '') {
			$($thumbnail2[idx]).attr('src', "/image/download/" + v[3])
							   .addClass("image-hover")
							   .hoverpulse({size: hover_size,speed : animate_speed});
			$image_id2[idx].value = v[3];
		} else {
			$($thumbnail2[idx]).attr('src', "")
							   .removeClass("image-hover")
							   .hoverpulse({size: 0,speed : 0});
			$image_id2[idx].value = "";
		}
		$url1[idx].value = v[4];
		$url2[idx].value = v[5];
		$url3[idx].value = v[6];
		$valiation[idx].value = v[7];
		$demand[idx].value = v[8];
		$china_price[idx].value = v[9];
	}
	
	$(document).on('click', '#add_button', function (e) {
		var text = new Array();
		var amount = new Array();
		var price = new Array();
		var line = $('#orderTable').find('tbody').find('tr');
		$.each(line, function(index, obj) {
			text[0]=$(obj).find('input[id="form_other_option1_label[]"]').val();
			amount[0]=$(obj).find('input[id="form_other_option1_amount[]"]').val();
			price[0]=$(obj).find('input[id="form_other_option1_unit_price[]"]').val();
			text[1]=$(obj).find('input[id="form_other_option2_label[]"]').val();
			amount[1]=$(obj).find('input[id="form_other_option2_amount[]"]').val();
			price[1]=$(obj).find('input[id="form_other_option2_unit_price[]"]').val();
			text[2]=$(obj).find('input[id="form_other_option3_label[]"]').val();
			amount[2]=$(obj).find('input[id="form_other_option3_amount[]"]').val();
			price[2]=$(obj).find('input[id="form_other_option3_unit_price[]"]').val();
			
			text[3]=$(obj).find('input[id="form_other_option4_label[]"]').val();
			amount[3]=$(obj).find('input[id="form_other_option4_amount[]"]').val();
			price[3]=$(obj).find('input[id="form_other_option4_unit_price[]"]').val();
			text[4]=$(obj).find('input[id="form_other_option5_label[]"]').val();
			amount[4]=$(obj).find('input[id="form_other_option5_amount[]"]').val();
			price[4]=$(obj).find('input[id="form_other_option5_unit_price[]"]').val();
			text[5]=$(obj).find('input[id="form_other_option6_label[]"]').val();
			amount[5]=$(obj).find('input[id="form_other_option6_amount[]"]').val();
			price[5]=$(obj).find('input[id="form_other_option6_unit_price[]"]').val();
			
			text[6]=$(obj).find('input[id="form_other_option7_label[]"]').val();
			amount[6]=$(obj).find('input[id="form_other_option7_amount[]"]').val();
			price[6]=$(obj).find('input[id="form_other_option7_unit_price[]"]').val();			
			return false;
		});
		 $.each(line,function (index,obj){
			 $(obj).find('input[id="form_other_option1_label[]"]').val(text[0]);
			 $(obj).find('input[id="form_other_option1_amount[]"]').val(amount[0]);
			 $(obj).find('input[id="form_other_option1_unit_price[]"]').val(price[0]);	
			 $(obj).find('input[id="form_other_option2_label[]"]').val(text[1]);
			 $(obj).find('input[id="form_other_option2_amount[]"]').val(amount[1]);
			 $(obj).find('input[id="form_other_option2_unit_price[]"]').val(price[1]);	
			 $(obj).find('input[id="form_other_option3_label[]"]').val(text[2]);
			 $(obj).find('input[id="form_other_option3_amount[]"]').val(amount[2]);
			 $(obj).find('input[id="form_other_option3_unit_price[]"]').val(price[2]);	
			 $(obj).find('input[id="form_other_option4_label[]"]').val(text[3]);
			 $(obj).find('input[id="form_other_option4_amount[]"]').val(amount[3]);
			 $(obj).find('input[id="form_other_option4_unit_price[]"]').val(price[3]);		
			 $(obj).find('input[id="form_other_option5_label[]"]').val(text[4]);
			 $(obj).find('input[id="form_other_option5_amount[]"]').val(amount[4]);
			 $(obj).find('input[id="form_other_option5_unit_price[]"]').val(price[4]);	
			 $(obj).find('input[id="form_other_option6_label[]"]').val(text[5]);
			 $(obj).find('input[id="form_other_option6_amount[]"]').val(amount[5]);
			 $(obj).find('input[id="form_other_option6_unit_price[]"]').val(price[5]);			 
			 $(obj).find('input[id="form_other_option7_label[]"]').val(text[6]);
			 $(obj).find('input[id="form_other_option7_amount[]"]').val(amount[6]);
			 $(obj).find('input[id="form_other_option7_unit_price[]"]').val(price[6]);
	
		 })
	})


	function set_form_disable() {
		$detail_id.each(function(idx, v) {
			set_detail_disable(idx);

			var is_disable_status = ORDER_STATUS_UPDATE_ENABLE.length > 0
				&& $detail_status[idx].value != ''
				&& $.inArray($detail_status[idx].value, ORDER_STATUS_UPDATE_ENABLE) == -1;
			var is_disable_new = v.value == '' && !IS_ORDER_NEW;
			var is_disable_edit = v.value != '' && !IS_ORDER_EDIT;

			if(is_disable_status || is_disable_new || is_disable_edit) {
				var $tr = $($detail_status[idx]).closest("tr");
				$tr.find(':input').prop("disabled", true);
				$tr.find('.fileuploader').remove();
				$tr.find('.fileuploader2').remove();
				$($order_date[idx]).datepicker("destroy");
				$($receive_date[idx]).datepicker("destroy");

				if(!is_disable_status && !is_disable_new && is_disable_edit) {
					var is_admin = is_screen_admin();
					$($delete_check[idx]).prop("disabled", !is_admin);
					$($admin_message[idx]).prop("disabled", !is_admin);
					$($admin_message2[idx]).prop("disabled", !is_admin);
					$($detail_status[idx]).prop("disabled", !is_admin);

					if(IS_ORDER_AMOUNT) {
						var status = $detail_status[idx].value;
						if(status == DETAIL_STATUS_LIST['arrival']
							|| status == DETAIL_STATUS_LIST['preparation']) {
							$($real_amount[idx]).prop("disabled", !is_admin);
							if(is_receiver_fba_status()) {
								$($send_directly_box[idx]).prop("disabled", !is_admin);
							}
						}
					}
				}
			}
		});

		if(FORM_DISABLED) {
			if(is_screen_admin()) {
				$("#update_button").prop("disabled", true);
				$("#send_jnl_button").prop("disabled", true);
				$("#order_info_button").prop("disabled", true);
				$(".order-info-edit-button").prop("disabled", true);
				$(".send-edit-button").prop("disabled", true);
				$($order_date).datepicker("destroy");
				$($receive_date).datepicker("destroy");
			}
			$("#form_order_status").prop("disabled", true);
			$("#form_receiver_id").prop("disabled", true);
			$(".order-sheet-table :input").prop("disabled", true);
			$(".order-sheet-table-button").prop("disabled", false);
			$(".fileuploader").remove();
			$(".fileuploader2").remove();
		}
		$(".order-sheet-table-button").prop("disabled", false);
	}

	function calc_detail_all() {
		$detail_id.each(function(idx, v) {
			recalc_all(idx);
		});
		calc_total();
	}

	set_receiver_info();
	set_form_disable();
	display_special_options_all();

	if(!iS_READONLY) {
		calc_detail_all();
	}

	$("img.image-hover").hoverpulse({size: hover_size,speed : animate_speed});
	$(document).on("mouseenter","img.image-hover",
		function(){
			$(this).css("max-width", "none");
	});

	$(document).on("mouseleave","img.image-hover",
		function(){
			$(this).css("max-width", "");
	});
	var is_admin = is_screen_admin();
	if( !is_admin){
		$("[name='url1_checked_flg[]'],[name='url2_checked_flg[]'],[name='url3_checked_flg[]']").prop("disabled", !is_admin);
	}
});
