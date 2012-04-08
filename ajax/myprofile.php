<?php
$sql = "SELECT *
			FROM files
			WHERE uploaded_by=$_SESSION[dbuserid]";
$result = mysql_query($sql);
// array_push($array, mysql_fetch_array($result));
$rows = array();
while($r = mysql_fetch_assoc($result))
{
    $rows[] = $r;
}
echo json_encode($rows);
?>