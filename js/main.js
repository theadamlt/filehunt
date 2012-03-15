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
  window.prompt ("Copy to clipboard: Ctrl+C, Enter", text);
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
