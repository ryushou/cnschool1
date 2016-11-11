<?php

class Controller_Admin_Send_Input_Mail extends Controller_Template {

	public $template = 'template/template';

	public function before() {
		parent::before();
        if(!Auth::has_access('send.input')) {
			Response::redirect('base/timeout');
		}
    }

	public function action_send() {
		$send_id  = Input::post('send_id');
		$order_id = Input::post('order_id');
		$user_id  = Input::post('user_id');

		$user  = Model_Users::select_primary($user_id);
		$email = $user->email;
		$name  = $user->name;

		Controller_Admin_Send_Input_Mail::send_input_send_mail($email, $name, $order_id);

		$send = Model_Send_Jnl::select_primary_admin($send_id);
		$send->send_mail_flg = Config::get('constant.send_mail_flg.kbn.send');
		$send->save();

		return json_encode(array(
			'error' => '',
			'info' => 'メールを送信しました。',
			'reload' => '500',
			'send_id' => $send_id,
		));
	}

	private function send_input_send_mail($email, $name, $order_id) {
		$body = Utility::get_mail_template('template_invoice.txt');
		$body = Utility::mb_str_replace('%order_id%', $order_id, $body);
		$body = Utility::mb_str_replace('%date%', Utility::get_datetime_now(), $body);

		$entry = Model_Mail_Queue::forge();
		$entry->to      = $email;
		$entry->to_name = $name . '様';
		$entry->subject = 'インボイス発行のお知らせ';
		$entry->body    = $body;
		Model_Mail_Queue::insert_entry($entry);
    }
}
