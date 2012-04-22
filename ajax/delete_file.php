<?php

if ( __FILE__ == $_SERVER['SCRIPT_FILENAME'] ) {
	die('Illegal request');
}


$sql = "DELETE
		FROM files
		WHERE uploaded_by=$_SESSION[dbuserid]
		    AND rowID=$_REQUEST[f]";

$result = mysql_query( $sql );
//Delete abuse reports
$sql2    = "DELETE
			FROM abuse
			WHERE fileID=$_REQUEST[f]";
$result2 = mysql_query( $sql2 );
//Delete comments
$sql3    = "DELETE
			FROM comments
			WHERE fileID=$_REQUEST[f]";
$result3 = mysql_query( $sql3 );
?>
