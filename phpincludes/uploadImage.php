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
 $destination = SITE_ROOT . '/images/' . $newName;
 if (move_uploaded_file($file['tmp_name'], $destination)) {
 	echo 'File ' . $newName . ' succesfully uploaded';
 }
 else {
 	echo 'Something occured';
 	die();
 }

 // now the file is uploaded an we can start manipulating

 $actual_image = SITE_ROOT . '/images/' . $newName;
 $thumb_image = SITE_ROOT . '/images/thumbs/' . $newName;

 // current size
 list( $width, $height ) = getimagesize( $actual_image );

 $newWidth = 350;
 $newHeight = 350;


// load original image
 $thumb = imagecreatetruecolor($newWidth, $newHeight );
 switch ($extension) {
 		case 'jpg':
 			$source = imagecreatefromjpeg( $actual_image );
 			break;
 		case 'jpeg':
 			$source = imagecreatefromjpeg( $actual_image );
 			break;
 		case 'gif':
 			$source = imagecreatefromgif( $actual_image );
 			break;
 		case 'png':
 			$source = imagecreatefrompng( $actual_image );
 			break;
 		default:
 			echo 'Unknown file type.';
 			die();
 }

 imagecopyresized($thumb, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

 imagejpeg( $thumb, $thumb_image, JPEG_QUALITY);

 $pathToImage = addslashes(file_get_contents( $thumb_image ));

 echo $pathToImage;







?>