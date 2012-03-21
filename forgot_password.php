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

if(isset($_GET['error']))
{
	echo'<div id="error">Somethings not right... Maybe you wrote something wrong? Try again</div>';
}


if(isset($_POST['username']) && isset($_POST['email']))
{
	$username = mysql_enteries_fix_string($_POST['username']);
	$email = mysql_enteries_fix_string($_POST['email']);
	$sql = "SELECT *
			FROM users
			WHERE username='$username'
			    AND email='$email' LIMIT 1";
	$result = mysql_query($sql,$con);
	$row = mysql_fetch_array($result);
	$username_r = $row['username'];
	$sec_code = $row['security_code'];
	$message = "Hi $username_r
It seems like you have been trying to reset you password on filehunt.
http://filehunt.pagodabox.com/?page=reset_password&yes=true
Click on the link above and insert this code to reset your password:
$sec_code

Sincerly
The filehunt team";

	if(mail($row['email'], 'Filehunt password reset', $message, 'From: noreply@filehunt.com'))
	{ 
		$email_r = $row['email'];
		header("Location: ?page=search&newPasswordEmailSent=$email_r");
	}
	else
	{
		header('Location: ?page=forgot_password&error=true');
		die();
	}
}
else
{
	echo '
		<form class="form" action="?page=forgot_password" method="post">
		<table>
		<tr>
			<td><input type="text" name="username" id="username"></td>
			<td><label for="username">Username</label></td>
		</tr>
		<tr>
			<td><input type="email" name="email" id="email"></td>
			<td><label for="email">Email</label></td>
		</tr>
		<tr>
			<td class="submit"><input type="submit" value="Submit"></td>
		</tr>
		</table>
		</form>
	';
}
?>
