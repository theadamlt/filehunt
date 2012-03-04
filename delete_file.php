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
	$profileID = $_SESSION['dbuserid'];
	$fileID = $_GET['fileID'];
	$sql = "DELETE FROM files WHERE uploaded_by='$profileID' AND rowID=$fileID";

	if($result = mysql_query($sql,$con))
	{
		//Delete abuse reports
		$sql2    = "DELETE FROM abuse WHERE fileID=$fileID";
		$result2 = mysql_query($sql,$con);
		//Delete comments
		$sql3    = "DELETE FROM comments WHERE fileID=$fileID";
		$result3 = mysql_query($sql3,$con);
		header('Location: ?page=myprofile&deleteSuccess=true');
		die();
	}
	else
	{
		header('Location: ?page=myprofile&deleteSuccess=false');
		die();
	}
}
?>