<?php 
	require("../config.php");

	// get image	
	$image = Image::getImageById( $_POST['imageId'] );


	$image->delete();


 ?>