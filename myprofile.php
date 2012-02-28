<?php
require_once('lib.php');
if(__FILE__ == $_SERVER['SCRIPT_FILENAME'])
	{
		header('Location: index.php?page=myprofile');
		die();
	}
mysql_selector();

if ((!isset($_SESSION['dbusername']))&&(!isset($_SESSION['dbpassword'])))
{
	header('Location: ?page=login&attemptedSite=myprofile');
	die();
}
else 
{
	$session_user     = $_SESSION['dbusername'];
	$session_password = $_SESSION['dbpassword'];
	$session_userid   = $_SESSION['dbuserid'];


	$sql    = "SELECT * FROM users WHERE username='$session_user' AND password='$session_password'";
	$result = mysql_query($sql,$con);
	$row    = mysql_fetch_array($result);
	$sql_username = $row['username'];
	$sql_password = $row['password'];
	$sql_email    = $row['email'];

	if(isset($_GET['deleteSuccess']) && $_GET['deleteSuccess']=='true') echo '<div id="success">Your file was successfully deleted</div>';
	elseif(isset($_GET['deleteSuccess'])) echo "<div id='error'>Your file wasn't deleted. Please try again later</div>";

	echo '
	<div id="signup">
				<p>Username: '.$sql_username.'</p>
				<p>Email: '.$sql_email.'</p>
	</div>';

	$sql = "SELECT * FROM files WHERE uploaded_by=$session_userid";
	$result = mysql_query($sql,$con);
	if(mysql_num_rows($result)!=0)
	{
	echo "
		<center>
		<h1 class='message'>Your uploaded files</h1>
		<table id='table'>
		<th>Filename</th>
		<th>Upload date</th>
		<th>Filesize</th>
		<th>Times downloaded</th>
		<th>Comments</th>
		<th>Delete file</th>";
		while($row = mysql_fetch_array($result))
		{
			$fileRow  = $row['rowID'];
			$sql2     = "SELECT * FROM comments WHERE fileID='$fileRow'";
			$result2  = mysql_query($sql2,$con);
			$numrows2 = mysql_num_rows($result2);
	        if($numrows2 == 1) $comment_string = 'comment';
            else $comment_string = 'comments';
			$count = 0;  
	        //File size calc
	        if(oddOrEven($count)==1) echo '<tr class="alt">';
	        elseif(oddOrEven($count)==0) echo '<tr>';
	        echo '<td><a href=download.php?file=' . $row['rowID'] . '>' . $row['file'] . '</a></td>';
	        echo '<td>' . $row['uploaded_date'] . '</td>';  
	        if($row['size'] >= 1024) echo '<td>'.($row["size"]/1024).'kB</td>';
	        elseif($row['size'] >= 1048576) echo '<td>'.($row['size']/10485776).'mB</td>';
	        else echo '<td>'.$row['size'].'bytes</td>';
	        echo '<td>'.$row['times_downloaded'].'</td>';
	        echo "<td><a href='?page=comments&fileID=".$row['rowID']."'>$numrows2 $comment_string</a></td>";
			$rowidfile = $row['rowID'];
			$string1   = 'onClick=areYouSure('.$rowidfile.',"myprofile");';
	        echo "<td><a title='Delete file' onClick=areYouSure('$rowidfile'); href='#'><img src='img/trash.png'></a></td>";
	        echo "</tr>";
	        ++$count;
	    }
	        
	        echo $row['uploded_by'];
	        echo "</table></center>";
    }
    else echo '<div id="error">You have no uploads!</div>';
}

?>

