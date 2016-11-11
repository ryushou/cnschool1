<?php
	class Model_User_Pre extends Orm\Model {
		protected static $_table_name = 'user_pre';
		protected static $_properties = array (
			'email',
			'send_flg',
			'finish_flg',
		);
		protected static $_primary_key = array (
			'email',
		);

		public static function select_not_send_list($limit) {
			$entry = Model_User_Pre::find('all', array(
				'where' => array(
					array('send_flg', 0),
				),
				'limit' => $limit,
			));
			return $entry;
		}

		public static function select_primary($email) {
			return Model_User_Pre::find($email);
		}

		public static function insert($email) {
			$props = array(
				'email' => $email,
				'send_flg' => 0,
				'finish_flg' => 0,
			);
			$entry = new Model_User_Pre($props);
			return $entry->save();
		}
	}