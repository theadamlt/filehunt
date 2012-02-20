<?php
require('lib.php');
mysql_selector();
if(isset($_SESSION['dbuserid']) && isset($_GET['reportedFile']))
{
	$fileID = $_GET['reportedFile'];
	$reportBy = $_SESSION['dbuserid'];
	$date = date("y/m/d : H:i:s", time());
	$sql = "INSERT INTO abuse(rowID, fileID, report_by, date_reported) VALUES(NULL, '$fileID', '$reportBy', '$date')";
	$result = mysql_query($sql,$con);
	echo '<script>
		history.back();
	</script>';
}
else header('Location: ?page=search');
?>