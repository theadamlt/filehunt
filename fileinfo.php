<?php
if(isset($_GET['fileID']))
{
	$fileID = $_GET['fileID'];

	$sql = "SELECT f.rowID AS f_rowID, f.file AS f_file, f.uploaded_by AS f_uploaded_by, f.uploaded_date AS f_uploaded_date, f.size AS f_size, f.times_downloaded AS f_times_downloaded, f.mimetype AS f_mimetype, u.rowID AS u_rowID, u.username AS u_username FROM users u, files f WHERE f.uploaded_by=u.rowID AND f.rowID=$fileID LIMIT 1";
	$result = mysql_query($sql);
	if(mysql_num_rows($result) == 0)
	{
		header('Location: ?page=404');
		die();
	}
	$row = mysql_fetch_array($result);
	echo '<h1>'.$row['f_file'].'</h1><br />';
	echo '<a href="download.php?file='.$row['f_rowID'].'">Download file</a><br><br>';
	
	echo '<center><table id="table">
	<th>Uploaded by</th>
	<th>Size</th>
	<th>Date uploaded</th>
	<th>Mimetype</th>';
	echo '<tr class="alt">';
	echo '<td><a href=?page=profile&userID='.$row['u_rowID'].'>'.$row['u_username'].'</a></td>';
	if($row['f_size'] >= 1024) echo '<td>'.($row['f_size']/1024).' KB</td>';
	elseif($row['f_size'] >= 1048576) echo '<td>'.($row['f_size']/10485776).' MB</td>';
	else echo '<td>'.$row['f_size'].' bytes</td>';
	echo '<td>'.date("d/m/y H:i",$row['f_uploaded_date']).'</td>';
	echo '<td>'.$row['f_mimetype'].'</td>';
	echo '</tr>';
	echo '</table></center>';

	if(substr($row['f_mimetype'], 0, 6) == 'image/') echo '<br /><img src="printimage.php?id='.$fileID.'" />';

	echo '<h1>Comments</h1>';

	$sql = "SELECT c.rowID AS comment_rowID, c.fileID AS fileID, c.comment_by AS comment_by_id, c.date_commented AS date_commented, c.comment AS comment, u.username AS username, u.rowID AS user_row FROM comments c, users u WHERE c.fileID=$fileID AND c.comment_by=u.rowID";
	//
	$result  = mysql_query($sql,$con);
	$numrows = mysql_num_rows($result);
	if($numrows !=0)
	{
		echo <<< _END
		<center>
		<table id="table">
		<th>Commented by</th>
		<th>Date commented</th>
		<th>Comment</th>
_END;
		
		$fileID  = $_GET['fileID'];
		$sql2 ="SELECT f.file AS filename, f.rowID AS file_row, f.uploaded_by AS uploaded_by, u.rowID AS user_row, u.username AS username FROM files f, users u WHERE f.rowID=$fileID LIMIT 1";
		$result2 = mysql_query($sql2,$con);
		$row2 = mysql_fetch_array($result2);
		$fileName = $row2['filename'];
		$uploaded_by = $row2['username'];
		$count = 0;
		while($row = mysql_fetch_array($result))
		{
			$commented_by   = $row['username'];
			$date_commented = $strtDate = date("d/m/y H:i",$row['date_commented']);
			$comment        = $row['comment'];
			if(oddOrEven($count)==1) echo '<tr class="alt">';
			elseif(oddOrEven($count)) echo '<tr>';
			$row_userid = $row['user_row'];
			echo "<td><a href='?page=profile&userID=$row_userid'>$commented_by</a></td>
			<td>$date_commented</td>
			<td>$comment</td></tr>";
		++$count;
		}
		echo '</table></center>';
		
	}
	elseif($numrows == 0 && isset($_SESSION['dbusername']))
	{
		echo "<div id='error'>There is no comments for this file! Why dont ya' add one?</div>";
	}
	elseif($numrows == 0 && !isset($_SESSION['dbusername']))
	{
		echo "<div id='error'>There is no comments for this file!</div>";
	}

	if (isset($_SESSION['dbusername']))
	{
	$query_string = '?'.$_SERVER['QUERY_STRING'];
	echo <<< _END
<form class="form" action="$query_string" method="post">
	<p class="message">
		<label for="message">Message</label><br />
		<textarea name="comment" cols="40" rows="6" placeholder="Message" id="message" ></textarea>
		<input type='hidden' name='submit' value='true' />
	</p>
	<p class="submit">
		<input type="submit" value="Submit" />
	</p>
</form>
_END;
	}
	else
	{
		$fileID_attempt = $_GET['fileID'];
		echo "<br /><div id='error'>You need to <a href='?page=login&attemptedSite=comments&fileID=$fileID_attempt'>login</a> to comment!</div>";
	}

	if(isset($_POST['comment']) && $_POST['comment']!='' && isset($_POST['submit']))
	{
		$get_fileid     = $_GET['fileID'];
		$session_userid = $_SESSION['dbuserid'];
		$date = date("d/m/y H:i", time());
		$datestrto = strtotime($date);
		$post_comment   = $_POST['comment'];
		$sql_uniq = "SELECT * FROM comments WHERE comment='$post_comment' AND comment_by=$session_userid";
		$result_uniq = mysql_query($sql_uniq);
		if(mysql_num_rows($result_uniq) == 0)
		{
			$sql = "INSERT INTO comments (rowID, fileID, comment_by, date_commented, comment) VALUES(NULL, $get_fileid, $session_userid, '$datestrto', '$post_comment')";
			$result = mysql_query($sql,$con);
		}
	}
}
else
{
	header('Location: ?page=404');
	die();
}


?>