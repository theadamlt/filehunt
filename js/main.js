function deleteOwnFile(arg)
{
	var sure = confirm("Are you sure that you want to delete that file?");
	if(sure == true) window.location.href="?page=delete_file&fileID="+arg;
}
function reportFile(file)
{
	$.get('reference.php',
		{
		func: 'isloggedin',
		},
		function(response)
		{
			if(response != 'false')
			{
				var sure = confirm("Are you sure that you want to report this file as abuse?");
				if(sure == true)
				{
					$.get('reference.php', 
					{
						func: 'report_abuse',
						file: file,
					},
					function(response)
					{
						var div = document.getElementById('success')
						div.innerHTML = 'The file has reported. Thank you';	

					});
				}	
			}
			else
			{
				window.location.href='?page=login&attemptedSite=report_abuse&reportedFile='+file;
			}
		});
}

function adminDeleteFile(arg)
{
	var sure = confirm("Are you sure that you want to delete that file?");
	if(sure == true) window.location.href="?page=delete_file_admin&fileID="+arg;
}

function deleteReport(file)
{
	var sure = confirm("Are you sure that you want to delete the report?");
	if(sure == true) window.location.href="?page=delete_report&file="+file;
}

function calChars(field)
{
	var element = document.getElementById('count');
	var left = 255-field.value.length;
	element.innerHTML = left+' characters left';
}

function plusCount(field)
{
	if(event.keyCode == '8' || event.keyCode == '46')
	{
		var element = document.getElementById('count');
		var left = field.value.length;
		var result = 255-left+1;
		element.innerHTML = result+' characters left';
	}
}

function copyToClipboard(text) {
  window.prompt("Copy to clipboard: Ctrl+C, Enter", text);
}

function validate_login()
{
	document.login.password.value = MD5(document.login.password.value);
	return true;
}

function validateFacebook()
{
	url = 'https://graph.facebook.com/'+document.user_pref.facebook_id.value;
	$.ajax({
	url: url,
	dataType: "json",
	success: function(data){
		if(document.getElementById('facebook_error'))
		{
			$('#facebook_error').remove();
		}
		if(!document.getElementById('facebook_success'))
		{
			fb_message = document.createElement('img');
			fb_message.setAttribute('id', 'facebook_success');
			fb_message.setAttribute('src', './img/success.png');
			fb_message.setAttribute('height', '16');
			fb_message.setAttribute('width', '16');
			fb_message.setAttribute('title', 'The entered ID is valid. Username: '+data['name']);
			$('#facebook_label').prepend(fb_message);
		}
	},
	error: function(data){
		if(document.getElementById('facebook_success'))
		{
			$('#facebook_success').remove();
		}
		if(!document.getElementById('facebook_error'))
		{
			fb_message = document.createElement('img');
			fb_message.setAttribute('id', 'facebook_error');
			fb_message.setAttribute('src', './img/error.png');
			fb_message.setAttribute('height', '16');
			fb_message.setAttribute('width', '16');
			fb_message.setAttribute('title', 'The entered ID is invalid');
			$('#facebook_label').prepend(fb_message);
		}
	}
	});
}

function validateTwitter()
{
	url = 'https://api.twitter.com/1/users/show.json';
	$.ajax({

	url : "http://api.twitter.com/1/users/show.json?screen_name="+document.user_pref.twitter_id.value,
	dataType : "jsonp",
	success : function(data)
	{
		//console.log(data);
		if(document.getElementById('twitter_error'))
		{
			$('#twitter_error').remove();
		}
		if(!document.getElementById('twitter_success'))
		{
			twitter_message = document.createElement('img');
			twitter_message.setAttribute('id', 'twitter_success');
			twitter_message.setAttribute('src', './img/success.png');
			twitter_message.setAttribute('height', '16');
			twitter_message.setAttribute('width', '16');
			twitter_message.setAttribute('title', 'The entered ID is valid. Username: '+data['screen_name']);
			$('#twitter_label').prepend(twitter_message);
		}
	},
	error : function()
	{
		if(document.getElementById('twitter_success'))
		{
			$('#twitter_success').remove();
		}
		if(!document.getElementById('twitter_error'))
		{
			twitter_message = document.createElement('img');
			twitter_message.setAttribute('id', 'twitter_error');
			twitter_message.setAttribute('src', './img/error.png');
			twitter_message.setAttribute('height', '16');
			twitter_message.setAttribute('width', '16');
			twitter_message.setAttribute('title', 'The entered ID is invalid');
			$('#twitter_label').prepend(twitter_message);
		}
	},

});
}
function validateUserPref()
{
	if(document.getElementById('real_name_error') || document.getElementById('email_error'))
	{
		return false;
	}
	else return true;
}

