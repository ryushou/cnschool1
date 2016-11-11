<?php

class Controller_Admin_Deposit_Input extends Controller_Template {

	public $template = 'template/template';

	public function before() {
		parent::before();
		if (!Auth::has_access('deposit.input')) {
			Response::redirect('base/timeout');
		}
	}

	public function action_index() {
		$user_id = Input::get('id');
		$user = Model_Users::select_primary($user_id);
		if(!$user) {
			Response::redirect('base/timeout');
		}
		$this->template->title = '入出金入力';
		$this->template->content = View::forge('admin/deposit/input');
		$this->template->content->set_safe('infomsg', '');
		$this->template->content->set_safe('errmsg', '');
		$this->template->content->set_safe('user', $user);
		$this->template->content->set_safe('deposit', Model_Deposit_Jnl::forge());
	}

	private function validate_registered($deposit) {
		$validation = Validation::forge();
		$validation->add('deposit_kbn', '区分')
			->add_rule('required');
		$validation->add('amount', '金額')
			->add_rule('required')
			->add_rule('numeric_between', 1, 5000000)
			->add_rule('max_length', 7);
		$validation->add('reason', '入出金理由')
			->add_rule('required')
			->add_rule('max_length', 15);
		$validation->add('note', '備考')
			->add_rule('max_length', 15);
		if($deposit->deposit_kbn == Config::get('constant.deposit_status.kbn.receipt')) {
			$validation->add('payers_id', '振込先')
				->add_rule('required');
		}
		$validation->run();
		return $validation;
	}

	public function action_registered() {
		try {
			DB::start_transaction();

			$user_id = Input::post('user_id');
			$user = Model_Users::select_for_update_primary($user_id);
			if(!$user) {
				Response::redirect('base/timeout');
			}
			$currency = Model_Currency_Rate::select_primary();
			if(!$currency) {
				Response::redirect('base/timeout');
			}
			$deposit              = Model_Deposit_Jnl::forge();
			$deposit->deposit_kbn = Input::post('deposit_kbn');
			$deposit->reason      = Input::post('reason');
			$deposit->amount      = Input::post('amount');
			$deposit->note        = Input::post('note');

			if(Input::post('updated_at') != $user->updated_at) {
				$error_message = '他ユーザに更新されています。もう一度入力してください。';
			} else {
				$validation = $this->validate_registered($deposit);
				if($validation->error()) {
					$error_message = $validation->show_errors();
				} else {
					$error_message = '';
				}
			}

			if($deposit->deposit_kbn == Config::get('constant.deposit_status.kbn.receipt')) {
				$payer_id = Input::post('payers_id');
				$payer = Model_Payers::select_primary($payer_id);
				if(!$payer) {
					$deposit_input_payers = Config::get('constant.deposit_input_payers');
					if(array_key_exists($payer_id, $deposit_input_payers)) {
						$payer = Model_Payers::forge(array('payer_name' => $deposit_input_payers[$payer_id]));
					}
				}
				if(Utility::is_empty($error_message) && !$payer) {
					$error_message = '振込先が存在しません。';
				}
			}

			if (Input::method() == 'POST' && Utility::is_empty($error_message)) {
				if($deposit->deposit_kbn == Config::get('constant.deposit_status.kbn.receipt')) {
					$payer_name = $payer->payer_name;
					$user->deposit += $deposit->amount;
				} else {
					$payer_name = '';
					$user->deposit -= $deposit->amount;
				}
				$user->save();

				$deposit->user_id      = $user_id;
				$deposit->order_id     = 0;
				$deposit->deposit_order_id = 0;
				$deposit->commission   = 0;
				$deposit->payer_name   = $payer_name;
				$deposit->deposit      = $user->deposit;
				$deposit->cny_jpy_rate = $currency->rate;
				$deposit->save();

				$this->template->title = '入出金入力';
				$this->template->content = View::forge('admin/deposit/input');
				$this->template->content->set_safe('infomsg', '入出金登録を行いました。');
				$this->template->content->set_safe('errmsg', '');
				$this->template->content->set_safe('user', $user);
				$this->template->content->set_safe('deposit', $deposit);
			} else {
				$this->template->title = '入出金入力';
				$this->template->content = View::forge('admin/deposit/input');
				$this->template->content->set_safe('infomsg', '');
				$this->template->content->set_safe('errmsg', $error_message);
				$this->template->content->set_safe('user', $user);
				$this->template->content->set_safe('deposit', $deposit);
			}
			DB::commit_transaction();
		}
		catch (\Database_exception $e) {
			DB::rollback_transaction();

			$this->template->title = '入出金入力';
			$this->template->content = View::forge('admin/deposit/input');
			$this->template->content->set_safe('infomsg', '');
			$this->template->content->set_safe('errmsg', 'データの更新に失敗しました。');
			$this->template->content->set_safe('user', $user);
			$this->template->content->set_safe('deposit', $deposit);
		}
	}
}
