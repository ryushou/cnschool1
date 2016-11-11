<?php

class Controller_Image extends Controller {

	public function action_download($image_id) {
		if(Auth::has_access('image.user')) {
			$image  = Model_Images::select_primary($image_id);
		} else {
			$user_id = Utility::get_user_id();
			$image   = Model_Images::select_primary_by_user_id($image_id, $user_id);
		}

		if(!$image) {
			$output_image = array(
				'status'  => 200,
				'content' => file_get_contents(Asset::get_file('noimage.png', 'img')),
				'type'    => 'png',
			);
		} else {
			$output_image = array(
				'status'  => 200,
				'content' => $image->file_data,
				'type'    => $image->file_type,
			);
		}

		return Response::forge(
			$output_image['content'],
			$output_image['status'],
			array('Content-Type' => $output_image['type'])
		);
	}

	public function action_upload() {
		$user_id = Input::post('user_id', Utility::get_user_id());
		$config  = array(
			'prefix' => $user_id . '_',
		);
		\Upload::process($config);
		if (\Upload::is_valid()) {
			Upload::save();
			$image_ids = array();
			$files = \Upload::get_files();
			if ($files) {
				foreach ($files as $file) {
					$image = Image::forge(array(
						'quality' => 70
					));
					$upload_path = Config::get('upload.path');
					$upload_file = $upload_path . $user_id . '_' . $file['name'];
					$image_file = $upload_path . date('ymdhis') . '_' . $user_id . '.' . $file['extension'];

					$image->load($upload_file)
						->resize(250)
						->save($image_file);
					$file['file'] = $image_file;

					$id = Model_Images::insert_image($user_id, $file);

					File::delete($upload_file);
					File::delete($image_file);

					array_push($image_ids, $id);
				}
			}
			$result = array(
				'error' => '',
				'ids'   => $image_ids,
			);
		} else {
			$result = array(
				'error' => \Upload::get_errors(),
			);
		}
		return json_encode($result);
	}
}
