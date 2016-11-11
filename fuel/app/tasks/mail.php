<?php

namespace Fuel\Tasks;

class Mail {

	public function send() {
		\Package::load('email');

		$quit_time = strtotime('4 minutes 45 seconds'); // 一定時間ごとにバッチを起動し直す
		$finish_flg = false;

		while(!$finish_flg) {
			$entries = \Model_Mail_Queue::get_unsent_list(5);
			foreach($entries as $entry) {
				if($this->send_mail($entry)) {
					$entry->send_flg = \Config::get('constant.send_mail.send_flg.kbn.sent');
					$entry->sended_at = \Utility::get_datetime_now();
				} else {
					$entry->retry_count += 1;
					if($entry->retry_count >= 2) {
						$entry->send_flg = \Config::get('constant.send_mail.send_flg.kbn.error');
					}
				}
				$entry->save();
			}
			sleep(10);

			if(time() > $quit_time) {
				$finish_flg = true;
			}
		}
	}

	private function send_mail($entry) {
		$mail = \Email::forge();
		$mail->from($entry->from, $entry->from_name);
		$mail->to($entry->to, $entry->to_name);
		$mail->reply_to($entry->to, $entry->to_name);
		$mail->subject($entry->subject);
		$mail->body($entry->body);

		try {
			$mail->send();
			$result = true;
		}
		catch(\EmailValidationFailedException $e) {
			$entry->error_message .= '[' . ($entry->retry_count+1) . '回目]アドレスが間違っています。';
			$result = false;
		}
		catch(\EmailSendingFailedException $e) { // ドライバがメールを送信できなかった。
			$entry->error_message .= '[' . ($entry->retry_count+1) . '回目]アドレスが間違っています。';
			$result = false;
		}
		catch(\RequestStatusException $e) { // SESのエラー
			$entry->error_message .= '[' . ($entry->retry_count+1) . '回目]' . $e;
			\Log::error($e);
			$result = false;
		}
		return $result;
	}
}
