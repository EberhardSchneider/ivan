<?php
ini_set("display_errors", true);
date_default_timezone_set("Europe/Berlin");
define("DB_DSN","mysql:host=rdbms.strato.de;dbname=DB2924883;charset=utf8");
define("DB_USERNAME","U2924883");
define("DB_PASSWORD","kolo222kolo");
define("CLASS_PATH","classes");
define("TEMPLATE_PATH","templates");
define("ADMIN_USERNAME","root");
define("ADMIN_PASSWORD","root");
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