function validateRealName()
{
	if(document.user_pref.real_name.value == '')
	{
		if(document.getElementById('real_name_success'))
		{
			$('#real_name_success').remove();
		}
		if(!document.getElementById('real_name_error'))
		{
			errorMessage = document.createElement('img');
			errorMessage.setAttribute('id', 'real_name_error');
			errorMessage.setAttribute('height', '16');
			errorMessage.setAttribute('width', '16');
			errorMessage.setAttribute('src', './img/error.png');
			errorMessage.setAttribute('title', 'The entered name is not valid');
			$('#real_name_label').prepend(errorMessage);
			user_pref_array['real_name'] = 'false';
		}	
	}
	else
	{
		if(document.getElementById('real_name_error'))
		{
			$('#real_name_error').remove();
		}
		if(!document.getElementById('real_name_success'))
		{
			successMessage = document.createElement('img');
			successMessage.setAttribute('id', 'real_name_success');
			successMessage.setAttribute('height', '16');
			successMessage.setAttribute('width', '16');
			successMessage.setAttribute('src', './img/success.png');
			successMessage.setAttribute('title', 'The entered name is valid!');
			$('#real_name_label').prepend(successMessage);
			user_pref_array['real_name'] = 'true';
		}
	}
}

function validateEmail2()
{
	if(document.user_pref.email.value != '')
	{
		$.get("validate.php?func=om&m="+document.user_pref.email.value+'&u='+document.user_pref.userid.value, function(response) { 
		if(response == 'false')
		{

			if(document.getElementById('email_success'))
			{
				$('#email_success').remove();
			}
			if(!document.getElementById('email_error'))
			{
				errorMessage = document.createElement('img');
				errorMessage.setAttribute('id', 'email_error');
				errorMessage.setAttribute('height', '16');
				errorMessage.setAttribute('width', '16');
				errorMessage.setAttribute('src', './img/error.png');
				errorMessage.setAttribute('title', 'The entered email is either not available or invalid');
				$('#email_label').prepend(errorMessage);
				user_pref_array['email'] = 'false';
			}
		}
		else
		{
			if(document.getElementById('email_error'))
			{
				$('#email_error').remove();
			}
			if(!document.getElementById('email_success'))
			{
				successMessage = document.createElement('img');
				successMessage.setAttribute('id', 'email_success');
				successMessage.setAttribute('height', '16');
				successMessage.setAttribute('width', '16');
				successMessage.setAttribute('src', './img/success.png');
				successMessage.setAttribute('title', 'The entered email is available and valid!');
				$('#email_label').prepend(successMessage);
				user_pref_array['email'] = 'true';
			}
		}

		});
	}
	else
	{
		if(document.getElementById('email_success'))
		{
			$('#email_success').remove();
		}
		if(!document.getElementById('email_error'))
		{
			errorMessage = document.createElement('img');
			errorMessage.setAttribute('id', 'email_error');
			errorMessage.setAttribute('height', '16');
			errorMessage.setAttribute('width', '16');
			errorMessage.setAttribute('src', './img/error.png');
			errorMessage.setAttribute('title', 'The entered email is either not available or invalid');
			$('#email_label').prepend(errorMessage);
			user_pref_array['email'] = 'false';
		}
	}
}



var newpasswordArray = new Array();
newpasswordArray['password1'] = 'false';
newpasswordArray['password2'] = 'false';
newpasswordArray['curpassword'] = 'false';
function validate_new_password()
{

	if(newpasswordArray['curpassword'] == 'true' && newpasswordArray['password1'] == 'true' && newpasswordArray['password2'] == 'true')
	{
		document.newpassword.password.value    = MD5(document.newpassword.password.value);
		document.newpassword.password2.value   = MD5(document.newpassword.password2.value);
		document.newpassword.curpassword.value = MD5(document.newpassword.curpassword.value);
		return true;
	}
	else
	{
		if(!document.getElementById('errormessage'))
		{
			el = document.createElement('td');
			el.setAttribute('id', 'errormessage');
			el.innerHTML = 'Somethings not right. Check the errors above';
			$('#errormes').prepend(el);
		}
		if(newpasswordArray['curpassword'] == 'false' && !document.getElementById('curpassword_error'))
		{
			errorImg = document.createElement('img');
			errorImg.setAttribute('src', './img/error.png')
			errorImg.setAttribute('height', '16');
			errorImg.setAttribute('width', '16');
			errorImg.setAttribute('id', 'curpassword_error');
			errorImg.setAttribute('title', 'The entered password is not right');
			$('#current_password_label').prepend(errorImg);
		}
		if(newpasswordArray['password1'] == 'false' && !document.getElementById('newpassword_error'))
		{
			errorMessage = document.createElement('img');
			errorMessage.setAttribute('id', 'newpassword_error');
			errorMessage.setAttribute('height', '16');
			errorMessage.setAttribute('width', '16');
			errorMessage.setAttribute('src', './img/error.png');
			errorMessage.setAttribute('title', 'The entered password is invalid. Must be over 5 characters');
			$('#newpassword_label').prepend(errorMessage);
		}
		if(newpasswordArray['password2'] == 'false' && !document.getElementById('newpassword2_error'))
		{
			errorMessage = document.createElement('img');
			errorMessage.setAttribute('id', 'newpassword2_error');
			errorMessage.setAttribute('height', '16');
			errorMessage.setAttribute('width', '16');
			errorMessage.setAttribute('src', './img/error.png');
			errorMessage.setAttribute('title', 'The entered passwords doesn\'t match');
			$('#newpassword2_label').prepend(errorMessage);
		}
		return false;
	}
}

