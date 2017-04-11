<?php 
	require("../config.php");
	
?>
<!DOCTYPE html>
<html lang="de">

	<head>
		<meta charset="UTF-8">
		<title><?php echo htmlspecialchars( $results['pageTitle']) ?></title>
		<link rel="stylesheet" type="text/css" href="_/css/normal-screens/styles.css" media="all and (min-width: 46.8em)">
		<link rel="stylesheet" type="text/css" href="_/css/small-screens/styles.css" media="all and (max-width: 46.8em)">
		<link href="https://fonts.googleapis.com/css?family=Monda" rel="stylesheet">
		<link rel="stylesheet" href="jsIncludes/jquery.mCustomScrollbar.css" />

		<meta name="viewport" content="width=device-width,  initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	</head>
	
	<body>

	<div class="side-logo">
		<span class="title"><a href=".">Ivan Bazak</a></span>
	</div>

	<div class="currentPage"> <!-- position fixed/absolute -->
		<?php echo htmlspecialchars( $_POST['title']) ?>
	</div>

	<div id="container">
<?php
	include "../templates/include/sidemenu.php"; 
?>


<div id="wrapper">
	<div id="articles"> <!-- stays so that css is consistent with articles page -->

	<div class="article">
		<h2>
			<span class="title"><?php echo htmlspecialchars($_POST['title']); ?></span>
		</h2>

<?php $content = $_POST['content'];
			$images = Image::getImagesByArticleId( $_POST['article_id'] );
			$content = Image::insertImages( $content, $images, '[IMAGE]' );
 ?>
			<div class="content"><?php echo $content ?></div>

	


	<!-- Show all iamges -->
<?php /**$images = Image::getImagesByArticleId( $_POST['article_id'] );
			foreach ($images as $image) {  ?>		
				<div class="article-image">
<?php $class = ($image->orientation == IMAGE_PORTRAIT) ? "portrait " : "landscape ";
			switch ($image->presentation_size) {
				case IMAGE_SIZE_SMALL:
					$path = SMALL_IMAGE_PATH;
					$class .= "image-small";
					break;
				case IMAGE_SIZE_MEDIUM:
					$path = MEDIUM_IMAGE_PATH;
					$class .= "image-medium";
					break;
				case IMAGE_SIZE_LARGE:
					$path = LARGE_IMAGE_PATH;
					$class .= "image-large";
					break;
			} // switch
?>			
				<img src="<?php echo $path . "/" . $image->source ?>" alt="<?php echo $image->subtitle ?>" 
					class="<?php echo $class ?>"/>
			</div> <!-- article-image -->

<?php } **/?>
		


	</div> <!-- article -->
	
	<div id="footer">
			&copy;2017 Ivan Bazak. Eberhard Schneider.<br> <a href="admin.php">Site Admin</a>
	</div>	
	</div>

</div>

<?php 

// function insertImages( $content, $images, $tag ) {

// 	$index = 0;

// 	while ( $pos = strpos( $content, $tag ) ) {

// 		if ( ! ($index < count( $images) ) ) {
// 			$content = str_replace( $tag, "", $content);
// 			break;
// 		}
// 		$image = $images[ $index ];


// 		$class = ($image->orientation == IMAGE_PORTRAIT) ? "portrait " : "landscape ";
// 		switch ($image->presentation_size) {
// 			case IMAGE_SIZE_SMALL:
// 				$path = SMALL_IMAGE_PATH;
// 				$class .= "image-small";
// 				break;
// 			case IMAGE_SIZE_MEDIUM:
// 				$path = MEDIUM_IMAGE_PATH;
// 				$class .= "image-medium";
// 				break;
// 			case IMAGE_SIZE_LARGE:
// 				$path = LARGE_IMAGE_PATH;
// 				$class .= "image-large";
// 				break;
// 		} // switch
		
// 		// $image_html = "<div class='article-image'>";
// 		$image_html = "<img src='$path/$image->source '  alt='$image->subtitle' class='$class'/>";


// 		$content = substr_replace( $content, $image_html, $pos, strlen( $tag ));
// 		$index++;
// 	}
// 		return $content;
// 	} ?>