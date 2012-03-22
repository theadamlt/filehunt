<?php
require_once('lib.php');
if(isset($_POST['clear_list']) && $_POST['clear_list'] == 'true' && isset($_SESSION['dbuserid']))
{
	$datestrto = time();
	$curUserID = $_SESSION['dbuserid'];
	$sql = "UPDATE users
			SET last_sub_check=$datestrto
			WHERE rowID=$curUserID";
	$result = mysql_query($sql);
	header('Location: ?page=mysubscriptions');
	die();
}
else
{
	header('Location: ?page=404');
	die();
}

?>