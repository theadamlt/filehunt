 // function myNewFiles2() { $.get('reference.php', { func: 'mysubscriptions', action: 'files_num', }, function(data) { if (data > 0) { $('#newfiles_pointer').html('► '); var open = false; var loaded = false; $('.newfiles').attr('title', 'Click me').html('My subscribers(' + data + ')');

 // $(".newfiles").click(function() { 

 // var pointer = $('#newfiles_pointer').html(); if (pointer == '► ') $('#newfiles_pointer').html('▼ '); else $('#newfiles_pointer').html('► ');

 // if (loaded == false) { loaded = true; $.get('reference.php', { func: 'mysubscriptions', action: 'files', }, function(data) { var json = $.parseJSON(data);

 // var container = document.getElementById('center'); var linebreak = document.createElement('br'); container.appendChild(linebreak);

 // var table = document.createElement('table') table.setAttribute('id', 'table');

 // var theader = document.createElement('tr');

 // var theadertxt1 = document.createElement('th'); theadertxt1.innerHTML = 'Filename';

 // var theadertxt2 = document.createElement('th'); theadertxt2.innerHTML = 'Uploaded by';

 // var theadertxt3 = document.createElement('th'); theadertxt3.innerHTML = 'Uploaded date';

 // theader.appendChild(theadertxt1); theader.appendChild(theadertxt2); theader.appendChild(theadertxt3);

 // table.appendChild(theader); container.appendChild(table);

 // for (var i = 0; i < json.length; i++) { var rowID = json[i]['f_rowID']; var fileName = json[i]['f_file']; var uploadedByID = json[i]['f_uploaded_by']; var uploadedBy = json[i]['u_username']; var uploadedDate = json[i]['f_uploaded_date']; // var uploadedById = json[i]['f_rowID'] var row = document.createElement('tr'); if (isEven(i)) row.setAttribute('class', 'alt');

 // //filename var td1 = document.createElement('td'); var td1Link = document.createElement('a'); td1Link.setAttribute('href', '?page=fileinfo&fileID=' + rowID); td1Link.innerHTML = fileName; td1.appendChild(td1Link);

 // //Uploaded by var td2 = document.createElement('td'); td2Link = document.createElement('a'); td2Link.setAttribute('href', '?page=profile&userID=' + uploadedBy); td2Link.innerHTML = uploadedBy; td2.appendChild(td2Link);

 // //date td3 = document.createElement('td'); td3.innerHTML = timeConverter(uploadedDate);

 // row.appendChild(td1); row.appendChild(td2); row.appendChild(td3); table.appendChild(row);

 // } $('.newfiles_content').append(table);

 // // linebreak = document.createElement('br'); // $('#center').append(linebreak); // var span = document.createElement('span'); // span.setAttribute('class', 'submit'); // var button = document.createElement('input'); // button.setAttribute('type', 'button'); // button.setAttribute('onclick', 'clearSubList()'); // button.setAttribute('value', 'Clear list'); // span.appendChild(button); // $('#center').append(span); } }); 

 // }); }}); } }

 function myNewFiles2() {
	$.get('reference.php', {
		func: 'mysubscriptions',
		action: 'files_num'
	}, function(data) {
		if (data > 0) {
			$('#newfiles_pointer').html('► ');
			var open = false;
			var loaded = false;
			$('.newfiles').attr('title', 'Click me').html('My subscribers(' + data + ')');

			$(".newfiles").click(function() {
				var pointer = $('#newfiles_pointer').html();
				if (pointer == '► ') $('#newfiles_pointer').html('▼ ');
				else $('#newfiles_pointer').html('► ');

				if (loaded == false) {
					loaded = true;
					$.get('reference.php', {
						func: 'mysubscriptions',
						action: 'files',
					}, function(data) {});
					var json = $.parseJSON(data);

					var container = document.getElementById('center');
					var linebreak = document.createElement('br');
					container.appendChild(linebreak);

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
					container.appendChild(table);

					for (var i = 0; i < json.length; i++) {
						var rowID = json[i]['f_rowID'];
						var fileName = json[i]['f_file'];
						var uploadedByID = json[i]['f_uploaded_by'];
						var uploadedBy = json[i]['u_username'];
						var uploadedDate = json[i]['f_uploaded_date'];
						var uploadedById = json[i]['f_rowID'];
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
						td2Link.setAttribute('href', '?page=profile&userID=' + uploadedBy);
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
					$('.newfiles_content').append(table);


				}
			});

		}
	});
}