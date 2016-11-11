<?php

namespace Fuel\Tasks;

class Balance {

	public function adjust() {
		$balance_list = \Model_Order_Jnl::select_balance_deposit();

		try {
			\DB::start_transaction();

			$currency = \Model_Currency_Rate::select_primary();
			if(!$currency) {
				throw new \FuelException('Model_Currency_Rateが見つかりません。');
			}

			foreach ($balance_list as $balance) {
				$balance['amount'] = round($balance['amount']);
				if(abs($balance['amount']) == 0) {
					continue;
				}
				$user = \Model_Users::select_for_update_primary($balance['user_id']);
				$user->deposit += $balance['amount'];
				$user->save();

				$deposit               = \Model_Deposit_Jnl::forge();
				$deposit->user_id      = $user->id;
				$deposit->order_id     = 0;
				$deposit->deposit_order_id = 0;
				if($balance['amount'] > 0) {
					$deposit->deposit_kbn = \Config::get('constant.deposit_status.kbn.receipt');
				} else {
					$deposit->deposit_kbn = \Config::get('constant.deposit_status.kbn.pay');
				}
				$deposit->reason       = \Config::get('constant.balance_adjust.reason');
				$deposit->amount       = abs($balance['amount']);
				$deposit->commission   = 0;
				$deposit->payer_name   = \Config::get('constant.balance_adjust.payer_name_adjust');
				$deposit->deposit      = $user->deposit;
				$deposit->note         = '';
				$deposit->cny_jpy_rate = $currency->rate;
				$deposit->save();
			}
			\DB::commit_transaction();
		}
		catch (\FuelException $e) {
			\DB::rollback_transaction();
		}
	}
}
