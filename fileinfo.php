<?php
if ( __FILE__ == $_SERVER['SCRIPT_FILENAME'] ) {
	header( 'Location: index.php?page='.substr( end( explode( '/', $_SERVER['SCRIPT_FILENAME'] ) ), 0, -4 ).'?'.$_SERVER['QUERY_STRING'] );
	die();
}
?>
<h1 id="header"></h1>
<span id="warning"></span>
<div id="success"></div>
<p class="submit">
	<input type="button" value="Download file" onclick="download()">
	<br />
	<br />
	<input type='button' onClick='reportFile(<?php echo $_GET["fileID"]?>)' value='Report abuse' ></p>
<script type="text/javascript">
fileInfo();

$(document).ready(function() {
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
<div id="cont"></div>
<!-- <div id="comments"></div> -->


<div id="tabs">
	<ul id="tabs_wrap">
		<li>
			<a href="#info">Info</a>
		</li>
		<li>
			<a href="#comments">Comments</a>
		</li>
		<li id="showme" style="visibility:hidden;"><a href="#preview">Image preview</a></li>
	</ul>

	<div id="info"></div>
	<div id="comments">
		<div id="comments_table"></div>
		<div id="commentform"></div>
	</div>
	<div id="preview"></div>
</div>