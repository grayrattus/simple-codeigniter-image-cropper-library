<html>
    <head>
	<script src="http://code.jquery.com/jquery-3.2.1.min.js" ></script>
	<link  href="https://cdnjs.cloudflare.com/ajax/libs/cropper/2.3.4/cropper.css" rel="stylesheet">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/cropper/2.3.4/cropper.js"></script>
	<script src="/public/js/fileuploader.js"></script>
	<style>
	    img {
		max-width: 100%; /* This rule is very important, please do not ignore this! */
	    }
	</style>
    </head>
    <body>
	<div style="width: 500px;">
	    <img id="imagecropper" src="">
	</div>
	<form action="" enctype="multipart/form-data" method="post">
	    <label for="image" >Image</label>
	    <input id="image" type="file" name="image"/>
	    <input id="mytext" type="text" name="mytext"/>
	</form>		
	<button id="submit"></button>
    </body>
    <script>

	    let data = [
		    {type: "file", id: "image", cropperId: "imagecropper"}
	    ];
	    let fileuploader = new AjaxUploader("index.php/welcome/asyncFileUpload", "POST", data);
	    document.getElementById('image').onchange = function () {
		    fileuploader.upload();
	    };

	    document.querySelector("#submit").addEventListener("click", function () {
		    fileuploader.getCroppedData();

	    });
    </script>
</html>