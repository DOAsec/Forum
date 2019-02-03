<?php
function avatar_sm($user) {
	global $avatardir;
	global $defaultavatar;

	if ($user["avatar"] != "") {
		return '<img class="sm_avatar" src="'.$avatardir.$user["avatar"].'" />';
	} else {
		return '<img class="sm_avatar" src="'.$avatardir.$defaultavatar.'" />';
	}
}

function avatar($user) {
	global $avatardir;
	global $defaultavatar;

	if ($user["avatar"] != "") {
		return '<img class="avatar" src="'.$avatardir.$user["avatar"].'" />';
	} else {
		return '<img class="avatar" src="'.$avatardir.$defaultavatar.'" />';
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