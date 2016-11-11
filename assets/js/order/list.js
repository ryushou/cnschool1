$(function() {
	$("#order_date_from").datepicker(get_datepicker_config());
	$("#order_date_to").datepicker(get_datepicker_config());

	$("img.ui-datepicker-trigger").hover(
		function() {
			$(this).fadeTo(50, 0.8);
		}, function() {
			$(this).fadeTo(50, 1.0);
		}
	);

	$("#reset_button").click(function(e) {
		$("#form_status").val('');
		$("#form_status_range").val('');
		$("#order_date_from").val('');
		$("#order_date_to").val('');
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
				param["status"]          = $("#form_status").val();
				param["status_range"]    = $("#form_status_range").val();
				param["order_date_from"] = $("#order_date_from").val();
				param["order_date_to"]   = $("#order_date_to").val();
			}
			param["page"] = page_id; // for pagination
			return param;
		};
	}();

	
	var formatDateTime = function (date) {  
	    var y = date.getFullYear();  
	    var m = date.getMonth() + 1;  
	    m = m < 10 ? ('0' + m) : m;  
	    var d = date.getDate();  
	    d = d < 10 ? ('0' + d) : d;  
	    var h = date.getHours();  
	    var minute = date.getMinutes();  
	    var second = date.getSeconds();
	    minute = minute < 10 ? ('0' + minute) : minute; 
	    second = minute < 10 ? ('0' + second) : second;
	    return y + '-' + m + '-' + d+' '+h+':'+minute+':'+second;  
	};  
	function order_reference(paging_flg, page_id) {
		var param = get_search_param(paging_flg, page_id);
		setCsrfToken(param);

		var loading = $("#loading").show();

		$('#search_button').button('loading');
		$('#reset_button').button('loading');

		$.ajax({
			url: BASE_URL + 'order/list/search',
			type: 'GET',
			dataType: 'json',
			data: param,
		})
		.done(function(data) {
			outputdata = [];
			$.each(data["detail"], function(i, val) {
				var d = {};
				d["id"]               = val["id"];
				d["created_at"]       = val["created_at"];

				d["received_at"]       = val["created_at"];
				d["detail_count"]     = get_number_format(val["detail_count"]);
				d["sum_price"]        = get_number_format(val["sum_price"]);
				d["image_src"]        = get_image_format(val["image_id"]);
				d["payer_name"]       = val["payer_name"];
				d["payer_url"]        = val["payer_url"];
				d["order_status"]     = val["order_status"];
				d["order_status_flg"] = val["order_status_flg"];
				d["order_kbn"]        = val["order_kbn"];
				d["send_fba_flg"]     = val["send_fba_flg"];

				if(d["send_fba_flg"]=="FBA"||d["send_fba_flg"]=="FBA（船便）"){
					d["send_fba_flg"]=val["send_receiver"];
					var date =new Date(d["created_at"]);
					  
					   var day=date.getDate()+7;
					   date.setDate(day);
					   date=formatDateTime(date);
					d["received_at"]        = date;
				}
				if(d["send_fba_flg"]=="事務所"||d["send_fba_flg"]=="事務所（船便）"){
					d["send_fba_flg"]=val["send_name"];
					  var date =new Date(d["created_at"]);
					
					   var day=date.getDate()+5;
					   date.setDate(day);
					   date=formatDateTime(date);
					d["received_at"]        = date;
				}
				d["user_note"]        = val["user_note"];
				d["message_unread_count"] = val["message_unread_count"];
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
		});
	}

	$(document).on('click', '#pagination a', function (e) {
		e.preventDefault();

		var page_id = $(this).attr('value').replace('?page=', '');
		order_reference(true, page_id);
	});

	$(document).on('click', 'button.delete_button', function (e) {
		e.preventDefault();
		$('#order_id_modal').val($(this).attr('value'));
		$('#info_delete_modal').modal('show');
	});

	$("#delete_button").click(function(e){
		var param = {};
		param['order_id'] = $('#order_id_modal').val();
		setCsrfToken(param);

		var loading = $("#loading").show();

		$('#search_button').button('loading');
		$('#reset_button').button('loading');

		$('#info_delete_modal').modal('hide');

		$.ajax({
			url: BASE_URL + 'order/list/delete',
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

				$('#search_button').button('reset');
				$('#reset_button').button('reset');

				order_reference(true, 1);
			}
		});
		e.preventDefault();
	});

	order_reference(false, 1);
});
