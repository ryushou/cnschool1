<?php
	class Model_Order_Jnl extends Orm\Model {
		protected static $_table_name = 'order_jnl';
		protected static $_properties = array (
			'id',
			'user_id',
			'order_kbn',
			'created_at',
			'ordered_at',
			'updated_at',
			'detail_count',
			'order_status',
			'cny_jpy_rate',
			'commission_rate',
			'minimum_commission',
			'product_price',
			'commission',
			'national_delivery_fee',
			'international_delivery_fee',
			'sum_tax',
			'sum_send_directly_price',
			'special_inspection_flg',
			'special_inspection_price',
			'option_price',
			'sum_price',
			'delivery_option',
			'payer_name',
			'payer_url',
			'payer_commission',
			'user_note',
			'send_fba_flg',
			'send_receiver',
			'send_zip1',
			'send_zip2',
			'send_address1',
			'send_address2',
			'send_phone',
			'send_name',
			'temp_settle_flg'
		);
		protected static $_primary_key = array (
			'id',
		);
		protected static $_observers = array(
	        'Orm\Observer_CreatedAt' => array(
	            'events' => array('before_insert'),
	            'mysql_timestamp' => true,
	        ),
	        'Orm\Observer_UpdatedAt' => array (
				'events' => array('before_save'),
				'mysql_timestamp' => true,
			),
	    );

		public static function select_primary($user_id, $order_id) {
			return Model_Order_Jnl::find('first', array(
				'where' => array(
					array('id', $order_id),
					array('user_id', $user_id),
				)
			));
		}

		public static function select_primary_is_draft($user_id, $order_id) {
			return Model_Order_Jnl::find('first', array(
				'where' => array(
					array('id', $order_id),
					array('user_id', $user_id),
					array('order_status', Config::get('constant.order_status.kbn.draft')),
				)
			));
		}

		public static function select_primary_admin($order_id) {
			return Model_Order_Jnl::find($order_id);
		}

		public static function select_for_update_primary($order_id, $user_id = '') {
			$query = DB::select_array(Model_Order_Jnl::$_properties)
					->from(Model_Order_Jnl::$_table_name)
					->where('id', $order_id);

			if(!Utility::is_empty($user_id)) {
				$query = $query->and_where('user_id', $user_id);
			}
			$result = DB::query($query->compile() . ' FOR UPDATE')
						->execute();

			if($result) {
				return Model_Order_Jnl::forge($result->current(), false);
			} else {
				return false;
			}
		}

		public static function get_order_ids_admin_lists($search) {
			$is_search_order_id   = !Utility::is_empty($search['order_id']);
			$is_search_user_id    = !Utility::is_empty($search['user_id']);
			$is_search_message    = !Utility::is_empty($search['message']);
			$is_search_untransact = !Utility::is_empty($search['untransact']);
            $is_search_fba_flg    = !Utility::is_empty($search['fba_flg']);
			$select = DB::select('order_detail.order_id')
						->from('order_detail');

			if($is_search_message) {
				$select->join('order_message', 'left')
					->on('order_message.order_id', '=', 'order_detail.order_id')
					->on('order_message.user_id', '!=', DB::expr(Utility::get_user_id()))
					
					->on('order_message.readed_flg', '=', DB::expr(Config::get('constant.order_message.kbn.unread')));
			}
			$select->join('order_jnl', 'inner')
				->on('order_jnl.id', '=', 'order_detail.order_id');
            
			if($is_search_order_id) {
				$select = $select->and_where('order_detail.order_id', '=', $search['order_id']);
			}
			if($is_search_user_id) {
				$select = $select->and_where('order_detail.user_id', '=', $search['user_id']);
			}
		    
		    if($is_search_fba_flg ){
		    	$select = $select->and_where('order_jnl.send_fba_flg', '=', $search['fba_flg']);
		    }
			$detail_status_query = 'CASE WHEN order_detail.detail_status = ' . Config::get('constant.order_status.kbn.temporary')
									. ' THEN ' . (Config::get('constant.order_status.kbn.draft')+0.5) . ' ELSE order_detail.detail_status END';
			$detail_search_status = $search['status'] == Config::get('constant.order_status.kbn.temporary') ? Config::get('constant.order_status.kbn.draft')+0.5 : $search['status'];
			Utility::status_query($select, DB::expr($detail_status_query), $detail_search_status, $search['status_range']);

			$is_orderer           = Auth::member(Config::get('constant.member_group.kbn.orderer'));
			$is_shipper           = Auth::member(Config::get('constant.member_group.kbn.shipper'));
			$is_oem_orderer       = Auth::member(Config::get('constant.member_group.kbn.oem_orderer'));
			$is_oem_shipper       = Auth::member(Config::get('constant.member_group.kbn.oem_shipper'));
			$is_oem_administrator = Auth::member(Config::get('constant.member_group.kbn.oem_administrator'));

			if($is_orderer) { // 発注担当：注文確定～入荷済み
				$order_status_from = Config::get('constant.order_status.kbn.buy');
				$order_status_to   = Config::get('constant.order_status.kbn.arrival');
				$temporary_flg     = false;
				$is_oem_flg        = false;
			}
			else if($is_oem_orderer) { // OEM発注担当：見積依頼+完成まで
				$order_status_from = Config::get('constant.order_status.kbn.buy');
				$order_status_to   = Config::get('constant.order_status.kbn.arrival');
				$temporary_flg     = true;
				$is_oem_flg        = true;
			}
			else if($is_shipper) { // 出荷担当：入荷待ち～出荷準備中
				$order_status_from = Config::get('constant.order_status.kbn.backordering');
				$order_status_to   = Config::get('constant.order_status.kbn.preparation');
				$temporary_flg     = false;
				$is_oem_flg        = false;
			}
			else if($is_oem_shipper) { // OEM出荷担当：完成～出荷準備中
				$order_status_from = Config::get('constant.order_status.kbn.backordering');
				$order_status_to   = Config::get('constant.order_status.kbn.preparation');
				$temporary_flg     = false;
				$is_oem_flg        = true;
			}
			else if($is_oem_administrator) { // OEM管理者：見積依頼～出荷準備中
				$order_status_from = Config::get('constant.order_status.kbn.buy');
				$order_status_to   = Config::get('constant.order_status.kbn.preparation');
				$temporary_flg     = true;
				$is_oem_flg        = true;
				$dispatchusers = DB::select('user_id')->from('users_dispatch')->where('my_id', '=', Utility::get_user_id())->execute()->as_array();
				if(count($dispatchusers)>0){
					$select = $select->and_where('order_detail.order_id', 'in', $dispatchusers);
				}else{
					$dispatchusers = DB::select('user_id')->from('users_dispatch')->where('which_type', '=', 'oem')->execute()->as_array();
					$select = $select->and_where('order_detail.order_id', 'not in', $dispatchusers);
				}
			}
			else { // 管理者：注文確定～出荷準備中
				$order_status_from = Config::get('constant.order_status.kbn.buy');
				$order_status_to   = Config::get('constant.order_status.kbn.preparation');
				$temporary_flg     = false;
				$is_oem_flg        = false;
			}

			if (!Auth::has_access('order.oem') || !Auth::has_access('order.normal')) { // スーパーユーザ対策
				if($is_oem_flg) {
					$order_kbn = Config::get('constant.order_kbn.kbn.oem');
				} else {
					$order_kbn = Config::get('constant.order_kbn.kbn.normal');
				}
				$select = $select->and_where('order_jnl.order_kbn', '=', $order_kbn);
			}

			if($is_search_untransact) {
				if($is_orderer || $is_oem_orderer) {
					// 注文係が注文一覧を「未処理」で検索した場合に限り
					// 「注文確定」の注文だけは、ユーザの残高が0円以上の注文だけを表示する
					$select->join('users', 'left')
						->on('users.id', '=', 'order_detail.user_id');
					$select = $select->and_where('users.deposit', '>=', DB::expr(0));
				}

				if($temporary_flg) {
					$select->and_where_open();
					Utility::query_between($select, 'order_detail.detail_status', $order_status_from, $order_status_to);
					$select->or_where('order_detail.detail_status', Config::get('constant.order_status.kbn.temporary'));
					$select->and_where_close();
				} else {
					Utility::query_between($select, 'order_detail.detail_status', $order_status_from, $order_status_to);
				}
				$select = $select->and_where('order_jnl.order_status', '!=', Config::get('constant.order_status.kbn.draft'));
			}
			if($is_search_message) {
				$select->having(DB::expr('COUNT(order_message.id)'), '>', DB::expr(0));
			}
			$select = $select->group_by('order_detail.order_id');

			return $select->execute()->as_array();
		}

		public static function get_admin_lists_count($order_ids) {
			$select = DB::select(DB::expr('COUNT(*) as count'));
			Model_Order_Jnl::get_admin_lists_select($select, $order_ids);
			return $select->execute()->current()['count'];
		}

		public static function get_admin_lists($order_ids, $pagination, $search) {
			$is_search_sort = !Utility::is_empty($search['sort']);

			$select_fields = array('order_jnl.id', 'order_jnl.user_id', 'order_jnl.order_kbn', 'order_jnl.created_at',
								   'order_jnl.ordered_at', 'order_jnl.detail_count', 'order_jnl.sum_price', 'order_detail.image_id',
								   'order_jnl.payer_name', 'order_jnl.payer_url', 
								   'order_jnl.order_status', 'order_jnl.send_fba_flg','order_jnl.send_name','order_jnl.send_receiver',
								   DB::expr('COUNT(order_message.id) as message_unread_count'));

			$select = DB::select_array($select_fields);
			Model_Order_Jnl::get_admin_lists_select($select, $order_ids);

			$select->join('order_message', 'left')
				->on('order_message.order_id', '=', 'order_jnl.id')
				->on('order_message.user_id', '!=', DB::expr(Utility::get_user_id()))
				->on('order_message.readed_flg', '=', DB::expr(Config::get('constant.order_message.kbn.unread')))
			->group_by('order_jnl.id');

			if($is_search_sort) {
				if($search['sort'] == Config::get('constant.order_list_sort.kbn.order_no')) {
					$select->order_by('order_jnl.id', 'desc'); // 注文no
				} else if($search['sort'] == Config::get('constant.order_list_sort.kbn.order_date_desc')) {
					$select->order_by('order_jnl.ordered_at', 'desc'); // 注文日時
				}
			}
			$result = $select->limit($pagination->per_page)
						->offset($pagination->offset);

			return $select->execute()->as_array();
		}

		private static function get_admin_lists_select($select, $order_ids) {
			$select->from('order_jnl')
					->where('order_jnl.id', 'in', $order_ids)
					->join('order_detail', 'inner')
						->on('order_detail.order_id', '=', 'order_jnl.id')
						->on('order_detail.detail_no', '=', DB::expr('0'));
		}

		public static function get_order_ids_user_lists($user_id, $search) {
			$is_order_date = !Utility::is_empty($search['order_date_from']) || !Utility::is_empty($search['order_date_to']);

			$select = DB::select('order_detail.order_id')
						->from('order_jnl')
						->where('order_jnl.user_id', $user_id)
						->join('order_detail', 'inner')
							->on('order_detail.order_id', '=', 'order_jnl.id');

			$detail_status_query = 'CASE WHEN order_detail.detail_status = ' . Config::get('constant.order_status.kbn.temporary')
									. ' THEN ' . (Config::get('constant.order_status.kbn.draft')+0.5) . ' ELSE order_detail.detail_status END';
			$detail_search_status = $search['status'] == Config::get('constant.order_status.kbn.temporary') ? Config::get('constant.order_status.kbn.draft')+0.5 : $search['status'];
			Utility::status_query($select, DB::expr($detail_status_query), $detail_search_status, $search['status_range']);

			if($is_order_date) {
				Utility::query_between($select, 'order_jnl.created_at', 
						Utility::get_date_time_value($search['order_date_from']),
						Utility::get_date_time_value($search['order_date_to'] . ' +1 days')); // search_to +1daysしないと指定日付で検索できない
			}
			$select = $select->group_by('order_jnl.id');
			return $select->execute()->as_array();
		}

		public static function get_user_lists_count($user_id, $order_ids) {
			$select = DB::select(DB::expr('COUNT(*) as count'));
			Model_Order_Jnl::get_user_lists_select($select, $user_id, $order_ids);
			return $select->execute()->current()['count'];
		}

		public static function get_user_lists($user_id, $order_ids, $pagination) {
			$select_fields = array('order_jnl.id', 'order_jnl.created_at',
								   'order_jnl.detail_count', 'order_jnl.sum_price', 'order_detail.image_id',
								   'order_jnl.payer_name', 'order_jnl.payer_url', 
								   'order_jnl.order_kbn', 'order_jnl.order_status', 'order_jnl.send_fba_flg', 
								   'order_jnl.user_note','order_jnl.send_name','order_jnl.send_receiver',
								   DB::expr('COUNT(order_message.id) as message_unread_count'));

			$select = DB::select_array($select_fields);
			Model_Order_Jnl::get_user_lists_select($select, $user_id, $order_ids);

			$select->join('order_message', 'left')
				->on('order_message.order_id', '=', 'order_jnl.id')
				->on('order_message.user_id', '!=', DB::expr(Utility::get_user_id()))
				->on('order_message.readed_flg', '=', DB::expr(Config::get('constant.order_message.kbn.unread')))
			->group_by('order_jnl.id');

			$result = $select->order_by('order_jnl.id', 'desc')
						->limit($pagination->per_page)
						->offset($pagination->offset);

			return $select->execute()->as_array();
		}

		private static function get_user_lists_select($select, $user_id, $order_ids) {
			$select->from('order_jnl')
					->where('order_jnl.id', 'in', $order_ids)
					->and_where('order_jnl.user_id', $user_id)
					->join('order_detail', 'inner')
						->on('order_detail.order_id', '=', 'order_jnl.id')
						->on('order_detail.detail_no', '=', DB::expr('0'));
		}

		public static function get_download_datas($order_ids, $search) {
			$is_search_sort = !Utility::is_empty($search['sort']);

			$select_fields = array('order_jnl.id', 'order_jnl.user_id', 'order_jnl.order_kbn', 'order_jnl.ordered_at', 'users.name','order_jnl.payer_name','order_jnl.order_status', 'order_jnl.cny_jpy_rate', 
								   'order_jnl.product_price', 'order_jnl.commission', 
								   'order_jnl.national_delivery_fee', 'order_jnl.international_delivery_fee', 
								   'order_jnl.sum_tax', 'order_jnl.sum_price', 'order_jnl.send_fba_flg',
								   array('order_bill_jnl.sum_price', 'order_bill_jnl_sum_price'),
								   'send_jnl.send_no', 'send_jnl.weight', 'send_jnl.delivery_fee_cny', 'send_jnl.delivery_date',
								   );

			$select = DB::select_array($select_fields);
			Model_Order_Jnl::get_download_datas_select($select, $order_ids);

			if($is_search_sort) {
				if($search['sort'] == Config::get('constant.order_list_sort.kbn.order_no')) {
					$select->order_by('order_jnl.id', 'desc'); // 注文no
				} else if($search['sort'] == Config::get('constant.order_list_sort.kbn.order_date_desc')) {
					$select->order_by('order_jnl.ordered_at', 'desc'); // 注文日時
				}
			}
			return $select->execute()->as_array();
		}

		private static function get_download_datas_select($select, $order_ids) {
			$select->from('order_jnl')
				   ->where('order_jnl.id', 'in', $order_ids)
				   ->join('users', 'left')
					->on('users.id', '=', 'order_jnl.user_id')
				   ->join('order_bill_jnl', 'left')
					->on('order_bill_jnl.id', '=', 'order_jnl.id')
				   ->join('send_jnl', 'left')
					->on('send_jnl.order_id', '=', 'order_jnl.id');
		}

		public static function delete_order_lists($user_id, $order_id) {
			$count = DB::delete('order_jnl')
					->where('id', $order_id)
					->and_where('user_id', $user_id)
					->execute();
			if($count > 0) {
				DB::delete('order_detail')
						->where('order_id', $order_id)
						->execute();
			}
		}

		public static function select_balance_deposit() {
			$result  = \DB::query(
							'SELECT A.user_id, SUM(A.amount - ifnull(B.amount, 0) - ifnull(C.amount, 0)) AS amount ' .
							'FROM ( ' .
							'  SELECT user_id, SUM(sum_price - sum_tax - product_price - commission - national_delivery_fee - international_delivery_fee - sum_send_directly_price - option_price) AS amount ' .
							'  FROM order_jnl WHERE order_status = ' . Config::get('constant.order_status.kbn.finish') . ' ' .
							'  GROUP BY user_id ' .
							') A ' .
							'LEFT JOIN ( ' .
							' SELECT user_id, SUM(amount)*0.03846153846153846153846153846154 AS amount ' .
							' FROM deposit_jnl ' .
							' WHERE commission = 0 AND payer_name = "' . Config::get('constant.balance_adjust.payer_name') . '" ' .
							' GROUP BY user_id ' .
							') B ON ' .
							'B.user_id = A.user_id ' .
							'LEFT JOIN ( ' .
							' SELECT user_id, SUM(CASE deposit_kbn WHEN ' . Config::get('constant.deposit_status.kbn.pay') . ' THEN -amount ELSE amount END) AS amount ' .
							' FROM deposit_jnl ' .
							' WHERE payer_name = "' . Config::get('constant.balance_adjust.payer_name_adjust') . '" ' .
							' GROUP BY user_id ' .
							') C ON ' .
							'C.user_id = A.user_id ' .
							'GROUP BY user_id ' .
							'HAVING ABS(amount) >= 1 ')
						->execute();
			return $result->as_array();
		}
		
		public static function select_min_order_date($order_id) {
			$result = \DB::query(
							'select MIN(A.order_date) as mindate from order_detail A ' .
							'where A.order_id = ' .$order_id . '' )
					  ->execute();
			return $result->as_array();
		}
	}