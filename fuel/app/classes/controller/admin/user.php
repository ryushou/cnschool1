<?php

class Controller_Admin_User extends Controller_Template {

	public $template = 'template/template';

	public function before() {
		parent::before();
		if (!Auth::has_access('user.list')) {
			Response::redirect('base/timeout');
		}
	}

	public function action_index() {
		$user_id = Input::get('id');
		$users   = Model_Users::select_primary($user_id);
		if(!$users) {
			Response::redirect('base/timeout');
		}
		$profile_fields = unserialize($users->profile_fields);
		$zip            = $profile_fields['zip'];
		$zip1           = mb_substr($zip, 0, 3);
		$zip2           = mb_substr($zip, 4, 4);

		$this->template->title = '会員設定';
		$this->template->content = View::forge('admin/user');
		$this->template->content->set_safe('infomsg', '');
		$this->template->content->set_safe('errmsg', '');
		$this->template->content->set_safe('users', $users);
		$this->template->content->set_safe('profile_fields', $profile_fields);
		$this->template->content->set_safe('zip1', $zip1);
		$this->template->content->set_safe('zip2', $zip2);
	}

	private function validate_registered() {
		$validation = Validation::forge();
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
			->add_rule('max_length', 35);
		$validation->add('skype', 'スカイプID')
			->add_rule('required')
			->add_rule('max_length', 32);
		$validation->add('chatwork', 'チャットワークID')
			->add_rule('required')
			->add_rule('max_length', 50);
		$validation->add('member_rank', '会員ランク')
			->add_rule('required');
		$validation->add('order_detail_count', '注文明細数')
			->add_rule('required')
			->add_rule('valid_string', array('numeric'))
			->add_rule('numeric_between', 0, 25);
		$validation->run();
		return $validation;
	}

	public function action_registered() {
		$user_id = Input::post('user_id');
		$users   = Model_Users::select_primary($user_id);
		if(!$users) {
			Response::redirect('base/timeout');
		}
		$users->name                = Input::post('name');
		$users->email               = Input::post('email');
		$users->skype_id            = Input::post('skype');
		$users->chatwork_id         = Input::post('chatwork');
		$users->member_rank         = Input::post('member_rank');
		$users->order_detail_count  = Input::post('order_detail_count');
		$zip1                       = Input::post('zip1');
		$zip2                       = Input::post('zip2');
		$profile_fields             = array();
		$profile_fields['zip']      = $zip1 . '-' . $zip2;
		$profile_fields['address1'] = Input::post('address1');
		$profile_fields['address2'] = Input::post('address2');
		$profile_fields['phone']    = Input::post('phone');
		$users->profile_fields      = serialize($profile_fields);

		$validation = $this->validate_registered();
		$errors     = $validation->error();
		if (Input::method() == 'POST' && empty($errors)) {
			$users->save();

			$this->template->title = '会員設定';
			$this->template->content = View::forge('admin/user');
			$this->template->content->set_safe('infomsg', '会員登録を行いました。');
			$this->template->content->set_safe('errmsg', '');
			$this->template->content->set_safe('users', $users);
			$this->template->content->set_safe('profile_fields', $profile_fields);
			$this->template->content->set_safe('zip1', $zip1);
			$this->template->content->set_safe('zip2', $zip2);
		} else {
			$this->template->title = '会員設定';
			$this->template->content = View::forge('admin/user');
			$this->template->content->set_safe('infomsg', '');
			$this->template->content->set_safe('errmsg', $validation->show_errors());
			$this->template->content->set_safe('users', $users);
			$this->template->content->set_safe('profile_fields', $profile_fields);
			$this->template->content->set_safe('zip1', $zip1);
			$this->template->content->set_safe('zip2', $zip2);
		}
	}
}
