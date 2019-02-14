<?php

/*

/////////////////////////////////////////

Add Pagination!

Page selection works, but there are no links and the code is not aware of the total number of pages required to display all posts in a thread.

/////////////////////////////////////////

*/


// Query for the thread
$thread = queryByX("threads", $threadcache, $_GET["thread"], "safesubject");

// Check to see if thread was found
if ($thread) {
	// Query user if not cached
	if (isset($usercache[$thread["accountid"]])) {
		$user = $usercache[$thread["accountid"]];
	} else {
		$userq = $db->prepare("SELECT * FROM `accounts` WHERE id = ?;");
		$userq->execute(array($thread["accountid"]));
		$usercache[$thread["accountid"]] = $user = $userq->fetch();
	}

	// Query rank if not cached
	if (isset($rankcache[$user["rankid"]])) {
		$rank = $rankcache[$user["rankid"]];
	} else {
		$rankq = $db->prepare("SELECT * FROM `ranks` WHERE id = ?;");
		$rankq->execute(array($user["rankid"]));
		$rankcache[$user["rankid"]] = $rank = $rankq->fetch();
	}

	// Query group if not cached
	if (isset($groupcache[$user["groupid"]])) {
		$group = $groupcache[$user["groupid"]];
	} else {
		$groupq = $db->prepare("SELECT * FROM `groups` WHERE id = ?;");
		$groupq->execute(array($user["groupid"]));
		$groupcache[$user["groupid"]] = $group = $groupq->fetch();
	}

	// Set up category navigation
	$curcat = queryById("categories", array(), $thread["categoryid"]);
	$catstring = '<a href="?cat='.htmlspecialchars($curcat["safename"]).'" class="cpage">'.htmlspecialchars($curcat["name"]).'</a>';
	while ($curcat["parent"] != 0) {
		$curcat = queryById("categories", array(), $curcat["parent"]);
		$catstring = '<a href="?cat='.htmlspecialchars($curcat["safename"]).'">'.htmlspecialchars($curcat["name"]).'</a> '.$catstring;
	}
	$catstring = '<a href="?">Home</a> '.$catstring;


	// Set up current page info
	$page = 1;
	$offset = 0;
	$postnum = 0;
	if (isset($_GET["page"])) {
		if (is_numeric($_GET["page"]) && $_GET["page"] > 0) {
			$page = $_GET["page"];
			$offset = (($page - 1) * $settings_threadsperpage);
			
		} else {
			die($numbersonlyerror);
		}
	}

	// Get page count for pagination
	$pagecount = ceil((queryCount("posts", "threadid", $thread["id"]) + 1) / $settings_threadsperpage);

	// Set up page navigation
	$paginationstring = "";
	if ($page > 1) {
		$paginationstring .= " ".threadLink($thread, "<< ", 1, $page);
	}
	if ($page > 2) {
		$paginationstring .= " ".threadLink($thread, "< ", $page - 1, $page);
	}
	for ($pagei = 1; $pagei < ($pagecount + 1); $pagei++) {
		$paginationstring .= threadLink($thread, $pagei, $pagei, $page);
	}
	if ($page < $pagecount - 1) {
		$paginationstring .= " ".threadLink($thread, ">", $page + 1, $page);
	}
	if ($page < $pagecount) {
		$paginationstring .= " ".threadLink($thread, ">>", $pagecount, $page);
	}
	?>
	<div class="catnav">
		<?php
			echo '
			<div>'.$catstring.'</div>
			<div>'.$paginationstring.'</div>';
		?>
	</div>

	<div class="forumsection">
		<table>
			<thead class="fhead">
				<tr>
					<td colspan="2" class="tdcenter">
						<?php echo htmlspecialchars($thread["subject"]); ?>
					</td>
				</tr>
				<tr>
					<td class="fdesc tdcenter" style="width: 15%;">
						Author
					</td>
					<td class="fdesc">
						Message
					</td>
				</tr>
			</thead>
			<tbody>
				<?php

					if ($page == 1) {
						$firstpost = true;
						include($config_defaultavatar."posttable.php");
					}

					$firstpost = false;

					foreach ($db->query("SELECT * FROM posts WHERE threadid = ".$thread["id"]." ORDER BY id ASC LIMIT ".$settings_threadsperpage." OFFSET ".$offset.";") as $post) {
						$postnum++;


						
						// Query user if not cached
						$usercache[$post["accountid"]] = $user = queryById("accounts", $usercache, $post["accountid"]);

						// Query rank if not cached
						$rankcache[$user["rankid"]] = $rank = queryById("ranks", $rankcache, $user["rankid"]);

						// Query group if not cached
						$groupcache[$user["groupid"]] = $group = queryById("groups", $groupcache, $user["groupid"]);
						

						include($config_defaultavatar."posttable.php");
					}
				?>
			</tbody>
		</table>
	</div>

	<div class="catnav">
		<?php
			echo '
			<div>'.$paginationstring.'</div>
			<div>'.$catstring.'</div>';
		?>
	</div>

	<div class="forumsection">
		<form method="POST">
			<table class="createpost">
				<thead class="fhead">
					<tr>
						<td colspan="2">
							New Post
						</td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							Subject:
						</td>
						<td>
							<input type="text" name="post_subject" placeholder="Post Subject" />
						</td>
					</tr>
					<tr>
						<td>
							Body:
						</td>
						<td>
							<textarea name="post_content"></textarea>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<input type="submit" value="New Post" />
						</td>
					</tr>
				</tbody>
			</table>
		</form>
	</div>



	<?php
	} else {
		?>
	<div class="forumsection">
		<div class="noticetext">Thread does not exist.</div>
	</div>
		<?php
	}
	?>
