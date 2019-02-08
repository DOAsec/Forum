<?php

function queryById($table, $cachevar, $id) {
	return queryByX($table, $cachevar, $id, "id");
}

function queryByX($table, $cachevar, $id, $x) {
	global $db;

	if (isset($cachevar[$id])) {
		$result = $cachevar[$id];
	} else {
		$qs = "SELECT * FROM `".$table."` WHERE ".$x." = ?;";
		$q = $db->prepare($qs);
		$q->execute(array($id));
		$result = $q->fetch();
	}
	
	return $result;
}

function queryAllByX($table, $id, $x) {
	global $db;

	$qs = "SELECT * FROM `".$table."` WHERE ".$x." = ?;";
	$q = $db->prepare($qs);
	$q->execute(array($id));
	$result = $q->fetchAll();
	
	return $result;
}

function queryLatestOrderByX($table, $x) {
	global $db;

	$qs = "SELECT * FROM `".$table."` ORDER BY ".$x." DESC;";
	$q = $db->prepare($qs);
	$q->execute();
	$result = $q->fetchAll();
	
	return $result;
}

function queryLatestOrderByXWhere($table, $x, $what, $where, $limit = 10) {
	global $db;

	$qs = "SELECT * FROM `".$table."` WHERE ".$what." = ? ORDER BY ".$x." DESC LIMIT ".$limit.";";
	$q = $db->prepare($qs);
	$q->execute(array($where));
	$result = $q->fetchAll();
	
	return $result;
}

function queryCount($table, $x, $id) {
	global $db;

	$qs = "SELECT count(*) FROM `".$table."` WHERE ".$x." = ?;";
	$q = $db->prepare($qs);
	$q->execute(array($id));
	$result = $q->fetch();
	
	return $result[0];
}

function queryCountLt($table, $x, $id, $what, $where) {
	global $db;

	$qs = "SELECT count(*) FROM `".$table."` WHERE ".$x." = ? AND ".$what." < ?;";
	$q = $db->prepare($qs);
	$q->execute(array($id, $where));
	$result = $q->fetch();
	
	return $result[0];
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