<?php

/**
* Class to handle articles
*/

class Article {

	// Properties

	/**
	*	@var int article ID from database
	*/
	public $id = null;

	/**
	*	@var int ID of page on which article will be presented
	*/
	public $pageId = null;

	/**
	*	@var int publishing date of article
	*/
	public $publicationDate = null;


/**
	*	@var string Full title of article
	*/
	public $title = null;


/**
	*	@var string Short headline of Article
	*/
	public $headline = null;

	/**
	*	@var string HTML content of article
	*/
	public $content = null;


/** TODO:
*	optional: name for the link which shows the article page
*/

/**
*	Sets object's properties from values stored in supplied array
*/

public function __construct( $data = array() ) {
	if ( isset( $data['id'] ) ) $this->id = (int) $data['id'];
	if ( isset( $data['pageId'])) $this->pageId = (int) $data['pageId'];
	if ( isset( $data['publicationDate'] ) ) $this->publicationDate = (int) $data['publicationDate'];
	if ( isset( $data['title'] ) ) $this->title = $data['title'];
	if ( isset( $data['headline'] ) ) $this->headline = $data['headline'];
	if ( isset( $data['content'] ) ) $this->content =  $data['content'];
}

/**
* Sets the object's properties using the edit form post values
*/

public function storeFormValues( $params ) {
	// Store all params
	$this->__construct( $params );


	// Parse and store publication Date

	if ( isset($params['publicationDate'])) {
		$publicationDate = explode('-', $params['publicationDate']);

		if (count($publicationDate) == 3) {
			list ($y, $m, $d) = $publicationDate;
			$this->publicationDate = mktime( 0,0,0, $m, $d, $y);
		}
	}
}

/**
* returns Article object matching the given article ID
*	@param int The article ID
* @return Article|false The article object, or false if nothing was found or error occured
*/

public function getArticleById( $id ) {
	$conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
	$sql = "SELECT *, UNIX_TIMESTAMP(publicationDate) AS publicationDate FROM articles WHERE id = :id";
	$st = $conn->prepare( $sql );
	$st->bindValue(":id", $id, PDO::PARAM_INT);
	$st->execute();
	$row = $st->fetch();
	$conn = null;
	if ($row) return new Article($row);
}



/**
* returns all Articles in the DB
*	@param int Optional number of rows (default=all)
* @param string Optional column by which to order the articles
* @return Array|false a two element array : result => array,  totalRows => Total number of articles
*/

public function getList( $numRows=1000000, $order="publicationDate DESC") {
	$conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
	$sql = "SELECT SQL_CALC_FOUND_ROWS *, UNIX_TIMESTAMP(publicationDate) AS publicationDate FROM articles ORDER BY " . mysql_escape_string($order) . " LIMIT :numRows";
	$st = $conn->prepare( $sql );
	$st->bindValue(":numRows", $numRows, PDO::PARAM_INT);
	$st->execute();
	$list = array();

	while ( $row = $st->fetch() ) {
		$article = new Article( $row );
		$list[] = $article;
	}

	// Now get total number of articles that matched the criteria
	$sql = "SELECT FOUND_ROWS() AS totalRows";
	$totalRows = $conn->query( $sql )->fetch();
	$conn = null;
	return (array( "results" => $list, "totalRows" => $totalRows[0]));

}

/**
* returns all Articles in the DB matching the given page ID
* @param int page Number
*	@param int Optional number of rows (default=all)
* @param string Optional column by which to order the articles
* @return Array|false a two element array : result => array,  totalRows => Total number of articles
*/

public function getArticlesByPage( $page = 1, $numRows=100000, $order="publicationDate DESC") {
	$conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
	$sql = "SELECT *, UNIX_TIMESTAMP(publicationDate) AS publicationDate FROM articles WHERE pageId = :pageId ORDER BY " . mysql_escape_string($order) . " LIMIT :numRows";
	$st = $conn->prepare( $sql );
	$st->bindValue(":numRows", $numRows, PDO::PARAM_INT);
	$st->bindValue(":pageId", $page, PDO::PARAM_INT);
	
	$st->execute();
	$list = array();

	while ( $row = $st->fetch() ) {
		$article = new Article( $row );
		$list[] = $article;
	}

	// Now get total number of articles that matched the criteria
	$sql = "SELECT FOUND_ROWS() AS totalRows";
	$totalRows = $conn->query( $sql )->fetch();
	$conn = null;
	return (array( "results" => $list, "totalRows" => $totalRows[0]));

}

/**
* Inserts the current Article object into the database and sets its ID property
*/

public function insert() {
	// Does the Article object already have an ID?
	if (!is_null( $this->id )) trigger_error("Article::insert()Attempt to insert an Article object that already has its ID property set (to $this->id).", E_USER_ERROR );
	
	trigger_error("j");
	// Insert the article
	$conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
	$sql = "INSERT INTO articles (publicationDate, title,  headline, content, pageId) VALUES ( FROM_UNIXTIME(:publicationDate), :headline, :title, :content, :pageId);";
	$st = $conn->prepare( $sql );
	$st->bindValue(":publicationDate", $this->publicationDate, PDO::PARAM_INT);
	$st->bindValue(":title", $this->title, PDO::PARAM_STR);
	$st->bindValue(":headline", $this->headline, PDO::PARAM_STR);
	$st->bindValue(":content", $this->content , PDO::PARAM_STR);
	$st->bindValue(":pageId", $this->pageId, PDO::PARAM_INT);

	$st->execute();
	

	$this->id = $conn->lastInsertId();
	$conn = null;

}

/**
 * Updates the current Article object in the database 
 */

public function update() {

	// Does the Article object have an ID?
  if ( is_null( $this->id ) ) trigger_error ( "Article::update(): Attempt to update an Article object that does not have its ID property set.", E_USER_ERROR );

		// Update the Article
  $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
  $sql = "UPDATE articles SET publicationDate=FROM_UNIXTIME(:publicationDate), title=:title, headline=:headline, pageId=:pageId, content=:content WHERE id = :id";
  $st = $conn->prepare ( $sql );
  $st->bindValue( ":publicationDate", $this->publicationDate, PDO::PARAM_INT );
  $st->bindValue( ":title", $this->title, PDO::PARAM_STR );
  $st->bindValue( ":headline", $this->headline, PDO::PARAM_STR );
  $st->bindValue( ":content", $this->content, PDO::PARAM_STR );
  $st->bindValue( ":pageId", $this->pageId, PDO::PARAM_INT );
  $st->bindValue( ":id", $this->id, PDO::PARAM_INT );
  $st->execute();
  $conn = null;
}
/**
 * Deletes the current Article object from the database.
 */
 
  public function delete() {
 
    // Does the Article object have an ID?
    if ( is_null( $this->id ) ) trigger_error ( "Article::delete(): Attempt to delete an Article object that does not have its ID property set.", E_USER_ERROR );
 
    // Delete the Article
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $st = $conn->prepare ( "DELETE FROM articles WHERE id = :id LIMIT 1" );
    $st->bindValue( ":id", $this->id, PDO::PARAM_INT );
    $st->execute();
    $conn = null;
  }
 



}

?>