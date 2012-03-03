<?php
require_once('lib.php');
/*if(__FILE__ == $_SERVER['SCRIPT_FILENAME'])
{
	header('Location: index.php?page=subscribe');
	die();
}*/
mysql_selector();

if(isset($_SESSION['dbuserid']) && isset($_POST['subscribeTo']) && $_SESSION['dbuserid'] != $_POST['subscribeTo'])
{
	$userID = $_SESSION['dbuserid'];
	$subscribeTo = $_POST['subscribeTo'];
	$sql = "SELECT * FROM subs WHERE subscriber=$userID AND subscribed=subscribeTo LIMIT 1";
	$result = mysql_query($sql);
	if(mysql_num_rows($result) != 0)
	{
		header('Location: ?page=404');
		die();
	}
	else
	{
		$sql2 = "INSERT INTO subs (rowID, subscriber, subscribed) VALUES (NULL, $userID, $subscribeTo)";
		if($result2 = mysql_query($sql2))
		{
			$redirectTo = $_POST['subscribeTo'];
			header("Location: ?page=profile&userID=$subscribeTo&subscribeSuccess=true");
			die();
		}
		else
		{
			$redirectTo = $_POST['subscribeTo'];
			header("Location: ?page=profile&userID=$subscribeTo&subscribeSuccess=false");
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