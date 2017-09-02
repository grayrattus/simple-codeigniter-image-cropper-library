<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Image_cropper extends CI_Loader {

	private $upload;
	private $CI;

	private $uploadConfig = [
	    "upload_path" => "/public/",
	    "allowed_types" => "gif|jpg|png",
	    "max_size" => 300,
	    "max_width" => 1024,
	    "max_height" => 768
	];
	private $error = [
	    0 => "You have not included proper upload_path",
	    1 => "You have not included proper config variable"
	];
	private $success = [
	    0 => "Image had been successfully uploaded"
	];

	public function __construct($config) {
		$this->CI = &get_instance();

		if (!isset($config["uploadConfig"])) {
			return $this->error[1];
		}
		if (!isset($config["uploadConfig"]["upload_path"])) {
			return $this->error[0];
		} else {
			$this->uploadConfig["upload_path"] = $config["uploadConfig"]["upload_path"];
		}
		if (isset($config["uploadConfig"]["allowed_types"])) {
			$this->uploadConfig["allowed_types"] = $config["uploadConfig"]["allowed_types"];
		}
		if (isset($config["uploadConfig"]["max_size"])) {
			$this->uploadConfig["max_size"] = $config["uploadConfig"]["max_size"];
		}
		if (isset($config["uploadConfig"]["max_width"])) {
			$this->uploadConfig["max_width"] = $config["uploadConfig"]["max_width"];
		}
		if (isset($config["uploadConfig"]["max_height"])) {
			$this->uploadConfig["max_height"] = $config["uploadConfig"]["max_height"];
		}
		$this->CI->load->library('upload', $this->uploadConfig);
	}

	// $fileName = "userfile" -- file namne from input form <input type="file" name="userfile" size="20" />
	public function uploadImage() {
		if (!$this->CI->upload->do_upload("image")) {
			$error = array("error" => $this->CI->upload->display_errors());
			return $error;
		} else {
			$data = array("upload_data", $this->CI->upload->data());
			return $data;
		}
	}

	public function upload_to_crop($file, $config) {
		$this->load->library('upload', $config);
	}

}
