<?php
require('./common.php');
$html = new HTML;

if(isset($QUERY['title'])) {
	if(!$sql->getOne("SELECT title FROM Post WHERE url='$QUERY[url]'")) { //Make sure that the URL is not already in the DB.
		$sql->insertFields('Post', array('title', 'url', 'summary', 'published_on', 'feed_id'), $QUERY);
		$QUERY['success'] = "Post added to the database.";
	} else {
		$QUERY['error'] = "Post already in the database";
	}
}

render();
