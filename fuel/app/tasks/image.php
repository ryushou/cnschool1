<?php

namespace Fuel\Tasks;

class Image {

	public function delete() {
		\Model_Images::delete_images_task();
	}
}
