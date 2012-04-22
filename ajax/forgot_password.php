<?php

if ( __FILE__ == $_SERVER['SCRIPT_FILENAME'] ) {
	die('Illegal request');
}

$username = mysql_enteries_fix_string( $_REQUEST['username'] );
$email = mysql_enteries_fix_string( $_REQUEST['email'] );
$sql = "SELECT *
		FROM users
		WHERE username='$username'
		    AND email='$email' LIMIT 1";
$result = mysql_query( $sql );
if ( mysql_num_rows( $result ) != 1 ) {
	die( 'false' );
}

$row = mysql_fetch_array( $result );

$username_r = $row['username'];

$sec_code = $row['security_code'];

$message = "Hi $username_r
It seems like you have been trying to reset you password on filehunt.
http://filehunt.pagodabox.com/?page=reset_password&yes=true
Click on the link above and insert this code to reset your password:
$sec_code

Sincerly
The filehunt team";

if ( mail( $row['email'], 'Filehunt password reset', $message, 'From: noreply@filehunt.com' ) ) {
	echo 'true';
}
else echo 'email_error';
?>
