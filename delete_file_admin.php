<?php
require_once('lib.php');
if(__FILE__ == $_SERVER['SCRIPT_FILENAME'])
	{
		header('Location: index.php?page=delete_file');
		die();
	}

if(!isset($_SESSION['dbuserid']))
{
	header('Location: ?page=404');
	die();
}
if(isset($_SESSION['dbuserid']) && isset($_GET['fileID']) && isset($user_pref['admin']) && $user_pref['admin'] == '1')
{
		$fileID = $_GET['fileID'];
		$sql2 = "DELETE
				FROM files
				WHERE rowID=$fileID";
		$result = mysql_query($sql2);
		
			//Delete abuse reports
			$sql3    = "DELETE
						FROM abuse
						WHERE fileID=$fileID";
			$result3 = mysql_query($sql3,$con);
			//Delete comments
			$sql4    = "DELETE
						FROM comments
						WHERE fileID=$fileID";
			$result4 = mysql_query($sql4,$con);
			header('Location: ?page=admin&deleteSuccess=true');
			die();
}
else
{
	header('Location: ?page=404');
	die();
}
?>