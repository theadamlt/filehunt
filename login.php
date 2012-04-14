<?php
require_once('lib.php');
if(__FILE__ == $_SERVER['SCRIPT_FILENAME'])
{
	header('Location: index.php?page='.substr(end(explode('/', $_SERVER['SCRIPT_FILENAME'])),0,-4).'?'.$_SERVER['QUERY_STRING']);
	die();
}

if (isset($_SESSION['dbuserid']))
{
	header('Location: ?page=search');
	die();
}
if (isset($_GET['attemptedSite']))
{
	echo "<div id='error'>You need to login first!</div>";
}
	
?>
<h1 style="text-align:center;">Login</h1>
<div id="login">
<div id="error"></div>
<form class="form" name="login" onsubmit="return reqLogin();">
	<table>
		<tr>
			<td>
				<input type="text" name="username" placeholder="Username" id="username" />
			</td>
			<td>
				<label for="name">Username</label>
			</td>
		</tr>
		<tr>
			<td>
				<input type="password" name="password" placeholder="Password" id="password" />
			</td>
			<td>
				<label for="password">Password</label>
			</td>
		</tr>
		<tr>
			<td>
				<label for="checkbox">Remember me</label>
			</td>
			<td>
				<input type="checkbox" name="remember" value="true" checked id="checkbox"></td>
		</tr>
		<tr>
			<td class="submit">
				<input type="submit" value="Login">
			</td>
		</tr>
	</table>
</form>
<a href="?page=forgot_password">Forgot password?</a>
</div>