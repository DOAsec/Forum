<?php
$pagestart = microtime(true); // Time the page load.

// Hardcoded values to reduce database usage and provide info about the site even on database failure
$site_name = "Forum";
$site_tagline = "This is only a simulation.";
$site_description = "";
$site_footer = "&copy; ".date("Y")." ".$site_name.". All your base are belong to us.";

$REMOTE_ADDR = $_SERVER["REMOTE_ADDR"];

$config_defaultavatar = "include/";
$config_dbfailfile = "nodb.php";

$settings_themename = "default";
$settings_avatardir = "files/avatars/";
$settings_defaultavatar = "defaulticon.png";
$settings_defaultgroup = 1;
$settings_defaultrank = 1;
$settings_threadsperpage = 6;
$settings_navurls = array("Back to Portfolio" => "../");
$settings_minpwlen = 6;
$settings_invitecodes = 5;
$settings_requireinvites = true;
$settings_inviteonlywhitelist = array($config_defaultavatar."register.php", $config_defaultavatar."login.php");


// Strings to show as easter egss
$strings = array(
"Unfortunately, no one can be told what The Matrix is. You'll have to see it for yourself.",
"The answer is out there, Neo, and it's looking for you, and it will find you if you want it to.",
"\r\nDo not try and bend the spoon. That's impossible. Instead only try to realize the truth.\r\nWhat truth?\r\nThere is no spoon.\r\nThere is no spoon?\r\nThen you'll see that it is not the spoon that bends, it is only yourself.\r\n"
);
// Show a little joke
$numbersonlyerror = "Don't hack me please! ;)";
// Universal invite key
$skeletoninvitekey = "YouWillNeverGuessThisPhraseAnyTimeSoon!!!";




if ( basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"]) ) {
	shuffle($strings);
	die("<!-- ".$strings[0]." -->");
} else {
	$db_host = "localhost";
	$db_name = "forumdb";
	$db_user = "forumuser";
	$db_pass = "password";

	$details = "mysql:dbname=".$db_name.";host=".$db_host;

	try {
	    @$db = new PDO($details, $db_user, $db_pass);
	} catch(PDOException $error) {
		include_once($config_defaultavatar."header.php");
	    include_once($config_defaultavatar.$config_dbfailfile);
	    include_once($config_defaultavatar."footer.php");
	    die();
	}
}





?>
