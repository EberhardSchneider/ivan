<?php 
	require("../config.php");
	// $article = Article::getArticleById( $_POST['articleId']);
?>


<div id="wrapper">
	<div id="articles"> <!-- stays so that css is consistent with articles page -->

	<div class="article">
		<h2>
			<span class="title"><?php echo htmlspecialchars($_POST['title']); ?></span>
		</h2>

<?php $content = $_POST['content'];
			$images = Image::getImagesByArticleId( $_POST['article_id'] );
			$content = Image::insertImages( $content, $images, '[IMAGE]' );
 ?>
			<div class="content"><?php echo $content ?></div>

	


	<!-- Show all iamges -->
<?php /**$images = Image::getImagesByArticleId( $_POST['article_id'] );
			foreach ($images as $image) {  ?>		
				<div class="article-image">
<?php $class = ($image->orientation == IMAGE_PORTRAIT) ? "portrait " : "landscape ";
			switch ($image->presentation_size) {
				case IMAGE_SIZE_SMALL:
					$path = SMALL_IMAGE_PATH;
					$class .= "image-small";
					break;
				case IMAGE_SIZE_MEDIUM:
					$path = MEDIUM_IMAGE_PATH;
					$class .= "image-medium";
					break;
				case IMAGE_SIZE_LARGE:
					$path = LARGE_IMAGE_PATH;
					$class .= "image-large";
					break;
			} // switch
?>			
				<img src="<?php echo $path . "/" . $image->source ?>" alt="<?php echo $image->subtitle ?>" 
					class="<?php echo $class ?>"/>
			</div> <!-- article-image -->

<?php } **/?>
		


	</div> <!-- article -->
	
	<div id="footer">
			&copy;2017 Ivan Bazak. Eberhard Schneider.<br> <a href="admin.php">Site Admin</a>
	</div>	
	</div>

</div>

<?php 

// function insertImages( $content, $images, $tag ) {

// 	$index = 0;

// 	while ( $pos = strpos( $content, $tag ) ) {

// 		if ( ! ($index < count( $images) ) ) {
// 			$content = str_replace( $tag, "", $content);
// 			break;
// 		}
// 		$image = $images[ $index ];


// 		$class = ($image->orientation == IMAGE_PORTRAIT) ? "portrait " : "landscape ";
// 		switch ($image->presentation_size) {
// 			case IMAGE_SIZE_SMALL:
// 				$path = SMALL_IMAGE_PATH;
// 				$class .= "image-small";
// 				break;
// 			case IMAGE_SIZE_MEDIUM:
// 				$path = MEDIUM_IMAGE_PATH;
// 				$class .= "image-medium";
// 				break;
// 			case IMAGE_SIZE_LARGE:
// 				$path = LARGE_IMAGE_PATH;
// 				$class .= "image-large";
// 				break;
// 		} // switch
		
// 		// $image_html = "<div class='article-image'>";
// 		$image_html = "<img src='$path/$image->source '  alt='$image->subtitle' class='$class'/>";


// 		$content = substr_replace( $content, $image_html, $pos, strlen( $tag ));
// 		$index++;
// 	}
// 		return $content;
// 	} ?>