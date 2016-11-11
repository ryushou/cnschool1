<?php

class Controller_Auth extends Controller_Template {

	public $template = 'template/template';

	private function validate_login() {
		$validation = Validation::forge();
		$validation->add('email', 'メールアドレス')
			->add_rule('required')
			->add_rule('valid_email')
			->add_rule('max_length', 35);
		$validation->add('password', 'パスワード')
			->add_rule('required')
			->add_rule('max_length', 20);
		$validation->run();
		return $validation;
	}

	public function action_logins() {
		$this->template->title = 'ログイン';
		$this->template->content = View::forge('auth/logins');
		$this->template->content->set_safe('errmsg', '');
		$this->template->content->set_safe('email', '');
	}

	public function action_login() {
		if(Input::method() == 'POST') {
			$email    = Input::post('email');
			$password = Input::post('password');

			$validation = $this->validate_login();
			$errors = $validation->error();

			if (empty($errors)) {
				if (Auth::login($email, $password)) {
					if (Input::post('remember_me', false)) {
						Auth::remember_me();
					} else {
						Auth::dont_remember_me();
					}
					if(Auth::has_access('order.list')) {
						Response::redirect('admin/order/list');
					} else if(Auth::has_access('user.list')) {
						Response::redirect('admin/user/list');
					} else {
						Response::redirect('order/list');
					}
				} else {
					$result_validate = "ログインに失敗しました。メールアドレスまたはパスワードが間違っています。";
					$this->template->title = 'ログイン';
					$this->template->content = View::forge('auth/logins');
					$this->template->content->set_safe('errmsg', $result_validate);
					$this->template->content->set_safe('email', $email);
				}
			} else {
				$result_validate = $validation->show_errors();
				$this->template->title = 'ログイン';
				$this->template->content = View::forge('auth/logins');
				$this->template->content->set_safe('errmsg', $result_validate);
				$this->template->content->set_safe('email', $email);
			}
		} else {
			$this->template->title = 'ログイン';
			$this->template->content = View::forge('auth/login');
			$this->template->content->set_safe('errmsg', "");
		}
	}

	public function action_logout() {
		Auth::logout();
		Auth::dont_remember_me();
		Response::redirect('auth/login');
	}

	public function action_create() {
		$profile_fields = array(
			'address1' => '',
			'address2' => '',
			'phone' => ''
		);
		$user = Model_Users::forge();
		$this->template->title = 'ユーザー作成';
		$this->template->content = View::forge('auth/create');
		$this->template->content->set_safe('errmsg', "");
		$this->template->content->set_safe('user', $user);
		$this->template->content->set_safe('zip1', "");
		$this->template->content->set_safe('zip2', "");
		$this->template->content->set_safe('profile_fields', $profile_fields);
	}

	private function validate_create() {
		$validation = Validation::forge();
		$validation->add('name', '会員様名')
			->add_rule('required')
			->add_rule('min_length', 2)
			->add_rule('max_length', 30);
		$validation->add('password', 'パスワード')
			->add_rule('required')
			->add_rule('max_length', 20);
		$validation->add('password_re', 'パスワード再入力')
			->add_rule('required_with', 'password')
			->add_rule('match_field', 'password')
			->add_rule('max_length', 20);
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
			->add_rule('max_length', 35);
		$validation->add('skype_id', 'スカイプID')
			->add_rule('required')
			->add_rule('max_length', 32);
		$validation->add('chatwork_id', 'チャットワークID')
			->add_rule('required')
			->add_rule('max_length', 50);
		$validation->run();
		return $validation;
	}

