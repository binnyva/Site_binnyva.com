<?php
function printTop($title="") {
	printHead($title);
	printBegin();
}

function printHead($title="") {
	global $rel,$abs, $config, $template;
	$title = ($title) ? $title : $config['site_title'];
	include($rel . "includes/layout/head.php");
}
function printBegin() {
	global $rel,$abs, $config;
	include($rel . "includes/layout/begin.php");
	print "<!-- Begin Content -->";
}
function printEnd() {
	global $rel,$abs, $template, $config;
	print "<!-- End Content -->";
	include($rel . "includes/layout/end.php");
}
