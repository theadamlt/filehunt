<?php
require_once('lib.php');
if(__FILE__ == $_SERVER['SCRIPT_FILENAME'])
	{
		header('Location: index.php?page=myprofile');
		die();
	}

if ((!isset($_SESSION['dbuserid'])))
{
	header('Location: ?page=login&attemptedSite=myprofile');
	die();
}
else 
{
	$session_userid   = $_SESSION['dbuserid'];
	$sql    = "SELECT *
			FROM users
			WHERE rowID=$session_userid";
	$result = mysql_query($sql,$con);
	$row    = mysql_fetch_array($result);
	$sql_username = $row['username'];
	$sql_email    = $row['email'];
	$sql_password = $row['password'];

	if(isset($_GET['deleteSuccess']) && $_GET['deleteSuccess']=='true') echo '<div id="success">Your file was successfully deleted</div>
';
	elseif(isset($_GET['deleteSuccess'])) echo "
<div id='error'>Your file wasn't deleted. Please try again later</div>
";

	echo '
<selection class="progress window">
	<details>
		<summary>Preferences</summary>
		<br>
		<div id="signup">
			<span class="form">
			<table>
			<tr>
			<td><input type="text" id="username" value="'.$sql_username.'" readonly></td>
			<td><label for="username">Username</label></td>
			</tr>
			<tr>
			<td><input type="text" id="email" value="'.$sql_email.'" readonly></td>
			<td><label for="email">Email</label></td>
			</tr>
			</table>
			</div>
			</span>
			<details>
			<summary class="second">New password</summary>
			<br>
			<form class="form" name="newpassword" action="?page=myprofile" onsubmit="validate_new_password()" method="post">
			<table>
			<tr>
			<td><input type="password" id="curpassword" name="curpassword"></td>			
			<td><label for="curpassword">Curent password</label></td>
			</tr>		
			<tr>
			<td><input type="password" name="password" id="password"></td>
			<td><label for="password">New password</label></td>
			</tr>									
			<tr>
			<td><input type="password" name="password1" id="password2"></td>
			<td><label for="password2">New Password again</label></td>
			</tr>
			<tr>
			<td class="submit"><input type="submit" value="Submit"></td>
			</tr>
			</table>
			</form>
			</details>
	</details>
	</selection>
';

	$sql = "SELECT *
			FROM files
			WHERE uploaded_by=$session_userid";
	$result = mysql_query($sql,$con);
	if(mysql_num_rows($result)!=0)
	{
	$count = 0; 
	echo "
<center>
<h1 class='message'>Your uploaded files</h1>
<table id='table'>
	<th>Filename</th>
	<th>Delete file</th>
	";
		while($row = mysql_fetch_array($result))
		{
			$fileRow  = $row['rowID'];
			$sql2     = "SELECT *
						FROM comments
						WHERE fileID='$fileRow'";
			$result2  = mysql_query($sql2,$con);
			$numrows2 = mysql_num_rows($result2);
			if($numrows2 == 1) $comment_string = 'comment';
			else $comment_string = 'comments'; 
			//File size calc
			if(oddOrEven($count)==1) echo '
	<tr class="alt">
		';
			elseif(oddOrEven($count)==0) echo '
		<tr>
			';
			echo '
			<td>
				<a href=?page=fileinfo&fileID=' . $row['rowID'] . '>' . $row['file'] . '</a>
			</td>
			';
			$rowidfile = $row['rowID'];
			$string1   = 'onClick=areYouSure('.$rowidfile.',"myprofile");';
			echo "
			<td>
				<a title='Delete file' onClick=deleteOwnFile('$rowidfile'); href='#'>
					<img src='img/trash.png' height=32 width=32></a>
			</td>
			";
			echo "
		</tr>
		";
			++$count;
		}
			
			echo $row['uploded_by'];
			echo "
	</table>
</center>
";
	}
	else echo '
<div id="error">You have no uploads!</div>
';
}

if(isset($_POST['curpassword']) && isset($_POST['password']))
{
	$password = mysql_enteries_fix_string($_POST['password']);
	$password2 = mysql_enteries_fix_string($_POST['password']);
	$curpassword = mysql_enteries_fix_string($_POST['curpassword']);
	if($password == $password2)
	{
		$sql = "SELECT * FROM users WHERE rowID=$_SESSION[dbuserid]";
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		if($row['password'] == $curpassword)
		{
			$curpassword = mysql_enteries_fix_string($_POST['curpassword']);
			$userid = $_SESSION['dbuserid'];
			$sql = "UPDATE users
					SET password='$password',
					WHERE rowID='$userid' LIMIT 1";
			$result =  mysql_query($sql);
			header('Location: ?page=myprofile&newPassword=true');
			die();
		}
		else
		{
			header('Location: ?page=myprofile&newPassword=false');
			die();
		}
	}
	else
	{
		header('Location: ?page=myprofile&newPassword=false');
		die();
	}
}

?>
<script src="js/jquery.details.min.js"></script>
<script>
window.console || (window.console = { 'log': alert });
$(function() {
// Add conditional classname based on support
$('html').addClass($.fn.details.support ? 'details' : 'no-details');
// Show a message based on support
//$('body').prepend($.fn.details.support ? 'Native support detected; the plugin will only add ARIA annotations and fire custom open/close events.' : 'Emulation active; you are watching the plugin in action!');

// Emulate <details> where necessary and enable open/close event handlers
$('details').details();

// Bind some example event handlers
$('details').on({
'open.details': function() {
//console.log('opened');
},
'close.details': function() {
//console.log('closed');
}
});
});
</script>