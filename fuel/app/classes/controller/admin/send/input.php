<?php

class Controller_Admin_Send_Input extends Controller_Template {

	public $template = 'template/template';

	public function before() {
		parent::before();
        if(!Auth::has_access('send.input')) {
			Response::redirect('base/timeout');
		}
    }

    private function check_order_status($order_id) {
    	$order = Model_Order_Jnl::select_primary_admin($order_id);
    	return $order->order_status != Config::get('constant.order_status.kbn.finish');
    }

	public function action_new() {
		$order_id   = Input::get('id', '');
		$detail_ids = explode(',', Input::get('dtl'));
		if(Utility::is_empty($order_id) || empty($detail_ids)) {
			Response::redirect('base/timeout');
		}
		if(!$this->check_order_status($order_id)) {
			Response::redirect('base/timeout');
		}

		$order              = Model_Order_Jnl::select_primary_admin($order_id);
		$detail_ids         = Model_Order_Detail::select_primaries($order_id, $detail_ids);

		$send_jnl           = Model_Send_Jnl::forge();
		$send_jnl->order_id = $order_id;
		$send_jnl->user_id  = $order->user_id;

		$send_details        = array();
		$send_detail_amounts = array();
		$order_details       = array();
		foreach ($detail_ids as $detail_id) {
			$order_detail = Model_Order_Detail::select_primary_admin($detail_id->id);
			if(!$order_detail) {
				Response::redirect('base/timeout');
			}
			$send_detail                  = Model_Send_Detail::forge();
			$send_detail->order_detail_id = $order_detail->id;
			$send_detail->amount          = $order_detail->real_amount;
			$send_detail->unit_price      = round($order_detail->japan_price);

			$send_detail_amount = Model_Send_Detail::get_send_detail_amounts($send_jnl->order_id, $order_detail->id);
			if(!$send_detail_amount) {
				Response::redirect('base/timeout');
			}

			$send_details[] = $send_detail;
			$order_details[] = $order_detail;
			$send_detail_amounts[] = $send_detail_amount;
		}

		$commissions = Model_Commissions::get_free_commissions();
		$user        = Model_Users::select_primary($order->user_id);
		foreach($commissions as $commission) {
			if($user->member_rank == $commission->rank) {
				$send_jnl->delivery_name = Config::get('constant.vip_delivery.default_name');
				break;
			}
		}

		$this->template->title = '発送伝票入力';
		$this->template->content = View::forge('admin/send/input');
		$this->template->content->set_safe('infomsg', '');
		$this->template->content->set_safe('errmsg', '');
		$this->template->content->set_safe('send_jnl', $send_jnl);
		$this->template->content->set_safe('send_details', $send_details);
		$this->template->content->set_safe('send_detail_amounts', $send_detail_amounts);
		$this->template->content->set_safe('order_details', $order_details);
	}

	public function action_modify() {
		$send_id  = Input::get('id'); // send_jnl.id
		$send_jnl = Model_Send_Jnl::select_primary_admin($send_id);
		if(!$send_jnl) {
			Response::redirect('base/timeout');
		}
		if(!$this->check_order_status($send_jnl->order_id)) {
			Response::redirect('base/timeout');
		}

		$order_detail_ids = Model_Send_Detail::get_order_detail_ids($send_jnl->id);
		$get_dtl          = Input::get('dtl', '');
		if(Utility::is_empty($get_dtl)) {
			$select_detail_ids = $order_detail_ids;
		} else {
			$select_detail_ids = array_merge(explode(',', $get_dtl), $order_detail_ids);
		}

		$order_detail_list = Model_Order_Detail::select_primaries($send_jnl->order_id, $select_detail_ids);

		$send_details        = array();
		$send_detail_amounts = array();
		$order_details       = array();
		foreach ($order_detail_list as $order_detail) {
			$send_detail = Model_Send_Detail::select_primary($send_jnl->id, $order_detail->id);
			if(!$send_detail) {
				$send_detail                  = Model_Send_Detail::forge();
				$send_detail->order_detail_id = $order_detail->id;
				$send_detail->amount          = $order_detail->real_amount;
				$send_detail->unit_price      = round($order_detail->japan_price);
			}
			$send_detail_amount = Model_Send_Detail::get_send_detail_amounts($send_jnl->order_id, $order_detail->id, $send_jnl->id);
			if(!$send_detail_amount) {
				Response::redirect('base/timeout');
			}

			$send_details[] = $send_detail;
			$order_details[] = $order_detail;
			$send_detail_amounts[] = $send_detail_amount;
		}
		if(empty($send_details)) {
			Response::redirect('base/timeout');
		}

		$this->template->title = '発送伝票入力';
		$this->template->content = View::forge('admin/send/input');
		$this->template->content->set_safe('infomsg', '');
		$this->template->content->set_safe('errmsg', '');
		$this->template->content->set_safe('send_jnl', $send_jnl);
		$this->template->content->set_safe('send_details', $send_details);
		$this->template->content->set_safe('send_detail_amounts', $send_detail_amounts);
		$this->template->content->set_safe('order_details', $order_details);
	}

