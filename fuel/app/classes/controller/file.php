<?php

class Controller_File extends Controller {

	public function action_export() {
		set_time_limit(0); //実行時間の最大値を無制限にする
		$data  = Input::post('data', '');
		$mode  = Input::post('mode', '');
		$title = Input::post('title', '');

		if($data == '' || $mode == '') {
			Response::redirect('base/timeout');
		}
		$data = Controller_File::numericentity_decode($data);
		$data = Utility::mb_str_replace('<br/>,', "\n", $data);
		$data = Utility::mb_str_replace('<br/>', "\n", $data);

		if($mode == 'csv' && $title != 'invoice') {
			$data = mb_convert_encoding($data, 'SJIS', mb_internal_encoding());
		}

		$dlkey = md5(uniqid(rand(), true));
		Cache::set($dlkey, $data, 60);
		Session::set_flash('file_download_values', array('dlkey' => $dlkey, 'mode' => $mode, 'title' => $title));

		return json_encode(array(
				'error'  => '',
				'info'   => 'ダウンロードを開始します。'
		));
	}

	public function action_download() {
		$download_values = Session::get_flash('file_download_values');
		if($download_values == null) {
			Response::redirect('base/timeout');
		}

		try {
		    $data  = Cache::get($download_values['dlkey']);
		    $mode  = $download_values['mode'];
		    $title = $download_values['title'];

		    Cache::delete($download_values['dlkey']);
		}
		catch (\CacheNotFoundException $e) {
			Response::redirect('base/timeout');
		}

		if($mode == 'csv') {
			Controller_File::download_csv($data, $title);
		} else if($mode == 'excel') {
			Controller_File::download_excel($data);
		} else {
			Response::redirect('base/timeout');
		}
	}

	public function action_excel_upload() {
		$user_id = Utility::get_user_id();
		$config  = array(
			'ext_whitelist'  => Config::get('constant.order_sheet_upload.ext_whitelist'),
			'type_whitelist' => array('application'),
			'mime_whitelist' => Config::get('constant.order_sheet_upload.mime_whitelist'),
			'max_size'       => 1024 * 1024 * 32, # 32MB
			'prefix'         => $user_id . '_',
		);

		\Upload::process($config);
		if(\Upload::is_valid()) {
			Upload::save();
			$files = \Upload::get_files();
			if($files) {
				foreach ($files as $file) {
					$is_excel = in_array($file['mimetype'], Config::get('constant.order_sheet_upload.mimetype.download'), true);
					if($is_excel) {
						$upload_path = Config::get('upload.path');
						$upload_file = $upload_path . $user_id . '_' . $file['name'];
						$read_file   = $upload_path . date('ymdhis') . '_' . $user_id . '.' . $file['extension'];
						File::copy($upload_file, $read_file);

						$result = Controller_File::read_excel_files($read_file, $file['extension'], $user_id, Input::post('upload_option'));
						File::delete($upload_file);
						File::delete($read_file);
					} else {
						$file['file'] = $file['saved_to'] . $file['saved_as'];
					}
				}
			}
		} else {
			$result = array(
				'error' => \Upload::get_errors(),
			);
		}
		return json_encode($result);
	}

	public function action_validate_excel_files() {
		$sheet_data  = Input::post('sheet_data');
		$column_name = Config::get('constant.order_sheet_upload.excel_validation_array');

		$validation = Validation::forge();
		foreach($sheet_data as $form_id => $details) {
			Utility::add_detail_validation($validation, 'sheet_data', $form_id, $column_name['sku'], 'SKU')
				->add_rule('max_length', 13);
			Utility::add_detail_validation($validation, 'sheet_data', $form_id, $column_name['quantity'], '在庫数')
				->add_rule('numeric_between', 1, 10000)
				->add_rule('valid_string', array('numeric'));

			Utility::add_detail_validation($validation, 'sheet_data', $form_id, $column_name['URL1'], '仕入先URL1')
				->add_rule('valid_url')
				->add_rule('max_length', 500);
			Utility::add_detail_validation($validation, 'sheet_data', $form_id, $column_name['URL2'], '仕入先URL2')
				->add_rule('valid_url')
				->add_rule('max_length', 500);
			Utility::add_detail_validation($validation, 'sheet_data', $form_id, $column_name['URL3'], '仕入先URL3')
				->add_rule('valid_url')
				->add_rule('max_length', 500);

			Utility::add_detail_validation($validation, 'sheet_data', $form_id, $column_name['valiation'], 'バリエーション')
				->add_rule('max_length', 150);
			Utility::add_detail_validation($validation, 'sheet_data', $form_id, $column_name['demand'], '要望')
				->add_rule('max_length', 150);

			Utility::add_detail_validation($validation, 'sheet_data', $form_id, $column_name['china_price'], '販売価格(元)')
				->add_rule('match_pattern', '/^\d{1,8}(\.\d{1,2})?$/');
		}
		$validation->run();

		$errors = $validation->error();
		if (!empty($errors)) {
			return json_encode(array(
				'error' => $validation->show_errors(),
			));
		} else {
			return json_encode(array(
				'error' => '',
			));
		}
	}

