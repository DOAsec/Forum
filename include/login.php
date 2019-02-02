<div class="forumsection loginsection" >
	<form method="post">
		<table>
			<thead class="fhead">
				<tr>
					<td colspan="2" style="color: #FFF;">
						<b>Login</b>
					</td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="labeltd">
						<label for="<?php echo $userform_username; ?>">Username:</label>
					</td>
					<td class="inputtd">
						<input type="text" name="<?php echo $userform_username; ?>" placeholder="Username" />
					</td>
				</tr>
				<tr>
					<td class="labeltd">
						<label for="<?php echo $userform_password; ?>">Password:</label>
					</td>
					<td class="inputtd">
						<input type="text" name="<?php echo $userform_password; ?>" placeholder="Password" />
					</td>
				</tr>
				<tr>
					<td colspan="2" class="tdcenter">
						<input type="submit" name="login" value="Login" />
					</td>
				</tr>
				<?php
				if (isset($loginmessage)) {
					?>
				<tr>
					<td colspan="2" class="tdcenter">
						<?php echo $loginmessage; ?>
					</td>
				</tr>
				<?php
				}
				?>
				<tr>
					<td colspan="2" class="tdcenter">
						<a href="?action=forgot">Forgot Password</a>
						|
						<a href="?action=register">Register</a>
					</td>
				</tr>
			</tbody>
		</table>
	</form>
</div>