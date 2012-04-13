<?php

$sql = "SELECT * FROM users u, user_pref up WHERE u.rowID = $_SESSION[dbuserid] AND up.admin = 1 LIMIT 1";
$result = mysql_query($sql);
if(mysql_num_rows($result) != 1)
{
	die('Illegal request');
}

$sql = "SELECT * FROM users";
$result = mysql_query($sql);
$error = array();
while ($row = mysql_fetch_array($result))
{
	if(!mail($row['email'], format_string($_REQUEST['subject']), format_string($_REQUEST['message']), 'From: noreply@filehunt.com'))
		$error[] = $row['rowID'];
}
if(!empty($error)) echo 'false';
else echo 'true';
?>