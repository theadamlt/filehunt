<?php
require_once('lib.php');
mysql_selector();

if (isset($_SESSION['dbusername']) && isset($_SESSION['dbpassword']))
{
	header('Location: ?page=search');
	die();
}


if (isset($_POST['username']) && (isset($_POST['password'])) && (!isset($_SESSION['dbusername'])))
{
	$username = mysql_enteries_fix_string($_POST['username']);
	$password = MD5(mysql_enteries_fix_string($_POST['password']));

	$sql = "SELECT * FROM users WHERE username='$username' AND password='$password' LIMIT 1";
	$result = mysql_query($sql,$con);

	if (mysql_num_rows($result)==1)
	{	
		$row = mysql_fetch_array($result);
		$_SESSION['dbusername'] = $row['username'];
		$_SESSION['dbpassword'] = $row['password'];
		$_SESSION['dbuserid']   = $row['rowID'];
		$_SESSION['dbemail']    = $row['email'];
		if(isset($_GET['uploadAttempt']) && $_GET['uploadAttempt']!='comments')
		{
			header("Location: ?page=".$_GET['attemptedSite']);
		}
		elseif(isset($_GET['attemptedSite']) && $_GET['attemptedSite']=='comments' && isset($_GET['fileID']))
		{
			header('Location: ?page=comments&fileID='.$_GET['fileID']);
		}
	} 
	else
	{
		header('Location: ?page=login&wrongLogin=true');
		die();
	}
}
if (isset($_GET['uploadAttempt']))
{
	echo "<div id='error'>You need to login first!</div>";
}
	
?>


<h1 style="text-align:center;">Login</h1>

<?if (isset($_GET['wrongLogin'])) echo '<div id="error">Wrong username or password</div>' ?>

<div id="login">

<form class="form" action="?<?php echo $_SERVER['QUERY_STRING']?>"
 method="post">
<p class="name">
	<input type="text" name="username" placeholder="Username" id="username" />
	<label for="name">Username</label> 
</p>

<p class="password">
	<input type="password" name="password" placeholder="Password" id="password" />
	<label for="password">Password</label>
</p>
<p class="submit">
	<input type="hidden" name="start" />
	<input type="submit" value="Login" >
</p>
</form>
<a href="?page=forgot_password">Forgot password?</a>


</div>