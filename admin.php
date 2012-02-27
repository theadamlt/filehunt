<?php
require_once('lib.php');
mysql_selector();
if ((isset($_SESSION['dbusername']))&&(isset($_SESSION['dbpassword'])))
{
	if(isset($_GET['deleteSuccess'])) echo '<div id="success">The file was successfully deleted</div>';
	echo <<< _END
	<h2>Send mail to all users</h2>
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
	if(mysql_num_rows($result)==1)
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
		header('Location: ?page=404');
		die();		
	}
	$sql = "SELECT a.rowID as a_rowID, a.fileID as a_fileID, a.report_by AS a_report_by, a.date_reported AS a_date_reported, f.rowID as f_rowID, f.uploaded_by AS f_uploaded_by, f.size AS f_size, f.times_downloaded AS f_times_downloaded, f.file AS f_file, f.uploaded_date AS f_uploaded_date, u.rowID as u_rowID, u.username as u_username FROM abuse a, files f, users u WHERE a.fileID=f.rowID and a.report_by=u.rowID;
";
	$result = mysql_query($sql,$con);
	if(mysql_num_rows($result) != 0)
	{
		echo "
		<center>
		<h1 class='message'>Reported files</h1>
		<table id='table'>
		<th>Filename</th>
		<th>Uploaded by</th>
		<th>Upload date</th>
		<th>Filesize</th>
		<th>Times downloaded</th>
		<th>Comments</th>
		<th>Report by</th>
		<th>Reported date</th>
		<th>Delete</th>";
		$count = 0;
		while($row =mysql_fetch_array($result))
		{			
			$fileRow  = $row['f_rowID'];
			$sql2     = "SELECT * FROM comments WHERE fileID='$fileRow'";
			$result2  = mysql_query($sql2,$con);
			$numrows2 = mysql_num_rows($result2);
			 if($numrows2 == 1) $comment_string = 'comment';
		    else $comment_string = 'comments';
			if(oddOrEven($count)==1) echo '<tr class="alt">';
			elseif(oddOrEven($count)==0) echo '<tr>';

			//Filename
			echo '<td><a href=download.php?file=' . $row['f_rowID'] . '>' . $row['f_file'] . '</a></td>';
			//uploaded by
			echo '<td><a href="?page=profile&userID='.$row['u_rowID'].'">' . $row['u_username'].'</a></td>';
			//uploaded date
			echo '<td>'.$row['f_uploaded_date'].'</td>';
			//size
			if($row['f_size'] >= 1024) echo '<td>'.($row["f_size"]/1024).'kB</td>';
			elseif($row['f_size'] >= 1048576) echo '<td>'.($row['f_size']/10485776).'mB</td>';
			else echo '<td>'.$row['f_size'].'bytes</td>';
			//times downloaded
			echo '<td>'.$row['f_times_downloaded'].'</td>';
			//Comments
			echo "<td><a href='?page=comments&fileID=".$row['f_rowID']."'>$numrows2 $comment_string</a></td>";
			//report by
			echo '<td>'.$row["a_report_by"].'</td>';
			//date reported
			echo '<td>'.$row["a_date_reported"].'</td>';
			//Delete
			$rowidfile = $row['f_rowID'];
			$string1   = 'onClick=areYouSure('.$rowidfile.');';
			echo "<td><a title='Delete file' onClick=areYouSure('$rowidfile','admin'); href='#'><img src='img/trash.png'></a></td>";
			echo "</tr>";
			 ++$count;
			    
		}
		echo "
		</center>
		</table>";
	}
	else echo '<div id="error>There is no reported files</div>"';
}
else
{
	header('Location: ?page=404');
	die();
}
?>
