<?php
if ( !isset( $_SERVER['HTTP_REFERER'] ) ) die( 'Illegal request' );
$host = $_SERVER['HTTP_HOST'];
$referer = $_SERVER['HTTP_REFERER'];
$array = explode( '/', $referer );

if ( $host != $array[2] ) die( 'Illegal request' );


session_start();
require_once "lib.php";
mysql_selector();
$action = $_REQUEST['func'];

if ( file_exists( 'ajax/'.$action.'.php' ) )
	require 'ajax/'.$action.'.php';
else echo 'Undefined action';
?>
