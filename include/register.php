<?php

// INSERT INTO `accounts` (`email`, `username`, `password`, `rankid`, `groupid`, `postcount`, `regip`, `regtime`, `invitecodes`)
// VALUES ('root@hackcult', 'root', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaa', '1', '4', '5', '127.0.0.1', now(), '999');


?>

<div class="forumsection registersection" >
	<form method="post">
		<table>
			<thead class="fhead">
				<tr>
					<td colspan="2" style="color: #FFF;">
						<b>Register</b>
					</td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="labeltd">
						<label for="email">E-Mail</label>
					</td>
					<td class="inputtd">
						<input type="email" name="email" placeholder="email@example.com" />
					</td>
				</tr>
				<tr>
					<td class="labeltd">
						<label for="username">Username</label>
					</td>
					<td class="inputtd">
						<input type="text" name="username" placeholder="username" />
					</td>
				</tr>
				<tr>
					<td class="labeltd">
						<label for="password">Password</label>
					</td>
					<td class="inputtd">
						<input type="password" name="password" placeholder="password" />
					</td>
				</tr>
				<tr>
					<td class="labeltd">
						<label for="v_password">Verify Password</label>
					</td>
					<td class="inputtd">
						<input type="password" name="v_password" placeholder="verify password" />
					</td>
				</tr>
				<?php
				if ($settings_requireinvites) {
				?>
				<tr>
					<td class="labeltd">
						<label for="invitecode">Invite Code</label>
					</td>
					<td class="inputtd">
						<input type="text" name="invitecode" placeholder="0000-0000-0000-0000" />
					</td>
				</tr>
				<?php
				}
				?>
				<tr>
					<td colspan="2" class="tdcenter">
						<input type="submit" name="register" value="Register" />
					</td>
				</tr>
				<?php

				// Process user registration

				$register_error = "";
				if (isset($_POST["email"]) && isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["v_password"])) {
					if ($_POST["email"] == "" && $_POST["username"] == "" && $_POST["password"] == "" && $_POST["v_password"] == "") {
						$register_error = "Please fill out the form to register.";
					} else if ($settings_requireinvites && !isset($_POST["invitecode"])) {
						$register_error = "You must have an invite code.";
					} else {

						// Validate form
						if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
							$register_error = "Email is invalid.";
						} else if (getUID($_POST["username"])) {
							$register_error = "Username is taken.";
						} else if (strlen($_POST["password"]) < $settings_minpwlen) {
							$register_error = "Password too short.";
						} else if ($_POST["password"] != $_POST["v_password"]) {
							$register_error = "Passwords do not match.";
						}
					}

					if ($register_error == "") {

						// Insert registration info to db

						


						$register_error = "Registration complete.";

					}

					if ($register_error != "") {
						?>
						<tr>
							<td colspan="2" class="tdcenter">
								<?php echo $register_error; ?>
							</td>
						</tr>	
						<?php
					}
				}
				?>
			</tbody>
		</table>
	</form>
</div>
