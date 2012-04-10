<?php
require_once('lib.php');
if(__FILE__ == $_SERVER['SCRIPT_FILENAME'])
{
	header('Location: index.php?page=myprofile');
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