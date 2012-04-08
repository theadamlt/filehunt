<?php

$datestrto = time();
$comment   = $_REQUEST['comment'];
$sql = "INSERT INTO comments (rowID, fileID, comment_by, date_commented, COMMENT)
		VALUES(NULL, $_REQUEST[file], $_SESSION[dbuserid], $datestrto, '$comment')";
$result = mysql_query($sql);

?>