<?php

function queryById($table, $cachevar, $id) {
	global $db;

	if (isset($cachevar[$id])) {
		$result = $cachevar[$id];
	} else {
		$qs = "SELECT * FROM `".$table."` WHERE id = ?;";
		$q = $db->prepare($qs);
		$q->execute(array($id));
		$result = $q->fetch();
	}
	
	return $result;
}

function getUID($username) {
	global $db;

	// I can only hope I remember to write this
	$registration = $db->prepare("SELECT count(*) FROM `accounts` WHERE username = ?;");
	$registration->execute(array($username));
	return $registration->fetchColumn();
}

function registerUser() {
	$qs = "INSERT INTO `accounts` (`refid`, `email`, `username`, `password`, `avatar`, `rankid`, `groupid`, `isbanned`, `postcount`, `regip`, `regtime`, `invitecodes`)
VALUES ('0', ?, ?, ?, ?, ?, ?, '0', '0', ?, now(), ?);";
	$q = $db->prepare($qs);
	$q->execute(array($id));
}
?>