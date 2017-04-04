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
 *	Uploads image file and sets properties according to image
*/

public function __construct( $file ) {
	// check if argument is file
	if (!is_file( $file )) {
		trigger_error( "Image::__construct(): Please use valid file to construct new Image.", E_USER_ERROR);
	}
	// check if upload is correct
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

 // set file name with timestamp, to avoid collisions
 $file_name = time() . '_' . $file['name'];
 // set correct destination path, then upload image
 $destination = SITE_ROOT . '/images/' . $file_name;
 if (move_uploaded_file($fi
 		le['tmp_name'], $destination)) {
 	echo 'File ' . $file_name . ' succesfully uploaded';
 }
 else {
 	echo 'Image upload not succesful.';
 	die();
 }


}

/**
 * Sets object's properties from values supplied dby form post
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
    $sql = "INSERT INTO images ( subtitle, source ) VALUES ( :subtitle, :source )";
    $st = $conn->prepare( $sql );
    $st->bindValue( ":subtitle", $this->subtitle, PDO::PARAM_STR);
    $st->bindValue( ":source", $this->source, PDO::PARAM_STR);
    $st->execute();
    $this->id = $conn->lastInsertId();
    $conn = null;

}

public function update() {
	 // Does the Image object have an ID?
    if ( is_null( $this->id ) ) trigger_error ( "Image::update(): Attempt to update an Image object that does not have its ID property set.", E_USER_ERROR );

    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD);
    $sql = "UPDATE images SET subtitle=:subtitle, source = :source WHERE id = :id";
    $st = $conn->prepare( $sql );
    $st->bindValue( ":subtitle", $this->subtitle, PDO::PARAM_STR );
    $st->bindValue( ":source", $this->source, PDO::PARAM_STR);
    $st->bindValue( ":id", $this->id, PDO::PARAM_INT );
    $st->execute();
    $conn = null;
}

public function delete() {
	// Does the Image object have an ID?
    if ( is_null( $this->id ) ) trigger_error ( "Image::update(): Attempt to update an Image object that does not have its ID property set.", E_USER_ERROR );

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


}