	private static function read_excel_files($read_file, $read_file_ext, $user_id, $upload_option) {
		if(!file_exists($read_file)) {
			return array();
		}

		ini_set('memory_limit', '1G');
		Package::load('excel');
		$sheet_name_array = array();

		$reader  = PHPExcel_IOFactory::createReader(Config::get('constant.order_sheet_upload.excel_varsion.kbn.' . $read_file_ext));
		$reader->setReadDataOnly(true);
		$reader->setLoadSheetsOnly(Config::get('constant.order_sheet_upload.upload_sheet_name'));

		$cache_setting = '';
		$cache_method  = PHPExcel_CachedObjectStorageFactory::cache_to_memcache;
		PHPExcel_Settings::setCacheStorageMethod($cache_method, $cache_setting);

		$excel   = $reader->load($read_file);

		$sheet   = $excel->getSheetByName(Config::get('constant.order_sheet_upload.upload_sheet_name'));
		if($sheet == null) {
			unset($reader);
			unset($excel);
			unset($sheet);
			Package::unload('excel');
			return array(
				'error' => '反映できるシートがありません。',
			);
		}

		$row_start_index      = Config::get('constant.order_sheet_upload.excel_row_start');
		$row_max              = Config::get('constant.order_sheet_upload.excel_row_max');
		$column_name          = Config::get('constant.order_sheet_upload.excel_column_name');
		$excel_upload_exclude = Config::get('constant.order_sheet_upload.excel_upload_exclude');

		$sheet_data = array();
		for($row_index = $row_start_index; $row_index <= $row_max-($row_start_index-1); $row_index++) {
			if($sheet->getCellByColumnAndRow($column_name['sku'], $row_index)->getValue() == ''
				 || $sheet->getCellByColumnAndRow($column_name['quantity'], $row_index)->getValue() == ''
				 || $sheet->getCellByColumnAndRow($column_name['china_price'], $row_index)->getValue() == '') {
				break;
			}
			$tmp_array = array();
			for($column_index = 0; $column_index <= Config::get('constant.order_sheet_upload.excel_column_max'); $column_index++) {
				if(in_array($column_index, $excel_upload_exclude)) {
					continue;
				}

				$cell = $sheet->getCellByColumnAndRow($column_index, $row_index);
				if($column_index == $column_name['main_offer_image']
				 || $column_index == $column_name['offer_image1']) {
					if($cell->getValue() == null || $cell->getValue() == '') {
						$tmp_array[] = '';
						continue;
					}

					$file = array();
					$file['file']  = @file_get_contents($cell->getValue());
					if(!$file['file']) {
						$tmp_array[] = '';
						continue;
					}
					$upload_path   = Config::get('upload.path');
					$base_url_pass = basename($cell->getValue(), '/');

					$info              = finfo_open(FILEINFO_MIME_TYPE);
					$file['mimetype']  = finfo_buffer($info, $file['file']);
					finfo_close($info);
					if(!$file['mimetype']) {
						$tmp_array[] = Config::get('constant.no_image_id');
						continue;
					}

					$file['extension'] = Config::get('constant.order_sheet_upload.image_mimetype.' . $file['mimetype']);
					if(!isset($file['extension'])) {
						$tmp_array[] = Config::get('constant.no_image_id');
						continue;
					}

					$file['name'] = pathinfo($base_url_pass, PATHINFO_FILENAME) . '_' . $user_id . '.' . $file['extension'];
					$upload_file  = date('ymdhis') . '_' . $user_id . '.' . $file['extension'];

					$file_exists  = File::create($upload_path, $upload_file, $file['file']);
					if(!$file_exists) {
						$tmp_array[] = Config::get('constant.no_image_id');
						continue;
					}

					$image = Image::forge(array(
						'quality' => 70
					));

					$image_file = $upload_path . $file['name'];

					$image->load($upload_path . $upload_file, false, $file['extension']);
					$image->resize(250);
					$image->save($image_file);

					$id = Model_Images::insert_image_direct($user_id, $file);
					$tmp_array[] = $id;
					File::delete($upload_path . $upload_file);
					File::delete($image_file);
				} else {
					$tmp_array[] = $cell->getValue() == null ? '' : $cell->getValue();
				}
			}
			$sheet_data[] = $tmp_array;
			unset($cell);
		}

		unset($reader);
		unset($excel);
		unset($sheet);
		Package::unload('excel');

		if(!$sheet_data) {
			return array(
				'error' => '反映できるデータがありません。',
			);
		}

		return array(
			'error' => '',
			'cells' => $sheet_data,
			'upload_option' => $upload_option,
		);
	}

