<?php

if(isset($_SESSION['dbuserid']))
{
	die('Illegal request');
}
$username = mysql_enteries_fix_string($_REQUEST['u']);
$password = mysql_enteries_fix_string($_REQUEST['p']);
$sql = "SELECT *
		FROM users
		WHERE username='$username'
		    AND password='$password' LIMIT 1";
$result = mysql_query($sql);
if (mysql_num_rows($result) == 1)
{	
	$row = mysql_fetch_array($result);
	
	$_SESSION['dbuserid'] = $row['rowID'];

	if($_REQUEST['remember'] == 'true')
	{
		setcookie("dbuserid", $row['rowID'], time()+604800);
	}
	echo 'true';
}
else echo 'false';
// if(isset($_GET['attemptedSite']) && $_GET['attemptedSite']=='report_abuse' && isset($_GET['reportedFile']))
// {
// 	header('Location: ?page=report_abuse&reportedFile='.$_GET['reportedFile']);
// 	die();
// }
// 	elseif(isset($_GET['attemptedSite']) && isset($_GET['fileID']) && $_GET['attemptedSite'] == 'fileinfo')
// 	{
// 		header('Location: ?page=fileinfo&fileID='.$_GET['fileID']);
// 		die();
// 	}
// 	if(isset($_GET['attemptedSite']))
// 	{
// 		header('Location: ?page='.$_GET['attemptedSite']);
// 		die();
// 	}
// 	else
// 	{
// 		header('Location: ?page=search');
// 		die();
// 	}
// 	} 
// 	else
// 	{
// 		header('Location: ?page=login&wrongLogin=true');
// 		die();
// 	}
?>