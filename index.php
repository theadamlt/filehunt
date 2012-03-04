<html>
<head>
	<title>Filehunt beta 0.5 <?echo $_SERVER['HTTP_HOST'];?></title>
<link rel="icon" type="image/png" href="img/favicon.png" />
<link rel="stylesheet" type="text/css" href="css/style.css" />
<script language="javascript" type="text/javascript" src="js/main.js"></script>
</head>
<body>
<?php
require_once('lib.php');
session_start();
	if(!isset($_GET['page'])) header('Location: ?page=search');
		if ((!isset($_SESSION['dbusername']))&&(!isset($_SESSION['dbpassword'])))
		{
			echo '<div id="links"><ul>';
			if($_GET['page'] == 'signup') echo '<li class=current_page_item>';
			else echo '<li>';
			echo '<a href="?page=signup">Signup</a></li>';
			if($_GET['page'] == 'login') echo '<li class=current_page_item>';
			else echo'<li>';
			echo '<a href="?page=login">Login</a></li>';
			if($_GET['page'] == 'search') echo '<li class=current_page_item>';
			else echo '<li>';
			echo '<a href="?page=search">Home</a></li></ul></div>';
		}
		else
		{
			echo '<div id="links"><ul>
			<li><span class="loggedin">Logged in as: '.$_SESSION["dbusername"].' </span> </li><li><a href="?page=logout">Logout</a></li>';
			if($_GET['page'] == 'myprofile') echo'<li class=current_page_item>';
			else echo '<li>';
			echo '<a href="?page=myprofile">My profile</a></li>';
			if($_GET['page'] == 'mysubscriptions') echo '<li class="current_page_item">';
			else echo '<li>';
			echo '<a href="?page=mysubscriptions">My subscriptions</a></li>';
			if($_GET['page'] == 'search') echo '<li class=current_page_item>';
			else echo '<li>';
			echo '<a href="?page=search">Home</a></li>';
			if($_GET['page'] == 'upload') echo '<li class=current_page_item>';
			else echo '<li>';
			echo '<a href="?page=upload">Upload</a></li>';
			//Miniform
			// echo '<li><form action="?page=search" method="post"><span class="minisearch"><input type="text" name="search"></span><input type="hidden" name="select" value="all"><input type="submit" value="Search"></form></li>';
			echo '</ul></div>';
		}

	echo '
	<div id="logo">
	<a href="?page=search"><img src="img/logo.png" /></a>';
	if (isset($_GET['uploadSucces']))
	{
		$host = $_SERVER['HTTP_HOST'];
		$id = $_GET['id'];
		$downloadLink = "download.php?file=$id";
		if($host == 'filehunt.pagodabox.com') $url = $host.'/'. $downloadLink;
		elseif ($host != 'filehunt.netau.net') $url = $host.'/filehunt/'.$downloadLink;
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
<br />
<br />
</body>
</html>