	public function action_template_download() {
		$file_path = APPPATH . 'tmp/excel/Flat.File.Listingloader.jp.xls';

		$response = Response::forge();
		$response->set_header('Content-Type', 'text/html');
		$response->set_header('Content-Disposition', 'attachment;filename=Flat.File.Listingloader.jp.xls');
		$response->set_header('Content-Length', File::get_size($file_path));
		$response->set_header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate');
		$response->set_header('Pragma', 'no-cache');
		$response->set_header('Expires', '0');
		$response->send(true);
		File::read($file_path, false);
	}

	private static function get_csv_value($data) {
		$fp = fopen('php://temp','r+');
		foreach($data as $v) {
			fputcsv($fp, $v, ',', '"');
		}
		rewind($fp); // ファイルポインタを一番先頭に戻す
		$csv = stream_get_contents($fp); //ファイルポインタの今の位置から全てを読み込み文字列へ代入
		$csv = mb_convert_encoding($csv, 'SJIS', mb_internal_encoding());
		fclose($fp);
		return $csv;
	}

	private static function numericentity_decode($str) {
		$str = mb_decode_numericentity($str, array(0x0, 0x10000, 0, 0xfffff), "UTF-8");
		$str = html_entity_decode($str, ENT_QUOTES, "UTF-8");
		return $str;
	}

	private static function download_csv($data, $title) {
		$response = Response::forge();
		$response->set_header('Content-Type', 'text/html');
		$response->set_header('Content-Disposition', 'attachment;filename=' . $title . date("YmdHis") . '.csv');
		$response->set_header('Content-Length', strlen($data));
		$response->set_header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate');
		$response->set_header('Pragma', 'no-cache');
		$response->set_header('Expires', '0');
		$response->send(true);
		echo $data;
	}

	private static function download_excel($data) {
		$tpl_dir = APPPATH . 'tmp/';

		Package::load('excel');
		$phpexcel = PHPExcel_IOFactory::load($tpl_dir . 'export.xls');

		$sheet = $phpexcel->setActiveSheetIndex(0);

		$data_rows = explode("\n", $data);
		foreach ($data_rows as $row => $data_row) {
			$data_columns = explode(",", $data_row);
			foreach ($data_columns as $column => $data_column) {
				$sheet->setCellValueByColumnAndRow($column, $row + 1, $data_column, true);
			}
		}
		$file = md5(uniqid(rand(), true)) . '.xlsx';
		$file_path = $tpl_dir . $file;

		$writer = PHPExcel_IOFactory::createWriter($phpexcel, 'Excel2007');
		$writer->save($file_path);

		$response = Response::forge();
		$response->set_header('Content-Type', 'text/html');
		$response->set_header('Content-Disposition', 'attachment;filename=' . date("YmdHis") . '.xlsx');
		$response->set_header('Content-Length', File::get_size($file_path));
		$response->set_header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate');
		$response->set_header('Pragma', 'no-cache');
		$response->set_header('Expires', '0');
		$response->send(true);
		File::read($file_path, false);
		File::delete($file_path);
	}
}