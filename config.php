<?php
ini_set("display_errors", true);
date_default_timezone_set("Europe/Berlin");
define("DB_DSN","mysql:host=localhost;dbname=cms;charset=utf8");
define("DB_USERNAME","root");
define("DB_PASSWORD","root");
define("CLASS_PATH","classes");
define("TEMPLATE_PATH","templates");
define("ADMIN_USERNAME","ivan");
define("ADMIN_PASSWORD","ivan");
define("SITE_ROOT","localhost/ivan");

define("IMG_PATH","images");

// here the required classes

require( CLASS_PATH . "/article.php");
require( CLASS_PATH . "/image.php");

/**function handleException( $exception ) {
  echo "Sorry, a problem occurred. Please try later.";
  error_log( $exception->getMessage() );
}
 
//set_exception_handler( 'handleException' );
?>
*/