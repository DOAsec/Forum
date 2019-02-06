<div class="navlinks">
	<a href="?">Home</a>
<?php
if (!$user_loggedin) {
	?>
		<a href="?action=login">Login</a>
		<a href="?action=register">Register</a>
	</div>
	<?php
} else {
	?>
		<a href="?action=logout">Logout</a>
	</div>
	<div class="userinfo">
		<?php
		if (isset($_SESSION["token"]["userdata"])) {
			$user = $_SESSION["token"]["userdata"];

			// Query rank if not cached
			$rankcache[$user["rankid"]] = $rank = queryById("ranks", $rankcache, $user["rankid"]);

			// Query group if not cached
			$groupcache[$user["groupid"]] = $group = queryById("groups", $groupcache, $user["groupid"]);

			?>
			<div class="data">
				<?php
				// Display username
				echo '<a href="?user='.$user["id"].'" class="usera"><span style="color: '.htmlspecialchars($rank["color"]).';">'.htmlspecialchars($user["username"]).'</span></a>';
				?>
				<br>
				<?php
				// Display group and rank
				echo '<span style="color: '.htmlspecialchars($group["color"]).';">'.htmlspecialchars($group["name"]).'</span> <span style="color: '.htmlspecialchars($rank["color"]).';">'.htmlspecialchars($rank["name"]).'</span>';
				?>
			</div>
			<?php
			echo avatar_sm($user);
		}
		?>
	</div>
	<?php
}

?>