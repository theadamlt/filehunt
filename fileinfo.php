<?php
if(__FILE__ == $_SERVER['SCRIPT_FILENAME'])
{
	header('Location: index.php?page=fileinfo');
	die();
}
?>
<span id="warning"></span><div id="success"></div><p class="submit"><input type="button" value="Download file" onclick="window.location.href='download.php?file=<?=$_GET['fileID']?>'"><br /><br /><input type='button' onClick='reportFile(<?=$_GET["fileID"]?>)' value='Report abuse' ></p><script type="text/javascript">fileInfo();</script><div id="cont"></div><div id="comments"></div><div id="commentform"></div>
