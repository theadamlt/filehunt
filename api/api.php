<?php
$con = mysql_connect('localhost', 'root', '');
if (!$con)	{
	die ("Could not connect to MySQL database ".mysql_error());
}

$con_db = mysql_select_db('filehunt', $con);
if (!$con_db) {
	die ("Could not select database ".mysql_error());
}

if($_GET['func'] == 'login')
{
	error_reporting(0);
	$sql = "SELECT * FROM users WHERE username = '$_GET[u]' AND password = '$_GET[p]'";
	$result = mysql_query($sql);

	echo json_encode(mysql_fetch_array($result));
}
?>