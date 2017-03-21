<?php
ini_set("display_errors", true);
date_default_timezone_set("Europe/Berlin");
define("DB_DSN","mysql:host=localhost;dbname=cms");
define("DB_USERNAME","root");
define("DB_PASSWORD","root");
define("CLASS_PATH","classes");
define("TEMPLATE_PATH","templates");
define("ADMINE_USERNAME","ivan");
define("ADMIN_PASSWORD","ivan");

// here the required classes

require( CLASS_PATH . "/article.php");
require( CLASS_PATH . "/page.php");
require( CLASS_PATH . "/image.php");

function handleException( $exception ) {
  echo "Sorry, a problem occurred. Please try later.";
  error_log( $exception->getMessage() );
}
 
set_exception_handler( 'handleException' );
?>
