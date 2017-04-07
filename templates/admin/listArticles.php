<?php include "templates/include/header.php" ?>

	<div class="adminHeader">
		<h2>Admin Seite</h2>
		<p>Sie sind als <b><?php echo htmlspecialchars($_SESSION['username']) ?></b> eingeloggt.<br> <a href="admin.php?action=logout">Log out</a></p>
	</div>
	
	<div id="wrapper">



<?php if ( isset( $results['errorMessage'] ) ) { ?>
	<div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
<?php 
	} 
?>

<?php if ( isset( $results['statusMessage'] ) ) { ?>
	<div class="statusMessage"><?php echo $results['statusMessage'] ?></div>
<?php 
	} 
?>
	<table class="article-table">
		<thead>
		<tr>
			<th>Einstelldatum</th>
			<th>Eintrag</th>
			<th>Seite</th>
			<th></th>
		</tr>
		</thead>
		<tbody>

<?php foreach ( $results['articles'] as $article ) { ?>
		<tr>
			<td onclick="location='admin.php?action=editArticle&amp;articleId=<?php echo $article->id?>'"><?php echo date('j.m.Y', $article->publicationDate)?></td>
			<td onclick="location='admin.php?action=editArticle&amp;articleId=<?php echo $article->id?>'">
				<?php echo $article->title?>
			</td>
			<td onclick="location='admin.php?action=editArticle&amp;articleId=<?php echo $article->id?>'">
				<?php echo $pages[$article->pageId-1]['title']; ?>
			</td>
			<td onclick="location='admin.php?action=editImages&amp;articleId=<?php echo $article->id?>'">
				Edit Images
			</td>
		</tr>
<?php
	}	
?>	</tbody>	
	</table>

	<p><?php echo $results['totalRows']?><?php echo ($results['totalRows'] != 1) ? ' Einträge' : ' Eintrag'?> insgesamt.</p>
	<p><a href="admin.php?action=newArticle">Neuen Eintrag hinzufügen.</a></p>
</div>
<?php include "templates/include/footer.php" ?>

