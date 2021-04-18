<?php
include('common.php');

//Get details of all the sites
$all_sites = $sql->getAll("SELECT id,name,url,description FROM Feed WHERE status=1");

$where = array();

//Time based searchs
$limit = array(
	'from'	=> array('year'=>2005,		'month'=>2),
	'to'	=> array('year'=>date('Y'),	'month'=>date('n'))
);

if(isset($_REQUEST['year'])) {
	$post_year = intval($_REQUEST['year']);
	$where[] = "YEAR(Post.published_on)='$post_year'";

	if(isset($_REQUEST['month'])) {
		$post_month = intval($_REQUEST['month']);
		//Validations
		if($post_month>12) $post_month=12;
		elseif($post_month<1) $post_month=1;
		if(!withinLimit($year, $mon)) error404();

		$where[] = "MONTH(Post.published_on)='$post_month'";
	}
}


//Feed based searchs
if(isset($_REQUEST['feed'])) {
	$feeds = array();
	foreach($_REQUEST['feed'] as $feed_id) {
		$feeds[] = "Post.feed_id=$feed_id";
	}
	$where[] = "(" . implode(' OR ', $feeds) . ")";
}

$where[] = "Feed.status='1'";

//Get all the posts with the given parameters
$all_posts = $sql->getAll("SELECT Post.id,Post.title,Post.url,DATE_FORMAT(Post.published_on,'%d %M, %Y') AS date, "
		. " Feed.name AS feed, Feed.id AS feed_id "
		. " FROM Post INNER JOIN Feed ON Post.feed_id=Feed.id WHERE " . implode(' AND ', $where)
		. " ORDER BY published_on DESC");

function withinLimit($year, $mon) {
	global $limit;
	if($year < $limit['from']['year'])	return false;
	elseif($year > $limit['to']['year'])return false;
	elseif($year == $limit['from']['year']	and $mon < $limit['from']['month'])	return false;
	elseif($year == $limit['to']['year']	and $mon > $limit['to']['month'])	return false;
	
	return true;
}

function error404() {
	header("HTTP/1.0 404 Not Found");
	render('404.php');
	exit;
}

$template->addResource('library/links_search.js');
render();
