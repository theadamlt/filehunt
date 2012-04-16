<?php
if(isset($_GET['u']))
echo file_get_contents('http://jquery-howto.blogspot.com/2009/04/display-loading-gif-image-while-loading.html');
?>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.js"></script>
<button id="btnLoad">Load Content</button>
<details id="content">
	<summary>Click me</summary>
	<div id="hej"></div>
</details>

<script>

var done = false;
$("#content").click(function(){
	if(done == false)
	{
		done = true;
  // Put an animated GIF image insight of content
  $("#hej").empty().html('<img src="ajax-loader.gif" />');

  // Make AJAX call
  $("#hej").load("test.php?u=hej");
	}
	});
</script>