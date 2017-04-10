<?php

/**
 * Class to store Image informations
 */

class Image {
	//Properties

	/**
	 * @var int The image ID from the database
	 */
	public $id = null;

/**
	 * @var string Optional subtitle for the image
	 */
	public $subtitle = null;

/**
	 * @var string Filename of the image
	 */
	public $source = null;

/**
	* @var int Size in the article: IMG_SMALL 0, IMG_MEDIUM 1, IMG_BIG 2, IMG_THUMB 3
	*/
	public $presentation_size = null;

	/**
	* @var int Orientation: IMG_PORTRAIT 0, IMG_LANDSCAPE 1
	*/
	public $orientation = null;

	/**
	* @var int width in pixels
	*/
	public $width = null;

	/**
	* @var int height in pixels
	*/
	public $height = null;


/** 
 *	Constructs new image from data given in an array
*/

public function __construct( $data = array() ) {

	if ( isset($data['id']) ) { $this->id = $data['id']; }
	if ( isset($data['subtitle']) ) { $this->subtitle = $data['subtitle']; }
	if ( isset($data['source']) ) { $this->source = $data['source']; }
	if ( isset($data['presentation_size']) ) { $this->presentation_size = $data['presentation_size']; }
	if ( isset($data['orientation']) ) { $this->orientation = $data['orientation']; }
	if ( isset($data['width']) ) { $this->width = $data['width']; }
	if ( isset($data['height']) ) { $this->height = $data['height']; }
}

/**
 * Sets object's properties from values supplied by form post
 */

public function storeFromValues( $params ) {
	$this->__construct( $params );
}







public function getImageById( $id ) {
	$conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD);
	$sql = "SELECT * FROM images WHERE id = :id";
	$st = $conn->prepare( $sql );
	$st->bindValue(":id", $id, PDO::PARAM_INT);
	$st->execute();
	$row = $st->fetch();
	$conn = null;
	if ( $row ) return ( new Image( $row ) );
}


// returns an array with all images in the article $id
public function getImagesByArticleId( $id = 1 ) {
	$images = array();
	$conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD);
	// TODO: put in one query!
	$sql = "SELECT image_id FROM articles JOIN articleimages ON articles.id=articleimages.article_id WHERE article_id=:article_id";
	$st = $conn->prepare( $sql );
	$st->bindValue(":article_id", $id, PDO::PARAM_INT);
	$st->execute();

	while ( $row = $st->fetch() ) {
		$images[] = Image::getImageById( $row['image_id']);
	}

	return $images;
}

public function insert() {

	// Does the Image object already have an ID?
    if ( !is_null( $this->id ) ) trigger_error ( "Image::insert(): Attempt to insert an Image object that already has its ID property set (to $this->id).", E_USER_ERROR );

    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD);
    $sql = "INSERT INTO images ( subtitle, source, presentation_size, orientation, width, height  ) VALUES ( :subtitle, :source, :presentation_size, :orientation, :width, :height  )";
    $st = $conn->prepare( $sql );
    $st->bindValue( ":subtitle", $this->subtitle, PDO::PARAM_STR);
    $st->bindValue( ":source", $this->source, PDO::PARAM_STR);
    $st->bindValue( ":presentation_size", $this->presentation_size, PDO::PARAM_INT);
    $st->bindValue( ":orientation", $this->orientation, PDO::PARAM_INT);
    $st->bindValue( ":width", $this->width, PDO::PARAM_INT);
    $st->bindValue( ":height", $this->height, PDO::PARAM_INT);
    $st->execute();
    var_dump( $st->errorInfo() );
    $this->id = $conn->lastInsertId();
    $conn = null;

}