	public function action_created() {
		$user           = Model_Users::forge();
		$user->name     = Input::post('name');
		$user->password = Input::post('password');
		$user->email    = Input::post('email');
		$user->skype_id = Input::post('skype_id');
		$user->chatwork_id = Input::post('chatwork_id');

		$zip1                       = Input::post('zip1');
		$zip2                       = Input::post('zip2');
		$profile_fields             = array();
		$profile_fields['zip']      = $zip1 . '-' . $zip2;
		$profile_fields['address1'] = Input::post('address1');
		$profile_fields['address2'] = Input::post('address2');
		$profile_fields['phone']    = Input::post('phone');

		$validation                 = $this->validate_create();
		$errors                     = $validation->error();

		if (Input::method() == 'POST' && empty($errors)) {
			$entry = Model_Users::select_by_email($user->email);
			if($entry && $entry->group != Config::get('constant.member_group.kbn.temporary')) {
				$this->template->title = 'ユーザー作成';
				$this->template->content = View::forge('auth/create');
				$this->template->content->set_safe('errmsg', 'ユーザはすでに登録されています。');
				$this->template->content->set_safe('profile_fields', $profile_fields);
				$this->template->content->set_safe('zip1', $zip1);
				$this->template->content->set_safe('zip2', $zip2);
				$this->template->content->set_safe('user', $user);
			} else {
				$now_date = Utility::get_datetime_now();
				$this->create_send_mail($user->email, $now_date);

				if(!$entry) {
					// 仮登録処理
					$group = Config::get('constant.member_group.kbn.temporary');
					$user_id = Auth::create_user($user->email, $user->password, $user->email, $group);
					$entry = Model_Users::select_primary($user_id);
				} else {
					// 再度仮登録
					$entry->password    = Auth::hash_password($user->password);
				}
				$entry->create_time    = $now_date;
				$entry->profile_fields = serialize($profile_fields);
				$entry->name           = $user->name;
				$entry->skype_id       = $user->skype_id;
				$entry->chatwork_id    = $user->chatwork_id;
				$entry->member_rank    = Config::get('constant.member_rank.kbn.normal');
				$entry->save();

				$result_validate = '仮登録を行いました。登録したメールアドレスに送られた内容をご確認ください。';
				$this->template->title = 'ユーザー仮登録完了';
				$this->template->content = View::forge('auth/created');
				$this->template->content->set_safe('errmsg', $result_validate);
				$this->template->content->set_safe('email', $user->email);
			}
		} else {
			$this->template->title = 'ユーザー作成';
			$this->template->content = View::forge('auth/create');
			$this->template->content->set_safe('errmsg', $validation->show_errors());
			$this->template->content->set_safe('profile_fields', $profile_fields);
			$this->template->content->set_safe('zip1', $zip1);
			$this->template->content->set_safe('zip2', $zip2);
			$this->template->content->set_safe('user', $user);
		}
	}

	private function create_send_mail($email, $date) {
		$url  = 'http://' . $_SERVER["SERVER_NAME"] . '/auth/register?id=' . Crypt::encode($email);

		$body = Utility::get_mail_template('template_register.txt');
		$body = Utility::mb_str_replace('%url%', $url, $body);
		$body = Utility::mb_str_replace('%date%', $date, $body);

		$entry = Model_Mail_Queue::forge();
		$entry->to      = $email;
		$entry->subject = '会員仮登録のお知らせ';
		$entry->body    = $body;
		Model_Mail_Queue::insert_entry($entry);
	}

	private function instruct_send_mail($email, $password) {
		$body = Utility::get_mail_template('template_instruct.txt');
		$body = Utility::mb_str_replace('%password%', $password, $body);
		$body = Utility::mb_str_replace('%date%', Utility::get_datetime_now(), $body);

		$entry = Model_Mail_Queue::forge();
		$entry->to      = $email;
		$entry->subject = '会員仮パスワード発行のお知らせ';
		$entry->body    = $body;
		Model_Mail_Queue::insert_entry($entry);
    }

    private function validate_instruct() {
		$validation = Validation::forge();
		$validation->add('email', 'メールアドレス')
			->add_rule('required')
			->add_rule('valid_email')
			->add_rule('max_length', 35);
		$validation->run();
		return $validation;
    }

    public function action_instruct() {
		$this->template->title = '仮パスワード発行';
		$this->template->content = View::forge('auth/instruct');
		$this->template->content->set_safe('errmsg', '');
		$this->template->content->set_safe('email', '');
    }

