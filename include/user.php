<div class="forumsection">
	<?php
	$userdata = queryById("accounts", $usercache, $_GET["user"]);
	if ($userdata != false) {
		print_r($userdata);
		?>
		<div class="usergrid">
			<div class="usercolumn">
				<h4><?php echo $userdata["username"]; ?></h4>

			</div>
		</div>
		<?php
	} else {
		echo '<div class="noticetext">User not found.</div>';
	}
	?>
</div>