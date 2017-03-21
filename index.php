<?php

require("config.php");
$action = isset( $_GET['action'] ) ? $_GET['action'] : "";

switch( $action ) {
	case 'showPage':
		showPage();
		break;
	case 'showArticle':
		showArticle();
		break;
	default:
		showWelcome();
}


function showPage() {
	$results = array();
	$page_id = isset( $_GET['page_id'] ? $_GET['page_id'] : 1;
	$data = Article::getArticlesByPage( $page_id );
	$result['articles'] = $data['results'];
	$result['totalRows'] = $data['totalRows'];

	// get Page title from DB
	$conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
	$sql = "SELECT * FROM pages WHERE id=:page_id";
	$st = $conn->prepare( $sql );
	$st->bindValue( ":page_id", $page_id, PDO::PARAM_INT );
	$st->execute();
	$row = $st->fetch();
	$conn = null;

	$results['pageTitle'] = $row['title'];

	require( TEMPLATE_PATH . "/showpage.php");

}

function showArticle() {
	if ( !isset( $_GET["articleId"]) || !$_GET['articleId']) {
		showWelcome();
		return;
	}

	$results = array();
	$results['article'] = Article::getById( (int)$_GET["articleId"]);
	$results['pageTitle'] = $results['article']->title;
	require( TEMPLATE_PATH . "/showpage.php");
}

function showWelcome() {
	$_GET['page_id'] = 1;
	showPage();
}

?>