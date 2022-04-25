<?php
require 'common.php';

$url = 'https://binnyva.com/';
$story_id = 0;

$active_story = iapp('sql')->getAssoc("SELECT id,url FROM sd_story WHERE added_on >= NOW() - INTERVAL 1 DAY");
if($active_story) {
	$url = $active_story['url'];
	$story_id = $active_story['id'];
}

// Tracking
iapp('db')->insert('sd_story_visit', [
	'story_id' => $story_id, 
	'referrer' => i($_SERVER, 'HTTP_REFERER', null),
	'added_on' => 'NOW()'
]);

echo $url . "\n";
header("Location: $url");
