<?php
require_once('lib.php');
if(__FILE__ == $_SERVER['SCRIPT_FILENAME'])
	{
		header('Location: index.php?page=delete_old_files');
		die();
	}
if(isset($_POST['delete']) && isset($_SESSION['dbuserid']) && isset($user_pref['admin']) && $user_pref['admin'] == '1')
{
	$date = time() -7257600;
	$sql = "DELETE FROM files WHERE uploaded_date < $date";
}
else
{
	header('Location: ?page=404');
	die();
}


?>