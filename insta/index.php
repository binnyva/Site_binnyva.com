<?php
$url = 'https://binnyva.com';
$url_file = 'link.txt';

// URL in the file is only valid if its lesser than one day old.
$url_age = time() - filemtime($url_file);

if($url_age < (60 * 60 * 24)) {
	$input_url = trim(file_get_contents($url_file));

	// Check if URL is valid
	$valid = filter_var($input_url, FILTER_VALIDATE_URL);

	if($valid) $url = $input_url;
}

// echo $url . "\n";
header("Location: $url");
