<?php
require_once('./lib.php');
mysql_selector();
if($_SERVER['HTTP_HOST'] == 'localhost') error_reporting(0);

if($_GET['func'] == 'login')
{	
	$sql = "SELECT rowID, username, email, last_sub_check FROM users WHERE username = '$_GET[u]' AND password = '$_GET[p]'";
	$result = mysql_query($sql);

	echo json_encode(mysql_fetch_array($result));
}

elseif($_GET['func'] == 'mysubscribers')
{
	$sql = "SELECT s.rowID AS s_rowID,
			       s.subscriber AS s_subscriber,
			       s.subscribed,
			       u.rowID AS u_rowID,
			       u.username AS u_username
			FROM subs s,
			     users u
			WHERE s.subscribed=$_GET[u]
			    AND s.subscriber=u.rowID";
	$result = mysql_query($sql);
	if(mysql_num_rows($result) == 0) echo 'false';
	for ($i=0; $i < mysql_num_rows($result) ; $i++)
	{ 
		echo json_encode(mysql_fetch_array($result));
	}

}

elseif($_GET['func'] == 'mysubscribtions')
{
	$sql = "SELECT s.rowID AS s_rowID,
			       s.subscriber AS s_subscriber,
			       s.subscribed,
			       u.rowID AS u_rowID,
			       u.username AS u_username
			FROM subs s,
			     users u
			WHERE s.subscriber=$_GET[u]
			    AND s.subscribed=u.rowID";
	$result = mysql_query($sql);
	if(mysql_num_rows($result) == 0) echo 'false';
	else
	{
		for ($i=0; $i < mysql_num_rows($result) ; $i++)
		{ 
			echo json_encode(mysql_fetch_array($result));
		}
	}
}


?>