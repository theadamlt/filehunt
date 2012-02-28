<?php
if(__FILE__ == $_SERVER['SCRIPT_FILENAME'])
	{
		header('Location: index.php?page=logout');
		die();
	}
session_destroy();
header('Location: ?page=search');
die();
?>