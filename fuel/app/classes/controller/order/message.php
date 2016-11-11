<?php

class Controller_Order_Message extends Controller_Template {

	public $template = 'template/template';

	public function before() {
		parent::before();
		if(!Auth::has_access('order.message') && !Auth::has_access('web.menu')) {
			Response::redirect('base/timeout');
		}
	}

	public function action_index() {
		$order_id = Input::get('id');
		$order = Model_Order_Jnl::select_primary_admin($order_id);
		if(!$order) {
			Response::redirect('base/timeout');
		}
		if(!Auth::has_access('order.message')) {
			$user_id = Utility::get_user_id();
			if($order->user_id != $user_id) {
				Response::redirect('base/timeout');
			}
		}
		$user_id = Utility::get_user_id();
		$messages = Model_Order_Message::select_by_order($order->id);
		foreach ($messages as $message) {
			if($message->user_id != $user_id
				&& $message->readed_flg == Config::get('constant.order_message.kbn.unread')) {
				$message->readed_flg = Config::get('constant.order_message.kbn.readed');
				$message->readed_at = Utility::get_datetime_now();
				$message->save();
			}
		}
		$this->template->title = '注文メッセージ履歴';
		$this->template->content = View::forge('order/message');
		$this->template->content->set_safe('messages', $messages);
	}

	public function action_delete_message() {
		$message = Model_Order_Message::find(Input::post('message_id'));
		if($message->user_id != Utility::get_user_id()) {
			return json_encode(array(
				'error' => 'メッセージは削除できません。',
				'info' => ''
			));
		}
		$message->delete();

		return json_encode(array(
			'error' => '',
			'info' => 'メッセージを削除しました。',
			'reload' => 500,
		));
	}

	private function validate_send_message() {
		$validation = Validation::forge();
		$validation->add('contact_note', 'お問い合わせメモ')
			->add_rule('required')
			->add_rule('max_length', 150);
		$validation->run();
		return $validation;
	}

	public function action_send_message() {
		$validation = $this->validate_send_message();
		$errors = $validation->error();
		if (!empty($errors)) {
			return json_encode(array(
				'error' => $validation->show_errors(),
				'info' => ''
			));
		}
		$order = Model_Order_Jnl::select_primary_admin(Input::post('order_id'));
		if(!$order) {
			return json_encode(array(
				'error' => '注文が存在しません。',
				'info' => ''
			));
		}
		if(!Auth::has_access('order.message')) {
			$user_id = Utility::get_user_id();
			if($order->user_id != $user_id) {
				return json_encode(array(
					'error' => '注文が存在しません。',
					'info' => ''
				));
			}
		}
		$contact_note = Input::post('contact_note');

		$message = Model_Order_Message::forge();
		$message->order_id   = $order->id;
		$message->user_id    = Utility::get_user_id();
		$message->message    = $contact_note;
		$message->readed_flg = Config::get('constant.order_message.kbn.unread');
		$message->readed_at  = '';
		$message->save();

		if($message->users->group != Config::get('constant.user_group.kbn.user')) {
			$user = Model_Users::select_primary($order->user_id);
			$this->send_notify_mail($user->email, $user->name, $order->id, $contact_note);
		}

		return json_encode(array(
			'error' => '',
			'info' => 'メッセージを送信しました。',
		));
	}

	private function send_notify_mail($email, $name, $order_id, $message){
		$body = Utility::get_mail_template('template_order_message.txt');
		$body = Utility::mb_str_replace('%message%', $message, $body);
		$body = Utility::mb_str_replace('%order_id%', $order_id, $body);
		$body = Utility::mb_str_replace('%date%', Utility::get_datetime_now(), $body);

		$entry = Model_Mail_Queue::forge();
		$entry->to      = $email;
		$entry->to_name = $name . '様';
		$entry->subject = '注文シートにメッセージが届きました';
		$entry->body    = $body;
		Model_Mail_Queue::insert_entry($entry);
    }
}