public function update() {
	 // Does the Image object have an ID?
    if ( is_null( $this->id ) ) trigger_error ( "Image::update(): Attempt to update an Image object that does not have its ID property set.", E_USER_ERROR );

    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD);
    $sql = "UPDATE images SET subtitle=:subtitle, source = :source, presentation_size=:presentation_size, orientation=:orientation, width=:width, height=:height WHERE id = :id";
    $st = $conn->prepare( $sql );
    $st->bindValue( ":subtitle", $this->subtitle, PDO::PARAM_STR );
    $st->bindValue( ":source", $this->source, PDO::PARAM_STR);
    $st->bindValue( ":id", $this->id, PDO::PARAM_INT );
    $st->bindValue( ":presentation_size", $this->presentation_size, PDO::PARAM_INT);
    $st->bindValue( ":orientation", $this->orientation, PDO::PARAM_INT);
    $st->bindValue( ":width", $this->width, PDO::PARAM_INT);
    $st->bindValue( ":height", $this->height, PDO::PARAM_INT);

    $st->execute();
    $conn = null;
}

public function delete() {
	// Does the Image object have an ID?
    if ( is_null( $this->id ) ) trigger_error ( "Image::update(): Attempt to update an Image object that does not have its ID property set.", E_USER_ERROR );

    // delete all files
		$file_name = $this->source;

		unlink ( SITE_ROOT . '/' . FULLSIZE_IMAGE_PATH . '/' .$file_name );
		unlink ( SITE_ROOT . '/' . LARGE_IMAGE_PATH . '/' . $file_name );
		unlink ( SITE_ROOT . '/' . MEDIUM_IMAGE_PATH . '/' . $file_name );
		unlink ( SITE_ROOT . '/' . SMALL_IMAGE_PATH . '/' . $file_name );
		unlink ( SITE_ROOT . '/' . THUMBS_IMAGE_PATH . '/' . $file_name );

    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD);
    $sql = "DELETE FROM images WHERE id = :id LIMIT 1";
    $st = $conn->prepare( $sql );
    $st->bindValue(":id", $this->id, PDO::PARAM_INT );
    $st->execute();
    $conn = null;

    // now delete all rows in the articleimage table with this image
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD);
    $sql = "DELETE FROM articleimages WHERE image_id = :imageId LIMIT 1";
    $st = $conn->prepare( $sql );
    $st->bindValue(":imageId", $this->id, PDO::PARAM_INT );
    $st->execute();
    $conn = null;
}

public static function uploadImage( $file_name, $full_path, $tmp_name, $article_id, $extension ) {

  	if (move_uploaded_file($tmp_name, $full_path)) {
 	echo 'File ' . $file_name . ' succesfully uploaded';
 }
 else {
 	echo 'Something occured';
 	die();
 }

 // now the file is uploaded an we can start manipulating

 $actual_image = $full_path;

 // current size
 list( $width, $height ) = getimagesize( $actual_image );

// create new Image instance and set orientation, width and height
 $image = new Image();
 $image->presentation_size = IMAGE_SIZE_SMALL;
 $image->orientation = ($width < $height) ? IMAGE_PORTRAIT : IMAGE_LANDSCAPE;
 $image->width = $width;
 $image->height = $height;

 $image->source = $file_name;
 $image->articleId = $article_id;

 $image->insert();

 // now create entry in articleimages table
 $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD);
 $sql = "INSERT INTO articleimages ( article_id, image_id) VALUES ( :articleId, :imageId )";
 $st = $conn->prepare( $sql );
 $st->bindValue( ":articleId", $article_id, PDO::PARAM_INT );
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

 imagejpeg( $image_large, SITE_ROOT . "/" . LARGE_IMAGE_PATH . "/" . $file_name, (int)JPEG_QUALITY );
 imagejpeg( $image_medium, SITE_ROOT . "/" . MEDIUM_IMAGE_PATH . "/" . $file_name, (int)JPEG_QUALITY );
 imagejpeg( $image_small, SITE_ROOT . "/" . SMALL_IMAGE_PATH . "/" . $file_name, (int)JPEG_QUALITY );
 imagejpeg( $image_thumb, SITE_ROOT . "/" . THUMBS_IMAGE_PATH . "/" . $file_name,  (int)JPEG_QUALITY);
  }



}
