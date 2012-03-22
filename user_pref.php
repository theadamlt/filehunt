<?php
if(!isset($_SESSION['dbuserid']))
{
	header('Location: ?page=login&attemptedSite=user_pref');
	die();
}


// $sql = "SELECT * FROM user_pref WHERE userID = $_SESSION[dbuserid] LIMIT 1";
// $result = mysql_query($sql);
// $row = mysql_fetch_array($result);



if(isset($_POST['curpassword']) && isset($_POST['password']) && isset($_POST['password2']))
{
	$password    = mysql_enteries_fix_string($_POST['password']);
	$password2   = mysql_enteries_fix_string($_POST['password2']);
	$curpassword = mysql_enteries_fix_string($_POST['curpassword']);

	if($password == $password2)
	{
		$sql = "SELECT * FROM users WHERE rowID=$_SESSION[dbuserid]";
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		if($row['password'] == $curpassword)
		{
			$userid = $_SESSION['dbuserid'];
			$sql = "UPDATE users
					SET password='$password'
					WHERE rowID=$userid LIMIT 1";
			if($result =  mysql_query($sql))
			{
				header('Location: ?page=user_pref&passwordChange=true');
				die();
			}
			else
			{
				header('Location: ?page=user_pref&passwordChange=false');
				die();
			}
		}
		else
		{
			header('Location: ?page=user_pref&passwordChange=false');
			die();
		}
	}
	else
	{
		header("Location: ?page=user_pref&passwordChange=false");
		die();
	}
}

if(isset($_POST['real_name']))
{
	if(empty($_POST['real_name']) || empty($_POST['email']))
	{
		header('Location: ?page=user_pref&somethingEmpty=true');
		die();
	}
	if(isset($_POST['show_name'])) $show_name = 1;
	else $show_name = 0;

	if(isset($_POST['show_mail'])) $show_mail = 1;
	else $show_mail = 0;

	$facebook_id = trim($_POST['facebook_id']);
	$twitter_id = trim($_POST['twitter_id']);

	$real_name = trim(ucfirst($_POST['real_name']));
	if(empty($user_pref)) $sql = "INSERT INTO user_pref (rowID, userID, real_name, show_real_name, show_mail, admin, facebook_id, twitter_id)
		VALUES(NULL, $_SESSION[dbuserid], '$real_name', $show_name, $show_mail, 0, '$facebook_id', '$twitter_id')";

	else $sql = "UPDATE user_pref SET real_name = '$real_name', show_real_name = $show_name, show_mail = $show_mail, facebook_id = '$facebook_id', twitter_id = '$twitter_id' WHERE userID = $_SESSION[dbuserid]";
	$result = mysql_query($sql);
	header('Location: ?page=user_pref');
	die();
}


if(isset($_GET['somethingEmpty']))
{
	echo '<div id="error">You left something empty!</div>';
}

?>
<div id="signup">
	<?if(isset($_GET['error'])) echo '<div id="error">Error mes</div>';?>
<form class="form" action="?page=user_pref" method="post" name="user_pref">
	<table>
		<tr>
			<td>
				<input type="text" name="real_name" placeholder="Real name" id="real_name" <?if(isset($user_pref['real_name'])) echo 'value="'.$user_pref['real_name'].'"';?>></td>
			<td>
				<label for="name">Real name</label>
			</td>
		</tr>
		<tr>
			<td>
				<input type="checkbox" name="show_name" <?if(isset($user_pref['show_real_name']) && $user_pref['show_real_name'] == 1) echo 'checked';?>>
			</td>
			<td>
				<label for="show_name">Show real name</label>
			</td>
		</tr>
		<tr>
			<td>
				<input type="email" id="email" name="email" value=<?=$user_info['email']?>></td>
			<td>
				<label for="email">Email</label>
			</td>
		</tr>
		<tr>
			<td>
				<input type="checkbox" id="show_mail" name="show_mail" <?if(isset($user_pref['show_mail']) && $user_pref['show_mail'] == 1) echo 'checked';?>>
				</td>
			<td>
				<label for="show_mail">Show email</label>
			</td>
		</tr>
		<tr>
			<td><input type="text" name="facebook_id" id="facebook_id" <?if(isset($user_pref['facebook_id']) && $user_pref['facebook_id'] != '') echo "value='$user_pref[facebook_id]'";?> ></td>
			<td><label for="facebook_id">Facebook id (optional)</label></td>
		</tr>
		<tr>
			<td><input type="text" name="twitter_id" id="twitter_id" <?if(isset($user_pref['twitter_id']) && $user_pref['twitter_id'] != '') echo "value='$user_pref[twitter_id]'";?>></td>
			<td><label for="twitter_id">Twitter id (optional)</label></td>
		</tr>
		<tr>
			<td class="submit">
				<input type="submit" value="Go"/>
			</td>
		</tr>
	</table>
</form>
<br>
<br></div>
<selection class="progress window">
<details>
	<summary>Change password</summary>


 <form class="form" name="newpassword" action="?page=user_pref" onsubmit="validate_new_password()" method="post"><table><tr><td><input type="password" id="curpassword" name="curpassword"></td><td><label for="curpassword">Curent password</label></td></tr><tr><td><input type="password" name="password" id="password"></td><td><label for="password">New password</label></td></tr><tr><td><input type="password" name="password2" id="password2"></td><td><label for="password2">New Password again</label></td></tr><tr><td class="submit"><input type="submit" value="Submit"></td></tr></table></form></details></selection>


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