<?php
if(__FILE__ == $_SERVER['SCRIPT_FILENAME'])
{
	header('Location: index.php?page='.substr(end(explode('/', $_SERVER['SCRIPT_FILENAME'])),0,-4).'?'.$_SERVER['QUERY_STRING']);
	die();
}

setcookie("dbuserid", $_SESSION['dbuserid'], time()-604800);
session_destroy();

header('Location: ?page=search');
die();
?>