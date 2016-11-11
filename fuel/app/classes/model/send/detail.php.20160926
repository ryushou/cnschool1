<?php
	class Model_Send_Detail extends Orm\Model {
		protected static $_table_name = 'send_detail';
		protected static $_properties = array (
			'id',
			'send_id',
			'user_id',
			'order_id',
			'order_detail_id',
			'product_name',
			'amount',
			'unit_price',
			'product_price',
		);
		protected static $_primary_key = array (
			'id',
		);

		public static function select_primary($send_id, $detail_id) {
			return Model_Send_Detail::find('first', array(
				'where' => array(
					array('send_id', $send_id),
					array('order_detail_id', $detail_id),
				)
			));
		}

		public static function select_primary_admin($send_detail_id) {
			return Model_Send_Detail::find($send_detail_id);
		}

		public static function get_order_detail_ids($send_id) {
			$select = DB::select('order_detail_id');
			$select = $select->from('send_detail');
			$select = $select->where('send_id', '=', $send_id);
			return $select->execute()->as_array();
		}

		public static function get_send_detail_amounts($order_id, $detail_id, $send_id = '') {
			$select_fields = array('order_detail.real_amount', DB::expr('IFNULL(SUM(send_detail.amount), 0) as input_amount'));

			$select = DB::select_array($select_fields);
			$select = $select->from('send_detail');
			$select = $select->join('order_detail', 'inner')
							 ->on('order_detail.id', '=', 'send_detail.order_detail_id');
			$select = $select->where('send_detail.order_id', '=', $order_id);
			$select = $select->and_where('send_detail.order_detail_id', '=', $detail_id);
			if(!Utility::is_empty($send_id)) {
				$select = $select->and_where('send_detail.id', '!=', $send_id);
			}

			return $select->execute()->current();
		}

		public static function delete_send_detail($send_id) {
			DB::delete('send_detail')
				->where('send_id', $send_id)
				->execute();
		}

		public static function delete_send_detail_by_id($send_detail_id) {
			DB::delete('send_detail')
				->where('id', $send_detail_id)
				->execute();
		}
	}