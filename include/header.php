<!DOCTYPE html>
<html>
<head>
	<title><?php echo $site_name." - ".$site_tagline; ?></title>
	<link rel="stylesheet" type="text/css" href="theme/<?php echo $settings_themename; ?>/main.css">
</head>
<body>
	<div class="page">
		<div class="header">
			<div class="headtext">
				<a href="?"><h1><?php echo $site_name; ?></h1></a>
				<h2><?php echo $site_tagline; ?></h2>
			</div>
			<div class="headnav">
				<?php include_once($config_defaultavatar."navigation.php"); ?>
			</div>
		</div>
		<div class="body">