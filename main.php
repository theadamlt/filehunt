<?php
require_once('lib.php');
mysql_selector();
session_start();

if(isset($_COOKIE['dbuserid']) && !isset($_SESSION['dbuserid']))
{
	$_SESSION['dbuserid']  = $_COOKIE['dbuserid'];
}

	if(!isset($_GET['page']))
	{
		header('Location: ?page=search');
	}

		if (!isset($_SESSION['dbuserid']))
		{
			// echo '<div id="links"><ul>';

			// if($_GET['page'] == 'signup') echo '<li class=current_page_item>';

			// else echo '<li>';

			// echo '<a href="?page=signup">Signup</a></li>';

			// if($_GET['page'] == 'login') echo '<li class=current_page_item>';

			// else echo'<li>';

			// echo '<a href="?page=login">Login</a></li>';

			// if($_GET['page'] == 'search') echo '<li class=current_page_item>';

			// else echo '<li>';

			// echo '<a href="?page=search">Home</a></li></ul></div>';
		}
		else
		{
			$sql = "SELECT s.subscriber AS s_subscriber,
			       s.subscribed AS s_subscribed, 
			       u.rowID AS u_rowID,
			       me.last_sub_check AS u_last_sub_check,
			       f.uploaded_date AS f_uploaded_date,
			       f.uploaded_by AS f_uploaded_by,
			       f.rowID AS f_rowID
					FROM subs s,
					     users u,
					     users me,
					     files f
					WHERE s.subscriber = $_SESSION[dbuserid]
					    AND me.rowID = $_SESSION[dbuserid]
					    AND s.subscribed = f.uploaded_by
					    AND f.uploaded_by = u.rowID
					    AND me.last_sub_check < f.uploaded_date";
			$result = mysql_query($sql);

			$sql2 = "SELECT *
					FROM users
					WHERE rowID = $_SESSION[dbuserid] LIMIT 1";
			$result2 = mysql_query($sql2);
			$user_info = mysql_fetch_array($result2);


			//user prefs
			$sql3 = "SELECT * FROM user_pref WHERE userID = $_SESSION[dbuserid] LIMIT 1";
			$result3 = mysql_query($sql3);
			if(mysql_num_rows($result3) == 0) $user_pref = array();
			else $user_pref = mysql_fetch_array($result3);

			// if(isset($user_pref['facebook_id']) && $user_pref['facebook_id'] != '') $user_fb = json_decode(file_get_contents('https://graph.facebook.com/'.$user_pref['facebook_id']));
			// else $user_fb = array();

			// if(isset($user_pref['twitter_id']) && $user_pref['twitter_id'] != '') $user_twitter = json_decode(file_get_contents('https://api.twitter.com/1/users/show.json?screen_name='.$user_pref['twitter_id']));
			// else $user_twitter = array();

			// //Debug info

			// print_r($user_pref);
			// print_r($user_info);
			// print_r($user_fb);
			// print_r($user_twitter);
		}

	if($_SERVER['HTTP_HOST'] != 'localhost') echo '
<br /><script type="text/javascript"><!--
google_ad_client = "ca-pub-6531227695181642";
/* Filehunt top logo */
google_ad_slot = "4106923675";
google_ad_width = 728;
google_ad_height = 90;
//-->
</script>
<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>';
echo '<div id="logo"><a href="?page=search"><img src="img/logo.png" height=179 width=207 /></a></div>';

	if(getBrowser() != 'Chrome' && !isset($_COOKIE['rmNotice']))
	{
	 		echo '<div id="error">This site is optimized for Google Chrome. You are using '.getBrowser().'. Please install Google Chrome to get the most out of this site</div><form action="?'.$_SERVER['QUERY_STRING'].'" method="post"><input type="hidden" name="rmNotice" value="true"><input type="submit" value="Remove notice"><input type="hidden" name="loca" value="'.$_SERVER['QUERY_STRING'].'"></form><br />';
	}

	if(isset($_SESSION['dbuserid']) && mysql_num_rows($result3) == 0 && $_GET['page'] != 'user_pref')
	{
			echo '<div id="error">You havent specified your <a href="?page=user_pref">user preferences!</a> Please do it. NOW!</div>';
			array_push($user_pref, 'true');
	}
	if(isset($_POST['rmNotice']))
	{
		setcookie("rmNotice", 'false', time()+604800);
		header('Location: ?'.$_POST['loca']);
	}
	if (isset($_GET['uploadSucces']))
	{
		$host = $_SERVER['HTTP_HOST'];
		$id = $_GET['id'];
		$downloadLink = "?page=fileinfo&fileID=$id";
		if($host != 'localhost') $url = $host.'/'. $downloadLink;
		else $url = $host.'/filehunt/'.$downloadLink;
		echo '<div id="success">Upload succeeded</div>';
		echo "<p>Your file link is: <a href='http://$url'>http://$url</a></p><input type='button' onclick='copyToClipboard(\"http://$url\")' value='Copy to clipboard'><br /><div id='socailshare'>";

		facebookShare($url);
		twitterShare($url);
		googleShare($url);
		echo '</div>';
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
			echo "<div id='error'>Oups... Your password hasen't been changed. Please try again later</div>";
		}
	}
	
	$page = $_GET['page'];

	if(file_exists($page.'.php') && $page != '404' && $page != '403')
	{
		require($page.'.php');
	} 
	else require('errors/404.php');
?>