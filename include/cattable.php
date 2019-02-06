<?php

if ( basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"]) ) {
	die("Direct access prohibited.");
} else {
	if (isset($parent)) {
		$i = 0;

	

		$catquery = "SELECT * FROM categories WHERE parent = ".$parent;
		if (isset($catdisplay)) {
			$catquery = "SELECT * FROM categories WHERE id = ".$parent;
		}
		
		
		foreach ($db->query($catquery) as $category) {

			$curcat = queryById("categories", array(), $category["id"]);
			$catstring = "";
			if ($curcat["parent"] != 0) {
				$catstring = '<a href="?cat='.htmlspecialchars($curcat["safename"]).'">'.htmlspecialchars($curcat["name"]).'</a>';
				while ($curcat["parent"] != 0) {
					$curcat = queryById("categories", array(), $curcat["parent"]);
					$catstring = '<a href="?cat='.htmlspecialchars($curcat["safename"]).'">'.htmlspecialchars($curcat["name"]).'</a> > '.$catstring;
				}
			} else {
				if (isset($_GET["cat"])) {
					$catstring = '<a href="?cat='.htmlspecialchars($curcat["safename"]).'">'.htmlspecialchars($curcat["name"]).'</a>';
				}
			}
			if ($catstring != "" && isset($_GET["cat"])) {
				$catstring = '<a href="?">Home</a> > '.$catstring;
			}
			?>
			<div class="catnav">
				<?php echo $catstring; ?>
			</div>

			<div class="forumsection">
				<table id ="<?php echo htmlspecialchars($category["safename"]); ?>">
					<thead class="fhead">
						<tr>
							<td colspan="6">
								<?php echo '<a href="?cat='.htmlspecialchars($category["safename"]).'" style="display: block;"><b>'.htmlspecialchars($category["name"]).'</b></a>'; ?>
							</td>
						</tr>
					<?php
					if ($category["description"] != "") {
						?>
						<tr>
							<td colspan="6" class="fdesc">

								<?php echo htmlspecialchars($category["description"]); ?>

							</td>
						</tr>
						<?php
					}
					?></thead>
					<tbody>
						
					<?php
					// Get subcategories
					$i = 0;

					$catquery = "SELECT * FROM categories WHERE parent = ".$category["id"];
					if (isset($catdisplay)) {
						$catquery = "SELECT * FROM categories WHERE parent = ".$parent;
					}
					
					foreach ($db->query($catquery) as $subcategory) {
						if ($i == 0) {
							?>
							<tr>
								<td colspan="2" style="width: 60%;">
									Forum
								</td>
								<td colspan="2" style="width: 15%; font-size: 90%; text-align: center;">
									Stats
								</td>
								<td colspan="2" style="width: 25%; text-align: center;">
									Last Post
								</td>
							</tr>
							<?php
						}
					?>
						<tr>
							<td class="thumb">
								<img src="https://via.placeholder.com/45" />
							</td>
							<td class="forum">
								<?php 
								echo '<b><a href="?cat='.htmlspecialchars($subcategory["safename"]).'">'.htmlspecialchars($subcategory["name"]).'</a></b>';
								if ($subcategory["description"] != "") {
									echo "
								<br>".htmlspecialchars($subcategory["description"]);
								}
								?>

							</td>
							<td class="tdcenter">
								<?php echo $subcategory["threadcount"]; ?> Threads
							</td>
							<td class="tdcenter">
								<?php echo $subcategory["postcount"]; ?> Posts
							</td>
							<td>
								<!-- Last Post. -->
								<?php
								$ltq = $db->prepare("SELECT * FROM `threads` WHERE categoryid = ? AND repliescache > 0 ORDER BY lastposttimestamp DESC LIMIT 1;");
								$ltq->execute(array($subcategory["id"]));
								$lastthread = $ltq->fetch();

								if ($lastthread) {

									$ltq = $db->prepare("SELECT * FROM `posts` WHERE threadid = ? ORDER BY timestamp DESC LIMIT 1;");
									$ltq->execute(array($lastthread["id"]));
									$lastpost = $ltq->fetch();

									$in = " in";
									if (!$lastpost) {
										$lastpost = $lastthread;
										$in = "";
									}

									// Query user if not cached
									$usercache[$lastpost["accountid"]] = $user = queryById("accounts", $usercache, $lastpost["accountid"]);

									// Query rank if not cached
									$rankcache[$user["rankid"]] = $rank = queryById("ranks", $rankcache, $user["rankid"]);

									echo '<a href="?user='.$user["id"].'" class="usera"><span style="color: '.htmlspecialchars($rank["color"]).';">'.htmlspecialchars($user["username"]).'</span></a> posted'.$in.' the thread "<a href="?thread='.$lastthread["safesubject"].'">'.$lastthread["subject"].'</a>" at '.date(DATE_RFC2822, $lastpost["timestamp"]);
									
								} else {
									echo 'No posts.';
								}
								?>
							</td>
							<td>
								<!-- Special Actions. -->
							</td>
						</tr>
					<?php
						$i++;
					}
					?>
			</tbody>
					</table>
				</div>
				<?php
				$i++;
			}
		
		if ($i == 0) {
			echo "No categories found.<br>\r\n";
		}
	} else {
		echo "parent required.";
	}
}