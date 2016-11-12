<?php

class Controller_Order_Sheet extends Controller_Template {

	public $template = 'template/template';

	public function before() {
		parent::before();
		if (!Auth::has_access('web.menu')) {
			Response::redirect('base/timeout');
		}
	}

	public static function get_commission($order_kbn, $member_rank) {
		if($order_kbn == Config::get('constant.order_kbn.kbn.oem')) {
			$commission = Model_Commissions::forge();
			$commission->rank = Config::get('constant.oem_commission.rank');
			$commission->commission = Config::get('constant.oem_commission.commission');
			$commission->minimum_commission = Config::get('constant.oem_commission.minimum_commission');
		} else {
			$commission = Model_Commissions::select_primary($member_rank);
		}
		return $commission;
	}

	public function action_index() {
		$user_id  = Utility::get_user_id();
		$order_id = Input::get('id');
		$detail_ids = Input::get('did');

		if(!Utility::is_empty($order_id)) {
			$order = Model_Order_Jnl::select_primary($user_id, $order_id);
			if(count($order) == 0) {
				Response::redirect('base/timeout');
			}
			$order_detail         = Model_Order_Detail::get_order_list($order->user_id, $order->id);
			$send_jnl_list        = Model_Send_Jnl::select_by_order_id($order->id, $order->user_id);
			$total_delivery_fee   = Model_Send_Jnl::total_delivery_fee_by_order($order->id, $order->user_id);
			$message_unread_count = Model_Order_Message::select_unread_count($order->id);
			$order_info_format    = Controller_Admin_Order_Sheet::get_format_order_info(Model_Order_Info::select_primary_admin_by_order_id($order->id));
			$order_attachs        = Model_Order_Attach::select_primary_admin_by_order_id($order->id);
		} else {
			$order                  = Model_Order_Jnl::forge();
			$order_detail           = array();
			$send_jnl_list          = array();
			$total_delivery_fee     = 0;
			$message_unread_count   = 0;
			$order_info_format      = array();
			$order_attachs          = array();
			$order->delivery_option = Config::get('constant.delivery_option.kbn.standard');

			$order_kbn = Input::get('kbn');
			if(!Utility::is_empty($order_kbn) && $order_kbn == Config::get('constant.order_kbn.kbn.oem')) {
				$order->order_kbn = $order_kbn;
			} else {
				$order->order_kbn = Config::get('constant.order_kbn.kbn.normal');
			}
		}

		if(!Utility::is_empty($detail_ids)) {
			foreach (preg_split("/,/", $detail_ids) as $detail_id) {
				$dtl_pre = Model_Order_Detail::select_primary($user_id, $detail_id);
				if(!$dtl_pre) {
					Response::redirect('base/timeout');
				}
				$dtl_new = Model_Order_Detail::forge();
				$dtl_new->supplier_url1  = $dtl_pre->supplier_url1;
				$dtl_new->supplier_url2  = $dtl_pre->supplier_url2;
				$dtl_new->supplier_url3  = $dtl_pre->supplier_url3;
				$dtl_new->url1_checked_flg       = $dtl_pre->url1_checked_flg;
				$dtl_new->url2_checked_flg       = $dtl_pre->url2_checked_flg;
				$dtl_new->url3_checked_flg       = $dtl_pre->url3_checked_flg;
				$dtl_new->image_id       = $dtl_pre->image_id;
				$dtl_new->image_id2      = $dtl_pre->image_id2;
				$dtl_new->valiation      = $dtl_pre->valiation;
				$dtl_new->demand         = $dtl_pre->demand;
				$dtl_new->request_amount = $dtl_pre->request_amount;
				$dtl_new->china_price    = $dtl_pre->china_price;
				$dtl_new->sku            = $dtl_pre->sku;
				$dtl_new->national_delivery_fee            = $dtl_pre->national_delivery_fee;
				$order_detail[] = $dtl_new;
			}
		}

		$max_detail_count = Utility::get_order_sheet_detail_count($user_id);
		for($i = count($order_detail); $i < $max_detail_count; $i++) {
			$order_detail[] = Model_Order_Detail::forge();
		}

		$currency = Model_Currency_Rate::select_primary();
		$user = Model_Users::select_primary($user_id);
		$commission = Controller_Order_Sheet::get_commission($order->order_kbn, $user->member_rank);
		$payer = Model_Payers::select_primary($user->payers_id);
		if(!$payer) {
			$payer = Model_Payers::forge();
			$payer->payer_commission = 0;
		}

		$this->template->title = '注文シート';
		$this->template->content = View::forge('order/sheet');
		$this->template->content->set_safe('order', $order);
		$this->template->content->set_safe('order_detail', $order_detail);
		$this->template->content->set_safe('currency', $currency);
		$this->template->content->set_safe('user', $user);
		$this->template->content->set_safe('commission', $commission);
		$this->template->content->set_safe('payer', $payer);
		$this->template->content->set_safe('send_jnl_list', $send_jnl_list);
		$this->template->content->set_safe('total_delivery_fee', $total_delivery_fee);
		$this->template->content->set_safe('message_unread_count', $message_unread_count);
		$this->template->content->set_safe('order_info_format', $order_info_format);
		$this->template->content->set_safe('order_attachs', $order_attachs);
		$this->template->content->set_safe('is_history', false);
	}

