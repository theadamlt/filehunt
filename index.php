<html>
<head>
	<?
		if($_SERVER['HTTP_HOST'] == 'filehunt.pagodabox.com')
		{
			echo <<< _END
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-29716641-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
_END;
		}		
	?>
	<title>Filehunt beta <?echo $_SERVER['HTTP_HOST'];?></title>
<link rel="icon" type="image/png" href="img/favicon.png" />
<link rel="stylesheet" type="text/css" href="css/style.css" />
<script language="javascript" type="text/javascript" src="js/main.js"></script>
</head>
<body>
<?php
require_once('lib.php');
mysql_selector();
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
			$sql = "SELECT s.rowID AS s_rowID, s.subscriber AS s_subscriber, s.subscribed, u.rowID AS u_rowID, u.username AS u_username, f.file AS f_file, f.uploaded_date AS f_uploaded_date, f.uploaded_by AS f_uploaded_by, f.size AS f_size, f.rowID AS f_rowID FROM subs s, users u, files f WHERE s.subscriber=$_SESSION[dbuserid] AND s.subscribed=u.rowID AND f.uploaded_date > u.last_sub_check AND f.uploaded_by=u.rowID";
			$result = mysql_query($sql);
			echo '<div id="links"><ul>
			<li><span class="loggedin">Logged in as: '.$_SESSION["dbusername"].' </span> </li><li><a href="?page=logout">Logout</a></li>';
			if($_GET['page'] == 'myprofile') echo'<li class=current_page_item>';
			else echo '<li>';
			echo '<a href="?page=myprofile">My profile</a></li>';
			if($_GET['page'] == 'mysubscriptions') echo '<li class="current_page_item" id="sub">';
			else echo '<li id="sub">';
			echo '<a href="?page=mysubscriptions">My subscriptions ('.mysql_num_rows($result).')</a></li>';
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
	if(getBrowser() != 'Chrome' && !isset($_COOKIE['rmNotice']))
		{
	 		echo '<div id="error">This site is optimized for Google Chrome. You are using '.getBrowser().'. Please install Google Chrome to get the most out of this site</div>';
	 		echo '<form action=?page=search method=post><input type="hidden" name="rmNotice" value="true"><input type="submit" value="Remove notice"></form>';
	}
	if(isset($_POST['rmNotice']))
	{
		setcookie("rmNotice", 'false', time()+604800);
		header('Location: '.$_SERVER['PHP_SELF']);
	}
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