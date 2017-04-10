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


	<div class="currentPage"> <!-- position fixed/absolute -->
		<?php echo htmlspecialchars( $results['pageTitle']) ?>
	</div>

	<div id="admin-container">