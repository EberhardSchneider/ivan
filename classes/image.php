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
 *	Sets the object's properties using the values in the supplied array
*/

public function __construct( $data = array()) {
	if ( isset($data['id'])) $this->id = (int) $data['id'];
	if ( isset($data['subtitle'])) $this->subtitle = $data['subtitle'];
	if ( isset($data['source'])) $this->source = $data['source'];
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

    $conn = PDO( DB_DSN, DB_USERNAME, DB_PASSWORD);
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

    $conn = PDO( DB_DSN, DB_USERNAME, DB_PASSWORD);
    $sql = "DELETE FROM images WHERE id = :id LIMIT 1";
    $st = $conn->prepare( $sql );
    $st->execute();
    $conn = null;
}


}
