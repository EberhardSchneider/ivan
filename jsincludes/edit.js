$( function() {

});

function showPreview( articleId ) {
	console.log(articleId);
	$.post( "phpincludes/getArticle.php", 
					{ article_id : articleId,
						title: $('#title').val(),
						content: $('#content').val() }, 
					function( data ) {
						var iframe = $('iframe')[0];
						iframe = iframe.contentWindow || iframe.contentDocument.document || iframe.contentDocument;
						iframe.document.open();
						iframe.document.write(data);
						iframe.document.close();
						$('.preview  #wrapper', $('iframe').contents() ).mCustomScrollbar( { theme: 'dark'});
					});
}