	public function action_receiver() {
		$user_id     = Utility::get_user_id();
		$receiver_id = Input::post('receiver_id');
		$receiver    = Model_Receivers::select_primary($user_id, $receiver_id);
		return json_encode(array(
			'receiver' => Controller_Receiver_Setting::get_receiver_array($receiver)
		));
	}

	private function validate_update_header() {
		$validation = Validation::forge();
		$validation->add('user_note', 'ユーザメモ')
			->add_rule('max_length', 150);
		$validation->run();
		return $validation;
	}

	public function action_update_header() {
		$validation = $this->validate_update_header();
		$errors = $validation->error();
		if (!empty($errors)) {
			return json_encode(array(
				'error' => $validation->show_errors(),
				'info' => ''
			));
		}
		$user_id  = Utility::get_user_id();
		$order_id = Input::post('order_id');

		try {
			DB::start_transaction();

			$order = Model_Order_Jnl::select_for_update_primary($order_id, $user_id);
			if(!$order) {
				throw new FuelException('注文が存在しません。');
			}
			if(Input::post('order_updated_at') != $order->updated_at) {
				throw new FuelException('他ユーザに更新されています。もう一度入力してください。');
			}
			$order->user_note    = Input::post('user_note');
			$order->save();

			DB::commit_transaction();

			return json_encode(array(
				'error' => '',
				'info' => '注文を更新しました。',
				'order_updated_at' => $order->updated_at,
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

	private function validate_sheet() {
		$validation = Validation::forge();
		$validation->add('order_status', '注文ステータス')
			->add_rule('required')
			->add_rule('valid_string', array('numeric'));
		$validation->add('user_note', 'ユーザメモ')
			->add_rule('max_length', 150);
		$validation->add('send_receiver', '配送先設定')
			->add_rule('required');
		$order_kbn = Input::post('order_kbn');
		$details = Input::post('details');
		if($details) {
			foreach ($details as $form_id => $detail) {
				$is_detail_exist = !Utility::is_empty($detail['request_amount'])
										|| !Utility::is_empty($detail['detail_id'])
										&& Utility::is_empty($detail['delete_check']);
				if(!$is_detail_exist) {
					continue;
				}
				if(Utility::is_empty($detail['delete_check'])) {
					$rule = Utility::add_detail_validation($validation, 'details', $form_id, 'url1', Utility::get_constant_name2('order_sheet_label', $order_kbn, 'url1'))
						->add_rule('valid_url')
						->add_rule('max_length', 500);
					if($order_kbn == Config::get('constant.order_kbn.kbn.normal')) {
						$rule->add_rule('required');
					}

					Utility::add_detail_validation($validation, 'details', $form_id, 'url2', Utility::get_constant_name2('order_sheet_label', $order_kbn, 'url2'))
						->add_rule('valid_url')
						->add_rule('max_length', 500);
					Utility::add_detail_validation($validation, 'details', $form_id, 'url3', Utility::get_constant_name2('order_sheet_label', $order_kbn, 'url3'))
						->add_rule('valid_url')
						->add_rule('max_length', 500);
					Utility::add_detail_validation($validation, 'details', $form_id, 'image_id', '画像')
						->add_rule('required')
						->add_rule('valid_string', array('numeric'));
					Utility::add_detail_validation($validation, 'details', $form_id, 'image_id2', '画像(補足)')
						->add_rule('valid_string', array('numeric'));
					Utility::add_detail_validation($validation, 'details', $form_id, 'valiation', 'バリエーション')
						->add_rule('max_length', 150);
					Utility::add_detail_validation($validation, 'details', $form_id, 'demand', '要望')
						->add_rule('max_length', 150);
					Utility::add_detail_validation($validation, 'details', $form_id, 'sku', 'SKU')
						->add_rule('max_length', 30);
					Utility::add_detail_validation($validation, 'details', $form_id, 'request_amount', '希望数量')
						->add_rule('required')
						->add_rule('numeric_between', 1, 10000)
						->add_rule('valid_string', array('numeric'));
					Utility::add_detail_validation($validation, 'details', $form_id, 'china_price', '単価（元）')
						->add_rule('required')
						->add_rule('match_pattern', '/^\d{1,8}(\.\d{1,2})?$/');

					for($idx = 1; $idx <= 7; $idx++) {
						Controller_Admin_Order_Sheet::option_validate($validation, $form_id, $detail, $idx);
					}
				}
			}
		}
		$validation->run();
		return $validation;
	}

	public function action_update() {
		$user_id  = Utility::get_user_id();
		$order_id = Input::post('order_id');
		$details  = Input::post('details');
		$international_delivery_fee_val  = Input::post('international_delivery_fee_val');

		$validation = $this->validate_sheet();
		$errors = $validation->error();
		if (!empty($errors)) {
			return json_encode(array(
				'error' => $validation->show_errors(),
				'info' => ''
			));
		}
		
		// add by ghh for url checkbox isRequired S
//		$index = 0;
//		$order_kbn = Input::post('order_kbn');
//		if($order_kbn == Config::get('constant.order_kbn.kbn.oem')){
//		}else {
//		foreach ($details as $detail) {
//			$index = $index + 1;
//			$is_detail_exist = !Utility::is_empty($detail['request_amount'])
//											&& Utility::is_empty($detail['delete_check']);
//					if(!$is_detail_exist) {
//						continue;
//					}
//			$flag = '';
//			if(!Utility::is_empty($detail['url1'])) {
//				if($detail['url1_checked_flg'] == '1') {
//					$flag = '1';
//				}
//			}
//			if(!Utility::is_empty($detail['url2'])) {
//				if($detail['url2_checked_flg'] == '1') {
//					$flag = '1';
//				}
//			}					
//			if(!Utility::is_empty($detail['url3'])) {
//				if($detail['url3_checked_flg'] == '1') {
//					$flag = '1';
//				}
//			}
//			
//			if (Utility::is_empty($flag)){				
//					return json_encode(array(
//						'error' => $index.'行目:'.'一つ仕入先URLをチェックください。',
//						'info' => ''
//					));
//			}
//		}
//		}
		// add by ghh for url checkbox isRequired E
		$order_status = Input::post('order_status');
		$currency = Model_Currency_Rate::select_primary();

		try {
			DB::start_transaction();

			$user = Model_Users::select_for_update_primary($user_id);

			$payer = Model_Payers::select_primary($user->payers_id);
			if(!$payer) {
				throw new FuelException('振込先が設定されていません。「アカウント変更」から設定してください。');
			}

			if(!Utility::is_empty($order_id)) {
				$order = Model_Order_Jnl::select_for_update_primary($order_id, $user_id);
				if(!$order) {
					throw new FuelException('注文が存在しません。');
				}
				if($order->order_status != Config::get('constant.order_status.kbn.draft')
					&& $order->order_status != Config::get('constant.order_status.kbn.temporary')) {
					throw new FuelException('更新できない注文ステータスです。');
				}
			} else {
				$order = Model_Order_Jnl::forge();
				$order->user_id = $user_id;

				$order_kbn = Input::post('order_kbn');
				if($order_kbn == Config::get('constant.order_kbn.kbn.oem')) {
					$order->order_kbn = $order_kbn;
				} else {
					$order->order_kbn = Config::get('constant.order_kbn.kbn.normal');
				}
				$order->temp_settle_flg = Config::get('constant.temp_settle_flg.kbn.no');
			}

			$commission = Controller_Order_Sheet::get_commission($order->order_kbn, $user->member_rank);
			if($commission->rank == Config::get('constant.member_rank.kbn.none')) {
				throw new FuelException('会員ランクが設定されていません。');
			}

			if(Input::post('user_updated_at') != $user->updated_at
				|| Input::post('order_updated_at') != $order->updated_at) {
				throw new FuelException('他ユーザに更新されています。もう一度入力してください。');
			}

			if($order->cny_jpy_rate == 0) {
				if($order_status == Config::get('constant.order_status.kbn.buy')
					|| $order_status == Config::get('constant.order_status.kbn.temporary')) {
					$order->cny_jpy_rate = $currency->rate;
				} else {
					$order->cny_jpy_rate = 0;
				}
			}

			if($order_status == Config::get('constant.order_status.kbn.buy')
				|| $order_status == Config::get('constant.order_status.kbn.temporary')) {
				$order->payer_name       = $payer->payer_name;
				$order->payer_url        = $payer->payer_url;
				$order->payer_commission = $payer->payer_commission;

				$order->international_delivery_fee = $international_delivery_fee_val;

			} else {
				$order->payer_name       = '';
				$order->payer_url        = '';
				$order->payer_commission = 0;
			}

			if(Utility::is_empty_date($order->ordered_at)) {
				if($order_status == Config::get('constant.order_status.kbn.buy')) {
					$order->ordered_at = Utility::get_datetime_now();
				} else {
					$order->ordered_at = '';
				}
			}

			if($order->cny_jpy_rate != 0) {
				$cny_jpy_rate = $order->cny_jpy_rate;
			} else {
				$cny_jpy_rate = $currency->rate;
			}

			$is_send_fba = false;
			if(Input::post('send_fba_flg') == Config::get('constant.address_kind.kbn.fba') 
			|| Input::post('send_fba_flg') == Config::get('constant.address_kind.kbn.fba_ship')) {
				$is_send_fba = true;
			}

			$sum_send_directly_box      = 0;
			$international_delivery_fee = 0;
			$sum_product_price          = 0;
			$sum_national_delivery_fee  = 0;

			$sum_detail_amount          = 0;
			$sum_fba_barcode_price      = 0;
			$sum_opp_packing_price      = 0;
			$sum_other_option_price     = 0;
			$sum_aplan_bplan_price      = 0;

			$update_detail_entry = array();
			$delete_detail_entry = array();
			$detail_no = 0;

			foreach ($details as $detail) {
				if(!Utility::is_empty($detail['detail_id'])) {
					$detail_entry = Model_Order_Detail::select_primary($user_id, $detail['detail_id']);
					if(!Utility::is_empty($detail['delete_check'])) {
						$delete_detail_entry[] = $detail_entry;
						continue;
					}
				} else {
					$is_detail_exist = !Utility::is_empty($detail['request_amount'])
											&& Utility::is_empty($detail['delete_check']);
					if(!$is_detail_exist) {
						continue;
					}
					$detail_entry = Model_Order_Detail::forge();
					$detail_entry->user_id                  = $user_id;
					$detail_entry->real_amount              = 0;
					$detail_entry->send_company             = '';
					$detail_entry->send_no                  = '';
					$detail_entry->send_status              = 0;
					$detail_entry->order_date               = 0;
					$detail_entry->receive_date             = 0;
					$detail_entry->admin_message            = '';
					$detail_entry->admin_message2            = '';
					$detail_entry->other_option1_label      = '';
					$detail_entry->other_option1_amount     = '';
					$detail_entry->other_option1_unit_price = '';
					$detail_entry->other_option2_label      = '';
					$detail_entry->other_option2_amount     = '';
					$detail_entry->other_option2_unit_price = '';
					$detail_entry->other_option3_label      = '';
					$detail_entry->other_option3_amount     = '';
					$detail_entry->other_option3_unit_price = '';
					$detail_entry->other_option4_label      = '';
					$detail_entry->other_option4_amount     = '';
					$detail_entry->other_option4_unit_price = '';
					$detail_entry->other_option5_label      = '';
					$detail_entry->other_option5_amount     = '';
					$detail_entry->other_option5_unit_price = '';
					$detail_entry->other_option6_label      = '';
					$detail_entry->other_option6_amount     = '';
					$detail_entry->other_option6_unit_price = '';
					$detail_entry->other_option7_label      = '';
					$detail_entry->other_option7_amount     = '';
					$detail_entry->other_option7_unit_price = '';
				}
				$detail_entry->detail_no       = $detail_no++;
				$detail_entry->supplier_url1   = $detail['url1'];
				$detail_entry->supplier_url2   = $detail['url2'];
				$detail_entry->supplier_url3   = $detail['url3'];
				$detail_entry->url1_checked_flg   = $detail['url1_checked_flg'];
				$detail_entry->url2_checked_flg   = $detail['url2_checked_flg'];
				$detail_entry->url3_checked_flg   = $detail['url3_checked_flg'];
				$detail_entry->image_id        = $detail['image_id'];
				$detail_entry->image_id2       = $detail['image_id2'];
				$detail_entry->valiation       = $detail['valiation'];
				$detail_entry->demand          = $detail['demand'];
				$detail_entry->request_amount  = $detail['request_amount'];
				$detail_entry->china_price     = $detail['china_price'];
				$detail_entry->sku             = $detail['sku'];
				$detail_entry->fba_barcode_flg = $detail['fba_barcode_flg'];
				$detail_entry->opp_packing_flg = $detail['opp_packing_flg'];
				$detail_entry->other_option1_label      = $detail['other_option1_label'];
				$detail_entry->other_option1_amount     = $detail['other_option1_amount'];
				$detail_entry->other_option1_unit_price = $detail['other_option1_unit_price'];
				$detail_entry->other_option2_label      = $detail['other_option2_label'];
				$detail_entry->other_option2_amount     = $detail['other_option2_amount'];
				$detail_entry->other_option2_unit_price = $detail['other_option2_unit_price'];
				$detail_entry->other_option3_label      = $detail['other_option3_label'];
				$detail_entry->other_option3_amount     = $detail['other_option3_amount'];
				$detail_entry->other_option3_unit_price = $detail['other_option3_unit_price'];
				$detail_entry->other_option4_label      = $detail['other_option4_label'];
				$detail_entry->other_option4_amount     = $detail['other_option4_amount'];
				$detail_entry->other_option4_unit_price = $detail['other_option4_unit_price'];
				$detail_entry->other_option5_label      = $detail['other_option5_label'];
				$detail_entry->other_option5_amount     = $detail['other_option5_amount'];
				$detail_entry->other_option5_unit_price = $detail['other_option5_unit_price'];
				$detail_entry->other_option6_label      = $detail['other_option6_label'];
				$detail_entry->other_option6_amount     = $detail['other_option6_amount'];
				$detail_entry->other_option6_unit_price = $detail['other_option6_unit_price'];
				$detail_entry->other_option7_label      = $detail['other_option7_label'];
				$detail_entry->other_option7_amount     = $detail['other_option7_amount'];
				$detail_entry->other_option7_unit_price = $detail['other_option7_unit_price'];

				if($order_status == Config::get('constant.order_status.kbn.buy')
					|| $order_status == Config::get('constant.order_status.kbn.temporary')) {
					$detail_entry->real_amount = $detail_entry->request_amount;
				}
				
				if($detail_entry->real_amount > 0){
					//if($order->
					$sum_aplan_bplan_price = $sum_aplan_bplan_price + $detail_entry->real_amount * Config::get('constant.unit_fba_barcode_price')
				}else{
					$sum_aplan_bplan_price = $sum_aplan_bplan_price + $detail_entry->request_amount * Config::get('constant.unit_fba_barcode_price')
				}

				$sum_detail_amount += $detail_entry->request_amount;
				if($detail_entry->fba_barcode_flg == Config::get('constant.fba_barcode_flg.kbn.yes')) {
					$sum_fba_barcode_price += $detail_entry->request_amount * Config::get('constant.unit_fba_barcode_price');
				}
				if($detail_entry->opp_packing_flg == Config::get('constant.opp_packing_flg.kbn.yes')) {
					$sum_opp_packing_price += $detail_entry->request_amount * Config::get('constant.unit_opp_packing_price');
				}
				if(!Utility::is_empty($detail_entry->other_option1_label)) {
					$sum_other_option_price += round($detail_entry->other_option1_amount * $detail_entry->other_option1_unit_price);
				}
				if(!Utility::is_empty($detail_entry->other_option2_label)) {
					$sum_other_option_price += round($detail_entry->other_option2_amount * $detail_entry->other_option2_unit_price);
				}
				if(!Utility::is_empty($detail_entry->other_option3_label)) {
					$sum_other_option_price += round($detail_entry->other_option3_amount * $detail_entry->other_option3_unit_price);
				}
				if(!Utility::is_empty($detail_entry->other_option4_label)) {
					$sum_other_option_price += round($detail_entry->other_option4_amount * $detail_entry->other_option4_unit_price);
				}
				if(!Utility::is_empty($detail_entry->other_option5_label)) {
					$sum_other_option_price += round($detail_entry->other_option5_amount * $detail_entry->other_option5_unit_price);
				}
				if(!Utility::is_empty($detail_entry->other_option6_label)) {
					$sum_other_option_price += round($detail_entry->other_option6_amount * $detail_entry->other_option6_unit_price);
				}
				if(!Utility::is_empty($detail_entry->other_option7_label)) {
					$sum_other_option_price += round($detail_entry->other_option7_amount * $detail_entry->other_option7_unit_price);
				}

				if(Utility::is_empty($detail_entry->detail_status)
					|| $detail_entry->detail_status == '0'
					|| $detail_entry->detail_status == Config::get('constant.order_status.kbn.draft')
					|| $detail_entry->detail_status == Config::get('constant.order_status.kbn.temporary')
					|| $detail_entry->detail_status == Config::get('constant.order_status.kbn.buy')) {
					$detail_entry->detail_status  = $order_status;
				}

				$detail_entry->japan_price   = round($detail_entry->china_price * $cny_jpy_rate, 3);

				$product_price = $detail_entry->request_amount * $detail_entry->japan_price;
				$detail_entry->product_price = round($product_price);

				$detail_entry->commission    = round($detail_entry->product_price
													* ($commission->commission * 0.01));

				$detail_entry->national_delivery_fee     = Config::get('constant.national_delivery_fee');
				$detail_entry->national_delivery_fee_yen = round($detail_entry->national_delivery_fee * $cny_jpy_rate);

				$detail_entry->subtotal_price            = round($detail_entry->product_price
															+ $detail_entry->commission
															+ $detail_entry->national_delivery_fee_yen);

				if($is_send_fba) {
					$send_directly_box = ceil($detail['request_amount'] / Config::get('constant.unit_send_directly_one_box'));
					$sum_send_directly_box += $send_directly_box;
				} else {
					$send_directly_box = 0;
				}
				$detail_entry->send_directly_box = $send_directly_box;

				$international_delivery_fee += round(
												ceil($detail_entry->request_amount / Config::get('constant.unit_one_box'))
													* Utility::get_unit_international_delivery_fee_rate($detail_entry->request_amount)
												);
				$sum_product_price         += $product_price;
				$sum_national_delivery_fee += $detail_entry->national_delivery_fee_yen;

				$update_detail_entry[] = $detail_entry;
			}

			$sum_product_price = round($sum_product_price);
			$sum_fba_barcode_price = round($sum_fba_barcode_price);
			$sum_opp_packing_price = round($sum_opp_packing_price);

			$sum_commission = round($sum_product_price
										* ($commission->commission * 0.01));

			if($sum_commission < $commission->minimum_commission) {
				$sum_commission = $commission->minimum_commission;
			}

			$unit_international_delivery_fee_max = Utility::get_constant_get2('constant.unit_international_delivery_fee_max', $order->order_kbn);
			if($international_delivery_fee > $unit_international_delivery_fee_max) {
				$international_delivery_fee = $unit_international_delivery_fee_max;
			}

			$sum_tax = round($sum_commission 
								* (Config::get('constant.consumption_tax') * 0.01));

			$sum_send_directly_price = $sum_send_directly_box * Config::get('constant.unit_send_directly_price');

			if(Input::post('special_inspection') == Config::get('constant.special_inspection.kbn.yes')) {
				$special_inspection_price = round($sum_detail_amount * Config::get('constant.unit_special_inspection_price'));
			} else {
				$special_inspection_price = 0;
			}

			$sum_option = $special_inspection_price
							+ $sum_fba_barcode_price
							+ $sum_opp_packing_price
							+ $sum_other_option_price;

			$sum_price = $sum_product_price
							+ $sum_commission
							+ $sum_national_delivery_fee
							+ $international_delivery_fee
							+ $sum_tax
							+ $sum_send_directly_price
							+ $sum_option;
			if($payer->payer_commission > 0) {
				$sum_price += $sum_price * ($payer->payer_commission / 100);
			}
			$sum_price = round($sum_price);

			$detail_count = count($update_detail_entry);
			if($detail_count == 0) {
				throw new FuelException('明細は1行以上入力してください。');
			}

			if($order_status == Config::get('constant.order_status.kbn.draft')) { // 差し戻しのときは、仮確定フラグも戻す
				$order->temp_settle_flg = Config::get('constant.temp_settle_flg.kbn.no');
			}
			$order->detail_count               = $detail_count;
			$order->order_status               = $order_status;
			$order->commission_rate            = $commission->commission;
			$order->minimum_commission         = $commission->minimum_commission;
			$order->product_price              = $sum_product_price;
			$order->commission                 = $sum_commission;
			$order->national_delivery_fee      = $sum_national_delivery_fee;
			$order->international_delivery_fee = $international_delivery_fee;
			$order->sum_send_directly_price    = $sum_send_directly_price;
			$order->special_inspection_flg     = Input::post('special_inspection');
			$order->special_inspection_price   = $special_inspection_price;
			$order->option_price               = $sum_option;
			$order->sum_tax                    = $sum_tax;
			$order->sum_price                  = $sum_price;
			$order->delivery_option            = Input::post('delivery_option');
			$order->user_note                  = Input::post('user_note');
			$order->send_fba_flg               = Input::post('send_fba_flg');
			$order->send_receiver              = Input::post('send_receiver');
			$order->send_zip1                  = Input::post('send_zip1');
			$order->send_zip2                  = Input::post('send_zip2');
			$order->send_address1              = Input::post('send_address1');
			$order->send_address2              = Input::post('send_address2');
			$order->send_phone                 = Input::post('send_phone');
			$order->send_name                  = Input::post('send_name');
			$order->save();

			foreach ($update_detail_entry as $detail_entry) {
				$detail_entry->order_id = $order->id;
				$detail_entry->save();
			}
			foreach ($delete_detail_entry as $detail_entry) {
				$detail_entry->delete();
			}

			if($order->order_status == Config::get('constant.order_status.kbn.buy')) {
				$order->international_delivery_fee = $international_delivery_fee_val;
				Controller_Order_Sheet::bill_buy($user, $order, $update_detail_entry);
			}
			DB::commit_transaction();

			return json_encode(array(
				'error' => '',
				'info' => '注文を更新しました。',
				'reload' => '500',
				'order_id' => $order->id,
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
			Log::error('注文シート：' . $e);
			return json_encode(array(
				'error' => 'データの更新に失敗しました。',
				'info' => ''
			));
		}
	}

	public static function bill_buy($user, $order, $details) {
		Model_Order_Bill_Jnl::insert_from_order($order);
		Model_Order_Bill_Detail::insert_from_order($details);

		$deposit_kbn = Config::get('constant.deposit_status.kbn.pay');
		$reason      = '最低デポジットデータ作成';
		Model_Deposit_Jnl::deposit_interface($user, $order->id, $deposit_kbn, 
												$reason, $order->sum_price, 
												$order->cny_jpy_rate);

		$body = Utility::get_mail_template('template_bill.txt');
		$body = Utility::mb_str_replace('%order_id%', $order->id, $body);
		$body = Utility::mb_str_replace('%date%', Utility::get_datetime_now(), $body);

		$entry = Model_Mail_Queue::forge();
		$entry->to      = $user->email;
		$entry->to_name = $user->name . '様';
		$entry->subject = '請求書の発行をご連絡いたします。';
		$entry->body    = $body;
		Model_Mail_Queue::insert_entry($entry);
	}
	
	// upload image
	public function action_fetchpage() {
		
		$pageurl = Input::get('pageurl');

		// 1. curl initialize
		$ch = curl_init();
		// 2. curl settings
		curl_setopt($ch, CURLOPT_URL, $pageurl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		// 3. get HTML document
		$output = curl_exec($ch);
		if($output === FALSE ){
			echo "CURL Error:".curl_error($ch);
		}
		if(preg_match('/.1688\.com/',$pageurl)){
			$output = mb_convert_encoding($output, 'utf-8', 'GBK,UTF-8,ASCII,GB2312');
			preg_match('/<title>(.*?)<\/title>/i', $output, $m);
			preg_match_all('/<em class=\"tb-rmb-num\">(.*?)<\/em>/i', $output, $prices);
			preg_match('/<meta[^>]*?property="og:image"[^>]*content=\"([^"]*)\"[^>]*>/', $output, $img);
		}else{
			$output = mb_convert_encoding($output, 'utf-8', 'GBK,UTF-8,ASCII,GB2312');
			preg_match('/<title>(.*?)<\/title>/i', $output, $m);
			preg_match_all('/<em class=\"tb-rmb-num\">(.*?)<\/em>/i', $output, $prices);
			preg_match('/<img[^>]*id=["J_ImgBooth"|"J_ThumbView"][^>]*rc=\"([^"]*)\"[^>]*>/', $output, $img);
		}
		// 4. dispose curl obj
		curl_close($ch);

		if (empty($img)) {
			return json_encode(array(
				'msg' => 'no image'
			));
		}
		
		// 5. upload img
		$imgurl = $img[1];
		$layers = explode('/', $imgurl);
		if(!preg_match('/^http:/', $imgurl) && !preg_match('/^https:/', $imgurl)) {
			$imgurl = 'http:'.$imgurl;
		}
		$user_id = Input::post('user_id', Utility::get_user_id());
		$file['file'] = file_get_contents($imgurl);
		$file['name'] = $layers[count($layers) - 1];
		$file['mimetype'] = 'image/jpeg';
		$file['extension'] = 'jpg';
        
		$id = Model_Images::insert_image_direct($user_id, $file);

		return json_encode(array(
			'imgid' => $id,
			'msg' => 'upload img success!',
		));
	}

}
