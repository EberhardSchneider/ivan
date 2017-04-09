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
 if (move_uploaded_file($file['tmp_name'], $destination)) {
 	echo 'File ' . $newName . ' succesfully uploaded';
 }
 else {
 	echo 'Something occured';
 	die();
 }

 // now the file is uploaded an we can start manipulating

 $actual_image = $destination;

 // current size
 list( $width, $height ) = getimagesize( $actual_image );

// create new Image instance and set orientation, width and height
 $image = new Image();
 $image->presentation_size = IMAGE_SIZE_SMALL;
 $image->orientation = ($width < $height) ? IMAGE_PORTRAIT : IMAGE_LANDSCAPE;
 $image->width = $width;
 $image->height = $height;

 $image->source = $newName;
 $image->articleId = $_POST['articleId'];

 $image->insert();

 // now create entry in articleimages table
 $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD);
 $sql = "INSERT INTO articleimages ( article_id, image_id) VALUES ( :articleId, :imageId )";
 $st = $conn->prepare( $sql );
 $st->bindValue( ":articleId", $_POST['articleId'], PDO::PARAM_INT );
 $st->bindValue( ":imageId", $image->id, PDO::PARAM_INT );
 $st->execute();

 $conn = null;




 // calculate ratios
 if ( $image->orientation == IMAGE_PORTRAIT ) {
 	$longer_side = $height;
 }
 else {
 	$longer_side = $width;
 }

 $large_ratio = IMAGE_PIXEL_SIZE_LARGE / $longer_side;
 $medium_ratio = IMAGE_PIXEL_SIZE_MEDIUM / $longer_side;
 $small_ratio = IMAGE_PIXEL_SIZE_SMALL / $longer_side;
 $thumb_ratio = IMAGE_PIXEL_SIZE_THUMB / $longer_side;


// create images in correct size
 $image_large = imagecreatetruecolor( $width * $large_ratio, $height * $large_ratio);
 $image_medium = imagecreatetruecolor( $width * $medium_ratio, $height * $medium_ratio);
 $image_small = imagecreatetruecolor( $width * $small_ratio, $height * $small_ratio);
 $image_thumb = imagecreatetruecolor( $width * $thumb_ratio, $height * $thumb_ratio);

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

 imagecopyresized($image_large, $source, 0, 0, 0, 0, $width * $large_ratio, $height * $large_ratio, $width, $height);
 imagecopyresized($image_medium, $source, 0, 0, 0, 0, $width * $medium_ratio, $height * $medium_ratio, $width, $height);
 imagecopyresized($image_small, $source, 0, 0, 0, 0, $width * $small_ratio, $height * $small_ratio, $width, $height);
 imagecopyresized($image_thumb, $source, 0, 0, 0, 0, $width * $thumb_ratio, $height * $thumb_ratio, $width, $height);

 imagejpeg( $image_large, SITE_ROOT . "/" . LARGE_IMAGE_PATH . "/" . $newName, (int)JPEG_QUALITY );
 imagejpeg( $image_medium, SITE_ROOT . "/" . MEDIUM_IMAGE_PATH . "/" . $newName, (int)JPEG_QUALITY );
 imagejpeg( $image_small, SITE_ROOT . "/" . SMALL_IMAGE_PATH . "/" . $newName, (int)JPEG_QUALITY );
 imagejpeg( $image_thumb, SITE_ROOT . "/" . THUMBS_IMAGE_PATH . "/" . $newName,  (int)JPEG_QUALITY);



?>