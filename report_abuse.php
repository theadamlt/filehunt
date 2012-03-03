<?php
require_once('lib.php');
if(__FILE__ == $_SERVER['SCRIPT_FILENAME'])
	{
		header('Location: index.php?page=report_abuse');
		die();
	}
mysql_selector();
if(isset($_SESSION['dbuserid']) && isset($_GET['reportedFile']))
{
	$fileID = $_GET['reportedFile'];
	$reportBy = $_SESSION['dbuserid'];
	$date = date("y/m/d : H:i:s", time());
	$sql = "INSERT INTO abuse(rowID, fileID, report_by, date_reported) VALUES(NULL, '$fileID', '$reportBy', '$date')";
	$result = mysql_query($sql,$con);
	/*echo '<script>
		history.back();
	</script>';*/ header('Location: ?page=search');
}
else header('Location: ?page=search');
?>