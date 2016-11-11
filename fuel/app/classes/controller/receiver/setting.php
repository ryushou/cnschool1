<?php

class Controller_Receiver_Setting extends Controller_Template {

	public $template = 'template/template';

	public function before() {
		parent::before();
		if (!Auth::has_access('web.menu')) {
			Response::redirect('base/timeout');
		}
	}

	public function action_index() {
		$this->template->title = '配送先設定';
		$this->template->content = View::forge('receiver/index');
		$this->template->content->set_safe('infomsg', '');
		$this->template->content->set_safe('errmsg', '');
		$this->template->content->set_safe('receiver', Model_Receivers::forge());
	}

	public static function get_receiver_array($receiver) {
		$detail = array();
		$detail['id']       = $receiver->id;
		$detail['fba_flg']  = $receiver->fba_flg;
		$detail['receiver'] = $receiver->receiver;
		$detail['zip1']     = $receiver->zip1;
		$detail['zip2']     = $receiver->zip2;
		$detail['address1'] = $receiver->address1;
		$detail['address2'] = $receiver->address2;
		$detail['phone']    = $receiver->phone;
		$detail['name']     = $receiver->name;
		return $detail;
	}

	public function action_search() {
		$user_id   = Utility::get_user_id();
		$receivers = Model_Receivers::get_receiver_lists($user_id);

		$details = array();
		foreach ($receivers as $receiver) {
			$receiver['fba_flg'] = Utility::get_constant_name('address_kind', $receiver->fba_flg);
			$details[]           = Controller_Receiver_Setting::get_receiver_array($receiver);
		}
		return json_encode(array(
			'detail'  => $details
		));
	}

	public function action_get() {
		$user_id     = Utility::get_user_id();
		$receiver_id = Input::post('receiver_id', '');
		$receiver    = Model_Receivers::select_primary($user_id, $receiver_id);

		return json_encode(array(
			'detail'  => Controller_Receiver_Setting::get_receiver_array($receiver),
		));
	}

	private function validate_registered() {
		$validation = Validation::forge();
		$validation->add('receiver', '配送先名')
			->add_rule('required')
			->add_rule('max_length', 50);
		$validation->add('zip1', '郵便番号1')
			->add_rule('required')
			->add_rule('valid_string', array('numeric'))
			->add_rule('exact_length', 3);
		$validation->add('zip2', '郵便番号2')
			->add_rule('required')
			->add_rule('valid_string', array('numeric'))
			->add_rule('exact_length', 4);
		$validation->add('address1', '住所1')
			->add_rule('required')
			->add_rule('max_length', 100);
		$validation->add('address2', '住所2')
			->add_rule('max_length', 100);
		$validation->add('phone', '電話番号')
			->add_rule('required')
			->add_rule('match_pattern', '/^\d{2,5}\-\d{1,4}\-\d{1,4}$/');
		$validation->add('name', '宛名')
			->add_rule('required')
			->add_rule('max_length', 50);
		$validation->add('fba_flg', '配送先区分')
			->add_rule('required');
		$validation->run();
		return $validation;
	}

	public function action_registered() {
		$user_id     = Utility::get_user_id();
		$receiver_id = Input::post('receiver_id', '');

		if(!Utility::is_empty($receiver_id)) {
			$receiver = Model_Receivers::select_primary($user_id, $receiver_id);
		} else {
			$receiver = Model_Receivers::forge();
			$receiver->user_id = $user_id;
		}
		$receiver->receiver = Input::post('receiver');
		$receiver->zip1     = Input::post('zip1');
		$receiver->zip2     = Input::post('zip2');
		$receiver->address1 = Input::post('address1');
		$receiver->address2 = Input::post('address2');
		$receiver->phone    = Input::post('phone');
		$receiver->name     = Input::post('name');
		$receiver->fba_flg  = Input::post('fba_flg');

		$validation = $this->validate_registered();
		$errors     = $validation->error();

		if (Input::method() == 'POST' && empty($errors)) {
			$receiver->save();

			$this->template->title = '配送先設定';
			$this->template->content = View::forge('receiver/index');
			$this->template->content->set_safe('infomsg', '配送先を登録しました。');
			$this->template->content->set_safe('errmsg', '');
			$this->template->content->set_safe('receiver', Model_Receivers::forge());
		} else {
			$this->template->title = '配送先設定';
			$this->template->content = View::forge('receiver/index');
			$this->template->content->set_safe('infomsg', '');
			$this->template->content->set_safe('errmsg', $validation->show_errors());
			$this->template->content->set_safe('receiver', $receiver);
		}
	}

	public function action_delete() {
		$user_id     = Utility::get_user_id();
		$receiver_id = Input::post('receiver_id');
		Model_Receivers::delete_receiver($user_id, $receiver_id);
		return json_encode(array(
			'error' => '',
			'info' => '配送先を削除しました。'
		));
	}
}
