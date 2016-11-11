<?php
	class Model_Mail_Queue extends Orm\Model {
		protected static $_table_name = 'mail_queue';
		protected static $_properties = array (
			'id',
			'created_at',
			'sended_at',
			'send_flg',
			'retry_count',
			'error_message',
			'from',
			'from_name',
			'to',
			'to_name',
			'reply_to',
			'reply_to_name',
			'subject',
			'body',
		);
		protected static $_primary_key = array (
			'id',
		);
		protected static $_observers = array(
	        'Orm\Observer_CreatedAt' => array(
	            'events' => array('before_insert'),
	            'mysql_timestamp' => true,
	        ),
	    );

		public static function get_unsent_list($limit = 5) {
			return Model_Mail_Queue::find('all', array(
				'where' => array(
					array('send_flg', Config::get('constant.send_mail.send_flg.kbn.unsent')),
				),
				'limit' => $limit,
				'from_cache' => false,
			));
		}

	    public static function insert_entry($entry) {
	    	$entry->sended_at     = '';
	    	$entry->send_flg      = Config::get('constant.send_mail.send_flg.kbn.unsent');
	    	$entry->retry_count   = 0;
	    	$entry->error_message = '';
			if($entry->to_name == null) {
				$entry->to_name = '';
			}
			if($entry->from == null) {
				$entry->from = Config::get('constant.send_mail.from');
			}
			if($entry->from_name == null) {
				$entry->from_name = Config::get('constant.send_mail.from_name');
			}
			if($entry->reply_to == null) {
				$entry->reply_to = Config::get('constant.send_mail.reply_to');
			}
			if($entry->reply_to_name == null) {
				$entry->reply_to_name = Config::get('constant.send_mail.reply_to_name');
			}
			if(!Utility::is_empty($entry->subject)) {
				$entry->subject = Config::get('constant.send_mail.subject.prefix') . $entry->subject;
			}
			$entry->body = Utility::mb_str_replace('%site_url%', Uri::base(false), $entry->body);
			$entry->save();
	    }
	}