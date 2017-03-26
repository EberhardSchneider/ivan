<?php

require("config.php");
session_start();
$action = isset( $_GET['action'] ) ? $_GET['action'] : "";
$username = isset( $_SESSION['username'] ) ? $_SESSION['username'] : "";


if ( $action != "login" && $action != "logout" && !$username ) {

	login();
	exit;
}

switch( $action ) {
	case 'login':
		login();
		break;
	case 'logout':
		logout();
		break;
	case 'newArticle':
		newArticle();
		break;
	case 'editArticle':
		editArticle();
		break;
	case 'deleteArticle':
		deleteArticle();
		break;
	default:
		listArticles();
}


function login() {
	$results = array();
	$results['pageTitle'] = "Admin Login";

	if ( isset( $_POST['login'] ) ) {
		// User has posted login form, attempt to log the user in
		if ($_POST['username'] == ADMIN_USERNAME && $_POST['password'] = ADMIN_PASSWORD) {
			// Login succesful: Create session and redirect to admin homepage
			$_SESSION['username'] = ADMIN_USERNAME;
			header( "Location: admin.php");
		} 
		else {
			// LOGIN failed: error message to user
			$results['errorMessage'] = "Incorrect username or password";
			require( TEMPLATE_PATH . "/admin/loginForm.php");
		}

	}
	else {
			// User has not posted login form yet
			require( TEMPLATE_PATH . "/admin/loginForm.php");
		}
}



function logout() {
	unset( $_SESSION['username']);
	header( "Location: admin.php" );
}

function newArticle() {

	$results = array();
	$results['pageTitle'] = "Neuer Eintrag";
	$results['formAction'] = "newArticle";

	if ( isset( $_POST['saveChanges']) ) {

		// User has posted article edit form: save new article
		$article = new Article();
		$article->storeFormValues( $_POST );
		$article->insert();
		header( "Location: admin.php&status=changesSaved");

	} 
	elseif ( isset( $_POST['cancel'])) {

		// User has cancelled their edits: return to list of articles
		header( "Location: admin.php" );
	}
	else {

		// User has not posted the article edit form yet: display the form
		$results['article'] = new Article();
		require( TEMPLATE_PATH . "/admin/editArticle.php");
	}

	
}


function editArticle() {
	$results = array();
	$results['pageTitle'] = "Eintrag bearbeiten";
	$results['formAction'] = "editArticle";

		if ( isset( $_POST['saveChanges']) ) {

				// User has posted article edit form: save new article
			if ( !$article = Article::getById( (int)$_POST['articleId'] ) ) {
				header( "Location: admin.php?error=articleNotFound");
				return;
			}


			$article->storeFormValues( $_POST );
			$article->update();
			header( "Location: admin.php&status=changesSaved");
		}
		elseif ( isset( $_POST['cancel'] ) ) {

			// User has cancelled edits: return to article list
			header( "Location: admin.php" );

		}
		else {

			// User has not postet the article edit form yet: display the form
			$results['article'] = Article::getById( (int)$_GET['articleId'] );
			require( TEMPLATE_PATH . "/admin/editArticle.php" );
		}

}


function deleteArticle() {

	if ( !$article = Article::getById( (int)$_GET['articleId'] ) ) {
		header( "Location: admin.php?error=articleNotFound" );
		return;
	}

	$article->delete();
	header( "Location: admin.php?status=articleDeleted" );

}

function listArticles() {
	$results = array();
	$data = Article::getList();
	$results['articles'] = $data['results'];
	$results['totalRows'] = $data['totalRows'];
	$results['pageTitle'] = "Alle Einträge";

	if ( isset( $_GET['error'] ) ) {
		if ( $_GET['error'] == "articleNotFound" ) $results['errorMessage'] = "Error: Article not found.";
	}

	if ( isset( $_GET['status']) ) {
		if ( $_GET['status'] == "changesSaved" ) $results['statusMessage'] = "Your changes have been saved.";
		if ( $_GET['status'] == "articleDeleted" ) $results['statusMessage'] = "Article deleted.";
	}

	require( TEMPLATE_PATH . "/admin/listArticles.php");
}

?>
