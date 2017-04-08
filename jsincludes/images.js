var d = {};


$(function() {

	// handle image upload
	$('#image-form').submit( function(e) {
		e.preventDefault();
		data = new FormData();
		$.each($('#fileToUpload')[0].files, function(i, file) {
			data.append('file-'+i, file);
		});




		$.ajax({
			type: 'POST',
			url: 	'phpincludes/uploadImage.php',
			data: data,
			cache: false,
			contentType: false,
			processData: false
		});
	});


	$('#save-changes-button').on("click", function() {

		data = new FormData();
		$('.image-options-form').each( function( index, form ) {
			$(form).submit();
		});
			
	});

	// show preview image when file is chosen
	$('#fileToUpload').change( function() {
		readURL(this);
	});
		
});



// shows preview image
function readURL( input ) {
	// check if file is chosen
	if (input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = function (e) {
			img = new Image();
			img.src = e.target.result;
			$('.image-preview').empty().append( img );
		}

		reader.readAsDataURL( input.files[0] );
	}
}


function showImages( articleId ) {

		$.post( "phpincludes/getImages.php", { "articleId": articleId } ,function( data ) {
			$('.image-thumbs').html( data );

		});
}

function deleteImageFromArticle( imageId, articleId ) {
	$.post( "phpincludes/deleteImage.php", { "articleId": articleId, "imageId": imageId }, function(data ) {
		alert( "Gelöscht." + data );
	});
}

function insertImage( imageSource, size, articleId ) {

}

// from http://stackoverflow.com/questions/439463/how-to-get-get-and-post-variables-with-jquery
// thanks to Ates Goral
function getQueryParams(qs) {
    qs = qs.split("+").join(" ");
    var params = {},
        tokens,
        re = /[?&]?([^=]+)=([^&]*)/g;

    while (tokens = re.exec(qs)) {
        params[decodeURIComponent(tokens[1])]
            = decodeURIComponent(tokens[2]);
    }

    return params;
}