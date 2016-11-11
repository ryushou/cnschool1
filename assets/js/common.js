
	function form_error_check(input_elm, has_error_func) {
		var error_class = "has-error has-feedback";
		var form = input_elm.closest('div.form-control-box');
		var has_error = has_error_func(input_elm.val());
		if(has_error) {
			form.addClass(error_class);
			form.append('<span class="glyphicon glyphicon-remove form-control-feedback"></span>');
		} else {
			form.removeClass(error_class)
			form.find('span.form-control-feedback').remove();
		}
		return has_error;
	}

	function form_error_check_array(check_array) {
		var error_message = "";
		$.each(check_array, function(i, val) {
			var has_error = form_error_check(val['input_elm'], val['has_error_func']);
			if(has_error) {
				if(error_message != "") {
					error_message += "</br>";
				}
				error_message += val['message'];
			}
		});
		return error_message;
	}

	function display_error_message(message) {
		if(message != '') {
			$('#display-notify-message')
				.removeClass('display-info-message')
				.addClass('display-error-message')
				.html(message)
				.finish().fadeIn(300).delay(5000).fadeOut();
		}
	}

	function display_info_message(message) {
		if(message != '') {
			$('#display-notify-message')
				.removeClass('display-error-message')
				.addClass('display-info-message')
				.html(message)
				.finish().fadeIn().delay(5000).fadeOut();
		}
	}

	function format(fmt, a){
	    var rep_fn;
	    if (typeof a == "object") {
	        rep_fn = function(m, k) { return a[ k ]; }
	    } else {
	        var args = arguments;
	        rep_fn = function(m, k) { return args[ parseInt(k)+1 ]; }
	    }
	    return fmt.replace( /\{(\w+)\}/g, rep_fn);
	}

	var register_enter_action = function($button, $element) {
		$element.keydown(function(e) {
			if (e.keyCode == 13) {
				var val = $.data(e.target, 'keydown');
				if(val !== true) {
					if($button.attr('disabled') === undefined) {
						$.data(e.target, 'keydown', true);
						$button.click();
					}
				}
				e.preventDefault();
			}
		});
		$element.keyup(function(e) {
			if (e.keyCode == 13) {
				$.data(e.target, 'keydown', false);
				e.preventDefault();
			}
		});
		$element.blur(function(e) {
			$.data(e.target, 'keydown', false);
		});
	};

	function get_number_format(number) {
		return number = String(number).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, '$1,');
	}

	function get_image_format(image_id) {
		return image_src = "/image/download/" + image_id;
	}

	function get_name_values(field) {
		return $("[name='" + field + "[]']");
	}

	function get_name_match_values(field) {
		return $("[name*='" + field + "[']");
	}

	function location_timeout(wait, href) {
		setTimeout(function() {
					location.href = href;
				}, wait);
	}

	function reload_timeout(wait) {
		setTimeout(function() {
					location.reload();
				}, wait);
	}

	function get_datepicker_config() {
		return {
			dateFormat: "yy-mm-dd",
			maxDate: "+40D",
			firstDay: 1,
			showButtonPanel: true,
			currentText: '当月',
			showOn: "button",
			buttonImage: BASE_URL + "assets/img/calender.png",
			buttonImageOnly: true,
		};
	}

	function get_profile_query(wait) {
		var param = {};
		param['query_profile'] = '1';
		setCsrfToken(param);

		$.ajax({
			url: BASE_URL + 'base/query_profile',
			type: "POST",
			dataType: "json",
			data: param,
		})
		.done(function(data) {
			$pqp_queries = $("#pqp-queries .pqp-main tbody").append(data.queries);
			if(wait < 10000) {
				setTimeout('get_profile_query(' + (wait+5000) + ')', wait);
			}
		})
		.fail(function(req, status, thrown) {
			console.log('profile query error.');
		})
		.always(function() {

		});
	}

$(function() {
	$("<div id='display-notify-message' />").appendTo($("body"));

	if(DEBUG) {
		setTimeout('get_profile_query(2000)', 1000);
	}
});