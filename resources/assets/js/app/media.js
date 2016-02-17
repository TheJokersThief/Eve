/* MEDIA */
function initDropzone( ){
	Dropzone.options.fileupload = {
		init: function(){
			this.on('addedfile', function( file ){
				var filename = file.name.replace('.', '').replace(' ', '');

				// Add the file to our list with a progress bar
				$('.uploaded-images').append(
					`
					<li class="collection-item" id="`+filename+`">
						<p>`+file.name+`</p>
						<div class="progress">
							<div class="determinate"></div>
						</div>
					</li>
					`
				);
			});

			this.on('uploadprogress', function( file, progress, bytesSent ){
				var filename = file.name.replace('.', '').replace(' ', '');
				$('#'+filename+" .determinate").width( progress + "%" );
			});

			this.on('success', function( file, response ){
				var filename = file.name.replace('.', '').replace(' ', '');

				$('#'+filename).remove();
				$('.uploaded-images').append(
					`
						<li class="collection-item avatar" id="`+filename+`">
							<img src="`+response.file_location+`" alt="" class="circle">

							<div class="image-name">
								<div class="input-field col s12">
									<input placeholder="`+file.name+` (Start typing to rename)" id="title" type="text" onchange="updateImageTitle( this.value, ` + response.media_id + ` )">
						        </div>
							</div>
							<a href="#!" class="secondary-content"><i class="fa fa-times red-text"></i></a>
						</li>
					`
				);
			});

		}
	};
}

function updateImageTitle( title, media_id ){
	$.ajax({
		url: '/api/media/rename',
		type: 'post',
		cache: false,
		dataType: 'json',
        data: {
        	"title" : title,
        	"mediaID"  : media_id
        }
	});
}

function deleteImage( encryptedEventID, encryptedMediaID ){
	$.ajax({
		url: '/api/media/delete',
		type: 'post',
		cache: false,
		dataType: 'json',
        data: {
        	"encryptedEventID" : encryptedEventID,
        	"encryptedMediaID"  : encryptedMediaID
        }
	});
}
