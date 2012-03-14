<?php
require_once('lib.php');
if(__FILE__ == $_SERVER['SCRIPT_FILENAME'])
	{
		header('Location: index.php?page=delete_old_files');
		die();
	}
if(isset($_POST['delete']))
{
	$sql = "SELECT *
			FROM users
			WHERE username='$_SESSION[dbusername]'
			    AND password='$_SESSION[dbpassword]'
			    AND rowID=$_SESSION[dbuserid]
			    AND ADMIN=1 LIMIT 1";
	$result = mysql_query($sql);
}
else
{
	header('Location: ?page=404');
	die();
}


?>