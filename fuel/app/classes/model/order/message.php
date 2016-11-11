<?php
	class Model_Order_Message extends Orm\Model {
		protected static $_table_name = 'order_message';
		protected static $_properties = array (
			'id',
			'order_id',
			'user_id',
			'created_at',
			'updated_at',
			'message',
			'readed_flg',
			'readed_at',
		);
		protected static $_primary_key = array (
			'id',
		);
		protected static $_observers = array(
			'Orm\Observer_CreatedAt' => array (
				'events' => array('before_insert'),
				'mysql_timestamp' => true,
			),
			'Orm\Observer_UpdatedAt' => array (
				'events' => array('before_save'),
				'mysql_timestamp' => true,
			),
		);
		protected static $_belongs_to = array(
			'users' => array(
				'model_to' => 'Model_Users',
				'key_from' => 'user_id',
				'key_to' => 'id',
				'cascade_save' => false,
				'cascade_delete' => false
			)
		);

		public static function select_by_order($order_id) {
			return Model_Order_Message::find('all', array(
				'related' => array(
					'users' => array()
				),
				'where' => array(
					array('order_id', $order_id),
				),
				'order_by' => array('created_at' => 'desc'),
			));
		}

		public static function select_unread_count($order_id) {
			return Model_Order_Message::query()->where(
					array(
						array('order_id', $order_id),
						array('user_id', '!=', Utility::get_user_id()),
						array('readed_flg', '=', Config::get('constant.order_message.kbn.unread')),
					)
				)->count();
		}
	}