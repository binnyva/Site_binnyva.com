<?php
include('admin_common.php');

$date_format = "%Y-%m-%d";
$search_in = array("Title","_Summary");

$all_blogs = $sql->getById("SELECT id,name FROM Feed WHERE status='1'");

//Database fields, their names, and types
$item_names	= array("","Title","_Link", "_GUID","_Summary","_Contents","Created","Blog");
$item_fields= array("id","title","url","guid", 'summary',"contents","published_on","feed_id");
$item_info	= array("","must;link;%GET%<url>","must;unique;link","must;unique;link","textarea","textarea","date","list;%A%all_blogs%A%;");

$admin_page = new AdminPage("Posts","posts.php","Post","",$item_names,$item_fields,$item_info);

renderAdminPage();
