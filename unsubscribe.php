<?php
require_once('lib.php');
if(__FILE__ == $_SERVER['SCRIPT_FILENAME'])
{
	header('Location: index.php?page=404');
	die();
}


if(isset($_SESSION['dbuserid']) && isset($_POST['unsubscribeTo']) && $_SESSION['dbuserid'] != $_POST['unsubscribeTo'])
{
	$userID = $_SESSION['dbuserid'];
	$unsubscribeTo = $_POST['unsubscribeTo'];
	$sql = "SELECT *
			FROM subs
			WHERE subscriber=$userID
			    AND subscribed=subscribeTo LIMIT 1";
	$result = mysql_query($sql);
	if(mysql_num_rows($result) != 0)
	{
		header('Location: ?page=404');
		die();
	}
	else
	{
		$userID = $_SESSION['dbuserid'];
		$unsubscribeTo = $_POST['unsubscribeTo'];
		$sql2 = "DELETE
				FROM subs
				WHERE subscriber=$userID
				    AND subscribed=$unsubscribeTo LIMIT 1";
		if($result2 = mysql_query($sql2))
		{
			$redirectTo = $_POST['unsubscribeTo'];
			header("Location: ?page=profile&userID=$unsubscribeTo&unsubscribeSuccess=true");
			die();
		}
		else
		{
			$redirectTo = $_POST['subscribeTo'];
			header("Location: ?page=profile&userID=$unsubscribeTo&unsubscribeSuccess=false");
			die();
		}

	}

}
else
{
	header('Location: ?page=404');
	die();
}
?>