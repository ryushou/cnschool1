<?php

class Controller_Admin_Payer extends Controller_Template {

	public $template = 'template/template';

	public function before() {
		parent::before();
		if (!Auth::has_access('master.update')) {
			Response::redirect('base/timeout');
		}
	}

	public function action_index() {
		$this->template->title = '振込先マスタ';
		$this->template->content = View::forge('admin/payer');
		$this->template->content->set_safe('infomsg', '');
		$this->template->content->set_safe('errmsg', '');
		$this->template->content->set_safe('payer', Model_Payers::forge());
	}

	public static function get_payer_array($payer) {
		$detail = array();
		$detail['id']         = $payer->id;
		$detail['payer_name'] = $payer->payer_name;
		$detail['payer_url']  = $payer->payer_url;
		$detail['payer_commission'] = $payer->payer_commission;
		return $detail;
	}

	public function action_search() {
		$details = array();
		foreach (Model_Payers::get_payer_lists() as $payer) {
			$details[] = $this->get_payer_array($payer);
		}
		return json_encode(array(
			'detail' => $details
		));
	}

	public function action_get() {
		$payer_id = Input::post('payer_id');
		$payer    = Model_Payers::select_primary($payer_id);
		return json_encode(array(
			'detail'  => $this->get_payer_array($payer),
		));
	}

	private function validate_registered() {
		$validation = Validation::forge();
		$validation->add('payer_name', '振込先名')
			->add_rule('required')
			->add_rule('max_length', 30);
		$validation->add('payer_url', '振込先リンク')
			->add_rule('valid_url')
			->add_rule('required')
			->add_rule('max_length', 100);
		$validation->add('payer_commission', '手数料')
			->add_rule('required')
			->add_rule('match_pattern', '/^\d{1,3}(\.\d)?$/');
		$validation->run();
		return $validation;
	}

	public function action_registered() {
		$payer_id  = Input::post('payer_id', '');
		if(!Utility::is_empty($payer_id)) {
			$payer = Model_Payers::select_primary($payer_id);
		} else {
			$payer = Model_Payers::forge();
		}
		$payer->payer_name = Input::post('payer_name', '');
		$payer->payer_url  = Input::post('payer_url', '');
		$payer->payer_commission = Input::post('payer_commission', '');

		$validation = $this->validate_registered();
		$errors     = $validation->error();
		if (Input::method() == 'POST' && empty($errors)) {
			$payer->save();

			$this->template->title = '振込先マスタ';
			$this->template->content = View::forge('admin/payer');
			$this->template->content->set_safe('infomsg', '振込先を登録しました。');
			$this->template->content->set_safe('errmsg', '');
			$this->template->content->set_safe('payer', Model_Payers::forge());
		} else {
			$this->template->title = '振込先マスタ';
			$this->template->content = View::forge('admin/payer');
			$this->template->content->set_safe('infomsg', '');
			$this->template->content->set_safe('errmsg', $validation->show_errors());
			$this->template->content->set_safe('payer', $payer);
		}
	}

	public function action_delete() {
		$payer_id = Input::post('payer_id', '');
		Model_Payers::delete_payer($payer_id);
		return json_encode(array(
			'error' => '',
			'info' => '振込先を削除しました。'
		));
	}
}
