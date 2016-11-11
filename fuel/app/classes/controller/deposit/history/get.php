<?php

class Controller_Deposit_History_Get extends Controller_Template {

	public $template = 'template/template';

	public function before() {
		parent::before();
		if(!Auth::has_access('deposit.history') && !Auth::has_access('web.menu')) {
			Response::redirect('base/timeout');
		}
	}

	private function get_deposit_history_data($index, $deposit_history, $amount_cny) {
		$detail = $index . ',' . $deposit_history->order_id . ',' . $deposit_history->deposit_order_id . ',' 
				. $deposit_history->deposit_kbn . ',' . $deposit_history->reason . ',' .  $deposit_history->amount . ',' 
				. $amount_cny . ',' . $deposit_history->deposit . ',' . $deposit_history->payer_name . ',' 
				. $deposit_history->note . ',' . $deposit_history->created_at . ',' . '<br/>,';
		return $detail;
	}

	public function action_download_data() {
		$get_user_id      = Input::post('user_id');

		$user_id          = $this->get_user_id_deposit_history($get_user_id);
		$deposit_historys = Model_Deposit_Jnl::select_by_user_id($user_id);

		$index = 1;
		$details = 'No.,注文No,注文履歴,入出金区分,入出金理由,変動額,変動額(元),残高,振込先,備考,作成日時,<br/>,';
		foreach ($deposit_historys as $deposit_history) {
			if($deposit_history->order_id == 0) {
				$deposit_history->order_id = '';
			}

			if($deposit_history->deposit_order_id == 0) {
				$deposit_history->deposit_order_id = '';
			}

			$deposit_history->deposit_kbn = Utility::get_constant_name('deposit_status', $deposit_history->deposit_kbn);
			if($deposit_history->cny_jpy_rate != 0) {
				$amount_cny = round($deposit_history->amount / $deposit_history->cny_jpy_rate, 3);
			} else {
				$amount_cny = '';
			}
			$details .= $this->get_deposit_history_data($index, $deposit_history, $amount_cny);
			$index = $index + 1;
		}
		return json_encode(array(
			'detail'  => $details
		));
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
