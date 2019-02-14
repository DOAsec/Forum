<?php

if ($stickied) {
	$stickytitle = "Stickied Threads";
} else {
	$stickytitle = "Normal Threads";
}

?>
<div class="forumsection">
	<table>
<?php
$y = 0;
foreach ($db->query("SELECT * FROM threads WHERE categoryid = ".$categoryid." AND approved = 1 AND stickied = ".$stickied) as $thread) {
	
	if ($y == 0) {
		?>
		<thead>
			<tr>
				<td colspan="5">
					<?php echo $stickytitle; ?>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					Thread
				</td>
				<td style="width: 5%;">
					Replies
				</td>
				<td style="width: 5%;">
					Views
				</td>
				<td style="width: 30%;">
					Last Post
				</td>
			</tr>
		</thead>
		<tbody>
		<?php
	}

	// Query rank if not cached
	$rankcache[$user["rankid"]] = $rank = db_queryById("ranks", $rankcache, $user["rankid"]);

	// Query group if not cached
	$groupcache[$user["groupid"]] = $group = db_queryById("groups", $groupcache, $user["groupid"]);

	?>
		<tr>
			<td class="thumb">
				<img src="https://via.placeholder.com/45" />
			</td>
			<td class="forum">
				<?php echo '<a href="?thread='.$thread["safesubject"].'">'.htmlspecialchars($thread["subject"]).'</a>
				<br>
				<a href="?user='.$user["id"].'" class="usera"><span style="color: '.htmlspecialchars($rank["color"]).';">'.htmlspecialchars($user["username"]).'</span></a>'; ?>
			</td>
			<td>
				<?php echo $thread["repliescache"]; ?>
			</td>
			<td>
				<?php echo $thread["viewscache"]; ?>
			</td>
			<td>
				<?php
				$lastthread = $thread["id"];

				if ($lastthread) {

					$ltq = $db->prepare("SELECT * FROM `posts` WHERE threadid = ? ORDER BY timestamp DESC LIMIT 1;");
					$ltq->execute(array($lastthread["id"]));
					$lastpost = $ltq->fetch();

					if ($lastpost) {
						// Query user if not cached
						if (isset($usercache[$lastpost["accountid"]])) {
							$user = $usercache[$lastpost["accountid"]];
						} else {
							$userq = $db->prepare("SELECT * FROM `accounts` WHERE id = ?;");
							$userq->execute(array($lastpost["accountid"]));
							$usercache[$lastpost["accountid"]] = $user = $userq->fetch();
						}

						// Query rank if not cached
						if (isset($rankcache[$user["rankid"]])) {
							$rank = $rankcache[$user["rankid"]];
						} else {
							$rankq = $db->prepare("SELECT * FROM `ranks` WHERE id = ?;");
							$rankq->execute(array($user["rankid"]));
							$rankcache[$user["rankid"]] = $rank = $rankq->fetch();
						}

						echo '<a href="?user='.$user["id"].'"  class="usera"><span style="color: '.htmlspecialchars($rank["color"]).';">'.htmlspecialchars($user["username"]).'</span></a> posted at '.date(DATE_RFC2822, $lastpost["timestamp"]);
					} else {
						echo 'No posts.';
					}
				}
				?>
			</td>
		</tr>
	<?php
	$y++;
	$threadi++;
}

?>
		</tbody>
	</table>
</div>