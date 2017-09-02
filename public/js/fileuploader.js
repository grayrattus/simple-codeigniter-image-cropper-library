/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class AjaxUploader {

	constructor(url, method, dataSelectors) {
		this.form_data = new FormData();
		for (let data of dataSelectors) {
			let selectedItem = document.querySelector(`#${data.id}`);
			if (data.type == "file") {
				this.form_data.append("" + data.id, selectedItem.files[0]);
			} else if (data.type == "text") {
				this.form_data.append("" + data.id, selectedItem);
			}
			this.cropperId = data.cropperId;
		}
		this.url = url;
		this.method = method;
		this.xml_http_request = new XMLHttpRequest();
	}

	upload() {
		this.xml_http_request.open(this.method, this.url, true);
		self = this;
		this.xml_http_request.onload = function (e) {
			if (this.status == 200) {
				let response = JSON.parse(this.response);
				let image = document.getElementById(self.cropperId);

				image.src = `/public/${response[1].client_name}`;
				console.log(self);
				$(`#${self.cropperId}`).cropper({
					aspectRatio: 16 / 9,
					crop: function (e) {
						// Output the result data for cropping image.
						console.log(e.x);
						console.log(e.y);
						console.log(e.width);
						console.log(e.height);
						console.log(e.rotate);
						console.log(e.scaleX);
						console.log(e.scaleY);
					}
				});


			}
		}
		this.xml_http_request.send(this.form_data);

	}

}