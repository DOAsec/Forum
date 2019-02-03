<?php

// Cache of users to avoid useless queries
$usercache = array();
$rankcache = array();
$groupcache = array();

include_once("config.php");

include_once("dbfunctions.php");
include_once("displayfunctions.php");

include_once("auth.php");

include_once($includedir."header.php");


$pageinclude = $includedir."forum.php";

if (isset($_GET["action"])) {
	if ($_GET["action"] == "register") {
		$pageinclude = $includedir."register.php";
	} else if ($_GET["action"] == "login") {
		$pageinclude = $includedir."login.php";
	} else if ($_GET["action"] == "logout") {
		session_unset();
		$user_loggedin = false;
		header("Location: ?action=login");
		$pageinclude = $includedir."login.php";
	} else {
		$pageinclude = $includedir."error.php";
	}
} else if (isset($_GET["thread"])) {
	$pageinclude = $includedir."thread.php";
} else if (isset($_GET["user"])) {
	$pageinclude = $includedir."user.php";
} else {
	$pageinclude = $includedir."forum.php";
}

if ($require_invites && !$user_loggedin) {
	if (!in_array($pageinclude, $inviteonly_pages)) {
		$pageinclude = $includedir."login.php";
	}
}
include_once($pageinclude);

include_once($includedir."footer.php");
?>