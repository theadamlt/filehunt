<?php
ob_start();
require_once 'lib.php';
mysql_selector();

$id=$_GET['id'];
$sql = "SELECT *
		FROM files
		WHERE rowID=$id";
$result = mysql_query( $sql );
$row = mysql_fetch_array( $result );
$content = $row['data'];
ob_clean();
header( "Content-type: $row[mimetype]" );
ob_start();
echo $content;
ob_flush();

?>
