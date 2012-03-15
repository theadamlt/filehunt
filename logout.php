<?php
if(__FILE__ == $_SERVER['SCRIPT_FILENAME'])
	{
		header('Location: index.php?page=logout');
		die();
	}

setcookie("dbuserid", $_SESSION['dbuserid'], time()-604800);
session_destroy();

header('Location: ?page=search');
die();
?>