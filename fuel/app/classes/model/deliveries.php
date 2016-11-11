<?php
	class Model_Deliveries extends Orm\Model {
		protected static $_table_name = 'deliveries';
		protected static $_properties = array (
			'id',
			'name',
			'kbn',
		);
		protected static $_primary_key = array (
			'id',
		);

		public static function select_primary($deliver_id) {
			return Model_Deliveries::find($deliver_id);
		}

		public static function get_deliver_lists($kbn) {
			return Model_Deliveries::find('all', array(
				'where' => array(
					array('kbn', $kbn),
				),
				'order_by' => array('id' => 'asc'),
			));
		}

		public static function get_deliver_by_name($name) {
			return Model_Deliveries::find('first', array(
				'where' => array(
					array('name', $name),
				),
			));
		}

		public static function get_deliver_lists_all() {
			return Model_Deliveries::find('all', array(
				'order_by' => array('kbn' => 'asc', 'id' => 'asc'),
			));
		}

		public static function delete_deliver($deliver_id) {
			$count = DB::delete('deliveries')
					->where('id', $deliver_id)
					->execute();
		}
	}