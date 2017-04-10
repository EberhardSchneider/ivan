$( function() {

});

function showPreview( articleId ) {
	console.log(articleId);
	$.post( "phpincludes/getArticle.php", 
					{ article_id : articleId,
						title: $('#title').val(),
						content: $('#content').val() }, 
					function( data ) {
						$('.preview').html( data );
						$('.preview  #wrapper').mCustomScrollbar( { theme: 'dark'});
					});
}