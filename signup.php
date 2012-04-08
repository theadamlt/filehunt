<h1 style="text-align:center;">Signup</h1>
<div id="signup">
	<? if (isset($_GET['capchaError'])) echo '<div id="error">
	Oups... The capcha was\'t entered correctly. Try again</div>'; ?>
<form class="form" onsubmit="return validateSignupOnsubmit()" name="signup">
	<table>
		<tr>
			<td>
				<input type="text" name="username" placeholder="Username" id="username" />
			</td>
			<td id="username_label">
				<label for="name">Username*</label>
			</td>
		</tr>
		<tr>
			<td>
				<input type="email" name="email" placeholder="Email" id="email" />
			</td>
			<td id="email_label">
				<label for="email">Email*</label>
			</td>
		</tr>
		<tr>
			<td>
				<input type="password" name="password" placeholder="Password" id="password" />
			</td>
			<td id="password_label">
				<label for="password">Password*</label>
			</td>
		</tr>
		<tr>
			<td>
				<input type="password" name="password2" placeholder="Password again" id="password2" />
			</td>
			<td id="password_label2">
				<label for="password2">Password Again*</label>
			</td>
		</tr>
		<tr>
			<td>
				<?php
	require_once('recaptchalib.php');
	if($_SERVER['HTTP_HOST']=='localhost') $publickey = "6LewEM4SAAAAAEzOcFxG0mJ1g1FE-SGb9KtQZAeN";
    elseif($_SERVER['HTTP_HOST']=='filehunt.pagodabox.com') $publickey = $_SERVER['CAPTCHA_PUBLIC'];
    echo '<center>'.recaptcha_get_html($publickey).'</center>';
    ?>
		</td>
	</tr>
	<tr>
		<input type="hidden" name="start" />
		<td class="submit">
			<input type="button" onclick="validateSignupOnsubmit()" value="Signup"/>
		</td>
	</tr>
</table>
</form>
</div>