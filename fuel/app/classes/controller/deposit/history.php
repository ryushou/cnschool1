<?php

class Controller_Deposit_History extends Controller_Template {

	public $template = 'template/template';

	public function before() {
		parent::before();
		if(!Auth::has_access('deposit.history') && !Auth::has_access('web.menu')) {
			Response::redirect('base/timeout');
		}
	}

	public function action_index() {
		$get_user_id = Input::get('id');
		$user_id     = $this->get_user_id_deposit_history($get_user_id);
		$user        = Model_Users::select_primary($user_id);
		if(!$user) {
			Response::redirect('base/timeout');
		}
		$this->template->title = '残高履歴';
		$this->template->content = View::forge('deposit/history');
		$this->template->content->set_safe('user_id', $user_id);
		$this->template->content->set_safe('name', $user->name);
	}

	public function action_search() {
		$search             = array();
		$get_user_id        = Input::get('user_id');
		$search['order_id'] = Input::get('order_id');

		$user_id          = $this->get_user_id_deposit_history($get_user_id);
		$total_items      = Model_Deposit_Jnl::get_deposit_history_count($user_id, $search);
		$pagination       = Pagination::forge('bootstrap3', Utility::get_paging_config($total_items));
		$deposit_historys = Model_Deposit_Jnl::get_deposit_history_lists($user_id, $search, $pagination);

		$details = array();
		foreach ($deposit_historys as $deposit_history) {
			$deposit_history['deposit_kbn'] = Utility::get_constant_name('deposit_status', $deposit_history['deposit_kbn']);
			$details[] = $this->get_deposit_history_array($deposit_history);
		}
		return json_encode(array(
			'pagination' => $pagination->render(),
			'detail'  => $details
		));
	}

	private function get_deposit_history_array($deposit_history) {
		if($deposit_history['order_id'] == 0) {
			$deposit_history['order_id'] = '';
		}
		if($deposit_history['deposit_order_id'] == 0) {
			$deposit_history['deposit_order_id'] = '';
		}
		$detail                = array();
		$detail['id']          = $deposit_history['id'];
		$detail['created_at']  = $deposit_history['created_at'];
		$detail['order_id']    = $deposit_history['order_id'];
		$detail['deposit_order_id'] = $deposit_history['deposit_order_id'];
		$detail['deposit_kbn'] = $deposit_history['deposit_kbn'];
		$detail['reason']      = $deposit_history['reason'];
		$detail['amount']      = $deposit_history['amount'];
		$detail['deposit']     = $deposit_history['deposit'];
		$detail['payer_name']  = $deposit_history['payer_name'];
		$detail['note']        = $deposit_history['note'];
		if(Auth::has_access('deposit.history')) {
			if($deposit_history['cny_jpy_rate'] != 0) {
				$detail['amount_cny'] = round($deposit_history['amount'] / $deposit_history['cny_jpy_rate'], 3);
			} else {
				$detail['amount_cny'] = '';
			}
		}
		return $detail;
	}

	private function get_user_id_deposit_history($get_user_id) {
		if(Auth::has_access('deposit.history') && !Utility::is_empty($get_user_id)) {
			$user_id = $get_user_id;
		} else {
			$user_id = Utility::get_user_id();
		}
		return $user_id;
	}
}
