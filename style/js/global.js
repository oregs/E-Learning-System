(function(){
		"use strict";

		var dropZone = document.getElementById('drop-zone');
		var barFill = document.getElementById('bar-fill');
		var barFillText = document.getElementById('bar-fill-text');
		
		var startUpload = function(files){
		app.uploader({
			files: files,
			progressBar: barFill,
			progressText: barFillText,
			processor: 'upload.php',

			finished: function(data){
				console.log('Yay. it worked!');
				console.log(data);
			},

			error: function(){
				console.log('There was an error');
			}
		});
	};

	// Standard form upload
	document.getElementById('standard-upload').addEventListener('click', function(e){
		var standardUploadFiles = document.getElementById('standard-upload-files').files;
		e.preventDefault();

		startUpload(standardUploadFiles);
	});

	// Drop functionality
	dropZone.ondrop = function(e){
		e.preventDefault();
		this.className = 'upload-console-drop';

		startUpload(e.dataTransfer.files);
	};

	dropZone.ondragover = function(){
		this.className = 'upload-console-drop drop';
		return false;
	};

	dropZone.ondragleave = function(){
		this.className = 'upload-console-drop';
		return false;
	};
}());