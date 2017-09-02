<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index() {

		$this->load->view('welcome_message');
	}

	public function asyncFileUpload() {
		$config = [
		    "uploadConfig" => [
			"upload_path" => "./public",
			"max_size" => 800000,
			"max_width" => 9000,
			"max_height" => 5000
		    ],
		    "cropperConfig" => [
			"test" => 20
		    ]
		];
		$this->load->library('image_cropper', $config);
		echo json_encode($this->image_cropper->uploadImage($_FILES));
	}

//{ ["image"] => array(5) { ["name"] => string(17) "1421826137705.png" ["type"] => string(9) "image/png" ["tmp_name"] => string(14) "/tmp/phpM4JAjD" ["error"] => int(0) ["size"] => int(1905979)
}
