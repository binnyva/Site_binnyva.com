<?php
include('admin_common.php');

$date_format = "%Y-%m-%d";
$search_in = array("Title","_Description");

//Database fields, their names, and types
$item_names	= array("","Title","_Description","_Link", "_Feed","Last edited","_Status");
$item_fields= array("id","name","description","url","feed_url","last_modified","status");
$item_info	= array("","must;link;%GET%<url>","textarea","must;unique;link","must;unique;link","date","status");

$admin_page = new AdminPage("Blogs/Feeds","blogs.php","Feed","",$item_names,$item_fields,$item_info);

renderAdminPage();
