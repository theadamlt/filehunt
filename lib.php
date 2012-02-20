<?php
function mysql_selector()
{
	$host = $_SERVER['HTTP_HOST'];
	if($host == 'localhost' || $host == '62.199.33.99' || $host == '85.83.1.123') localhost_con('filehunt');
	else if($host == www_domain) mysql_con("mysql7.000webhost.com", "a4438711_user", "kage123", "a4438711_fh1");
	else localhost_con('filehunt');
}


$mysql_host = "mysql7.000webhost.com";
$mysql_database = "a4438711_fh1";
$mysql_user = "a4438711_user";
$mysql_password = "kage123";

//The www domain for mysql connection function
define('www_domain', 'filehunt.netau.net');

//Define Environment
define('ENVIRONMENT', 'development');
/*
 *---------------------------------------------------------------
 * ERROR REPORTING
 *---------------------------------------------------------------
 * Different environments will require different levels of error reporting.
 * By default development will show errors but testing and live will hide them.
 */
if (defined('ENVIRONMENT'))
{
	switch (ENVIRONMENT)
	{
		case 'development':
			error_reporting(E_ALL);
		break;
	
		case 'testing':
		case 'production':
			error_reporting(0);
		break;

		default:
			exit('The application environment is not set correctly.');
	}
}

function mysql_con($host, $user, $password, $dbname)	{
	global $con;
	$con = mysql_connect($host, $user, $password);
	if (!$con)	{
		die ("Could not connect to MySQL database ".mysql_error());
	}

	global $con_db;
	$con_db = mysql_select_db($dbname, $con);
	if (!$con_db) {
		die ("Could not select database ".$dbname." ".mysql_error());
	}

}

function localhost_con($dbname) {
	global $con;
	$con = mysql_connect("localhost", "root", "");
		if (!$con)	{
		die ("Could not connect to MySQL database ".mysql_error());
	}
	global $con_db;
	$con_db = mysql_select_db($dbname,$con);
		if (!$con_db) {
		die ("Could not select database ".$dbname." ".mysql_error());
	}
}


function mysql_fix_string($string)	{
	if (get_magic_quotes_gpc()) $string = stripslashes($string);
	return mysql_real_escape_string($string);
}

function mysql_enteries_fix_string($string) {
	return htmlentities(mysql_fix_string($string));
}

function oddOrEven($num)
{
if($odd = $num%2 ) return(0); //Odd number
else return(1); //Even number
}


?>

