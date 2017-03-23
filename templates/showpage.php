<?php include "templates/include/header.php"; ?>

<?php include "templates/include/sidemenu.php"; ?>

<div id="content">
	<ul id="headlines">

<?php
	foreach ($results['articles'] as $article) {  ?>

	<li>
		<h2>
			<span class="title"><?php echo htmlspecialchars($article->title); ?></span>
			<!-- TODO: show Images (in Template???) -->
			<div class="content"><?php echo $article->content ?></div>
		</h2>

	</li>
<?php
	}	
?>		

	</ul>
</div>

<?php include "templates/include/footer.php"; ?>