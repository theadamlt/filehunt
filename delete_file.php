<?php
require_once('lib.php');
mysql_selector();
if(!isset($_SESSION['dbuserid']))
{
	header('Location: ?page=search');
}

if(isset($_SESSION['dbuserid']) && isset($_GET['fileID']))
{
	$profileID = $_SESSION['dbuserid'];
	$fileID = $_GET['fileID'];
	$sql = "DELETE FROM files WHERE uploaded_by='$profileID' AND rowID=$fileID";

	if($result = mysql_query($sql,$con))
	{
		$sql2 = "SELECT * FROM abuse WHERE fileID=$fileID";
		$result2 = mysql_query($sql,$con);
		if(mysql_num_rows($result)!=0)
		{
			$sql3 = "DELETE FROM abuse WHERE fileID=$fileID";
			$result3 = mysql_query($sql,$con);
		}
		header('Location: ?page=admin&deleteSuccess=true');
		die();
	}
	else
	{
		header('Location: ?page=admin&deleteSuccess=false');
		die();
	}
}
?>