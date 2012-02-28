function areYouSure(arg)
{
	var sure = confirm("Are you sure that you want to delete that file?");
	if(sure == true) window.location.href="?page=delete_file&fileID="+arg+"&site=myprofile";
}
function areYouSure2(file,site)
{
	var sure = confirm("Are you sure that you want to report this file as abuse?");
	if(sure == true) window.location.href="?page=report_abuse&reportedFile="+file;
}

function areYouSure3(arg)
{
	var sure = confirm("Are you sure that you want to delete that file?");
	if(sure == true) window.location.href="?page=delete_file&fileID="+arg+"&site="+site;
}