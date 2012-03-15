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
	$result = mysql_query($sql,$con);

	if (mysql_num_rows($result)==1)
	{	
		$row = mysql_fetch_array($result);
		$_SESSION['dbuserid']   = $row['rowID'];

		if($_POST['remember'])
		{
			setcookie("dbuserid", $row['rowID'], time()+604800);
		}

		if(isset($_GET['attemptedSite']) && $_GET['attemptedSite']=='comments' && isset($_GET['fileID']))
		{
			header('Location: ?page=comments&fileID='.$_GET['fileID']);
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
	echo "<div id='error'>You need to login first!</div>
";
}
	
?>
<h1 style="text-align:center;">Login</h1>

<?if (isset($_GET['wrongLogin'])) echo '<div id="error">Wrong username or password</div>
' ?>
<div id="login">

<form class="form" action="?<?php echo $_SERVER['QUERY_STRING']?>" method="post" onsubmit="validate_login()" name="login">
<p class="name">
	<input type="text" name="username" placeholder="Username" id="username" />
	<label for="name">Username</label>
</p>

<p class="password">
	<input type="password" name="password" placeholder="Password" id="password" />
	<label for="password">Password</label>
</p>
<p class="checkbox">
	<label for="checkbox">Remember me</label>
	<input type="checkbox" name="remember" value="true" checked id="checkbox"></p>
<p class="submit">
	<input type="hidden" name="start" />
	<input type="submit" value="Login" ></p>
</form>
<a href="?page=forgot_password">Forgot password?</a>
</div>