function validateNewPassword1()
{
	if(document.newpassword.password.value.length > 5)
	{
			if(document.getElementById('newpassword_error'))
			{
				$('#newpassword_error').remove();
			}
			if(!document.getElementById('newpassword_success'))
			{
				successMessage = document.createElement('img');
				successMessage.setAttribute('id', 'newpassword_success');
				successMessage.setAttribute('height', '16');
				successMessage.setAttribute('width', '16');
				successMessage.setAttribute('src', './img/success.png');
				successMessage.setAttribute('title', 'The entered password is valid!');
				$('#password2').removeAttr('readonly');
				$('#newpassword_label').prepend(successMessage);
				newpasswordArray['password1'] = 'true';
			}

	}
	else
	{
		if(document.getElementById('newpassword_success'))
		{
			$('#newpassword_success').remove();
		}
		if(!document.getElementById('newpassword_error'))
		{
			errorMessage = document.createElement('img');
			errorMessage.setAttribute('id', 'newpassword_error');
			errorMessage.setAttribute('height', '16');
			errorMessage.setAttribute('width', '16');
			errorMessage.setAttribute('src', './img/error.png');
			errorMessage.setAttribute('title', 'The entered password is invalid. Must be over 5 characters');
			$('#newpassword_label').prepend(errorMessage);
			$('#password2').attr('readonly', 'readonly');
			newpasswordArray['password1'] = 'false';
		}
	}
}

function validateCurrentPassword()
{
	$.get("validate.php?func=p&u="+document.user_pref.userid.value+'&p='+MD5(document.newpassword.curpassword.value), function(response) { 
		if(response == 'false')
		{
			if(!document.getElementById('curpassword_error'))
			{
				if(document.getElementById('curpassword_success'))
				{
					$('#curpassword_success').remove();
				}
				if(!document.getElementById('curpassword_error'))
				{
					errorImg = document.createElement('img');
					errorImg.setAttribute('src', './img/error.png')
					errorImg.setAttribute('height', '16');
					errorImg.setAttribute('width', '16');
					errorImg.setAttribute('id', 'curpassword_error');
					errorImg.setAttribute('title', 'The entered password is not right');
					$('#current_password_label').prepend(errorImg);
					newpasswordArray['curpassword'] = 'false';
				}
			}
		}
		else
		{
			if(document.getElementById('curpassword_error'))
			{
				$('#curpassword_error').remove();
			}
			if(!document.getElementById('curpassword_success'))
			{
				successImg = document.createElement('img');
				successImg.setAttribute('src', './img/success.png')
				successImg.setAttribute('height', '16');
				successImg.setAttribute('width', '16');
				successImg.setAttribute('title', 'The entered password right!');
				successImg.setAttribute('id', 'curpassword_success');
				$('#current_password_label').prepend(successImg);
				newpasswordArray['curpassword'] = 'true';
			}
		}
	});
}

function validateNewPassword2()
{
	if(document.newpassword.password.value == document.newpassword.password2.value)
	{
		if(document.getElementById('newpassword2_error'))
		{
			$('#newpassword2_error').remove();
		}
		if(!document.getElementById('newpassword2_success'))
		{
			successMessage = document.createElement('img');
			successMessage.setAttribute('id', 'newpassword2_success');
			successMessage.setAttribute('height', '16');
			successMessage.setAttribute('width', '16');
			successMessage.setAttribute('src', './img/success.png');
			successMessage.setAttribute('title', 'The entered passwords is matching!');
			$('#newpassword2_label').prepend(successMessage);
			newpasswordArray['password2'] = 'true';
		}
	}
	else
	{
		if(document.getElementById('newpassword2_success'))
		{
			$('#newpassword2_success').remove();
		}
		if(!document.getElementById('newpassword2_error'))
		{
			errorMessage = document.createElement('img');
			errorMessage.setAttribute('id', 'newpassword2_error');
			errorMessage.setAttribute('height', '16');
			errorMessage.setAttribute('width', '16');
			errorMessage.setAttribute('src', './img/error.png');
			errorMessage.setAttribute('title', 'The entered passwords doesn\'t match');
			$('#newpassword2_label').prepend(errorMessage);
			newpasswordArray['password2'] = 'false';
		}
	}
}

var reset_passwordArray = new Array();
reset_passwordArray['password'] = 'false';
reset_passwordArray['password2'] = 'false';

function validate_password_reset()
{
	if(reset_passwordArray['password'] == 'true' && reset_passwordArray['password2'] == 'true')
	{ 
		document.reset.password.value = MD5(document.reset.password.value);
		document.reset.password2.value = MD5(document.reset.password2.value);
		return true;
	}
	else
	{
		return false;
	}
}


function validateResetPassword1()
{
	if(document.reset.password.value.length > 5)
	{
		if(document.getElementById('password_error'))
		{
			$('#password_error').remove();
		}
		if(!document.getElementById('password_success'))
		{
			successMessage = document.createElement('img');
			successMessage.setAttribute('id', 'password_success');
			successMessage.setAttribute('height', '16');
			successMessage.setAttribute('width', '16');
			successMessage.setAttribute('src', './img/success.png');
			successMessage.setAttribute('title', 'The entered password is valid!');
			$('#password2').removeAttr('readonly');
			$('#password_label').prepend(successMessage);
			reset_passwordArray['password'] = 'true';
		}
	}
	else
	{
		if(document.getElementById('password_success'))
		{
			$('#password_success').remove();
		}

		if(!document.getElementById('password_error'))
		{
			errorMessage = document.createElement('img');
			errorMessage.setAttribute('id', 'password_error');
			errorMessage.setAttribute('height', '16');
			errorMessage.setAttribute('width', '16');
			errorMessage.setAttribute('src', './img/error.png');
			errorMessage.setAttribute('title', 'The entered password is invalid. Must be over 5 characters');
			$('#password_label').prepend(errorMessage);
			$('#password2').attr('readonly', 'readonly');
			reset_passwordArray['password'] = 'false';
		}
	}
}

