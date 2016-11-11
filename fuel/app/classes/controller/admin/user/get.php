<?php

class Controller_Admin_User_Get extends Controller_Template {

	public $template = 'template/template';

	public function before() {
		parent::before();
		if (!Auth::has_access('user.list')) {
			Response::redirect('base/timeout');
		}
	}

	private function get_user_data($user, $member_rank) {
		$detail = $user->id . ',' . $member_rank . ',' . $user->name . ',' 
				. $user->email . ',' . $user->deposit . ',' .  $user->skype_id . ',' 
				. $user->chatwork_id . ',' . '<br/>,';
		return $detail;
	}

	private function get_deposit_history_data($index, $deposit_history, $amount_cny) {
		$detail = date('Y-m-d', strtotime($deposit_history['created_at'])) . ',' . $index . ',' . $deposit_history['user_id'] . ',' . $deposit_history['name'] . ',' 
				. $deposit_history['order_id'] . ',' . $deposit_history['deposit_order_id'] . ',' . $deposit_history['deposit_kbn'] . ',' 
				. $deposit_history['reason'] . ',' .  $deposit_history['amount'] . ',' . $amount_cny . ',' . $deposit_history['deposit'] . ',' 
				. $deposit_history['payer_name'] . ',' . $deposit_history['note'] . ',' . $deposit_history['created_at'] . ',' . '<br/>,';
		return $detail;
	}

	public function action_download_data() {
		$users = Model_Users::get_users_by_group(Config::get('constant.user_group.kbn'));

		$details = 'ユーザID,会員ランク,お名前,メールアドレス,残高,スカイプID,チャットワークID,<br/>,';
		foreach ($users as $user) {
			$member_rank = Utility::get_constant_name('member_rank', $user->member_rank);
			$details    .= $this->get_user_data($user, $member_rank);
		}
		return json_encode(array(
			'detail'  => $details
		));
	}

	public function action_deposit_history_download_data() {
		$deposit_history_day = Input::post('deposit_history_day');
		$deposit_history_day = $deposit_history_day - 1; //？日分の入出金履歴をすべて出力できるように
		$deposit_historys = Model_Deposit_Jnl::select_by_history_day($deposit_history_day);

		$details = '日付,No.,ユーザID,お名前,注文No,注文履歴,入出金区分,入出金理由,変動額,変動額(元),残高,振込先,備考,作成日時,<br/>,';
		$index = 1;
		foreach ($deposit_historys as $deposit_history) {
			if($deposit_history['order_id'] == 0) {
				$deposit_history['order_id'] = '';
			}

			if($deposit_history['deposit_order_id'] == 0) {
				$deposit_history['deposit_order_id'] = '';
			}

			$deposit_history['deposit_kbn'] = Utility::get_constant_name('deposit_status', $deposit_history['deposit_kbn']);
			if($deposit_history['cny_jpy_rate'] != 0) {
				$amount_cny = round($deposit_history['amount'] / $deposit_history['cny_jpy_rate'], 3);
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
}
