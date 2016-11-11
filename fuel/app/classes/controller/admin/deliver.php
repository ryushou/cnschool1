<?php

class Controller_Admin_Deliver extends Controller_Template {

	public $template = 'template/template';

	public function before() {
		parent::before();
		if (!Auth::has_access('master.update')) {
			Response::redirect('base/timeout');
		}
	}

	public function action_index() {
		$this->template->title = '配送元マスタ';
		$this->template->content = View::forge('admin/deliver');
		$this->template->content->set_safe('infomsg', '');
		$this->template->content->set_safe('errmsg', '');
		$this->template->content->set_safe('deliver', Model_Deliveries::forge());
	}

	public static function get_deliver_array($deliver) {
		$detail = array();
		$detail['id']   = $deliver->id;
		$detail['name'] = $deliver->name;
		$detail['kbn']  = $deliver->kbn;
		$detail['kbn_name']  = Utility::get_constant_name('deliver_kbn', $deliver->kbn);
		return $detail;
	}

	public function action_search() {
		$details  = array();
		foreach (Model_Deliveries::get_deliver_lists_all() as $deliver) {
			$details[] = $this->get_deliver_array($deliver);
		}
		return json_encode(array(
			'detail'  => $details
		));
	}

	public function action_get() {
		$deliver_id = Input::post('deliver_id');
		$deliver    = Model_Deliveries::select_primary($deliver_id);
		return json_encode(array(
			'detail'  => $this->get_deliver_array($deliver),
		));
	}

	private function validate_registered() {
		$validation = Validation::forge();
		$validation->add('deliver_name', '配送元名')
			->add_rule('required')
			->add_rule('max_length', 50);
		$validation->add('deliver_kbn', '配送元区分')
			->add_rule('required');
		$validation->run();
		return $validation;
	}

	public function action_registered() {
		$deliver_id  = Input::post('deliver_id');
		if(!Utility::is_empty($deliver_id)) {
			$deliver = Model_Deliveries::select_primary($deliver_id);
		} else {
			$deliver = Model_Deliveries::forge();
		}
		$deliver->name = Input::post('deliver_name');
		$deliver->kbn = Input::post('deliver_kbn');

		$validation = $this->validate_registered();
		$errors     = $validation->error();
		if (Input::method() == 'POST' && empty($errors)) {
			$deliver->save();

			$this->template->title = '配送元マスタ';
			$this->template->content = View::forge('admin/deliver');
			$this->template->content->set_safe('infomsg', '配送元を登録しました。');
			$this->template->content->set_safe('errmsg', '');
			$this->template->content->set_safe('deliver', Model_Deliveries::forge());
		} else {
			$this->template->title = '配送元マスタ';
			$this->template->content = View::forge('admin/deliver');
			$this->template->content->set_safe('infomsg', '');
			$this->template->content->set_safe('errmsg', $validation->show_errors());
			$this->template->content->set_safe('deliver', $deliver);
		}
	}

	public function action_delete() {
		$deliver_id = Input::post('deliver_id', '');
		Model_Deliveries::delete_deliver($deliver_id);
		return json_encode(array(
			'error' => '',
			'info' => '配送元を削除しました。'
		));
	}
}