	private function validate_update() {
		$validation = Validation::forge();
		$validation->add('delivery_date', '配送日付')
			->add_rule('required')
			->add_rule('match_pattern', '/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/');
		$validation->add('total_box', '箱数')
			->add_rule('required')
			->add_rule('valid_string', array('numeric'))
			->add_rule('numeric_between', 1, 1000);
		$validation->add('weight', '重量')
			->add_rule('required')
			->add_rule('match_pattern', '/^\d{1,5}(\.\d{1})?$/');
		$validation->add('delivery_fee_cny', '送料（元）')
			->add_rule('required')
			->add_rule('match_pattern', '/^\d{1,8}(\.\d{1,2})?$/');
		$validation->add('delivery_name', '配送業者')
			->add_rule('required');
		$validation->add('send_no', '追跡番号')
			->add_rule('required')
			->add_rule('max_length', 20);
		$validation->add('total_price', '合計金額')
			->add_rule('required')
			->add_rule('valid_string', array('numeric'))
			->add_rule('numeric_between', 0, 9999999);

		$details = Input::post('details');
		if($details) {
			foreach ($details as $form_id => $detail) {
				Utility::add_detail_validation($validation, 'details', $form_id, 'product_name', '品名')
					->add_rule('required')
					->add_rule('max_length', 20);
				Utility::add_detail_validation($validation, 'details', $form_id, 'amount', '数量')
					->add_rule('required')
					->add_rule('numeric_between', 0, 10000)
					->add_rule('valid_string', array('numeric'));
				Utility::add_detail_validation($validation, 'details', $form_id, 'unit_price', '単価')
					->add_rule('required')
					->add_rule('numeric_between', 0, 9999999)
					->add_rule('valid_string', array('numeric'));
				Utility::add_detail_validation($validation, 'details', $form_id, 'product_price', '商品金額')
					->add_rule('required')
					->add_rule('numeric_between', 0, 9999999)
					->add_rule('valid_string', array('numeric'));
			}
		}
		$validation->run();
		return $validation;
	}