function validateResetPassword2()
{
	if(document.reset.password.value == document.reset.password2.value)
	{
		if(document.getElementById('password2_error'))
		{
			$('#password2_error').remove();
		}
		if(!document.getElementById('password2_success'))
		{
			successMessage = document.createElement('img');
			successMessage.setAttribute('id', 'password2_success');
			successMessage.setAttribute('height', '16');
			successMessage.setAttribute('width', '16');
			successMessage.setAttribute('src', './img/success.png');
			successMessage.setAttribute('title', 'The entered passwords is matching!');
			$('#password2_label').prepend(successMessage);
			reset_passwordArray['password2'] = 'true';
		}
	}
	else
	{
		if(document.getElementById('password2_success'))
		{
			$('#password2_success').remove();
		}
		if(!document.getElementById('password2_error'))
		{
			errorMessage = document.createElement('img');
			errorMessage.setAttribute('id', 'password2_error');
			errorMessage.setAttribute('height', '16');
			errorMessage.setAttribute('width', '16');
			errorMessage.setAttribute('src', './img/error.png');
			errorMessage.setAttribute('title', 'The entered passwords doesn\'t match');
			$('#password2_label').prepend(errorMessage);
			reset_passwordArray['password2'] = 'false';
		}
	}
}

function validateUsername(username)
{
	var reg = /^[A-Za-z0-9 ]{3,20}$/;
	return reg.test(username);
}

function validateEmail(email)
{
	var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	return reg.test(email);
}

function validatePassword(password)
{
	if(password.length > 5) return true;
	else return false;
}

function validatePasswordMatch(password1, password2)
{
	if(password1 == password2) return true;
	else return false;
}

