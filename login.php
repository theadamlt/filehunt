<?php
require_once('lib.php');
if(__FILE__ == $_SERVER['SCRIPT_FILENAME'])
	{
		header('Location: index.php?page=login');
		die();
	}

if (isset($_SESSION['dbuserid']))
{
	header('Location: ?page=search');
	die();
}


if (isset($_POST['username']) && (isset($_POST['password'])) && (!isset($_SESSION['dbuserid'])))
{
	$username = mysql_enteries_fix_string($_POST['username']);
	$password = mysql_enteries_fix_string($_POST['password']);

	$sql = "SELECT *
			FROM users
			WHERE username='$username'
			    AND password='$password' LIMIT 1";
	$result = mysql_query($sql);

	if (mysql_num_rows($result) == 1)
	{	
		$row = mysql_fetch_array($result);
		$_SESSION['dbuserid'] = $row['rowID'];

		if($_POST['remember'])
		{
			setcookie("dbuserid", $row['rowID'], time()+604800);
		}

		if(isset($_GET['attemptedSite']) && $_GET['attemptedSite']=='report_abuse' && isset($_GET['reportedFile']))
		{
			header('Location: ?page=report_abuse&reportedFile='.$_GET['reportedFile']);
			die();
		}
		elseif(isset($_GET['attemptedSite']) && isset($_GET['fileID']) && $_GET['attemptedSite'] == 'fileinfo')
		{
			header('Location: ?page=fileinfo&fileID='.$_GET['fileID']);
			die();
		}
		if(isset($_GET['attemptedSite']))
		{
			header('Location: ?page='.$_GET['attemptedSite']);
			die();
		}
		else
		{
			header('Location: ?page=search');
			die();
		}
	} 
	else
	{
		header('Location: ?page=login&wrongLogin=true');
		die();
	}
}
if (isset($_GET['attemptedSite']))
{
	echo "<div id='error'>You need to login first!</div>";
}
	
?>
<h1 style="text-align:center;">Login</h1>
<?if (isset($_GET['wrongLogin'])) echo '<div id="error">Wrong username or password</div>
' ?>
<div id="login">
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