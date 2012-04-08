<?php
	require_once('./recaptchalib.php');
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
	    echo 'capcha_error';
	    die();
  	}
  	else
	{
			$username  = mysql_enteries_fix_string($_POST['username']);
			$password  = mysql_enteries_fix_string($_POST['password']);
			$email     = mysql_enteries_fix_string($_POST['email']);
			$random = rand(30, 100)*rand(7574,324)*rand(323,876);
			$date = time();
			$sql = "INSERT INTO users(rowID, username, password, email, security_code, last_sub_check)
					VALUES(NULL, '$username', '$password', '$email', $random, '$date')";
			$result = mysql_query($sql,$con);
			
				$subject = "Filehunt signup";
				$password_lenght = strlen($password);
				$body = "Hi!

					Welcome to filehunt!
					In case you forgot your username for filehunt is: $username

					Sincerly
					The fileHunt team";
				mail($email, $subject, $body, 'From: Filehunt@filehunt.com');
					
				$sql    = "SELECT *
							FROM users
							WHERE username='$username' LIMIT 1";
				$result = mysql_query($sql,$con);
				$row    = mysql_fetch_array($result);
				session_start();
				$_SESSION['dbuserid']   = $row['rowID'];
				echo 'true';
			

		}

?>
