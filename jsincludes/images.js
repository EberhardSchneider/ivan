var d = {};


$(function() {

	// handle image upload
	$('#image-form').submit( function(e) {
		e.preventDefault();
		data = new FormData();
		$.each($('#fileToUpload')[0].files, function(i, file) {
			data.append('file-'+i, file);
		});

		// now append article Id

		articleId = $('#article-id').val();
		data.append('articleId', articleId );




		$.ajax({
			type: 'POST',
			url: 	'phpincludes/uploadImage.php',
			data: data,
			cache: false,
			contentType: false,
			processData: false,
			success: function() {
				showImages( articleId );
			}
		});
	});


	$('#save-changes-button').on("click", function() {

		data = new FormData();
		forms = $('.image-options-form');
		nForms = forms.length-1;
		$('.image-options-form').each( function( index, form ) {
			console.log(index +"  :  " + nForms);
			if (index == nForms) {
				$.post('phpincludes/changeImageProperties.php',$(form).serialize(), function( data ) { window.location.replace( 'admin.php') } );
			} else {
				$.post('phpincludes/changeImageProperties.php',$(form).serialize() );
			}
			
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
		showImages( articleId );
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