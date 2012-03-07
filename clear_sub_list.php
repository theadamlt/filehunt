<?php
require_once('lib.php');
if(isset($_POST['clear_list']) && $_POST['clear_list'] == 'true' && isset($_SESSION['dbuserid']))
{
	$checkDate = date("d/m/y H:i", time());
	$datestrto = strtotime($checkDate);
	$curUserID = $_SESSION['dbuserid'];
	$curUsername = $_SESSION['dbusername'];
	$curUserPassword = $_SESSION['dbpassword'];
	$sql = "UPDATE users SET last_sub_check='$datestrto' WHERE rowID=$curUserID AND username='$curUsername' AND password='$curUserPassword'";
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