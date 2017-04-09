<?php include "templates/include/header.php"; ?>

<?php include "templates/include/sidemenu.php"; ?>

<?php $article = $results['article']; ?>

<div id="wrapper">
	<div id="articles"> <!-- stays so that css is consistent with articles page -->

	<div class="article">
		<h2>
			<span class="title"><?php echo htmlspecialchars($article->title); ?></span>
		</h2>
<?php  	$images = Image::getImagesByArticleId( $article->id );
		foreach ($images as $image) {  ?>		
			<div class="article-image">
<?php 	$class = ($image->orientation == IMAGE_PORTRAIT) ? "portrait " : "landscape ";
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
		}
?>			
				<img src="<?php echo $path . "/" . $image->source ?>" alt="<?php echo $image->subtitle ?>" 
					class="<?php echo $class ?>"/>
			</div>
<?php } ?>
			<div class="content"><?php echo $article->content ?></div>
		
	</div>
	
	<div id="footer">
			&copy;2017 Ivan Bazak. Eberhard Schneider.<br> <a href="admin.php">Site Admin</a>
	</div>	
	</div>

</div>

<?php include "templates/include/footer.php"; ?>