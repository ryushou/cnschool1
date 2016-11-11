<?php

class Controller_Admin_Order_Get extends Controller_Template {

	public $template = 'template/template';

	public function before() {
		parent::before();
		if (!Auth::has_access('order.list')) {
			Response::redirect('base/timeout');
		}
	}

	private function get_order_data($order) {
		$order['order_status'] = Utility::get_constant_name2('order_status', $order['order_kbn'], $order['order_status']);
		$order['send_fba_flg'] = Utility::get_constant_name('address_kind', $order['send_fba_flg']);

		if($order['cny_jpy_rate'] != 0) {
			$order['international_delivery_fee_cny'] = round($order['international_delivery_fee'] / $order['cny_jpy_rate'], 3);
		} else {
			$order['international_delivery_fee_cny'] = '';
		}
		$order['transfer_commission'] = $order['sum_price'] - $order['sum_tax']
					 - ($order['product_price'] + $order['commission'] + $order['national_delivery_fee'] + $order['international_delivery_fee']);

		$detail = $order['id'] . ',' . $order['ordered_at'] . ',' . $order['payer_name'] . ',' . Utility::get_constant_name('order_kbn', $order['order_kbn']) . ',' . $order['order_status'] . ',' . $order['send_fba_flg'] . ','
				. $order['user_id'] . ',' . $order['name'] . ',' . $order['product_price'] . ',' . $order['sum_tax'] . ',' . $order['commission'] . ','
				. $order['transfer_commission'] . ',' . $order['national_delivery_fee'] . ',' . $order['international_delivery_fee'] . ','
				. $order['international_delivery_fee_cny'] . ',' . $order['sum_price'] . ',' . $order['order_bill_jnl_sum_price'] . ','
				. $order['cny_jpy_rate'] . ',' . $order['send_no'] . ',' . $order['weight'] . ',' . $order['delivery_fee_cny'] . ',' . $order['delivery_date'] . ','
				. '<br/>,';
		return $detail;
	}

	private function get_order_detail_data($order_detail) {
		$order_detail['ordered_at']    = date('Y-m-d', strtotime($order_detail['ordered_at']));
		$order_detail['detail_no']     = $order_detail['detail_no'] + 1;
		$order_detail['detail_status'] = Utility::get_constant_name2('order_status', $order_detail['order_kbn'], $order_detail['detail_status']);

		$detail = $order_detail['ordered_at'] . ',' . $order_detail['user_id'] . ',' . $order_detail['name'] . ',' 
				. $order_detail['order_id'] . ',' . $order_detail['detail_no'] . ',' . Utility::get_constant_name('order_kbn', $order_detail['order_kbn']) . ',' . $order_detail['detail_status'] . ',' 
				. $order_detail['real_amount'] . ',' . $order_detail['china_price'] . ',' . $order_detail['national_delivery_fee'] . ',' 
				. '<br/>,';
		return $detail;
	}

	public function action_download_data() {
		$search                 = array();
		$search['order_id']     = Input::post('order_id');
		$search['user_id']      = Input::post('user_id');		
		$search['status']       = Input::post('status');
		$search['status_range'] = Input::post('status_range');
		$search['message']      = Input::post('message');
		$search['untransact']   = Input::post('untransact');
		$search['sort']         = Input::post('sort');
		$search['fba_flg']      = Input::get('fba_flg');

		$order_ids = Model_Order_Jnl::get_order_ids_admin_lists($search);
		if(empty($order_ids)) {
			return json_encode(array(
				'detail'  => ''
			));
		}
		$orders  = Model_Order_Jnl::get_download_datas($order_ids, $search);

		$details = '請求番号,注文日時,振込先,注文区分,注文ステータス,配送先,会員番号,会員名,買い付け金額,消費税（合計）,代行手数料(合計),振込手数料,国内送料,国際送料（円）,国際送料（元）,合計金額,請求金額,為替,追跡番号,配送重量,送料（元）,配送予定日<br/>,';
		foreach ($orders as $order) {
			$details .= $this->get_order_data($order);
		}
		return json_encode(array(
			'detail'  => $details
		));
	}

	public function action_all_data_download_data() {
		$order_details = Model_Order_Detail::get_all_data_download_datas();
		if(empty($order_details)) {
			return json_encode(array(
				'detail'  => ''
			));
		}

		$details = '注文日,会員番号,会員名,注文No.,明細番号,注文区分,注文ステータス,実数量,単価(元),国内送料(元)<br/>,';
		foreach ($order_details as $order_detail) {
			$details .= $this->get_order_detail_data($order_detail);
		}

		return json_encode(array(
			'detail'  => $details
		));
	}
}
