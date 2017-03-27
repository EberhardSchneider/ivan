

<div id="menu-bar">
	<label for="open-menu" class="open-menu-label">
		<img src="icons/hamburger.svg" alt="Show Menu">
		<div class="spacerhalfem"></div>
	</label>
	<input type="checkbox" id="open-menu">
	<nav>
	<ul>
	
<?php
	$index = 0;

	$conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
	$sql = "SELECT  * FROM pages";
	$st = $conn->prepare( $sql );
	$st->execute();

	while ($row = $st->fetch()) {
		$index++;
?>
		<li>
			<a href="index.php?action=showPage&page_id=<?php echo $row['id']; ?> ">
				<span class="menu-element <?php echo ($index == $page) ? "active" : "" ?>" > <?php echo $row['linkname']; ?></span>
			</a>
		</li>

<?php
	}
?>
	</ul>
	</nav>
</div> <!-- menu-bar -->