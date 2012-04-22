<?php
if ( __FILE__ == $_SERVER['SCRIPT_FILENAME'] ) {
	die('Illegal request');
}

$datestrto = time();
$sql = "INSERT INTO abuse(rowID, fileID, report_by, date_reported) VALUES(NULL, $_REQUEST[file], $_SESSION[dbuserid], '$datestrto')";
$result = mysql_query( $sql );
echo $sql;

?>
