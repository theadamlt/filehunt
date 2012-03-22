<?php
require_once('lib.php');
if(__FILE__ == $_SERVER['SCRIPT_FILENAME'])
	{
		header('Location: index.php?page=profile');
		die();
	}

if(isset($_GET['userID']))
{
	if(isset($_SESSION['dbuserid']) && $_SESSION['dbuserid'] == $_GET['userID']) header('Location: ?page=myprofile');
	else
	{
		$profile = $_GET['userID'];
		$sql     = "SELECT *
				FROM users
				WHERE rowID=$profile LIMIT 1";
		$result  = mysql_query($sql,$con);
		$numrows = mysql_num_rows($result);
		if($numrows == 1)
		{
			$sql2 = "SELECT * FROM user_pref WHERE userID = $profile";
			$result2 = mysql_query($sql2);
			if(mysql_num_rows($result2) == 0) $row2 = array('show_real_name' => '0', 'show_mail' => '0', 'admin' => '0');
			else $row2 = mysql_fetch_array($result2);
			$row = mysql_fetch_array($result);

			//Subscribe user message
			if(isset($_GET['subscribeSuccess']) && $_GET['subscribeSuccess'] == 'true')
			{
				echo '<div id="success">You have successfully subscribed to '.$row["username"].'</div><br />';
			}
			elseif(isset($_GET['subscribeSuccess']) && $_GET['subscribeSuccess'] == 'false')
			{
				echo '<div id="error">An error occured. You have not subscribed to '.$row['username'].'. Please try again later</div><br />';
			}

			//Unsubscribe user message
			if(isset($_GET['unsubscribeSuccess']) && $_GET['unsubscribeSuccess'] == 'true')
			{
				echo '<div id="success">You have successfully unsubscribed to '.$row["username"].'</div><br />';	
			}
			elseif(isset($_GET['unsubscribeSuccess']) && $_GET['unsubscribeSuccess'] == 'false')
			{
				echo '<div id="error">An error occured. You have not unsubscribed to '.$row['username'].'. Please try again later</div><br />';
			}

			echo '<center><br />Username: '.$row['username'].'<br /><br />';

			if($row2['show_real_name'] == 1)echo  'Real name: '.$row2['real_name'].'<br /><br />';

			if($row2['show_mail'] == 1)echo  'Email: '.$row['email'].'<br><br>';

			if($row2['admin'] == '1') echo  'Admin';
			echo '</center>';

			if(isset($_SESSION['dbuserid']))
			{
				//Is logged in user a subscriber?
				$sql3 = "SELECT *
						FROM subs
						WHERE subscriber=$_SESSION[dbuserid]
						    AND subscribed=$_GET[userID]";
				$result3 = mysql_query($sql3);
				if(mysql_num_rows($result3) == 1)
				{
					echo "<form action='?page=unsubscribe' method='post'><input type='hidden' name='unsubscribeTo' value='$profile' /><p class='submit'><input type='submit' value='Unsubscribe' /></p></form>";
				}
				else
				{
					echo "<form action='?page=subscribe' method='post'><input type='hidden' name='subscribeTo' value='$profile' /><p class='submit'><input type='submit' value='Subscribe' /></p></form>";
				}
			}

			//Find uploads
			$sql = "SELECT *
					FROM files
					WHERE uploaded_by='$profile'";
			$result = mysql_query($sql,$con);
			$numrows = mysql_num_rows($result); 
			if($numrows > 0)
			{
				echo '<center><br /><table id="table"><th>Filename</th>';
				$count = 0;
				while($row = mysql_fetch_array($result))
				{
					$fileRow = $row['rowID'];
					$sql2     = "SELECT *
								FROM comments
								WHERE fileID='$fileRow'";
			        $result2  = mysql_query($sql2,$con);
			        $numrows2 = mysql_num_rows($result2);
			        if($numrows2 == 1) $comment_string = 'comment';
		            else $comment_string = 'comments';

					if(oddOrEven($count)==1) echo '<tr class="alt">';
					elseif(oddOrEven($count)==0) echo '<tr>';
					echo '<td><a href="?page=fileinfo&fileID='.$row['rowID'].'">'.$row["file"].'</a></td></tr>';	
					++$count;

				}
				echo '</table></center>';
			}
			else
			{
				echo '<br /><div id="error">The user has no uploads</div>';
			} 
			
		}
		else
		{
			header('Location: ?page=404');
			die();
		}
	}
}
else
{
	header('Location: index.php?page=search');
	die();
}
?>