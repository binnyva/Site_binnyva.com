<?php
if(isset($_GET["url"])) {
	$url = $_GET['url'];

	if(strpos($url, 'http') === false) {
		$url = 'https://' . $url;
	}

	$valid = filter_var($url, FILTER_VALIDATE_URL);
	if($valid) {
		file_put_contents('link.txt', $url);
		print "Saving '$url'";
	} else {
		die("Yeah, I don't think '$url' is a valid URL");
	}

} else {
	die("No URL specified.");
}
