<?php

// Cache of users to avoid useless queries
$usercache = array();
$rankcache = array();
$groupcache = array();

include_once("config.php");

include_once("dbfunctions.php");
include_once("displayfunctions.php");

include_once("auth.php");

include_once($config_defaultavatar."header.php");


$pageinclude = $config_defaultavatar."forum.php";

if (isset($_GET["action"])) {
	if ($_GET["action"] == "register") {
		$pageinclude = $config_defaultavatar."register.php";
	} else if ($_GET["action"] == "login") {
		$pageinclude = $config_defaultavatar."login.php";
	} else if ($_GET["action"] == "logout") {
		session_unset();
		$user_loggedin = false;
		header("Location: ?action=login");
		$pageinclude = $config_defaultavatar."login.php";
	} else {
		$pageinclude = $config_defaultavatar."error.php";
	}
} else if (isset($_GET["thread"])) {
	$pageinclude = $config_defaultavatar."thread.php";
} else if (isset($_GET["user"])) {
	$pageinclude = $config_defaultavatar."user.php";
} else {
	$pageinclude = $config_defaultavatar."forum.php";
}

if ($settings_requireinvites && !$user_loggedin) {
	if (!in_array($pageinclude, $settings_inviteonlywhitelist)) {
		$pageinclude = $config_defaultavatar."login.php";
	}
}
include_once($pageinclude);

include_once($config_defaultavatar."footer.php");
?>