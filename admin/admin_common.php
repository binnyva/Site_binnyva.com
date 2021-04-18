<?php
require('../common.php');
$url_parts = parse_url($config['PHP_SELF']);
$current_file = basename($url_parts['path']);
if(!$current_file or substr($url_parts['path'],-5) == '/admin/' or substr($url_parts['path'],-4) == '/admin/') $current_file = 'index.php';

// A small hack to make sure the resources in the admin folder are used.
$template->js_folder = 'admin/js';
$template->css_folder = 'admin/css';
$template->options['template_folder'] = 'admin/templates';
$template->_findResources(basename($current_file));

$html = new HTML;
if($current_file != 'index.php') {
	include('admin/Admin.php');
	include('session.php');
}