function validateSignupOnsubmit()
{
	//Send request
	$.get("validate.php", {
		func:'signup_all',
		recaptcha_challenge_field:document.getElementById('recaptcha_challenge_field').value,
		recaptcha_response_field:document.getElementById('recaptcha_response_field').value,
		u: document.signup.username.value,
		e: document.signup.email.value
		}, function(response) {
		//If server responds no
		var password = document.signup.password.value;
		var password2 = document.signup.password2.value;
		var username = document.signup.username.value;
		var email = document.signup.email.value;	
		if(response == 'true')
		{
			
			if(validatePassword(password))
			{
				passwordlength_success = true;
			}
			else
			{
				if(!document.getElementById('password_error'))
				{
					errorMessage = document.createElement('img');
					errorMessage.setAttribute('id', 'password_error');
					errorMessage.setAttribute('height', '16');
					errorMessage.setAttribute('width', '16');
					errorMessage.setAttribute('src', './img/error.png');
					errorMessage.setAttribute('title', 'The entered password invalid, must be over 5 charachers');
					$('#password_label').prepend(errorMessage);
				}
				passwordlength_success = false;
			}

			if(validatePasswordMatch(password, password2) && passwordlength_success == true)
			{
				passwordmatch_success = true;
			}
			else
			{
				if(!document.getElementById('password2_error'))
				{
					errorMessage = document.createElement('img');
					errorMessage.setAttribute('id', 'password2_error');
					errorMessage.setAttribute('height', '16');
					errorMessage.setAttribute('width', '16');
					errorMessage.setAttribute('src', './img/error.png');
					errorMessage.setAttribute('title', 'The entered passwords does not match');
					$('#password_label2').prepend(errorMessage);
				}
				passwordmatch_success = false;
			}
			if(!validateEmail(email))
			{
				if(!document.getElementById('email_error'))
				{
					errorMessage = document.createElement('img');
					errorMessage.setAttribute('id', 'email_error');
					errorMessage.setAttribute('height', '16');
					errorMessage.setAttribute('width', '16');
					errorMessage.setAttribute('src', './img/error.png');
					errorMessage.setAttribute('title', 'The entered email is either not available or invalid');
					$('#email_label').prepend(errorMessage);
				}
				email_success = false;
			}
			else email_success = true;

			if(!validateUsername(username))
			{
				errorImg = document.createElement('img');
				errorImg.setAttribute('src', './img/error.png')
				errorImg.setAttribute('height', '16');
				errorImg.setAttribute('width', '16');
				errorImg.setAttribute('id', 'username_error');
				errorImg.setAttribute('title', 'The entered username is either not available or invalid');
				$('#username_label').prepend(errorImg);
				username_success = false
			}				
			else username_success = true;

			if(email_success == true && username_success == true && passwordlength_success == true && passwordmatch_success == true)
			{
				$.post('reference.php', {
					func: 'signup',
					username: username,
					email: email,
					password: MD5(password),
					recaptcha_challenge_field: document.signup.recaptcha_challenge_field.value,
					recaptcha_response_field: document.signup.recaptcha_response_field.value,
				}, function(response)
					{
						if(response == 'capcha_error')
						{
							window.location="?page=signup&capchaError=true";
						}
						else if(response == 'true')
						{
							//TODO fix redirect på success
							window.location="?page=search&signupCompleted=true";
						}
					});
			}
			else
			{
				//return false;
			}
		}
		else
		{
			//return

			var errors = $.parseJSON(response);
			if(errors['username_available'] == 'false')
			{
				if(!document.getElementById('username_error'))
				{
					errorImg = document.createElement('img');
					errorImg.setAttribute('src', './img/error.png')
					errorImg.setAttribute('height', '16');
					errorImg.setAttribute('width', '16');
					errorImg.setAttribute('id', 'username_error');
					errorImg.setAttribute('title', 'The entered username is either not available or invalid');
					$('#username_label').prepend(errorImg);
				}
			}
			else
			{
				if(!validateUsername(username))
				{
					errorImg = document.createElement('img');
					errorImg.setAttribute('src', './img/error.png')
					errorImg.setAttribute('height', '16');
					errorImg.setAttribute('width', '16');
					errorImg.setAttribute('id', 'username_error');
					errorImg.setAttribute('title', 'The entered username is either not available or invalid');
					$('#username_label').prepend(errorImg);
				}
			}
			
			if(errors['email_available'] == 'false')
			{
				if(!document.getElementById('email_error'))
				{
					errorMessage = document.createElement('img');
					errorMessage.setAttribute('id', 'email_error');
					errorMessage.setAttribute('height', '16');
					errorMessage.setAttribute('width', '16');
					errorMessage.setAttribute('src', './img/error.png');
					errorMessage.setAttribute('title', 'The entered email is either not available or invalid');
					$('#email_label').prepend(errorMessage);
				}
			}
			else
			{
				if(!validateEmail(email))
				{
					if(!document.getElementById('email_error'))
					{
						errorMessage = document.createElement('img');
						errorMessage.setAttribute('id', 'email_error');
						errorMessage.setAttribute('height', '16');
						errorMessage.setAttribute('width', '16');
						errorMessage.setAttribute('src', './img/error.png');
						errorMessage.setAttribute('title', 'The entered email is either not available or invalid');
						$('#email_label').prepend(errorMessage);
					}
				}
			}
			if(!validatePassword(password))
			{
				if(!document.getElementById('password_error'))
				{
					errorMessage = document.createElement('img');
					errorMessage.setAttribute('id', 'password_error');
					errorMessage.setAttribute('height', '16');
					errorMessage.setAttribute('width', '16');
					errorMessage.setAttribute('src', './img/error.png');
					errorMessage.setAttribute('title', 'The entered password invalid, must be over 5 charachers');
					$('#password_label').prepend(errorMessage);
				}
				password_length = false;
			}
			else password_length = true;

			if(!validatePasswordMatch(password, password2) && password_length == false)
			{
				if(!document.getElementById('password2_error'))
				{
					errorMessage = document.createElement('img');
					errorMessage.setAttribute('id', 'password2_error');
					errorMessage.setAttribute('height', '16');
					errorMessage.setAttribute('width', '16');
					errorMessage.setAttribute('src', './img/error.png');
					errorMessage.setAttribute('title', 'The entered passwords does not match');
					$('#password_label2').prepend(errorMessage);
				}
			}
		}

		});
}

function myprofile()
{
	$.post('reference.php', 
		{
			func: 'myprofile',
		}, function(data)
		{

			var json = $.parseJSON(data);
			if(json.length > 0)
			{
				var container = document.getElementById('center');
				var table = document.createElement('table')
				table.setAttribute('id', 'table');
				var theader = document.createElement('tr');
				var theadertxt1 = document.createElement('th');
				theadertxt1.innerHTML = 'Filename';
				var theadertxt2 = document.createElement('th');
				theadertxt2.innerHTML = 'Delete file';
				theader.appendChild(theadertxt1);
				theader.appendChild(theadertxt2);
				table.appendChild(theader);
				container.appendChild(table);

				for(var i=0; i<json.length; i++)
				{
					var rowID = json[i]['rowID'];
					var fileName = json[i]['file'];
					var row = document.createElement('tr');
					if(isEven(i)) row.setAttribute('class', 'alt');
					var td1 = document.createElement('td');

					var td1Link = document.createElement('a');
					td1Link.setAttribute('href', '?page=fileinfo&fileID='+rowID);
					td1Link.innerHTML = fileName;
					td1.appendChild(td1Link);

					var td2 = document.createElement('td');
					td2Link = document.createElement('a');
					td2Link.setAttribute('title', 'Delete file');
					td2Link.setAttribute('onclick', 'deleteOwnFile('+rowID+',myprofile)');
					td2Link.setAttribute('href', '#');
					td2Img = document.createElement('img');
					td2Img.setAttribute('src', './img/trash.png');
					td2Img.setAttribute('height', '32');
					td2Img.setAttribute('width', '32');
					td2Link.appendChild(td2Img);
					td2.appendChild(td2Link);
					row.appendChild(td1);
					row.appendChild(td2);
					$('#table').append(row);
				}
			}
			else
			{
				errorMessage = document.createElement('div');
				errorMessage.setAttribute('id', 'error');
				errorMessage.innerHTML = 'You have no uploads!';
				$('#center').append(errorMessage);
			}

		});
}

