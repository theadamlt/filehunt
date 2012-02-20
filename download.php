<?php
require('lib.php');
mysql_selector();

$file = $_GET['file'];

$sql        = "SELECT * FROM files WHERE rowID='$file' LIMIT 1";
$result     = mysql_query($sql,$con);
$row        = mysql_fetch_array($result);
$downloaded = $row['times_downloaded'];
$uploaded_by = $row['uploaded_by'];
$rowID = $row['rowID'];


$sql    = "UPDATE files SET times_downloaded=times_downloaded+1 WHERE times_downloaded=$downloaded AND uploaded_by=$uploaded_by AND rowID=$rowID";
$result = mysql_query($sql,$con);


header("Content-length: ".$row['size']);
header("Content-type: ".$row['mimetype']);
header("Content-Disposition: attachment; filename=".$row['file']);
//header('Location: ?index.php?page=search');
echo $row['data'];
?>