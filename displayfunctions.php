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

function latestPosts($id = 0, $limit = 10) {
	global $user_loggedin;
	global $settings_requireinvites;
	?>
	<table>
		<tr>
			<td>
				<b>Thread</b>
			</td>
			<td>
				<b>Posted</b>
			</td>
			<td>
				<b>Text</b>
			</td>
		</tr>
	<?php
	if (!$user_loggedin && $settings_requireinvites) {
		?>
		<tr>
			<td colspan="3">You must be registered.</td>
		</tr>
		<?php
	} else {
		if ($id == 0) {
			$posts = queryLatestOrderByXWhere("posts", "id", "approved", 1, $limit);
		} else {
			$posts = queryLatestOrderByXWhere("posts", "id", "accountid", $id, $limit);
		}

		$catcache = array();
		$threadcache = array();

		foreach ($posts as $post) {
			$thread = queryById("threads", $threadcache, $post["threadid"]);
			$postpage = calcPostPage(queryCountLt("posts", "threadid", $post["threadid"], "id", $post["id"]) + 1);

			?>
			<tr>
				<td>
					<?php echo '<a href="?thread='.$thread["safesubject"].'&page='.$postpage.'#'.$thread["safesubject"].$post["id"].'">'.htmlspecialchars($thread["subject"]).'</a>'; ?>
				</td>
				<td>
					<?php echo date(DATE_RFC2822, $post["timestamp"]); ?>
				</td>
				<td>
					<?php echo substr($post["body"], 0, 32); if (strlen($post["body"]) > 32) { echo "..."; } ?>
				</td>
			</tr>
			<?php
		}
	}
	?>
	</table>
	<?php
}


function lastestThreads($id = 0, $limit = 10) {
	global $user_loggedin;
	global $settings_requireinvites;
	?>
	<table>
		<tr>
			<td>
				<b>Category</b>
			</td>
			<td>
				<b>Thread</b>
			</td>
			<td>
				<b>Posted</b>
			</td>
			<td>
				<b>Views</b>
			</td>
			<td>
				<b>Replies</b>
			</td>
		</tr>
	<?php
	if (!$user_loggedin && $settings_requireinvites) {
		?>
		<tr>
			<td colspan="3">You must be registered.</td>
		</tr>
		<?php
	} else {
		if ($id == 0) {
			$threads = queryLatestOrderByXWhere("threads", "timestamp", "approved", 1, 5);
		} else {
			$threads = queryLatestOrderByXWhere("threads", "timestamp", "accountid", $id, 10);
		}

		$catcache = array();

		foreach ($threads as $thread) {
			?>
			<tr>
				<td>
					<?php
					$category = queryById("categories", $catcache, $thread["categoryid"]);
					echo '<a href="?cat='.htmlspecialchars($category["safename"]).'">'.htmlspecialchars($category["name"]).'</a>';
					?>
				</td>
				<td>
					<?php echo '<a href="?thread='.$thread["safesubject"].'">'.htmlspecialchars($thread["subject"]).'</a>'; ?>
				</td>
				<td>
					<?php echo date(DATE_RFC2822, $thread["timestamp"]); ?>
				</td>
				<td>
					<?php echo $thread["viewscache"]; ?>
				</td>
				<td>
					<?php echo $thread["repliescache"]; ?>
				</td>
			</tr>
			<?php
		}
	}
	?>
	</table>
	<?php
}

function threadLink($thread, $text = "", $page = 1) {
	if ($text == "") {
		$text = $thread["subject"];
	}
	$class = ' class="pagination"';
	if ($text == $page) {
		$class = ' class="pagination cpage"';
	}
	return '<a'.$class.' href="?thread='.$thread["safesubject"].'&page='.$page.'">'.htmlspecialchars($text).'</a>';
}

?>