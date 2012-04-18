<?php
if(__FILE__ == $_SERVER['SCRIPT_FILENAME'])
{
	header('Location: index.php?page='.substr(end(explode('/', $_SERVER['SCRIPT_FILENAME'])),0,-4).'?'.$_SERVER['QUERY_STRING']);
	die();
}
?>
<div class="subscribtions">
	<span id="mysubscribtions_pointer"></span><span class="mysubscribtions"></span>

	<div class="mysubscribtions_content" style="display: none"></div>

	<br><br>

	<span id="mysubscribers_pointer"></span><span class="mysubscribers"></span>

	<div class="mysubscribers_content" style="display: none"></div>
</div>


<script type="text/javascript">
mySubscriptions();
mySubscribers();
// myNewFiles();
</script>
