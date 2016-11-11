<?php
	class Model_Order_Detail extends Orm\Model {
		protected static $_table_name = 'order_detail';
		protected static $_properties = array (
			'id',
			'order_id',
			'user_id',
			'detail_no',
			'supplier_url1',
			'url1_checked_flg',
			'supplier_url2',
			'url2_checked_flg',
			'supplier_url3',
			'url3_checked_flg',
			'image_id',
			'image_id2',
			'valiation',
			'demand',
			'request_amount',
			'real_amount',
			'china_price',
			'japan_price',
			'commission',
			'national_delivery_fee',
			'national_delivery_fee_yen',
			'product_price',
			'send_directly_box',
			'fba_barcode_flg',
			'opp_packing_flg',
			'other_option1_label',
			'other_option1_amount',
			'other_option1_unit_price',
			'other_option2_label',
			'other_option2_amount',
			'other_option2_unit_price',
			'other_option3_label',
			'other_option3_amount',
			'other_option3_unit_price',
			'other_option4_label',
			'other_option4_amount',
			'other_option4_unit_price',
			'other_option5_label',
			'other_option5_amount',
			'other_option5_unit_price',
			'other_option6_label',
			'other_option6_amount',
			'other_option6_unit_price',
			'other_option7_label',
			'other_option7_amount',
			'other_option7_unit_price',
			'subtotal_price',
			'send_company',
			'send_no',
			'send_status',
			'order_date',
			'receive_date',
			'detail_status',
			'admin_message',
			'sku',
		//order_date
		    'order_date',
		//admin_message2    
		    'admin_message2'
		);
		protected static $_primary_key = array (
			'id',
		);

		public static function select_primary($user_id, $detail_id) {
			return Model_Order_Detail::find('first', array(
				'where' => array(
					array('id', $detail_id),
					array('user_id', $user_id),
				)
			));
		}

		public static function select_primary_admin($detail_id) {
			return Model_Order_Detail::find($detail_id);
		}

		public static function get_order_list($user_id, $order_id) {
			return Model_Order_Detail::find('all', array(
				'where' => array(
					array('order_id', $order_id),
					array('user_id', $user_id),
				),
				'order_by' => array('detail_no' => 'asc'),
			));
		}

		public static function get_order_list_admin($order_id) {
			return Model_Order_Detail::find('all', array(
				'where' => array(
					array('order_id', $order_id),
				),
				'order_by' => array('detail_no' => 'asc'),
			));
		}

		public static function select_primaries($order_id, $detail_ids) {
			return Model_Order_Detail::find('all', array(
				'where' => array(
					array('id', 'in', $detail_ids),
					array('order_id', '=', $order_id),
				),
				'order_by' => array('detail_no' => 'asc'),
			));
		}

		public static function get_order_ids_user_history_lists($user_id, $search) {
			$select = DB::select('order_detail.id')
						->from('order_detail')
						->where('order_detail.user_id', $user_id);

			if(!Utility::is_empty($search['order_id'])) {
				$select = $select->and_where('order_detail.order_id', $search['order_id']);
			}
			if(!Utility::is_empty($search['valiation'])) {
				Utility::query_likes($select, 'order_detail.valiation', $search['valiation']);
			}
			if(!Utility::is_empty($search['sku'])) {
				Utility::query_likes($select, 'order_detail.sku', $search['sku']);
			}
			return $select->execute()->as_array();
		}

		public static function get_user_history_lists_count($user_id, $detail_ids) {
			$select = DB::select(DB::expr('COUNT(*) as count'));
			Model_Order_Detail::get_user_history_lists_select($select, $user_id, $detail_ids);
			return $select->execute()->current()['count'];
		}

		public static function get_user_history_lists($user_id, $detail_ids, $pagination) {
			$select_fields = array('order_detail.id', 'order_detail.order_id', 'order_detail.detail_no',
								   'order_detail.image_id', 'order_detail.valiation', 'order_detail.sku',
								   'order_detail.japan_price', 'order_detail.request_amount', 'order_detail.real_amount');

			$select = DB::select_array($select_fields);
			Model_Order_Detail::get_user_history_lists_select($select, $user_id, $detail_ids);

			$result = $select->order_by('order_detail.order_id', 'desc')
						->order_by('order_detail.id', 'asc')
						->limit($pagination->per_page)
						->offset($pagination->offset);

			return $select->execute()->as_array();
		}

		private static function get_user_history_lists_select($select, $user_id, $detail_ids) {
			$select->from('order_detail')
					->where('order_detail.id', 'in', $detail_ids)
					->and_where('order_detail.user_id', $user_id);
		}

		public static function get_all_data_download_datas() {
			$select_fields = array('order_jnl.ordered_at', 'order_detail.user_id', 'order_jnl.order_kbn', 'users.name', 
				'order_detail.order_id', 'order_detail.detail_no', 'order_detail.detail_status', 
				'order_detail.real_amount', 'order_detail.china_price', 'order_detail.national_delivery_fee');

			$select = DB::select_array($select_fields)->from('order_detail');

			$order_status_from = Config::get('constant.order_status.kbn.buy');
			Utility::query_between($select, 'order_detail.detail_status', $order_status_from, '');

			$select->where('order_detail.detail_status', '!=', Config::get('constant.order_status.kbn.temporary'));

			$select->join('order_jnl', 'inner')->on('order_jnl.id', '=', 'order_detail.order_id');
			$select->join('users', 'inner')->on('users.id', '=', 'order_detail.user_id');
			$select->order_by(DB::expr("DATE_FORMAT(`order_jnl`.`ordered_at`, '%Y-%m-%d')"), 'desc');
			$select->order_by('order_detail.user_id', 'asc');
			$select->order_by('order_detail.order_id', 'desc');
			$select->order_by('order_detail.detail_no', 'asc');

			$result = $select->execute();
			return $result->as_array();
		}

		public static function select_send_is_valid($order_id) {
			$select_fields = array('order_detail.order_id', 'order_detail.detail_no', 
								   'order_detail.real_amount', DB::expr('SUM(IFNULL(send_detail.amount,0))'));

			$select = DB::select_array($select_fields)->from('order_detail')
													  ->join('send_detail', 'left')
													  ->on('send_detail.order_detail_id', '=', 'order_detail.id')
													  ->where('order_detail.order_id', $order_id)
													  ->group_by('order_detail.id')
													  ->having(DB::expr('SUM(IFNULL(send_detail.amount,0)) - order_detail.real_amount'), '!=', 0);
			$result = $select->execute();
			return $result->as_array();
		}

	}