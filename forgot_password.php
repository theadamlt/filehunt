<?php
require_once('lib.php');
if(__FILE__ == $_SERVER['SCRIPT_FILENAME'])
	{
		header('Location: index.php?page=forgot_password');
		die();
	}
if(isset($_SESSION['dbuserid']))
{
	header('Location: ?page=search');
	die();
}
?>
<h1>Forgot password</h1>
<br>
<p id="mes">Please enter you username and email-address</p>
<div id="error"></div>
<div id="success"></div>
<div id="forgot">
<form class="form" name="forgot_password" onsubmit="return forgotPassword();">
	<table>
		<tr>
			<td>
				<input type="text" name="username" id="username"></td>
			<td>
				<label for="username">Username</label>
			</td>
		</tr>
		<tr>
			<td>
				<input type="email" name="email" id="email">
			</td>
			<td>
				<label for="email">Email</label>
			</td>
		</tr>
		<tr>
			<td class="submit">
				<input type="submit" value="Submit"></td>
		</tr>
	</table>
</form>
</div>