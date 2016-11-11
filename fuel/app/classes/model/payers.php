<?php
	class Model_Payers extends Orm\Model {
		protected static $_table_name = 'payers';
		protected static $_properties = array (
			'id',
			'payer_name',
			'payer_url',
			'payer_commission',
		);
		protected static $_primary_key = array (
			'id',
		);

		public static function select_primary($payer_id) {
			return Model_Payers::find($payer_id);
		}

		public static function get_payer_lists() {
			return Model_Payers::find('all', array(
				'order_by' => array('id' => 'asc'),
			));
		}

		public static function delete_payer($payer_id) {
			$count = DB::delete('payers')
					->where('id', $payer_id)
					->execute();
		}
	}