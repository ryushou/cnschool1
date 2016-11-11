<?php
	class Model_Images extends Orm\Model {
		protected static $_table_name = 'images';
		protected static $_properties = array (
			'id',
			'user_id',
			'file_name',
			'file_type',
			'file_data',
			'created_at',
		);
		protected static $_primary_key = array (
			'id',
		);
		protected static $_observers = array(
			'Orm\Observer_CreatedAt' => array (
				'events' => array('before_insert'),
				'mysql_timestamp' => true,
			),
		);

		public static function select_primary($image_id) {
			return Model_Images::find($image_id);
		}

		public static function select_primary_by_user_id($image_id, $user_id) {
			return Model_Images::find('first', array(
				'where' => array(
					array('id', $image_id),
					array('user_id', $user_id),
				)
			));
		}

		public static function insert_image($user_id, $file) {
			$file['file'] = file_get_contents($file['file']);
			return Model_Images::insert_image_direct($user_id, $file);
		}

		public static function insert_image_direct($user_id, $file) {
			$props = array(
				'user_id'     => $user_id,
				'file_name'   => $file['name'],
				'file_type'   => $file['mimetype'],
				'file_data'   => $file['file'],
				'ext'         => $file['extension'],
			);
			$entry = Model_Images::forge()->set($props);
			$entry->save();
			return $entry->id;
		}

		public static function delete_images_task() {
			$result  = \DB::query(
							'DELETE FROM images ' .
							'WHERE created_at < (NOW() -INTERVAL 7 DAY) ' .
							'  AND NOT EXISTS (' .
							'    SELECT * FROM order_detail ' .
							'    WHERE order_detail.image_id = images.id ' .
							'      OR order_detail.image_id2 = images.id ' .
							'  ) ' .
							'  AND NOT EXISTS ( ' .
							'    SELECT * FROM order_bill_detail ' .
							'    WHERE order_bill_detail.image_id = images.id ' .
							'      OR order_bill_detail.image_id2 = images.id ' .
							'  ) ' .
							'  AND NOT EXISTS ( ' .
							'    SELECT * FROM deposit_order_detail ' .
							'    WHERE deposit_order_detail.image_id = images.id ' .
							'      OR deposit_order_detail.image_id2 = images.id ' .
							'  ) '
							)
						->execute();
		}
	}