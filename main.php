<?php
require_once('lib.php');
mysql_selector();
session_start();

if(
	isset($_COOKIE['dbuserid'])
	&& isset($_COOKIE['dbusername'])
	&& isset($_COOKIE['dbpassword'])
	&& isset($_COOKIE['dbuseremail'])
	&& !isset($_SESSION['dbuserid'])
	&& !isset($_SESSION['dbusername'])
	&& !isset($_SESSION['dbuseremail'])
	&& !isset($_SESSION['dbpassword']))
	{
		$_SESSION['dbuserid']    = $_COOKIE['dbuserid'];
		$_SESSION['dbusername']  = $_COOKIE['dbusername'];
		$_SESSION['dbuseremail'] = $_COOKIE['dbuseremail'];
		$_SESSION['dbpassword']  = $_COOKIE['dbpassword'];
	}

	if(!isset($_GET['page'])) header('Location: ?page=search');

		if ((!isset($_SESSION['dbusername']))&&(!isset($_SESSION['dbpassword'])))
		{
			echo '<div id="links">
<ul>
	';

			if($_GET['page'] == 'signup') echo '
	<li class=current_page_item>
		';

			else echo '
		<li>
			';

			echo '
			<a href="?page=signup">Signup</a>
		</li>
		';

			if($_GET['page'] == 'login') echo '
		<li class=current_page_item>
			';

			else echo'
			<li>
				';

			echo '
				<a href="?page=login">Login</a>
			</li>
			';

			if($_GET['page'] == 'search') echo '
			<li class=current_page_item>
				';

			else echo '
				<li>
					';

			echo '
					<a href="?page=search">Home</a>
				</li>
			</ul>
		</div>
		';
		}
		else
		{
			$sql = "SELECT s.rowID AS s_rowID,
			       s.subscriber AS s_subscriber,
			       s.subscribed AS s_subscribed, 
			       u.rowID AS u_rowID,
			       u.username AS u_username,
			       me.last_sub_check AS u_last_sub_check,
			       f.file AS f_file,
			       f.uploaded_date AS f_uploaded_date,
			       f.uploaded_by AS f_uploaded_by,
			       f.size AS f_size,
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
			echo '
		<div id="links">
			<ul>
				<li>
					<span class="loggedin">Logged in as: '.$_SESSION["dbusername"].'</span>
				</li>
				<li>
					<a href="?page=logout">Logout</a>
				</li>
				';
			if($_GET['page'] == 'myprofile') echo'
				<li class=current_page_item>
					';

			else echo '
					<li>
						';

			echo '
						<a href="?page=myprofile" >My profile</a>
					</li>
					';

			if($_GET['page'] == 'mysubscriptions') echo '
					<li class="current_page_item" id="sub">
						';

			else echo '
						<li id="sub">
							';

			echo '
							<a href="?page=mysubscriptions">My subscriptions ('.mysql_num_rows($result).')</a>
						</li>
						';

			if($_GET['page'] == 'search') echo '
						<li class=current_page_item>
							';

			else echo '
							<li>
								';

			echo '
								<a href="?page=search">Home</a>
							</li>
							';

			if($_GET['page'] == 'upload') echo '
							<li class=current_page_item>
								';

			else echo '
								<li>
									';

			echo '
									<a href="?page=upload">Upload</a>
								</li>
								';
			//Miniform
			/*echo '
								<li>
									//
									<form action="?page=search" method="post">
										//
										<span class="minisearch">
											//
											<input type="text" name="search"></span>
										//
										<input type="hidden" name="select" value="all">
										//
										<input type="submit" value="Search"></form>
									//
								</li>
								//';*/
			echo '
							</ul>
						</div>
						';
		}

	echo '
						<br />
						<script type="text/javascript"><!--
							google_ad_client = "ca-pub-6531227695181642";
							/* Filehunt top logo */
							google_ad_slot = "4106923675";
							google_ad_width = 728;
							google_ad_height = 90;
							//-->
						</script>
						<script type="text/javascript"
							src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
						</script>
						<div id="logo">
							<a href="?page=search">
								<img src="img/logo.png" height=179 width=207 />
							</a>
						</div>
						';
	if(getBrowser() != 'Chrome' && !isset($_COOKIE['rmNotice']))
		{
	 		echo '
						<div id="error">
							This site is optimized for Google Chrome. You are using '.getBrowser().'. Please install Google Chrome to get the most out of this site
						</div>
						';
	 		echo '
						<form action="?'.$_SERVER['QUERY_STRING'].'" method="post">
							<input type="hidden" name="rmNotice" value="true">
							<input type="submit" value="Remove notice">
							<input type="hidden" name="loca" value="'.$_SERVER['QUERY_STRING'].'"></form>
						<br />
						';
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
		if($host == ',filehunt.pagodabox.com') $url = $host.'/'. $downloadLink;
		elseif ($host != 'filehunt.netau.net') $url = $host.'/filehunt/'.$downloadLink;
		else $url = $host.'/'.$downloadLink;
		echo '
						<div id="success">Upload succeeded</div>
						';
		echo "
						<p>
							Your file link is:
							<a href='http://$url'>http://$url</a>
						</p>
						";
		echo "
						<input type='button' onclick='copyToClipboard(\"http://$url\")' value='Copy to clipboard'>
						<br />
						";
		echo '
						<div id="socailshare">
							';
		facebookShare($url);
		twitterShare($url);
		googleShare($url);
		echo '
						</div>
						';
	}
	if(isset($_GET['signupCompleted'])) echo '
						<div id="success">Signup completed</div>
						';
	if(isset($_GET['newPassword']))
	{
		if($_GET['newPassword']=='true')
		{
			echo '
						<div id="success">Your password has been changed. You can now login</div>
						';
		}
		else
		{
			echo "
						<div id='success'>
							Oups... Your password hasen't been changed. Please try again later
						</div>
						";
		}
	}
	if(isset($_GET['newPasswordEmailSent']))
	{
		$print_email = $_GET['newPasswordEmailSent'];
		echo "
						<div id='success'>An email has been sent to you at $print_email</div>
						";
	}
	if(isset($_GET['captchaErr'])) echo "
						<div id='error'>
							The CAPTCHA field was not entered correctly. Please try again
						</div>
						";
	$page = $_GET['page'];

	if (file_exists($page.'.php'))
	{
		if($page != '404' || $page != '403') require($page.'.php');
	} else require('errors/'.$page.'.php');
?>