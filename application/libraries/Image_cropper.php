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
	private $cropperConfig = [
	    "image_library" => 'gd2',
	    "source_image" => "",
	    "library_path" => '/usr/local/bin',
	    "create_thumb" => FALSE,
	    "maintain_ration" => TRUE
	];
	private $error = [
	    0 => "You have not included proper upload_path",
	    1 => "You have not included proper uploadConfig",
	    2 => "You have not included proper cropperConfig",
	    3 => "You have not included source_image"
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
		if (isset($config["cropperConfig"]["image_library"])) {
			$this->cropperConfig["image_library"] = $config["cropperConfig"]["image_library"];
		}
		if (isset($config["cropperConfig"]["image_library"])) {
			$this->cropperConfig["create_thumb"] = $config["cropperConfig"]["create_thumb"];
		}
		if (isset($config["cropperConfig"]["maintain_ration"])) {
			$this->cropperConfig["maintain_ration"] = $config["cropperConfig"]["maintain_ration"];
		}
		if (isset($config["cropperConfig"]["width"])) {
			$this->cropperConfig["width"] = $config["cropperConfig"]["width"];
		}
		if (isset($config["cropperConfig"]["height"])) {
			$this->cropperConfig["height"] = $config["cropperConfig"]["height"];
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

	public function cropImage($config) {
		if (!isset($config)) {
			return -1;
		}
		if (!isset($config["cropperData"]["sourceImage"])) {
			return -1;
		} else {
			$srcNoSlash = preg_replace("/^\//", "", $config["cropperData"]["sourceImage"]);
			$this->cropperConfig["source_image"] = $srcNoSlash;
		}
		if (isset($config["cropperData"]["x"])) {
			$this->cropperConfig["x_axis"] = (int)$config["cropperData"]["x"];
		}
		if (isset($config["cropperData"]["y"])) {
			$this->cropperConfig["y_axis"] = (int)$config["cropperData"]["y"];
		}
		if (isset($config["cropperData"]["width"])) {
			$this->cropperConfig["width"] = (int)$config["cropperData"]["width"];
		}
		if (isset($config["cropperData"]["height"])) {
			$this->cropperConfig["height"] = (int)$config["cropperData"]["height"];
		}
		if (isset($config["cropperData"]["rotate"])) {
			$this->cropperConfig["roration_angle"] = $config["cropperData"]["rotate"];
		}

		$this->CI->load->library('image_lib');
		$this->CI->image_lib->initialize($this->cropperConfig);
		$this->CI->image_lib->crop();
		$this->CI->image_lib->clear();
		echo $this->CI->image_lib->display_errors();
	}

}
