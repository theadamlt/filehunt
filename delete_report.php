<?php
require_once('lib.php');
if(isset($_GET['file']) && isset($_SESSION['dbuserid']))
{
	$admin = $_SESSION['dbuserid'];
	$sql = "SELECT *
			FROM users
			WHERE rowID=$admin
			    AND ADMIN=1 LIMIT 1";
	$result = mysql_query($sql);
	if(mysql_num_rows($result) == 1)
	{
		$file = $_GET['file'];
		$sql = "DELETE
				FROM abuse
				WHERE fileID=$file";
		$result = mysql_query($sql);
		header('Location: ?page=admin&deleteReport=true');
		die();
	}
	else
	{
		header('Location: ?page=404');
		die();
	}
}
?>