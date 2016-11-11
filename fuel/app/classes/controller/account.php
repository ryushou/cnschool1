<?php

class Controller_Account extends Controller_Template {

	public $template = 'template/template';

	public function action_update() {
		$this->template->title = 'ユーザー更新';
		$this->template->content = View::forge('account/update');
		$this->template->content->set_safe('errmsg', "");
	}

	private function validate_update() {
		$validation = Validation::forge();
		$validation->add('old_password', '旧パスワード')
			->add_rule('required')
			->add_rule('max_length', 20);
		$validation->add('password', '新パスワード')
			->add_rule('required')
			->add_rule('max_length', 20);
		$validation->add('confirm_password', 'パスワード（確認）')
			->add_rule('required_with', 'password')
			->add_rule('match_field', 'password')
			->add_rule('max_length', 20);
		$validation->run();
		return $validation;
	}

	public function action_updated() {
		$old_password     = Input::post('old_password', null);
		$password         = Input::post('password', null);
		$confirm_password = Input::post('confirm_password', null);

		$validation       = $this->validate_update();
		$errors           = $validation->error();

		if (Input::method() == 'POST' && empty($errors)) {
			if(Auth::change_password($old_password, $password, Auth::get_email())) {
				$this->template->title = 'ユーザー更新完了';
				$this->template->content = View::forge('account/updated');
				$this->template->content->set_safe('infomsg', 'パスワードの更新が完了しました。');
			} else {
				$this->template->title = 'ユーザー更新';
				$this->template->content = View::forge('account/update');
				$this->template->content->set_safe('errmsg', '旧パスワードが間違っています。');
			}
		} else {
			$this->template->title = 'ユーザー更新';
			$this->template->content = View::forge('account/update');
			$this->template->content->set_safe('errmsg', $validation->show_errors());
		}
	}

	public function action_remove() {
		if (!Auth::has_access('web.menu')) {
			Response::redirect('base/timeout');
		}
		$this->template->title = '退会処理';
		$this->template->content = View::forge('account/remove');
		$this->template->content->set_safe('errmsg', '');
	}

	private function validate_remove() {
		$validation = Validation::forge();
		$validation->add('password', 'パスワード')
			->add_rule('required')
			->add_rule('max_length', 20);
		$validation->run();
		return $validation;
	}

	public function action_removed() {
		if(!Auth::has_access('account.remove')) {
			Response::redirect('base/timeout');
		}
		$validation = $this->validate_remove();
		$errors   = $validation->error();

		if (Input::method() == 'POST' && empty($errors)) {
			$entry = Model_Users::select_primary(Utility::get_user_id());
			if($entry->deposit >= 0) {
				if($entry->password == Auth::hash_password(Input::post('password'))) {
					$entry->group = Config::get('constant.member_group.kbn.ban');
					$entry->save();

					Auth::logout();

					$body = Utility::get_mail_template('template_account_remove.txt');
					$body = Utility::mb_str_replace('%system_id%', Config::get('constant.send_mail.subject.prefix'), $body);
					$body = Utility::mb_str_replace('%user_id%', $entry->id, $body);
					$body = Utility::mb_str_replace('%name%', $entry->name, $body);
					$body = Utility::mb_str_replace('%email%', $entry->email, $body);
					$body = Utility::mb_str_replace('%date%', Utility::get_datetime_now(), $body);

					$admin_users = Model_Users::find('all', array(
						'where' => array(
							array('group', 'in', array(
									Config::get('constant.member_group.kbn.admin'),
									Config::get('constant.member_group.kbn.accountant'),
								)
							),
						)
					));

					foreach ($admin_users as $admin_user) {
						$mail_queue = Model_Mail_Queue::forge();
						$mail_queue->to      = $admin_user->email;
						$mail_queue->to_name = $admin_user->name . '様';
						$mail_queue->subject = '会員様が退会されました。';
						$mail_queue->body    = $body;
						Model_Mail_Queue::insert_entry($mail_queue);
					}

					$result_validate = '退会処理が完了しました。またのご利用お待ち申しあげます。';
					$this->template->title = '退会完了';
					$this->template->content = View::forge('account/removed');
					$this->template->content->set_safe('infomsg', $result_validate);
				} else {
					$result_validate = '入力したパスワードは現在登録されているパスワードと違います';
					$this->template->title = '退会処理';
					$this->template->content = View::forge('account/remove');
					$this->template->content->set_safe('errmsg', $result_validate);
				}
			} else {
				$result_validate = '残高がマイナスなので、退会できません。';
				$this->template->title = '退会処理';
				$this->template->content = View::forge('account/remove');
				$this->template->content->set_safe('errmsg', $result_validate);
			}
		} else {
			$result_validate = $validation->show_errors();
			$this->template->title = '退会処理';
			$this->template->content = View::forge('account/remove');
			$this->template->content->set_safe('errmsg', $result_validate);
		}
	}

