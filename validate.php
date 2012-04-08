<?php
require_once('lib.php');
mysql_selector();
//Does user exist?
if($_GET['func'] == 'u')
{
	$username = mysql_enteries_fix_string($_GET['u']);
	$sql = "SELECT * FROM users WHERE username='$username'";
	$result = mysql_query($sql);
	if(mysql_num_rows($result) == 0 && $username != '') echo 'true';
	else echo 'false';
}

//Is email already used?
elseif($_GET['func'] == 'm')
{
	$email = trim(mysql_enteries_fix_string($_GET['m']));
	$regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/'; 
	if (preg_match($regex, $email))
	{
		$sql = "SELECT * FROM users WHERE email = '$email'";
		$result = mysql_query($sql);
		if(mysql_num_rows($result) == 0 && $email !='') echo 'true';
		else echo 'false';
	}
	else echo 'false';
}

//Is email already used and is it your own?
elseif($_GET['func'] == 'om')
{
	$email = trim(mysql_enteries_fix_string($_GET['m']));
	$regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/'; 
	if (preg_match($regex, $email))
	{
		$sql = "SELECT * FROM users WHERE email = '$email'";
		$result = mysql_query($sql);
		if(mysql_num_rows($result) == 0) echo 'true';
		else
		{
			$row = mysql_fetch_array($result);
			if($row['rowID'] == $_GET['u']) echo 'true';
			else echo 'false';
		}
	}
	else echo 'false';
}

//Check password
elseif($_GET['func'] == 'p')
{
	$password = mysql_enteries_fix_string($_GET['p']);
	$sql = "SELECT * FROM users WHERE rowID=$_GET[u] AND password='$password'";
	$result = mysql_query($sql);
	if(mysql_num_rows($result) == 0) echo 'false';
	else echo 'true';
}


elseif($_GET['func'] == 'signup_all')
{
	// //captcha
	// require_once('recaptchalib.php');
	// if($_SERVER['HTTP_HOST'] =='localhost') $privatekey = "6LewEM4SAAAAAFb7bWOf7PWVH1c6aarqrk8quPOZ";
	// elseif($_SERVER['HTTP_HOST'] =='85.83.1.123') $privatekey = "6LdnNM4SAAAAANM1Pn1m9u9vn4si_0APRAO7Draa";
	// elseif($_SERVER['HTTP_HOST'] =='10.180.2.167') $privatekey = "6Le4M84SAAAAAMwymwm6YVRAuLFyB0zTrlQK0kIl";
	// elseif($_SERVER['HTTP_HOST'] == 'filehunt.pagodabox.com') $privatekey = $_SERVER['CAPTCHA_PRIVATE'];

	// $resp = recaptcha_check_answer ($privatekey,
 //    $_SERVER["REMOTE_ADDR"],
 //    $_GET["recaptcha_challenge_field"],
 //    $_GET["recaptcha_response_field"]);

	// if (!$resp->is_valid)
	// {
	//     echo 'cap_false';
 //  	}
 //  	else
 //  	{
  		$username = mysql_enteries_fix_string($_GET['u']);
  		$email = mysql_enteries_fix_string($_GET['e']);
  		$sql = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
  		$result = mysql_query($sql);
  		if(mysql_num_rows($result) == 0 && $username != '' && $email != '') echo 'true';
  		else
  		{
  			$row = mysql_fetch_array($result);
  			if($row['username'] == $username) $uname = 'false';
  			else $uname = 'true';
  			if($row['email'] == $email) $email_ = 'false';
  			else $email_ = 'true';
	  		$error_array = array('username_available' => $uname, 'email_available' => $email_);
	  		echo json_encode($error_array);
  		}
  		
  	//}
}
?>
