$( function() {
	$('#edit-form').submit( function() {
			console.log("Form submitted");
			content = $('#content').val();
			content = nl2br( content );
			$('#content').val( content );
			return true;
	});
});

function showPreview( articleId ) {
	console.log(articleId);
	$.post( "phpincludes/getArticle.php", 
					{ article_id : articleId,
						title: $('#title').val(),
						content: nl2br( $('#content').val() ) }, 
					function( data ) {
						var iframe = $('iframe')[0];
						iframe = iframe.contentWindow || iframe.contentDocument.document || iframe.contentDocument;
						iframe.document.open();
						iframe.document.write(data);
						iframe.document.close();
						
					});
}

function nl2br (str, is_xhtml) {   
    // var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';    
    // return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1'+ breakTag +'$2');
    return str.replace(/\n/g,"<br>");
}