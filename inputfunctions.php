<?php


//
function input_checkRegistrationPost() {
	global $_POST;

	if (isset($_POST["email"]) && isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["v_password"])) {
		if ($_POST["email"] == "" || $_POST["username"] == "" || $_POST["password"] == "" || $_POST["v_password"] == "") {
			return false;
		}
		return true;
	}

	return false;
}

function input_checkRegistration() {
	global $_POST;
	global $settings_requireinvites;
	global $settings_minpwlen;

	$register_response = "";
	$register_bool = false;

	if ($_POST["email"] == "" && $_POST["username"] == "" && $_POST["password"] == "" && $_POST["v_password"] == "") {
		$register_response = "Please fill out the form to register.";
	} else if ($settings_requireinvites && !isset($_POST["invitecode"])) {
		$register_response = "You must have an invite code.";
	} else {

		// Validate form
		if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
			$register_response = "Email is invalid.";
		} else if (db_getUID($_POST["username"])) {
			$register_response = "Username is taken.";
		} else if (strlen($_POST["password"]) < $settings_minpwlen) {
			$register_response = "Password too short.";
		} else if ($_POST["password"] != $_POST["v_password"]) {
			$register_response = "Passwords do not match.";
		}
	}

	if ($register_response == "") {

		$register_response = "Registration complete.";
		$register_bool = true;

	}

	return array($register_bool, $register_response);
}


function input_doRegistration() {
	global $_POST;
	global $REMOTE_ADDR;
	global $settings_defaultrank;
	global $settings_defaultgroup;
	global $settings_invitecodes;

	$passwordhash = password_hash($_POST["password"], PASSWORD_BCRYPT);

	db_registerUser($_POST["email"], $_POST["username"], $passwordhash, "", $settings_defaultrank, $settings_defaultgroup, $REMOTE_ADDR, $settings_invitecodes);
}


?>