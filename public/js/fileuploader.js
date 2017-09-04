/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class AjaxUploader {
	/* 
	 *let url = {
	 *        upload: "index.php/welcome/asyncFileUpload",
	 *        cropper: "index.php/welcome/croppImage"
	 *};
	 *let data = [
	 *        {type: "file", id: "image", cropperId: "imagecropper"}
	 *];
	 */
	constructor(url, method, dataSelectors) {
		// Initialization of uploadFormData object
		this.uploadFormData = {};
		this.uploadFormData.formData = new FormData();
		for (let data of dataSelectors) {
			let selectedItem = document.querySelector(`#${data.id}`);
			if (data.type == "file") {
				this.uploadFormData.formData.append("" + data.id, selectedItem.files[0]);
			} else if (data.type == "text") {
				this.uploadFormData.formData.append("" + data.id, selectedItem);
			}
			this.cropperId = data.cropperId;
		}
		this.uploadFormData.url = url.upload;
		this.uploadFormData.method = method;
		this.uploadFormData.formData.xmlHttpRequest = new XMLHttpRequest();

		// Initialization of cropperFormData object
		this.cropperFormData = {};
		this.cropperFormData.formData = new FormData();
		this.cropperFormData.url = url.cropper;
		this.cropperFormData.method = method;
		this.cropperFormData.formData.xmlHttpRequest = new XMLHttpRequest();
	}

	upload() {
		this.uploadFormData.formData.xmlHttpRequest.open(this.uploadFormData.method, this.uploadFormData.url, true);
		self = this;
		this.uploadFormData.formData.xmlHttpRequest.onload = function (e) {
			if (this.status == 200) {
				let response = JSON.parse(this.response);
				let image = document.getElementById(self.cropperId);

				image.src = `/public/${response[1].client_name}`;
				self.cropperInstance = $(`#${self.cropperId}`);
				self.cropperInstance.cropper({
					aspectRatio: 16 / 9,
					crop: function (e) {
					}
				});
			}
		}
		this.uploadFormData.formData.xmlHttpRequest.send(this.uploadFormData.formData);
	}

	uploadCropped() {
		this.cropperFormData.formData.xmlHttpRequest.open(this.cropperFormData.method, this.cropperFormData.url, true);
		this.cropperFormData.formData.append("cropperData[x]", this.cropperInstance.cropper('getData').x);
		this.cropperFormData.formData.append("cropperData[y]", this.cropperInstance.cropper('getData').y);
		this.cropperFormData.formData.append("cropperData[width]", this.cropperInstance.cropper('getData').width);
		this.cropperFormData.formData.append("cropperData[height]", this.cropperInstance.cropper('getData').height);
		this.cropperFormData.formData.append("cropperData[rotate]", this.cropperInstance.cropper('getData').rotate);
		this.cropperFormData.formData.append("cropperData[scaleX]", this.cropperInstance.cropper('getData').scaleX);
		this.cropperFormData.formData.append("cropperData[scaleY]", this.cropperInstance.cropper('getData').scaleY);
		self = this;
		this.cropperFormData.formData.xmlHttpRequest.onload = function (e) {
			if (this.status == 200) {
				// Here i need to add callback function
				console.log(this.response);
			}
		}
		this.cropperFormData.formData.xmlHttpRequest.send(this.cropperFormData.formData);
	}
}