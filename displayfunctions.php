<?php
function avatar_sm($user) {
	global $settings_avatardir;
	global $settings_defaultavatar;

	if ($user["avatar"] != "") {
		return '<img class="sm_avatar" src="'.$settings_avatardir.$user["avatar"].'" />';
	} else {
		return '<img class="sm_avatar" src="'.$settings_avatardir.$settings_defaultavatar.'" />';
	}
}

function avatar($user) {
	global $settings_avatardir;
	global $settings_defaultavatar;

	if ($user["avatar"] != "") {
		return '<img class="avatar" src="'.$settings_avatardir.$user["avatar"].'" />';
	} else {
		return '<img class="avatar" src="'.$settings_avatardir.$settings_defaultavatar.'" />';
	}
}

function calcPostPage($postnum) {
	global $settings_threadsperpage;

	if ($postnum < $settings_threadsperpage) {
		return 1;
	} else {
		return ceil($postnum / $settings_threadsperpage);
	}
}
?>