<?php
	class Model_International_Delivery_Fee extends Orm\Model {
		protected static $_table_name = 'international_delivery_fee';
		protected static $_properties = array (
			'delivery_id',
			'weight_min',
			'weight_max',
			'delivery_fee_cny',
			'delivery_fee_slope',
		);
		protected static $_primary_key = array (
			'delivery_id',
			'weight_min',
		);

		public static function get_delivery_fees($weight, $delivery_id) {
			$query = "SELECT * FROM international_delivery_fee WHERE weight_min < " . $weight . 
					 " AND weight_max >= " . $weight . " AND delivery_id = " . $delivery_id . 
					 " UNION ALL SELECT * FROM international_delivery_fee WHERE delivery_id = " . $delivery_id . 
					 " AND weight_min = (SELECT MIN(weight_min) FROM international_delivery_fee WHERE delivery_id = " . $delivery_id . 
					 " AND weight_min >= " . $weight . ")";
			$select = DB::query($query);
			$result = $select->execute();
			return $result->as_array();
		}
	}