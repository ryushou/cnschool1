<?php
	class Model_Access_Logs extends Orm\Model {
		protected static $_table_name = 'access_logs';
		protected static $_properties = array (
			'id',
			'user_id',
			'create_at',
			'uri',
			'request',
			'ip',
			'host',
		);
		protected static $_primary_key = array (
			'id',
		);

		public static function insert_access_logs($user_id, $uri, $request, $ip, $host) {
			$props = array(
				'user_id' => $user_id,
				'uri' => $uri,
				'request' => $request,
				'ip' => $ip,
				'host' => $host,
			);
			$query = \DB::insert('access_logs')->set($props);
			$entry = \DB::query($query)->execute();
			return $entry;
		}
	}