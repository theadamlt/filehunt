<html>
<head>
	<title>Filehunt beta 0.3</title>
<link rel="icon" type="image/png" href="img/favicon.png" />
<link rel="stylesheet" type="text/css" href="style.css" />
<script type="text/javascript">
	function areYouSure(arg)
	{
		var sure = confirm("Are you sure that you want to delete that file?");
		if(sure == true) window.location.href="?page=delete_file&fileID="+arg;
	}
	function areYouSure2(arg)
	{
		var sure = confirm("Are you sure that you want to report this file as abuse?");
		if(sure == true) window.location.href="?page=report_abuse&reportedFile="+arg;
	}
</script>
</head>
<body>
<?php

function facebookShare($url)
{
		echo <<<_END
<script>function fbs_click() {u=location.href;t=document.title;window.open('http://www.facebook.com/sharer.php?u='+encodeURIComponent(u)+'&t='+encodeURIComponent(t),'sharer','toolbar=0,status=0,width=626,height=436');return false;}</script><style> html .fb_share_link { padding:2px 0 0 20px; }</style><a title="Share on Facebook" rel="nofollow" href="http://www.facebook.com/share.php?u=$url" onclick="return fbs_click()" target="_blank" class="fb_share_link"><img src="img/facebook.ico" height="32" width="32"></a>&nbsp;&nbsp;&nbsp;&nbsp;
_END;
}
function twitterShare($url)
{
	echo <<< _END
<a href="http://twitter.com/home?status=I just uploaded a file on fileHunt! $url" title="Share on Twitter" target='_blank'><img src="img/twitter.ico" height="32" width="32"></a>&nbsp;&nbsp;&nbsp;&nbsp;
_END;
}
function googleShare($url)
{
	echo <<< _END
	<a title="Share on Google+" href="https://m.google.com/app/plus/x/?v=compose&content=I just uploaded a file on fileHunt! $url" onclick="window.open('https://m.google.com/app/plus/x/?v=compose&content=I just uploaded a file on fileHunt $url','gplusshare','width=450,height=300,left='+(screen.availWidth/2-225)+',top='+(screen.availHeight/2-150)+'');return false;"><img src="img/google+.ico" height="32" width="32"></a>
_END;
}


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
	
		$url = $host.'/'.$downloadLink;
		echo '<div id="success">Upload succeeded</div>';
		echo "<p>Your download link is: <a href='$url'>http://$url</a><br />";
		echo '<div id="socailshare">';
		facebookShare($url);
		twitterShare($url);
		googleShare($url);
		echo '</div>';
			 '</div>';
	}
	if(isset($_GET['signupCompleted'])) echo '<div id="success">Signup completed</div>';
	if(isset($_GET['newPassword'])) echo '<div id="success">Your password has been changed. You can now login</div>';
	if(isset($_GET['newPasswordEmailSent']))
	{
		$print_email = $_GET['newPasswordEmailSent'];
		echo "<div id='success'>An email has been sent to you at $print_email</div>";
	}

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