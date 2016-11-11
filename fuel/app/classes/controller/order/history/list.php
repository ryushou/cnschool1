<?php

class Controller_Order_History_List extends Controller_Template {

	public $template = 'template/template';

	public function before() {
		parent::before();
		if (!Auth::has_access('web.menu')) {
			Response::redirect('base/timeout');
		}
	}

	public function action_index() {
		$this->template->title = '注文履歴一覧';
		$this->template->content = View::forge('order/history/list');
	}

	private function get_order_array($order) {
		$detail = array();
		$detail['order_detail_id'] = $order['id'];
		$detail['order_id']        = $order['order_id'];
		$detail['detail_no']       = $order['detail_no'] + 1;
		$detail['image_id']        = $order['image_id'];
		$detail['valiation']       = $order['valiation'];
		$detail['sku']             = $order['sku'];
		$detail['japan_price']     = $order['japan_price'];
		$detail['request_amount']  = $order['request_amount'];
		$detail['real_amount']     = $order['real_amount'];
		return $detail;
	}

	public function action_search() {
		$user_id                   = Utility::get_user_id();
		$search                    = array();
		$search['order_id']        = Input::get('order_id', '');
		$search['valiation']       = Input::get('valiation', '');
		$search['sku']             = Input::get('sku', '');

		$detail_ids = Model_Order_Detail::get_order_ids_user_history_lists($user_id, $search);
		if(empty($detail_ids)) {
			return json_encode(array(
				'pagination' => '',
				'detail'  => ''
			));
		}
		$total_items = Model_Order_Detail::get_user_history_lists_count($user_id, $detail_ids);
		$pagination  = Pagination::forge('bootstrap3', Utility::get_paging_config($total_items));
		$orders      = Model_Order_Detail::get_user_history_lists($user_id, $detail_ids, $pagination);

		$details = array();
		foreach ($orders as $order) {
			$details[] = $this->get_order_array($order);
		}

		return json_encode(array(
			'pagination' => $pagination->render(),
			'detail'  => $details
		));
	}

	private function validate_is_draft() {
		$validation = Validation::forge();
		$validation->add('order_id', '注文No')
			->add_rule('valid_string', array('numeric'));

		$validation->run();
		return $validation;
	}

	public function action_is_draft() {
		$user_id  = Utility::get_user_id();
		$order_id = Input::post('order_id', '');

		$detail_count = 0;
		if(!Utility::is_empty($order_id)) {
			$validation = $this->validate_is_draft();
			$errors     = $validation->error();
			if (!empty($errors)) {
				return json_encode(array(
					'error' => $validation->show_errors(),
				));
			}

			$order = Model_Order_Jnl::select_primary($user_id, $order_id);
			if(!$order) {
				return json_encode(array(
					'error' => '注文が見つかりません。',
				));
			}
			$detail_count = $order->detail_count;

			$order_is_draft = Model_Order_Jnl::select_primary_is_draft($user_id, $order_id);
			if(!$order_is_draft) {
				return json_encode(array(
					'error' => '注文ステータスが作成中のときに引き継げます。',
				));
			}
		}

		return json_encode(array(
			'error' => '',
			'order_id' => $order_id,
			'detail_count' => $detail_count,
		));
	}
}
