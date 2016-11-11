<?php

/**
 * 基礎的なページの表示を管理するクラス
 */
class Controller_Base extends Controller_Template {

	public $template = 'template/template';

	public function action_404() {
		$this->template->title = 'ページが見つかりません。';
		$this->template->content = View::forge('auth/404');
	}

	public function action_timeout() {
		$this->template->title = '有効期限が切れました。';
		$this->template->content = View::forge('auth/timeout');
	}

	public function action_query_profile() {
		$query_profile_key = Utility::get_query_profile_key();
		try	{
			$queries = Cache::get($query_profile_key);
			Cache::delete($query_profile_key);
		}
		catch (\CacheNotFoundException $e) {
			$queries = [];
		}
		return json_encode(array(
			'queries' => $queries,
		));
	}
}
