<?php
require_once('lib.php');
if(__FILE__ == $_SERVER['SCRIPT_FILENAME'])
{
	header('Location: index.php?page=mysubscribtions');
	die();
}
mysql_selector();

if(isset($_SESSION['dbuserid']) && isset($_SESSION['dbuserid']))
{

	$userID = $_SESSION['dbuserid'];
	$sql = "SELECT s.rowID AS s_rowID, s.subscriber AS s_subscriber, s.subscribed, u.rowID AS u_rowID, u.username AS u_username FROM subs s, users u WHERE s.subscriber=$userID AND s.subscribed=u.rowID";
	$result = mysql_query($sql);
	if(mysql_num_rows($result) != 0)
	{
		echo '<details><summary>Your subscriptions('.mysql_num_rows($result).')</summary>';
		while($row = mysql_fetch_array($result))
		{
			echo '<a href="?page=profile&userID='.$row['u_rowID'].'">'.$row['u_username'].'</a><br />';
		}
		echo '</details><br />';
	}
	else echo '<div id="error">You have no subscriptions</div><br />';

	$userID2 = $_SESSION['dbuserid'];
	$sql2 = "SELECT s.rowID AS s_rowID, s.subscriber AS s_subscriber, s.subscribed, u.rowID AS u_rowID, u.username AS u_username FROM subs s, users u WHERE s.subscribed=$userID2 AND s.subscriber=u.rowID";
	$result2 = mysql_query($sql2);
	if(mysql_num_rows($result2) != 0)
	{
		echo '<details><summary>Your subscribers('.mysql_num_rows($result2).')</summary>';
		while($row2 = mysql_fetch_array($result2))
		{
			echo '<a href="?page=profile&userID='.$row2['u_rowID'].'">'.$row2['u_username'].'</a><br />';
		}
		echo '</details><br />';
	}
	else echo '<div id="error">You have no subscribers</div>';



	/*$userID = $_SESSION['dbuserid'];
	$sql = "SELECT * FROM subs WHERE subscriber=$userID";
	$result = mysql_query($sql);
	if(mysql_num_rows($result) != 0)
	{
		$sql2 = "SELECT * FROM files WHERE "; //Make subscribtions function
        echo '<h1>The files</h1>
        	<center><table id="table">
        	<th>Filename</th>
			<th>Uploaded by</th>
			<th>Upload date</th>
            <th>Filesize</th>
            <th>Comments</th>';
        $count = 0;
		while($row = mysql_fetch_array($result))
		{
			if(oddOrEven($count)==1) echo "<tr class='alt'>";
            elseif(oddOreven($count)==0) echo '<tr>';
            echo '<td>'.$row.'</td>'
            echo '</tr>';
            ++$count;
		}
		echo '</table></center>';
	}
	else
	{
		echo '<div id="error">You have no subscribtions</div>';
	}*/
}
else
{
	header('Location: ?page=login&attemptedSite=mysubscribtions');
	die();
}


?>
