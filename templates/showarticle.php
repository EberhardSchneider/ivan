<?php include "templates/include/header.php"; ?>

<?php include "templates/include/sidemenu.php"; ?>

<?php $article = $results['article']; ?>

<div id="wrapper">
	<div id="articles"> <!-- stays so that css is consistent with articles page -->

	<div class="article">
		<h2>
			<span class="title"><?php echo htmlspecialchars($article->title); ?></span>
		</h2>

<?php $content =$article->content;
			$images = Image::getImagesByArticleId( $article->id);
			$content = Image::insertImages( $content, $images, '[IMAGE]' );
 ?>
			<div class="content"><?php echo $content ?></div>
		


	</div> <!-- article -->
	
	<div id="footer">
			&copy;2017 Ivan Bazak. Eberhard Schneider.<br> <a href="admin.php">Site Admin</a>
	</div>	
	</div>

</div>

<?php include "templates/include/footer.php"; ?>