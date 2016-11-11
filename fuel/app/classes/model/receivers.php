<?php
	class Model_Receivers extends Orm\Model {
		protected static $_table_name = 'receivers';
		protected static $_properties = array (
			'id',
			'user_id',
			'fba_flg',
			'receiver',
			'zip1',
			'zip2',
			'address1',
			'address2',
			'phone',
			'name',
		);
		protected static $_primary_key = array (
			'id',
		);

		public static function select_primary($user_id, $receiver_id) {
			return Model_Receivers::find('first', array(
				'where' => array(
					array('id', $receiver_id),
					array('user_id', $user_id),
				)
			));
		}

		public static function get_receiver_lists($user_id) {
			return Model_Receivers::find('all', array(
				'where' => array(
					array('user_id', $user_id),
				),
				'order_by' => array('id' => 'desc'),
			));
		}

		public static function delete_receiver($user_id, $receiver_id) {
			$count = DB::delete('receivers')
					->where('id', $receiver_id)
					->and_where('user_id', $user_id)
					->execute();
		}
	}