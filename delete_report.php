<?php
require_once('lib.php');
if(isset($_GET['file']) && isset($_SESSION['dbuserid']) && isset($user_pref['admin']) && $user_pref['admin'] == '1')
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
?>