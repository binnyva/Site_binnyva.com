<?php
require('admin_common.php');

$all_events = array("OK","Hmm...",'Hey!','Oh No!','What The...','Important','Important','Important','Important',
'Important','Important','Important','Important','Important','Important','Important','Important','Important',
'Important','Important','Important','Important','Important','Important','Important','Important','Important',
'Critical','Critical','Critical','Critical','Critical','Critical');
// Flag actually was 'list;%A%all_events%A%'

//Database fields, their names, and types
$item_names	= array("","Event","Time","Flag","_Ip","Event Status");
$item_fields= array("id","event","time","flagged","ip","status");
$item_info	= array("","","date;time","text","","textarea");

$QUERY['sortasc'] = 'time';
$admin_page = new AdminPage("Event Log","logs.php","Event_Log","",$item_names,$item_fields,$item_info);
$admin_page->is_addable = 0;

$admin_page->content['display_start_text'] = '<a href="?action=delete_all"'
	. ' onclick="return confirm(\'This will delete all the logs. Are you sure?\');">Delete All Logs</a>';
if(isset($QUERY['action']) and  $QUERY['action'] == 'delete_all') {
	$sql->execQuery("DELETE FROM Event_Log WHERE event='Comment Spam'");
}

renderAdminPage();
