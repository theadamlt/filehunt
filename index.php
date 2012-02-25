<html>
<head>
	<title>Filehunt beta 0.3</title>
<link rel="icon" type="image/png" href="img/favicon.png" />
<link rel="stylesheet" type="text/css" href="style.css" />
<script type="text/javascript">
	function areYouSure(arg,site)
	{
		var sure = confirm("Are you sure that you want to delete that file?");
		if(sure == true) window.location.href="?page=delete_file&fileID="+arg+"&site="+site;
	}
	function areYouSure2(file,site)
	{
		var sure = confirm("Are you sure that you want to report this file as abuse?");
		if(sure == true) window.location.href="?page=report_abuse&reportedFile="+file;
	}
</script>
</head>
<body>
<?php
require_once('lib.php');
session_start();
	if(!isset($_GET['page'])) header('Location: ?page=search');
		if ((!isset($_SESSION['dbusername']))&&(!isset($_SESSION['dbpassword'])))
		{
			echo '<div id="links">
			<a href="?page=signup">Signup</a> | <a href="?page=login">Login</a> | <a href="?page=search">Home</a></div>';
		}
		else
		{
			echo '<div id="links">
			Logged in as: '.$_SESSION["dbusername"].' | <a href="?page=logout">Logout</a> | <a href="?page=myprofile">My profile</a> | <a href="?page=search">Home</a> | <a href="?page=upload">Upload</a> </div>';
		}

	echo '
	<div id="logo">
	<a href="?page=search"><img src="img/logo.png" /></a>';
	if (isset($_GET['uploadSucces']))
	{
		$host = $_SERVER['HTTP_HOST'];
		$id = $_GET['id'];
		$downloadLink = "download.php?file=$id";
		if ($host != 'filehunt.netau.net') $url = $host.'/filehunt/'.$downloadLink;
		else $url = $host.'/'.$downloadLink;
		echo '<div id="success">Upload succeeded</div>';
		echo "<p>Your download link is: <a href='http://$url'>http://$url</a><br />";
		echo '<div id="socailshare">';
		facebookShare($url);
		twitterShare($url);
		googleShare($url);
		echo '</div>';
			 '</div>';
	}
	if(isset($_GET['signupCompleted'])) echo '<div id="success">Signup completed</div>';
	if(isset($_GET['newPassword']))
	{
		if($_GET['newPassword']=='true')
		{
			echo '<div id="success">Your password has been changed. You can now login</div>';
		}
		else
		{
			echo "<div id='success'>Oups... Your password hasen't been changed. Please try again later</div>";
		}
	}
	if(isset($_GET['newPasswordEmailSent']))
	{
		$print_email = $_GET['newPasswordEmailSent'];
		echo "<div id='success'>An email has been sent to you at $print_email</div>";
	}
	if(isset($_GET['captchaErr'])) echo "<div id='error'>The CAPTCHA field was not entered correctly. Please try again</div>";

	$page = $_GET['page'];

	//If no, $page=main
	//if (!$page) $page = "search";
	if (file_exists($page.'.php'))
	{
		require($page.'.php');
	} else require('404.php');





?>

</body>
</html>