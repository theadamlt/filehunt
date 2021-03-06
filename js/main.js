var linebreak = document.createElement('br');

function deleteOwnFile(arg) {
	var sure = confirm("Are you sure that you want to delete that file?");
	if (sure == true) {
		$.get('reference.php', {
			f: arg,
			func: 'delete_file',
		}, function(response) {
			$('#center').empty();
			myprofile();
		});

	}
	//window.location.href="?page=delete_file&fileID="+arg;
}

function reportFile(file) {
	$.get('reference.php', {
		func: 'isloggedin',
	}, function(response) {
		if (response != 'false') {
			var sure = confirm("Are you sure that you want to report this file as abuse?");
			if (sure == true) {
				$.get('reference.php', {
					func: 'report_abuse',
					file: file,
				}, function(response) {
					var div = document.getElementById('success')
					$('#success').html('The file has reported. Thank you').hide().fadeIn();

				});
			}
		} else {
			window.location.href = '?page=login&attemptedSite=report_abuse&reportedFile=' + file;
		}
	});
}

function adminDeleteFile(arg) {
	var sure = confirm("Are you sure that you want to delete that file?");
	if (sure == true) window.location.href = "?page=delete_file_admin&fileID=" + arg;
}

function deleteReport(file) {
	var sure = confirm("Are you sure that you want to delete the report?");
	if (sure == true) window.location.href = "?page=delete_report&file=" + file;
}

function calChars(field) {
	var element = document.getElementById('count');
	var left = 255 - field.value.length;
	element.innerHTML = left + ' characters left';
}

function plusCount(field) {
	if (event.keyCode == '8' || event.keyCode == '46') {
		var element = document.getElementById('count');
		var left = field.value.length;
		var result = 255 - left + 1;
		element.innerHTML = result + ' characters left';
	}
}

function copyToClipboard(text) {
	window.prompt("Copy to clipboard: Ctrl+C, Enter", text);
}

function validateFacebook() {
	url = 'https://graph.facebook.com/' + document.user_pref.facebook_id.value;
	$.get(url, function(result) {
		console.log(result);
	});
}


function validateTwitter() {
	$.get('https://api.twitter.com/1/users/show.json', {
		screen_name: 'theadamlt',
		include_entities: 'false',
	}, function(response) {
		console.log(response);
	});
}

function userPref() {
	var realName = document.user_pref.real_name.value;
	var email = document.user_pref.email.value;
	var showRealName = document.user_pref.show_name.checked;
	var showEmail = document.user_pref.show_mail.checked;
	var twitterID = document.user_pref.twitter_id.value;
	var facebookID = document.user_pref.facebook_id.value;

	if (!empty(realName) && validateEmail(email)) {
		$.get('reference.php', {
			func: 'user_pref',
			real_name: realName,
			email: email,
			show_real_name: showRealName,
			show_email: showEmail,
			twitter_id: twitterID,
			facebook_id: facebookID,

		}, function(response) {
			if (response == 'true') {
				$('.upError').fadeOut();
				$('.upSuccess').empty();
				$('.upSuccess').hide().html('Your preferences has successfully been updated').fadeIn();
				$('html,body').animate({
					scrollTop: $(".upSuccess").offset().top
				}, 1000);
			} else {
				$('.upSuccess').fadeOut();
				$('.upError').empty();
				$('.upError').hide().html('Something went wrong. Please try again later').fadeIn();
				$('html,body').animate({
					scrollTop: $(".upError").offset().top
				}, 1000);
			}

		});


	} else {
		$('.upSuccess').fadeOut();
		$('.upError').hide().html('Something\'s not right. The entered name or email is invalid').fadeIn();
		$('html,body').animate({
			scrollTop: $(".upError").offset().top
		}, 1000);
	}
	return false;

}

