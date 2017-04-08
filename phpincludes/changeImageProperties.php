<?php 
	require("../config.php");

	$image = Image::GetImageById( (int)$_POST['id'] );
	
	
	$image->presentation_size = (int)$_POST['radio_image_size_' . $_POST['id']];
	$image->subtitle = $_POST['image-subtitle'];

	$image->update();
 ?>