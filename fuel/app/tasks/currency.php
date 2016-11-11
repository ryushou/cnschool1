<?php

namespace Fuel\Tasks;

class Currency {

	public function update() {
		$update_urls = [
			'https://query.yahooapis.com/v1/public/yql?q=SELECT%20*%20FROM%20yahoo.finance.xchange%20WHERE%20pair%3D%22CNYJPY%22&format=json&diagnostics=true&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys&callback=',
			'http://api.aoikujira.com/kawase/json/cny',
		];
		$currency_rate = 0;

		foreach ($update_urls as $idx => $url) {
			$content = file_get_contents($url);
			if($idx == 0) {
				$json = json_decode($content);
				if(property_exists($json, 'query')) {
					$currency_rate = $json->query->results->rate->Rate;
					break;
				}
			}
			else if($idx == 1) {
				$json = json_decode($content);
				if(property_exists($json, 'JPY')) {
					$currency_rate = $json->JPY;
					break;
				}
			}
		}

		if($currency_rate > 0) {
			$currency = \Model_Currency_Rate::select_primary();
			if($currency) {
				$currency->rate = $currency_rate + 1; // 1円加算する
				$currency->save();
			}
		} else {
			$entry = \Model_Mail_Queue::forge();
			$entry->to      = \Config::get('constant.send_mail.admin');
			$entry->to_name = \Config::get('constant.send_mail.admin_name');
			$entry->subject = '管理メール通知';
			$entry->body    = '通貨レートの更新に失敗しました。';
			\Model_Mail_Queue::insert_entry($entry);
		}
	}
}
