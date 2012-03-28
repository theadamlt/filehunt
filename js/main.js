function deleteOwnFile(arg)
{
	var sure = confirm("Are you sure that you want to delete that file?");
	if(sure == true) window.location.href="?page=delete_file&fileID="+arg;
}
function reportFile(file)
{
	var sure = confirm("Are you sure that you want to report this file as abuse?");
	if(sure == true) window.location.href="?page=report_abuse&reportedFile="+file;
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


var isDetailsSupported = (function(doc) {
  var el = doc.createElement('details'),
	  fake,
	  root,
	  diff;
  if (!('open' in el)) {
	return false;
  }
  root = doc.body || (function() {
	var de = doc.documentElement;
	fake = true;
	return de.insertBefore(doc.createElement('body'), de.firstElementChild || de.firstChild);
  }());
  el.innerHTML = '<summary>a</summary>b';
  el.style.display = 'block';
  root.appendChild(el);
  diff = el.offsetHeight;
  el.open = true;
  diff = diff != el.offsetHeight;
  root.removeChild(el);
  if (fake) {
	root.parentNode.removeChild(root);
  }
  return diff;
}(document));


var MD5 = function (string) {
 
  function RotateLeft(lValue, iShiftBits) {
	return (lValue<<iShiftBits) | (lValue>>>(32-iShiftBits));
  }
 
  function AddUnsigned(lX,lY) {
	var lX4,lY4,lX8,lY8,lResult;
	lX8 = (lX & 0x80000000);
	lY8 = (lY & 0x80000000);
	lX4 = (lX & 0x40000000);
	lY4 = (lY & 0x40000000);
	lResult = (lX & 0x3FFFFFFF)+(lY & 0x3FFFFFFF);
	if (lX4 & lY4) {
	  return (lResult ^ 0x80000000 ^ lX8 ^ lY8);
	}
	if (lX4 | lY4) {
	  if (lResult & 0x40000000) {
		return (lResult ^ 0xC0000000 ^ lX8 ^ lY8);
	  } else {
		return (lResult ^ 0x40000000 ^ lX8 ^ lY8);
	  }
	} else {
	  return (lResult ^ lX8 ^ lY8);
	}
  }
 
  function F(x,y,z) { return (x & y) | ((~x) & z); }
  function G(x,y,z) { return (x & z) | (y & (~z)); }
  function H(x,y,z) { return (x ^ y ^ z); }
  function I(x,y,z) { return (y ^ (x | (~z))); }
 
  function FF(a,b,c,d,x,s,ac) {
	a = AddUnsigned(a, AddUnsigned(AddUnsigned(F(b, c, d), x), ac));
	return AddUnsigned(RotateLeft(a, s), b);
  };
 
  function GG(a,b,c,d,x,s,ac) {
	a = AddUnsigned(a, AddUnsigned(AddUnsigned(G(b, c, d), x), ac));
	return AddUnsigned(RotateLeft(a, s), b);
  };
 
  function HH(a,b,c,d,x,s,ac) {
	a = AddUnsigned(a, AddUnsigned(AddUnsigned(H(b, c, d), x), ac));
	return AddUnsigned(RotateLeft(a, s), b);
  };
 
  function II(a,b,c,d,x,s,ac) {
	a = AddUnsigned(a, AddUnsigned(AddUnsigned(I(b, c, d), x), ac));
	return AddUnsigned(RotateLeft(a, s), b);
  };
 
  function ConvertToWordArray(string) {
	var lWordCount;
	var lMessageLength = string.length;
	var lNumberOfWords_temp1=lMessageLength + 8;
	var lNumberOfWords_temp2=(lNumberOfWords_temp1-(lNumberOfWords_temp1 % 64))/64;
	var lNumberOfWords = (lNumberOfWords_temp2+1)*16;
	var lWordArray=Array(lNumberOfWords-1);
	var lBytePosition = 0;
	var lByteCount = 0;
	while ( lByteCount < lMessageLength ) {
	  lWordCount = (lByteCount-(lByteCount % 4))/4;
	  lBytePosition = (lByteCount % 4)*8;
	  lWordArray[lWordCount] = (lWordArray[lWordCount] | (string.charCodeAt(lByteCount)<<lBytePosition));
	  lByteCount++;
	}
	lWordCount = (lByteCount-(lByteCount % 4))/4;
	lBytePosition = (lByteCount % 4)*8;
	lWordArray[lWordCount] = lWordArray[lWordCount] | (0x80<<lBytePosition);
	lWordArray[lNumberOfWords-2] = lMessageLength<<3;
	lWordArray[lNumberOfWords-1] = lMessageLength>>>29;
	return lWordArray;
  };
 
  function WordToHex(lValue) {
	var WordToHexValue="",WordToHexValue_temp="",lByte,lCount;
	for (lCount = 0;lCount<=3;lCount++) {
	  lByte = (lValue>>>(lCount*8)) & 255;
	  WordToHexValue_temp = "0" + lByte.toString(16);
	  WordToHexValue = WordToHexValue + WordToHexValue_temp.substr(WordToHexValue_temp.length-2,2);
	}
	return WordToHexValue;
  };
 
  function Utf8Encode(string) {
	string = string.replace(/\r\n/g,"\n");
	var utftext = "";
 
	for (var n = 0; n < string.length; n++) {
 
	  var c = string.charCodeAt(n);
 
	  if (c < 128) {
		utftext += String.fromCharCode(c);
	  }
	  else if((c > 127) && (c < 2048)) {
		utftext += String.fromCharCode((c >> 6) | 192);
		utftext += String.fromCharCode((c & 63) | 128);
	  }
	  else {
		utftext += String.fromCharCode((c >> 12) | 224);
		utftext += String.fromCharCode(((c >> 6) & 63) | 128);
		utftext += String.fromCharCode((c & 63) | 128);
	  }
 
	}
 
	return utftext;
  };
 
  var x=Array();
  var k,AA,BB,CC,DD,a,b,c,d;
  var S11=7, S12=12, S13=17, S14=22;
  var S21=5, S22=9 , S23=14, S24=20;
  var S31=4, S32=11, S33=16, S34=23;
  var S41=6, S42=10, S43=15, S44=21;
 
  string = Utf8Encode(string);
 
  x = ConvertToWordArray(string);
 
  a = 0x67452301; b = 0xEFCDAB89; c = 0x98BADCFE; d = 0x10325476;
 
  for (k=0;k<x.length;k+=16) {
	AA=a; BB=b; CC=c; DD=d;
	a=FF(a,b,c,d,x[k+0], S11,0xD76AA478);
	d=FF(d,a,b,c,x[k+1], S12,0xE8C7B756);
	c=FF(c,d,a,b,x[k+2], S13,0x242070DB);
	b=FF(b,c,d,a,x[k+3], S14,0xC1BDCEEE);
	a=FF(a,b,c,d,x[k+4], S11,0xF57C0FAF);
	d=FF(d,a,b,c,x[k+5], S12,0x4787C62A);
	c=FF(c,d,a,b,x[k+6], S13,0xA8304613);
	b=FF(b,c,d,a,x[k+7], S14,0xFD469501);
	a=FF(a,b,c,d,x[k+8], S11,0x698098D8);
	d=FF(d,a,b,c,x[k+9], S12,0x8B44F7AF);
	c=FF(c,d,a,b,x[k+10],S13,0xFFFF5BB1);
	b=FF(b,c,d,a,x[k+11],S14,0x895CD7BE);
	a=FF(a,b,c,d,x[k+12],S11,0x6B901122);
	d=FF(d,a,b,c,x[k+13],S12,0xFD987193);
	c=FF(c,d,a,b,x[k+14],S13,0xA679438E);
	b=FF(b,c,d,a,x[k+15],S14,0x49B40821);
	a=GG(a,b,c,d,x[k+1], S21,0xF61E2562);
	d=GG(d,a,b,c,x[k+6], S22,0xC040B340);
	c=GG(c,d,a,b,x[k+11],S23,0x265E5A51);
	b=GG(b,c,d,a,x[k+0], S24,0xE9B6C7AA);
	a=GG(a,b,c,d,x[k+5], S21,0xD62F105D);
	d=GG(d,a,b,c,x[k+10],S22,0x2441453);
	c=GG(c,d,a,b,x[k+15],S23,0xD8A1E681);
	b=GG(b,c,d,a,x[k+4], S24,0xE7D3FBC8);
	a=GG(a,b,c,d,x[k+9], S21,0x21E1CDE6);
	d=GG(d,a,b,c,x[k+14],S22,0xC33707D6);
	c=GG(c,d,a,b,x[k+3], S23,0xF4D50D87);
	b=GG(b,c,d,a,x[k+8], S24,0x455A14ED);
	a=GG(a,b,c,d,x[k+13],S21,0xA9E3E905);
	d=GG(d,a,b,c,x[k+2], S22,0xFCEFA3F8);
	c=GG(c,d,a,b,x[k+7], S23,0x676F02D9);
	b=GG(b,c,d,a,x[k+12],S24,0x8D2A4C8A);
	a=HH(a,b,c,d,x[k+5], S31,0xFFFA3942);
	d=HH(d,a,b,c,x[k+8], S32,0x8771F681);
	c=HH(c,d,a,b,x[k+11],S33,0x6D9D6122);
	b=HH(b,c,d,a,x[k+14],S34,0xFDE5380C);
	a=HH(a,b,c,d,x[k+1], S31,0xA4BEEA44);
	d=HH(d,a,b,c,x[k+4], S32,0x4BDECFA9);
	c=HH(c,d,a,b,x[k+7], S33,0xF6BB4B60);
	b=HH(b,c,d,a,x[k+10],S34,0xBEBFBC70);
	a=HH(a,b,c,d,x[k+13],S31,0x289B7EC6);
	d=HH(d,a,b,c,x[k+0], S32,0xEAA127FA);
	c=HH(c,d,a,b,x[k+3], S33,0xD4EF3085);
	b=HH(b,c,d,a,x[k+6], S34,0x4881D05);
	a=HH(a,b,c,d,x[k+9], S31,0xD9D4D039);
	d=HH(d,a,b,c,x[k+12],S32,0xE6DB99E5);
	c=HH(c,d,a,b,x[k+15],S33,0x1FA27CF8);
	b=HH(b,c,d,a,x[k+2], S34,0xC4AC5665);
	a=II(a,b,c,d,x[k+0], S41,0xF4292244);
	d=II(d,a,b,c,x[k+7], S42,0x432AFF97);
	c=II(c,d,a,b,x[k+14],S43,0xAB9423A7);
	b=II(b,c,d,a,x[k+5], S44,0xFC93A039);
	a=II(a,b,c,d,x[k+12],S41,0x655B59C3);
	d=II(d,a,b,c,x[k+3], S42,0x8F0CCC92);
	c=II(c,d,a,b,x[k+10],S43,0xFFEFF47D);
	b=II(b,c,d,a,x[k+1], S44,0x85845DD1);
	a=II(a,b,c,d,x[k+8], S41,0x6FA87E4F);
	d=II(d,a,b,c,x[k+15],S42,0xFE2CE6E0);
	c=II(c,d,a,b,x[k+6], S43,0xA3014314);
	b=II(b,c,d,a,x[k+13],S44,0x4E0811A1);
	a=II(a,b,c,d,x[k+4], S41,0xF7537E82);
	d=II(d,a,b,c,x[k+11],S42,0xBD3AF235);
	c=II(c,d,a,b,x[k+2], S43,0x2AD7D2BB);
	b=II(b,c,d,a,x[k+9], S44,0xEB86D391);
	a=AddUnsigned(a,AA);
	b=AddUnsigned(b,BB);
	c=AddUnsigned(c,CC);
	d=AddUnsigned(d,DD);
  }
 
  var temp = WordToHex(a)+WordToHex(b)+WordToHex(c)+WordToHex(d);
 
  return temp.toLowerCase();
};

function dump(arr,level) {
var dumped_text = "";
if(!level) level = 0;

//The padding given at the beginning of the line.
var level_padding = "";
for(var j=0;j<level+1;j++) level_padding += "    ";

if(typeof(arr) == 'object') { //Array/Hashes/Objects
 for(var item in arr) {
  var value = arr[item];
 
  if(typeof(value) == 'object') { //If it is an array,
   dumped_text += level_padding + "'" + item + "' ...\n";
   dumped_text += dump(value,level+1);
  } else {
   dumped_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
  }
 }
} else { //Stings/Chars/Numbers etc.
 dumped_text = "===>"+arr+"<===("+typeof(arr)+")";
}
return dumped_text;
} 

var signupArray = new Array();
signupArray['username'] = 'false';
signupArray['email'] = 'false';
signupArray['password'] = 'false';
signupArray['password2'] = 'false'

function validateSignup()
{
	if(signupArray['username'] == 'true' && signupArray['email'] == 'true' && signupArray['password'] == 'true' && signupArray['password2'] == 'true')
	{
		document.signup.password.value = MD5(document.signup.password.value);
		document.signup.password2.value = MD5(document.signup.password2.value);
		return true;
	}
	else
	{
		return false;
	}
}

function validate_login()
{
	document.login.password.value = MD5(document.login.password.value);
	return true;
}

function validateUsername()
{
	$.get("validate.php?func=u&u="+document.signup.username.value, function(response) { 
		if(response == 'false')
		{
			if(!document.getElementById('username_error'))
			{
				if(document.getElementById('username_success'))
				{
					$('#username_success').remove();
				}
				if(!document.getElementById('username_error'))
				{
					errorImg = document.createElement('img');
					errorImg.setAttribute('src', './img/error.png')
					errorImg.setAttribute('height', '16');
					errorImg.setAttribute('width', '16');
					errorImg.setAttribute('id', 'username_error');
					errorImg.setAttribute('title', 'The entered username is either not available or invalid');
					$('#username_label').prepend(errorImg);
					signupArray['username'] = 'false';
				}
			}
		}
		else
		{
			if(document.getElementById('username_error'))
			{
				$('#username_error').remove();
			}
			if(!document.getElementById('username_success'))
			{
				successImg = document.createElement('img');
				successImg.setAttribute('src', './img/success.png')
				successImg.setAttribute('height', '16');
				successImg.setAttribute('width', '16');
				successImg.setAttribute('title', 'The entered username is available and valid');
				successImg.setAttribute('id', 'username_success');
				$('#username_label').prepend(successImg);
				signupArray['username'] = 'true';
			}
		}
	});
}

function validateEmail()
{
	if(document.signup.email.value != '')
	{
	$.get("validate.php?func=m&m="+document.signup.email.value, function(response) { 
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
			signupArray['email'] = 'false';
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
			signupArray['email'] = 'true';
		}
	}

	});
	}
}

function validatePassword1()
{
	if(document.signup.password.value.length > 5)
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
				signupArray['password'] = 'true';
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
			signupArray['password'] = 'false';
		}
	}
}

function validatePassword2()
{
	if(document.signup.password.value == document.signup.password2.value)
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
			$('#password_label2').prepend(successMessage);
			signupArray['password2'] = 'true';
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
			$('#password_label2').prepend(errorMessage);
			signupArray['password2'] = 'false';
		}
	}
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
var user_pref_array = new Array();
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
	else return false;
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