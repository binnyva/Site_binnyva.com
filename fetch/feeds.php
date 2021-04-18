<?php
include('../common.php');
include($config['code_path'] . 'includes/classes/Tagging.php');

$tagging = new Tagging();
$tagging->setReferenceTable("PostTag", "tag_id", "post_id");
$tagging->setTagTable("Tag", 'id', 'name');
$tagging->setItemTable("Post", 'id');
$tagging->checkSetup();

header("Content-type: text/plain");

$feeds = $sql->getAll("SELECT id,feed_url AS url,last_modified FROM Feed");
// $feeds = array(array(
// 	'id'	=>	20,
// 	'url'	=>	'http://localhost/binnyva/aggregator/debug/binblog.xml',
// 	'last_modified'	=> '0000-00-00 00:00:00'
// ));

foreach($feeds as $feed_details) {
	extract($feed_details);
	message("Fetching $url ... ");
	$result = load($url,array(
						'return_info'	=>	true,
						'modified_since'=> $last_modified
					));
	
	$headers = $result['headers'];
	$feed_xml = $result['body'];
	$info = $result['info'];
	
	if(!$feed_xml) {
		message("Cannot continue - Download Failed! Maybe it was not modified since the last fetch.\n\n");
		continue;
	}

	if(isset($headers['Last-Modified'])) $last_modified = date('Y-m-d H:i:s', strtotime($headers['Last-Modified']));
	else $last_modified = date('Y-m-d H:i:s');
	$sql->execQuery("UPDATE Feed SET last_modified='$last_modified' WHERE id=$id");

	message("Done\nPasing Content ... ");
	$feed_data = parseFeed($feed_xml);

	if(!$feed_data) {
		message("Cannot continue - parse error!\n\n");
		continue;
	}

	message(count($feed_data) . " items. Done\nSaving To DB ... ");
	saveFeed($feed_data,$id);
	
	message("Done\n\n");
}

function parseFeed($xml) {
	$arr = xml2array($xml);
	if(!isset($arr['rss'])) return array(); //Not Valid RSS

	$items = $arr['rss']['channel']['item'];
	if(!isset($items[0])) $items = array($items); // Just 1 item in the feed. This is a ugly workaround for that.
	$feed_data = array();
	foreach($items as $post) { //Get all the necessary data into this array.
		$data = array();
		$data['link']		= $post['link'];
		$data['title']		= $post['title'];
		$data['guid']		= ($post['guid']) ? $post['guid'] : $data['link'];
		$data['description']= $post['description'];
		if(isset($post['content:encoded'])) $data['content']	= $post['content:encoded'];
		else $data['content']	= '';
		$data['pubDate']	= $post['pubDate'];

		if(isset($post['category'])) {
			$categories = array();
			foreach($post['category'] as $cats) {
				$categories[] = $cats;
			}
			$data['categories'] = $categories;
		}

		$feed_data[] = $data;
	}
	
	unset($arr,$items);
	return $feed_data;
}

function saveFeed($data,$feed_id) {
	global $sql,$tagging;
	$last_post = count($data) - 1;
	
	$last_time = getMysqlTime($data[$last_post]['pubDate']);
	$guids_of_latest_posts_in_db = $sql->getCol("SELECT guid FROM Post WHERE published_on>='$last_time'");
	
	$data = array_reverse($data);//Invert the array - so that the older ones come on top.
	
	$post_inserts = array();
	foreach($data as $post) {
		if(in_array($post['guid'], $guids_of_latest_posts_in_db)) continue; //The post is already in the DB
		message("Inserting  '$post[title]'");
		
		$sql->execQuery("INSERT INTO Post(title,url,guid,summary,contents,published_on,feed_id) VALUES ('"
			. $sql->escape($post['title']) ."','"
			. $sql->escape($post['link']) ."','"
			. $sql->escape($post['guid']) ."','"
			. $sql->escape($post['description']) ."','"
			. $sql->escape($post['content']) ."','"
			. $sql->escape(getMysqlTime($post['pubDate'])) ."','$feed_id')");

		if(isset($post['categories'])) {
			$tagging->setTags($sql->fetchInsertId(), $post['categories']);
		}
	}
}

function getMysqlTime($time) {
	return date('Y-m-d H:i:s', strtotime($time));
}

function message($text) {
	$verbose = true;
	if($verbose) print $text;
}