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
				// Check POST data
				if ($_POST) {
					if (input_checkRegistrationPost()) {

						// Ensure we are able to register and get message
						$register_check = input_checkRegistration();
						$register_error = $register_check[1];

						if ($register_check[0]) {
							// Do registration
							input_doRegistration();
						}

						// Registration attempt response
						if ($register_error != "") {
							echo '
							<tr>
								<td colspan="2" class="tdcenter">
									'.$register_error.'
								</td>
							</tr>';
						}
					}
				}
				?>
			</tbody>
		</table>
	</form>
</div>
