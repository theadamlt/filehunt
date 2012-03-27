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
?>
