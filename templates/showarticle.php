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
				<img src="<?php echo IMG_PATH . "/" . $image->source ?>" alt="<?php echo $image->subtitle ?>" />
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