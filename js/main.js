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

function deleteFromSubList(file)
{
	var sure = confirm("Are you sure?");
	if(sure == true)
	{
		var table = document.getElementById('table');
		var tbody = table.getElementsByTagName('tbody')[0];
		var tr = document.getElementById(file);
		tbody.removeChild(tr);
		var subNumber = document.getElementById('sub');
		var rowLenght = document.getElementById('table').rows.length;
		rowLenght = rowLenght-1;
		sub.innerHTML = '<a href="?page=mysubscriptions">My subscriptions ('+rowLenght+')</a>';
		//window.location.href="?page=remove_from_sub_list&file="+file;
	}	
}

function removeNotice()
{
	var notice = document.getElementById('notice');
	var noticeChild = document.getElementById('error');
	notice.removeChild(noticeChild);
}