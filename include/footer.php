		</div>
		<div class="footer">
			<div class="linkgrid">
				<div class="footsection">
					<h4>Navigation</h4>
					<?php
					foreach ($settings_navurls as $key => $value) {
						echo '
							<a href="'.$value.'">'.$key.'</a>';
					}
					if (!$user_loggedin) {
						?>
							<a href="?action=login">Login</a>
							<a href="?action=register">Register</a>
						<?php
					} else {
						?>
							<a href="?action=logout">Logout</a>
						<?php
					}
					?>
				</div>
				<div class="footsection threads">
					<h4>Latest Threads</h4>

					<?php echo display_lastestThreads(0, 5); ?>

				</div>
				<div class="footsection posts">
					<h4>Latest Posts</h4>

					<?php echo display_latestPosts(0, 5); ?>

				</div>
			</div>
			<br>
			<?php echo "<b>".$site_footer."</b><span style=\"float: right;\">Page rendered in ".round((microtime(true) - $pagestart), 4)." seconds.</span>"; ?>
		</div>
	</div>
</body>
</html>