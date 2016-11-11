<?php

class Controller_Admin_Send_Input_Get extends Controller_Template {

	public $template = 'template/template';

	public function before() {
		parent::before();
		if (!Auth::has_access('send.input')) {
			Response::redirect('base/timeout');
		}
	}

	private function get_invoice_header_data($send_jnl, $order, $user) {
		$profile_fields = @unserialize($user->profile_fields);
		$user_zip       = \Arr::get($profile_fields, 'zip', '');
		$user_address1  = \Arr::get($profile_fields, 'address1', '');
		$user_address2  = \Arr::get($profile_fields, 'address2', '');
		$user_tel       = \Arr::get($profile_fields, 'phone', '');

		$detail = '差出人,' //左上
				. '環日本海有限公司,' . '322000,' . '"1st floor unit 5,building 4, 3 area,",'
				. '"louxia village, zhejiang,china",' . 'TEL: 15015906051' . '<br/>,'

				. '荷受人,' //左下
				. $order->send_receiver . ',' . $order->send_name . ','
				. $order->send_address1 . ',' . $order->send_address2 . ',' . 'TEL: ' . $order->send_phone . '<br/>,'

				//右上
				. '配送日付,' . str_replace('-', '/', $send_jnl->delivery_date) . '<br/>,'
				. '配送手段,' . $send_jnl->delivery_name . '<br/>,'
				. '追跡番号,' . $send_jnl->send_no . '<br/>,'
				. '注文番号,' . $order->id . '<br/>,'
				. '備考,処理品として販売<br/>,'
				. '箱数,' . $send_jnl->total_box . '<br/>,'
				. '生産国,CHINA<br/>,'
				. '差出地,YIWU CHINA<br/>,'
				. '宛地,JAPAN<br/>,'

				//右下
				. '輸入者,'
				. $user->name . ',' . $user_zip . ','
				. $user_address1 . ',' . $user_address2 . ',' . 'TEL: ' . $user_tel . '<br/>,<br/>,';
		return $detail;
	}

	private function get_invoice_footer_data($order_detail, $send_detail) {
		$order_detail['detail_no'] = $order_detail['detail_no'] + 1;
		$detail = $order_detail['detail_no'] . ',' . $send_detail['product_name'] . ',' . '' . ',' . $send_detail['amount'] . ',' 
				. $send_detail['unit_price'] . ',' . $send_detail['product_price'] . '<br/>,';
		return $detail;
	}

	public function action_invoice_download_data() {
		$send_id  = Input::post('send_id');
		$order_id = Input::post('order_id');

		$send_jnl = Model_Send_Jnl::select_primary_admin($send_id);
		if(!$send_jnl) {
			Response::redirect('base/timeout');
		}

		$order = Model_Order_Jnl::select_primary($send_jnl->user_id, $send_jnl->order_id);
		$user = Model_Users::select_primary($send_jnl->user_id);
		if(!$order || !$user) {
			Response::redirect('base/timeout');
		}

		//BOM付UTF-8にするため
		$header_field = chr(239) . chr(187) . chr(191);
		$header_field .= $this->get_invoice_header_data($send_jnl, $order, $user);

		$footer_field = '明細行番号,品名,品名,数量,単価（円）,金額（円）<br/>,';

		$select_detail_ids = Model_Send_Detail::get_order_detail_ids($send_id);
		if(empty($select_detail_ids)) {
			Response::redirect('base/timeout');
		}

		$send_details = '';
		$order_detail_list = Model_Order_Detail::select_primaries($order_id, $select_detail_ids);
		foreach ($order_detail_list as $order_detail) {
			$send_detail  = Model_Send_Detail::select_primary($send_id, $order_detail->id);
			$send_details .= $this->get_invoice_footer_data($order_detail, $send_detail);
		}

		if(Utility::is_empty($send_details)) {
			Response::redirect('base/timeout');
		}
		$details = $header_field . $footer_field . $send_details;

		return json_encode(array(
			'detail'  => $details
		));
	}
}
