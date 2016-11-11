<?php

class Controller_Admin_Su_User extends Controller_Template {

	public $template = 'template/template';

	public function before() {
		parent::before();
		if (!Auth::has_access('admin_user.list')) {
			Response::redirect('base/timeout');
		}
	}

	public function action_index() {
		$user_id = Input::get('id');
		if(!$user_id) {
			$user = Model_Users::forge();
		} else {
			$user = Model_Users::select_primary($user_id);
			if(!$user) {
				Response::redirect('base/timeout');
			}
		}
		$this->template->title = '管理ユーザ設定';
		$this->template->content = View::forge('admin/su/user');
		$this->template->content->set_safe('infomsg', '');
		$this->template->content->set_safe('errmsg', '');
		$this->template->content->set_safe('user', $user);
	}

	private function validate_registered($user) {
		$validation = Validation::forge();
		$validation->add_callable('MyValidation');

		$validation->add('email', 'メールアドレス')
			->add_rule('required')
			->add_rule('valid_email')
			->add_rule('max_length', 35)
			->add_rule('table_exclude_unique', 'users', 'email', $user->email);

		$password_validation = $validation->add('password', 'パスワード')
				->add_rule('max_length', 20);
		if(Utility::is_empty($user->id)) {
			$password_validation->add_rule('required');
		}
		$validation->add('confirm_password', 'パスワード（確認）')
			->add_rule('required_with', 'password')
			->add_rule('match_field', 'password')
			->add_rule('max_length', 20);
		$validation->add('name', '会員様名')
			->add_rule('required')
			->add_rule('min_length', 2)
			->add_rule('max_length', 30);
		$validation->add('skype', 'スカイプID')
			->add_rule('required')
			->add_rule('max_length', 32);
		$validation->add('chatwork', 'チャットワークID')
			->add_rule('required')
			->add_rule('max_length', 50);
		$validation->add('group', '管理者権限')
			->add_rule('required');
		$validation->run();
		return $validation;
	}

	public function action_registered() {
		$user_id = Input::post('user_id');
		if(!$user_id) {
			$user = Model_Users::forge();
		} else {
			$user = Model_Users::select_primary($user_id);
			if(!$user) {
				Response::redirect('base/timeout');
			}
		}
		$validation = $this->validate_registered($user);
		$errors     = $validation->error();

		$user->group       = Input::post('group');
		$user->email       = Input::post('email');
		$user->name        = Input::post('name');
		$user->skype_id    = Input::post('skype');
		$user->chatwork_id = Input::post('chatwork');

		if(Input::method() == 'POST' && empty($errors)) { // POSTかどうか判断しないと画面遷移毎ユーザが作成されてしまう
			$datetime             = Utility::get_datetime_now();
			$user->username       = $user->email;
			$user->password       = Auth::hash_password(Input::post('password'));
			$user->create_time    = $datetime;

			if(!$user_id) {
				$user->last_login = $datetime;
				$user->login_hash = '';
			}
			$user->profile_fields = serialize(array());
			$user->deposit        = 0;
			$user->member_rank    = 0;
			$user->payers_id      = 0;
			$user->order_detail_count = 0;
			$user->save();

			$this->template->title = '管理ユーザ設定';
			$this->template->content = View::forge('admin/su/user');
			$this->template->content->set_safe('infomsg', '管理ユーザ登録を行いました。');
			$this->template->content->set_safe('errmsg', '');
			$this->template->content->set_safe('user', $user);
		} else {
			$this->template->title = '管理ユーザ設定';
			$this->template->content = View::forge('admin/su/user');
			$this->template->content->set_safe('infomsg', '');
			$this->template->content->set_safe('errmsg', $validation->show_errors());
			$this->template->content->set_safe('user', $user);
		}
	}
}
