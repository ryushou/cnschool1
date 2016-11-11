<?php
	class Model_Order_Bill_Detail extends Orm\Model {
		protected static $_table_name = 'order_bill_detail';
		protected static $_properties = array (
			'id',
			'order_id',
			'user_id',
			'detail_no',
			'supplier_url1',
			'supplier_url2',
			'supplier_url3',
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
			'id',
		);

		// public static function select_primary($user_id, $detail_id) {
		// 	return Model_Order_Bill_Detail::find('first', array(
		// 		'where' => array(
		// 			array('id', $detail_id),
		// 			array('user_id', $user_id),
		// 		)
		// 	));
		// }

		public static function insert_from_order($details) {
			foreach ($details as $detail) {
				$aft = Model_Order_Bill_Detail::forge($detail->to_array());
				if(!$aft->save()) { // bool
					throw new FuelException('請求明細の更新に失敗しました。');
				}
			}
		}

		public static function delete_bill($order_id) {
			return DB::delete(Model_Order_Bill_Detail::$_table_name)
						->where('order_id', $order_id)
						->execute();
		}
	}