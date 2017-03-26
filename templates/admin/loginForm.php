<?php include "templates/include/header.php" ?>
	<div class="side-logo">
		<span class="title"><a href=".">Ivan Bazak</a></span>
	</div>
	<form action="admin.php?action=login" method="post" class="login-form">
	<input type="hidden" name="login" value="true" />

<?php if ( isset ( $results['errorMessage'] ) ) { ?>
	<div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
<?php } ?>		

	<ul>
		<li>
			<label for="username">Benutzername</label>
			<input type="text" name="username" ud="username" placeholder="Admin Benutzername" required autofocus maxlength="20" />
		</li>

		<li>
			<label for="password">Passwort </label>
			<input type="password" mane="password" id="password" palceholder="Passwort" required maxlength="20" />
		</li>
	</ul>

	<div class="buttons">
		<input type="submit" name="login" value="Login">
	</div>
	</form>

	<?php include "templates/include/footer.php" ?>