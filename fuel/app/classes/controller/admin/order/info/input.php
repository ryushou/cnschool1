<?php

class Controller_Admin_Order_Info_Input extends Controller_Template {

	public $template = 'template/template';

	public function before() {
		parent::before();
		if (!Auth::has_access('order.oem')) {
			Response::redirect('base/timeout');
		}
    }

	public function action_index() {
		$order_id = Input::get('oid', '');
		$order = Model_Order_Jnl::select_primary_admin($order_id);
		if(empty($order)) {
			Response::redirect('base/timeout');
		}

		$order_info_id = Input::get('iid', '');
		if(!Utility::is_empty($order_info_id)) {
			$order_info = Model_Order_Info::select_primary_admin($order_info_id);
			if(empty($order_info)) {
				Response::redirect('base/timeout');
			}
		} else {
			$order_info = Model_Order_Info::forge();
		}

		$order_attach_id = Input::get('aid', '');
		if(!Utility::is_empty($order_attach_id)) {
			$order_attach = Model_Order_Attach::select_primary($order_attach_id);
			if(empty($order_attach)) {
				Response::redirect('base/timeout');
			}
		} else {
			$order_attach = Model_Order_Attach::forge();
		}

		$order_info_array = array();
		$order_info_status_max = Config::get('constant.order_info_status.kbn.MAX');
		for($i = 0; $i < $order_info_status_max; $i++) {
			if($i == $order_info->info_kbn) {
				$tmp_order_info = $order_info;
			} else {
				$tmp_order_info = Model_Order_Info::forge();
			}
			$order_info_array[] = $tmp_order_info;
		}
		$this->template->title = '注文情報入力';
		$this->template->content = View::forge('admin/order/info/input');
		$this->template->content->set_safe('user_id', $order->user_id);
		$this->template->content->set_safe('order_id', $order->id);
		$this->template->content->set_safe('order_info_id', $order_info->id);
		$this->template->content->set_safe('order_info_array', $order_info_array);
		$this->template->content->set_safe('order_attach', $order_attach);
	}

	public static function validation_order_info($validation, $label, $target_at_name, $content_name, $is_url = false, $note_name = '') {
		$content = Input::post($content_name);
		if(!Utility::is_empty($target_at_name)) {
			$target_at = Input::post($target_at_name);
		} else {
			$target_at = '';
		}
		if(!Utility::is_empty($content) || !Utility::is_empty($target_at)) {
			$validation = $validation->add($content_name, $label)
				->add_rule('required')
				->add_rule('max_length', 500);
			if(!Utility::is_empty($note_name)) {
				$validation->add($note_name, $label . '備考')
					->add_rule('max_length', 100);
			}
			if($is_url) {
				$validation->add_rule('valid_url');
			}

			if(!Utility::is_empty($target_at_name)) {
				$validation->add($target_at_name, $label . '日付')
					->add_rule('required')
					->add_rule('match_pattern', '/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/');
			}
		}
	}

	private function validate_update() {
		$validation = Validation::forge();
		$this->validation_order_info($validation, 'ご依頼状況', 'request_state_date', 'request_state_note');
		$this->validation_order_info($validation, 'ご依頼状況管理者メモ', 'request_state_date_admin', 'request_state_note_admin');
		$this->validation_order_info($validation, '参考URL', '', 'reference_url', true, 'reference_url_note');
		$this->validation_order_info($validation, '参考URL管理者メモ', 'reference_url_date_admin', 'reference_url_note_admin');
		$this->validation_order_info($validation, '制約条件', 'budget_date', 'budget_note');
		$this->validation_order_info($validation, '制約条件管理者メモ', 'budget_date_admin', 'budget_note_admin');
		$this->validation_order_info($validation, 'その他サービス（検品含む）のご希望', 'other_date', 'other_note');
		$this->validation_order_info($validation, 'その他サービス（検品含む）のご希望 管理者メモ', 'other_date_admin', 'other_note_admin');

		$attach_id   = Input::post('attach_id');
		$attach_note = Input::post('attach_note');
		if(!Utility::is_empty($attach_id) || !Utility::is_empty($attach_note)) {
			$validation->add('attach_id', 'アップロードファイル')
					->add_rule('required')
					->add_rule('valid_string', array('numeric'));
			$validation->add('attach_note', 'ファイル備考')
					->add_rule('required')
					->add_rule('max_length', 150);
		}
		$validation->run();
		return $validation;
	}

