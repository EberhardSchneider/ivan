		

		</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	<script src="jsIncludes/jquery.mCustomScrollbar.concat.min.js"></script>
	<script type="text/javascript" src="_/js/script.js"></script>
		<!-- Now handle images -->
	<script src="jsincludes/images.js"></script>
	<script src="jsincludes/edit.js"></script>
	<script>
		$( 
			function() { 
				showImages( <?php echo $results['article']->id ?>); 
			});

			$('#showPreview').click(function() { 
				console.log("skljd");
				showPreview( <?php echo $results['article']->id ?> ); 
			});
	</script>
	</body>
</html>