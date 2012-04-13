<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="google-site-verification" content="2iJhMBF2ixUIrJXnBSedVKJgYP5lqyq03vfCf51qlBY" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<?
	if($_SERVER['HTTP_HOST'] != 'localhost')
	{
		echo "
<script src=\"js/main.min.js\"></script><script src=\"js/lib.min.js\"></script><link rel=\"stylesheet\" type=\"text/css\" href=\"css/style.min.css\" />";
}
else echo '<script src="js/main.js"></script><script type="text/javascript" src="js/lib.js"></script><link rel="stylesheet" type="text/css" href="css/style.css" />';?>
<title>Filehunt beta
	<?= $_SERVER['HTTP_HOST'];?></title>
<link rel="icon" type="image/png" href="img/favicon.png" />

<link rel="stylesheet" type="text/css" href="css/style.min.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>

<script>
if (!isDetailsSupported)
{
	document.documentElement.className += ' no-details';
}
navBar();
</script>
<!--[if lt IE 9]>
<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
</head>
<body>
	<div id="links"></div>
<?php
header('Content-Type: text/html; charset=utf-8');
header('Cache-control: public');
header('Vary: Accept-Encoding');

require_once('main.php');
?>
<script type='text/javascript'>
var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-29716641-1']);
_gaq.push(['_trackPageview']);
(function() {
var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();
</script>


<br />
<br />
<? if($_SERVER['HTTP_HOST'] != 'localhost') echo '
<script type="text/javascript"><!--
google_ad_client = "ca-pub-6531227695181642";
/* Filehunt under logo */
google_ad_slot = "5163483525";
google_ad_width = 728;
google_ad_height = 90;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>';?>
</body>
</html>