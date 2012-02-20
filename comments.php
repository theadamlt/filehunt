<?php
require('lib.php');
mysql_selector();

if(isset($_POST['comment']) && $_POST['comment']!='' && isset($_POST['submit']))
{
	$get_fileid     = $_GET['fileID'];
	$session_userid = $_SESSION['dbuserid'];
	$date           = date("y/m/d : H:i:s", time());
	$post_comment   = $_POST['comment'];
	$sql            = "INSERT INTO comments (rowID, fileID, comment_by, date_commented, comment) VALUES(NULL, $get_fileid, $session_userid, '$date', '$post_comment')";
	$result = mysql_query($sql,$con);
}





if(!isset($_GET['fileID'])) header('Location: ?page=search');
elseif(isset($_GET['fileID']))
{
	$fileID  = $_GET['fileID'];
	//
	$sql     = "SELECT c.rowID AS comment_rowID, c.fileID AS fileID, c.comment_by AS comment_by_id, c.date_commented AS date_commented, c.comment AS comment, u.username AS username, u.rowID AS user_row FROM comments c, users u WHERE c.fileID=$fileID AND c.comment_by=u.rowID";
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
		$sql2 ="SELECT f.file AS filename, f.rowID AS file_row, f.uploaded_by AS uploaded_by, u.rowID AS user_row, u.username AS username FROM files f, users u WHERE f.rowID=9 LIMIT 1";
		$result2 = mysql_query($sql2,$con);
		while($row2 = mysql_fetch_array($result2))
		{
			$fileName = $row2['filename'];
			$uploaded_by = $row2['username'];
		}
		echo "<h2>$fileName, uploaded by $uploaded_by</h2>";
		$count = 0;
		while($row = mysql_fetch_array($result))
		{
			$commented_by   = $row['username'];
			$date_commented = $row['date_commented'];
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
	elseif($numrows = 0 && isset($_SESSION['dbusername']))
	{
		echo "<div id='error'>There is no comments for this file! Why dont ya' add one?";
	}
	elseif($numrows = 0 && !isset($_SESSION['dbusername']))
	{
		echo "<div id='error'>There is no comments for this file!</div>";
	}
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

echo '<p class="submit"><input type="button" onClick="javascript:history.back()" value="Back" />';
?>