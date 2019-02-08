<?php
session_start();

$userform_username = "u53rn4m3";
$userform_password = "p455w0rd";


$user_loggedin = false;

// Token that will be set if the session is valid to prevent cookie hijacking
function createToken() {
	$tokenua = $tokencs = $tokenlang = $tokenuname = "";
	if (isset($_SERVER['HTTP_USER_AGENT'])) {
		$tokenua = $_SERVER['HTTP_USER_AGENT'];
	}
	if (isset($_SERVER['HTTP_ACCEPT_CHARSET'])) {
		$tokencs = $_SERVER['HTTP_ACCEPT_CHARSET'];
	}
	if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
		$tokenlang = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
	}
	if (isset($_SESSION["token"]["userdata"]["username"])) {
		$tokenuname = $_SESSION["token"]["userdata"]["username"];
	}
	$tokenstring = $tokenua.$tokencs.$tokenlang.$tokenuname.$REMOTE_ADDR;

	return $tokenstring;
}


if (isset($_SESSION["token"]["safetycheck"])) {
	if ($_SESSION["token"]["safetycheck"] !== createToken()) {
		session_unset();
	} else if (isset($_SESSION["token"]["userdata"])) {
		if ($_SESSION["token"]["userdata"]) {
			$user_loggedin = true;
		}
	}
} else {
	$_SESSION["token"]["safetycheck"] = createToken();
}



if (!isset($_SESSION["userform_attempts"]) || !isset($_SESSION["userform_attemptsallowed"])) {
	$_SESSION["userform_attempts"] = 0;
	$_SESSION["userform_attemptsallowed"] = mt_rand(4, 8);
	// If we are in the process of creating the first session and we are on the login page, we want to add a delay.
	// This makes bruteforcers slower, as getting the session will require either two page loads or a long delay on the first
	if (isset($_GET["action"])) {
		if ($_GET["action"] == "login") {
			sleep(mt_rand(3, 8));
		}
	}
}
if (isset($_SESSION["userform_username"])) {
	$userform_username = $_SESSION["userform_username"];
} else {
	$_SESSION["userform_username"] = $userform_username = mt_rand(100, 999999999999);
}
if (isset($_SESSION["userform_password"])) {
	$userform_password = $_SESSION["userform_password"];
} else {
	$_SESSION["userform_password"] = $userform_password = mt_rand(100, 999999999999);
}


//if ($_POST) {
	if (isset($_POST[$userform_username]) && isset($_POST[$userform_password])) {
		$passwordhash = "aaaaaaaaaaaaaaaaaaaaaaaaaaaa";
		//echo $_POST[$userform_username].":".$passwordhash."<br>\r\n";

		// Too many password attempts
		if ($_SESSION["userform_attemptsallowed"] <= $_SESSION["userform_attempts"]) {
			$loginmessage = "Try again. Security measure triggered.";

			sleep(mt_rand(3, 8));

			$_SESSION["userform_attempts"] = 0;
			$_SESSION["userform_attemptsallowed"] = mt_rand(2, 4);
			$_SESSION["userform_username"] = $userform_username = mt_rand(100, 999999999999);
			$_SESSION["userform_password"] = $userform_password = mt_rand(100, 999999999999);
		} else {
			$accountq = $db->prepare("SELECT * FROM `accounts` WHERE username = ? AND password = ? AND isbanned = 0 LIMIT 1;");
			$accountq->execute(array($_POST[$userform_username], $passwordhash));
			$_SESSION["token"]["userdata"] = $accountq->fetch();

			if ($_SESSION["token"]["userdata"]) {
				//print_r($_SESSION["token"]["userdata"]);

				// Query rank if not cached
				$rankcache[$_SESSION["token"]["userdata"]["rankid"]] = $_SESSION["token"]["userrank"] = queryById("ranks", $rankcache, $_SESSION["token"]["userdata"]["rankid"]);

				// Query group if not cached
				$groupcache[$_SESSION["token"]["userdata"]["groupid"]] = $_SESSION["token"]["usergroup"] = queryById("groups", $groupcache, $_SESSION["token"]["userdata"]["groupid"]);

				// Set to valid token
				$_SESSION["token"]["safetycheck"] = createToken();

				$user_loggedin = true;
				header("Location: ?");
			} else {
				$loginmessage = "Login credentials invalid.            ";
			}
		}

		$_SESSION["userform_attempts"]++;
	}
//}

?>
