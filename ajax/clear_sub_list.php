<?php
$datestrto = time();
$sql = "UPDATE users
		SET last_sub_check=$datestrto
		WHERE rowID=$_SESSION[dbuserid]";
$result = mysql_query($sql);
?>