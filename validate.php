<?php
require_once('lib.php');
mysql_selector();

if($_GET['func'] == 'u')
{
	$username = mysql_enteries_fix_string($_GET['u']);
	$sql = "SELECT * FROM users WHERE username='$username'";
	$result = mysql_query($sql);
	if(mysql_num_rows($result) == 0 && $username != '') echo 'true';
	else echo 'false';
}
elseif($_GET['func'] == 'm')
{
	$email = mysql_enteries_fix_string($_GET['m']);
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
?>
