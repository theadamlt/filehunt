<?php 
if (isset($_GET['uploadError']))
{
	$error = $_GET['uploadError'];
	switch ($error)
	{
		case '0':
			echo '<div id="error">There was an error uploading your file</div>';
			break;
		case '1':
			echo '<div id="error">Your file is too big1</div>';			
			break;
		case '2':
			echo '<div id="error">Your file is too big2</div>';							
			break;
		case '3':
			echo '<div id="error">The uploaded file was only partially uploaded</div>';
			break;
		case '4':
			echo '<div id="error">You have to select a file!</div>';
		default:
			echo '<div id="error">There was an error uploading your file</div>';
			break;
	}
	echo '
	<center>
	<form class="form" enctype="multipart/form-data" action="uploadaction.php" method="POST">
	<input type="hidden" name="MAX_FILE_SIZE" value="31457280" />
	<p class="uploadfile">
		<input name="uploadedfile" type="file" />
	</p>
	<p class="submit">
		<input type="hidden" name="upload" value="start" />
		<input type="submit" value="Upload File" />
	</p>
	</form></center>';
}
elseif ((!isset($_SESSION['dbusername']))&&(!isset($_SESSION['dbpassword'])))
{
	header('Location: ?page=login&attemptedSite=upload');
	die();
}
else
{
	echo '
	<center>
	<form class="form" enctype="multipart/form-data" action="uploadaction.php" method="POST">
	<input type="hidden" name="MAX_FILE_SIZE" value="31457280" />
	<p class="uploadfile">
		<input name="uploadedfile" type="file" />
	</p>
	<p class="submit">
		<input type="hidden" name="upload" value="start" />
		<input type="submit" value="Upload File" />
	</p>
	</form></center>';
}
?>
