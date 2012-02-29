<?php

$mysql_host = "mysql7.000webhost.com";
$mysql_database = "a4438711_fh1";
$mysql_user = "a4438711_user";
$mysql_password = "kage123";

//The www domain for mysql connection function
define('www_domain', 'filehunt.netau.net');
define('pagoda', 'filehunt.pagodabox.com');

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

function facebookShare($url)
{
		echo <<<_END
<script>function fbs_click() {u=location.href;t=document.title;window.open('http://www.facebook.com/sharer.php?u='+encodeURIComponent(u)+'&t='+encodeURIComponent(t),'sharer','toolbar=0,status=0,width=626,height=436');return false;}</script><a rel="nofollow" href="http://www.facebook.com/share.php?u=$url" onclick="return fbs_click()" target="_blank"><img src="img/facebook.ico" height="32" width="32"></a>&nbsp;&nbsp;&nbsp;&nbsp;
_END;
}
function twitterShare($url)
{
	echo <<< _END
<a href="http://twitter.com/home?status=I just uploaded a file on fileHunt! $url" title="Share on Twitter" target='_blank'><img src="img/twitter.ico" height="32" width="32"></a>&nbsp;&nbsp;&nbsp;&nbsp;
_END;
}
function googleShare($url)
{
	echo <<< _END
	<a title="Share on Google+" href="https://m.google.com/app/plus/x/?v=compose&content=I just uploaded a file on fileHunt! $url" onclick="window.open('https://m.google.com/app/plus/x/?v=compose&content=I just uploaded a file on fileHunt $url','gplusshare','width=450,height=300,left='+(screen.availWidth/2-225)+',top='+(screen.availHeight/2-150)+'');return false;"><img src="img/google+.ico" height="32" width="32"></a>
_END;
}

function mysql_selector()
{
	$host = $_SERVER['HTTP_HOST'];
	if($host == 'localhost' || $host == '62.199.33.99' || $host == '85.83.1.123') localhost_con('filehunt');
	else if($host == www_domain) /*mysql_con("mysql7.000webhost.com", "a4438711_user", "kage123", "a4438711_fh1")*/
		mysql_con($mysql_host, $mysql_user, $mysql_password, $mysql_database);
	else if($host == pagoda) mysql_con('tunnel.pagodabox.com:3306', 'luba', '9pctB2Vg', 'filehunt');
	else localhost_con('filehunt');
}
?>

