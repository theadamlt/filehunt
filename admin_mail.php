<html>
<head>
	<link rel="icon" type="image/png" href="img/favicon.png" />
	<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
<?php
require_once('lib.php');
mysql_selector();

if ((isset($_POST['username'])) && (isset($_POST['password'])))
	{
		$username = mysql_enteries_fix_string($_POST['username']);
		$password = MD5(mysql_enteries_fix_string($_POST['password']));
		$sql = "SELECT * FROM users WHERE username='$username' AND password='$password' AND admin=1";
		$result = mysql_query($sql,$con);
		if(mysql_num_rows($result) == 1)
		{
			$row = mysql_fetch_array($result);
			if($row['admin'] == 1)
			{
				$sql2    = "SELECT * FROM users";
				$result2 = mysql_query($sql,$con);

				if ($_POST['subject']!='' && $_POST['message']!='')
				{
					while ($row2 = mysql_fetch_array($result2))
					{
						mail($row2['email'], $_POST['subject'], $_POST['message'], 'From: Filehunt@filehunt.com');
					}
					
				} else echo 'You left someting empty!';
			} else
			{
				echo 'You dont have permissions to do that!';
			}
			
		}
	}
?>

<form class="form" action="admin_mail.php" method="post">
<p class="username">
	<input type="text" name="username" placeholder="Username" id="username" />
	<label for="username">Username</label>
</p>	
<p class="password">
	<input type="password" name="password" placeholder="Password" id="password" />
	<label for="password">Password</label>								
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