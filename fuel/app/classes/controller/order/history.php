<?php

class Controller_Order_History extends Controller_Template {

	public $template = 'template/template';

	public function before() {
		parent::before();
		if(!Auth::has_access('deposit.history') && !Auth::has_access('web.menu')) {
			Response::redirect('base/timeout');
		}
	}

	public function action_index() {
		$deposit_order_id = Input::get('id');
		$order = Model_Deposit_Order_Jnl::select_primary_admin($deposit_order_id);
		if(!$order) {
			Response::redirect('base/timeout');
		}

		if(!Auth::has_access('deposit.history')) {
			$user_id = Utility::get_user_id();
			if($order->user_id != $user_id) {
				Response::redirect('base/timeout');
			}
		}

		$order_detail = Model_Deposit_Order_Detail::get_order_list($order->user_id, $deposit_order_id);
		$send_jnl_list = array();
		$total_delivery_fee = $order->international_delivery_fee;
		$message_unread_count = Model_Order_Message::select_unread_count($order->id);

		$max_detail_count = Utility::get_order_sheet_detail_count($order->user_id);
		for($i = count($order_detail); $i < $max_detail_count; $i++) {
			$order_detail[] = Model_Order_Detail::forge();
		}

		$commission = Model_Commissions::forge();
		$commission->commission = $order->commission_rate;
		$commission->minimum_commission = $order->minimum_commission;

		$this->template->title = '注文履歴';
		$this->template->content = View::forge('order/sheet');
		$this->template->content->set_safe('order', $order);
		$this->template->content->set_safe('order_detail', $order_detail);
		$this->template->content->set_safe('commission', $commission);
		$this->template->content->set_safe('payer', $order);
		$this->template->content->set_safe('send_jnl_list', $send_jnl_list);
		$this->template->content->set_safe('total_delivery_fee', $total_delivery_fee);
		$this->template->content->set_safe('message_unread_count', $message_unread_count);
		$this->template->content->set_safe('is_history', true);
	}
}
