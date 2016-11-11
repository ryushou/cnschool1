<?php

class Controller_Admin_Su_User_List extends Controller_Template {

	public $template = 'template/template';

	public function before() {
		parent::before();
		if (!Auth::has_access('admin_user.list')) {
			Response::redirect('base/timeout');
		}
	}

	public function action_index() {
		$this->template->title = '管理ユーザ一覧';
		$this->template->content = View::forge('admin/su/user/list');
	}

	private function get_user_array($user) {
		$detail = array();
		$profile_fields     = unserialize($user['profile_fields']);
		$detail['id']       = $user['id'];
		$detail['group']    = $user['group'];
		$detail['name']     = $user['name'];
		$detail['email']    = $user['email'];
		$detail['skype']    = $user['skype_id'];
		$detail['chatwork'] = $user['chatwork_id'];
		return $detail;
	}

	public function action_search() {
		$group = Config::get('constant.admin_group.kbn');
		$users = Model_Users::get_users_by_group($group);

		$details = array();
		foreach ($users as $user) {
			$user['group'] = Utility::get_constant_name('admin_group', $user['group']);
			$details[]     = $this->get_user_array($user);
		}
		return json_encode(array(
			'detail'  => $details
		));
	}

	public function action_delete() {
		$user_id = Input::post('user_id');
		Model_Users::delete_user($user_id);
		return json_encode(array(
			'error' => '',
			'info' => '管理者を削除しました。'
		));
	}
}