    public function action_instructed() {
		$validation = $this->validate_instruct();
		$errors     = $validation->error();
		$email      = Input::post('email', null);

		if (empty($errors)) {
			$entry = Model_Users::select_by_email($email);
			if($entry){
				switch ($entry->group){
					case Config::get('constant.member_group.kbn.temporary'):
						$result_validate = '仮登録中のため仮パスワードを発行できません。';
						$this->template->title = '仮パスワード発行';
						$this->template->content = View::forge('auth/instruct');
						$this->template->content->set_safe('errmsg', $result_validate);
						$this->template->content->set_safe('email', $email);
						break;
					default:
						// 本登録
						$new_password = Auth::reset_password($email);
						$this->instruct_send_mail($email, $new_password);

						$result_validate = '仮パスワードを発行しました。ログインしてパスワードを更新してください。';
						$this->template->title = '仮パスワード発行完了';
						$this->template->content = View::forge('auth/instructed');
						$this->template->content->set_safe('infomsg', $result_validate);
						$this->template->content->set_safe('email', $email);
						break;
				}
			} else {
				$result_validate = 'メールアドレスは登録されていません。';
				$this->template->title = '仮パスワード発行';
				$this->template->content = View::forge('auth/instruct');
				$this->template->content->set_safe('errmsg', $result_validate);
				$this->template->content->set_safe('email', $email);
			}
		} else {
			$result_validate = $validation->show_errors();
			$this->template->title = '仮パスワード発行';
			$this->template->content = View::forge('auth/instruct');
			$this->template->content->set_safe('errmsg', $result_validate);
			$this->template->content->set_safe('email', $email);
		}
	}

	public function action_register() {
		$email = Crypt::decode(Input::get('id'));
		$entry = Model_Users::select_by_email($email);

		if($entry) {
			$old_date = date("Y-m-d H:i:s", strtotime('-1 day')); // 24時間に発行されたURLか？
			if($entry->create_time >= $old_date) {
				if($entry->group == Config::get('constant.member_group.kbn.temporary')) {
					$entry->group = Config::get('constant.member_group.kbn.web');
					$entry->create_time = Utility::get_datetime_now();
					$entry->save();

					if(Auth::force_login($entry->id)) {
						Response::redirect('account/modify');
					} else {
						$result_validate = 'ユーザ登録が完了しました。トップページからログインしてください。';
						$this->template->title = 'ユーザ登録';
						$this->template->content = View::forge('auth/register');
						$this->template->content->set_safe('infomsg', $result_validate);
						$this->template->content->set_safe('errmsg', "");
					}
				} else {
					$result_validate = 'すでに本登録されています。トップページからログインしてください。';
					$this->template->title = 'ユーザ登録';
					$this->template->content = View::forge('auth/register');
					$this->template->content->set_safe('infomsg', "");
					$this->template->content->set_safe('errmsg', $result_validate);
				}
			} else {
				$result_validate = 'ユーザ登録ができませんでした。仮登録から24時間以上経過しています。もう一度、仮登録を行ってください。';
				$this->template->title = 'ユーザ登録';
				$this->template->content = View::forge('auth/register');
				$this->template->content->set_safe('infomsg', "");
				$this->template->content->set_safe('errmsg', $result_validate);
			}
		} else {
			$result_validate = 'ユーザ登録ができませんでした。仮登録メールにあるURLをご確認ください。';
			$this->template->title = 'ユーザ登録';
			$this->template->content = View::forge('auth/register');
			$this->template->content->set_safe('infomsg', "");
			$this->template->content->set_safe('errmsg', $result_validate);
		}
	}

	public function action_contact() {
		$email = Auth::get_email();
		if($email) {
			$user_id = Utility::get_user_id();
			$user    = Model_Users::select_primary($user_id);
			$name    = $user->name;
		} else {
			$name    = '';
		}
		$this->template->title   = 'お問い合わせ';
		$this->template->content = View::forge('auth/contact');
		$this->template->content->set_safe('errmsg', '');
		$this->template->content->set_safe('name', $name);
		$this->template->content->set_safe('email', $email);
		$this->template->content->set_safe('screen', '');
		$this->template->content->set_safe('content', '');
	}

	private function validate_contact() {
		$validation = Validation::forge();
		$validation->add('name', 'お名前')
			->add_rule('required')
			->add_rule('min_length', 3)
			->add_rule('max_length', 30);
		$validation->add('email', 'メールアドレス')
			->add_rule('required')
			->add_rule('valid_email')
			->add_rule('max_length', 35);
		$validation->add('screen', '画面名')
			->add_rule('required');
		$validation->add('content', 'お問い合わせ内容')
			->add_rule('required')
			->add_rule('max_length', 2000);
		$validation->run();
		return $validation;
	}