	public function action_modify() {
		if (!Auth::has_access('web.menu')) {
			Response::redirect('base/timeout');
		}
		$user = Model_Users::select_primary(Utility::get_user_id());
		$profile_fields = Auth::get_profile_fields();

		$zip  = $profile_fields['zip'];
		$zip1 = mb_substr($zip, 0, 3);
		$zip2 = mb_substr($zip, 4, 4);

		$this->template->title = 'アカウント変更';
		$this->template->content = View::forge('account/modify');
		$this->template->content->set_safe('infomsg', "");
		$this->template->content->set_safe('errmsg', "");
		$this->template->content->set_safe('profile_fields', $profile_fields);
		$this->template->content->set_safe('zip1', $zip1);
		$this->template->content->set_safe('zip2', $zip2);
		$this->template->content->set_safe('user', $user);
	}

	private function validate_modify($user) {
		$validation = Validation::forge();
		$validation->add_callable('MyValidation');

		$validation->add('name', '会員様名')
			->add_rule('required')
			->add_rule('min_length', 2)
			->add_rule('max_length', 30);
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
		$validation->add('email', 'メールアドレス')
			->add_rule('required')
			->add_rule('valid_email')
			->add_rule('max_length', 35)
			->add_rule('table_exclude_unique', 'users', 'email', $user->email);
		$validation->add('skype_id', 'スカイプID')
			->add_rule('required')
			->add_rule('max_length', 32);
		$validation->add('chatwork_id', 'チャットワークID')
			->add_rule('required')
			->add_rule('max_length', 50);
		$validation->add('payers_id', '振込先')
			->add_rule('required');
		$validation->run();
		return $validation;
	}

	public function action_modified() {
		$user = Model_Users::select_primary(Utility::get_user_id());

		$validation = $this->validate_modify($user);
		$errors     = $validation->error();

		$profile_fields             = array();
		$zip1                       = Input::post('zip1');
		$zip2                       = Input::post('zip2');
		$profile_fields['zip']      = $zip1 . '-' . $zip2;
		$profile_fields['address1'] = Input::post('address1');
		$profile_fields['address2'] = Input::post('address2');
		$profile_fields['phone']    = Input::post('phone');

		$user->profile_fields = $profile_fields;
		$user->email          = Input::post('email');
		$user->name           = Input::post('name');
		$user->skype_id       = Input::post('skype_id');
		$user->chatwork_id    = Input::post('chatwork_id');
		$user->payers_id      = Input::post('payers_id');

		if (empty($errors)) {
			$user->username       = $user->email;
			$user->profile_fields = serialize($user->profile_fields);
			$user->save();

			$this->template->title = 'アカウント変更完了';
			$this->template->content = View::forge('account/modify');
			$this->template->content->set_safe('infomsg', 'アカウント情報を変更しました。');
			$this->template->content->set_safe('errmsg', '');
			$this->template->content->set_safe('profile_fields', $profile_fields);
			$this->template->content->set_safe('zip1', $zip1);
			$this->template->content->set_safe('zip2', $zip2);
			$this->template->content->set_safe('user', $user);
		} else {
			$this->template->title = 'アカウント変更';
			$this->template->content = View::forge('account/modify');
			$this->template->content->set_safe('infomsg', '');
			$this->template->content->set_safe('errmsg', $validation->show_errors());
			$this->template->content->set_safe('profile_fields', $profile_fields);
			$this->template->content->set_safe('zip1', $zip1);
			$this->template->content->set_safe('zip2', $zip2);
			$this->template->content->set_safe('user', $user);
		}
	}
}
