<?php
require_once("lib.php");
if(__FILE__ == $_SERVER['SCRIPT_FILENAME'])
	{
		header('Location: index.php?page=signup');
		die();
	}


if (isset($_SESSION['dbuserid']))
{
	header('Location: ?page=search');
	die();
}

if (isset($_POST['username']) && (isset($_POST['password'])) && (isset($_POST['password2']) && (isset($_POST['email']))))
{
	require_once('recaptchalib.php');
	if($_SERVER['HTTP_HOST'] =='localhost') $privatekey = "6LewEM4SAAAAAFb7bWOf7PWVH1c6aarqrk8quPOZ";
	elseif($_SERVER['HTTP_HOST'] =='85.83.1.123') $privatekey = "6LdnNM4SAAAAANM1Pn1m9u9vn4si_0APRAO7Draa";
	elseif($_SERVER['HTTP_HOST'] =='10.180.2.167') $privatekey = "6Le4M84SAAAAAMwymwm6YVRAuLFyB0zTrlQK0kIl";
	elseif($_SERVER['HTTP_HOST'] == 'filehunt.pagodabox.com') $privatekey = $_SERVER['CAPTCHA_PRIVATE'];

	$resp = recaptcha_check_answer ($privatekey,
    $_SERVER["REMOTE_ADDR"],
    $_POST["recaptcha_challenge_field"],
    $_POST["recaptcha_response_field"]);

	if (!$resp->is_valid)
	{
	    // What happens when the CAPTCHA was entered incorrectly
	    header('Location: ?page=signup&captchaErr=true');
	    die();
  	}
  	else
	{
	if($_POST['username']!='' || $_POST['password']!='' || $_POST['email']!='')
	{
		$username  = mysql_enteries_fix_string($_POST['username']);
		$password  = mysql_enteries_fix_string($_POST['password']);
		$password2  = mysql_enteries_fix_string($_POST['password2']);
		$email     = mysql_enteries_fix_string($_POST['email']);
		if($password == $password2)
		{
			//Check if user exists
			$sql = "SELECT *
					FROM users
					WHERE username='$username'
					    OR email='$email'";
			$result = mysql_query($sql,$con);
			$numrows = mysql_num_rows($result);
			if($numrows!=0) echo '
							<div id="error"> <b>Oups... Username or email already exists in database. Try another one</b> 
							</div>
							';
			else
			{
				$random = rand(30, 100)*rand(7574,324)*rand(323,876);
				$date = time();
				$sql = "INSERT INTO users(rowID, username, password, email, security_code, last_sub_check)
						VALUES(NULL, '$username', '$password', '$email', $random, '$date')";
				if (!$result = mysql_query($sql,$con))
				{
					header('Location: ?page=signup&signupError=true');
					die();
				}
				else 
				{
					$subject = "Filehunt signup";
					$password_lenght = strlen($password);
					$body = "Hi!


					Welcome to filehunt!
					In case you forgot your username for http://filehunt.com is: $username and your password contains $password_lenght digits

					Sincerly
					The fileHunt team";
					mail($email, $subject, $body, 'From: Filehunt@filehunt.com');
					
					$sql    = "SELECT *
								FROM users
								WHERE username='$username' LIMIT 1";
					$result = mysql_query($sql,$con);
					$row    = mysql_fetch_array($result);
					
					$_SESSION['dbuserid']   = $row['rowID'];
					header('Location: ?page=search&signupCompleted=true');
					die();

				}
			}
		}
		else
		{
			header('Location: ?page=signup&signupError=true');
			die();
		}
	}
	else
	{
		header('Location: ?page=signup&signupError=true');
		die();
	}
}
}
?>
<h1 style="text-align:center;">Signup</h1>
<div id="signup">
	<? if (isset($_GET['signupError'])) echo '<div id="error">
	Oups... You either left something empty or the passwords didn\'t match. Try again
</div>
'; ?>
<div id="signup_success"></div>
<div id="error"></div>
<form class="form" action="?page=signup" method="post" onsubmit="validateSignup()" name="signup">
	<table>
		<tr>
			<td>
				<input type="text" name="username" placeholder="Username" id="username" onfocusout="validateUsername()"/>
			</td>
			<td>
				<label for="name">Username</label>
			</td>
		</tr>
		<tr>
			<td>
				<input type="email" name="email" placeholder="Email" id="email" onfocusout="validateEmail()" />
			</td>
			<td>
				<label for="email">Email*</label>
			</td>
		</tr>
		<tr>
			<td>
				<input type="password" name="password" placeholder="Password" id="password" />
			</td>
			<td>
				<label for="password">Password*</label>
			</td>
		</tr>
		<tr>
			<td>
				<input type="password" name="password2" placeholder="Password again" id="password2" onfocusout="validatePassword()" />
			</td>
			<td>
				<label for="password2">Password Again*</label>
			</td>
		</tr>
		<tr>
			<td>
				<?php
	require_once('recaptchalib.php');
	if($_SERVER['HTTP_HOST']=='localhost') $publickey = "6LewEM4SAAAAAEzOcFxG0mJ1g1FE-SGb9KtQZAeN";
    elseif($_SERVER['HTTP_HOST']=='filehunt.pagodabox.com') $publickey = $_SERVER['CAPTCHA_PUBLIC'];
    echo '<center>'.recaptcha_get_html($publickey).'</center>
			';
    ?>
		</td>
	</tr>
	<tr>
		<input type="hidden" name="start" />
		<td class="submit">
			<input type="submit" value="Signup"/>
		</td>
	</tr>
</table>
</form>
</div>