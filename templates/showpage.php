<?php include "templates/include/header.php"; ?>

<?php include "templates/include/sidemenu.php"; ?>

<div id="wrapper">
	<div id="articles">

<?php
	foreach ($results['articles'] as $article) {  



		?>

	<div class="article">
		<h2>
			<span class="title"><?php echo htmlspecialchars($article->title); ?></span>
		</h2>
<?php  $images = Image::getImagesByArticleId( $article->id );
		foreach ($images as $image) {  ?>		
			<div class="article-image">
				<img src="<?php echo IMG_PATH . "/" . $image->source ?>" alt="<?php echo $image->subtitle ?>" />
			</div>
<?php } ?>
			<div class="content"><?php echo $article->content ?></div>
		
	</div>
<?php
	}	
?>		
	<div id="footer">
			&copy;2017 Ivan Bazak. Eberhard Schneider.<br> <a href="admin.php">Site Admin</a>
	</div>	
	</div>

</div>

<?php include "templates/include/footer.php"; ?>