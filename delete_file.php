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