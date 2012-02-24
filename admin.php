<?php
require_once('lib.php');
mysql_selector();
if ((isset($_SESSION['dbusername']))&&(isset($_SESSION['dbpassword'])))
{
	echo <<< _END
<form class="form" action="?page='admin'" method="post">							
<p class="subject">
	<input type="text" name="subject" placeholder="Subject" id="subject" />
	<label for="subject">Subject</label>
</p>
<p class="message">
	<textarea name="message" cols="40" rows="6" placeholder="Message" id="message" ></textarea>
	<label for="message">Message</label>
</p>
<p class="submit">
	<input type="submit" value="Send"></form>
</p>
_END;
	if(isset($_GET['mailSuccess'])) echo '<div id="success">The mails was successfully sent</div>';
	$username = $_SESSION['dbusername'];
	$password = $_SESSION['dbpassword'];
	$userid   = $_SESSION['dbuserid'];
	$sql = "SELECT * FROM users WHERE username='$username' AND password='$password' AND rowID=$userid AND admin=1 LIMIT 1";
	$result = mysql_query($sql,$con);
	if(mysql_num_rows($result)=='1')
	{
		if(isset($_POST['username']) && isset($_POST['password']))
		{
			$sql2    = "SELECT * FROM users";
			$result2 = mysql_query($sql,$con);
			if($_POST['subject']!='' && $_POST['message']!='')
			{
				while ($row2 = mysql_fetch_array($result2))
				{
					mail($row2['email'], $_POST['subject'], $_POST['message'], 'From: filehunt@filehunt.com');
				}
				header('Location: ?page=admin&mailSuccess=true');
				
			} else echo 'You left someting empty!';
		
		}
	}
	else
	{
		header('Location: ?page=search');
		die();		
	}
}
else
{
	header('Location: ?page=search');
	die();
}̈́
/*
$sql = "SELECT * FROM abuse";
$result = mysql_query($sql,$con);
while($row =mysql_fetch_array($result))
{
	echo $row['rowID'];
}*/
?>