<?php


//INSERT INTO `categories` (`name`, `safename`, `description`, `parent`, `postcount`, `threadcount`)
// VALUES ('General', 'general', '', '0', '777', '666');

$action = "forum";
if (isset($_GET["cat"])) {
	$registration = $db->prepare("SELECT count(*) FROM `categories` WHERE safename = ?;");
	$registration->execute(array($_GET["cat"]));
	if ($registration->fetchColumn() > 0) {
		$action = "category";
	} else {
		$action = "badcategory";
	}
}


if ($action === "forum") {
	$parent = 0;
	include_once($includedir."cattable.php");
} else if ($action === "badcategory") {
	echo "Category does not exist.";
} else if ($action === "category") {

	$categoryq = $db->prepare("SELECT * FROM `categories` WHERE safename = ?;");
	$categoryq->execute(array($_GET["cat"]));
	$category = $categoryq->fetch();

	// Show subcategories
	// Used by cattable.php
	$parent = $category["id"];
	$catdisplay = $category["parent"];
	include_once($includedir."cattable.php");


	// Show threads
	if ($catdisplay > 0) {

		// Used by threadtable.php
		$categoryid = $parent;

		// Counter for post number on page
		$threadi = 0;

		// Show stickied threads
		$stickied = 1;
		include($includedir."threadtable.php");

		// Show normal threads
		$stickied = 0;
		include($includedir."threadtable.php");

		if ($threadi == 0) {
			echo "No threads found.<br>\r\n";
		}
	}
}


?>