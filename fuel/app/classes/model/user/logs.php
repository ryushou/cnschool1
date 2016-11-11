<?php
	class Model_User_Logs extends Orm\Model {
		protected static $_table_name = 'user_logs';
		protected static $_properties = array (
			'id',
			'user_id',
			'create_at',
			'screen_name',
			'log_level',
			'message_id',
			'value1',
			'value2',
			'value3',
		);
		protected static $_primary_key = array (
			'id',
		);

		public static function select_user_logs($user_id, $screen_name = '', $page_id) {
			$select = DB::select('id', 'create_at', 'screen_name', 'log_level', 'message_id', 'value1', 'value2', 'value3');
			$select = $select->from('user_logs');
			$select	= $select->where('user_id', $user_id);
			if($screen_name != ''){
				$select	= $select->and_where('screen_name', $screen_name);
			}
			$select = $select->order_by('create_at','desc');
			$select = $select->limit(100);
			$select = $select->offset(100 * ($page_id - 1));
			$result = $select->execute();
			return $result->as_array();
		}

		public static function insert_user_logs($user_id, $screen_name, $log_level, $message_id, $value1 = '', $value2 = '', $value3 = '') {
			$props = array(
			'user_id' => $user_id,
			'screen_name' => $screen_name,
			'log_level' => $log_level,
			'message_id' => $message_id,
			'value1' => $value1,
			'value2' => $value2,
			'value3' => $value3,
			);
			$query = \DB::insert('user_logs')->set($props);
			$entry = \DB::query($query)->execute();
			return $entry;
		}
	}