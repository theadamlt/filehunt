<?php
require_once('lib.php');
if(__FILE__ == $_SERVER['SCRIPT_FILENAME'])
{
	header('Location: index.php?page='.substr(end(explode('/', $_SERVER['SCRIPT_FILENAME'])),0,-4).'?'.$_SERVER['QUERY_STRING']);
	die();
}
if (!isset($_SESSION['dbuserid']))
{
	header('Location: ?page=login&attemptedSite=myprofile');
	die();
}
?>
<script type="text/javascript">
	myprofile();
</script>
<input type='submit' value='My preferences' onclick='window.location.href="?page=user_pref"'><h1 class='message'>Your uploaded files</h1>
<center id="center">
</center>