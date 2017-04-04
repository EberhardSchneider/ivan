<?php 
	require("../config.php");
	
	$image = Image::getImageById( $_POST['imageId'] );
	$image->delete();

 ?>