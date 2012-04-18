<?php
if($_REQUEST['action'] == 'mysubscriptions')
{
	$sql = "SELECT s.rowID AS s_rowID,
			       s.subscriber AS s_subscriber,
			       s.subscribed,
			       u.rowID AS u_rowID,
			       u.username AS u_username
			FROM subs s,
			     users u
			WHERE s.subscriber=$_SESSION[dbuserid]
			    AND s.subscribed=u.rowID";
	$result = mysql_query($sql);
	$rows = array();
	while($r = mysql_fetch_array($result))
	{
		$rows[] = $r;
	}
	echo json_encode($rows);
}
elseif($_REQUEST['action'] == 'mysubscriptions_num')
{
	$sql = "SELECT * FROM subs WHERE subscriber=$_SESSION[dbuserid]";
	$result = mysql_query($sql);
	echo mysql_num_rows($result);
}

elseif($_REQUEST['action'] == 'mysubscribers')
{
	$sql = "SELECT s.rowID AS s_rowID,
			       s.subscriber AS s_subscriber,
			       s.subscribed AS s_subscribed,
			       u.rowID AS u_rowID,
			       u.username AS u_username
			FROM subs s,
			     users u
			WHERE s.subscribed=$_SESSION[dbuserid]
			    AND s.subscriber=u.rowID";
	$result = mysql_query($sql);
	$rows = array();
	while($r = mysql_fetch_array($result))
	{
		$rows[] = $r;
	}
	echo json_encode($rows);
	echo mysql_error();
}

elseif($_REQUEST['action'] == 'mysubscribers_num')
{
	$sql = "SELECT *
			FROM subs
			WHERE subscribed=$_SESSION[dbuserid]";
	$result = mysql_query($sql);
	echo mysql_num_rows($result);
}


elseif($_REQUEST['action'] == 'files')
{
	$sql = "SELECT s.rowID AS s_rowID,
			       s.subscriber AS s_subscriber,
			       s.subscribed,
			       u.rowID AS u_rowID,
			       u.username AS u_username,
			       me.last_sub_check AS u_last_sub_check,
			       f.file AS f_file,
			       f.uploaded_date AS f_uploaded_date,
			       f.uploaded_by AS f_uploaded_by,
			       f.size AS f_size,
			       f.rowID AS f_rowID
			FROM subs s,
			     users u,
			     users me,
			     files f
			WHERE s.subscriber = $_SESSION[dbuserid]
			    AND me.rowID = $_SESSION[dbuserid]
			    AND s.subscribed = f.uploaded_by
			    AND f.uploaded_by = u.rowID
			    AND me.last_sub_check < f.uploaded_date";
	$result = mysql_query($sql);
	$rows = array();
	while($r = mysql_fetch_array($result))
	{
		$rows[] = $r;
	}
	echo json_encode($rows);	
}

elseif($_REQUEST['action'] == 'files_num')
{
	$sql = "SELECT s.rowID AS s_rowID,
			       s.subscriber AS s_subscriber,
			       me.last_sub_check AS u_last_sub_check,
			       me.rowID AS me_rowID
			FROM subs s,
			     users u,
			     users me,
			     files f
			WHERE s.subscriber = $_SESSION[dbuserid]
			    AND me.rowID = $_SESSION[dbuserid]
			    AND s.subscribed = f.uploaded_by
			    AND f.uploaded_by = u.rowID
			    AND me.last_sub_check < f.uploaded_date";
	$result = mysql_query($sql);
	echo mysql_error();
	echo mysql_num_rows($result);
}
?>