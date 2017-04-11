<?php include "templates/admin/admin-header.php" ?>

	<!-- <div class="adminHeader">
		<h2>Admin Seite</h2>
		<p>Sie sind als <b><?php echo htmlspecialchars($_SESSION['username']) ?></b> eingeloggt.<br> <a href="admin.php?action=logout">Log out</a></p>
	</div> -->
	
	<div id="edit-wrapper">

		<form action="admin.php?action=<?php echo $results['formAction']?>" method="post" id="edit-form">
			<input type="hidden" name="articleId" value="<?php echo $results['article']->id ?>" />
<?php if ( isset( $results['errorMessage'] ) ) { ?>
        <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
<?php } ?>

			<ul>
				<li>
					<label for="title">Titel des Eintrags</label>
					<input type="text" name="title" id="title" placeholder="Name des Eintrags" required autofocus maxlength="255" 
						value="<?php echo htmlspecialchars( $results['article']->title )?>" />
				</li>

				<li>
					<label for="headline">Headline</label>
					<input type="text" name="headline" id="headline" placeholder="Headline" required autofocus maxlength="255" 
						value="<?php echo htmlspecialchars( $results['article']->headline )?>" />
				</li>

				<li>
					<label for="content">Eintrag</label>
					<textarea name="content" id="content"  placeholder="Inhalt des Eintrags" 
					required maxlength="100000"><?php echo  $results['article']->content ?></textarea></li>

				<li>
					<label for="publicationDate">Einstelldatum</label>
					<input type="date" name="publicationDate" id="publicationDate" placeholder="TT-MM-JJJJ" required maxlength="10" 
						value="<?php echo $results['article']->publicationDate ? date( "Y-m-d", $results['article']->publicationDate ) : "" ?>" />
				</li>

<!-- 				<li>
					<div class="page-radiobuttons">
			
<?php 	$index = 0;
		// loop through all pages
		foreach($pages as $page) { 
			$index++;  ?>
			<div class="page-radiobutton">
					<div class="input-wrapper"><input type="radio" name="pageId" id="<?php echo $index?>" value="<?php echo $index ?>"

					<?php if ($index == $results['article']->pageId) echo " checked"?> /></div>
					<label for="<?php echo $index?>"><?php echo $page['title'] ?></label>	
			</div>
<?php } ?>
					</div>	
				</li> -->

				<li>
					<label for="pageId">Seite</label>
					<select name="pageId" id="pageSelect" form="edit-form">
<?php $index = 1;
			foreach( $pages as $page ) { ?>
						<option <?php if ($index == $results['article']->pageId) echo "selected "?> value="<?php echo $index++ ?>"><?php echo $page['title'] ?></option>
<?php } ?>
					</select>
				</li>
				
			</ul>

			<div class="buttons">
				<input type="submit" name="saveChanges" value="Änderungen speichern" />
				<input type="submit" formnovalidate name="cancel" value="Cancel" />
			</div>

		</form>

				<?php if ( $results['article']->id) { ?>
		<!-- <p><a href="admin.php?action=deleteArticle&amp;articleId=<?php echo $results['article']->id ?>" onclick="return confirm('Diesen Eintrag löschen?')">Diesen Eintrag löschen?</a></p> -->
		
			<button 
			onclick="if (confirm('Diesen Eintrag löschen?')) window.location.replace('admin.php?action=deleteArticle&amp;articleId=<?php echo $results['article']->id ?>') ">Diesen Eintrag löschen?</button>

			<button id="showPreview">Zeige Vorschau</button>

			<button id="moveToImages" onclick="window.location.replace('admin.php?action=editImages&amp;articleId=<?php echo $results['article']->id ?>')">
				Zu Bildern wechseln
			</button>
	
		
<?php } ?>	

		</div>
<div class="preview">
	<div class="wrap-iframe">>
		<iframe src="index.php?action=showArticle&amp;articleId=<?php echo $results['article']->id ?> " frameborder="0"></iframe>
	</div>
</div>


<?php include "templates/admin/edit-footer.php" ?>		