<?php

class Controller_Admin_Send_Input_Calc extends Controller_Template {

	public $template = 'template/template';

	public function before() {
		parent::before();
		if (!Auth::has_access('send.input')) {
			Response::redirect('base/timeout');
		}
	}

	public function action_delivery_fee() {
		$delivery_name = Input::post('delivery_name');
		$weight        = Input::post('weight');

		if(Utility::is_empty($delivery_name)) {
			return json_encode(array(
				'error'  => '『配送業者』は必須です',
				'info'  => '',
				'delivery_fee_cny' => '',
			));			
		}

		if(!preg_match('/^\d{1,5}(\.\d{1})?$/', $weight)) {
			return json_encode(array(
				'error'  => '指定の重量は範囲を超えているか、または形式が違います',
				'info'  => '',
				'delivery_fee_cny' => '',
			));
		}

		$delivery_id   = Model_Deliveries::get_deliver_by_name($delivery_name)->id;
		$delivery_fees = Model_International_Delivery_Fee::get_delivery_fees($weight, $delivery_id);
		if(!$delivery_fees) {
			return json_encode(array(
				'error'  => '指定の配送業者は料金表にありません',
				'info'  => '',
				'delivery_fee_cny' => '',
			));
		}

		$ceil_weight = ceil($weight);
		if(isset($delivery_fees[1])) {
			if($delivery_fees[1]['delivery_fee_slope'] != 0 && $delivery_fees[1]['weight_min'] == $ceil_weight) {
				$delivery_fee_cny = $delivery_fees[1]['delivery_fee_slope'] * $ceil_weight;
			} else {
				if($delivery_fees[0]['delivery_fee_slope'] != 0) {
					$delivery_fee_cny = $delivery_fees[0]['delivery_fee_slope'] * $ceil_weight;
				} else {
					if($delivery_fees[1]['delivery_fee_slope'] != 0) {
						$delivery_fee_cny = $delivery_fees[1]['delivery_fee_slope'] * $ceil_weight;
					} else {
						$delivery_fee_cny = $delivery_fees[1]['delivery_fee_cny'];
					}
				}
			}
		} else {
			$delivery_fee_cny = $delivery_fees[0]['delivery_fee_slope'] * $ceil_weight;
		}

		return json_encode(array(
			'error'  => '',
			'info'  => '送料（元）に反映しました',
			'delivery_fee_cny' => $delivery_fee_cny,
		));
	}
}
