<?php
require_once('lib.php');
if(__FILE__ == $_SERVER['SCRIPT_FILENAME'])
{
	header('Location: index.php?page='.substr(end(explode('/', $_SERVER['SCRIPT_FILENAME'])),0,-4).'?'.$_SERVER['QUERY_STRING']);
	die();
}
if (!isset($_SESSION['dbuserid']))
{
	header('Location: ?page=login&attemptedSite=myprofile');
	die();
}
?>
<script type="text/javascript">
	myprofile();
	$(function() {
		$( "#tabs" ).tabs({
			ajaxOptions: {
				error: function( xhr, status, index, anchor ) {
					$( anchor.hash ).html(
						"Couldn't load this tab. We'll try to fix this as soon as possible. " +
						"If this wouldn't be a demo." );
				}
			}
		});
	});
</script>
<div id="tabs">
	<ul><li><a href="#myfiles">My files</a></li>
		<li><a href="#preferences">Preferences</a></li>
		<li><a href="#changepassword">Change password</a></li>
	</ul>

	<div id="myfiles">
	</div>
	<div id="preferences">
		
<div id="signup">
	<div id="error" class="upError"></div>
	<div id="success" class="upSuccess"></div>
	<h1>Preferences</h1>
	<form class="form" onsubmit="return userPref()" name="user_pref">
		<table>
			<tr>
				<td>
					<input type="text" name="real_name" placeholder="Real name" id="real_name" <?php if ( isset( $user_pref['real_name'] ) ) echo 'value="'.$user_pref['real_name'].'"';?>></td>
				<td id="real_name_label">
					<label for="name">Real name</label>
				</td>
			</tr>
			<tr>
				<td>
					<input type="checkbox" name="show_name" <?php if ( isset( $user_pref['show_real_name'] ) && $user_pref['show_real_name'] == 1 ) echo 'checked';?>></td>
				<td>
					<label for="show_name">Show real name</label>
				</td>
			</tr>
			<tr>
				<td>
					<input type="email" id="email" name="email" value=<?php echo $user_info['email']?>></td>
				<td id="email_label">
					<label for="email">Email</label>
				</td>
			</tr>
			<tr>
				<td>
					<input type="checkbox" id="show_mail" name="show_mail" <?php if ( isset( $user_pref['show_mail'] ) && $user_pref['show_mail'] == 1 ) echo 'checked';?>></td>
				<td>
					<label for="show_mail">Show email</label>
				</td>
			</tr>
			<tr>
				<td>
					<input type="text" name="facebook_id" id="facebook_id" <?php if ( isset( $user_pref['facebook_id'] ) && $user_pref['facebook_id'] != '' ) echo "value='$user_pref[facebook_id]'";?>></td>
				<td id="facebook_label">
					<label for="facebook_id">Facebook id (optional)</label>
				</td>
			</tr>
			<tr>
				<td>
					<input type="text" name="twitter_id" id="twitter_id" <?php if ( isset( $user_pref['twitter_id'] ) && $user_pref['twitter_id'] != '' ) echo "value='$user_pref[twitter_id]'";?>></td>
				<td id="twitter_label">
					<label for="twitter_id">Twitter id (optional)</label>
				</td>
			</tr>
			<tr>
				<td class="submit">
					<input type="submit" value="Go"/>
				</td>
			</tr>
		</table>
		<input type="hidden" name="userid" value=<?php echo $_SESSION['dbuserid']?>></form>
	<br>
	<br></div>
	</div>
	<div id="changepassword">
		<div class="npError" id="error"></div>
		<div id="success" class="npSuccess"></div>
		<br>
		<div id="np-wrapper">
		<form class="form" name="newpassword" onsubmit="return newPassword()">
			<table>
				<tr>
					<td>
						<input type="password" id="curpassword" name="curpassword" ></td>
					<td id="current_password_label">
						<label for="curpassword">Curent password</label>
					</td>
				</tr>
				<tr>
					<td>
						<input type="password" name="password" id="password" ></td>
					<td id="newpassword_label">
						<label for="password">New password</label>
					</td>
				</tr>
				<tr>
					<td>
						<input type="password" name="password2" id="password2" ></td>
					<td id="newpassword2_label">
						<label for="password2">New Password again</label>
					</td>
				</tr>
				<tr id="errormes"></tr>
				<tr>
					<td class="submit">
						<input type="submit" value="Submit"></td>
				</tr>
			</table>
		</form>
	</div>
	</div>
</div>

</div><!-- End demo -->
