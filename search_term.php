<?php
require_once('lib.php');


if(isset($_POST['search_term']) && !empty($_POST['search_term']))
{
	$select_val = mysql_real_escape_string($_POST['select_val']);
	$search_term = mysql_real_escape_string($_POST['search_term']);

	if($select_val == 'filename')
	{
		$sql = "SELECT f.file AS file , f.uploaded_by AS uploaded_by, u.rowID AS user_rowID, u.username AS username
	FROM files f, users u WHERE f.file LIKE '$search_term%' AND f.uploaded_by = u.rowID OR u.username LIKE '$search_term%' AND f.uploaded_by = u.rowID";
		$result = mysql_query($sql,$con);
		while($row = mysql_fetch_assoc($result))
		{
			echo '<li>'.$row['file']./*.$row['username'].*/'</li>';
		}
	}

	elseif($select_val == 'all')
	{
		$sql = "SELECT * FROM users WHERE username LIKE '$search_term%'";
		$result = mysql_query($sql,$con);
		while($row = mysql_fetch_assoc($result))
		{
			// echo '<li>'.$row['file'].'</li>';
			echo '<li>'.$row['username'].'</li>';
		}
		$sql2 = "SELECT f.file FROM files f WHERE f.file LIKE '$search_term%'";
		$result2 = mysql_query($sql2,$con);
		if(mysql_num_rows($result2) != 0)
		{
			while($row2 = mysql_fetch_assoc($result2))
			{
				echo '<li>'.$row2['file'].'</li>';
			}
		}
	}

	elseif($select_val == 'username')
	{
		$sql = "SELECT * FROM users WHERE username LIKE '$search_term%'";
		$result = mysql_query($sql,$con);
		while($row = mysql_fetch_assoc($result))
		{
			echo '<li>'.$row['username'].'</li>';
		}
	}
	
}
?>