	public function action_update() {
		$validation = $this->validate_update();
		$errors     = $validation->error();
		if (!empty($errors)) {
			return json_encode(array(
				'error' => $validation->show_errors(),
				'info' => ''
			));
		}
		$send_id  = Input::post('send_id');
		$order_id = Input::post('order_id');
		$user_id  = Input::post('user_id');
		$details  = Input::post('details');

		if(!$this->check_order_status($order_id)) {
			return json_encode(array(
				'error' => '請求確定されている注文です。',
				'info' => ''
			));
		}

		try {
			DB::start_transaction();

			if(!Utility::is_empty($send_id)) {
				$send_jnl = Model_Send_Jnl::select_for_update_primary($send_id);
				if(!$send_jnl) {
					DB::rollback_transaction();
					return json_encode(array(
						'error' => '発送伝票が存在しません。',
						'info' => ''
					));
				}
			} else {
				$send_jnl = Model_Send_Jnl::forge();
				$send_jnl->user_id  = $user_id;
				$send_jnl->order_id = $order_id;
			}

			$order = Model_Order_Jnl::select_primary_admin($order_id);
			if(!$order) {
				return json_encode(array(
					'error' => '注文が存在しません。',
					'info' => ''
				));
			}

			$total_price   = 0;
			$update_detail_entry = array();

			foreach ($details as $detail) {
				$send_detail_id = $detail['send_detail_id'];

				if(!Utility::is_empty($send_detail_id)) {
					$detail_entry = Model_Send_Detail::select_primary_admin($send_detail_id);
				} else {
					$detail_entry = Model_Send_Detail::forge();
					$detail_entry->send_id  = $send_id;
					$detail_entry->user_id  = $user_id;
					$detail_entry->order_id = $order_id;
					$detail_entry->order_detail_id = $detail['order_detail_id'];
				}
				$detail_entry->product_name    = $detail['product_name'];
				$detail_entry->amount          = $detail['amount'];
				$detail_entry->unit_price      = $detail['unit_price'];
				$detail_entry->product_price   = round($detail_entry->amount * $detail_entry->unit_price);

				$total_price += $detail_entry->product_price;

				$update_detail_entry[] = $detail_entry;
			}

			$delivery_fee_cny = Input::post('delivery_fee_cny');
			$delivery_fee = round($delivery_fee_cny * $order->cny_jpy_rate);

			$send_jnl->delivery_date = Input::post('delivery_date');
			$send_jnl->total_box     = Input::post('total_box');
			$send_jnl->weight        = Input::post('weight');
			$send_jnl->delivery_fee  = $delivery_fee;
			$send_jnl->delivery_fee_cny = $delivery_fee_cny;
			$send_jnl->send_no       = Input::post('send_no');
			$send_jnl->delivery_name = Input::post('delivery_name');
			$send_jnl->total_price   = $total_price;
			if($send_jnl->send_mail_flg == '') {
				$send_jnl->send_mail_flg = Config::get('constant.send_mail_flg.kbn.unsend');
			}
			$send_jnl->save();

			foreach ($update_detail_entry as $detail_entry) {
				$detail_entry->send_id = $send_jnl->id;
				$detail_entry->save();
			}
			DB::commit_transaction();

			return json_encode(array(
				'error' => '',
				'info' => '発送伝票を登録しました。',
				'reload' => '500',
				'send_id' => $send_jnl->id,
			));
		}
		catch (FuelException $e) {
			DB::rollback_transaction();
			return json_encode(array(
					'error' => $e->getMessage(),
					'info' => ''
				));
		}
		catch (Exception $e) {
			DB::rollback_transaction();
			return json_encode(array(
				'error' => 'データの更新に失敗しました。',
				'info' => ''
			));
		}
	}

	public function action_delete_jnl() {
		$send_id = Input::post('send_id');
		$send_jnl = Model_Send_Jnl::select_primary_admin($send_id);
		if(!$this->check_order_status($send_jnl->order_id)) {
			return json_encode(array(
				'error' => '請求確定されている注文です。',
				'info' => ''
			));
		}

		try {
			DB::start_transaction();

			Model_Send_Jnl::delete_send_jnl($send_id);
			Model_Send_Detail::delete_send_detail($send_id);

			DB::commit_transaction();
		}
		catch (\Database_exception $e) {
			DB::rollback_transaction();
			return json_encode(array(
				'error' => '発送伝票を削除できませんでした。',
				'info' => ''
			));
		}
		return json_encode(array(
			'error' => '',
			'info' => '発送伝票を削除しました。',
			'reload' => '500',
		));
	}

	public function action_delete_detail() {
		$send_detail_id = Input::post('send_detail_id');
		$send_detail    = Model_Send_Detail::select_primary_admin($send_detail_id);
		if(!$this->check_order_status($send_detail->order_id)) {
			return json_encode(array(
				'error' => '請求確定されている注文です。',
				'info' => ''
			));
		}
		if(Model_Send_Detail::query()->where('send_id', $send_detail->send_id)->count() <= 1) {
			return json_encode(array(
				'error' => '明細行数が1件です。注文シートから削除をしてください。',
				'info' => ''
			));
		}

		Model_Send_Detail::delete_send_detail_by_id($send_detail_id);
		return json_encode(array(
			'error' => '',
			'info' => '明細を削除しました。',
			'reload' => '500',
			'send_id' => $send_detail->send_id
		));
	}
}
