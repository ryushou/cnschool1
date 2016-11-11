<?php

class Controller_Order_Attach extends Controller {

	private function get_attach($attach_id) {
		if(Auth::has_access('image.user')) {
			$attach  = Model_Order_Attach::select_primary($attach_id);
		} else {
			$user_id = Utility::get_user_id();
			$attach  = Model_Order_Attach::select_primary_by_user_id($user_id, $attach_id);
		}
		return $attach;
	}

	public function action_file($attach_id) {
		$attach = $this->get_attach($attach_id);
		if($attach) {
			return Response::forge(
				$attach->file_data,
				200,
				array(
					'Content-Type' => $attach->file_type,
					'Content-Disposition' => 'attachment;filename=' . $attach->file_name,
				)
			);
		} else {
			Response::redirect('base/timeout');
		}
	}

	public function action_download($attach_id) {
		$attach = $this->get_attach($attach_id);
		if(!$attach) {
			$output_image = array(
				'status'  => 200,
				'content' => file_get_contents(Asset::get_file('noimage.png', 'img')),
				'type'    => 'png',
			);
		} else {
			if(in_array($attach->file_type, Config::get('constant.order_info_attach.mimetype.ai'), true)) {
				$output_image = array(
					'status'  => 200,
					'content' => file_get_contents(Asset::get_file('aiicon.jpg', 'img')),
					'type'    => 'jpg',
				);
			} else if(in_array($attach->file_type, Config::get('constant.order_info_attach.mimetype.doc'), true)) {
				$output_image = array(
					'status'  => 200,
					'content' => file_get_contents(Asset::get_file('word.png', 'img')),
					'type'    => 'png',
				);
			} else {
				$output_image = array(
					'status'   => 200,
					'content'  => $attach->file_data,
					'type'     => $attach->file_type,
				);
			}
		}

		return Response::forge(
			$output_image['content'],
			$output_image['status'],
			array('Content-Type' => $output_image['type'])
		);
	}

	public function action_upload() {
		$config = array(
			'ext_whitelist'  => Config::get('constant.order_info_attach.ext_whitelist'),
			'type_whitelist' => array('image','application'),
			'mime_whitelist' => Config::get('constant.order_info_attach.mime_whitelist'),
			'max_size'       => 1024 * 1024 * 16, # 16MB
        );
		\Upload::process($config);
		if (\Upload::is_valid()) {
			Upload::save();
			$attach_ids = array();
			$files = \Upload::get_files();
			if ($files) {
				$user_id  = Input::post('user_id', '');
				if(Auth::has_access('image.user')) {
					$upload_user = Config::get('constant.order_info_attach.upload_user.kbn.admin');
				} else {
					$upload_user = Config::get('constant.order_info_attach.upload_user.kbn.user');
				}
				$order_id = Input::post('order_id', '');
				foreach ($files as $file) {
					$is_image = !in_array($file['mimetype'], Config::get('constant.order_info_attach.mimetype.download'), true);
					if($is_image) {
						$attach = Image::forge(array(
							'quality' => 70,
							'persistence' => true
						));
						$upload_path = Config::get('upload.path');
						$upload_file = $upload_path . $file['name'];
						$attach_file = $upload_path . date('ymdhis') . '.' . $file['extension'];

						$attach->load($upload_file, false, $file['extension'])
							->resize(250)
							->save($attach_file);
						$file['file'] = $attach_file;
					} else {
						$file['file'] = $file['saved_to'] . $file['saved_as'];
					}
					$id = Model_Order_Attach::insert_attach($order_id, $user_id, $upload_user, $file);

					if($is_image) {
						File::delete($upload_file);
						File::delete($attach_file);
					}
					array_push($attach_ids, $id);
				}
			}
			$result = array(
				'error' => '',
				'ids'   => $attach_ids,
			);
		} else {
			$result = array(
				'error' => \Upload::get_errors(),
			);
		}
		return json_encode($result);
	}
}
