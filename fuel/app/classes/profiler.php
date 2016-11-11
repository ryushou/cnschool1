<?php 

class Profiler extends \Fuel\Core\Profiler
{
	private static $is_ajax = false;

    public static function init()
	{
		if (\Input::is_ajax() and ! static::$profiler)
		{
			static::$profiler = new PhpQuickProfiler(FUEL_START_TIME);
			static::$profiler->queries = array();
			static::$profiler->queryCount = 0;
			static::$profiler->db = static::$profiler;
			static::$is_ajax = true;
			\Fuel::$profiling = true;
		}
		else
		{
			parent::init();
		}
	}

	public static function get_execute_query()
	{
		if (static::$is_ajax && static::$profiler)
		{
			static::$profiler->gatherQueryData();
			return static::get_query_format(static::$profiler->output);
		}
		else
		{
			return '';
		}
	}

	private static function get_query_format($output) {
		$return_output = '';

		// ↓コピペして持ってきただけ
		// phpQuickProfiler => displayPqp
		$class = '';
		foreach($output['queries'] as $query) {
			$return_output .='<tr>
				<td class="'.$class.'">'.$query['sql'];
			$return_output .='<em>';
			$return_output .='Speed: <b>'.$query['time'].'</b>';
			$query['duplicate'] and $return_output .=' &middot; <b>DUPLICATE</b>';
			if(isset($query['explain'])) {
				$return_output .= '<br />Query analysis:';
				foreach($query['explain'] as $qe)
				{
					isset($qe['select_type']) and $return_output .='<br /> &middot; Query: <b>'.$qe['select_type'].'</b>';
					empty($qe['table']) or $return_output .=' on <b>'.htmlentities($qe['table']).'</b>';
					isset($qe['possible_keys']) and $return_output .=' &middot; Possible keys: <b>'.$qe['possible_keys'].'</b>';
					isset($qe['key']) and $return_output .=' &middot; Key Used: <b>'.$qe['key'].'</b>';
					isset($qe['type']) and $return_output .=' &middot; Type: <b>'.$qe['type'].'</b>';
					isset($qe['rows']) and $return_output .=' &middot; Rows: <b>'.$qe['rows'].'</b>';
					empty($qe['Extra']) or $return_output .=' ('.$qe['Extra'].')';
//					$return_output .='<br />';
				}
			}
			if ( ! empty($query['stacktrace']))
			{
				$return_output .='<br />Call trace for this query:</em>';
				foreach ($query['stacktrace'] as $st)
				{
					$return_output .='<em>File: <b>'.$st['file'].'</b>, line <b>'.$st['line'].'</b></em>';
				}
			}
			else
			{
				$return_output .='</em>';
			}
			$return_output .='</td></tr>';
			if($class == '') $class = 'pqp-alt';
			else $class = '';
		}
		return $return_output;
	}
}