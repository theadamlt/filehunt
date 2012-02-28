<?php
require_once("lib.php");
if(__FILE__ == $_SERVER['SCRIPT_FILENAME'])
	{
		header('Location: index.php?page=signup');
		die();
	}
mysql_selector();

if (isset($_SESSION['dbusername']))
{
	header('Location: ?page=search');
	die();
}

if (isset($_POST['username']) && (isset($_POST['password'])) && (isset($_POST['password2']) && (isset($_POST['email']))))
{
	require_once('recaptchalib.php');
	if($_SERVER['HTTP_HOST'] =='localhost') $privatekey = "6LewEM4SAAAAAFb7bWOf7PWVH1c6aarqrk8quPOZ";
	if($_SERVER['HTTP_HOST'] =='85.83.1.123') $privatekey = "6LdnNM4SAAAAANM1Pn1m9u9vn4si_0APRAO7Draa";
	if($_SERVER['HTTP_HOST'] =='filehunt.netau.net') $privatekey = "6LevEM4SAAAAAPL6_aWkuYYTw7cW9OY6fkly6Xhg";
	if($_SERVER['HTTP_HOST'] =='10.180.2.167') $privatekey = "6Le4M84SAAAAAMwymwm6YVRAuLFyB0zTrlQK0kIl";

	$resp = recaptcha_check_answer ($privatekey,
    $_SERVER["REMOTE_ADDR"],
    $_POST["recaptcha_challenge_field"],
    $_POST["recaptcha_response_field"]);

	if (!$resp->is_valid)
	{
	    // What happens when the CAPTCHA was entered incorrectly
	    header('Location: ?page=signup&captchaErr=true');
	    die();
	    //die ("<div id='error>'The reCAPTCHA wasn't entered correctly. Go back and try it again</div>");
  	}
  	else
	{
	if($_POST['username']!='' || $_POST['password']!='' || $_POST['password2']!='' || $_POST['email']!='')
	{
		$username  = mysql_enteries_fix_string($_POST['username']);
		$password  = mysql_enteries_fix_string($_POST['password']);
		$password2 = mysql_enteries_fix_string($_POST['password2']);
		$email     = mysql_enteries_fix_string($_POST['email']);

		if($password == $password2)
		{
			//Check if user exists
			$sql = "SELECT * FROM users WHERE username='$username' OR email='$email'";
			$result = mysql_query($sql,$con);
			$numrows = mysql_num_rows($result);
			if($numrows!=0) echo '<div id="error"><b>Oups... Username or email already exists in database. Try another one</b></div>';
			else
			{
				$random = rand(30, 100)*rand(7574,324)*rand(323,876);
				$sql = "INSERT INTO 
				users(rowID, username, password, email, security_code, admin) 
				VALUES(NULL, '$username', MD5('$password'), '$email', $random, '0')";
				if (!$result = mysql_query($sql,$con))
				{
					header('Location:');
					die();
				}
				else 
				{
					$subject = "Filehunt singup";
					$password_lenght = strlen($password);
					$body = "Hi!


					Welcome to filehunt!
					In case you forgot your username for http://filehunt.com is: $username and your password contains $password_lenght digits

					Sincerly
					The fileHunt team";
					mail($email, $subject, $body, 'From: Filehunt@filehunt.com');
					
					$sql    = "SELECT * FROM users WHERE username='$username' LIMIT 1";
					$result = mysql_query($sql,$con);
					$row    = mysql_fetch_array($result);
					
					$_SESSION['dbusername'] = $row['username'];
					$_SESSION['dbpassword'] = $row['password'];
					$_SESSION['dbuserid']   = $row['rowID'];
					$_SESSION['dbemail']    = $row['email'];

					header('Location: ?page=search&signupCompleted=true');
					die();

				}
			}
		} else echo '<div id="error"><b>Oups... The passwords did not match. Try again</b></div>';
	}
	else
	{
		header('Location: ?page=signup&signupEmpty=true');
		die();
	}
}
}
?>
<h1 style="text-align:center;">Signup</h1>
<div id="signup">

<? if (isset($_GET['signupEmpty'])) echo '<div id="error">You left somwthing empty. Try again</div>'; ?>

<form class="form" action="?page=signup" method="post">
<p class="username">
	<input type="text" name="username" placeholder="Username" id="username" />
	<label for="username">Username</label>
</p>

<p class="password">
	<input type="password" name="password" placeholder="Password" id="password" />
	<label for="password">Password</label>
</p>
<p class="password">
	<input type="password" name="password2" placeholder="Password again" id="password2" />
	<label for="password2">Password Again</label>
</p>
<p class="email">
	<input type="email" name="email" placeholder="Email" id="email" />
	<label for="email">Email</label>
</p>
<?php
	require_once('recaptchalib.php');
	if($_SERVER['HTTP_HOST']=='85.83.1.123') $publickey = "6LdnNM4SAAAAAGyaTpT4VCx7Ig4UZJ9YL0vUYTeT"; // you got this from the signup page
	if($_SERVER['HTTP_HOST']=='localhost') $publickey = "6LewEM4SAAAAAEzOcFxG0mJ1g1FE-SGb9KtQZAeN"; // you got this from the signup page
	if($_SERVER['HTTP_HOST']=='filehunt.netau.net') $publickey = "6Le7M84SAAAAALJaZciDaXI-BkCuwU7ftbt1ZoIZ"; // you got this from the signup page
	if($_SERVER['HTTP_HOST']=='10.180.2.167' )$publickey = "6Le4M84SAAAAAFu5m6IE_LERTQK--fIrEaqHoHuX"; // you got this from the signup page
    echo '<center>'.recaptcha_get_html($publickey).'</center>';
?>
<p class="submit">
	<input type="hidden" name="start" />
	<input type="submit" value="Signup"/>
</p>
</form>
</div>
