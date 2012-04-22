<?php

if ( __FILE__ == $_SERVER['SCRIPT_FILENAME'] ) {
	die('Illegal request');
}
$datestrto = time();
$sql = "UPDATE users
		SET last_sub_check=$datestrto
		WHERE rowID=$_SESSION[dbuserid]";
$result = mysql_query( $sql );
?>
