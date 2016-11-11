$(function() {
	var hover_size = 80;
	var animate_speed = 200;

	$("[name='request_state_date'],[name='request_state_date_admin'],[name='reference_url_date_admin']," +
	  "[name='budget_date'],[name='budget_date_admin'],[name='other_date'],[name='other_date_admin']")
	.datepicker(get_datepicker_config());

	$("#update_button").click(function(e) {
		var loading = $("#loading").show();
		$('#update_button').button('loading');

		var param = {
			'order_info_id': $("#form_order_info_id").val(),
			'order_id': $("#form_order_id").val(),
			'request_state_date': $("#form_request_state_date").val(),
			'request_state_note': $("#form_request_state_note").val(),
			'request_state_date_admin': $("#form_request_state_date_admin").val(),
			'request_state_note_admin': $("#form_request_state_note_admin").val(),
			'reference_url': $("#form_reference_url").val(),
			'reference_url_note': $("#form_reference_url_note").val(),
			'reference_url_date_admin': $("#form_reference_url_date_admin").val(),
			'reference_url_note_admin': $("#form_reference_url_note_admin").val(),
			'budget_date': $("#form_budget_date").val(),
			'budget_note': $("#form_budget_note").val(),
			'budget_date_admin': $("#form_budget_date_admin").val(),
			'budget_note_admin': $("#form_budget_note_admin").val(),
			'other_date': $("#form_other_date").val(),
			'other_note': $("#form_other_note").val(),
			'other_date_admin': $("#form_other_date_admin").val(),
			'other_note_admin': $("#form_other_note_admin").val(),
			'attach_id': $("#form_attach_id").val(),
			'attach_note': $("#form_attach_note").val(),
		};
		setCsrfToken(param);

		$.ajax({
			url: BASE_URL + 'admin/order/info/input/update',
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
				var href = BASE_URL + "admin/order/info/input?oid=" + data.order_id;
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
		e.preventDefault();
	})

	$(".fileuploader").each(function(i, v) {
		$(this).uploadFile({
			url: BASE_URL + "order/attach/upload",
			returnType: 'json',
			showStatusAfterSuccess: true,
			showAbort: true,
			showDone: true,
			uploadButtonClass: "ajax-file-upload-green",
			maxFileSize: 1024 * 1024 * 16,
			statusBarWidth: 90,
			dragdropWidth: 90,
			dragDropStr: '',
			sizeErrorStr: "最大サイズを超えています。最大:",
			multiDragErrorStr: "画像は1つずつドラッグ＆ドロップしてください。",
			uploadErrorStr: "アップロードに失敗しました。",
			cancelStr: "キャンセル",
			multiple: false,
			dynamicFormData: function() {
				var param = {};
				param['user_id'] = $('#form_user_id').val();
				param['order_id'] = $('#form_order_id').val();
				setCsrfToken(param);
				return param;
			},
			onSuccess: function(files, data, xhr) {
				if(data.error === '') {
					$("[name='thumbnail']").attr('src', "/order/attach/download/" + data.ids[0]);
					$("[name='thumbnail']").addClass("image-hover");
					$("[name='attach_id']").val(data.ids[0]);
					$("[name='thumbnail']").hoverpulse({size: hover_size,speed : animate_speed});
				}
			},
		});
	});

	$(document).on('mouseenter', 'img.ui-datepicker-trigger', function (e) {
		$(this).fadeTo(50, 0.8);
	});
	$(document).on('mouseleave', 'img.ui-datepicker-trigger', function (e) {
		$(this).fadeTo(50, 1.0);
	});

	$("img.image-hover").hoverpulse({size: hover_size,speed : animate_speed});
	$(document).on("mouseenter","img.image-hover",
		function(){
			$(this).css("max-width", "none");
	});

	$(document).on("mouseleave","img.image-hover",
		function(){
			$(this).css("max-width", "");
	});
});
