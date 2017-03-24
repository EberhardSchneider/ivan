<?php include "templates/include/header.php"; ?>

<?php include "templates/include/sidemenu.php"; ?>

<div id="content">
	<div id="articles">

<?php
	foreach ($results['articles'] as $article) {  ?>

	<div class="article">
		<h2>
			<span class="title"><?php echo htmlspecialchars($article->title); ?></span>
		</h2>
			<!-- TODO: show Images (in Template???) -->
			<div class="content"><?php echo $article->content ?></div>
		

	</div>
<?php
	}	
?>		

	</div>
</div>

<?php include "templates/include/footer.php"; ?>