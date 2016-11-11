<?php
	class Model_Users extends Orm\Model {
		protected static $_table_name = 'users';
		protected static $_properties = array (
			'id',
			'username',
			'password',
			'group',
			'email',
			'create_time',
			'last_login',
			'login_hash',
			'profile_fields',
			'created_at',
			'updated_at',
			'name',
			'skype_id',
			'chatwork_id',
			'deposit',
			'member_rank',
			'payers_id',
			'order_detail_count',
		);
		protected static $_primary_key = array (
			'id',
		);
		protected static $_observers = array(
			'Orm\Observer_CreatedAt' => array (
				'events' => array('before_insert'),
				'mysql_timestamp' => true,
			),
			'Orm\Observer_UpdatedAt' => array (
				'events' => array('before_save'),
				'mysql_timestamp' => true,
			),
		);

		public static function select_primary($user_id) {
			return Model_Users::find($user_id);
		}

		public static function select_by_email($email) {
			return Model_Users::find('first', array(
				'where' => array(
					array('email', $email),
				)
			));
		}

		public static function select_for_update_primary($user_id) {
			$query = DB::select_array(Model_Users::$_properties)
					->from(Model_Users::$_table_name)
					->where('id', $user_id);

			$result = DB::query($query->compile() . ' FOR UPDATE')
						->execute();

			if($result) {
				return Model_Users::forge($result->current(), false);
			} else {
				return false;
			}
		}

		public static function get_users_by_group($group) {
			return Model_Users::find('all', array(
				'where' => array(
					array('group', 'in', $group),
				)
			));
		}

		public static function get_users_count($search) {
			$select = DB::select(DB::expr('COUNT(*) as count'));
			Model_Users::get_users_select($select, $search);
			return $select->execute()->current()['count'];
		}

		public static function get_users_lists($search, $pagination) {
			$select_fields = array('id', 'email', 'profile_fields', 'name', 'skype_id', 'chatwork_id', 'deposit', 'member_rank');

			$select = DB::select_array($select_fields);
			Model_Users::get_users_select($select, $search);

			if($search['order_by'] == Config::get('constant.list_order_by.kbn.asc')) {
				$order_by = 'asc';
			} else {
				$order_by = 'desc';
			}
			if($search['order'] == Config::get('constant.admin_user_list_order.kbn.id')) {
				$order_field = 'id';
			} else {
				$order_field = Config::get('constant.admin_user_list_order.kbn.none');
			}
			$result = $select->order_by($order_field, $order_by)
						->limit($pagination->per_page)
						->offset($pagination->offset);

			return $select->execute()->as_array();
		}

		private static function get_users_select($select, $search) {
			$is_user_id     = !Utility::is_empty($search['user_id']);
			$is_name        = !Utility::is_empty($search['name']);
			$is_member_rank = !Utility::is_empty($search['member_rank']);
			$is_skype       = !Utility::is_empty($search['skype']);
			$is_chatwork    = !Utility::is_empty($search['chatwork']);
			$is_search_untransact = !Utility::is_empty($search['untransact']);

			$select = $select->from('users');
			$select = $select->where('group', 'in', Config::get('constant.user_group.kbn'));

			if($is_user_id) {
				$select = $select->and_where('id', $search['user_id']);
			}
			if($is_name) {
				Utility::query_likes($select, 'name', $search['name']);
			}
			if($is_member_rank) {
				$select = $select->and_where('member_rank', $search['member_rank']);
			}
			if($is_skype) {
				Utility::query_likes($select, 'skype_id', $search['skype']);
			}
			if($is_chatwork) {
				Utility::query_likes($select, 'chatwork_id', $search['chatwork']);
			}
			if($is_search_untransact) {
				$select = $select->and_where('deposit', '<', DB::expr(0));
			}
		}

		public static function delete_user($user_id) {
			DB::delete('users')
				->where('id', $user_id)
				->execute();
		}
	}