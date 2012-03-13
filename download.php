<?php
ob_start();
require_once('lib.php');
mysql_selector();
session_start();
$file = $_GET['file'];

$sql        = "SELECT *
			FROM files
			WHERE rowID='$file' LIMIT 1";
$result     = mysql_query($sql,$con);
$row        = mysql_fetch_array($result);
$downloaded = $row['times_downloaded'];
$uploaded_by = $row['uploaded_by'];
$rowID = $row['rowID'];

// $checkDate = date("d/m/y H:i", time());
// $datestrto = strtotime($checkDate);
$datestrto = time();

if(isset($_SESSION['dbuserid'])) $downloaded_by = $_SESSION['dbuserid'];
else $downloaded_by = 'anon';

$sql = "INSERT INTO downloads(rowID, downloaded_by, fileID, downloaded_date) VALUES(NULL, $downloaded_by, $_GET[file], $datestrto)";

//$sql    = "UPDATE files SET times_downloaded=times_downloaded+1 WHERE times_downloaded=$downloaded AND uploaded_by=$uploaded_by AND rowID=$rowID";
$result = mysql_query($sql);


ob_clean();
header("Content-length: ".$row['size']);
header("Content-type: ".$row['mimetype']);
header("Content-Disposition: attachment; filename=".$row['file']);
ob_start();
echo $row['data'];
ob_flush();
?>