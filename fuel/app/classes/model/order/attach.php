<?php
	class Model_Order_Attach extends Orm\Model {
		protected static $_table_name = 'order_attach';
		protected static $_properties = array (
			'id',
			'order_id',
			'user_id',
			'upload_user',
			'file_name',
			'file_type',
			'file_data',
			'note',
			'created_at',
		);
		protected static $_primary_key = array (
			'id',
		);
		protected static $_observers = array(
	        'Orm\Observer_CreatedAt' => array(
	            'events' => array('before_insert'),
	            'mysql_timestamp' => true,
	        ),
	    );
		public static function select_primary($attach_id) {
			return Model_Order_Attach::find($attach_id);
		}

		public static function select_primary_admin_by_order_id($order_id) {
			return Model_Order_Attach::find('all', array(
				'where' => array(
					array('order_id', $order_id),
				),
				'order_by' => array('created_at' => 'desc'),
			));
		}

		public static function select_primary_by_user_id($user_id, $attach_id) {
			return Model_Order_Attach::find('first', array(
				'where' => array(
					array('id', $attach_id),
					array('user_id', $user_id),
				)
			));
		}

		public static function insert_attach($order_id, $user_id, $upload_user, $file) {
			$props = array(
				'order_id'    => $order_id,
				'user_id'     => $user_id,
				'upload_user' => $upload_user,
				'file_name'   => $file['name'],
				'file_type'   => $file['mimetype'],
				'file_data'   => file_get_contents($file['file']),
				'note'        => '',
			);
			$entry = Model_Order_Attach::forge()->set($props);
			$entry->save();
			return $entry->id;
		}

		public static function delete_order_attach($id) {
			DB::delete('order_attach')
				->where('id', $id)
				->execute();
		}
	}