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
				<div class="footsection">
					<h4>Latest Threads</h4>
				</div>
				<div class="footsection">
					<h4>Latest Posts</h4>
				</div>
			</div>
			<br>
			<?php echo "<b>".$site_footer."</b><span style=\"float: right;\">Page rendered in ".round((microtime(true) - $pagestart), 4)." seconds.</span>"; ?>
		</div>
	</div>
</body>
</html>