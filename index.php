<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<?
	if($_SERVER['HTTP_HOST'] == 'filehunt.pagodabox.com')
	{
		echo "
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
";
	}		
	?>
<title>Filehunt beta
	<?= $_SERVER['HTTP_HOST'];?></title>
<link rel="icon" type="image/png" href="img/favicon.png" />
<link rel="stylesheet" type="text/css" href="css/style.min.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script src="js/main.min.js"></script>
<script>
	if (!isDetailsSupported)
	{
		document.documentElement.className += ' no-details';
	}
	</script>
</head>
<body>
<?php
		header('Content-Type: text/html; charset=utf-8');
		require_once('main.php');
	?>
<br />
<br />
</body>
</html>