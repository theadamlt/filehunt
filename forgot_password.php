<?php
require_once('lib.php');
if(__FILE__ == $_SERVER['SCRIPT_FILENAME'])
	{
		header('Location: index.php?page=forgot_password');
		die();
	}
mysql_selector();


if(isset($_POST['username']) && isset($_POST['email']))
{
	$username = mysql_enteries_fix_string($_POST['username']);
	$email = mysql_enteries_fix_string($_POST['email']);
	$sql = "SELECT * FROM users WHERE username='$username' AND email='$email' LIMIT 1";
	$result = mysql_query($sql,$con);
	$row = mysql_fetch_array($result);
	$username_r = $row['username'];
	$sec_code = $row['security_code'];
	$message = "Hi $username_r
It seems like you have been trying to reset you password on filehunt.
http://filehunt.netau.net/?page=reset_password&yes=true
Click on the link and insert this code to reset your password:
$sec_code

Sincerly
The filehunt team";

	if(mail($row['email'], 'Password Reset', $message, 'From: Filehunt@filehunt.com'))
		{ 
			$email_r = $row['email'];
			header("Location: ?page=search&newPasswordEmailSent=$email_r");
			//echo "<div id='success'>An email has been sent to you at $email_r</div>";
		}
		else echo <<< _END
		<div id="error">Something went wrong</div>';
	<form class="form" action="?page=forgot_password" method="post">
<p class="usermame">
	<input type="text" name="username" id="username" />
	<label for="username">Username<label>
</p>
<p class="email">
	<input type="email" name="email" id="email" />
	<label for="email">Email</label>
</p>
<p class="submit">
	<input type="submit" value="Submit" />
</p>
</form>
_END;
}
else
{
	echo '<center>
<form class="form" action="?page=forgot_password" method="post">
<p class="usermame">
	<input type="text" name="username" id="username" />
	<label for="username">Username<label>
</p>
<p class="email">
	<input type="email" name="email" id="email" />
	<label for="email">Email</label>
</p>
<p class="submit">
	<input type="submit" value="Submit" />
</p>
</form>
</center>';
}
?>
