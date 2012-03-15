<?php
require_once('lib.php');
if(__FILE__ == $_SERVER['SCRIPT_FILENAME'])
	{
		header('Location: index.php?page=delete_file');
		die();
	}

if(!isset($_SESSION['dbuserid']))
{
	header('Location: ?page=search');
	die();
}
if(isset($_SESSION['dbuserid']) && isset($_GET['fileID']))
{
	$adminusername = $_SESSION['dbusername'];
	$adminuserid   = $_SESSION['dbuserid'];
	$sql = "SELECT *
			FROM users
			WHERE username='$adminusername'
			    AND rowID=$adminuserid
			    AND ADMIN=1 LIMIT 1";
	$result = mysql_query($sql);
	if(mysql_num_rows($result)==1)
	{
		$fileID = $_GET['fileID'];
		$sql2 = "DELETE
				FROM files
				WHERE rowID=$fileID";
		if($result = mysql_query($sql2))
		{
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
			header('Location: ?page=admin&deleteSuccess=false');
			die();
		}
	}
	else
	{
		header('Location: ?page=admin&deleteSuccess=false');
		die();
	}
}
else
{
	header('Location: ?page=404');
	die();
}
?>