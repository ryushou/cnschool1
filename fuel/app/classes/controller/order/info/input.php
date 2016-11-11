<?php

class Controller_Order_Info_Input extends Controller_Template {

	public $template = 'template/template';

	public function before() {
		parent::before();
		if (!Auth::has_access('web.menu')) {
			Response::redirect('base/timeout');
		}
    }

	public function action_index() {
		$user_id  = Utility::get_user_id();
		$order_id = Input::get('oid', '');
		$order = Model_Order_Jnl::select_primary($user_id, $order_id);
		if(empty($order)) {
			Response::redirect('base/timeout');
		}

		$order_info_id = Input::get('iid', '');
		if(!Utility::is_empty($order_info_id)) {
			$order_info = Model_Order_Info::select_primary($user_id, $order_info_id);
			if(empty($order_info)) {
				Response::redirect('base/timeout');
			}
		} else {
			$order_info = Model_Order_Info::forge();
		}

		$order_attach_id = Input::get('aid', '');
		if(!Utility::is_empty($order_attach_id)) {
			$order_attach = Model_Order_Attach::select_primary_by_user_id($user_id, $order_attach_id);
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
		$this->template->content = View::forge('order/info/input');
		$this->template->content->set_safe('user_id', $order->user_id);
		$this->template->content->set_safe('order_id', $order->id);
		$this->template->content->set_safe('order_info_id', $order_info->id);
		$this->template->content->set_safe('order_info_array', $order_info_array);
		$this->template->content->set_safe('order_attach', $order_attach);
	}

	private function validate_update() {
		$validation = Validation::forge();
		Controller_Admin_Order_Info_Input::validation_order_info($validation, '参考URL', '', 'reference_url', true, 'reference_url_note');

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

		$user_id  = Utility::get_user_id();
		$order_id = Input::post('order_id');
		$order = Model_Order_Jnl::select_primary($user_id, $order_id);
		if(empty($order)) {
			Response::redirect('base/timeout');
		}

		$order_info_id = Input::post('order_info_id');
		if(!Utility::is_empty($order_info_id)) {
			$order_info = Model_Order_Info::select_primary($user_id, $order_info_id);
			if(empty($order_info)) {
				Response::redirect('base/timeout');
			}
		} else {
			$order_info = null;
		}

		$order_attach_id = Input::post('attach_id');
		if(!Utility::is_empty($order_attach_id)) {
			$order_attach = Model_Order_Attach::select_primary_by_user_id($user_id, $order_attach_id);
			if(empty($order_attach)) {
				Response::redirect('base/timeout');
			}
		} else {
			$order_attach = null;
		}

		Controller_Admin_Order_Info_Input::save_order_info($order_info, $order, Config::get('constant.order_info_status.kbn.reference_url'), date('Y-m-d'), Input::post('reference_url'), Input::post('reference_url_note'));

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

	// public function action_delete() {
	// 	$info_kbn = Input::post('order_info_kbn');
	// 	$id       = Input::post('id');
	// 	if($info_kbn != 'content' && $info_kbn != 'attach') {
	// 		return json_encode(array(
	// 			'error' => '注文情報区分が不正です。',
	// 			'info' => ''
	// 		));
	// 	}
	// 	if($info_kbn == 'content') {
	// 		Model_Order_Info::delete_order_info($id);
	// 	} else {
	// 		Model_Order_Attach::delete_order_attach($id);
	// 	}

	// 	return json_encode(array(
	// 		'error' => '',
	// 		'info' => '注文情報を削除しました。',
	// 		'reload' => '500',
	// 	));
	// }
}
