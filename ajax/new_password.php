<?php

if ( __FILE__ == $_SERVER['SCRIPT_FILENAME'] ) {
	die('Illegal request');
}

$password    = mysql_enteries_fix_string( $_REQUEST['p1'] );
$password2   = mysql_enteries_fix_string( $_REQUEST['p2'] );
$curpassword = mysql_enteries_fix_string( $_REQUEST['cp'] );

if ( $password == $password2 ) {
	$sql = "SELECT * FROM users WHERE rowID=$_SESSION[dbuserid]";
	$result = mysql_query( $sql );
	$row = mysql_fetch_array( $result );
	if ( $row['password'] == $curpassword ) {
		$userid = $_SESSION['dbuserid'];
		$sql = "UPDATE users
				SET password='$password'
				WHERE rowID=$userid LIMIT 1";
		if ( $result =  mysql_query( $sql ) ) {
			echo 'true';
		}
		else {
			echo 'false';
		}
	}
	else {
		echo 'false';
	}
}
else {
	echo 'false';
}
?>
