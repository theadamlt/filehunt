<?php
require_once('lib.php');
if(__FILE__ == $_SERVER['SCRIPT_FILENAME'])
{
	header('Location: index.php?page=myprofile');
	die();
}

if(isset($_GET['passwordChange']))
{
	if($_GET['passwordChange'] == 'true')
	{
		echo '
					<br><div id="success">Your password has been changed!</div><br>
					';
	}
	else
	{
		echo "
					<br><div id='error'>
						Oups... Your password hasen't been changed. Please try again later
					</div><br>
					";
	}
}

if ((!isset($_SESSION['dbuserid'])))
{
	header('Location: ?page=login&attemptedSite=myprofile');
	die();
}
else 
{
	$session_userid   = $_SESSION['dbuserid'];

	if(isset($_GET['deleteSuccess']) && $_GET['deleteSuccess']=='true') echo '<div id="success">Your file was successfully deleted</div>
';
	elseif(isset($_GET['deleteSuccess'])) echo "
<br><div id='error'>Your file wasn't deleted. Please try again later</div><br>
";
	$sql = "SELECT *
			FROM files
			WHERE uploaded_by=$session_userid";
	$result = mysql_query($sql,$con);
	if(mysql_num_rows($result) != 0)
	{
	$count = 0; 
	echo "
	<input type='submit' value='My preferences' onclick='window.location.href=\"?page=user_pref\"'>
<center>
<h1 class='message'>Your uploaded files</h1>
<table id='table'>
	<th>Filename</th>
	<th>Delete file</th>
	";
		while($row = mysql_fetch_array($result))
		{
			$fileRow  = $row['rowID'];
			$sql2     = "SELECT *
						FROM comments
						WHERE fileID='$fileRow'";
			$result2  = mysql_query($sql2,$con);
			$numrows2 = mysql_num_rows($result2);
			if($numrows2 == 1) $comment_string = 'comment';
			else $comment_string = 'comments'; 
			//File size calc
			if(oddOrEven($count)==1) echo '
	<tr class="alt">
		';
			elseif(oddOrEven($count)==0) echo '
		<tr>
			';
			echo '
			<td>
				<a href=?page=fileinfo&fileID=' . $row['rowID'] . '>' . $row['file'] . '</a>
			</td>
			';
			$rowidfile = $row['rowID'];
			$string1   = 'onClick=areYouSure('.$rowidfile.',"myprofile");';
			echo "
			<td>
				<a title='Delete file' onClick=deleteOwnFile('$rowidfile'); href='#'>
					<img src='img/trash.png' height=32 width=32></a>
			</td>
			";
			echo "
		</tr>
		";
			++$count;
		}
			
			echo $row['uploded_by'];
			echo "
	</table>
</center>
";
	}
	else echo '
<br><div id="error">You have no uploads!</div><br>
';
}



?>
