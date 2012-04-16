<?php
if($_REQUEST['show_real_name'] == 'true') $show_name = 1;
else $show_name = 0;

if($_REQUEST['show_email'] == 'true') $show_mail = 1;
else $show_mail = 0;

$facebook_id = trim($_REQUEST['facebook_id']);
$twitter_id = trim($_REQUEST['twitter_id']);

$real_name = trim(ucfirst($_REQUEST['real_name']));



$sql = "SELECT * FROM users WHERE rowID = $_SESSION[dbuserid]";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
if($row['email'] != $_REQUEST['email'])
{
	mysql_query("UPDATE users SET email = '$_REQUEST[email]' WHERE rowID = $_SESSION[dbuserid]");
}

$sql = "SELECT *
		FROM user_pref
		WHERE userID = $_SESSION[dbuserid]";
$result = mysql_query($sql);

if(mysql_num_rows($result) == 0) $sql = "INSERT INTO user_pref (rowID, userID, real_name, show_real_name, show_mail, ADMIN, facebook_id, twitter_id) 
	VALUES(NULL, $_SESSION[dbuserid], '$real_name', $show_name, $show_mail, 0, '$facebook_id', '$twitter_id')";

else $sql = "UPDATE user_pref
					SET real_name = '$real_name',
                	show_real_name = $show_name,
                	show_mail = $show_mail,
                	facebook_id = '$facebook_id',
                    twitter_id = '$twitter_id'
				WHERE userID = $_SESSION[dbuserid]";

if($result = mysql_query($sql)) echo 'true';
else echo 'false';

echo mysql_error();
?>