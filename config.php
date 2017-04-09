<?php
ini_set("display_errors", true);
date_default_timezone_set("Europe/Berlin");
define("DB_DSN","mysql:host=localhost;dbname=cms;charset=utf8");
define("DB_USERNAME","root");
define("DB_PASSWORD","root");
// define("DB_DSN","mysql:host=rdbms.strato.de;dbname=DB2924883;charset=utf8");
// define("DB_USERNAME","U2924883");
// define("DB_PASSWORD","kolo222kolo");

define("CLASS_PATH","classes");
define("TEMPLATE_PATH","templates");
define("ADMIN_USERNAME","root");
define("ADMIN_PASSWORD","root");
define("SITE_ROOT", realpath(dirname(__FILE__)));

define("LARGE_IMAGE_PATH","images/large");
define("MEDIUM_IMAGE_PATH","images/medium");
define("SMALL_IMAGE_PATH","images/small");
define("THUMBS_IMAGE_PATH","images/thumbs");
define("FULLSIZE_IMAGE_PATH","images/fullsize");
define("JPEG_QUALITY","85");
// size constants
define("IMAGE_SIZE_SMALL","0");
define("IMAGE_SIZE_MEDIUM","1");
define("IMAGE_SIZE_LARGE","2");
define("IMAGE_PORTRAIT", "0");
define("IMAGE_LANDSCAPE", "1");
// define exact size of different images
// we only define larger side, to preserve ratio, we compute the other
define("IMAGE_PIXEL_SIZE_THUMB", "150");
define("IMAGE_PIXEL_SIZE_SMALL", "400");
define("IMAGE_PIXEL_SIZE_MEDIUM", "800");
define("IMAGE_PIXEL_SIZE_LARGE", "1200");




// here the required classes

require( CLASS_PATH . "/article.php");
require( CLASS_PATH . "/image.php");
require( CLASS_PATH . "/ImageManipulator.php");
/**function handleException( $exception ) {
  echo "Sorry, a problem occurred. Please try later.";
  error_log( $exception->getMessage() );
}
 
//set_exception_handler( 'handleException' );
?>
*/