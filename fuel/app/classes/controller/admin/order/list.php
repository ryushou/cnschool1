<?php

class Controller_Admin_Order_List extends Controller_Template {

	public $template = 'template/template';

	public function before() {
		parent::before();
		if (!Auth::has_access('order.list')) {
			Response::redirect('base/timeout');
		}
	}

	public function action_index() {
		$this->template->title = '注文一覧';
		$this->template->content = View::forge('admin/order/list');
	}

	private function get_order_array($order) {
		$detail = array();
		$detail['id']               = $order['id'];
		$detail['user_id']          = $order['user_id'];
		$detail['created_at']       = $order['created_at'];
		$detail['ordered_at']       = $order['ordered_at'];
		$detail['detail_count']     = $order['detail_count'];
		$detail['sum_price']        = $order['sum_price'];
		$detail['image_id']         = $order['image_id'];
		$detail['payer_name']       = $order['payer_name'];
		$detail['payer_url']        = $order['payer_url'];
		$detail['order_status']     = $order['order_status'];
		$detail['order_status_flg'] = $order['order_status_flg'];
		$detail['order_kbn']        = $order['order_kbn'];
		$detail['send_fba_flg']     = $order['send_fba_flg'];
		
		$detail['send_name']     = $order['send_name'];
		$detail['send_receiver']     = $order['send_receiver'];
		
		$detail['message_unread_count'] = $order['message_unread_count'];
		return $detail;
	}

	public function action_search() {
		$search                 = array();
		$search['order_id']     = Input::get('order_id');
		$search['user_id']      = Input::get('user_id');		
		$search['status']       = Input::get('status');
		$search['status_range'] = Input::get('status_range');
		$search['message']      = Input::get('message');
		$search['untransact']   = Input::get('untransact');
		$search['sort']         = Input::get('sort');
        
        $search['fba_flg']         = Input::get('fba_flg');
		$order_ids = Model_Order_Jnl::get_order_ids_admin_lists($search);
		if(empty($order_ids)) {
			return json_encode(array(
				'pagination' => '',
				'detail'  => ''
			));
		}
		$total_items = Model_Order_Jnl::get_admin_lists_count($order_ids);
		$pagination  = Pagination::forge('bootstrap3', Utility::get_paging_config($total_items));
		$orders      = Model_Order_Jnl::get_admin_lists($order_ids, $pagination, $search);

		$details = array();
		foreach ($orders as $order) {
			$order['order_status_flg'] = $order['order_status'];
			$order['order_status'] = Utility::get_constant_name2('order_status', $order['order_kbn'], $order['order_status']);
			$order['send_fba_flg'] = Utility::get_constant_name('address_kind', $order['send_fba_flg']);

			$details[]             = $this->get_order_array($order);
		}
		return json_encode(array(
			'pagination' => $pagination->render(),
			'detail'  => $details
		));
	}
}
