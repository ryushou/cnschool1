<?php
	class Model_Commissions extends Orm\Model {
		protected static $_table_name = 'commissions';
		protected static $_properties = array (
			'rank',
			'name',
			'commission',
			'minimum_commission',
		);
		protected static $_primary_key = array (
			'rank',
		);

		public static function select_primary($rank) {
			return Model_Commissions::find($rank);
		}

		public static function get_free_commissions() {
			return Model_Commissions::find('all', array(
				'where' => array(
					array('commission', 0),
				),
			));
		}
	}