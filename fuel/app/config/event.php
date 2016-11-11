<?php

return array(
	'fuelphp' => array(
		'app_created' => function() {
			// フレームワークが初期化された後にトリガーされます。
			$env_config = Config::get('constant.dynamic_config.env.' . Fuel::$env);
			foreach(Arr::flatten($env_config, '.') as $key => $value) {
				Config::set($key, $value);
			}
			if(array_key_exists('HTTP_HOST', $_SERVER)) {
				$host_config = Config::get('constant.dynamic_config.host.' . $_SERVER['HTTP_HOST']);
				if(is_array($host_config)) {
					foreach(Arr::flatten($host_config, '.') as $key => $value) {
						Config::set($key, $value);
					}
				}
			}
		},
		'controller_started' => function() {
			// Request がリクエストされる際の処理

			// ログインチェック（除外ページ）
			$method = Uri::segment(1);
			if($method == 'secured') {
				return;
			}

			// CSRFチェック
			if (Input::method() === 'POST') {
				if (!Security::check_token()) {
					Response::redirect('base/timeout');
				}
			}

			$auth_methods = array(
				'base',
				'auth',
			);
			$auth_check = Auth::check();
			if (!in_array($method, $auth_methods) && !$auth_check) {
				Response::redirect('auth/login');
			}

			if ($method !== 'auth' && !Auth::has_access('event.request')) {
				Auth::logout();
				Response::redirect('/auth/login');
			}

			$email_split = explode("@", Auth::get_email(), 2);
			if(count($email_split) >= 2) {
				$user_name = $email_split[0] . '@';
			} else {
				$user_name = Auth::get_email();
			}

			// Viewで使う共通変数をセット
			View::set_global('login', $auth_check, false);
			View::set_global('user_name', $user_name);
		},
		'shutdown' => function() {
            if(Auth::check()) {
            	$user_id = Utility::get_user_id();
				Utility::log_access($user_id);
				Utility::register_shutdown_function($user_id);
            }
            // shutdown時にsessionに保存はできない
            // cacheとして保存する
			if(Input::post('query_profile') == null) {
	            $execute_query = Profiler::get_execute_query();
	            if($execute_query != '') {
					$query_profile_key = Utility::get_query_profile_key();
					try	{
						$queries = Cache::get($query_profile_key);
						if(is_array($queries)) {
							$queries[] = $execute_query;
						} else {
							$queries = $execute_query;
						}
					}
					catch (\CacheNotFoundException $e) {
						$queries = $execute_query;
					}
					Cache::set($query_profile_key, $queries, 10);
	            }
			}
        },
	),
);