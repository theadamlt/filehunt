<?php
if(__FILE__ == $_SERVER['SCRIPT_FILENAME'])
	{
		header('Location: index.php?page=logout');
		die();
	}

setcookie("dbusername", $_SESSION['dbusername'], time()-604800);
setcookie("dbuserid", $_SESSION['dbuserid'], time()-604800);
setcookie("dbuseremail", $_SESSION['dbuseremail'], time()-604800);
session_destroy();

header('Location: ?page=search');
die();
?>