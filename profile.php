<?php
require_once('lib.php');;
mysql_selector();

if(isset($_GET['userID']))
{
	if(isset($_SESSION['dbuserid']) && $_SESSION['dbuserid'] == $_GET['userID']) header('Location: ?page=myprofile');
	else
	{
		$profile = $_GET['userID'];
		$sql     = "SELECT * FROM users where rowID=$profile LIMIT 1";
		$result  = mysql_query($sql,$con);
		$numrows = mysql_num_rows($result);
		if($numrows == 1)
		{
			$row = mysql_fetch_array($result);
			echo '<center><br />';
			echo  'Username: '.$row['username'];
			echo '<br /><br />';
			echo  'Email: '.$row['email'];
			echo '<br /><br />';
			if($row['admin'] == '1') echo  'Admin';
			echo '</center>';

			//Find uploads
			$sql = "SELECT * FROM files WHERE uploaded_by='$profile'";
			$result = mysql_query($sql,$con);
			$numrows = mysql_num_rows($result); 
			if($numrows > 0)
			{
				echo '
				<center><br />
				<table id="table">
				<th>Filename</th>
				<th>Date</th>';
				$count = 0;
				while($row = mysql_fetch_array($result))
				{
					$fileRow = $row['rowID'];
					$sql2     = "SELECT * FROM comments WHERE fileID='$fileRow'";
			        $result2  = mysql_query($sql2,$con);
			        $numrows2 = mysql_num_rows($result2);
			        if($numrows2 == 1) $comment_string = 'comment';
		            else $comment_string = 'comments';

					if(oddOrEven($count)==1) echo '<tr class="alt">';
					elseif(oddOrEven($count)==0) echo '<tr>';
					echo '
						<td><a href="download.php?file='.$row['rowID'].'>"'.$row["file"].'</a></td>
						<td>'.$row["uploaded_date"].'</td>';
						echo "<td><a href='?page=comments&fileID=".$row['rowID']."'>$numrows2 $comment_string</a></td>
						</tr>";;
				}
			}
			else
			{
				echo '<br /><div id="error">The user has no uploads</div>';
			} 
			
		} else header('Location: google.com');
	}
}
else
{
	header('Location: index.php?page=search');
	die();
}
?>