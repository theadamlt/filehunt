<?php
require_once('lib.php');
localhost_con('filehunt');

if(isset($_POST['search_term']) && !empty($_POST['search_term']))
{
	$search_term = mysql_real_escape_string($_POST['search_term']);

	$sql = "SELECT file FROM files WHERE file LIKE '$search_term%'";
	$result = mysql_query($sql,$con);
	while($row = mysql_fetch_assoc($result))
	{
		echo '<li>'.$row['file'].'</li>';
	}
}
?>