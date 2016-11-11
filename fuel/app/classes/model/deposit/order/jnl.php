<?php
	class Model_Deposit_Order_Jnl extends Orm\Model {
		protected static $_table_name = 'deposit_order_jnl';
		protected static $_properties = array (
			'deposit_order_id',
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
			'deposit_order_id',
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

		public static function select_primary_admin($deposit_order_id) {
			return Model_Deposit_Order_Jnl::find($deposit_order_id);
		}

	    public static function insert_from_order($order) {
			$aft = Model_Deposit_Order_Jnl::forge($order->to_array());
			if(!$aft->save()) { // bool
				throw new FuelException('入出金ヘッダの更新に失敗しました。');
			}
			return $aft;
		}
	}