function mySubscriptions()
{
	$.get('reference.php',
		{
			func: 'mysubscriptions',
			action: 'mysubscriptions',
		}, function(data)
		{
			var json = $.parseJSON(data);
			if(json.length > 0)
			{
				var mysubs = document.createElement('details');
				var summary = document.createElement('summary');
				summary.innerHTML = 'My subscribtions('+json.length+')';
				mysubs.appendChild(summary);
				for(var i=0; i<json.length; i++)
				{
					var link = document.createElement('a');
					link.setAttribute('href', '?page=profile&userID='+json[i]['u_rowID']);
					link.innerHTML = json[i]['u_username'];
					mysubs.appendChild(link);
					var linebreak = document.createElement('br');
					mysubs.appendChild(linebreak);

				}
				$('#mysubs').prepend(mysubs);
			}
			else
			{
				var errorDiv = document.createElement('div');
				errorDiv.setAttribute('id', 'error');
				errorDiv.innerHTML = 'You have no subscriptions';
				$('#mysubs').prepend(errorDiv);
			}

		});
}

function mySubscribers()
{
	$.get('reference.php',
		{
			func: 'mysubscriptions',
			action: 'mysubscribers',
		}, function(data)
		{
			var json = $.parseJSON(data);
			if(json.length > 0)
			{
				var mysubs = document.createElement('details');
				var summary = document.createElement('summary');
				summary.innerHTML = 'My subscribers('+json.length+')';
				mysubs.appendChild(summary);
				for(var i=0; i<json.length; i++)
				{
					var link = document.createElement('a');
					link.setAttribute('href', '?page=profile&userID='+json[i]['u_rowID']);
					link.innerHTML = json[i]['u_username'];
					mysubs.appendChild(link);
					var linebreak = document.createElement('br');
					mysubs.appendChild(linebreak);

				}
				$('#mysubs').append(mysubs);
			}
			else
			{
				var errorDiv = document.createElement('div');
				errorDiv.setAttribute('id', 'error');
				errorDiv.innerHTML = 'You have no subscriptions';
				$('#mysubs').append(errorDiv);
			}
			
		});
}


function myNewFiles()
{
	$('#center').empty();
	$.get('reference.php',
		{
			func: 'mysubscriptions',
			action: 'files',
		}, function(data)
		{
			var json = $.parseJSON(data);
			if(json.length > 0)
			{

				var container = document.getElementById('center');
				var linebreak = document.createElement('br');
				container.appendChild(linebreak);

				var table = document.createElement('table')
				table.setAttribute('id', 'table');

				var theader = document.createElement('tr');

				var theadertxt1 = document.createElement('th');
				theadertxt1.innerHTML = 'Filename';

				var theadertxt2 = document.createElement('th');
				theadertxt2.innerHTML = 'Uploaded by';

				var theadertxt3 = document.createElement('th');
				theadertxt3.innerHTML = 'Uploaded date';

				theader.appendChild(theadertxt1);
				theader.appendChild(theadertxt2);
				theader.appendChild(theadertxt3);

				table.appendChild(theader);
				container.appendChild(table);
				
				for(var i=0; i<json.length; i++)
				{
					var rowID        = json[i]['f_rowID'];
					var fileName     = json[i]['f_file'];
					var uploadedByID = json[i]['f_uploaded_by'];
					var uploadedBy   = json[i]['u_username'];
					var uploadedDate = json[i]['f_uploaded_date'];
					// var uploadedById = json[i]['f_rowID']
					var row = document.createElement('tr');
					if(isEven(i)) row.setAttribute('class', 'alt');

					//filename
					var td1 = document.createElement('td');
					var td1Link = document.createElement('a');
					td1Link.setAttribute('href', '?page=fileinfo&fileID='+rowID);
					td1Link.innerHTML = fileName;
					td1.appendChild(td1Link);
					
					//Uploaded by
					var td2 = document.createElement('td');
					td2Link = document.createElement('a');
					td2Link.setAttribute('href', '?page=profile&userID='+uploadedBy);
					td2Link.innerHTML = uploadedBy;
					td2.appendChild(td2Link);

					//date
					td3 = document.createElement('td');
					td3.innerHTML = timeConverter(uploadedDate);

					row.appendChild(td1);
					row.appendChild(td2);
					row.appendChild(td3);
					table.appendChild(row);

				}
				$('#center').append(table);

				linebreak = document.createElement('br');
				$('#center').append(linebreak);

				var span = document.createElement('span');
				span.setAttribute('class', 'submit');
				var button = document.createElement('input');
				button.setAttribute('type', 'button');
				button.setAttribute('onclick', 'clearSubList()');
				button.setAttribute('value', 'Clear list');
				span.appendChild(button);
				$('#center').append(span);
			}
			else
			{
				var errorDiv = document.createElement('div');
				errorDiv.setAttribute('id', 'error');
				errorDiv.innerHTML = 'You have no unseen files';
				var linebreak = document.createElement('br');
				$('#center').append(linebreak);
				$('#center').append(errorDiv);
			}
			
		});
}

function clearSubList()
{
	$.get('reference.php', 
		{
			func: 'clear_sub_list',
		},
		function(response)
		{
			myNewFiles();
		});
}

