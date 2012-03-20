<?php
require_once('lib.php');
if(__FILE__ == $_SERVER['SCRIPT_FILENAME'])
	{
		header('Location: index.php?page=admin');
		die();
	}

if(isset($_GET['deleteReport']) && $_GET['deleteReport'] == 'true') echo '<div id="success">The report has successfylly been removed</div>
';

if (isset($_SESSION['dbuserid']))
{
	if(isset($_GET['deleteSuccess'])) echo '
<div id="success">The file was successfully deleted</div>
';
	echo
<<< _END
<h2>Send mail to all users</h2>
<form class="form" action="?page=admin" method="post">
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
	if(isset($_GET['mailSuccess'])) echo '
<div id="success">The mails was successfully sent</div>
';
	$userid   = $_SESSION['dbuserid'];
	$sql = "SELECT *
			FROM users
			WHERE rowID=$userid
			    AND ADMIN=1 LIMIT 1";
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
	$sql = "SELECT a.rowID AS a_rowID,
	       a.fileID AS a_fileID,
	       a.report_by AS a_report_by,
	       a.date_reported AS a_date_reported,
	       f.rowID AS f_rowID,
	       f.uploaded_by AS f_uploaded_by,
	       f.size AS f_size,
	       f.times_downloaded AS f_times_downloaded,
	       f.file AS f_file,
	       f.uploaded_date AS f_uploaded_date,
	       u.rowID AS u_rowID,
	       u.username AS u_username
			FROM abuse a,
			     files f,
			     users u
			WHERE a.fileID=f.rowID
	    	AND a.report_by=u.rowID";
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
	<th>Report by</th>
	<th>Reported date</th>
	<th>Delete file</th>
	<th>Delete report</th>
	";
		$count = 0;
		while($row =mysql_fetch_array($result))
		{			
			$fileRow  = $row['f_rowID'];
			$sql2     = "SELECT *
						FROM comments
						WHERE fileID='$fileRow'";
			$result2  = mysql_query($sql2,$con);
			$numrows2 = mysql_num_rows($result2);
			 if($numrows2 == 1) $comment_string = 'comment';
		    else $comment_string = 'comments';
			if(oddOrEven($count)==1) echo '
	<tr class="alt">
		';
			elseif(oddOrEven($count)==0) echo '
		<tr>
			';

			//Filename
			echo '
			<td>
				<a href=?page=fileinfo&fileID=' . $row['f_rowID'] . '>' . $row['f_file'] . '</a>
			</td>
			';
			//uploaded by
			echo '
			<td>
				<a href="?page=profile&userID='.$row['u_rowID'].'">' . $row['u_username'].'</a>
			</td>
			';
			//uploaded date
			echo '
			<td>'.date("d/m/y H:i",$row['f_uploaded_date']).'</td>
			';
			//size
			if($row['f_size'] >= 1024) echo '
			<td>'.($row["f_size"]/1024).' KB</td>
			';
			elseif($row['f_size'] >= 1048576) echo '
			<td>'.($row['f_size']/10485776).'MB</td>
			';
			else echo '
			<td>'.$row['f_size'].' bytes</td>
			';
			//times downloaded
			echo '
			<td>'.$row['f_times_downloaded'].'</td>
			';
			//report by
			$a_report_by = $row['a_report_by'];
			$sql3 = "SELECT *
					FROM users
					WHERE rowID=$a_report_by LIMIT 1";
			$result3 = mysql_query($sql3,$con);
			$row3 = mysql_fetch_array($result3);
			echo '
			<td>
				<a href="?page=profile&userID='.$row['a_report_by'].'">'.$row3["username"].'</a>
			</td>
			';
			//date reported
			echo '
			<td>'.date("d/m/y H:i",$row['a_date_reported']).'</td>
			';
			//Delete
			$rowidfile = $row['f_rowID'];
			$string1   = 'onClick=areYouSure('.$rowidfile.');';
			echo "
			<td>
				<a title='Delete file' onClick=adminDeleteFile('$rowidfile'); href='#'>
					<img height=32 width=32 src='img/trash.png'></a>
			</td>
			";
			echo "
			<td>
				<a title='Delete report' onClick='deleteReport(\"$rowidfile\")' href='#'>
					<img src='img/delete.png' height=32 width=32></td>
				";
			echo '
			</tr>
			';
			 ++$count;
			    
		}
		echo "
		</center>
	</table>
	";
	}
	else echo '
	<div id="error">There is no reported files</div>
	<br />
	';

	//List 3 month old files
	$checkDate = date("d/m/y H:i", time());
	$datestrto = strtotime($checkDate) - 7776000; //Now minus 3 months
	$sql = "SELECT f.rowID AS f_rowID,
		       f.uploaded_by AS f_uploaded_by,
		       f.uploaded_date AS f_uploaded_date,
		       f.file AS f_file,
		       d.downloaded_date AS d_downloaded_date,
		       u.username AS u_username
				FROM files f,
				     users u,
				     downloads d
				WHERE f.uploaded_date
	< $datestrto
				    AND f.uploaded_by=u.rowID
				    AND d.downloaded_date < $datestrto";
	$result = mysql_query($sql);
	echo mysql_error();
	if(mysql_num_rows($result) != 0)
	{
		echo '
<center>
		<h1>Too old files</h1>
		';
		echo '
		<table id="table">
			<th>File</th>
			<th>Uploaded by</th>
			<th>Uploaded_date</th>
			<th>Last download</th>
			';
			$count = 0;
			while($row = mysql_fetch_array($result))
			{
				if(oddOrEven($count)==1) echo "
			<tr class='alt'>
				";
            	elseif(oddOreven($count)==0) echo '
				<tr>
					';
            	echo '
					<td>
						<a href=?page=fileinfo&fileID='.$row['f_rowID'].'>'.$row['f_file'].'</a>
					</td>
					';
            	echo '
					<td>'.$row['u_username'].'</td>
					';
            	echo '
					<td>'.$row['f_uploaded_date'].'</td>
					';
            	echo '
					<td>'.date("d/m/y H:i",$row['d_downloaded_date']).'</td>
					';
				echo '
				</tr>
				';
				++$count;
			}
			echo '
			</table>
		</center>
		';
			echo '
		<form action="?page=delete_old_files" method=post>
			<input type="hidden" name="delete" value="true">
			<p class="submit">
				<input type="submit" value="Delete old files"></p>
		</form>
		';
	}
	else echo '
		<div id="error">There is no old files</div>
		';

}
else
{
	header('Location: ?page=404');
	die();
}
?>