	public function action_update() {
		$validation = $this->validate_update();
		$errors = $validation->error();
		if (!empty($errors)) {
			return json_encode(array(
				'error' => $validation->show_errors(),
				'info' => ''
			));
		}

		$order_id = Input::post('order_id');
		$order = Model_Order_Jnl::select_primary_admin($order_id);
		if(empty($order)) {
			Response::redirect('base/timeout');
		}

		$order_info_id = Input::post('order_info_id');
		if(!Utility::is_empty($order_info_id)) {
			$order_info = Model_Order_Info::select_primary_admin($order_info_id);
			if(empty($order_info)) {
				Response::redirect('base/timeout');
			}
		} else {
			$order_info = null;
		}

		$order_attach_id = Input::post('attach_id');
		if(!Utility::is_empty($order_attach_id)) {
			$order_attach = Model_Order_Attach::select_primary($order_attach_id);
			if(empty($order_attach)) {
				Response::redirect('base/timeout');
			}
		} else {
			$order_attach = null;
		}

		$this->save_order_info($order_info, $order, Config::get('constant.order_info_status.kbn.request_state'), Input::post('request_state_date'), Input::post('request_state_note'));
		$this->save_order_info($order_info, $order, Config::get('constant.order_info_status.kbn.request_state_admin'), Input::post('request_state_date_admin'), Input::post('request_state_note_admin'));
		$this->save_order_info($order_info, $order, Config::get('constant.order_info_status.kbn.reference_url'), date('Y-m-d'), Input::post('reference_url'), Input::post('reference_url_note'));
		$this->save_order_info($order_info, $order, Config::get('constant.order_info_status.kbn.reference_url_admin'), Input::post('reference_url_date_admin'), Input::post('reference_url_note_admin'));
		$this->save_order_info($order_info, $order, Config::get('constant.order_info_status.kbn.budget'), Input::post('budget_date'), Input::post('budget_note'));
		$this->save_order_info($order_info, $order, Config::get('constant.order_info_status.kbn.budget_admin'), Input::post('budget_date_admin'), Input::post('budget_note_admin'));
		$this->save_order_info($order_info, $order, Config::get('constant.order_info_status.kbn.other'), Input::post('other_date'), Input::post('other_note'));
		$this->save_order_info($order_info, $order, Config::get('constant.order_info_status.kbn.other_admin'), Input::post('other_date_admin'), Input::post('other_note_admin'));

		if($order_attach != null) {
			$order_attach->note = Input::post('attach_note');
			$order_attach->save();
		}

		return json_encode(array(
			'error' => '',
			'info' => '注文情報を更新しました。',
			'reload' => '500',
			'order_id' => $order_id,
		));
	}

	public static function save_order_info($order_info, $order, $kbn, $target_at, $content, $note = '') {
		if(!Utility::is_empty($target_at) && !Utility::is_empty($content)) {
			if($order_info != null && $order_info->info_kbn == $kbn) {
				$update_jnl = $order_info;
			} else {
				$update_jnl = Model_Order_Info::forge();
				$update_jnl->order_id = $order->id;
				$update_jnl->user_id  = $order->user_id;
				$update_jnl->info_kbn = $kbn;
			}
			$update_jnl->target_at = $target_at;
			$update_jnl->content = $content;
			if(!Utility::is_empty($note)) {
				$update_jnl->note = $note;
			} else {
				$update_jnl->note = '';
			}
			$update_jnl->save();
		}
	}

	public function action_delete() {
		$info_kbn = Input::post('order_info_kbn');
		$id       = Input::post('id');
		if($info_kbn != 'content' && $info_kbn != 'attach') {
			return json_encode(array(
				'error' => '注文情報区分が不正です。',
				'info' => ''
			));
		}
		if($info_kbn == 'content') {
			Model_Order_Info::delete_order_info($id);
		} else {
			Model_Order_Attach::delete_order_attach($id);
		}

		return json_encode(array(
			'error' => '',
			'info' => '注文情報を削除しました。',
			'reload' => '500',
		));
	}
}
