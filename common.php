<?php
$rel = localfindRelation();
include($rel . '../../iframe/common.php');

$online = 0;
if(isset($_SERVER['HTTP_HOST']) and strpos($_SERVER['HTTP_HOST'],'localhost') === false and strpos($_SERVER['HTTP_HOST'],'127.')===false) $online = 1;
$email_html = '<span class="email-encrypt">moc.liamg@avynnib<span class="email-decrypt-message">(Reverse this text to get my Email address)</span></span>';//Decrypt using CSS.
$page = &$template;

//Find the relation between the page we are in and the root folder.
function localfindRelation() {
	$rel = "";
	$depth = 0;
	while($depth < 10) { //We don't want an infinite loop - do we?
		if(file_exists($rel . "configuration.php")) {
			break;
		} else {
			$rel .= "../";
		}
		$depth++;
	}
	return $rel; 
}

