<?php

class Controller_Admin_Site extends Controller_Template {

	public $template = 'template/template';

	public function before() {
		parent::before();
		if (!Auth::has_access('master.update')) {
			Response::redirect('base/timeout');
		}
	}

	public function action_index() {
		$this->template->title = 'サイト設定';
		$this->template->content = View::forge('admin/site');
		$this->template->content->set_safe('infomsg', '');
		$this->template->content->set_safe('errmsg', '');
		$this->template->content->set_safe('currency', Model_Currency_Rate::select_primary());
	}

	private function validate_registered() {
		$validation = Validation::forge();
		$validation->add('rate', '為替レート')
			->add_rule('required')
			->add_rule('match_pattern', '/^\d{1,5}(\.\d{1,7})?$/');
		$validation->run();
		return $validation;
	}

	public function action_registered() {
		$currency = Model_Currency_Rate::select_primary();
		$currency->rate = Input::post('rate');

		$validation     = $this->validate_registered();
		$errors         = $validation->error();
		if (Input::method() == 'POST' && empty($errors)) {
			$currency->save();

			$this->template->title = 'サイト設定';
			$this->template->content = View::forge('admin/site');
			$this->template->content->set_safe('infomsg', '為替レートを登録しました。');
			$this->template->content->set_safe('errmsg', '');
			$this->template->content->set_safe('currency', $currency);
		} else {
			$this->template->title = 'サイト設定';
			$this->template->content = View::forge('admin/site');
			$this->template->content->set_safe('infomsg', '');
			$this->template->content->set_safe('errmsg', $validation->show_errors());
			$this->template->content->set_safe('currency', $currency);
		}
	}
}
