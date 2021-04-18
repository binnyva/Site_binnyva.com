<?php
include('common.php');
$template -> addMetadata('keywords','Binny V Abraham,binny,web,programmer,developer,sites,binnyva');
$template -> addMetadata('description','Binny VA is the personal site of Binny V Abraham, freelance Web Developer based in Cochin, Kerala, India.');

//Get details of all the sites
$all_sites = $sql->getAll("SELECT id,name,url,description FROM Feed WHERE status=1");

$mode = 'index';

// Switch to aggregator mode.
if (i($_GET, 'show') == 'aggregator' or (i($_GET, 'year') and i($_GET, 'month'))) {

	$mode = 'aggregator';
	
	$calendar = new Calendar("day");
	$calendar->link_template = joinPath($config['site_url'], "%YEAR%/%MONTH%/");
	$calendar->limit = array(
		'from'	=> array('year'=>2005,		'month'=>2),
		'to'	=> array('year'=>date('Y'),	'month'=>date('n'))
	);
	
	//Cache all the events that will happen in this month.
	$all_posts = $sql->getAll("SELECT Post.id,Post.title,Post.url,Post.summary,Post.feed_id, DATE_FORMAT(Post.published_on,'%Y-%m-%d') AS published_on "
			. " FROM Post INNER JOIN Feed ON Post.feed_id=Feed.id WHERE YEAR(published_on)='{$calendar->year}' AND Feed.status='1' "
			. " AND MONTH(published_on)='". (($calendar->month < 10) ? '0' : '') . $calendar->month . "'");
			
	$posts = array();
	foreach($all_posts as $p) $posts[$p['published_on']][] = $p;
	
	//Get the data of the feeds
	$all_feeds = $sql->getAll("SELECT id,name,update_freqency FROM Feed");
	$feeds = array();
	foreach($all_feeds as $f) $feeds[$f['id']] = $f;
	
	//Find the last posted day of all feeds
	$next_post = array();
	if($calendar->year == date('Y') and $calendar->month == date('n')) { //We need to find this only if we are at the curent month
		$all_last_days = array();
		foreach($posts as $post_collection) {
			foreach($post_collection as $ps) { //Go thru each post
				foreach($feeds as $f) { //And find which feed it belongs to
					if($f['id'] == $ps['feed_id']) {
						$all_last_days[$f['id']] = $ps['published_on'];
						break;
					}
				}
			}
		}
		//Now to reverse it - put the date as the key and the id of the feed as the array in it.
		foreach($all_last_days as $feed_id => $last_update_date) {
			if(!$feeds[$feed_id]['update_freqency']) continue;
		
			$update_freqency_offset = $feeds[$feed_id]['update_freqency'] * 24 * 60 * 60; //The number of days after the last post
			$date = date('Y-m-d', strtotime($last_update_date) + $update_freqency_offset);
			$next_post[$date][] = $feed_id;
		}
	}
}

function day($year, $month, $day) {
	global $posts, $next_post, $feeds;
	$full_day = "$year-$month-$day";
	
	//Find the number of posts on that day.
	$show_count = 0;
	if(isset($posts[$full_day]))	 $show_count =  count($posts[$full_day]);
	if(isset($next_post[$full_day])) $show_count += count($next_post[$full_day]);
	
	if($show_count) {
		if(isset($posts[$full_day]))
		foreach($posts[$full_day] as $post) {
			print "<a class='calendar-row post feed-$post[feed_id]' id='post-$post[id]' href='$post[url]'>$post[title]</a>\n";
			print "<p class='post-summary' id='summary-$post[id]'>$post[summary]</p>\n";
			print "<br />\n\n";
		}
		
		if(isset($next_post[$full_day]) and isset($_REQUEST['show_prediction']))
		foreach($next_post[$full_day] as $feed_id) {
			print "<span class='prediction feed-$feed_id'>{$feeds[$feed_id]['name']}</span><br />";
		}
	}
}

$template->addResource('calendar.css','css');

if($mode == 'aggregator') render('aggregator.php');
else {
	render();
}