function newPassword() {
	var password = MD5(document.newpassword.password.value);
	var password2 = MD5(document.newpassword.password2.value);
	var curPassword = MD5(document.newpassword.curpassword.value);

	if (password == password2 && password.length > 5) {
		$.get('reference.php', {
			func: 'new_password',
			p1: password,
			p2: password2,
			cp: curPassword,
		}, function(response) {
			if (response == 'false') {
				$('.npError').hide().html('Something went wrong. Maybe your current password was wrong, or the new passwords didn\'t match?').fadeIn();
				$('html,body').animate({
					scrollTop: $(".npError").offset().top
				}, 1000);
			} else {
				$('.npSuccess').hide().html('Your password has been changed').fadeIn('slow');
				$('html,body').animate({
					scrollTop: $("#success").offset().top
				}, 1000);
				$('.npError').fadeOut();
				$('#np-wrapper').fadeOut('slow');
				document.newpassword.password.value = null;
				document.newpassword.password2.value = null;
				document.newpassword.curpassword.value = null;
			}

		});
	} else {
		$('.npError').hide().html('Something went wrong. Maybe your current password was entered wrong, or the new passwords didn\'t match? The password must be over 5 characters').fadeIn();
	}
	return false;

}



var reset_passwordArray = new Array();
reset_passwordArray['password'] = 'false';
reset_passwordArray['password2'] = 'false';

function validate_password_reset() {
	if (reset_passwordArray['password'] == 'true' && reset_passwordArray['password2'] == 'true') {
		document.reset.password.value = MD5(document.reset.password.value);
		document.reset.password2.value = MD5(document.reset.password2.value);
		return true;
	} else {
		return false;
	}
}


