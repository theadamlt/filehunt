<?php

if($_REQUEST['action'] == 'is_reported')
{
	$sql = "SELECT * FROM abuse WHERE fileID=$_REQUEST[file]";
	$result = mysql_query($sql);
	if(mysql_num_rows($result) > 0) echo 'true';
	else echo 'false';

}
elseif($_REQUEST['action'] == 'fileinfo')
{
	$sql = "SELECT f.rowID AS f_rowID,
	        f.file AS f_file,
	        f.uploaded_by AS f_uploaded_by,
			f.uploaded_date AS f_uploaded_date,
			f.size AS f_size,
			f.mimetype AS f_mimetype,
			f.description AS f_description,
			u.rowID AS u_rowID,
			u.username AS u_username
				FROM users u,
				     files f
				WHERE f.uploaded_by=u.rowID
				AND f.rowID=$_REQUEST[file] LIMIT 1";
	$result = mysql_query($sql);
	if(mysql_num_rows($result) == 0)
	{
		echo 'false';
		die();
	}
	$rows = array();
	while($r = mysql_fetch_array($result))
	{
		$rows[] = $r;
	}
	echo json_encode($rows);
}

elseif($_REQUEST['action'] == 'times_downloaded')
{
	$sql = "SELECT * FROM downloads WHERE fileID = $_REQUEST[file]";
	$result = mysql_query($sql);
	echo mysql_num_rows($result);
}
?>