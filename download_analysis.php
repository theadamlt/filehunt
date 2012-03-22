<?php
require_once('lib.php');
if(__FILE__ == $_SERVER['SCRIPT_FILENAME'])
	{
		header('Location: index.php?page=download_analysis');
		die();
	}

if(isset($_GET['file']))
{
// 	$sql = "SELECT *
// 			FROM files
// 			WHERE uploaded_by=$_SESSION[dbuserid]
// 			    AND rowID=$_GET[file] LIMIT 1";
// 	$result = mysql_query($sql);
// 	if(mysql_num_rows($result) == 1)
// 	{
	$sql = "SELECT d.rowID AS d_rowID,
			       d.downloaded_by AS d_downloaded_by,
				   d.fileID AS d_fileID,
				   d.downloaded_date AS d_downloaded_date,
				   u.username AS u_username,
				   u.rowID AS u_rowID,
				   f.rowID AS f_rowID,
				   f.file AS f_file
			FROM downloads d,
				     users u,
				     files f
			WHERE d.fileID=$_GET[file]
				AND d.downloaded_by=u.rowID
				AND d.fileID=f.rowID";
		$result = mysql_query($sql);
		if(mysql_num_rows($result) != 0)
		{
			echo '<center><table id="table"><th></th><th>Downloaded by</th><th>Downloaded date</th>';
			$count = 0;
			while ($row = mysql_fetch_array($result))
			{
				if(oddOrEven($count) == 1) echo '<tr class="alt">';
				else echo '<tr>';
				echo '<td>'.++$count.'</td><td><a href=?page=profile&userID='.$row['u_rowID'].'>'.$row['u_username'].'</a></td><td>'.date("d/m/y H:i",$row['d_downloaded_date']).'</td></tr>';
			}
			echo '</table></center>';
		}
		else
		{
			echo '<div id="error">The file has never been downloaded</div>';
		}
}
else
{
	header('Location: ?page=404');
	die();
}
?>