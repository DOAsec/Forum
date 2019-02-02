				<?php
				if ($firstpost) {
					echo '<tr id="'.htmlspecialchars($thread["safesubject"]).'">';
				} else {
					echo '<tr id="'.htmlspecialchars($thread["safesubject"]).$post["id"].'">';
				}
				?>
					<td class="tdcenter">
						<?php
						if ($user["avatar"] != "") {
							echo '<img class="avatar" src="'.$avatardir.$user["avatar"].'" />';
						} else {
							echo '<img class="avatar" src="'.$avatardir.$defaultavatar.'" />';
						}
						?>
						<br>
						<?php echo '<a href="?user='.$user["id"].'" class="usera"><span style="color: '.htmlspecialchars($rank["color"]).';">'.htmlspecialchars($user["username"]).'</span></a>'; ?>
						<br>
						<?php echo '<span style="color: '.htmlspecialchars($group["color"]).';">'.htmlspecialchars($group["name"]).'</span> <span style="color: '.htmlspecialchars($rank["color"]).';">'.htmlspecialchars($rank["name"]).'</span>'; ?>
						<br>
						<?php echo '<b>Posts</b>: '.$user["postcount"]; ?>
					</td>
					<td>
						<div class="posttop">
							<span style="float: left;"><?php echo htmlspecialchars($thread["subject"]).' &nbsp; <a href="#'.htmlspecialchars($thread["safesubject"]).$post["id"].'">Post #'.$postnum.'</a>'; ?></span>
							<span style="float: right;">
							<?php
							if (($p_timestamp != $p_edittimestamp) && $p_edittimestamp != 0) {
							?>
							<b>Edited</b>: 
							<?php
								echo date(DATE_RFC2822, $p_edittimestamp);
							}
							?>
							 <b>Posted</b>: <?php
							if ($firstpost) {
								$p_timestamp = $thread["timestamp"];
								$p_edittimestamp = $thread["edittimestamp"];
							} else {
								$p_timestamp = $post["timestamp"];
								$p_edittimestamp = $post["edittimestamp"];
							}

							echo date(DATE_RFC2822, $p_timestamp);
							?>
							</span>
						</div>
						<div class="postbody">
							<?php
							if ($firstpost) {
								echo htmlspecialchars($thread["body"]);
							} else {
								echo htmlspecialchars($post["body"]);
							}
							?>
						</div>
					</td>
				</tr>