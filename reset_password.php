<?php
require_once('lib.php');
if(__FILE__ == $_SERVER['SCRIPT_FILENAME'])
	{
		header('Location: index.php?page=reset_password');
		die();
	}
if(isset($_SESSION['dbuserid']))
{
	header('Location: ?page=search');
	die();
}

if (isset($_POST['username']) && isset($_POST['security_code']))
{
	$username      = mysql_enteries_fix_string($_POST['username']);
	$security_code = mysql_enteries_fix_string($_POST['security_code']);
	$sql = "SELECT *
			FROM users
			WHERE username='$username'
			    AND security_code=$security_code LIMIT 1";
	$result = mysql_query($sql,$con);
	if(mysql_num_rows($result) == 1)
	$row = mysql_fetch_array($result);
	$email = $row['email'];
		echo <<< _END
	<form class="form" name="reset" action="?page=reset_password&yes=true" method="post" onsubmit="validate_password_reset()"><table><tr><td><input type="password" name="password" id="password1"></td><td><label for="password1">New password</label></td></tr><tr><td><input type="password" name="password2" id="password2" /></td><td><label for="password2">New password again</label></td></tr><tr><input type="hidden" name="username" value="$username" /><input type="hidden" name="email" value="$email" /><input type="hidden" name="security_code" value="$security_code" /><td class="submit"><input type="submit" value="submit" /></td></tr></table></form>
_END;
}
else
{
	echo
<<< _END
	<form class="form" action="?page=reset_password&yes=true"  method="post"><table><tr><td><input type="text" name="username" id="username"></td><td><label for="username">Username</label></td></tr><tr><td><input type="text" name="security_code" id="security_code"></td><td><label for="security_code">Security code</label></td></tr><tr><td class="submit"><input type="submit" value="submit"></td></tr></table></form>
_END;
}

if(isset($_POST['password']))
{
		$password = mysql_enteries_fix_string($_POST['password']);
		$username = mysql_enteries_fix_string($_POST['username']);
		$email    = mysql_enteries_fix_string($_POST['email']);
		$random = $_POST['security_code'];
		$random_new = rand(30, 100)*rand(7574,324)*rand(323,876);
		$sql = "UPDATE users
				SET password='$password',
				             security_code=$random_new
				WHERE security_code=$random
				    AND username='$username' LIMIT 1";
		if($result =  mysql_query($sql,$con))
		{
			header('Location: ?page=search&newPassword=true');
			die();
		}
	else
	{
		header('Location: ?page=search&newPassword=false');
		die();
	}

}
if(isset($_SESSION['dbuserid']))
{
	header('Location: ?page=search');
	die();
}
elseif(!isset($_GET['yes']))
{
	header('Location: ?page=search');
	die();
}
?>