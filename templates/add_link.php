<h2>Add Link</h2>
<form action="" method="post">
<?php
if($QUERY['success']) {
	print "<p>$QUERY[success]</p>";
} 

$html->buildInput("title");
$html->buildInput("url", "URL");
$html->buildInput("summary", 'Summary', 'textarea');
$html->buildInput("published_on");
$html->buildInput("feed_id", "Site", 'select', '3', array('options'=>$all_feeds) );
$html->buildInput("action",'&nbsp', 'submit', 'Save Link');
?>
</form>
