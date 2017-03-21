<?php

require("config.php");
session_start();
$action = isset( $_GET['action'] ) ? $_GET['action'] : "";
$username = isset( $_SESSION['username'] ) ? $_SESSION['username'] : "";

if ( $action != "login" && $action != "logout" && !username) {
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
		else {
			// User has not posted login form yet
			require( TEMPLATE_PATH . "/admin/loginForm.php");
		}
	}
}



function logout() {
	unset( $_SESSION['username']);
	header( "Location: admin.php" );
}

function newArticle() {
	
}