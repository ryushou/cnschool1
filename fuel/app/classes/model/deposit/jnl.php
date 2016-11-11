<?php
	class Model_Deposit_Jnl extends Orm\Model {
		protected static $_table_name = 'deposit_jnl';
		protected static $_properties = array (
			'id',
			'created_at',
			'user_id',
			'order_id',
			'deposit_order_id',
			'deposit_kbn',
			'reason',
			'amount',
			'commission',
			'payer_name',
			'deposit',
			'note',
			'cny_jpy_rate',
		);
		protected static $_primary_key = array (
			'id',
		);
		protected static $_observers = array(
			'Orm\Observer_CreatedAt' => array (
				'events' => array('before_insert'),
				'mysql_timestamp' => true,
			),
		);

		public static function select_primary_admin($id) {
			return Model_Deposit_Jnl::find($id);
		}

		public static function select_primary_admin_before($id, $user_id) {
			return Model_Deposit_Jnl::find('first', array(
				'where' => array(
					array('id', '<', $id),
					array('user_id', $user_id),
					array('reason', Config::get('constant.balance_adjust.reason')),
				),
				'order_by' => array('created_at' => 'desc'),
			));
		}

		public static function select_by_user_id($user_id) {
			return Model_Deposit_Jnl::find('all', array(
				'where' => array(
					array('user_id', $user_id),
				),
				'order_by' => array('created_at' => 'desc'),
			));
		}

		public static function select_by_history_day($deposit_history_day) {
			$select_fields = array('deposit_jnl.created_at', 'deposit_jnl.user_id', 'users.name', 
				'deposit_jnl.order_id', 'deposit_jnl.deposit_order_id', 'deposit_jnl.deposit_kbn', 
				'deposit_jnl.reason', 'deposit_jnl.amount', 'deposit_jnl.cny_jpy_rate', 'deposit_jnl.deposit', 
				'deposit_jnl.payer_name', 'deposit_jnl.note');

			$select = DB::select_array($select_fields)->from('deposit_jnl');
			$select = $select->join('users', 'inner')->on('users.id', '=', 'deposit_jnl.user_id');
			$select = $select->where('deposit_jnl.created_at', '>=', DB::expr('"' . date('Y-m-d', strtotime('-' . $deposit_history_day . ' day', time())) . '"'));
			$select = $select->order_by(DB::expr("DATE_FORMAT(`deposit_jnl`.`created_at`, '%Y-%m-%d')"), 'desc');
			$select = $select->order_by('deposit_jnl.user_id', 'asc');
			$select = $select->order_by('deposit_jnl.created_at', 'desc');
			
			$result = $select->execute();
			return $result->as_array();
		}

		public static function get_deposit_history_count($user_id, $search) {
			$select = DB::select(DB::expr('COUNT(*) as count'));
			Model_Deposit_Jnl::get_deposit_history_select($select, $user_id, $search);
			return $select->execute()->current()['count'];
		}

		public static function get_deposit_history_lists($user_id, $search, $pagination) {
			$select_fields = array('id', 'created_at', 'deposit_order_id', 
				'order_id', 'deposit_kbn', 'reason', 'amount', 'deposit', 'payer_name', 'note', 'cny_jpy_rate');

			$select = DB::select_array($select_fields);
			Model_Deposit_Jnl::get_deposit_history_select($select, $user_id, $search);

			$result = $select->order_by('id', 'desc')
						->limit($pagination->per_page)
						->offset($pagination->offset);

			return $select->execute()->as_array();
		}

		private static function get_deposit_history_select($select, $user_id, $search) {
			$is_order_id = !Utility::is_empty($search['order_id']);

			$select = $select->from('deposit_jnl');
			$select = $select->where('user_id', $user_id);

			if($is_order_id) {
				$select = $select->and_where('order_id', $search['order_id']);
			}
		}

		public static function deposit_interface($user, $order_id, $deposit_kbn, $reason, $amount, $cny_jpy_rate) {
			if($deposit_kbn == Config::get('constant.deposit_status.kbn.receipt')) {
				$user->deposit += $amount;
			} else {
				$user->deposit -= $amount;
			}
			$user->save();

			if(!Utility::is_empty($order_id)) {
				$order = Model_Order_Jnl::select_primary_admin($order_id);
				$order_detail = Model_Order_Detail::get_order_list_admin($order->id);

				$entry = Model_Deposit_Order_Jnl::insert_from_order($order);
				Model_Deposit_Order_Detail::insert_from_order($order_detail, $entry->deposit_order_id);

				$deposit_order_id = $entry->deposit_order_id;
			} else {
				$deposit_order_id = 0;
			}
			$deposit              = Model_Deposit_Jnl::forge();
			$deposit->user_id     = $user->id;
			$deposit->order_id    = $order_id;
			$deposit->deposit_order_id = $deposit_order_id;
			$deposit->deposit_kbn = $deposit_kbn;
			$deposit->reason      = $reason;
			$deposit->amount      = $amount;
			$deposit->commission  = 0;
			$deposit->payer_name  = '';
			$deposit->deposit     = $user->deposit;
			$deposit->note        = '';
			$deposit->cny_jpy_rate = $cny_jpy_rate;
			$deposit->save();
		}
	}
