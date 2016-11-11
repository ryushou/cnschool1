$(function() {
	var deposit = BigNumber($("#deposit").val());

	$("#form_deposit_kbn").change(function() {
		change_deposit_mark();
	});

	$("#amount,#form_payers_id").change(function() {
		recalc_deposit();
	});

	function change_deposit_mark() {
		var $deposit_mark = $("#deposit_mark");
		var $payer_area = $(".payer_input_area");

		if($("#form_deposit_kbn").val() == DEPOSIT_STATUS_RECEIPT) {
			$deposit_mark.text('円加算');
			$payer_area.show('normal');
		} else {
			$deposit_mark.text('円減算');
			$payer_area.hide('normal');
		}
		recalc_deposit();
	}

	function recalc_deposit() {
		var amount = $("#amount").val();
		var $deposit = $("#deposit");

		var result;
		if($.isNumeric(amount)) {
			var big_amount = BigNumber(amount);
			if($("#form_deposit_kbn").val() == DEPOSIT_STATUS_RECEIPT) {
				result = deposit.plus(big_amount);
			} else {
				result = deposit.minus(big_amount);
			}
		} else {
			result = deposit;
		}
		$deposit.val(result.toFormat());
	}

	change_deposit_mark();
});
