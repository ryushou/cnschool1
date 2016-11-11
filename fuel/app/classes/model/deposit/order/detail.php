<?php
	class Model_Deposit_Order_Detail extends Orm\Model {
		protected static $_table_name = 'deposit_order_detail';
		protected static $_properties = array (
			'deposit_order_id',
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
		);
		protected static $_primary_key = array (
			'deposit_order_id',
			'detail_no',
		);

		public static function get_order_list($user_id, $deposit_order_id) {
			return Model_Deposit_Order_Detail::find('all', array(
				'where' => array(
					array('deposit_order_id', $deposit_order_id),
					array('user_id', $user_id),
				),
				'order_by' => array('detail_no' => 'asc'),
			));
		}

		public static function insert_from_order($details, $deposit_order_id) {
			foreach ($details as $detail) {
				$aft = Model_Deposit_Order_Detail::forge($detail->to_array());
				$aft->deposit_order_id = $deposit_order_id;
				if(!$aft->save()) { // bool
					throw new FuelException('入出金明細の更新に失敗しました。');
				}
			}
		}
	}