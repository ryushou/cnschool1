<?php
	class Model_Order_Bill_Jnl extends Orm\Model {
		protected static $_table_name = 'order_bill_jnl';
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
			'temp_settle_flg',
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
			return Model_Order_Bill_Jnl::find('first', array(
				'where' => array(
					array('id', $order_id),
					array('user_id', $user_id),
				)
			));
		}

		public static function select_primary_admin($order_id) {
			return Model_Order_Bill_Jnl::find($order_id);
		}

	    public static function insert_from_order($order) {
			$aft = Model_Order_Bill_Jnl::forge($order->to_array());
			if(!$aft->save()) { // bool
				throw new FuelException('請求ヘッダの更新に失敗しました。');
			}
		}

		public static function delete_bill($user_id, $order_id) {
			$count = DB::delete(Model_Order_Bill_Jnl::$_table_name)
					->where('id', $order_id)
					->and_where('user_id', $user_id)
					->execute();
			if($count > 0) {
				Model_Order_Bill_Detail::delete_bill($order_id);
			}
		}
	}