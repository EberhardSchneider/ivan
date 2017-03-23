<div class="side-logo">
	<span class="title">Ivan Bazak</span>

</div>

<div id="menu-bar">
	<label for="open-menu" class="open-menu-label">
		<img src="icons/hamburger.svg" alt="Show Menu">
	</label>
	<input type="checkbox" id="open-menu">
	<nav>
	<ul>
	
<?php
	$conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
	$sql = "SELECT  * FROM pages";
	$st = $conn->prepare( $sql );
	$st->execute();

	while ($row = $st->fetch()) {
?>
		<li>

			<a href="index.php?action=showPage&page_id=<?php echo $row['id']; ?> ">
				<span class="menu-element"><?php echo $row['linkname']; ?></span>
			</a>
		</li>

<?php
	}
?>
	</ul>
	</nav>
</div> <!-- menu-bar -->