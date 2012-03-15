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
			WHERE rowID=$_SESSION[dbuserid]
			    AND ADMIN=1 LIMIT 1";
	$result = mysql_query($sql);
	if(mysql_query($result) == 1)
	{
		$date = time() -7257600;
		$sql = "DELETE FROM files WHERE uploaded_date < $date";
	}
}
else
{
	header('Location: ?page=404');
	die();
}


?>