<?php

class MyValidation {
	public static function _validation_table_exclude_unique($val, $table, $field, $exclude) {
		$select = DB::select(DB::expr('COUNT(*) as count'))
			->where($field, '=', $val);
		if($exclude != '') {
			$select = $select->and_where($field, '!=', $exclude);
		}
		return $select->from($table)
			->execute()
			->current()['count'] == 0;
	}

	public static function _validation_table_unique($val, $table, $field) {
		if($val != '') {
			return DB::select(DB::expr('COUNT(*) as count'))
				->where($field, '=', $val)
				->from($table)
				->execute()
				->current()['count'] == 0;
		} else {
			return true;
		}
	}

	public static function _validation_send_detail_exists($val, $table, $field) {
		return MyValidation::_validation_table_unique($val, $table, $field);
	}

	public static function _validation_table_values_in($val, $table, $field, $pk_field, $pk_value) {
		if($pk_value != '') {
			return DB::select(DB::expr('COUNT(*) as count'))
				->where($pk_field, '=', $pk_value)
				->and_where($field, 'in', $val)
				->from($table)
				->execute()
				->current()['count'] > 0;
		} else {
			return true;
		}
	}

	public static function _validation_order_sheet_delete_check($val) {
		return MyValidation::_validation_table_values_in(
			Config::get('constant.order_status_delete_enable'),
			'order_detail', 'detail_status', 'id', $val);
	}
}