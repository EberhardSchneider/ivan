<?php
require "../config.php";
 // type less
 $file = $_FILES['file-0'];
 // check if an error occured
 if ($file['error'] > 3) {
 	echo "Error: " . $file['error'];
 	die();
 }
 
 // check if extension is image extension
 $valid_extensions = array( 'jpg', 'jpeg', 'gif', 'png');
 $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
 if ( !in_array($extension, $valid_extensions )) {
 	echo "Extension not allowed. Upload image file!";
 	die();
 }

 $newName = time() . '_' . $file['name'];
 $destination = SITE_ROOT . "/" . FULLSIZE_IMAGE_PATH . "/" . $newName;
 $tmp_name = $file['tmp_name'];
 $articleId = $_POST['articleId'];

 Image::uploadImage( $newName, $destination, $tmp_name, $articleId, $extension );

 


?>