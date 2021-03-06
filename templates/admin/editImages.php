<?php include "templates/admin/admin-header.php" ?>

	<div class="adminHeader">
		<h2>Admin Seite</h2>
		<p>Sie sind als <b><?php echo htmlspecialchars($_SESSION['username']) ?></b> eingeloggt.<br> <a href="admin.php?action=logout">Log out</a></p>
	</div>
	
	<div id="wrapper">
		<div class="images">
				<div class="image-thumbs"></div>		
					<div class="image-form-wrapper">
						<form enctype="multipart/form-data" id="image-form" >
							<input type="hidden" id="article-id" name="articleId" value="<?php echo $_GET['articleId'] ?>">
							<div class="column">
								<label for="imageToUpload">Neues Bild hochladen:</label><br>
								<input type="file" name="fileToUpload" id="fileToUpload" />
								<input type="submit" value="Diese Datei hochladen">
							</div>
							<div class="column">
								<div class="image-preview"></div>
							</div>
						</form>
					</div>
				</div>	
				<button id="save-changes-button">Alle Änderungen speichern</button>
				<button onclick="window.location.replace('admin.php?action=editArticle&amp;articleId=<?php echo $_GET['articleId'] ?>')">Zum Artikel (Änderungen gehen verloren)</button>
	</div>




<?php include "templates/admin/edit-footer.php" ?>		