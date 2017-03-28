<?php

require("config.php");
$action = isset( $_GET['action'] ) ? $_GET['action'] : "";
$page_id = isset( $_GET['page_id'] ) ? $_GET['page_id'] : 1;

switch( $action ) {
	case 'showPage':
		showPage( $page_id );
		break;
	case 'showArticle':
		showArticle();
		break;
	default:
		showWelcome();
}


function showPage( $page ) {

	

	$results = array();
	$data = Article::getArticlesByPage( $page );
	$results['articles'] = $data['results'];
	$results['totalRows'] = $data['totalRows'];

	// get Page info from DB
	$conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
	$sql = "SELECT * FROM pages WHERE id=:page_id";
	$st = $conn->prepare( $sql );
	$st->bindValue( ":page_id", $page, PDO::PARAM_INT );
	$st->execute();
	$row = $st->fetch();
	$conn = null;

	$results['pageTitle'] = $row['title'];
	$results['headlinePage'] = $row['headlinePage'];

	require( TEMPLATE_PATH . "/showpage.php");

}

function showArticle() {
	if ( !isset( $_GET["articleId"]) || !$_GET['articleId']) {
		showWelcome();
		return;
	}

	$results = array();
	
	$article = Article::getArticleById( (int)$_GET["articleId"]);
	$results['article'] = $article;
	$results['pageTitle'] = $article->title;
	require( TEMPLATE_PATH . "/showarticle.php");
}

function showWelcome() {
	$_GET['page_id'] = 1;
	showPage(1);
}

?>