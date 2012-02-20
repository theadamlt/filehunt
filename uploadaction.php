<?php
require('lib.php');
mysql_selector();

session_start();

//var_dump($_FILES['uploadedfile']);

if(isset($_POST['upload']) && $_FILES['uploadedfile']['size'] > 0)
{
	$fileName = $_FILES['uploadedfile']['name'];
	$tmpName  = $_FILES['uploadedfile']['tmp_name'];
	$fileSize = $_FILES['uploadedfile']['size'];
	$fileType = $_FILES['uploadedfile']['type'];
	$fileType;
	
	$fp      = fopen($tmpName, 'r');
	$content = fread($fp, filesize($tmpName));
	$content = mysql_real_escape_string($content);
	fclose($fp);
	if(!get_magic_quotes_gpc())
	{
	    $fileName = mysql_real_escape_string($fileName);
	}

	$date = date("y/m/d : H:i:s", time());
	$user = $_SESSION['dbuserid'];

	$sql = "INSERT INTO files (rowID, file, mimetype, data, uploaded_by, uploaded_date, size, times_downloaded) 
	VALUES (NULL, '$fileName', '$fileType', '$content', '$user', '$date', $fileSize, 0);";

	if (mysql_query($sql,$con))
	{
		$sql = "SELECT * FROM files WHERE file='$fileName' AND size=$fileSize AND uploaded_date='$date' LIMIT 1";
		$result = mysql_query($sql,$con);
		$row = mysql_fetch_array($result);
		$fileRow = $row['rowID'];
		header("Location: index.php?page=search&uploadSucces=true&id=$fileRow");
		die();
	} 
	else echo mysql_error();
} 
else
{
	switch($_FILES['uploadedfile']['error'])
	{
		case 0: //no error; possible file attack!
			header('Location: index.php?page=upload&uploadError=0');
			die();
			break;
		case 1: //uploaded file exceeds the upload_max_filesize directive in php.ini
			header('Location: index.php?page=upload&uploadError=1');
			die();
			break;
		case 2: //uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the html form
			header('Location: index.php?page=upload&uploadError=2');
			die();
			break;
		case 3: //uploaded file was only partially uploaded
			header('Location: index.php?page=upload&uploadError=3');
			die();
			break;
		case 4: //no file was uploaded
			header('Location: index.php?page=upload&uploadError=4');
			die();
			break;
		default: //a default error, just in case! 
			header('Location: index.php?page=upload&uploadError=1');
			die();
			break;
	} 
	//die();
}

?>
