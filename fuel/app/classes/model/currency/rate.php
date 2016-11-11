<?php
	class Model_Currency_Rate extends Orm\Model {
		protected static $_table_name = 'currency_rate';
		protected static $_properties = array (
			'id',
			'rate',
			'updated_at',
		);
		protected static $_primary_key = array (
			'id',
		);
		protected static $_observers = array(
			'Orm\\Observer_UpdatedAt' => array(
					'events' => array('before_save'),
					'mysql_timestamp' => true,
			),
		);

		public static function select_primary() {
			return Model_Currency_Rate::find('cny_jpy');
		}
	}