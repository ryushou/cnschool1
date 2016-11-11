<?php

class Controller_Admin_User_List extends Controller_Template {

	public $template = 'template/template';

	public function before() {
		parent::before();
		if (!Auth::has_access('user.list')) {
			Response::redirect('base/timeout');
		}
	}

	public function action_index() {
		$this->template->title = '会員一覧';
		$this->template->content = View::forge('admin/user/list');
		$this->template->content->set_safe('users', Model_Users::forge());
	}

	private function get_user_array($user) {
		$detail = array();
		$profile_fields        = unserialize($user['profile_fields']);
		$detail['id']          = $user['id'];
		$detail['name']        = $user['name'];
		$detail['email']       = $user['email'];
		$detail['deposit']     = $user['deposit'];
		$detail['skype']       = $user['skype_id'];
		$detail['chatwork']    = $user['chatwork_id'];
		$detail['member_rank'] = $user['member_rank'];
		return $detail;
	}

	public function action_search() {
		$search = array();
		$search['user_id']     = Input::get('user_id');
		$search['name']        = Input::get('name');
		$search['member_rank'] = Input::get('member_rank');
		$search['skype']       = Input::get('skype');
		$search['chatwork']    = Input::get('chatwork');
		$search['untransact']  = Input::get('untransact');
		$search['order']       = Input::get('order');
		$search['order_by']    = Input::get('order_by');

		$total_items           = Model_Users::get_users_count($search);
		$pagination            = Pagination::forge('bootstrap3', Utility::get_paging_config($total_items));
		$users                 = Model_Users::get_users_lists($search, $pagination);

		$details = array();
		foreach ($users as $user) {
			$user['member_rank'] = Utility::get_constant_name('member_rank', $user['member_rank']);
			$details[]           = $this->get_user_array($user);
		}
		return json_encode(array(
			'pagination' => $pagination->render(),
			'detail'  => $details
		));
	}
}
