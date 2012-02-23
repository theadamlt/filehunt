<?php
$host = $_SERVER['HTTP_HOST'];
		$id = 9;
		$downloadLink = "download.php?file=$id";
	
		$url = $host.'/'.$downloadLink;
		echo $url;
?>