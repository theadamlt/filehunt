<?php
if ( __FILE__ == $_SERVER['SCRIPT_FILENAME'] ) {
	die('Illegal request');
}
$sql = "SELECT c.rowID AS comment_rowID,
			c.fileID AS fileID,
			c.comment_by AS comment_by_id,
			c.date_commented AS date_commented,
			c.comment AS comment,
			u.username AS username,
			u.rowID AS user_row
			FROM comments c,
     			users u
			WHERE c.fileID=$_REQUEST[file]
    		AND c.comment_by=u.rowID";
$result  = mysql_query( $sql );
if ( mysql_num_rows( $result ) == 0 ) echo 'false';
else {
	$rows = array();
	while ( $r = mysql_fetch_array( $result ) ) {
		$rows[] = $r;
	}

	echo json_encode( $rows );
}

?>