function validateResetPassword1() {
	if (document.reset.password.value.length > 5) {
		if (document.getElementById('password_error')) {
			$('#password_error').remove();
		}
		if (!document.getElementById('password_success')) {
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
	} else {
		if (document.getElementById('password_success')) {
			$('#password_success').remove();
		}

		if (!document.getElementById('password_error')) {
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

function validateResetPassword2() {
	if (document.reset.password.value == document.reset.password2.value) {
		if (document.getElementById('password2_error')) {
			$('#password2_error').remove();
		}
		if (!document.getElementById('password2_success')) {
			successMessage = document.createElement('img');
			successMessage.setAttribute('id', 'password2_success');
			successMessage.setAttribute('height', '16');
			successMessage.setAttribute('width', '16');
			successMessage.setAttribute('src', './img/success.png');
			successMessage.setAttribute('title', 'The entered passwords is matching!');
			$('#password2_label').prepend(successMessage);
			reset_passwordArray['password2'] = 'true';
		}
	} else {
		if (document.getElementById('password2_success')) {
			$('#password2_success').remove();
		}
		if (!document.getElementById('password2_error')) {
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

function validateUsername(username) {
	var reg = /^[A-Za-z0-9 ]{3,20}$/;
	return reg.test(username);
}

function validateEmail(email) {
	var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	return reg.test(email);
}

function validatePassword(password) {
	if (password.length > 5) return true;
	else return false;
}

function validatePasswordMatch(password1, password2) {
	if (password1 == password2) return true;
	else return false;
}

function validateSignupOnsubmit() {
	//Send request
	$.get("validate.php", {
		func: 'signup_all',
		recaptcha_challenge_field: document.getElementById('recaptcha_challenge_field').value,
		recaptcha_response_field: document.getElementById('recaptcha_response_field').value,
		u: document.signup.username.value,
		e: document.signup.email.value
	}, function(response) {
		//If server responds no
		var password = document.signup.password.value;
		var password2 = document.signup.password2.value;
		var username = document.signup.username.value;
		var email = document.signup.email.value;
		if (response == 'true') {

			if (validatePassword(password)) {
				var passwordlength_success = true;
			} else {
				if (!document.getElementById('password_error')) {
					errorMessage = document.createElement('img');
					errorMessage.setAttribute('id', 'password_error');
					errorMessage.setAttribute('height', '16');
					errorMessage.setAttribute('width', '16');
					errorMessage.setAttribute('src', './img/error.png');
					errorMessage.setAttribute('title', 'The entered password invalid, must be over 5 charachers');
					$('#password_label').prepend(errorMessage);
				}
				var passwordlength_success = false;
			}

			if (validatePasswordMatch(password, password2) && passwordlength_success == true) {
				var passwordmatch_success = true;
			} else {
				if (!document.getElementById('password2_error')) {
					errorMessage = document.createElement('img');
					errorMessage.setAttribute('id', 'password2_error');
					errorMessage.setAttribute('height', '16');
					errorMessage.setAttribute('width', '16');
					errorMessage.setAttribute('src', './img/error.png');
					errorMessage.setAttribute('title', 'The entered passwords does not match');
					$('#password_label2').prepend(errorMessage);
				}
				var passwordmatch_success = false;
			}
			if (!validateEmail(email)) {
				if (!document.getElementById('email_error')) {
					errorMessage = document.createElement('img');
					errorMessage.setAttribute('id', 'email_error');
					errorMessage.setAttribute('height', '16');
					errorMessage.setAttribute('width', '16');
					errorMessage.setAttribute('src', './img/error.png');
					errorMessage.setAttribute('title', 'The entered email is either not available or invalid');
					$('#email_label').prepend(errorMessage);
				}
				var email_success = false;
			} else var email_success = true;

			if (!validateUsername(username)) {
				if (!document.getElementById('username_error')) {
					errorImg = document.createElement('img');
					errorImg.setAttribute('src', './img/error.png')
					errorImg.setAttribute('height', '16');
					errorImg.setAttribute('width', '16');
					errorImg.setAttribute('id', 'username_error');
					errorImg.setAttribute('title', 'The entered username is either not available or invalid');
					$('#username_label').prepend(errorImg);
				}
				username_success = false;
			} else username_success = true;

			if (email_success == true && username_success == true && passwordlength_success == true && passwordmatch_success == true) {
				$.get('reference.php', {
					func: 'signup',
					username: username,
					email: email,
					password: MD5(password),
					recaptcha_challenge_field: document.signup.recaptcha_challenge_field.value,
					recaptcha_response_field: document.signup.recaptcha_response_field.value,
				}, function(response) {
					console.log(response);
					if (response == 'capcha_error') {
						window.location = "?page=signup&capchaError=true";
					} else {
						//TODO fix redirect pÃ¥ success
						window.location.href = "?page=search&signupCompleted=true"

					}
				});
			} else {
				//return false;
			}
		} else {
			//return
			var errors = $.parseJSON(response);
			if (errors['username_available'] == 'false') {
				if (!document.getElementById('username_error')) {
					errorImg = document.createElement('img');
					errorImg.setAttribute('src', './img/error.png')
					errorImg.setAttribute('height', '16');
					errorImg.setAttribute('width', '16');
					errorImg.setAttribute('id', 'username_error');
					errorImg.setAttribute('title', 'The entered username is either not available or invalid');
					$('#username_label').prepend(errorImg);
				}
			} else {
				if (!validateUsername(username)) {
					errorImg = document.createElement('img');
					errorImg.setAttribute('src', './img/error.png')
					errorImg.setAttribute('height', '16');
					errorImg.setAttribute('width', '16');
					errorImg.setAttribute('id', 'username_error');
					errorImg.setAttribute('title', 'The entered username is either not available or invalid');
					$('#username_label').prepend(errorImg);
				}
			}

			if (errors['email_available'] == 'false') {
				if (!document.getElementById('email_error')) {
					errorMessage = document.createElement('img');
					errorMessage.setAttribute('id', 'email_error');
					errorMessage.setAttribute('height', '16');
					errorMessage.setAttribute('width', '16');
					errorMessage.setAttribute('src', './img/error.png');
					errorMessage.setAttribute('title', 'The entered email is either not available or invalid');
					$('#email_label').prepend(errorMessage);
				}
			} else {
				if (!validateEmail(email)) {
					if (!document.getElementById('email_error')) {
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
			if (!validatePassword(password)) {
				if (!document.getElementById('password_error')) {
					errorMessage = document.createElement('img');
					errorMessage.setAttribute('id', 'password_error');
					errorMessage.setAttribute('height', '16');
					errorMessage.setAttribute('width', '16');
					errorMessage.setAttribute('src', './img/error.png');
					errorMessage.setAttribute('title', 'The entered password invalid, must be over 5 charachers');
					$('#password_label').prepend(errorMessage);
				}
				password_length = false;
			} else password_length = true;

			if (!validatePasswordMatch(password, password2) && password_length == false) {
				if (!document.getElementById('password2_error')) {
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

function myprofile() {
	$.post('reference.php', {
		func: 'myprofile',
	}, function(data) {

		var json = $.parseJSON(data);
		if (json.length > 0) {
			var container = document.getElementById('myfiles');
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

			for (var i = 0; i < json.length; i++) {
				var rowID = json[i]['rowID'];
				var fileName = json[i]['file'];
				var row = document.createElement('tr');
				if (isEven(i)) row.setAttribute('class', 'alt');
				var td1 = document.createElement('td');

				var td1Link = document.createElement('a');
				td1Link.setAttribute('href', '?page=fileinfo&fileID=' + rowID);
				td1Link.innerHTML = fileName;
				td1.appendChild(td1Link);

				var td2 = document.createElement('td');
				td2Link = document.createElement('a');
				td2Link.setAttribute('title', 'Delete file');
				td2Link.setAttribute('onclick', 'deleteOwnFile(' + rowID + ',myprofile)');
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
		} else {
			errorMessage = document.createElement('div');
			errorMessage.setAttribute('id', 'error');
			errorMessage.innerHTML = 'You have no uploads!';
			$('#tabs-1').append(errorMessage);
		}

	});
}


function clearSubList() {

	$('.newfiles_content').empty();
	$.get('reference.php', {
		func: 'clear_sub_list',
	}, function(response) {
		var noti = document.getElementById('mysubsbar');
		$.get('reference.php', {
			func: 'mysubscriptions',
			action: 'files_num',
		}, function(newFiles) {
			noti.innerHTML = "Subscriptions (" + newFiles + ")";
			myNewFiles();
		});
	});
}

function loadComments(fileID) {
	$('#comments_table').empty();
	$.get('reference.php', {
		func: 'comments',
		file: fileID,
	}, function(response) {
		// var header = document.createElement('h1');
		// header.innerHTML = 'Comments';
		// $('#comments').append(header);
		if (response == 'false') {
			// var isLoggedIn = isLoggedIn();
			if (isLoggedIn() != 'false') {
				var errorMessage = document.createElement('div');
				errorMessage.setAttribute('id', 'error');
				errorMessage.innerHTML = 'There is no comments for this file. Why dont you leave one?';
				var linebreak = document.createElement('br');
				$('#comments_table').prepend(linebreak);
				$('#comments_table').prepend(errorMessage);
			}
		} else {
			var json = $.parseJSON(response);
			var table = document.createElement('table');
			table.setAttribute('id', 'table');
			table.setAttribute('style', 'width:75%;');

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

			for (var i = 0; i < json.length; i++) {
				var rowID = json[i]['user_row'];
				var commentBy = json[i]['username'];
				var comment = json[i]['comment'];
				var dateCommented = json[i]['date_commented'];

				var row = document.createElement('tr');
				if (isEven(i)) row.setAttribute('class', 'alt');

				//Comment by
				var td1 = document.createElement('td');
				var td1Link = document.createElement('a');
				td1Link.setAttribute('href', '?page=profile&userID=' + rowID);
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
			$('#comments_table').append(table);
		}
	});
}


function fileInfo() {
	var fileID = qs['fileID'];
	$.get('reference.php', {
		func: 'fileinfo',
		file: fileID,
		action: 'is_reported',
	}, function(response) {
		if (response == 'true') {
			var warning = document.createElement('div');
			warning.setAttribute('id', 'error');
			warning.innerHTML = 'Be careful! This file has been reported at abuse! We are on the case. You can still download the file, but: BE CAREFUL!';
			$('#warning').prepend(warning);
		}
	});

	$.get('reference.php', {
		func: 'fileinfo',
		action: 'fileinfo',
		file: fileID,

	}, function(response) {
		if (response == 'false') {
			window.location.href = '?page=search';
		} else {
			var json = $.parseJSON(response);
			var rowID = json[0]['f_rowID'];
			var uploadedByID = json[0]['f_uploaded_by'];
			var uploadedBy = json[0]['u_username'];
			var uploadedById = json[0]['u_rowID'];
			var uploadedDate = json[0]['f_uploaded_date'];
			var mimeType = json[0]['f_mimetype'];
			var size = json[0]['f_size'];
			var file = json[0]['f_file'];
			var description = json[0]['f_description']

			$('#header').html(file);

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

			if (mimeType.substring(0, 6) == 'image/') {
				var header5 = document.createElement('th');
				header5.innerHTML = 'Dimension';
			}

			var header6 = document.createElement('th');
			header6.innerHTML = 'Times downloaded';

			table.appendChild(header1);
			table.appendChild(header2);
			table.appendChild(header3);
			table.appendChild(header4);
			if (mimeType.substring(0, 6) == 'image/') table.appendChild(header5);
			table.appendChild(header6);



			// var uploadedById = json[i]['f_rowID']
			var row = document.createElement('tr');
			row.setAttribute('class', 'alt');

			//Uploaded by
			var td1 = document.createElement('td');
			td1Link = document.createElement('a');
			td1Link.setAttribute('href', '?page=profile&userID=' + uploadedById);
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
			if (mimeType.substring(0, 6) == 'image/') {
				var td5 = document.createElement('td');
				var img = new Image();
				img.src = './printimage.php?id=' + rowID;
				img.onload = function() {
					width = this.width;
					height = this.height;
					td5.innerHTML = 'Height: ' + height + 'Width: ' + width;
				}
			}

			//Times downloaded
			var td6 = document.createElement('td');
			var td6Link = document.createElement('a');
			td6Link.setAttribute('href', '?page=download_analysis&file=' + fileID);
			td6Link.setAttribute('id', 'timesDownloaded');
			$.get('reference.php', {
				func: 'fileinfo',
				action: 'times_downloaded',
				file: fileID,
			}, function(response) {
				td6Link.innerHTML = response;
			});
			td6.appendChild(td6Link);

			row.appendChild(td1);
			row.appendChild(td2);
			row.appendChild(td3);
			row.appendChild(td4);
			if (mimeType.substring(0, 6) == 'image/') row.appendChild(td5);
			row.appendChild(td6);

			table.appendChild(row);
			$('#info').prepend(table);
			var linebreak = document.createElement('br');
			$('#cont').append(linebreak);
			$('#cont').append(linebreak);
			$('#cont').append(linebreak);

		}
		var mimeType = json[0]['f_mimetype'];
		var rowID = json[0]['f_rowID'];

		if (!empty(description)) {
			var fieldset = document.createElement('fieldset');
			var legend = document.createElement('legend');
			legend.innerHTML = 'Description';
			fieldset.innerHTML = description;
			fieldset.appendChild(legend);
			$('#info').append(linebreak);
			$('#info').append(fieldset);
		}

		if (mimeType.substring(0, 6) == 'image/') {

			// var listItem = document.createElement('li');
			// var liLink = document.createElement('a');
			// liLink.setAttribute('href', '#preview');
			// liLink.innerHTML = 'Image preview';
			// liLink.setAttribute('class', 'ui-state-default ui-corner-top');
			// listItem.appendChild(liLink);
			// $('#tabs_wrap').append(listItem);
			$('#showme').css('visibility', 'visible');

			// var prevDiv = document.createElement('div');
			// prevDiv.setAttribute('id', 'preview');

			// $('#tabs').append(prevDiv);
			var pic = document.createElement('img');
			pic.setAttribute('src', 'printimage.php?id=' + rowID);
			pic.style.width = '70%';
			pic.style.height = 'auto';

			var linebreak = document.createElement('br');
			// $('#cont').append(linebreak);
			// $('#cont').append(pic);

			$('#preview').append(pic);

		}

	});
	loadComments(fileID);

	$.get('reference.php', {
		func: 'isloggedin',
	}, function(response) {
		if (response != 'false') {
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
		} else {
			var errorMessage = document.createElement('div');
			errorMessage.setAttribute('id', 'error');
			errorMessage.innerHTML = 'In order to comment, you need to ';
			var errLink = document.createElement('a');
			errLink.setAttribute('href', '?page=login&attemptedSite=fileinfo&file=' + fileID);
			errLink.innerHTML = 'login';
			errorMessage.appendChild(errLink);
			$('#commentform').append(errorMessage);
		}
	});
}

function placeComment() {
	var fileID = qs['fileID'];
	if (document.comment.comment.value != '') {
		$.get('reference.php', {
			func: 'place_comment',
			comment: document.comment.comment.value,
			file: fileID,
		}, function(response) {
			loadComments(fileID);
			document.comment.comment.value = '';
			$('.rmMe').remove();
		});
	} else {
		var err = document.createElement('div');
		err.setAttribute('id', 'error');
		err.setAttribute('class', 'rmMe');
		err.innerHTML = 'The textfield is not filled out correctly';
		$('#commentform').append(err);
	}
}

function reqLogin() {

	var checked = document.login.remember.checked;
	var username = document.login.username.value;
	var password = document.login.password.value;
	$.get('reference.php', {
		func: 'login',
		u: username,
		p: MD5(password),
		remember: checked,
	}, function(response) {
		if (response == 'true') {
			if (qs['attemptedSite'] && qs['attemptedSite'] == 'report_abuse' && qs['reportedFile']) {
				window.location.href = "?page=report_abuse&reportedFile=" + qs['reportedFile'];
			} else if (qs['attemptedSite'] && qs['fileID'] && qs['attemptedSite'] == 'fileinfo') {
				window.location.href = "?page=fileinfo&fileID=" + qs['fileID'];
			} else if (qs['attemptedSite']) {
				window.location.href = "?page=" + qs['attemptedSite'];
			} else {
				window.location.href = "?page=search";
			}
		} else {
			$('#error').html('The username and password does not match').hide().fadeIn();
			$('html,body').animate({
				scrollTop: $("#error").offset().top
			}, 1000);
		}

	});
	return false;
}

function forgotPassword() {
	var email = document.forgot_password.email.value;
	var username = document.forgot_password.username.value;
	$.get('reference.php', {
		func: 'forgot_password',
		email: email,
		username: username,
	}, function(response) {
		if (response == 'false') {
			$('#error').html('The entered username and email does not match').hide().fadeIn();
		} else if (response == 'email_error') {
			$('#error').empty().html('An error occured. Please try again later').hide().fadeIn();
		} else {
			$('#error').empty();
			$('#forgot').empty();
			$('#mes').remove();
			$('#success').html('An email has been sent to you at ' + email).hide().fadeIn();
		}

	});
	return false;
}

function navBar() {
	$.get('reference.php', {
		func: 'isloggedin',
	}, function(response) {
		if (response != 'false') {
			$.get('reference.php', {
				func: 'mysubscriptions',
				action: 'files_num',
			}, function(newFiles) {
				var json = $.parseJSON(response);

				var bar = document.getElementById('links');

				var ul = document.createElement('ul');

				var loggedInAs = document.createElement('span');
				loggedInAs.setAttribute('class', 'loggedin');
				loggedInAs.innerHTML = 'Logged in as: ' + json['username'];
				ul.appendChild(loggedInAs);

				var logout = document.createElement('li');
				logout.id = "logout";
				var logoutLink = document.createElement('a');
				logoutLink.href = "?page=logout";
				logoutLink.innerHTML = 'Logout';
				logout.appendChild(logoutLink);
				ul.appendChild(logout);

				var myprofile = document.createElement('li');
				myprofile.id = "myprofile";
				var myprofileLink = document.createElement('a');
				myprofileLink.href = "?page=myprofile";
				myprofileLink.innerHTML = 'My profile';
				myprofile.appendChild(myprofileLink);
				ul.appendChild(myprofile);

				var mysubscriptions = document.createElement('li');
				mysubscriptions.id = "mysubscriptions";
				var mysubscriptionsLink = document.createElement('a');
				mysubscriptionsLink.href = "?page=mysubscriptions";
				mysubscriptionsLink.id = "mysubsbar";
				mysubscriptionsLink.innerHTML = 'Subscriptions (' + newFiles + ')';
				mysubscriptions.appendChild(mysubscriptionsLink);
				ul.appendChild(mysubscriptions);

				var home = document.createElement('li');
				home.id = "home";
				var homeLink = document.createElement('a');
				homeLink.href = "?page=search";
				homeLink.innerHTML = 'Home';
				home.appendChild(homeLink);
				ul.appendChild(home);

				var upload = document.createElement('li');
				upload.id = "upload";
				var uploadLink = document.createElement('a');
				uploadLink.href = "?page=upload";
				uploadLink.innerHTML = 'Upload';
				upload.appendChild(uploadLink);
				ul.appendChild(upload);

				if (json['admin'] == '1') {
					var admin = document.createElement('li');
					admin.id = "admin";
					var adminLink = document.createElement('a');
					adminLink.href = "?page=admin";
					adminLink.innerHTML = 'Admin';
					admin.appendChild(adminLink);
					ul.appendChild(admin);
				}

				bar.appendChild(ul);

				if (qs['page'] == 'myprofile' || qs['page'] == 'mysubscriptions' || qs['page'] == 'upload' || qs['page'] == 'admin') document.getElementById(qs['page']).setAttribute('class', 'current_page_item');
				else if (qs['page'] == 'user_pref') document.getElementById('myprofile').setAttribute('class', 'current_page_item');
				else if (qs['page'] == 'search') document.getElementById('home').setAttribute('class', 'current_page_item');

			});


		} else {
			var bar = document.getElementById('links');

			var ul = document.createElement('ul');

			var signup = document.createElement('li');
			signup.id = "signup";
			var signupLink = document.createElement('a');
			signupLink.href = "?page=signup";
			signupLink.innerHTML = 'Signup';
			signup.appendChild(signupLink);
			ul.appendChild(signup);

			var login = document.createElement('li');
			login.id = "login";
			var loginLink = document.createElement('a');
			loginLink.href = "?page=login";
			loginLink.innerHTML = 'Login';
			login.appendChild(loginLink);
			ul.appendChild(login);

			var home = document.createElement('li');
			home.id = "home";
			var homeLink = document.createElement('a');
			homeLink.href = "?page=search";
			homeLink.innerHTML = 'Home';
			home.appendChild(homeLink);
			ul.appendChild(home);

			bar.appendChild(ul);

			if (qs['page'] != 'search') document.getElementById(qs['page']).setAttribute('class', 'current_page_item');
			else document.getElementById('home').setAttribute('class', 'current_page_item');

		}
	});
}

function download() {
	var file = qs['fileID'];
	window.location.href = "download.php?file=" + file;
	var el = document.getElementById('timesDownloaded');
	var num = el.innerHTML;
	el.innerHTML = parseInt(num) + 1;
}


function sendMail() {
	var subject = document.mail.subject.value;
	var message = document.mail.message.value;

	$.get('reference.php', {
		func: 'mail',
		subject: subject,
		message: message,
	}, function(response) {
		if (response == 'false') {
			var errorMessage = document.createElement('div');
			errorMessage.id = "error";
			errorMessage.innerHTML = "An error occured. Please try again later";
			$('#mes').append(errorMessage).hide().fadeIn();
			$('html,body').animate({
				scrollTop: $("#mes").offset().top
			}, 1000);
		} else {
			var message = document.createElement('div');
			message.id = "success";
			message.innerHTML = "The mails was successfully sent";
			$('#mes').append(message).hide().fadeIn();
			$('html,body').animate({
				scrollTop: $("#mes").offset().top
			}, 1000);
			$('#mail').empty();
		}

	});
	return false;
}

function profile() {
	var userID = qs['userID'];
	$.get('reference.php', {
		func: 'profile',
		userID: userID,
	}, function(response) {

	});
}


function mySubscriptions() {
	$.get('reference.php', {
		func: 'mysubscriptions',
		action: 'mysubscriptions_num',
	}, function(data) {

		if (data > 0) {
			$('#mysubscribtions_pointer').html('► ');
			var open = false;

			var loaded = false;
			$('.mysubscribtions').attr('title', 'Click me').html('My subscriptions(' + data + ')');

			$(".mysubscribtions").click(function() {


				var pointer = $('#mysubscribtions_pointer').html();
				if (pointer == '► ') $('#mysubscribtions_pointer').html('▼ ');
				else $('#mysubscribtions_pointer').html('► ');

				if (loaded == false) {
					var img = document.createElement('img');
					img.setAttribute('src', 'img/load.gif');
					$('.mysubscribtions_content').append(img);
					$('.mysubscribtions_content').slideToggle('fast');

					$.get('reference.php', {
						func: 'mysubscriptions',
						action: 'mysubscriptions',
					}, function(data) {
						$('.mysubscribtions_content').empty();
						var json = $.parseJSON(data);
						for (var i = 0; i < json.length; i++) {
							var link = document.createElement('a');
							link.setAttribute('href', '?page=profile&userID=' + json[i]['u_rowID']);
							link.innerHTML = json[i]['u_username'];
							$('.mysubscribtions_content').append(link);
							var linebreak = document.createElement('br');
							$('.mysubscribtions_content').append(linebreak);
							loaded = true;
						}


					});

				} else {
					$('.mysubscribtions_content').slideToggle('fast');
				}
			});

		} else {
			$('.mysubscribtions').id('error').html('You have no subscriptions');
		}

	});
}

function mySubscribers() {
	$.get('reference.php', {
		func: 'mysubscriptions',
		action: 'mysubscribers_num',
	}, function(data) {
		if (data > 0) {
			$('#mysubscribers_pointer').html('► ');
			var open = false;

			var loaded = false;
			$('.mysubscribers').attr('title', 'Click me').html('My subscribers(' + data + ')');

			$(".mysubscribers").click(function() {


				var pointer = $('#mysubscribers_pointer').html();
				if (pointer == '► ') $('#mysubscribers_pointer').html('▼ ');
				else $('#mysubscribers_pointer').html('► ');

				if (loaded == false) {
					var img = document.createElement('img');
					img.setAttribute('src', 'img/load.gif');
					$('.mysubscribers_content').append(img);
					$('.mysubscribers_content').slideToggle('fast');

					$.get('reference.php', {
						func: 'mysubscriptions',
						action: 'mysubscribers',
					}, function(data) {
						$('.mysubscribers_content').empty();
						var json = $.parseJSON(data);
						for (var i = 0; i < json.length; i++) {
							var link = document.createElement('a');
							link.setAttribute('href', '?page=profile&userID=' + json[i]['u_rowID']);
							link.innerHTML = json[i]['u_username'];
							$('.mysubscribers_content').append(link);
							var linebreak = document.createElement('br');
							$('.mysubscribers_content').append(linebreak);
							loaded = true;
						}


					});

				} else {
					$('.mysubscribers_content').slideToggle('fast');
				}
			});

		} else {
			$('.mysubscribers').attr('id', 'error').html('You have no subscribers');
		}

	});
}



function myNewFiles() {
	$.get('reference.php', {
		func: 'mysubscriptions',
		action: 'files_num'
	}, function(data) {
		if (data > 0) {
			$('#newfiles_pointer').html('► ');
			var open = false;
			var loaded = false;
			$('.newfiles').attr('title', 'Click me').html('Unseen files(' + data + ')');

			$(".newfiles").click(function() {
				var pointer = $('#newfiles_pointer').html();
				if (pointer == '► ') $('#newfiles_pointer').html('▼ ');
				else $('#newfiles_pointer').html('► ');

				if (loaded == false) {
					loaded = true;

					var img = document.createElement('img');
					img.setAttribute('src', 'img/load.gif');
					$('.newfiles_content').append(img);
					$('.newfiles_content').slideToggle('fast');

					$.get('reference.php', {
						func: 'mysubscriptions',
						action: 'files',
					}, function(data) {
						var json = $.parseJSON(data);

						var table = document.createElement('table');
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


						for (var i = 0; i < json.length; i++) {
							var rowID = json[i]['f_rowID'];
							var fileName = json[i]['f_file'];
							var uploadedById = json[i]['f_uploaded_by'];
							var uploadedBy = json[i]['u_username'];
							var uploadedDate = json[i]['f_uploaded_date'];
							var row = document.createElement('tr');
							if (isEven(i)) row.setAttribute('class', 'alt');
							// filename
							var td1 = document.createElement('td');
							var td1Link = document.createElement('a');
							td1Link.setAttribute('href', '?page=fileinfo&fileID=' + rowID);
							td1Link.innerHTML = fileName;
							td1.appendChild(td1Link);
							//Uploaded by 
							var td2 = document.createElement('td');
							td2Link = document.createElement('a');
							td2Link.setAttribute('href', '?page=profile&userID=' + uploadedById);
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
						$('.newfiles_content').empty();
						$('.newfiles_content').append(table);
						var button = document.createElement('input');
						button.setAttribute('class', 'submit');
						button.setAttribute('value', 'Clear list');
						button.setAttribute('onclick', 'clearSubList();');
						button.setAttribute('type', 'button');

						$('.newfiles_content').append(button);
					});



				} else {
					$('.newfiles_content').slideToggle('fast');
				}

			});

		} else {

			$('#newfiles_pointer').empty();
			$('.newfiles').css('cursor', 'default');
			$('#newfiles_pointer').append(linebreak);
			$('#newfiles_pointer').append(linebreak);
			$('.newfiles').attr('id', 'error').html('You have no unseen files');
		}
	});

}