function loadComments(fileID)
{
	$('#comments').empty();
	$.get('reference.php', 
	{
		func: 'comments',
		file: fileID,			
	}, 
	function(response)
	{
		var header = document.createElement('h1');
		header.innerHTML = 'Comments';
		$('#comments').append(header);
		if(response == 'false')
		{
			// var isLoggedIn = isLoggedIn();
			if(isLoggedIn() != 'false')
			{
				var errorMessage = document.createElement('div');
				errorMessage.setAttribute('id', 'error');
				errorMessage.innerHTML = 'There is no comments for this file. Why dont you leave one?';
				var linebreak = document.createElement('br');
				$('#comments').append(linebreak);
				$('#comments').append(errorMessage);
			}
		}
		else
		{
			var json = $.parseJSON(response);
			var table = document.createElement('table');
			table.setAttribute('id', 'table');

			var theader = document.createElement('tr');
			var theadertxt1 = document.createElement('th');
			theadertxt1.innerHTML = 'Comment by';

			var theadertxt2 = document.createElement('th');
			theadertxt2.innerHTML = 'Date commented';

			var theadertxt3 = document.createElement('th');
			theadertxt3.innerHTML = 'Comment';
			theader.appendChild(theadertxt1);
			theader.appendChild(theadertxt2);
			theader.appendChild(theadertxt3);
			table.appendChild(theader);

			for(var i=0; i<json.length; i++)
			{
				var rowID         = json[i]['user_row'];
				var commentBy     = json[i]['username'];
				var comment       = json[i]['comment'];
				var dateCommented = json[i]['date_commented'];

				var row = document.createElement('tr');
				if(isEven(i)) row.setAttribute('class', 'alt');

				//Comment by
				var td1 = document.createElement('td');
				var td1Link = document.createElement('a');
				td1Link.setAttribute('href', '?page=profile&userID='+rowID);
				td1Link.innerHTML = commentBy;
				td1.appendChild(td1Link);
					
				//Date commented
				var td2 = document.createElement('td');
				td2.innerHTML = timeConverter(dateCommented);

				//Comment
				td3 = document.createElement('td');
				td3.innerHTML = comment;

				row.appendChild(td1);
				row.appendChild(td2);
				row.appendChild(td3);
				table.appendChild(row);
			}
			$('#comments').append(table);
		}
	});
}


