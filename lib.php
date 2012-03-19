<?php


//The www domain for mysql connection function
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
$url = urlencode($url);

echo <<< _END
	<a href="http://www.facebook.com/sharer.php
?u=$url&t=I+just+uploaded+a+file+on+filehunt%21"><img src="img/facebook.ico" height="32" width="32"></a>
	&nbsp;&nbsp;&nbsp;&nbsp;
_END;
}
function twitterShare($url)
{
	$url = urlencode($url);
	echo
<<< _END
<a href="http://twitter.com/home?status=I just uploaded a file on fileHunt! $url" title="Share on Twitter" target='_blank'>
<img src="img/twitter.ico" height="32" width="32"></a>
&nbsp;&nbsp;&nbsp;&nbsp;
_END;
}
function googleShare($url)
{
	$url = urlencode($url);
	echo
<<< _END
	<a href="https://m.google.com/app/plus/x/?v=compose&content=I just uploaded a file on fileHunt! $url" onclick="window.open('https://m.google.com/app/plus/x/?v=compose&content=I just uploaded a file on fileHunt! $url','gplusshare','width=450,height=300,left='+(screen.availWidth/2-225)+',top='+(screen.availHeight/2-150)+'');return false;"><img src="img/google+.ico" height="32" width="32"></a>
_END;
}

function mysql_selector()
{
	$host = $_SERVER['HTTP_HOST'];


	if($host == 'localhost' || $host == '62.199.33.99' || $host == '85.83.1.123') localhost_con('filehunt');
	else if($host == pagoda) mysql_con('tunnel.pagodabox.com:3306', 'luba', $_SERVER['DB_PASSWORD'], 'filehunt');
	else localhost_con('filehunt');
}


function getBrowser()
{
	if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE')) 
		$browser = 'Internet explorer';

	elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox')) 
		$browser = 'Firefox';
		
	elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome')) 
		$browser = 'Chrome';

	elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera'))
		$browser = 'Opera';

	elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Safari'))
		$browser = 'Safari';

	elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'SeaMonkey'))
		$browser = 'SeaMonkey';

	elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Flock'))
		$browser = 'Flock';

	elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Prism'))
		$browser = 'Prism';

	elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Deepnet Explorer'))
		$browser = 'Deepnet Explorer';

	elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Maxthon'))
		$browser = 'Maxthon';

	elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'SeaMonkey'))
		$browser = 'SeaMonkey';

	else
		$browser = 'Undefined';

	return $browser;
}

function calc_file_size($file)
{

	$kb = 1024;
	$mb = 1048576;
	$gb = 1073741824;
	$tb = 1099511627776;
	if($file >= $kb && $file < $mb) $size = round($file/$kb, 1).' Kb';
	elseif($file >= $mb && $file < $gb) $size = round($file/$mb, 1).' MB';
	elseif($file >= $gb && $file < $tb) $size = round($file/$gb, 1).' GB';
	elseif($file >= $tb) $size = round($file/$tb, 1).'TB';
	else
	{
		$size = round($file, 1);
		if($size == 1) $size = $size.' Byte';
		else $size = $size.' Bytes';
	}
	return $size;
}
?>