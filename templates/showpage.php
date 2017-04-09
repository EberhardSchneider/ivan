<?php include "templates/include/header.php"; ?>

<?php include "templates/include/sidemenu.php"; ?>

<div id="wrapper">
	<div id="articles">

<?php 
	// check if headlines or articles page

	if ( isset( $results['headlinePage']) && $results['headlinePage'] == 1)  {  ?>
		<!-- Headline Page -->
		<div class="headlines">
			<ul class="headlines-list">
<?php foreach ($results['articles'] as $article) {   
		if ( $article->headline !== "" ){ ?>
				<li>
					<a href="index.php?action=showArticle&amp;articleId=<?php echo $article->id ?>">
						<?php echo htmlspecialchars($article->headline) ?>
					</a>
				</li>
<?php }   ?>
<?php } ?>
		</ul>
		</div>
		
<?php	}
	else {
		// Articles page
	
		foreach ($results['articles'] as $article) {  



		?>

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
<?php
		}	// foreach
	} // else
?>		
	<div id="footer">
			&copy;2017 Ivan Bazak. Eberhard Schneider.<br> <a href="admin.php">Site Admin</a>
	</div>	
	</div>

</div>

<?php include "templates/include/footer.php"; ?>