function fileInfo()
{
	qs();	
	var fileID = qsParm['fileID'];
	$.get('reference.php', 
		{
			func: 'fileinfo',
			file: fileID,
			action: 'is_reported',
		}, function(response)
		{
			if(response == 'true')
			{
				var warning = document.createElement('div');
				warning.setAttribute('id', 'error');
				warning.innerHTML = 'Be careful! This file has been reported at abuse! We are on the case. You can still download the file, but: BE CAREFUL!';
				$('#warning').prepend(warning);
			}
		});

	$.get('reference.php', 
	{
		func: 'fileinfo',
		action: 'fileinfo',
		file: fileID,

	},
	function(response)
	{
		if(response == 'false')
		{
			window.location.href = '?page=search';
		}
		else
		{
			var json = $.parseJSON(response);
			var rowID        = json[0]['f_rowID'];
			var uploadedByID = json[0]['f_uploaded_by'];
			var uploadedBy   = json[0]['u_username'];
			var uploadedById = json[0]['u_rowID'];
			var uploadedDate = json[0]['f_uploaded_date'];
			var mimeType     = json[0]['f_mimetype'];
			var size         = json[0]['f_size'];

			var table = document.createElement('table');
			table.setAttribute('id', 'table');

			var header1 = document.createElement('th');
			header1.innerHTML = 'Uploaded by'

			var header2 = document.createElement('th')
			header2.innerHTML = 'Size';

			var header3 = document.createElement('th');
			header3.innerHTML = 'Date uploaded';

			var header4 = document.createElement('th');
			header4.innerHTML = 'Mimetype';

			if(mimeType.substring(0,6) == 'image/')
			{
				var header5 = document.createElement('th');
				header5.innerHTML = 'Dimension';
			}

			var header6 = document.createElement('th');
			header6.innerHTML = 'Times downloaded';

			table.appendChild(header1);
			table.appendChild(header2);
			table.appendChild(header3);
			table.appendChild(header4);
			if(mimeType.substring(0,6) == 'image/') table.appendChild(header5);
			table.appendChild(header6);

			

			// var uploadedById = json[i]['f_rowID']
			var row = document.createElement('tr');
			row.setAttribute('class', 'alt');
					
			//Uploaded by
			var td1 = document.createElement('td');
			td1Link = document.createElement('a');
			td1Link.setAttribute('href', '?page=profile&userID='+uploadedById);
			td1Link.innerHTML = uploadedBy;
			td1.appendChild(td1Link);

			//Size
			var td2 = document.createElement('td');
			td2.innerHTML = calcFileSize(size);

			//Date
			td3 = document.createElement('td');
			td3.innerHTML = timeConverter(uploadedDate);

			//Mimetype
			td4 = document.createElement('td');
			td4.innerHTML = mimeType;

			//If image, get dimentions
			if(mimeType.substring(0,6) == 'image/')
			{
				var td5 = document.createElement('td');
				var img = new Image();
				img.src = './printimage.php?id='+rowID;
				img.onload = function()
				{
					width = this.width;
					height = this.height;
					td5.innerHTML = 'Height: '+height+'Width: '+width;
				}				
			}

			//Times downloaded
			var td6 = document.createElement('td');
			var td6Link = document.createElement('a');
			td6Link.setAttribute('href', '?page=download_analysis&file='+fileID);
			$.get('reference.php', 
				{
					func: 'fileinfo',
					action: 'times_downloaded',
					file: fileID,
				},
				function(response)
				{
					td6Link.innerHTML = response;
				});
			td6.appendChild(td6Link);

			row.appendChild(td1);
			row.appendChild(td2);
			row.appendChild(td3);
			row.appendChild(td4);
			if(mimeType.substring(0,6) == 'image/') row.appendChild(td5);
			row.appendChild(td6);

			table.appendChild(row);
			$('#cont').prepend(table);
			var linebreak = document.createElement('br');
			$('#cont').append(linebreak);
			$('#cont').append(linebreak);
			$('#cont').append(linebreak);
			
		}
		var mimeType = json[0]['f_mimetype'];
		var rowID  	 = json[0]['f_rowID'];
		if(mimeType.substring(0,6) == 'image/')
		{
			var pic = document.createElement('img');
			pic.setAttribute('src', 'printimage.php?id='+rowID);
			pic.style.width = '30%';
			pic.style.height = 'auto';

			var linebreak = document.createElement('br');
			$('#cont').append(linebreak);
			$('#cont').append(pic);

		}

	});
	loadComments(fileID);

	$.get('reference.php',
		{
		func: 'isloggedin',
		},
		function(response)
		{
			if(response != 'false')
			{
				var linebreak = document.createElement('br');
				$('#commentform').append(linebreak);
				var form = document.createElement('form');
				form.setAttribute('class', 'form');
				form.setAttribute('name', 'comment');
				//form.setAttribute('action', '');
				//form.setAttribute('method', 'post');
				//form.setAttribute('onsubmit', 'placeComment()');

				//Message
				var span1 = document.createElement('span');

				textArea1 = document.createElement('textarea');
				textArea1.setAttribute('name', 'comment');
				textArea1.setAttribute('cols', '40');
				textArea1.setAttribute('rows', '6');
				textArea1.setAttribute('Placeholder', 'Comment');
				textArea1.setAttribute('id', 'message');
				span1.appendChild(textArea1);

				//Submit
				var span2 = document.createElement('p')
				span2.setAttribute('class', 'submit');
				var hidden = document.createElement('input');
				hidden.setAttribute('type', 'hidden');
				hidden.setAttribute('name', 'submit');
				hidden.setAttribute('value', 'true');
				var submit = document.createElement('input');
				submit.setAttribute('value', 'Submit');
				submit.setAttribute('type', 'button');
				submit.setAttribute('onclick', 'placeComment()');
				span2.appendChild(submit);

				form.appendChild(hidden);
				form.appendChild(span1);
				form.appendChild(span2);
				$('#commentform').append(form);
			}
			else
			{
				var errorMessage = document.createElement('div');
				errorMessage.setAttribute('id', 'error');
				errorMessage.innerHTML = 'In order to comment, you need to ';
				var errLink = document.createElement('a');
				errLink.setAttribute('href', '?page=login&attemptedSite=fileinfo&file='+fileID);
				errLink.innerHTML = 'login';
				errorMessage.appendChild(errLink);
				$('#commentform').append(errorMessage);
			}
		});
}

function placeComment()
{
	qs()
	var fileID = qsParm['fileID']; 
	if(document.comment.comment.value != '')
	{
		$.get('reference.php',
			{
			func: 'place_comment',
			comment: document.comment.comment.value,
			file: fileID,
			},
			function(response)
			{
				loadComments(fileID);
				document.comment.comment.value = '';
				$('.rmMe').remove();
			});
	}
	else
	{
		var err = document.createElement('div');
		err.setAttribute('id', 'error');
		err.setAttribute('class', 'rmMe');
		err.innerHTML = 'The textfield is not filled out correctly';
		$('#commentform').append(err);
	}
}

function reqLogin()
{
	
	var checked = document.login.remember.checked;
	var username = document.login.username.value;
	var password = document.login.password.value;
	$.post('reference.php',
	{
		func: 'login',
		u: username,
		p: MD5(password),
		remember: checked,
	},
	function(response)
	{
		if(response == 'true')
		{
			if(qs['attemptedSite'] && qs['attemptedSite'] == 'report_abuse' && qs['reportedFile'])
			{
				window.location.href="?page=report_abuse&reportedFile="+qs['reportedFile'];
			}
			else if(qs['attemptedSite'] && qs['fileID'] && qs['attemptedSite'] == 'fileinfo')
			{
				window.location.href="?page=fileinfo&fileID="+qs['fileID'];
			}
			else if(qs['attemptedSite'])
			{
				window.location.href="?page="+qs['attemptedSite'];
			}
			else
			{
				window.location.href="?page=search";
			}
		}
		else
		{
			var errormessage = document.createElement('div');
			errormessage.setAttribute('id', 'error');
			errormessage.innerHTML = 'The username and password does not match';
			$('#login').prepend(errormessage);
		}

	});
	return false;
}