	private function validate_contact_login() {
		$validation = Validation::forge();
		$validation->add('screen', '画面名')
			->add_rule('required');
		$validation->add('content', 'お問い合わせ内容')
			->add_rule('required')
			->add_rule('max_length', 2000);
		$validation->run();
		return $validation;
	}

	public function action_contact_send() {
		$screen   = Input::post('screen', '');
		$content  = Input::post('content', '');

		if(Auth::check()) {
			$user_id    = Utility::get_user_id();
			$user       = Model_Users::select_primary($user_id);
			$name       = $user->name;
			$email      = Auth::get_email();
			$mailid     = 'AM' . $user->member_rank . '-' . $user_id;
			$validation = $this->validate_contact_login();
		} else {
			$name       = Input::post('name', '');
			$email      = Input::post('email', '');
			$mailid     = '';
			$validation = $this->validate_contact();
		}
		$errors = $validation->error();

		if (Input::method() == 'POST' && empty($errors)) {
			$this->contact_send_mail($name, $email, $screen, $content, $mailid);
			$this->contact_remail($name, $email, $content);

			$this->template->title = 'お問い合わせ';
			$this->template->content = View::forge('auth/contact_send');
			$this->template->content->set_safe('infomsg', 'お問い合わせしました。');
		} else {
			$this->template->title   = 'お問い合わせ';
			$this->template->content = View::forge('auth/contact');
			$this->template->content->set_safe('errmsg', $validation->show_errors());
			$this->template->content->set_safe('name', $name);
			$this->template->content->set_safe('email', $email);
			$this->template->content->set_safe('screen', $screen);
			$this->template->content->set_safe('content', $content);
		}
	}

	private function contact_send_mail($name, $email, $screen, $content, $mailid) {
		$user_agent = Input::user_agent('');
		$ip         = Input::ip();
		$browser    = Agent::browser();
		$platform   = Agent::platform();

		$body = Utility::get_mail_template('template_contact.txt');
		$body = Utility::mb_str_replace('%name%', $name, $body);
		$body = Utility::mb_str_replace('%email%', $email, $body);
		$body = Utility::mb_str_replace('%mailid%', $mailid, $body);
		$body = Utility::mb_str_replace('%user_agent%', $user_agent, $body);
		$body = Utility::mb_str_replace('%ip%', $ip, $body);
		$body = Utility::mb_str_replace('%browser%', $browser, $body);
		$body = Utility::mb_str_replace('%platform%', $platform, $body);
		$body = Utility::mb_str_replace('%content%', $content, $body);
		$body = Utility::mb_str_replace('%date%', Utility::get_datetime_now(), $body);

		$entry = Model_Mail_Queue::forge();
		$entry->to            = Config::get('constant.send_mail.reply_to');
		$entry->to_name       = Config::get('constant.send_mail.reply_to_name');
		$entry->reply_to      = $email;
		$entry->reply_to_name = $name . '様';
		$entry->subject       = 'お客様お問い合わせ／' . $screen . '／' . $name . '様';
		$entry->body          = $body;
		Model_Mail_Queue::insert_entry($entry);
	}

	private function contact_remail($name, $email, $content) {
		$body = Utility::get_mail_template('template_contact_remail.txt');
		$body = Utility::mb_str_replace('%name%', $name, $body);
		$body = Utility::mb_str_replace('%content%', $content, $body);
		$body = Utility::mb_str_replace('%date%', Utility::get_datetime_now(), $body);

		$entry = Model_Mail_Queue::forge();
		$entry->to      = $email;
		$entry->to_name = $name . '様';
		$entry->subject = 'お客様お問い合わせ／確認メール';
		$entry->body    = $body;
		Model_Mail_Queue::insert_entry($entry);
	}

	public function action_terms() {
		$this->template->title = '利用規約';
		$this->template->content = View::forge('auth/terms');
	}

	public function action_privacy() {
		$this->template->title = 'プライバシーポリシー';
		$this->template->content = View::forge('auth/privacy');
	}

	public function action_faq() {
		$this->template->title = 'よくある質問';
		$this->template->content = View::forge('auth/faq');
	}

	public function action_scta() {
		$this->template->title = '特定商取引法';
		$this->template->content = View::forge('auth/scta');
	}

	public function action_manual() {
		$this->template->title = 'ご利用マニュアル';
		$this->template->content = View::forge('auth/manual');
	}
}
