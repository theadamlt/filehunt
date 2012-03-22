<?php
require_once('lib.php');
if(__FILE__ == $_SERVER['SCRIPT_FILENAME'])
{
	header('Location: index.php?page=mysubscribtions');
	die();
}


if(isset($_SESSION['dbuserid']))
{
	$userID = $_SESSION['dbuserid'];
	$sql = "SELECT s.rowID AS s_rowID,
			       s.subscriber AS s_subscriber,
			       s.subscribed,
			       u.rowID AS u_rowID,
			       u.username AS u_username
			FROM subs s,
			     users u
			WHERE s.subscriber=$userID
			    AND s.subscribed=u.rowID";
	$result = mysql_query($sql);
	if(mysql_num_rows($result) != 0)
	{
		echo '<selection class="progress window"><details><summary>Your subscriptions('.mysql_num_rows($result).')</summary>';
		while($row = mysql_fetch_array($result))
		{
			echo '<a href="?page=profile&userID='.$row['u_rowID'].'">'.$row['u_username'].'</a><br />';
		}
		echo '</details></selection><br />';
	}
	else echo '<div id="error">You have no subscriptions</div><br />';

	$userID2 = $_SESSION['dbuserid'];
	$sql2 = "SELECT s.rowID AS s_rowID,
			       s.subscriber AS s_subscriber,
			       s.subscribed,
			       u.rowID AS u_rowID,
			       u.username AS u_username
			FROM subs s,
			     users u
			WHERE s.subscribed=$userID2
			    AND s.subscriber=u.rowID";
	$result2 = mysql_query($sql2);
	if(mysql_num_rows($result2) != 0)
	{
		echo '<selection class="progress window"><details><summary>Your subscribers('.mysql_num_rows($result2).')</summary>';
		while($row2 = mysql_fetch_array($result2))
		{
			echo '<a href="?page=profile&userID='.$row2['u_rowID'].'">'.$row2['u_username'].'</a><br />';
		}
		echo '</details></selection><br />';
	}
	else echo '<div id="error">You have no subscribers</div>';

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
			WHERE s.subscriber = $userID2
			    AND me.rowID = $userID2
			    AND s.subscribed = f.uploaded_by
			    AND f.uploaded_by = u.rowID
			    AND me.last_sub_check < f.uploaded_date";
	$result = mysql_query($sql);
	if(mysql_num_rows($result) != 0)
	{
        echo '<h1>The files</h1><center><table id="table"><th>Filename</th><th>Uploaded by</th><th>Upload date</th>';
        $count = 0;
		while($row = mysql_fetch_array($result))
		{

			$sql2     = "SELECT *
						FROM comments
						WHERE fileID='".$row['f_rowID']."'";
			$result2  = mysql_query($sql2,$con);
			$numrows2 = mysql_num_rows($result2);
	        if($numrows2 == 1) $comment_string = 'comment';
            else $comment_string = 'comments'; 

			if(oddOrEven($count)==1) echo "<tr class='alt' id='".$row['f_rowID']."'>";
            elseif(oddOreven($count)==0) echo '<tr id='.$row['f_rowID'].'><td><a href=?page=fileinfo&fileID=' . $row['f_rowID'] . '>' . $row['f_file'] . '</a></td><td><a href=?page=profile&userID='.$row['f_uploaded_by'].'>'.$row['u_username'].'</a></td><td>'.date("d/m/y H:i",$row['f_uploaded_date']).'</td></tr>';
            ++$count;
		}
		echo '</table></center>';
		echo '<form action="?page=clear_sub_list" method="post"><input type="hidden" name="clear_list" value="true"><p class="submit"><input type="submit" value="Clear list"></p></form>';
	}
	else
	{
		echo '<div id="error">You have no unseen files</div>';
	}

}
else
{
	header('Location: ?page=login&attemptedSite=mysubscribtions');
	die();
}


?>
<script src="js/jquery.details.min.js"></script>
<script>
window.console || (window.console = { 'log': alert });
$(function() {
// Add conditional classname based on support
$('html').addClass($.fn.details.support ? 'details' : 'no-details');

// Show a message based on support
//$('body').prepend($.fn.details.support ? 'Native support detected; the plugin will only add ARIA annotations and fire custom open/close events.' : 'Emulation active; you are watching the plugin in action!');

// Emulate <details> where necessary and enable open/close event handlers
$('details').details();

// Bind some example event handlers
$('details').on({
'open.details': function() {
//console.log('opened');
},
'close.details': function() {
//console.log('closed');
}
});
});
</script>