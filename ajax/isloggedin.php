<?php
if(isset($_SESSION['dbuserid']))
{
	$sql = "SELECT u.rowID AS userID,
			       u.username AS username,
			       u.email AS email,
			       up.rowID,
			       up.userID,
			       up.real_name,
			       up.show_real_name,
			       up.show_mail,
			       up.admin,
			       up.facebook_id,
			       up.twitter_id,
			       up.gplus_id
			       FROM users u,
			       user_pref up
			WHERE u.rowID = $_SESSION[dbuserid]
			    AND u.rowID=up.userID";
	$result = mysql_query($sql);
	echo json_encode(mysql_fetch_array($result));
}
else echo 'false';
?>