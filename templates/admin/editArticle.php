<?php include "templates/include/header.php" ?>

	<div class="adminHeader">
		<h2>Admin Seite</h2>
		<p>Sie sind als <b><?php echo htmlspecialchars($_SESSION['username']) ?></b> eingeloggt.<br> <a href="admin.php?action=logout">Log out</a></p>
	</div>
	
	<div id="wrapper">

		<form action="admin.php?action=<?php echo $results['formAction']?>" method="post">
			<input type="hidden" name="articleId" value="<?php echo $results['article']->id ?>" />
<?php if ( isset( $results['errorMessage'] ) ) { ?>
        <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
<?php } ?>

			<ul>
				<li>
					<label for="title">Titel des Eintrags</label>
					<input type="text" name="title" id="title" placeholder="Name des Eintrags" required autofocus maxlength="255" value="<?php echo htmlspecialchars( $results['article']->title )?>" />
				</li>

				<li>
					<label for="headline">Headline</label>
					<input type="text" name="headline" id="headline" placeholder="Headline" required autofocus maxlength="255" value="<?php echo htmlspecialchars( $results['article']->headline )?>" />
				</li>

				<li>
					<label for="content">Eintrag</label>
					<textarea name="content" id="content"  placeholder="Inhalt des Eintrags" required maxlength="100000"><?php echo  $results['article']->content ?></textarea>
				</li>

				<li>
					<label for="publicationDate">Einstelldatum</label>
					<input type="date" name="publicationDate" id="publicationDate" placeholder="TT-MM-JJJJ" required maxlength="10" value="<?php echo $results['article']->publicationDate ? date( "Y-m-d", $results['article']->publicationDate ) : "" ?>" />
				</li>

			</ul>

			
<?php 	$index = 0;
		foreach($pages as $page) { 
			$index++;  ?>
				<input type="radio" name="pageId" id="<?php echo $index?>" value="<?php echo $index ?>" 
				<?php if ($index == $results['article']->pageId) echo " checked"?> />
				<label for="<?php echo $index?>"><?php echo $page['title'] ?></label>	
<?php } ?>							
			

			<div class="buttons">
				<input type="submit" name="saveChanges" value="Änderungen speichern" />
				<input type="submit" formnovalidate name="cancel" value="Cancel" />
			</div>

		</form>

<?php if ( $results['article']->id) { ?>
		<p><a href="admin.php?action=deleteArticle&amp;articleId=<?php echo $results['article']->id ?>" onclick="return confirm('Diesen Eintrag löschen?')">Diesen Eintrag löschen?</a></p>
<?php } ?>

<?php include "templates/include/footer.php" ?>		