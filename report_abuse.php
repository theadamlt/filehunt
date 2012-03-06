<?php
require_once('lib.php');
if(__FILE__ == $_SERVER['SCRIPT_FILENAME'])
	{
		header('Location: index.php?page=report_abuse');
		die();
	}

if(isset($_SESSION['dbuserid']) && isset($_GET['reportedFile']))
{
	$fileID = $_GET['reportedFile'];
	$reportBy = $_SESSION['dbuserid'];
	$date = date("d/m/y H:i", time());
	$datestrto = strtotime($date);

	$sql = "INSERT INTO abuse(rowID, fileID, report_by, date_reported) VALUES(NULL, '$fileID', '$reportBy', '$datestrto')";
	$result = mysql_query($sql,$con);
	header('Location: ?page=fileinfo&fileID='.$fileID.'&reportSuccess=true');
}
else header('Location: ?page=search');
?>