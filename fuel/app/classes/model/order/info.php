<?php
	class Model_Order_Info extends Orm\Model {
		protected static $_table_name = 'order_info';
		protected static $_properties = array (
			'id',
			'order_id',
			'user_id',
			'info_kbn',
			'content',
			'note',
			'target_at',
			'created_at',
			'updated_at',
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

		public static function select_primary($user_id, $id) {
			return Model_Order_Info::find('first', array(
				'where' => array(
					array('id', $id),
					array('user_id', $user_id),
				)
			));
		}

		public static function select_primary_admin($id) {
			return Model_Order_Info::find($id);
		}

		public static function select_primary_admin_by_order_id($order_id) {
			return Model_Order_Info::find('all', array(
				'where' => array(
					array('order_id', $order_id),
				),
				'order_by' => array('info_kbn' => 'asc', 'target_at' => 'desc'),
			));
		}

		public static function delete_order_info($id) {
			DB::delete('order_info')
				->where('id', $id)
				->execute();
		}
	}