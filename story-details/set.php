<?php
require 'common.php';

if(isset($_GET["url"])) {
	$url = $_GET['url'];

	if(strpos($url, 'http') === false) {
		$url = 'https://' . $url;
	}

	$valid = filter_var($url, FILTER_VALIDATE_URL);
	if($valid) {
		$name = i($_GET, 'name', null);
		iapp('db')->insert("sd_story", [
			'url' => $url, 
			'name' => $name, 
			'added_on' => 'NOW()'
		]);
		print "Saving '$url'";
	} else {
		die("Yeah, I don't think '$url' is a valid URL");
	}

} else {
	die("No URL specified.");
}
